<?php
require_once('../../class/encrypt.php');
require_once('../../class/conn.php');
session_start();

if (isset($_POST['pass']) && isset($_POST['acc_id']) && isset($_POST['amount'])) {
    if (!($_SESSION['csrf_token'] == $_POST['csrf_token'])) {
        echo 'csrf';
        session_unset();
        session_destroy();
        die();
    }

    $aes = new AES();
    $conn = new conn();
    
    $acc_id = $_POST['acc_id'];
    $pass = $_POST['pass'];
    $amount = $_POST['amount'];
    $enc_aid = $aes->encrypt($acc_id);
    $enc_pass = $aes->encrypt($pass);

    $enc_user = $aes->encrypt($_SESSION['username']);

    $sql = "SELECT username FROM users WHERE username=? AND password=?";
    $stmt = $conn->mysqli->prepare($sql);
    $stmt->bind_param('ss', $enc_user, $enc_pass);
    $stmt->execute();
    $res = $stmt->get_result();
    $nrows = $res->num_rows;
    // echo "numrows $nrows";
    if ($nrows > 0) {
        $enc_bank = $aes->encrypt('bank');
        $sql = "SELECT u.*, c.*, a.* FROM users as u INNER JOIN customers as c ON u.username=c.username 
        INNER JOIN accounts as a ON c.customer_id=a.customer_id WHERE u.username=?";
        $stmt = $conn->mysqli->prepare($sql);
        $stmt->bind_param('s', $enc_bank);
        $stmt->execute();
        $res = $stmt->get_result();
        
        if ($row = $res->fetch_assoc()){
            $bank_id = $row['account_id'];
        }

        // AMBIL BALANCE PENERIMA
        $sql = "SELECT balance FROM accounts WHERE account_id=?";
        $stmt = $conn->mysqli->prepare($sql);
        $stmt->bind_param('s', $enc_aid);
        $stmt->execute();
        $res = $stmt->get_result();
        $balanceDest = 0;
        
        if($row = $res->fetch_assoc()){
            $balanceDest = $row['balance'];
        }
        
        $newBal = $balanceDest + $amount;
        $sql = "UPDATE accounts SET balance=? WHERE account_id=?";
        $stmt = $conn->mysqli->prepare($sql);
        $stmt->bind_param('ds', $newBal, $enc_aid);
        $stmt->execute();

        $sql = "INSERT into transactions(amount, transaction_type, account_origin, account_destination) values (?,?,?,?)";
        $stmt = $conn->mysqli->prepare($sql);
        $tt = 'DEBIT';
        $stmt->bind_param('dsss', $amount, $tt, $bank_id, $enc_aid);
        $stmt->execute();
        
        echo 'true';
    } else {
        echo 'false';
    }

    $conn->mysqli->close();
}

?>