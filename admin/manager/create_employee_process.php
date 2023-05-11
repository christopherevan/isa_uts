<?php
require_once('../../class/encrypt.php');
require_once('../../class/conn.php');
session_start();

function kill_session(string $redirect) {
    header("location: $redirect");
    session_unset();
    session_destroy();
    die();
}

if (!(isset($_SESSION['username']) && isset($_SESSION['role']) && isset($_SESSION['csrf_token']))) {
    kill_session('../../login.php?err=2');
}

if (!$_SESSION['role'] == "manager") {
    kill_session('../../login.php?err=4');
}

if (!isset($_POST['csrf_token'])) {
    kill_session('../../login.php?err=3');
}

if ($_SESSION['csrf_token'] != $_POST['csrf_token']) {
    kill_session('../../login.php?err=3');
}

if (!(isset($_POST['username']) && isset($_POST['pass']) && isset($_POST['selectRole']))) {
    header("location: create_employee_account.php?err=2");
    die();
}

$aes = new AES();
$conn = new conn();

$enc_username = $aes->encrypt($_POST['username']);
$enc_pass = $aes->encrypt($_POST['pass']);
$role = $_POST['selectRole'];

$sql = "SELECT username FROM users WHERE username=?";
$stmt = $conn->mysqli->prepare($sql);
$stmt->bind_param('s', $enc_username);
$stmt->execute();
$res = $stmt->get_result();
$nrows = $res->num_rows;

if ($nrows > 0) {
    header('location: create_employee_account.php?err=1');
    $conn->mysqli->close();
    die();
}

$sql = "INSERT INTO users VALUE(?,?,?)";
$stmt = $conn->mysqli->prepare($sql);
$stmt->bind_param('sss', $enc_username, $enc_pass, $role);
$stmt->execute();
$nrows = $stmt->affected_rows;

if (!($nrows > 0)) {
    header('location: create_employee_account.php?err=2');
    $conn->mysqli->close();
    die();
}

header('location: create_employee_account.php?success=1');
$conn->mysqli->close();
?>