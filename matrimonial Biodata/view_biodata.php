<?php
// =======================================================================
// == FILE: view_biodata.php
// =======================================================================
require 'db_connect.php';
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("location: index.php"); // Redirect if no ID is provided
    exit;
}

$biodata_id = $_GET['id'];
$sql = "SELECT * FROM biodata WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $biodata_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$biodata = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$biodata) {
    echo "Biodata not found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Biodata</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
        <a href="index.php" class="navbar-brand">Matrimony</a>
    </div>
    <div class="container">
        <div class="biodata-full-view">
            <h2><?php echo htmlspecialchars($biodata['full_name']); ?>'s Profile</h2>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($biodata['gender']); ?></p>
            <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($biodata['date_of_birth']); ?></p>
            <p><strong>Religion:</strong> <?php echo htmlspecialchars($biodata['religion']); ?></p>
            <p><strong>Education:</strong> <?php echo htmlspecialchars($biodata['education']); ?></p>
            <p><strong>Occupation:</strong> <?php echo htmlspecialchars($biodata['occupation']); ?></p>
            <p><strong>Address:</strong> <?php echo nl2br(htmlspecialchars($biodata['address'])); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($biodata['phone_number']); ?></p>
            <hr>
            <h3>About Me</h3>
            <p><?php echo nl2br(htmlspecialchars($biodata['about_me'])); ?></p>
            <br>
            <a href="index.php" class="btn">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
