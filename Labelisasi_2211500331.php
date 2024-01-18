<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tahap Labelisasi Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class = "mx-5">
    <table class= "table table-bordered table-striped">
        <td colspan= "3">
        <button class ="bg-primary border-0 py-2 px-3 text-light rounded-3" onClick= "goBack()">Kembali Ke Form Input Link</button>
            <script>
                function goBack() {
                    window.history.back();
                }
            </script>
        </td>
    </table>
    <br>

    <?php
    include 'Koneksi_2211500331.php';

    $q = "TRUNCATE TABLE kategori_2211500331";
    $result = mysqli_query($conn,$q);

    $q = "insert into kategori_2211500331 (nm_kategori)
    select substr(galert_title,16) from galert_data_2211500331";
    $result1 = mysqli_query($conn,$q);

    $sql = "select galert_id, galert_title,id_kategori,substr(galert_title,16) as kategori_2211500331
    from galert_data_2211500331 a, kategori_2211500331 b
    where substr(galert_title,16)=nm_kategori";
    $result = $conn->query($sql);

    if($result->num_rows == 0) {
        echo "Data Kategori Tidak Ditemukan";
    }else {
        ?>
        <table class = "table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <td colspan = "3"><strong>Daftar Kategori</strong></td>
                </tr>
                <tr class = "text-center" bgcolor = "#cccccc">
                    <th>No</th>
                    <th>Title</th>
                    <th>Kategori</th>
                </tr>
            </thead>
            <?php
            $i = 1;
            while($d = mysqli_fetch_array($result)){
                $id = $d['galert_id'];
                $title = $d['galert_title'];
                $id_kategori = $d['id_kategori'];
                $kategori = $d['kategori_2211500331'];
            ?>

            <tr bgcolor= "#FFFFFF">
                <td><?php echo $i; ?></td>
                <td><?php echo $title; ?></td>
                <td class="text-center"><?php echo $kategori; ?></td>
            </tr>
            <?php

            $sql = "SELECT * FROM galert_entry_2211500331 where feed_id= '$id'";
            $result2 = $conn->query($sql);

            if($result2->num_rows > 0) {
                $q = "UPDATE preprocessing_2211500331 set id_kategori = '$id_kategori'
                where entry_id in(SELECT entry_id FROM galert_entry_2211500331 WHERE feed_id='$id')";

                $result2 = mysqli_query($conn,$q);
            }

        $i=$i+1;

        if($result2){
            echo '<script>alert("Berhasil! Tahap Labelisasi Data Berhasil")</script>';
            // echo '<strong>Berhasil!</strong> Tahap Labelisasi Data Berhasil';
        }else {
            echo '<script>alert("Berhasil! Tahap Labelisasi Data Berhasil")</script>';
            // echo '<strong>Gagal!</strong> Tahap Lbelisasi Data Tidak Berhasil';
        }

    }

}
    ?>
    <br>
    <br>

    <?php
    $i =1;
    $sql = "SELECT a.*,nm_kategori
    FROM preprocessing_2211500331 a, kategori_2211500331 b
    WHERE a.id_kategori= b.id_kategori and length(entry_id)!= 0" ;
    $result = $conn->query($sql);


    if($result->num_rows == 0) {
        echo "Data Tidak Ditemukan";
    }else {
        ?>
        <table class = "table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <td colspan = "3"><strong>Daftar Labelisasi Data</strong></td>
                </tr>
                <tr class ="text-center" bgcolor = "#cccccc">
                    <th>No</th>
                    <th>Data Bersih</th>
                    <th>Nama Kategori</th>
                </tr>
            </thead>
            <?php
            while($d = mysqli_fetch_array($result)){
                $data_bersih = $d['data_bersih'];
                $id_kategori = $d['id_kategori'];
                $nm_kategori = $d['nm_kategori'];
                
            ?>
            <tr bgcolor= "#FFFFFF">
                <td><?php echo $i; ?></td>
                <td><?php echo $data_bersih; ?></td>
                <td class="text-center"><?php echo $nm_kategori; ?></td>
            </tr>
            <?php
        $i=$i+1;    
        }
    }
    ?>
    <br>
    <br>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>