//Setiap Link Pindah Halaman Wajib Menggunakan ID linkpage dan Attribute data-halaman
// Contoh : <a href="javascript:void(0)" data-halaman="home.html" class="linkpage"></a>

var url_folder_api = "http://localhost/bina-Koperasi/Bina-Koperasi/";
var halama_utama = "home.html";

var halaman_saatini = "";
var dir_halaman = "pages/";
var selector_loadHalaman = $("main");

if (localStorage.getItem("halaman_tersimpan")) {
  halaman_saatini = localStorage.getItem("halaman_tersimpan");
  load_halaman(halaman_saatini);
} else {
  halaman_saatini = halama_utama;
  localStorage.setItem("halaman_tersimpan", halaman_saatini);
  load_halaman(halaman_saatini);
}
$(".linkpage").on("click", function () {
  halaman_saatini = $(this).attr("data-halaman");
  localStorage.setItem("halaman_tersimpan", halaman_saatini);
  load_halaman(halaman_saatini);
});
function load_halaman(halaman_apa) {
  $(selector_loadHalaman).hide();
  $(selector_loadHalaman).load(dir_halaman + halaman_apa);
  $(selector_loadHalaman).fadeIn(300);
}
