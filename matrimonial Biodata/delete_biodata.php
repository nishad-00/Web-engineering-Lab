<?php
// =======================================================================
// == FILE: delete_biodata.php
// =======================================================================
require 'db_connect.php';
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

if(isset($_GET['id'])){
    $biodata_id = $_GET['id'];
    $user_id = $_SESSION['id'];

    $sql = "DELETE FROM biodata WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $biodata_id, $user_id);
    
    if(mysqli_stmt_execute($stmt)){
        header("location: index.php");
        exit();
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
?>