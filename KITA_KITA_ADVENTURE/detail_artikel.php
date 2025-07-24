<?php
include("config/database.php");
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM artikel WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

echo "<h1>" . $result['judul'] . "</h1>";
echo "<small>Diposting pada: " . $result['tanggal_upload'] . "</small><br>";

echo "<p>" . nl2br($result['isi']) . "</p>";
?>
