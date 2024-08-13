<?php
include 'config/database.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die('Invalid ID');
}

// Delete the entry from the database
$sql = "DELETE FROM entries WHERE id = ?";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute([$id]);

if ($result) {
    header("Location: index.php?message=Entry+deleted+successfully");
    exit;
} else {
    die('Failed to delete the entry');
}
