<?php
require 'db.php';

$id = $_GET['id'] ?? null;
if (!$id)
    die("Invalid quote ID.");

$stmt = $con->prepare("SELECT * FROM quotes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$quote = $result->fetch_assoc();
if (!$quote)
    die("Quote not found.");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text = $_POST['quote_text'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $date = $_POST['quote_date'];

    $update = $con->prepare("UPDATE quotes SET quote_text=?, author=?, category=?, quote_date=? WHERE id=?");
    $update->bind_param("ssssi", $text, $author, $category, $date, $id);

    if ($update->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Update failed: " . $update->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Quote</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-5">
        <h2>Edit Quote</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Quote Text</label>
                <textarea name="quote_text" class="form-control" required minlength="10"
                    maxlength="500"><?= htmlspecialchars($quote['quote_text']) ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Author</label>
                <input type="text" name="author" class="form-control" required minlength="3" maxlength="50"
                    value="<?= htmlspecialchars($quote['author']) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category" class="form-select" required>
                    <option value="">Select</option>
                    <option value="Motivation" <?= $quote['category'] == 'Motivation' ? 'selected' : '' ?>>Motivation
                    </option>
                    <option value="Love" <?= $quote['category'] == 'Love' ? 'selected' : '' ?>>Love</option>
                    <option value="Wisdom" <?= $quote['category'] == 'Wisdom' ? 'selected' : '' ?>>Wisdom</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Date</label>
                <input type="date" name="quote_date" class="form-control" required value="<?= $quote['quote_date'] ?>">
            </div>
            <button class="btn btn-primary">Update Quote</button>
        </form>
    </div>
</body>

</html>