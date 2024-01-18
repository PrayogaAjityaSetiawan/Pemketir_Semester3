<!DOCTYPE html>
<html lang="en">
<head>
    <title>Confusion Metrix</title>
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
    echo "0 results";
}

$sql = "SELECT id_actual, id_predicted FROM classify_2211500331";
$result = $conn->query($sql);

$confusionMatrix = array_fill_keys(array_keys($categoryNames), array_fill_keys(array_keys($categoryNames), 0));
$total = 0;
$correct = 0;

if ($result->num_rows > 0) {
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

$conn->close();

// Hitung akurasi, presisi, dan recall
$accuracy = $correct / $total * 100;
$precision = array();
$recall = array();
$tp = array();
$fp = array();
$total_tp = 0;
$total_fp = 0;
$total_fn = 0;
foreach ($categoryNames as $i => $name) {
    $tp[$i] = $confusionMatrix[$i][$i];
    $fp[$i] = array_sum($confusionMatrix[$i]) - $tp[$i];
    $fn[$i] = array_sum(array_column($confusionMatrix, $i)) - $tp[$i];
    $precision[$i] = ($tp[$i] + $fp[$i]) > 0 ? $tp[$i] / ($tp[$i] + $fp[$i]) : 0;
    $recall[$i] = ($tp[$i] + $fn[$i]) > 0 ? $tp[$i] / ($tp[$i] + $fn[$i]) : 0;
    $total_tp += $tp[$i];
    $total_fp += $fp[$i];
    $total_fn += $fn[$i];
}

// Untuk Menghitung All precision dan All recall
$all_precision = array_sum($precision) / count($precision) * 100;
$all_recall = array_sum($recall) / count($recall) * 100;


// Tampilkan confusion matrix, TP, FP, akurasi, presisi, dan recall dalam bentuk tabel HTML
echo '<div class="container">';
echo '<h2>Confusion Matrix</h2>';
echo '<table class="table table-bordered">';
echo '<tr><th>Actual\Predicted</th>';
foreach ($categoryNames as $name) {
    echo "<th>$name</th>";
}

echo '</tr>';
foreach ($confusionMatrix as $actual => $predictions) {
    echo '<tr>';
    echo "<td>{$categoryNames[$actual]}</td>";
    foreach ($predictions as $predicted => $count) {
        echo "<td>$count</td>";
    }
    echo '</tr>';
}
echo '</table>';

// Menampilkan table Perfomance Metrics
echo '<h2>Performance Metrics</h2>';
echo '<table class="table table-bordered">';
echo '<tr><th>Category</th><th>True Positive</th><th>False Positive</th><th>Precision (TP / (TP + FP))</th><th>Recall (TP / (TP + FN))</th></tr>';
foreach ($categoryNames as $i => $name) {
    echo '<tr>';
    echo "<td>$name</td><td>{$tp[$i]}</td><td>{$fp[$i]}</td><td>{$tp[$i]} / ({$tp[$i]} + {$fp[$i]}) = {$precision[$i]}</td><td>{$tp[$i]} / ({$tp[$i]} + {$fn[$i]}) = {$recall[$i]}</td>";
    echo '</tr>';
}
echo '</table>';

// Menampilkan table All Precission dan All Recall
echo '<h2>All Precision and All Recall</h2>';
echo '<table class="table table-bordered">';
echo '<tr><th>All Precision (Sum of Precision / Number of Classes)</th><th>All Recall (Sum of Recall / Number of Classes)</th></tr>';
echo '<tr><td>' . array_sum($precision) . ' / ' . count($precision) . ' = ' . $all_precision . '</td><td>' . array_sum($recall) . ' / ' . count($recall) . ' = ' . $all_recall . '</td></tr>';
echo '</table>';


// Menampilkan table Accuracy
echo '<h2>Accuracy</h2>';
echo '<table class="table table-bordered">';
echo '<tr><th>Accuracy (correct / total)</th></tr>';
echo '<tr><td>' . $correct . ' / ' . $total . ' x 100 = ' . $accuracy . '</td></tr>';
echo '</table>';
echo '</div>';
?>

</body>
</html>