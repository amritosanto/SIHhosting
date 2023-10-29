<?php
    $servername = "localhost";
    $fname = "fname";
    $lname = "lname";
    $pnumber = "pnumber";
    $email = "email";
    $password = "password";
    $dbname = "certicain.individual";

    // Create connection
    $conn = new mysqli($localhost, $root, $, $certicain.individual);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO individual (fname, lname, pnumber, email, password) VALUES ('$fname','$lname','$pnumber','$email','$password')";

    if ($conn->query($sql) === TRUE) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
?>