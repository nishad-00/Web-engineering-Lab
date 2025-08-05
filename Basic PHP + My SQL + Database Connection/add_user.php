<?php
$message = ""; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'db_connect.php';

    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);

    if (empty($firstname) || empty($lastname) || empty($email)) {
        $message = "Error: All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Error: Invalid email format.";
    } else {
        $sql = "INSERT INTO users (firstname, lastname, email) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sss", $firstname, $lastname, $email);
            if ($stmt->execute()) {
                $message = "New user created successfully!";
            } else {
                $message = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $message = "Error preparing statement: " . $conn->error;
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New User</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            margin: 0;
            padding: 30px;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus, input[type="email"]:focus {
            border-color: #007bff;
            outline: none;
        }
        input[type="submit"] {
            width: 100%;
            background-color: #007bff;
            color: white;
            padding: 12px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.2s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: 500;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .links {
            text-align: center;
            margin-top: 20px;
        }
        .links a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Add a New User</h2>
        
        <?php if (!empty($message)): ?>
            <div class="message <?php echo strpos(strtolower($message), 'error') !== false ? 'error' : 'success'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form action="add_user.php" method="POST" novalidate>
            <div class="form-group">
                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="firstname" required>
            </div>
            <div class="form-group">
                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Add User">
            </div>
        </form>

        <div class="links">
            <a href="index.php">← Back to User List</a>
        </div>
    </div>

</body>
</html>