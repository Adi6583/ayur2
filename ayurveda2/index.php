<?php
include 'config.php';

$sql = "SELECT * FROM preparations ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
$preparations = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Calculate the number of items per column
$totalPreparations = count($preparations);
$itemsPerColumn = ceil($totalPreparations / 3);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ayurvedic Preparations</title>
    <style>
        body {
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: green;
            font-display: block;
        }
        h1:hover {
            color: blue;
            cursor: pointer;
        }
        .preparation {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
        }
        .preparation h3 {
            margin-top: 0;
            color: black;
            font-size: 20px;
        }
        .preparation a {
            text-decoration: none;
            color: black;
        }
        .preparation a:hover {
            text-decoration: underline;
            color: green;

        }
        .no-preparations {
            text-align: center;
            color: #666;
            padding: 20px;
        }
        .preparations-container {
            display: flex;
            gap: 10px;
            justify-content: space-between;
        }
        .column {
            flex: 1;
        }
    </style>
</head>
<body>
    <h1>Classical Ayurvedic Preparations</h1>
    <?php if (!empty($preparations)): ?>
        <div class="preparations-container">
            <?php for ($col = 0; $col < 3; $col++): ?>
                <div class="column">
                    <?php
                    for ($i = $col * $itemsPerColumn; $i < ($col + 1) * $itemsPerColumn && $i < $totalPreparations; $i++):
                        $prep = $preparations[$i];
                    ?>
                        <div class='preparation'>
                            <h3><a href='preparation.php?id=<?= $prep['id'] ?>'><?= htmlspecialchars($prep['name']) ?></a></h3>
                        </div>
                    <?php endfor; ?>
                </div>
            <?php endfor; ?>
        </div>
    <?php else: ?>
        <div class="no-preparations">No preparations found.</div>
    <?php endif; ?>
</body>
</html>
