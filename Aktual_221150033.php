<!DOCTYPE html>
<html>
<head>
    <title>Tahap Menentukan Kategori Aktual dari Data Uji</title>
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
require_once "Koneksi_2211500331.php";

if(isset($_POST['submit'])) {
    $dataActual = $_POST['kategori'];
    $idPredicted = $_POST['id_actual'];
    
    foreach($idPredicted as $key => $id) {
        $actual = mysqli_real_escape_string($conn, $dataActual[$key]);
        $id = mysqli_real_escape_string($conn, $id);

        $updateQuery = "UPDATE classify_2211500331 SET id_actual = '$actual' WHERE id_predicted = '$id'";
        mysqli_query($conn, $updateQuery);
    }
}

$kategori_result = mysqli_query($conn, "SELECT * FROM kategori_2211500331;");
$prediction_result = mysqli_query($conn, "SELECT a.data_bersih, b.nm_kategori, a.id_predicted, a.id_actual FROM classify_2211500331 a LEFT JOIN kategori_2211500331 b ON a.id_predicted = b.id_kategori;");

?>
<form method="POST" action="">
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <td style="text-align:center" colspan="4"><strong>Menentukan Kategori Aktual Dari Data Uji</strong></td>
            </tr>
            <tr bgcolor="#CCCCCC">
                <th>No.</th>
                <th>Data Bersih</th>
                <th>Prediksi Kategori</th>
                <th>Aktual Kategori</th>
            </tr>
        </thead>
        <?php
        $i = 1;
        while($d = mysqli_fetch_array($prediction_result)) {
            ?>
            <tr bgcolor="#FFFFFF">
                <td><?php echo $i; ?></td>
                <td><?php echo $d[0]; ?></td>
                <td><?php echo $d[1]; ?></td>
                <td>
                    <input type="hidden" name="id_actual[]" value="<?php echo $d[2]; ?>">
                    <select name="kategori[]">
                        <option value="">Pilih Kategori</option>
                        <?php
                        mysqli_data_seek($kategori_result, 0);
                        while ($kategori = mysqli_fetch_assoc($kategori_result)) {
                            $selected = ($kategori['id_kategori'] == $d[3]) ? 'selected' : '';
                            echo '<option  value="' . $kategori['id_kategori'] . '" ' . $selected . '>' . $kategori['nm_kategori'] . '</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <?php
            $i++;
        }
        ?>
        <tr>
            <td colspan="4">
                <br><input class="bg-primary border-0 py-2 px-3 text-light rounded-3" type="submit" name="submit" value="Simpan Data"><br><br>
            </td>
        </tr>
    </table>
</form>

</body>
</html>