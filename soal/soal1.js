// SOAL 1
// const arry = [5, 7, 7, 9, 10, 4, 5, 10, 6, 5];
// const arry = [10, 20, 20, 10, 10, 30, 50, 10, 20];
// const arry = [6, 5, 3, 3, 5, 2, 2, 1, 1, 5, 1, 3, 3, 3, 5];
const arry = [1, 1, 3, 1, 2, 1, 3, 3, 3, 3];

const counts = {};
let akhir = 0;
arry.forEach(function (x) {
    counts[x] = (counts[x] || 0) + 1;
});
let uniqueChars = [...new Set(arry)];

for (let i = 0; i < uniqueChars.length; i++) {
    if (counts[uniqueChars[i]] % 2 == 0) {
        akhir += counts[uniqueChars[i]] / 2;
    } else {
        akhir += (counts[uniqueChars[i]] - 1) / 2;
    }
}

console.log(akhir);