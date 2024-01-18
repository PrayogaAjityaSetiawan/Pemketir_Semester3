<!DOCTYPE html>
<html>
<head>
    <title>Tahap Klasifikasi Data Dengan Algoritma Naive Bayes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<table class="table table-bordered table-striped">
    <td colspan="3">
    <button class="bg-primary border-0 py-2 px-3 text-light rounded-3" onclick="goBack()">Kembali Ke Form Input Link</button>
    <script>
        function goBack(){
            window.history.back();
        }
    </script>
    </td>
</table>
<br>

<?php
require_once "Koneksi_2211500331.php";

$sql = "SELECT * FROM probabilitas_kata_2211500331 WHERE id_kategori IS NOT NULL ORDER BY id_kategori";
$result1 = $conn->query($sql);
if ($result1->num_rows == 0) {
    echo "Data Tidak Ditemukan";
} else {
    while ($d = mysqli_fetch_array($result1)) {
        $kata = $d['kata'];
        $id = $d['id_kategori'];

        $sql = "SELECT SUM(jml_data) AS NK FROM probabilitas_kata_2211500331 WHERE kata='$kata' AND id_kategori='$id'";
        $rNK1 = mysqli_query($conn, $sql);
        $rNK2 = mysqli_fetch_row($rNK1);
        $NK = $rNK2[0];
        
        $N = "SELECT SUM(jml_data) AS N FROM probabilitas_kata_2211500331 WHERE id_kategori='$id'";
        $rN1 = mysqli_query($conn, $N);
        $rN2 = mysqli_fetch_row($rN1);
        $N = $rN2[0];
        
        $kosakata = "SELECT COUNT(DISTINCT kata) AS KOSAKATA FROM probabilitas_kata_2211500331";
        $rkosakata1 = mysqli_query($conn, $kosakata);
        $rkosakata2 = mysqli_fetch_row($rkosakata1);
        $kosakata = $rkosakata2[0];
        
        $NilaiProbabilitas = ($NK+1) / ($N + $kosakata);

        $q = "UPDATE probabilitas_kata_2211500331 SET nilai_probabilitas='$NilaiProbabilitas' WHERE kata='$kata' AND id_kategori='$id'";
        $result5 = mysqli_query($conn, $q);
    }
}

$data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT SUM(jml_data) AS total FROM probabilitas_kategori_2211500331"));
$SD = $data['total'];

$sql = "SELECT kata, id_kategori, jml_data, nilai_probabilitas FROM probabilitas_kata_2211500331 ORDER BY nilai_probabilitas";
$result2 = $conn->query($sql);
?>

<table class="table table-bordered table-striped table-hover">
<thead>
    <br></br>
    <tr></tr>
<tr>
    <h1 style="text-align:center">Prayoga Ajitya Setiawan 2211500331</h1>
    <td colspan = "5"><strong>Vocabulary Kata Pada Setiap Dokumen Data Training</strong></td>
</tr>
<tr bgcolor="#52D3D8">
<th>No.</th>
<th>Kata</th>
<th>Kategori</th>
<th>Jumlah Data Dari</th>
<th>Nilai Probabilitas</th>
</tr>
</thead>
    <?php

        $i=1;
        while($d = mysqli_fetch_array($result2))
        {
        ?>
            <tr bgcolor="#FFFFFF">
                <td><?php echo $i; ?></td>
                <td><?php echo $d[0]; ?></td>
                <td><?php echo $d[1]; ?></td>
                <td><?php echo $d['jml_data']; ?></td>
                <td><?php echo $d['nilai_probabilitas']; ?></td>
        </tr>
    <?php
    $i=$i+1;
        }
    ?>
</table>