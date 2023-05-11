<?php
require_once('./class/encrypt.php');
require_once('./class/conn.php');
session_start();

$aes = new AES();
$conn = new conn();

if (isset($_POST['passOld']) && isset($_POST['passNew']) && isset($_POST['passNewRe']) && isset($_POST['csrf_token'])) {
    if (!(isset($_SESSION['username']) && isset($_SESSION['csrf_token']))) {
        header('location: login.php?err=2');
        session_destroy();
        $conn->mysqli->close();
        die();
    } 

    if (!($_SESSION['csrf_token'] == $_POST['csrf_token'])) {
        header('location: login.php?err=3');
        session_destroy();
        $conn->mysqli->close();
        die();
    } 

    if (!$_POST['passNew'] == $_POST['passNewRe']) {
        header('location: change_password.php?err=3');
        $conn->mysqli->close();
        die();
    }

    $pass_old = $_POST['passOld'];
    $pass_new = $_POST['passNew'];

    $enc_username = $aes->encrypt($_SESSION['username']);
    $enc_pass_old = $aes->encrypt($pass_old);
    $enc_pass_new = $aes->encrypt($pass_new);

    $sql = "SELECT * FROM users WHERE username=? AND password=?";
    $stmt = $conn->mysqli->prepare($sql);
    $stmt->bind_param('ss', $enc_username, $enc_pass_old);
    $stmt->execute();
    $res = $stmt->get_result();
    $nrows = $res->num_rows;
    
    if (!$nrows > 0) {
        header('location: change_password.php?err=2');
        $conn->mysqli->close();
        die();
    }

    $sql = "UPDATE users SET password=? WHERE username=?";
    $stmt = $conn->mysqli->prepare($sql);
    $stmt->bind_param('ss', $enc_pass_new, $enc_username);
    $stmt->execute();
    
    if (!$stmt->affected_rows > 0) {
        header('location: change_password.php?err=1');
        $conn->mysqli->close();
        die();
    }

    session_unset();
    session_destroy();

    header('location: login.php?success=1');
    $conn->mysqli->close();

} else {
    header('location: change_password.php?err=1');
    $conn->mysqli->close();
    die();
}
?>