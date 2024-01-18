<!-- Prayoga Ajitya Setiawan 2211500331 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
<h1 style="text-align: center">Prayoga Ajitya Setiawan 2211500331</h1>
<h3><a href="FormLoadFile_2211500331.php"> Kembali Ke Form Input Link</a></h3>
</html>
<?php 
include 'Koneksi_2211500331.php';
include "stopword_2211500331.php";

require_once __DIR__ . '/sastrawi/vendor/autoload.php';

$stemmerFactory = new Sastrawi\Stemmer\StemmerFactory();
$stemmer = $stemmerFactory->createStemmer();

echo "<br>";

$sql = "SELECT kata_tbaku,concat(kata_baku,' '),kata_baku from slangword_2211500331";
$stmt = $conn->prepare($sql);
$stmt->execute();
$resultSet = $stmt->get_result();
$result = $resultSet->fetch_all();
$arr_slang=array();
foreach($result as $k=>$v){
    $arr_slang[$v[0]] = $v[1];
}

$sql = "SELECT * From galert_entry_2211500331 where length(entry_id)!=0";
$result = $conn->query($sql);
if ($result->num_rows == 0){
    echo "Data Tidak Ditemukan";
}
else{
    ?>
    <table border = "1" cellpadding = "1" cellspacing="1" bgcolor ="#999999">
    <tr bgcolor = "#CCCCCC">
    <th>ID</th>
    <th>Content</th>
    <th>Case Folding</th>
    <th>Hapus Simbol</th>
    <th>Filter Slang Word</th>
    <th>Filter Stop Word</th>
    <th>Stiming</th>
    <th>Tokenisasi</th>
</tr>
<?php
while($d = mysqli_fetch_array($result)){
    $id = $d['entry_id'];
    $content = $d['entry_content'];

    //1. Case Folding
        //echo strtoupper($content);
        //echo strtoupper($content);
        $cf = strtolower($content);

    //2 Penghapus Simbol-simbol (Symbol Removal)
        $simbol = preg_replace("/[^a-zA-Z\\s]/", "", $cf);

    //3 Konversi Slangword
        $rem_slang = explode(" ",$simbol);
        $slangword=str_replace(array_keys($arr_slang), $arr_slang, $simbol);
    //4 Stopword Removal
        $rem_stopword=explode(" ", $slangword);
        $str_data=array();
        foreach($rem_stopword as $value){
            if(!in_array($value, $stopword_2211500331 )){
                $str_data[] = "".$value;
            }
        }
        $stopword = implode(" ", $str_data);

    //5 Stemming
        $query1 = implode('', (array)$stopword);
        $stemming = $stemmer->stem($query1);
    
    //6 Tokenisasi
        $tokenisasi_2211500331 = preg_split("/[\s,..:]+/", $stemming);
        $tokenisasi_2211500331 = implode(",", $tokenisasi_2211500331);
    ?>
        <tr bgcolor="#FFFFFF">
            <td><?php echo $id; ?></td>
            <td><?php echo $content; ?></td>
            <td><?php echo $cf; ?></td>
            <td><?php echo $simbol; ?></td>
            <td><?php echo $slangword; ?></td>
            <td><?php echo $stopword; ?></td>
            <td><?php echo $stemming; ?></td>
            <td><?php echo $tokenisasi_2211500331; ?></td>
        </tr>
    <?php
        $sql = "SELECT * From preprocessing_2211500331 where entry_id='$id'";
        $result1 = $conn->query($sql);

        if ($result1->num_rows == 0){
            //save to database
            $q = "INSERT INTO preprocessing_2211500331(entry_id,p_cf,p_simbol,p_sword,p_stopword,p_stemming,p_tokenisasi,data_bersih)
            VALUES('$id','$cf','$simbol','$slangword', '$stopword','$stemming','$tokenisasi_2211500331', '$stemming')";

            $result1 = mysqli_query($conn,$q);
        
            
        }
        else{
                    $q = "UPDATE preprocessing_2211500331 set p_cf='$cf', p_simbol='$simbol', p_tokenisasi='$tokenisasi_2211500331', p_sword = '$slangword', p_stopword='$stopword', p_stemming='$stemming', data_bersih='$stemming' WHERE entry_id = '$id'";

                $result1 = mysqli_query($conn,$q);
        }
    }
?>
    </table>
<?php
    if($result1){
        echo '<h4>Preprocessing Data Berhasil</h4>';
    }
    else{
        echo '<h2>Gagal Melakukan Preprocessing Data</h2>';
    }
    }
?>