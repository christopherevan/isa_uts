<?php
require_once('./class/encrypt.php');
require_once('./class/conn.php');
session_start();

$name = $_POST['name'];
$email = $_POST['email'];
$address = $_POST['address'];
$tel = $_POST['phone'];

$user = array($name, $email, $address, $tel);
$user_arr = array('name','email', 'address', 'tel');
$enc_user = array();

$aes = new AES();
$conn = new conn();
$enc_username = $aes->encrypt($_SESSION['username']);
$i = 0;
foreach ($user as $u) {
    $enc_user[$user_arr[$i]] = $aes->encrypt($u);
    $i++;
}

// $sql = 'UPDATE customers SET c.name=?, c.email=?, c.address=?, c.phone_number=? 
// FROM customers AS c INNER JOIN users AS u ON c.username=u.username WHERE c.username=?';
$sql='UPDATE customers AS c 
INNER JOIN users AS u ON c.username = u.username 
SET c.name = ?, c.email = ?, c.address = ?, c.phone_number = ? 
WHERE c.username = ?
';
$stmt = $conn->mysqli->prepare($sql);
$stmt->bind_param('sssss', $enc_user['name'], $enc_user['email'], $enc_user['address'], $enc_user['tel'], $enc_username);
$stmt->execute();
// print_r($enc_user);

$conn->mysqli->close();
// echo '<pre>' . print_r(get_defined_vars(), true) . '</pre>';
header('location: user_profile.php?success=1');
die();
?>