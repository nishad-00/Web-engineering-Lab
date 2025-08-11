<?php
// =======================================================================
// == FILE: index.php (Dashboard)
// =======================================================================
require 'db_connect.php';
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$user_id = $_SESSION['id'];

// Check if user has a biodata entry
$sql = "SELECT * FROM biodata WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$biodata = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
        <div class="navbar-brand">Matrimony</div>
        <div class="navbar-links">
            <span>Welcome, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></span>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
    <div class="container">
        <h2>My Biodata Profile</h2>
        <?php if ($biodata): ?>
            <div class="biodata-view">
                <h3><?php echo htmlspecialchars($biodata['full_name']); ?></h3>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($biodata['gender']); ?></p>
                <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($biodata['date_of_birth']); ?></p>
                <p><strong>Religion:</strong> <?php echo htmlspecialchars($biodata['religion']); ?></p>
                <p><strong>Occupation:</strong> <?php echo htmlspecialchars($biodata['occupation']); ?></p>
                <a href="view_biodata.php?id=<?php echo $biodata['id']; ?>" class="btn">View Full Details</a>
                <a href="edit_biodata.php?id=<?php echo $biodata['id']; ?>" class="btn btn-secondary">Edit Biodata</a>
                <a href="delete_biodata.php?id=<?php echo $biodata['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete your biodata?');">Delete Biodata</a>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                You have not created your biodata yet.
            </div>
            <a href="create_biodata.php" class="btn">Create My Biodata</a>
        <?php endif; ?>
    </div>
</body>
</html>
