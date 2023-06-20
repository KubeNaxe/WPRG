<?php 
session_start();
function connect()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "jdmforum";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error)
    {
        die("Failed to connect with database: " . $conn->connect_error);
    }
    return $conn;
}
?>