<?php
// Koneksi Database
// Menghubungkan aplikasi ke server database MySQL (localhost) dengan user root dan database db_mahasiswa
$koneksi = mysqli_connect("localhost", "root", "", "db_mahasiswa");

/**
 * FUNGSI QUERY
 * Digunakan untuk mengambil data dari database dan mengubahnya menjadi array format PHP
 * agar lebih mudah diolah dan ditampilkan pada halaman index/detail.
 */
function query($query)
{
    // Menggunakan variabel koneksi global agar bisa diakses di dalam fungsi
    global $koneksi;

    $result = mysqli_query($koneksi, $query);

    // Menyiapkan wadah berupa array kosong
    $rows = [];

    // Looping untuk mengambil setiap baris data dan memasukkannya ke dalam array $rows
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

/**
 * FUNGSI TAMBAH (CREATE)
 * Berfungsi untuk menangani input dari form tambah mahasiswa.
 * Menggunakan htmlspecialchars untuk mencegah serangan XSS (Cross Site Scripting).
 */
function tambah($data)
{
    global $koneksi;

    // Sanitasi data input untuk keamanan penyimpanan data
    $nim = htmlspecialchars($data['nim']);
    $nama = htmlspecialchars($data['nama']);
    $kelas = htmlspecialchars($data['kelas']);
    $jurusan = htmlspecialchars($data['jurusan']);
    $semester = htmlspecialchars($data['semester']);

    // Perintah SQL untuk memasukkan data baru ke tabel mahasiswa
    $sql = "INSERT INTO mahasiswa(nim, nama, kelas, jurusan, semester) VALUES ('$nim','$nama','$kelas','$jurusan','$semester')";

    mysqli_query($koneksi, $sql);

    // Mengembalikan angka 1 jika berhasil (ada baris yang berubah)
    return mysqli_affected_rows($koneksi);
}

/**
 * FUNGSI HAPUS (DELETE)
 * Digunakan untuk menghapus data mahasiswa berdasarkan NIM sebagai kunci unik (primary key).
 */
function hapus($nim)
{
    global $koneksi;

    // Perintah SQL untuk menghapus baris data yang sesuai dengan NIM yang dikirim
    mysqli_query($koneksi, "DELETE FROM mahasiswa WHERE nim = $nim");
    
    return mysqli_affected_rows($koneksi);
}

/**
 * FUNGSI UBAH (UPDATE)
 * Digunakan untuk mengedit data mahasiswa yang sudah ada di database.
 * Melakukan update pada semua kolom berdasarkan NIM yang dipilih.
 */
function ubah($data)
{
    global $koneksi;

    // Mengambil data dari form edit dan melakukan sanitasi kembali
    $nim = htmlspecialchars($data['nim']);
    $nama = htmlspecialchars($data['nama']);
    $kelas = htmlspecialchars($data['kelas']);
    $jurusan = htmlspecialchars($data['jurusan']);
    $semester = htmlspecialchars($data['semester']);

    // Menyusun perintah SQL update dengan klausa WHERE agar data yang berubah tidak tertukar
    $sql = "UPDATE mahasiswa SET nama = '$nama', kelas = '$kelas', jurusan = '$jurusan', semester = '$semester' WHERE nim = $nim";

    mysqli_query($koneksi, $sql);

    return mysqli_affected_rows($koneksi);
}
?>
