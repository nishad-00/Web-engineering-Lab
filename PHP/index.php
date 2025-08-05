<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            margin: 0;
            padding: 30px;
        }
        .container {
            max-width: 900px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        tr {
            transition: background-color 0.2s ease;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        tr:first-child th:first-child { border-top-left-radius: 6px; }
        tr:first-child th:last-child { border-top-right-radius: 6px; }
        .add-link {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 10px 18px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.2s ease;
        }
        .add-link:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Registered Users</h2>
        <a href="add_user.php" class="add-link">＋ Add New User</a>

        <table>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Registration Date</th>
            </tr>

            <?php
            require_once 'db_connect.php';
            $sql = "SELECT id, firstname, lastname, email, reg_date FROM users ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["firstname"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["lastname"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["reg_date"]) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='text-align:center;'>No users found</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </div>

</body>
</html>