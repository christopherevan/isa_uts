<?php
require_once('./class/encrypt.php');
require_once('./class/conn.php');
session_start();

if (isset($_POST['accNumber']) && isset($_POST['amount'])) {
    $aes = new AES();
    $conn = new conn();
    
    $accDest = $_POST['accNumber'];
    $enc_dest = $aes->encrypt($accDest);
    $amount = $_POST['amount'];
    
    $enc_user = $aes->encrypt($_SESSION['username']);
    $sql = "SELECT u.*, c.*, a.* FROM users as u INNER JOIN customers as c ON u.username=c.username 
    INNER JOIN accounts as a ON c.customer_id=a.customer_id WHERE u.username=?";
    $stmt = $conn->mysqli->prepare($sql);
    $stmt->bind_param('s', $enc_user);
    $stmt->execute();
    $res = $stmt->get_result();
    
    if ($row = $res->fetch_assoc()){
        $user = array('origin' => $row['account_id'], 'dest' => $enc_dest, 'amount' => $amount);
    }
    
    // AMBIL BALANCE PENGIRIM
    $sql = "SELECT balance FROM accounts WHERE account_id=?";
    $stmt = $conn->mysqli->prepare($sql);
    $stmt->bind_param('s', $user['origin']);
    $stmt->execute();
    $res = $stmt->get_result();
    $balanceOrigin = 0;
    
    if($row = $res->fetch_assoc()){
        $balanceOrigin = $row['balance'];
    }
    
    // AMBIL BALANCE PENERIMA
    $sql = "SELECT balance FROM accounts WHERE account_id=?";
    $stmt = $conn->mysqli->prepare($sql);
    $stmt->bind_param('s', $user['dest']);
    $stmt->execute();
    $res = $stmt->get_result();
    $balanceDest = 0;
    
    if($row = $res->fetch_assoc()){
        $balanceDest = $row['balance'];
    }
    
    if($balanceOrigin < $amount){
        header('location: transfer.php?err=1');
        die();
    }
    
    $newBal = $balanceOrigin - $amount;
    $sql = "UPDATE accounts SET balance=? WHERE account_id=?";
    $stmt = $conn->mysqli->prepare($sql);
    $stmt->bind_param('ds', $newBal, $user['origin']);
    $stmt->execute();
    
    $newBal = $balanceDest + $amount;
    $sql = "UPDATE accounts SET balance=? WHERE account_id=?";
    $stmt = $conn->mysqli->prepare($sql);
    $stmt->bind_param('ds', $newBal, $user['dest']);
    $stmt->execute();
    
    $sql = "INSERT into transactions(amount, transaction_type, account_origin, account_destination) values (?,?,?,?)";
    $stmt = $conn->mysqli->prepare($sql);
    $tt = 'DEBIT';
    $stmt->bind_param('dsss', $user['amount'], $tt, $user['origin'], $user['dest']);
    $stmt->execute();
    
    
    $sql = "INSERT into transactions(amount, transaction_type, account_origin, account_destination) values (?,?,?,?)";
    $stmt = $conn->mysqli->prepare($sql);
    $tt = 'CREDIT';
    $stmt->bind_param('dsss', $user['amount'], $tt, $user['origin'], $user['dest']);
    $stmt->execute();
    
    header('location: transfer.php?success=1');
    
    $conn->mysqli->close();
}
?>