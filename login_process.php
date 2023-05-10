<?php
require_once('./class/encrypt.php');
require_once('./class/conn.php');
session_start();

if (isset($_SESSION['username'])) {
    session_unset();
    session_destroy();
    session_start();
}   

$username = $_POST['username'];
$password = $_POST['password'];

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

$sql = "SELECT * FROM users WHERE username=? AND password=?";
$stmt = $conn->mysqli->prepare($sql);
$stmt->bind_param('ss', $enc_user['username'], $enc_user['pass']);
$stmt->execute();
$res = $stmt->get_result();
$nrows = $res->num_rows;

if ($nrows > 0) {
    $csrf_token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $csrf_token;
    $_SESSION['username'] = $username;
    if ($row = $res->fetch_assoc()){
        if($row['role'] == 'customer'){
            $_SESSION['role'] = 'customer';
            header('location: index.php');
        }
        else if($row['role'] == 'manager'){
            $_SESSION['role'] = 'manager';
            header('location: admin/manager/index.php');
        }
        else if($row['role'] == 'teller'){
            $_SESSION['role'] = 'teller';
            header('location: teller/index.php');
        }
    }  
} else {
    header('location: login.php?err=1');
}

$conn->mysqli->close();
?>