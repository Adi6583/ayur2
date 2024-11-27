<?php
include 'config.php';

// Fetch the preparation details for editing
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Fetch the preparation details
    $sql = "SELECT * FROM preparations WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $name = htmlspecialchars($row['name']);
        $description = htmlspecialchars($row['description']);
    } else {
        echo "<script>alert('Preparation not found.'); window.location.href='admin.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('No ID specified.'); window.location.href='admin.php';</script>";
    exit;
}

// Handle form submission for updating the preparation
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    
    $sql = "UPDATE preparations SET name = ?, description = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $name, $description, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Preparation updated successfully!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Error updating preparation.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Ayurvedic Preparation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-group {
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
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Edit Ayurvedic Preparation</h2>
    <form method="POST">
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $name; ?>" required>
        </div>
        <div class="form-group">
            <label>Description:</label>
            <textarea name="description" rows="5" required><?php echo $description; ?></textarea>
        </div>
        <button type="submit" name="update">Update Preparation</button>
    </form>
    <a href="admin.php">Back to Preparations</a>
</body>
</html>