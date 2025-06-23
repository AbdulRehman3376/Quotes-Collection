<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $quote_text = $_POST['quote_text'];
  $author = $_POST['author'];
  $category = $_POST['category'];
  $quote_date = $_POST['quote_date'];

  // Use prepared statement for security
  $stmt = $con->prepare("INSERT INTO quotes (quote_text, author, category, quote_date) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $quote_text, $author, $category, $quote_date);

  if ($stmt->execute()) {
    header("Location: index.php");
    exit();
  } else {
    echo "<div class='alert alert-danger text-center'>Error: " . $stmt->error . "</div>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Add Quote</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container py-5">
    <h2>Add Quote</h2>
    <form method="POST" onsubmit="return validateForm()">
      <div class="mb-3">
        <label class="form-label">Quote Text</label>
        <textarea name="quote_text" class="form-control" required minlength="10" maxlength="500"></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Author</label>
        <input type="text" name="author" class="form-control" required minlength="3" maxlength="50">
      </div>
      <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="category" class="form-select" required>
          <option value="">Select</option>
          <option value="Motivation">Motivation</option>
          <option value="Love">Love</option>
          <option value="Wisdom">Wisdom</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Date</label>
        <input type="date" name="quote_date" class="form-control" required>
      </div>
      <button class="btn btn-primary">Add Quote</button>
    </form>
  </div>
  <script src="script.js"></script>
</body>

</html>