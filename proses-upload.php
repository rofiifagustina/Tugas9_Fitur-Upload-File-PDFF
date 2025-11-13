<?php
require_once 'koneksi.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Cek apakah file benar-benar ada dan tidak ada error
    if (isset($_FILES['file_pdf']) && $_FILES['file_pdf']['error'] === UPLOAD_ERR_OK) {

        // --- Proses Validasi ---
        $file_tmp_path = $_FILES['file_pdf']['tmp_name'];
        $file_name = $_FILES['file_pdf']['name'];
        $file_size = $_FILES['file_pdf']['size'];
        $file_name_parts = explode('.', $file_name);
        $file_ext = strtolower(end($file_name_parts));

        $allowed_exts = ['pdf'];
        
        // 1. Validasi Tipe File
        if (in_array($file_ext, $allowed_exts)) {
            
            // 2. Validasi Ukuran File (misal: maks 2MB)
            // 1MB = 1048576 bytes
            if ($file_size < 10485760) {
                
                // --- Proses Pemindahan File ---
                $upload_dir = 'rofiif/';
                // Membuat nama file baru yang unik untuk menghindari penimpaan file
                $new_file_name = 'rofiif_'.time() . '-' . $file_name;
                $dest_path = $upload_dir . $new_file_name;

                // Memindahkan file dari lokasi sementara ke lokasi tujuan
                if (move_uploaded_file($file_tmp_path, $dest_path)) {
                    //Untuk menyimpan kedatabase
                    $path = mysqli_real_escape_string($koneksi,$dest_path);
                    $name = mysqli_real_escape_string($koneksi,$new_file_name);

                    $query ="INSERT INTO dokumen (path_file,nama_file) VALUES ('$path','$name')";
                    if(mysqli_query($koneksi,$query)){
                    echo "<h1>Upload Berhasil!</h1>";
                    echo '<p>File <a href="' . htmlspecialchars($dest_path) . '" target="_blank">' . htmlspecialchars($new_file_name) . '</a> telah berhasil diunggah.</p>';

                    }else{
                        echo "<p>Kesalahan saat menyimpan ke database: " . mysqli_error($koneksi) . "</p>";
                        
                    }
                   
                } else {
                    echo "<h1>Upload Gagal!</h1>";
                    echo "<p>Terjadi kesalahan saat memindahkan file.</p>";
                }

            } else {
                echo "<h1>Upload Gagal!</h1>";
                echo "<p>Ukuran file terlalu besar. Maksimal 10MB.</p>";
            }

        } else {
            echo "<h1>Upload Gagal!</h1>";
            echo "<p>Tipe file tidak diizinkan. Hanya PDF SAJA.</p>";
        }

    } else {
        echo "<h1>Error!</h1>";
        echo "<p>Tidak ada file yang dipilih atau terjadi error saat upload.</p>";
    }
}
?>