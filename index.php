<?php
require 'db.php';

$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM quotes WHERE author LIKE ? OR category LIKE ?";
$stmt = $con->prepare($sql);
$searchParam = "%$search%";
$stmt->bind_param("ss", $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();
$quotes = $result->fetch_all(MYSQLI_ASSOC);

$randomResult = $con->query("SELECT * FROM quotes ORDER BY RAND() LIMIT 1");
$random = $randomResult->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Quote Collection</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container py-5">
    <h2 class="text-center mb-4">🌟 Quote of the Day</h2>
    <?php if ($random): ?>
      <div class="card mb-5 p-3 bg-light quote-card category-<?= strtolower($random['category']) ?>">
        <blockquote class="blockquote mb-0">
          <p>"<?= htmlspecialchars($random['quote_text']) ?>"</p>
          <footer class="blockquote-footer">
            <?= htmlspecialchars($random['author']) ?> in <cite><?= htmlspecialchars($random['category']) ?></cite>
          </footer>
        </blockquote>
      </div>
    <?php else: ?>
      <div class="alert alert-warning text-center">
        No quotes found. Please <a href="add_quote.php">add one</a> to get started!
      </div>
    <?php endif; ?>

    <!-- Search -->
    <form method="GET" class="sticky-top bg-white p-3">
      <div class="input-group mb-3">
        <input type="text" name="search" class="form-control" placeholder="Search by author or category..."
          value="<?= htmlspecialchars($search) ?>">
        <button class="btn btn-outline-secondary" type="submit">Search</button>
      </div>
    </form>

    <!-- Quote List -->
    <h3 class="mb-3">📚 Your Quotes</h3>
    <a href="add_quote.php" class="btn btn-success mb-3"><i class="fas fa-plus-circle"></i> Add Quote</a>
    <div class="row">
      <?php if ($search && count($quotes) === 0): ?>
        <div class="alert alert-danger text-center">
          No results found for "<strong><?= htmlspecialchars($search) ?></strong>".<br>
          Redirecting to all quotes...
        </div>
        <script>
          setTimeout(() => {
            window.location.href = 'index.php';
          }, 2000); // 3 seconds delay
        </script>
      <?php endif; ?>

      <?php if (count($quotes) > 0): ?>
        <?php foreach ($quotes as $quote): ?>
          <div class="col-md-6 mb-4">
            <div class="card quote-card category-<?= strtolower($quote['category']) ?>">
              <div class="card-body">
                <p class="card-text">"<?= htmlspecialchars($quote['quote_text']) ?>"</p>
                <h6 class="card-subtitle mb-2 text-muted">
                  <?= htmlspecialchars($quote['author']) ?> | <?= htmlspecialchars($quote['quote_date']) ?>
                </h6>
                <span class="badge bg-primary"><?= htmlspecialchars($quote['category']) ?></span>
                <div class="mt-2">
                  <a href="update_quote.php?id=<?= $quote['id'] ?>" class="btn btn-sm btn-warning">
                    <i class="fas fa-edit"></i> Edit
                  </a>
                  <a href="delete_quote.php?id=<?= $quote['id'] ?>" class="btn btn-sm btn-danger"
                    onclick="return confirm('Delete this quote?');">
                    <i class="fas fa-trash"></i> Delete
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
  <script src="script.js"></script>
</body>

</html>