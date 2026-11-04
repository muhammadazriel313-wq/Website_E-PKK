<?php
require 'c:\xampp1\htdocs\Website_PKK\public\API-REST-E-PKK\config\koneksi.php';
$result = mysqli_query($koneksi, "SHOW COLUMNS FROM laporan_penghayatan_n_pengamalan");
if ($result) {
    while($row = mysqli_fetch_assoc($result)) {
        echo $row['Field'] . ' - ' . $row['Type'] . "\n";
    }
} else {
    echo mysqli_error($koneksi);
}
?>
