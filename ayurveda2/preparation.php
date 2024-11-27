<?php
include 'config.php';

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Convert to integer to prevent SQL injection

    // Fetch the preparation details
    $sql = "SELECT * FROM preparations WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $name = htmlspecialchars($row['name']);
        $description = nl2br(htmlspecialchars($row['description']));
    } else {
        // If no preparation is found
        $name = "Preparation Not Found";
        $description = "No description available.";
    }
} else {
    // If no ID is specified
    $name = "Preparation Not Found";
    $description = "No description available.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $name; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        p {
            color: #666;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <h2><?php echo $name; ?></h2>
    <p><?php echo $description; ?></p>
    <a href="index.php">Click here to go back to Preparations</a>
</body>
</html>