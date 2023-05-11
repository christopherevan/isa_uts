<?php
require_once('../../class/encrypt.php');
require_once('../../class/conn.php');
session_start();

if (!(isset($_SESSION['username']) && isset($_SESSION['role']))) {
    header('location: ../../login.php?err=2');
    die();
}

if (!(($_SESSION['role'] == "teller") || ($_SESSION['role'] == "manager"))) {
    session_unset();
    session_destroy();
    header('location: ../../login.php?err=4');
    die();
}


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
    
    $enc_to = $aes->encrypt($acc_id);
    $enc_pass = $aes->encrypt($pass);
    
    if (isset($_POST['acc_from'])){
        $acc_from = $_POST['acc_from'];
        $enc_from = $aes->encrypt($acc_from);
    }

    $enc_user = $aes->encrypt($_SESSION['username']);

    $sql = "SELECT username FROM users WHERE username=? AND password=?";
    $stmt = $conn->mysqli->prepare($sql);
    $stmt->bind_param('ss', $enc_user, $enc_pass);
    $stmt->execute();
    $res = $stmt->get_result();
    $nrows = $res->num_rows;
    if ($nrows > 0) {
        if (!isset($_POST['acc_from'])){
            $enc_bank = $aes->encrypt('bank');
            $sql = "SELECT u.*, c.*, a.* FROM users as u INNER JOIN customers as c ON u.username=c.username 
            INNER JOIN accounts as a ON c.customer_id=a.customer_id WHERE u.username=?";
            $stmt = $conn->mysqli->prepare($sql);
            $stmt->bind_param('s', $enc_bank);
            $stmt->execute();
            $res = $stmt->get_result();
            
            if ($row = $res->fetch_assoc()){
                $enc_from = $row['account_id'];
            }
        }
        
        if (isset($_POST['acc_from'])){
            $sql = "SELECT balance FROM accounts WHERE account_id=?";
            $stmt = $conn->mysqli->prepare($sql);
            $stmt->bind_param('s', $enc_from);
            $stmt->execute();
            $res = $stmt->get_result();
            $balanceOrigin = 0;
            
            if($row = $res->fetch_assoc()){
                $balanceOrigin = $row['balance'];
            }

            if($balanceOrigin < $amount){
                echo 'ins';
                die();
            }
        }

        // AMBIL BALANCE PENERIMA
        $sql = "SELECT balance FROM accounts WHERE account_id=?";
        $stmt = $conn->mysqli->prepare($sql);
        $stmt->bind_param('s', $enc_to);
        $stmt->execute();
        $res = $stmt->get_result();
        $balanceDest = 0;
        
        if($row = $res->fetch_assoc()){
            $balanceDest = $row['balance'];
        }

        if (isset($_POST['acc_from'])){
            $newBal = $balanceOrigin - $amount;
            $sql = "UPDATE accounts SET balance=? WHERE account_id=?";
            $stmt = $conn->mysqli->prepare($sql);
            $stmt->bind_param('ds', $newBal, $enc_from);
            $stmt->execute();

            $sql = "INSERT into transactions(amount, transaction_type, account_origin, account_destination) values (?,?,?,?)";
            $stmt = $conn->mysqli->prepare($sql);
            $tt = 'CREDIT';
            $stmt->bind_param('dsss', $amount, $tt, $enc_from, $enc_to);
            $stmt->execute();
        }
        
        $newBal = $balanceDest + $amount;
        $sql = "UPDATE accounts SET balance=? WHERE account_id=?";
        $stmt = $conn->mysqli->prepare($sql);
        $stmt->bind_param('ds', $newBal, $enc_to);
        $stmt->execute();

        $sql = "INSERT into transactions(amount, transaction_type, account_origin, account_destination) values (?,?,?,?)";
        $stmt = $conn->mysqli->prepare($sql);
        $tt = 'DEBIT';
        $stmt->bind_param('dsss', $amount, $tt, $enc_from, $enc_to);
        $stmt->execute();
        
        echo 'true';
    } else {
        echo 'false';
    }

    $conn->mysqli->close();
}

?>