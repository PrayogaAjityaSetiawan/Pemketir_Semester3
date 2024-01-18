<!DOCTYPE html>
<!-- Prayoga Ajitya Setiawan - 2211500331-->
<html>
    <h3><a href = "FormLoadFile_2211500331.php"> Kembali Ke Form Input Link</a></h3>
    <br>
</html>
<head><h1 style=text-align:center>Prayoga Ajitya Setiawan - 2211500331</h1></br></head>

<?php
include 'Koneksi_2211500331.php';
include 'XML2Array_2211500331.php';

$link = $_GET['link'];
$xml = simplexml_load_file($link);
if (!$xml) {
    echo 'load XML failed';
} 
else {
    $array = XML2Array_2211500331($xml);

    $a = 0;
    foreach( $array as $key => $value){
        $id = $array['id'];
        $title = $array['title'];
        $link = $array['link'];
        $update = $array['updated'];

        
        //select ke database
        $sql = "SELECT * FROM galert_data_2211500331 where galert_id='$id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "";
        } 
        else {
            // simpan data ke tabel galert data
            $q = "INSERT INTO galert_data_2211500331(galert_id, galert_title, galert_link, galert_update)
                VALUES('$id','$title','$link','$update')";
            $result = mysqli_query($conn,$q);
            foreach( $xml as $record)
            {
                $id2 = $record->id;
                $title = $record->title;
                $link = $record->link;
                $published = $record->published;
                $update = $record->update;
                $content = $record->content;
                $author = $record->author;

                $sql = "SELECT * FROM galert_entry_2211500331 where entry_id = '$id2'";
                $result = $conn->query($sql);

                if ($result->num_rows >0 ) {
                    // Data sudah ada, jadi jangan lakukan apa pun
                } 
                else {
                    // Data tidak ada, jadi masukkan ke database
                    $masuk = "INSERT INTO galert_entry_2211500331(entry_id,entry_title,entry_link,entry_published,entry_updated,entry_content,entry_author,feed_id)
                            VALUES ('$id2','$title','$link','$published','$update','$content','$author','$id')";
            
                    $result = mysqli_query($conn,$masuk);
                
                }
            }
        }
    }

}

if ($result) {
    echo '<h4>Penyimpanan Data Berhasil </h4>';
} else {
    echo '<h2>Gagal Melakukan Penyimpanan Data</h2>';
}
?>

<html>
    <head>
        <meta http-equiv="Content-Type"content="text/html; charset=utf-8" />
        <style>
            body
                {
                    font-family: Verdana, Geneva, sans-serif;
                }
        </style>
    </head>
    <body>
<table cellpadding="1" cellspacing="1" bgcolor="+999999">
    <tr bgcolor="#CCCCCC">
        <th>No</th>
        <th>ID</th>
        <th>Title</th>
        <th>Link</th>
        <th>Publisher</th>
        <th>Update</th>
        <th>Content</th>
        <th>Author</th>
    </tr>
    <?php
    $nomor=1;
    foreach ($xml as $r) {
    ?>
    <tr bgcolor="FFFFFF">
        <td><?php echo $nomor++;?></td>
        <td><?php echo $r->id ;?></td>
        <td><?php echo $r->title ;?></td>
        <td><?php echo $r->link ;?></td>
        <td><?php echo $r->published ;?></td>
        <td><?php echo $r->update ;?></td>
        <td><?php echo $r->content ;?></td>
        <td><?php echo $r->author;?></td>



    </tr>
    <?php
            }
    ?>
</table><br />
</body>
</html>
