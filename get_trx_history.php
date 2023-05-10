<?php
require_once('./class/encrypt.php');
require_once('./class/conn.php');
session_start();

if (isset($_SESSION['username']) && isset($_SESSION['csrf_token'])) {
    $aes = new AES();
    $conn = new conn();
    
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

    $debit='DEBIT';
    $kredit='CREDIT';

    $sql = "SELECT transaction_time, account_origin, account_destination, transaction_type, amount FROM transactions 
    WHERE (account_origin=? AND transaction_type=?) OR (account_destination=? AND transaction_type=?)";
    $stmt = $conn->mysqli->prepare($sql);
    $stmt->bind_param('ssss', $sender_acc_id, $kredit, $sender_acc_id, $debit);
    $stmt->execute();
    $res = $stmt->get_result();

    $data = array();
    // $data_idx = array('transaction_time', 'account_origin', 'account_destination', 'transaction_type', 'amount');
    while ($row = $res->fetch_assoc()) {
        $decrypted_row = array();
        foreach ($row as $key => $value) {
            if ($key == 'account_origin' || $key == 'account_destination') {
                $value = $aes->decrypt($value);
            }

            if ($key == "amount") {
                $rupiah = number_format($value,0,',','.');
                $value = 'Rp'.$rupiah;
            }
            $decrypted_row[$key] = $value;
        }
        array_push($data, $decrypted_row);
    }

    echo json_encode($data);
    $conn->mysqli->close();
}

?>