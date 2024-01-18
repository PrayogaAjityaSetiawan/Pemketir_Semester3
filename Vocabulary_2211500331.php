<!DOCTYPE html>
<html>
<head>
    <title>Tahap Klasifikasi Data Dengan Algoritma Naive Bayes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
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

$sql = "delete FROM probabilitas_kata_2211500331";
$result0 = mysqli_query($conn,$sql);

$sql = "SELECT * FROM Preprocessing_2211500331 where id_kategori is not null order by entry_id";
$result1 = $conn->query($sql);
if ($result1->num_rows == 0){
    echo "Data Tidak Ditemukan";
}else{
    while($d = mysqli_fetch_array($result1)){
        $data = $d['data_bersih'];
        $id_kategori = $d['id_kategori'];

        $data_array = explode(" ",$data);
        $str_data = array();
        foreach($data_array as $value){
            $str_data[] = "".$value;
            $kata = $value;

            $sql = "SELECT * FROM kategori_2211500331";
            $result2 = $conn->query($sql);

            if ($result2 != false && $result2->num_rows == 0){
                echo "Data Tidak Ditemukan";
            }else{
                while($d = mysqli_fetch_array($result2)){
                    $id = $d[0];
                    $nm = $d[1];

                    $sql = "SELECT * FROM probabilitas_kata_2211500331 where kata='$kata' and id_kategori='$id'";
                    $result3 = $conn->query($sql);

                    if ($result3 != false && $result3->num_rows == 0){
                        $q = "INSERT INTO probabilitas_kata_2211500331(kata,id_kategori)
                        VALUES('$kata','$id')";

                        $result3 = mysqli_query($conn,$q);
                    }
                }
            $q = "update Probabilitas_Kata_2211500331 set jml_data = nvl(jml_data,0)+1 where kata = '$kata' and id_kategori = '$id_kategori'";
            $result4 = mysqli_query($conn,$q);
            }

        }
    }
}

$sql = "SELECT kata,nm_kategori FROM probabilitas_kata_2211500331 a,kategori_2211500331 b
where a.id_kategori=b.id_kategori order by kata";

$result4 = $conn->query($sql);
?>

<table class="table table-bordered table-striped table-hover">
<thead>
    <br></br>
    <tr></tr>
<tr>
    <td colspan = "5"><strong>Vocabulary Pada Setiap Dokumen Data Training</strong></td>
</tr>
<tr bgcolor="#CCCCCC">
<th>No.</th>
<th>Kata</th>
<th>Kategori</th>
</tr>
</thead>
    <?php

        $i=1;
        while($d = mysqli_fetch_array($result4))
        {
        ?>
            <tr bgcolor="#FFFFFF">
                <td><?php echo $i; ?></td>
                <td><?php echo $d[0]; ?></td>
                <td><?php echo $d[1]; ?></td>
        </tr>
    <?php
    $i=$i+1;
        }
    ?>
</table>