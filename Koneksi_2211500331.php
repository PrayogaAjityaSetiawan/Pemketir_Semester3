<!-- Prayoga Ajitya Setiawan 2211500331 -->
<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbName = "db_pemketir_2211500331";
$conn = mysqli_connect($host, $user, $pass);

if(!$conn) {
    die("Koneksi Mysql gagal !!<br>" . mysqli_connect_error());
}
echo "Koneksi Mysql Berhasil !!<br>";
$sql = mysqli_select_db($conn, $dbName);
if (!$sql){
    die ("Koneksi database gagal !!" .mysqli_error($conn));
}
echo "Koneksi Database Berhasil";
?>