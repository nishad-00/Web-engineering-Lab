<?php
// =======================================================================
// == FILE: edit_biodata.php
// =======================================================================
session_start();
require 'db_connect.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid request.";
    exit;
}

$biodata_id = (int)$_GET['id'];
$user_id = $_SESSION['id'];

// Fetch existing data
$sql_fetch = "SELECT * FROM biodata WHERE id = ? AND user_id = ?";
$stmt_fetch = mysqli_prepare($conn, $sql_fetch);
mysqli_stmt_bind_param($stmt_fetch, "ii", $biodata_id, $user_id);
mysqli_stmt_execute($stmt_fetch);
$result = mysqli_stmt_get_result($stmt_fetch);
$biodata = mysqli_fetch_assoc($result);

if (!$biodata) {
    echo "Biodata not found or you don't have permission to edit it.";
    exit;
}
mysqli_stmt_close($stmt_fetch);

// Handle form submission for update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $gender = trim($_POST['gender']);
    $dob = trim($_POST['date_of_birth']);
    $religion = trim($_POST['religion']);
    $education = trim($_POST['education']);
    $occupation = trim($_POST['occupation']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone_number']);
    $about = trim($_POST['about_me']);

    $sql_update = "UPDATE biodata 
                   SET full_name=?, gender=?, date_of_birth=?, religion=?, education=?, occupation=?, address=?, phone_number=?, about_me=? 
                   WHERE id = ? AND user_id = ?";
    $stmt_update = mysqli_prepare($conn, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "ssssssssssi", 
        $full_name, $gender, $dob, $religion, $education, $occupation, $address, $phone, $about, $biodata_id, $user_id
    );

    if (mysqli_stmt_execute($stmt_update)) {
        header("location: index.php");
        exit;
    } else {
        echo "Something went wrong. Please try again.";
    }
    mysqli_stmt_close($stmt_update);
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Biodata</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
        <a href="index.php" class="navbar-brand">Matrimony</a>
    </div>
    <div class="container">
        <h2>Edit Your Biodata Profile</h2>
        <form action="edit_biodata.php?id=<?php echo $biodata_id; ?>" method="post" class="biodata-form">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" value="<?php echo htmlspecialchars($biodata['full_name']); ?>" required>
            </div>
            <div class="form-group">
                <label>Gender</label>
                <select name="gender" required>
                    <option value="Male" <?php if($biodata['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if($biodata['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                </select>
            </div>
            <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" name="date_of_birth" value="<?php echo htmlspecialchars($biodata['date_of_birth']); ?>" required>
            </div>
            <div class="form-group">
                <label>Religion</label>
                <input type="text" name="religion" value="<?php echo htmlspecialchars($biodata['religion']); ?>">
            </div>
            <div class="form-group">
                <label>Highest Education</label>
                <input type="text" name="education" value="<?php echo htmlspecialchars($biodata['education']); ?>">
            </div>
            <div class="form-group">
                <label>Occupation</label>
                <input type="text" name="occupation" value="<?php echo htmlspecialchars($biodata['occupation']); ?>">
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea name="address"><?php echo htmlspecialchars($biodata['address']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone_number" value="<?php echo htmlspecialchars($biodata['phone_number']); ?>">
            </div>
            <div class="form-group">
                <label>About Me</label>
                <textarea name="about_me" rows="5"><?php echo htmlspecialchars($biodata['about_me']); ?></textarea>
            </div>
            <div class="form-group">
                <input type="submit" class="btn" value="Update">
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
