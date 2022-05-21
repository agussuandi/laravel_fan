// SOAL 2
// const string = 'Saat meng*ecat tembok, Agung dib_antu oleh Raihan.';
// const string = 'Berapa u(mur minimal[ untuk !mengurus ktp?';
const string = 'Masing-masing anak mendap(atkan uang jajan ya=ng be&rbeda.';
const array = string.split(" ");

const result = []
array.forEach((val) => {
    if (!/[~`!#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/g.test(val)) {
        result.push(val);
    }
})

console.log(result.length)