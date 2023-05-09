<?php
require_once('./class/encrypt.php');
require_once('./class/conn.php');
session_start();


$accDest = $_POST['accNumber'];
$enc_dest = $aes->encrypt($accDest);
$amount = $_POST['amount'];

$aes = new AES();
$conn = new conn();

$enc_user = $aes->encrypt($_SESSION['username']);
$sql = "SELECT u.*, c.*, a.* FROM users as u INNER JOIN customers as c ON u.username=c.username 
INNER JOIN accounts as a ON c.customer_id=a.customer_id WHERE u.username=?";
$stmt = $conn->mysqli->prepare($sql);
$stmt->bind_param('s', $enc_user);
$stmt->execute();
$res = $stmt->get_result();

if ($row = $res->fetch_assoc()){
    $user = array($row['account_id'], $enc_dest, $amount);
    $user_arr = array('origin', 'dest', 'amount');
}

$sql = "UPDATE balance SET balance=balance-? FROM accounts WHERE account_id=?";
$stmt = $conn->mysqli->prepare($sql);
$stmt->bind_param('ds', $user_arr['amount'], $user_arr['origin']);
$stmt->execute();
$res = $stmt->affected_rows;
if ($res > 0) {
      
} else {
    header('location: login.php?err=1');
}

$sql = "UPDATE balance SET balance=balance+? FROM accounts WHERE account_id=?";
$stmt = $conn->mysqli->prepare($sql);
$stmt->bind_param('ds', $user_arr['amount'], $user_arr['dest']);
$stmt->execute();
$res1 = $stmt->affected_rows;
if ($res1 > 0) {
      
} else {
    header('location: login.php?err=1');
}
$conn->mysqli->close();
?>