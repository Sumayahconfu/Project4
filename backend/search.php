<?php
// Database connection
$host = 'localhost';
$db = 'properlink';
$user = 'root';
$pass = 'YourDatabasePassword'; // Update with your MySQL password
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get the search query
$query = $_GET['query'] ?? '';

if (!empty($query)) {
    // Search the database for matching records
    $stmt = $pdo->prepare("
        SELECT * FROM properties
        WHERE city LIKE :query OR address LIKE :query OR zip LIKE :query
    ");
    $stmt->execute(['query' => "%$query%"]);
    $results = $stmt->fetchAll();
} else {
    $results = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="../frontend/css/styles.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <h1>Search Results</h1>
        </div>
    </header>
    <main class="main-content">
        <div class="container">
            <?php if (!empty($results)): ?>
                <h2>Results for "<?php echo htmlspecialchars($query); ?>"</h2>
                <ul class="results-list">
                    <?php foreach ($results as $property): ?>
                        <li>
                            <h3><?php echo htmlspecialchars($property['address']); ?></h3>
                            <p>City: <?php echo htmlspecialchars($property['city']); ?></p>
                            <p>ZIP: <?php echo htmlspecialchars($property['zip']); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No results found for "<?php echo htmlspecialchars($query); ?>"</p>
            <?php endif; ?>
        </div>
    </main>
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 ProperLink. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
