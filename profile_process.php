<?php
require_once('./class/encrypt.php');
require_once('./class/conn.php');
session_start();

$aes = new AES();
$conn = new conn();

if (!(isset($_SESSION['username']) && isset($_SESSION['csrf_token']))) {
    header('location: login.php?err=2');
    session_destroy();
    $conn->mysqli->close();
    die();
}

if (!$_SESSION['csrf_token'] == $_POST['csrf_token']) {
    header('location: login.php?err=3');
    session_destroy();
    $conn->mysqli->close();
    die();
}

$name = $_POST['name'];
$email = $_POST['email'];
$address = $_POST['address'];
$tel = $_POST['phone'];

$user = array($name, $email, $address, $tel);
$user_arr = array('name','email', 'address', 'tel');
$enc_user = array();


$enc_username = $aes->encrypt($_SESSION['username']);
$i = 0;
foreach ($user as $u) {
    $enc_user[$user_arr[$i]] = $aes->encrypt($u);
    $i++;
}
$sql='UPDATE customers AS c 
INNER JOIN users AS u ON c.username = u.username 
SET c.name = ?, c.email = ?, c.address = ?, c.phone_number = ? 
WHERE c.username = ?
';
$stmt = $conn->mysqli->prepare($sql);
$stmt->bind_param('sssss', $enc_user['name'], $enc_user['email'], $enc_user['address'], $enc_user['tel'], $enc_username);
$stmt->execute();

$conn->mysqli->close();
header('location: user_profile.php?success=1');
die();
?>