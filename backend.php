<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$server = "localhost";
$username = "root";
$password = "";
$db = "gym_db";

// Establish connection to MySQL
$con = new mysqli($server, $username, $password, $db);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Ensure the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register_btn'])) {
        // Validate and fetch form data safely
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $dob = isset($_POST['dob']) ? trim($_POST['dob']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $phonenumber = isset($_POST['phonenumber']) ? trim($_POST['phonenumber']) : '';
        $address = isset($_POST['address']) ? trim($_POST['address']) : '';
        $gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
        $plan = isset($_POST['plan']) ? trim($_POST['plan']) : '';

        // Check if required fields are empty
        if (empty($name) || empty($dob) || empty($email) || empty($phonenumber) || empty($address) || empty($gender) || empty($plan)) {
            die("Error: All fields are required.");
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Error: Invalid email format.");
        }

        // Validate phone number length
        if (strlen($phonenumber) < 10) {
            die("Error: Phone number must be at least 10 digits.");
        }

        // Use prepared statements to prevent SQL injection
        $stmt = $con->prepare("INSERT INTO members (name, dob, email, phonenumber, address, gender, plan) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $name, $dob, $email, $phonenumber, $address, $gender, $plan);

        if ($stmt->execute()) {
            header("Location: confirmation.html");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement and connection
        $stmt->close();
    }
    $con->close();
} else {
    die("405 Method Not Allowed - Only POST requests are accepted.");
}
?>
