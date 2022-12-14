<?php
    $usernreg = $_POST['usernreg'];
    $emailreg = $_POST['emailreg'];
    $passreg = $_POST['passreg'];

    //Database connection
    $conn = new mysqli('localhost','root','','test');
    if($conn->connect_error){
        die('Connection failed: ' .$conn->connect_error);
    } else {
        $stmt = $conn->prepare("insert into lietotāji(lietotājvārds, e-pasts) values(?, ?)");
        $stmt->bind_param("ss", $username, $emailreg);
        $stmt->execute();
        echo "Registration successful!";
        $stmt->close();
        $conn->close();
    }
?>