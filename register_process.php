<?php
require_once('./class/encrypt.php');
require_once('./class/conn.php');

$cid = 0;
$aid = 0;
$unique = false;
$unique_acc = false;

function randomNumber($length) {
    $result = '';

    for($i = 0; $i < $length; $i++) {
        $result .= mt_rand(0, 9);
    }

    return $result;
}

function checkUsername($username, $conn) {
    $sql = "SELECT username FROM users WHERE username='$username'";
    $res = $conn->mysqli->query($sql);
    $nr = $res->num_rows;
    if ($nr != 0) {
        $conn->mysqli->close();
        header('location: register.php?err=1');
        die();
    }
}

function checkCustId($cid, $conn) {
    global $unique;

    $sql = "SELECT customer_id FROM customers WHERE customer_id='$cid'";
    $res = $conn->mysqli->query($sql);
    $nr = $res->num_rows;
    if ($nr == 0) {
        $unique = true;
    }
}

function checkAccountId($aid, $conn) {
    global $unique_acc;

    $sql = "SELECT account_id FROM accounts WHERE account_id='$aid'";
    $res = $conn->mysqli->query($sql);
    $nr = $res->num_rows;
    if ($nr == 0) {
        $unique_acc = true;
    }
}

function checkPassword($pass, $repeatPas){
    if($pass == $repeatPas){
        return true;
    }
    else{
        return false;
    }
}

$name = $_POST['name'];
$username = $_POST['username'];
$email = $_POST['email'];
$address = $_POST['address'];
$tel = $_POST['tel'];
$pass = $_POST['pass'];
$passRe = $_POST['passRe'];
$pin = $_POST['pin'];

$user = array($name, $username, $email, $address, $tel, $pass, $pin);
$user_arr = array('name', 'username', 'email', 'address', 'tel', 'pass', 'pin');
$enc_user = array();

$aes = new AES();
$conn = new conn();

if(!checkPassword($pass, $passRe)){
    header('location: register.php?err=2');
    die();
}

$i = 0;
foreach ($user as $u) {
    $enc_user[$user_arr[$i]] = $aes->encrypt($u);
    $i++;
}

checkUsername($enc_user['username'], $conn);

$cust = 'customer';
$sql = 'INSERT INTO users VALUES(?,?,?)';
$stmt = $conn->mysqli->prepare($sql);
$stmt->bind_param('sss', $enc_user['username'], $enc_user['pass'], $cust);
$stmt->execute();
// print_r($enc_user);

while ($unique == false) {
    $cid = randomNumber(16);
    checkCustId($cid, $conn);
}

$encrypted_cid = $aes->encrypt($cid);
$sql2 = 'INSERT INTO customers VALUES(?,?,?,?,?,?)';
$stmt2 = $conn->mysqli->prepare($sql2);
$stmt2->bind_param('ssssss', $encrypted_cid, $enc_user['name'], $enc_user['address'], $enc_user['tel'], $enc_user['email'], $enc_user['username']);
$stmt2->execute();

while ($unique_acc == false) {
    $aid = randomNumber(16);
    checkAccountId($aid, $conn);
}

$bal = 0;
$encrypted_aid = $aes->encrypt($aid);
$sql3 = 'INSERT INTO accounts VALUES(?,?,?,?)';
$stmt3 = $conn->mysqli->prepare($sql3);
$stmt3->bind_param('siss', $encrypted_aid, $bal, $encrypted_cid, $enc_user['pin']);
$stmt3->execute();

$conn->mysqli->close();
// echo '<pre>' . print_r(get_defined_vars(), true) . '</pre>';
header('location: register.php?success=1');
die();
?>