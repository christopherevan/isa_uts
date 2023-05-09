<?php
require_once('./class/encrypt.php');
require_once('./class/conn.php');
session_start();

if (isset($_POST['acc_id'])) {
    $aes = new AES();
    $conn = new conn();
    
    $acc_id = $_POST['acc_id'];
    $enc_session = $aes->encrypt($_SESSION['username']);
    $enc_aid = $aes->encrypt($acc_id);

    // lanjut cek apakh yg ditransferi sama apa ga
    $sql = "SELECT account_id FROM accounts WHERE account_id=?";
    $stmt = $conn->mysqli->prepare($sql);
    $stmt->bind_param('s', $enc_aid);
    $stmt->execute();
    $res = $stmt->get_result();
    $nrows = $res->num_rows;

    if ($nrows > 0) {
        $sql = "SELECT c.name FROM accounts AS a INNER JOIN customers AS c ON c.customer_id=a.customer_id WHERE a.account_id=?";
        $stmt = $conn->mysqli->prepare($sql);
        $stmt->bind_param('s', $enc_aid);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            echo $aes->decrypt($row['name']);
        }
    } else {
        echo 'false';
    }

    $conn->mysqli->close();
}

?>