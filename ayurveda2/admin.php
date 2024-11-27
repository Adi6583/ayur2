<?php

// Handle new preparation submission
require 'config.php';

// Handle new preparation submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addPreparation'])) {
    $prepName = $_POST['prepName'];
    $prepDescription = $_POST['prepDescription'];
    
    $insertQuery = "INSERT INTO preparations (name, description) VALUES ('$prepName', '$prepDescription')";
    
    if (mysqli_query($conn, $insertQuery)) {
        echo "<script>alert('Preparation added successfully!');</script>";
    } else {
        echo "<script>alert('Failed to add preparation.');</script>";
    }
}

// Handle preparation deletion 
if (isset($_GET['remove'])) {
    $prepId = intval($_GET['remove']);
    $deleteQuery = "DELETE FROM preparations WHERE id = $prepId";
    
    if (mysqli_query($conn, $deleteQuery)) {
        echo "<script>alert('Preparation deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error occurred while deleting the preparation.');</script>";
    }
}

// Pagination logic
$limit = 5; // Number of records per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Fetch total number of preparations for pagination
$totalQuery = "SELECT COUNT(*) as total FROM preparations";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalPreparations = $totalRow['total'];
$totalPages = ceil($totalPreparations / $limit);

// Fetch preparations with limit and offset
$fetchQuery = "SELECT * FROM preparations LIMIT $limit OFFSET $offset";
$preparationsResult = mysqli_query($conn, $fetchQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Ayurvedic Preparations</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .input-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 10px;
        }
        button:hover {
            background-color: #45a049;
        }
        .preparation-item {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .preparation-item h3 {
            margin: 0;
            color: #333;
        }
        .action-links {
            display: flex;
            gap: 10px;
        }
        .action-links a {
            text-decoration: none;
            color: #4CAF50;
        }
        .action-links a:hover {
            text-decoration: underline;
        }
        .pagination {
            margin-top: 20px;
        }
        .pagination a {
            margin: 0 5px;
            text-decoration: none;
            color: #4CAF50;
        }
        .pagination a.active {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Add New Ayurvedic Preparation</h2>
    <form method="POST">
        <div class="input-group">
            <label for="prepName">Name of Preparation:</label>
            <input type="text" id="prepName" name="prepName" placeholder="New Preparation......." required>
        </div>
        <div class="input-group">
            <label for="prepDescription">Description of Preparation:</label>
            <textarea id="prepDescription" name="prepDescription" rows="5" placeholder="Description for the Preparation" required></textarea>
        </div>
        <button type="submit" name="addPreparation">Add </button>
    </form>

    <h2>All Preparations</h2>
    <?php
    if (mysqli_num_rows($preparationsResult) > 0) {
        while ($preparation = mysqli_fetch_assoc($preparationsResult)) {
            echo "<div class='preparation-item'>";
            echo "<h3>" . htmlspecialchars($preparation['name']) . "</h3>";
            echo "<div class='action-links'>";
            echo "<a href='?remove=" . $preparation['id'] . "' onclick='return confirm(\"Are you sure you want to delete this preparation?\");'>Delete</a>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>No preparations found.</p>";
    }
    ?>

    <div class="pagination">
        <?php
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $page) {
                echo "<a href='?page=$i' class='active'>$i</a>";
            } else {
                echo "<a href='?page=$i'>$i</a>";
            }
        }
        ?>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>