<?php
require_once('./class/encrypt.php');
require_once('./class/conn.php');
session_start();

if (isset($_POST['pin']) && isset($_POST['acc_id']) && isset($_POST['amount'])) {
    if (!($_SESSION['csrf_token'] == $_POST['csrf_token'])) {
        echo 'csrf';
        session_unset();
        session_destroy();
        die();
    }

    $aes = new AES();
    $conn = new conn();
    
    $acc_id = $_POST['acc_id'];
    $pin = $_POST['pin'];
    $amount = $_POST['amount'];
    $enc_aid = $aes->encrypt($acc_id);
    $enc_pin = $aes->encrypt($pin);

    $enc_user = $aes->encrypt($_SESSION['username']);
    $sql = "SELECT a.account_id FROM users as u INNER JOIN customers as c ON u.username=c.username 
    INNER JOIN accounts as a ON c.customer_id=a.customer_id WHERE u.username=?";
    $stmt = $conn->mysqli->prepare($sql);
    $stmt->bind_param('s', $enc_user);
    $stmt->execute();
    $res = $stmt->get_result();
    
    while ($row = $res->fetch_assoc()){
        $sender_acc_id = $row['account_id'];
    }

    $sql = "SELECT account_id FROM accounts WHERE account_id=? AND pin=?";
    $stmt = $conn->mysqli->prepare($sql);
    $stmt->bind_param('ss', $sender_acc_id, $enc_pin);
    $stmt->execute();
    $res = $stmt->get_result();
    $nrows = $res->num_rows;
    // echo "numrows $nrows";
    if ($nrows > 0) {
            // $accDest = $sender_acc_id;
            $enc_dest = $enc_aid;
            $amount = $amount;
            
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
                echo 'ins';
                // header('location: transfer.php?err=1');
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
            
            echo 'true';
    } else {
        echo 'false';
    }

    $conn->mysqli->close();
}

?>