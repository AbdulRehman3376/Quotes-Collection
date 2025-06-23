<?php
require 'db.php';
$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $con->prepare("DELETE FROM quotes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
header("Location: index.php");
exit();
?>