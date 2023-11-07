<?php
session_start();

$server = "localhost";
$username = "root";
$password = "";
$database = "certicain";

$conn = mysqli_connect($server, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_SESSION['success'])) {
    echo $_SESSION['success'];
    session_destroy();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $fname = mysqli_real_escape_string($conn, $_POST['fname']);
        $lname = mysqli_real_escape_string($conn, $_POST['lname']);
        $pnumber = mysqli_real_escape_string($conn, $_POST['pnumber']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $sql = "INSERT INTO `individual`(`fname`, `lname`, `pnumber`, `email`, `password`) VALUES ('$fname','$lname','$pnumber','$email','$password')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $_SESSION['success'] = 'Registration success.';
            header("location: login.php");
        } else {
            throw new Exception("Error inserting data into the database.");
        }
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INDIVIDUAL CREATE</title>
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

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="number"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-bottom: 1.5px solid #ccc;
            outline: none;
            text-align: left;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="email"]:focus,
        .form-group input[type="number"]:focus,
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
<
    </style>
</head>
<body>
    <div class="container1">
        <h1 style="text-align:center;">Create Account</h1><br><br>
        <form id="user_form" method="POST">
            <div class="form-group">
                <input type="text" name="fname" placeholder="First Name" required>
            </div><br>
            <div class="form-group">
                <input type="text" name="lname" placeholder="Last Name" required>
            </div><br>
            <div class="form-group">
                <input type="number" name="pnumber" placeholder="Phone Number" style="height: 2.5em; width: 100%;" required>
            </div><br>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" style="height: 2.5em; width: 100%;" required>
            </div><br>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div><br>
            <center>
                <input class="btn-primary" type="submit" name="submit" value="Submit" href="D:\eih project\website\index.html"class="button">
            </center>
        </form>
    </div>
</body>
</html>
