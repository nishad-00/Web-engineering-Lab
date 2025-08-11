<?php
// =======================================================================
// == FILE: create_biodata.php
// =======================================================================

// IMPORTANT: Make sure session_start() is called at the very top of your
// script, before any HTML output, usually in your db_connect.php or a header file.
// session_start(); 

require 'db_connect.php';

// Redirect if user is not logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$error_message = ""; // To hold any potential error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // It's good practice to have a user_id variable from the session
    $user_id = $_SESSION['id'];

    // Trim all POST data to remove unwanted whitespace
    $full_name = trim($_POST['full_name']);
    $gender = trim($_POST['gender']);
    $dob = trim($_POST['date_of_birth']);
    $religion = trim($_POST['religion']);
    $education = trim($_POST['education']);
    $occupation = trim($_POST['occupation']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone_number']);
    $about = trim($_POST['about_me']);

    // Prepare the SQL statement (caste field removed)
    $sql = "INSERT INTO biodata (user_id, full_name, gender, date_of_birth, religion, education, occupation, address, phone_number, about_me) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind variables to the prepared statement as parameters (caste removed)
        // Type string changed from "issssssssss" to "isssssssss"
        mysqli_stmt_bind_param($stmt, "isssssssss", $user_id, $full_name, $gender, $dob, $religion, $education, $occupation, $address, $phone, $about);
        
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to index page on successful creation
            header("location: index.php");
            exit;
        } else {
            $error_message = "Something went wrong. Please try again later.";
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        $error_message = "Error preparing the database query.";
    }
    
    // Close connection
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Biodata Profile - Matrimony</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Your Professional Stylesheet -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
        <div class="navbar-side"></div> <!-- Empty div to balance the flexbox -->
        <a href="index.php" class="navbar-brand">Matrimony</a>
        <div class="navbar-side">
            <a href="index.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>

    <div class="form-container">
        <h2>Create Your Biodata Profile</h2>

        <?php 
        // Display an error message if something went wrong during form submission
        if (!empty($error_message)): 
        ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select id="gender" name="gender" required>
                    <option value="" disabled selected>Select your gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="form-group">
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" id="date_of_birth" name="date_of_birth" required>
            </div>
            <div class="form-group">
                <label for="religion">Religion</label>
                <input type="text" id="religion" name="religion">
            </div>
            <!-- Caste field has been removed -->
            <div class="form-group">
                <label for="education">Highest Education</label>
                <input type="text" id="education" name="education">
            </div>
            <div class="form-group">
                <label for="occupation">Occupation</label>
                <input type="text" id="occupation" name="occupation">
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea id="address" name="address"></textarea>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number">
            </div>
            <div class="form-group">
                <label for="about_me">About Me</label>
                <textarea id="about_me" name="about_me" rows="5"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Create Profile</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
