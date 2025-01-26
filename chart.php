<?php
// Include your database connection code here
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Database connection parameters
$dbHost = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "recursos_humanos";
// Database configuration
// Create connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT count(id_personal) as personal, count(firma) as firma FROM datosPersonales"; // Replace 'your_table_name' with your actual table name
$result = $conn->query($sql);

$data = array();
foreach ($result as $row) {
    //echo "Hello!";
    $data[] = $row;
}

$conn->close();

// Print data in JSON format
echo json_encode($data);
?>