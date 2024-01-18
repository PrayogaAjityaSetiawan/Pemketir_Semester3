<!DOCTYPE html>
<html>
<head>
    <title>Tahap Klasifikasi Data Dengan Algoritma Naive Bayes Part 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<h1 style="text-align: center">Tugas 2 Prayoga Ajitya Setiawan 2211500331</h1>
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

$sql = "delete FROM probabilitas_kategori_2211500331";
$result0 = mysqli_query($conn,$sql);

$sql = "SELECT * FROM kategori_2211500331 order by id_kategori";
$result1 =$conn->query($sql);
if ($result1->num_rows == 0) {
    echo "Data Tidak Ditemukan";
}else{
        while ($d = mysqli_fetch_array ($result1)) {
            $id = $d['id_kategori'];

            $sql = "SELECT count(*) as jml FROM preprocessing_2211500331 where id_kategori='$id'";
            $result2 = $conn->query($sql);
            $d = mysqli_fetch_row ($result2);
            $jmlhkategori = $d[0];

            $sql = "SELECT count(*) as jml FROM preprocessing_2211500331";
            $result3 = $conn->query($sql);
            $d = mysqli_fetch_row ($result3);
            $jmlhdokumen = $d[0];

            $nilai=$jmlhkategori/$jmlhdokumen;

            $q = "INSERT INTO probabilitas_kategori_2211500331(id_kategori,jml_data,nilai_probabilitas)
            VALUES('$id','$jmlhkategori', '$nilai')";

            $result4 = mysqli_query($conn,$q);
        }
}

$sql = "SELECT nm_kategori,jml_data,nilai_probabilitas FROM probabilitas_kategori_2211500331 a,kategori_2211500331 b
        where a.id_kategori=b.id_kategori order by 1";
$result4 =$conn->query($sql);
?>

<table class ="table table borderd table table-hover">
<thead>
    <br><br><tr></tr>
<tr>
    <td cosplan="5"><strong>Nilai Probabilitas Pada Setiap Kategori</strong></id>
</tr>
<tr bgcolor="#CCCCCC">
<th>No.</th>
<th>Kategori</th>
<th>Frekuensi Dokumen Per Kategori</th>
<th>Jumlah Seluruh Dokumen</th>
<th>Probabilitas</th>   
</tr>
</thead>
    <?php
        $i=1;
        while($d = mysqli_fetch_array($result4)) {
            ?>
            <tr bgcolor="FFFFFF">
                <td><?php echo $i; ?></td>
                <td><?php echo $d[0] ; ?></td>
                <td><?php echo $d[1] ; ?></td>
                <td><?php echo $jmlhdokumen ; ?></td>
                <td><?php echo $d[2] ; ?></td>
            </tr>
        <?php
            $i=$i+1;
        }
        ?>
</table>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>