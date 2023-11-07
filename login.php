<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establish a database connection
    $conn = new mysqli("localhost", "root", "", "certicain");

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if login_type, email, and password are set in the POST request
    $login_type = isset($_POST['login_type']) ? $_POST['login_type'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Define the table based on the login type
    $table_name = ($login_type === 'individual') ? 'individual' : 'institutional';

    if (!empty($login_type) && !empty($email) && !empty($password)) {
        // Prepare and execute a SQL query with prepared statements
        $stmt = $conn->prepare("SELECT * FROM $table_name WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            if ($login_type === 'individual') {
                header("Location: indihome.html");
            } else {
                 header("Location: instihome.html");
             }
        } else {
            // Invalid login, redirect back to the login page with an error message
            header("Location: login.html?error=1");
        }
    } else {
        // Missing input values, redirect back to the login page with an error message
        header("Location: login.html?error=2");
    }

    // Close the database connection
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN PAGE</title>
    <style>

@media (max-width: 768px) {

/* Adjust styles for smaller screens */
.container1 {
    margin: 40px;
    max-width: 100%;
}

body {
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
}

@media (max-width: 480px) {

/* Additional media query for screens with a maximum width of 480px */
.container1 {
    padding: 20px;
}

}

@media (max-width: 330px) {

/* Further adjustment for even smaller screens */
.container1 {
    padding: 20px;
    width:max-content;
    max-width: 150%;
}

input {
    width: 95%;
}

body {
    overflow-x: hidden;
    /* Remove horizontal scrolling bar */
}
}
        body {
            font-family: Arial, sans-serif;
            background: #86A8CF;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .container1 {
            background-color: white;
            border-radius: 8px;
            box-shadow: 12px 12px 6px rgba(0, 0, 0, 0.2);
            width: 80%;
            max-width: 400px;
            padding: 40px;
            margin: 20px;
            text-align: center;
        }

        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-bottom: 1.5px solid #ccc;
            outline: none;
            text-align: left;
        }

        .form-group input[type="email"]:focus,
        .form-group input[type="password"]:focus {
            border-bottom: 1.5px solid black;
        }

        .btn-primary {
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 3px;
            padding: 10px 20px;
            cursor: pointer;
            font-weight: bold;
            box-shadow: 2px 2px 1px rgba(0, 0, 0, 0.3);
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .create-account a {
            color: #3498db;
        }

        .create-account a:hover {
            text-decoration: underline;
        }
        .User {
            color: powderblue;
        }

        @media screen and (max-width: 600px) {
            .container1 {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container1">
        <h1 style="text-align:center;">Login</h1><br><br>
        <form action="login.php" method="POST">
            <div class="form-group">
                <input type="email" id="email"name="email" placeholder="Email" required style="height: 2.5em; width: 100%;" required>
            </div><br>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div><br>
             <label for="login_type">Login Type:</label>
                <select name="login_type" id="login_type">
                    <option id="individual" value="individual">Individual</option>
                    <option id="institutional" value="institutional">Institutional</option>
                 </select><br><br>
            <center>
                <p style="text-align: center;">Don't have an account?  <a href="option.html">Create Account</a></p><br>
                <input class="btn-primary" type="submit" name="submit" value="Submit" href="home.html"class="button">
            </center>
        </form>
    </div>
</body>