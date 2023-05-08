<?php
require_once("data.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

class conn {
    public $mysqli;

    public function __construct()
    {
         return $this->mysqli = new mysqli(SERVER_NAME, USER_NAME, PASSWORD, DB_NAME);
    }
}
?>