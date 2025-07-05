<?php include 'config/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Startup Documents</title>
    <style>
        body { font-family: Arial; background: #f2f2f2; padding: 20px; }
        .doc-card { background: #fff; border: 1px solid #ccc; padding: 15px; margin: 10px 0; }
        #popup-form {
            display: none; position: fixed; top: 50%; left: 50%;
            transform: translate(-50%, -50%); background: white;
            padding: 20px; border: 2px solid #333; z-index: 1000;
        }
        #overlay {
            display: none; position: fixed; top: 0; left: 0;
            width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;
        }
    </style>
</head>
<body>

<h2>📄 Startup Documents</h2>
<a href="index.php">← Back to Home</a> | 
<button onclick="openPopup()">➕ Add Document</button>

<form method="GET" style="margin-top:20px;">
    <input type="text" name="search" placeholder="Search documents..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
    <button type="submit">Search</button>
</form>

<?php
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$query = "SELECT * FROM startup_documents";
if ($search != '') {
    $query .= " WHERE name LIKE '%$search%' OR description LIKE '%$search%'";
}
$query .= " ORDER BY created_at DESC";

$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
    echo "<div class='doc-card'>";
    echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
    echo "<p>" . nl2br(htmlspecialchars($row['description'])) . "</p>";
    echo "<a href='" . htmlspecialchars($row['download_link']) . "' target='_blank'><button>⬇️ Download</button></a>";
    echo "</div>";
}
?>

<!-- Popup Form -->
<div id="overlay"></div>
<div id="popup-form">
    <h3>Add New Document</h3>
    <form action="submit_document.php" method="POST">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Description:</label><br>
        <textarea name="description" required></textarea><br><br>

        <label>Download Link (URL):</label><br>
        <input type="url" name="download_link" required><br><br>

        <button type="submit">Add Document</button>
        <button type="button" onclick="closePopup()">Cancel</button>
    </form>
</div>

<script>
function openPopup() {
    document.getElementById('popup-form').style.display = 'block';
    document.getElementById('overlay').style.display = 'block';
}
function closePopup() {
    document.getElementById('popup-form').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
}
</script>

</body>
</html>
