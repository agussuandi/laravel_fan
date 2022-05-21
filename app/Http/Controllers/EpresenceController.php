<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use DB;

use App\Models\Epresence\TrxEpresence;

class EpresenceController extends Controller
{
    public function index()
    {
        try
        {
            $trxEpresence = TrxEpresence::from('trx_epresence as a')->selectRaw("a.users_id, DATE(a.waktu) as tanggal, TIME(a.waktu) as waktu_masuk,
                    case
                        when a.is_approve = 'TRUE' then 'APPROVE'
                        when a.is_approve = 'FALSE' then 'REJECT'
                        else 'WAITING'
                    end as status_masuk,
                    (select TIME(waktu) from trx_epresence where users_id = a.users_id and DATE(waktu) = DATE(a.waktu) and type = 'OUT') as waktu_keluar,
                    case
                        when (select is_approve from trx_epresence where users_id = a.users_id and DATE(waktu) = DATE(a.waktu) and type = 'OUT') = 'TRUE' then 'APPROVE'
                        when a.is_approve = 'FALSE' then 'REJECT'
                        else 'WAITING'
                    end as status_keluar
                ")
                ->where('type', 'IN')
            ->get();

            return response()->json([
                'message' => "Success get data",
                "data"    => $trxEpresence
            ]);
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function absenIn()
    {
        try
        {
            $alreadyIn = TrxEpresence::select('users_id')->alreadyIn(auth()->user()->id)->first();
            if ($alreadyIn)
            {
                return response()->json([
                    'message' => "You Already Absen In",
                ]);
            }

            DB::beginTransaction();
            $trxEpresence             = new TrxEpresence;
            $trxEpresence->users_id   = auth()->user()->id;
            $trxEpresence->waktu      = date('Y-m-d H:i:s');
            $trxEpresence->type       = 'IN';
            $trxEpresence->is_approve = 'FALSE';
            $trxEpresence->save();
            DB::commit();

            return response()->json([
                'message' => "Success Absen In",
            ]);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'message' => "Error When Absen In",
            ]);
        }
    }

    public function absenOut()
    {
        try
        {
            $alreadyOut = TrxEpresence::select('users_id')->alreadyOut(auth()->user()->id)->first();
            if ($alreadyOut)
            {
                return response()->json([
                    'message' => "You Already Absen Out",
                ]);
            }

            DB::beginTransaction();
            $trxEpresence             = new TrxEpresence;
            $trxEpresence->users_id   = auth()->user()->id;
            $trxEpresence->waktu      = date('Y-m-d H:i:s');
            $trxEpresence->type       = 'OUT';
            $trxEpresence->is_approve = 'FALSE';
            $trxEpresence->save();
            DB::commit();

            return response()->json([
                'message' => "Success Absen Out",
            ]);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'message' => "Error When Absen Out",
            ]);
        }
    }

    public function approvalAbsen($id)
    {
        try
        {
            $trxEpresence = TrxEpresence::find($id);
            if (!$trxEpresence)
            {
                return response()->json([
                    'message' => "Data Not Found",
                ]);
            }

            DB::beginTransaction();
            $trxEpresence->is_approve = 'TRUE';
            $trxEpresence->save();
            DB::commit();

            return response()->json([
                'message' => "Success Approval Absen",
            ]);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'message' => "Error When Approval Absen",
            ]);
        }
    }
}