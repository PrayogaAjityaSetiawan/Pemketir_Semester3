<?php
// nama kategori
function getNmKategori($conn,$kat){
    $d = mysqli_fetch_row($conn->query("SELECT nm_kategori FROM kategori_2211500331 WHERE id_kategori='$kat'"));
    $nm_kategori = $d[0];
    return $nm_kategori;
}

// TMP Nilai probabilitas per kategori
function getTMPNilai($conn,$id){
    $d = mysqli_fetch_row($conn->query("SELECT tmp_nilai FROM probabilitas_kategori_2211500331 WHERE id_kategori='$id'"));
    $tmp_nilai = $d[0];
    return $tmp_nilai;
}

// kategori dengan nilai tertingggi/maksimal
function getNilTertinggi($conn){
    $d = mysqli_fetch_row($conn->query("SELECT MAX(nilai_probabilitas*tmp_nilai) FROM probabilitas_kategori_2211500331"));
    $nilaitertinggi = $d[0];
    return $nilaitertinggi;
}

// kategori terpilih
function getKatTerpilih($conn){
    $d = mysqli_fetch_row($conn->query("SELECT * FROM probabilitas_kategori_2211500331 WHERE (nilai_probabilitas*tmp_nilai) = (SELECT MAX(nilai_probabilitas*tmp_nilai) FROM probabilitas_kategori_2211500331)"));
    $id = $d[0];
    return $id;
}
?>
