<?php
require_once('./class/encrypt.php');
require_once('./class/conn.php');
session_start();

if (isset($_SESSION['username'])) {
    session_unset();
    session_destroy();
}

// print_r($_POST);    

$username = $_POST['username'];
$password = $_POST['password'];

// $mysqli = new mysqli("localhost","my_user","my_password","my_db");

// if ($mysqli -> connect_errno) {
//   echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
//   exit();
// }

$user = array($username, $password);
$user_arr = array('username', 'pass');
$enc_user = array();

$aes = new AES();
$conn = new conn();

$i = 0;
foreach ($user as $u) {
    $enc_user[$user_arr[$i]] = $aes->encrypt($u);
    $i++;
}
print_r($enc_user);
// $stmt = $mysqli->prepare("SELECT * FROM users WHERE username=? AND password=?");
// $stmt->bind_param('ss', $enc_user['username'], $enc_user['pass']);
// $stmt->execute();

// $res = $stmt->num_rows;
// if ($res > 0) {
//     $_SESSION['username'] = $username;
// } else {
//     header('location: login.php?err=1');
// }

$sql = "SELECT * FROM users WHERE username=? AND password=?";
$stmt = $conn->mysqli->prepare($sql);
$stmt->bind_param('ss', $enc_user['username'], $enc_user['pass']);
$stmt->execute();
$res = $stmt->get_result();
$nrows = $res->num_rows;
print_r($nrows);
if ($nrows > 0) {
    $_SESSION['username'] = $username;
    if ($row = $res->fetch_assoc()){
        if($row['role'] == 'customer'){
            $_SESSION['role'] = 'customer';
            header('location: index.php');
        }
        elseif($row['role'] == 'manager'){
            $_SESSION['role'] = 'manager';
            header('location: admin/manager/index.php');
        }
        elseif($row['role'] == 'teller'){
            $_SESSION['role'] = 'teller';
            header('location: teller/index.php');
        }
    }

    
} else {
    header('location: login.php?err=1');
}

$conn->mysqli->close();
?>