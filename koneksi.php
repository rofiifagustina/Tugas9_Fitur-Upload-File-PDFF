<?php
// --- FILE KONEKSI DATABASE ---

// 1. Definisikan parameter koneksi
$db_host = "localhost"; // (Sengaja disalahkan untuk tes)
$db_user = "root";
$db_pass = "";
$db_name = "db_uploadpdf";

// 2. Gunakan try...catch untuk menangani error koneksi
try {
    // Mencoba membuat koneksi
    $koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    // Jika berhasil, kode ini akan jalan
    // echo "Koneksi ke database berhasil!";

} catch (mysqli_sql_exception $e) {
    // Jika gagal, tangkap error (exception) dan hentikan skrip
    die("Koneksi ke database gagal: " . $e->getMessage());
}

// Jika skrip berlanjut ke sini, artinya $koneksi berhasil dibuat.
// ...
?>