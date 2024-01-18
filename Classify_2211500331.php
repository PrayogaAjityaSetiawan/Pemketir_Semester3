<!DOCTYPE html>
<html>
<head>
    <title>Tahap Menentukan Kategori Prediksi dari Data Uji</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<table class="table table-bordered table-striped">
    <td colspan="3">
    <button class="bg-primary border-0 py-2 px-3 text-light rounded-3"  onclick="goBack()">Kembali Ke Form Input Link</button>
    <script>
        function goBack(){
            window.history.back();
        }
    </script>
    </td>
</table>
<br>

<?php
require_once 'Koneksi_2211500331.php';
?>
<h2 style="text-align:center">Data Uji</h2>
<?php
require_once 'fungsi_2211500331.php';

// $result = mysqli_query($conn,"DELETE FROM classify_");
$result0 = mysqli_query($conn,"UPDATE classify_2211500331 SET id_predicted = NULL");
$result1 = $conn->query("SELECT * FROM preprocessing_2211500331 WHERE id_kategori IS NULL");
if ($result1->num_rows == 0){
    echo "Data Tidak Ditemukan";
}else{
    while($d = mysqli_fetch_array($result1)){
        $data = $d['data_bersih'];

        echo "<br>";
        echo "Data Uji ==> ", $data;

        $data_array = explode(" ", $data);
        $str_data = array();
        foreach($data_array AS $value){
            $str_data[] = "".$value;
            $kata = $value;

            $result2 = $conn->query("SELECT * FROM probabilitas_kata_2211500331 WHERE kata = '$kata'");

            if ($result2->num_rows > 0){
                while($d = mysqli_fetch_array($result2)){
                    $id = $d[1];
                    $jml = $d[2];
                    $nilai = $d[3];

                    // TMP Nilai probabilitas per kategori
                    $tmp_nilai = (getTMPNilai($conn,$id));
                    if ($tmp_nilai <= 0 ){
                        $tmp_nilai = 1;
                    }
                    (float)$totnilai = (float)($tmp_nilai*$nilai);

                    $result3 = $conn->query("SELECT * FROM probabilitas_kategori_2211500331 WHERE id_kategori = '$id'");
                    if ($result3->num_rows > 0){
                        $result3 = mysqli_query($conn,"UPDATE probabilitas_kategori_2211500331 SET tmp_nilai = $totnilai WHERE id_kategori = '$id'");
                    }
                }
            }
        }

        $nilaitertinggi = getNilTertinggi($conn);
        $id_kategori = 0;
        if ($nilaitertinggi != 0){
            $id_kategori = getKatTerpilih($conn);
        }

        if ($id_kategori == 0){
            echo " ==> Kategori Tidak Ditemukan";
        }else{
            echo " ==> Kategori Tertinggi : ".getNmKategori($conn,$id_kategori)." (",$nilaitertinggi." )";
        }
        $result4 = mysqli_query($conn,"SELECT * FROM classify_2211500331 WHERE data_bersih='$data'");

        if ($result4->num_rows > 0){
            $result4 = mysqli_query($conn,"UPDATE classify_2211500331 SET id_predicted = '$id_kategori' WHERE data_bersih = '$data'");
        } else {
            $result4 = mysqli_query($conn,"INSERT INTO classify_2211500331(data_bersih,id_predicted) VALUES('$data','$id_kategori')");
        }
        
        $result3 = mysqli_query($conn,"UPDATE probabilitas_kategori_2211500331 SET tmp_nilai=0");
    }
}

$result5 = mysqli_query($conn,"SELECT a.data_bersih,b.nm_kategori,a.id_actual FROM classify_2211500331 a 
LEFT JOIN kategori_2211500331 b ON a.id_predicted = b.id_kategori;");
?>

<div class="container-fluid">

<table class="table table-bordered table-striped table-hover">
<thead>
    <br></br>
    <tr></tr>
<tr>
    <td style="text-align:center" colspan = "5"><strong>Tahap Menentukan Kategori Prediksi dari Data Uji</strong></td>
</tr>
<tr bgcolor="#CCCCCC">
<th>No.</th>
<th>Data Bersih</th>
<th>Prediksi Kategori</th>
<th>Aktual Kategori</th>
<th></th>
</tr>
</thead>
    <?php

        $i=1;
        while($d = mysqli_fetch_array($result5))
        {
        ?>
            <tr bgcolor="#FFFFFF">
                <td><?php echo $i; ?></td>
                <td><?php echo $d[0]; ?></td>
                <td><?php echo $d[1]; ?></td>
                <td><?php echo $d[2]; ?></td>
    <?php
    $i = $i + 1;
}
?>
</table>
</div>