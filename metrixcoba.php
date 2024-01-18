<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<button class="bg-primary border-0 py-2 px-3 text-light rounded-3"  onclick="goBack()">Kembali Ke Form Input Link</button>
    <script>
        function goBack(){
            window.history.back();
        }
    </script>
    <?php

    require_once "Koneksi_2211500331.php";


// Ambil nama kategori dari database
$sql = "SELECT id_kategori, nm_kategori FROM kategori_2211500331";
$result = $conn->query($sql);
$categoryNames = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $categoryNames[$row['id_kategori']] = $row['nm_kategori'];
    }
} else {
    echo "Data tidak ditemukan";
}

// Mengambil data aktual dan prediksi dari database
$sql = "SELECT id_actual, id_predicted FROM classify_2211500331";
$result = $conn->query($sql);

// Inisialisasi confusion matrix
$confusionMatrix = array_fill_keys(array_keys($categoryNames), array_fill_keys(array_keys($categoryNames), 0));
$total = 0;
$correct = 0;

if ($result->num_rows > 0) {
    // Mengambil data dari setiap baris hasil query
    while($row = $result->fetch_assoc()) {
        $total++;
        if (isset($confusionMatrix[$row['id_actual']][$row['id_predicted']])) {
            $confusionMatrix[$row['id_actual']][$row['id_predicted']]++;
            if ($row['id_actual'] == $row['id_predicted']) {
                $correct++;
            }
        }
    }
} else {
    echo "Data Tidak ditemukan";
}

// Menutup koneksi ke database
$conn->close();

// Hitung akurasi, presisi, dan recall
// Akurasi adalah jumlah prediksi yang benar dibagi dengan total prediksi
$accuracy = $correct / $total * 100;
$precision = array();
$recall = array();
$tp = array();
$fp = array();
$total_tp = 0;
$total_fp = 0;
$total_fn = 0;
foreach ($categoryNames as $i => $name) {
    // True Positive untuk kategori ini
    $tp[$i] = $confusionMatrix[$i][$i];
    // False Positive untuk kategori ini
    $fp[$i] = array_sum($confusionMatrix[$i]) - $tp[$i];
    // False Negative untuk kategori ini
    $fn[$i] = array_sum(array_column($confusionMatrix, $i)) - $tp[$i];
    // Precision untuk kategori ini
    $precision[$i] = ($tp[$i] + $fp[$i]) > 0 ? $tp[$i] / ($tp[$i] + $fp[$i]) : 0;
    // Recall untuk kategori ini
    $recall[$i] = ($tp[$i] + $fn[$i]) > 0 ? $tp[$i] / ($tp[$i] + $fn[$i]) : 0;
    // Menambahkan True Positive untuk semua kategori
    $total_tp += $tp[$i];
    // Menambahkan False Positive untuk semua kategori
    $total_fp += $fp[$i];
    // Menambahkan False Negative untuk semua kategori
    $total_fn += $fn[$i];
}

// Untuk Menghitung All precision dan All recall
// All Precision adalah rata-rata presisi untuk semua kategori
$all_precision = array_sum($precision) / count($precision) * 100;
// All Recall adalah rata-rata recall untuk semua kategori
$all_recall = array_sum($recall) / count($recall) * 100;
?>

<!-- Tampilkan confusion matrix, TP, FP, akurasi, presisi, dan recall dalam bentuk tabel HTML -->
<div class= container>
<!-- Table Untuk Menampilkan Hasil All Precision -->
<table class="table table-bordered table-striped table-hover">
<thead>
    <br></br>
    <tr></tr>
<tr>
    <td style="text-align:center" colspan = "5"><strong>Menghitung All Precision dan All Recall</strong></td>
</tr>
<tr class="bg-primary text-light">
<th>Nilai Akurasi yang didapat</th>
</tr>
</thead>
        <tr bgcolor="#FFFFFF">
            <td><?php echo 'Nilai Akurasi yang didapaat  => ',"($correct / $total) * 100 = ", $accuracy, "%";  ?></td>
</table><br>

<!-- Table Untuk Menampilkan Hasil Precision  -->
<table class="table table-bordered table-striped table-hover">
<thead>
    <br></br>
    <tr></tr>
<tr>
    <td style="text-align:center" colspan = "5"><strong>Menghitung Precision</strong></td>
</tr>
<tr class="bg-primary text-light">
<th>No.</th>
<th>Kategori</th>
<th>True Positive</th>
<th>False Positif</th>
<th>Precision (TP / (TP + FP))</th>
</tr>
</thead>
    <?php

        $no=1;
        foreach($categoryNames as $i => $name)
        {
        ?>
            <tr bgcolor="#FFFFFF">
                <td><?php echo $no; ?></td>
                <td><?php echo $name; ?></td>
                <td><?php echo $tp[$i]; ?></td>
                <td><?php echo $fp[$i]; ?></td>
                <td><?php echo "$tp[$i] / ($tp[$i] + $fp[$i]) = $precision[$i]"?></td>
    <?php
    $no = $no + 1;
}
    ?>
</table><br>

<!-- Table untuk menampilkan hasil Recall -->
<table class="table table-bordered table-striped table-hover">
<thead>
    <br></br>
    <tr></tr>
<tr>
    <td style="text-align:center" colspan = "5"><strong>Menghitung Recall</strong></td>
</tr>
<tr class="bg-primary text-light">
<th>No.</th>
<th>Kategori</th>
<th>True Positive</th>
<th>False Positif</th>
<th>Recall (TP / (TP + FN))</th>
</tr>
</thead>
    <?php

        $no=1;
        foreach($categoryNames as $i => $name)
        {
        ?>
            <tr bgcolor="#FFFFFF">
                <td><?php echo $no; ?></td>
                <td><?php echo $name; ?></td>
                <td><?php echo $tp[$i]; ?></td>
                <td><?php echo $fp[$i]; ?></td>
                <td><?php echo "{$tp[$i]} / ({$tp[$i]} + {$fn[$i]}) = {$recall[$i]}"?></td>
    <?php
    $no = $no + 1;
}
    ?>
</table><br>

<!-- Table Untuk Menampilkan Hasil All Precision -->
<table class="table table-bordered table-striped table-hover">
<thead>
    <br></br>
    <tr></tr>
<tr>
    <td style="text-align:center" colspan = "5"><strong>Menghitung All Precision dan All Recall</strong></td>
</tr>
<tr class="bg-primary">
<th>Nilai Precision yang didapat</th>
<th>Nilai Recall yang didapat</th>
</tr>
</thead>
        <tr bgcolor="#FFFFFF">
            <td><?php echo 'Nilai Precision yang didapaat  => ', $all_precision;  ?></td>
            <td><?php echo 'Nilai Recall yang didapaat  => ', $all_recall;  ?></td>
    <?php
    $no = $no + 1;
    ?>
</table>
</div>
</body>
</html>