<?php include 'config/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Startups & Investors</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <h1>Startup Ideas</h1>
    <a href="list_investor.php">List Yourself as Investor</a> | 
    <a href="list_startup.php">Pitch Startup Idea</a>

    <h2>Startups</h2>
    <div>
        <?php
        $result = $conn->query("SELECT s.*, i.name as investor_name FROM startups s LEFT JOIN investors i ON s.investor_id = i.id ORDER BY s.created_at DESC");
        while($row = $result->fetch_assoc()) {
            echo "<div style='border:1px solid #ccc;padding:10px;margin:10px;'>";
            echo "<strong>Name:</strong> " . htmlspecialchars($row['name']) . "<br>";
            echo "<strong>Idea:</strong> " . nl2br(htmlspecialchars($row['idea'])) . "<br>";
            echo "<strong>Pitch Amount:</strong> $" . $row['pitch_amount'] . "<br>";
            echo "<strong>Equity:</strong> " . $row['equity_percentage'] . "%<br>";
            echo "<strong>Pitched To:</strong> " . htmlspecialchars($row['investor_name']) . "<br>";
            echo "<img src='assets/uploads/startups/" . $row['product_photo'] . "' height='100'><br>";
            echo "</div>";
        }
        ?>
    </div>

    <h2>Investors</h2>
    <div>
        <?php
        $result = $conn->query("SELECT * FROM investors ORDER BY created_at DESC");
        while($row = $result->fetch_assoc()) {
            echo "<div style='border:1px solid #ccc;padding:10px;margin:10px;'>";
            echo "<img src='assets/uploads/investors/" . $row['photo'] . "' height='100'><br>";
            echo "<strong>Name:</strong> " . htmlspecialchars($row['name']) . "<br>";
            echo "<strong>Company:</strong> " . htmlspecialchars($row['company']) . "<br>";
            echo "<strong>Description:</strong> " . nl2br(htmlspecialchars($row['description'])) . "<br>";
            echo "<strong>Contact:</strong> " . htmlspecialchars($row['contact']) . "<br>";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>
