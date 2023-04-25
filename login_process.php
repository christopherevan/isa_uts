<?php
session_start();

if (isset($_SESSION['username'])) {
    session_unset();
    session_destroy();
}

print_r($_POST);    

$username = $_POST['username'];
$password = $_POST['password'];

$mysqli = new mysqli("localhost","my_user","my_password","my_db");

if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

$stmt = $mysqli->prepare("SELECT * FROM users WHERE username=? AND password=?");
$stmt->bind_param('ss', $username, $password);
$stmt->execute();

$res = $stmt->num_rows;
if ($res > 0) {
    $_SESSION['username'] = $username;
} else {
    header('location: login.php?err=1');
}

$mysqli->close();
?>