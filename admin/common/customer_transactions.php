<?php
require_once('../../class/encrypt.php');
require_once('../../class/conn.php');
session_start();

$aes = new AES();
$conn = new conn();

$enc_user = $aes->encrypt($_SESSION['username']);
// $sql = "SELECT c.name FROM users as u INNER JOIN customers as c ON u.username=c.username WHERE u.username=?";
// $stmt = $conn->mysqli->prepare($sql);
// $stmt->bind_param('s', $enc_user);
// $stmt->execute();
// $res = $stmt->get_result();

// if ($row = $res->fetch_assoc()){
//     $user = $row['name'];
// }
// $dec_user = $aes->decrypt($user);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Mi-Bank Admin</title>

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../../admin/<?php echo $_SESSION['role']?>/index.php">
                <div class="sidebar-brand-icon">
                    <img src="../../img/mixue-mascot.png" alt="" style="width: 70px;">
                </div>
                <div class="sidebar-brand-text mx-3">mi-bank admin</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item ">
                <a class="nav-link" href="../../admin/<?php echo $_SESSION['role']?>/index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <?php
                if ($_SESSION['role']=='manager'){
                    echo '<div class="sidebar-heading">
                    Transactions
                </div>
                <li class="nav-item active">
                    <a class="nav-link" href="../common/customer_transactions.php">
                        <i class="fas fa-fw fa-clipboard-list"></i>
                        <span>Customer Transactions</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../common/deposit.php" >
                        <i class="fas fa-fw fa-money-bill-wave-alt"></i>
                        <span>Deposit</span>
                    </a>
                </li>
                
                <hr class="sidebar-divider">
                <div class="sidebar-heading">
                    Data
                </div>
                <li class="nav-item">
                    <a class="nav-link" href="../common/list_customer.php">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Customer List</span>
                    </a>
                </li>
    
                <hr class="sidebar-divider">
                <div class="sidebar-heading">
                    Employee
                </div>
                <li class="nav-item">
                    <a class="nav-link" href="../manager/create_employee_account.php">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Create Employee Account</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../manager/list_employees.php">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Employees List</span>
                    </a>
                </li>
    
                <hr class="sidebar-divider">
                <li class="nav-item">
                    <a class="nav-link" href="../../logout.php">
                        <i class="fas fa-fw fa-chart-area"></i>
                        <span>Logout</span></a>
                </li>';
                }else if($_SESSION['role']=='teller'){
                    echo'<div class="sidebar-heading">
                    Transactions
                </div>
                <li class="nav-item active">
                    <a class="nav-link" href="../common/customer_transactions.php">
                        <i class="fas fa-fw fa-clipboard-list"></i>
                        <span>Customer Transactions</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../common/deposit.php" >
                        <i class="fas fa-fw fa-money-bill-wave-alt"></i>
                        <span>Deposit</span>
                    </a>
                </li>
                
                <hr class="sidebar-divider">
                <div class="sidebar-heading">
                    Data
                </div>
                <li class="nav-item">
                    <a class="nav-link" href="../common/list_customer.php">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Customer List</span>
                    </a>
                </li>
    
                <hr class="sidebar-divider">
                <li class="nav-item">
                    <a class="nav-link" href="../../logout.php">
                        <i class="fas fa-fw fa-chart-area"></i>
                        <span>Logout</span></a>
                </li>';
                }
            ?>

            <!-- TELLER -->




            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        

                        <!-- Nav Item - Messages -->
                        

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small" id="user_name"><?php echo $_SESSION['username']?></span>
                                <img class="img-profile rounded-circle"
                                    src="../../img/undraw_profile.svg">
                            </a>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                <!-- KONTEN DISINIIIII -->

                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Customer Transactions</h1>
                                </div>
                                <!-- <form class="user" method="post" action="transfer_process.php"> -->
                                    <div class="form-group">
                                        <label>From</label>
                                        <input type="text" class="form-control form-control-user" name="accNumber"
                                            id="accNumberFrom" placeholder="Insert Account Number" maxlength="16" required>

                                        <div id="alertAccFrom"></div>
                                    </div>
                                    <div class="form-group">
                                        <?php
                                        if (isset($_GET['err'])) {
                                            if ($_GET['err'] == 1) {
                                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Oops!</strong> Balance is insufficient!.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>';
                                            }
                                        }

                                        if (isset($_GET['success'])) {
                                            if ($_GET['success'] == 1) {
                                                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Transfer Successful!</strong> Fund has been transferred successfully.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>';
                                            }
                                        }
                                        
                                        ?>
                                        <label>Send To</label>
                                        <!-- <select name="accNumber" class="form-control" id="accNumber" required>
                                            <option>aaaaa</option>
                                        </select> -->
                                        <input type="text" class="form-control form-control-user" name="accNumber"
                                            id="accNumberTo" placeholder="Insert Account Number" maxlength="16" required>

                                        <div id="alertAccTo"></div>
                                    </div>
                                    <div class="form-group">
                                        <label>Money Amount</label>
                                        <input type="number" class="form-control form-control-user" name="amount"
                                            id="moneyAmount" placeholder="Insert Amount" min="1" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block" id="btnSend"  data-toggle="modal" data-target="#modalSubscriptionForm">
                                        Send
                                    </button>
                                    <!-- <button type="submit" class="btn btn-primary btn-user btn-block" id="btnSend" disabled>
                                        Send
                                    </button> -->
                                <!-- </form> -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalSubscriptionForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header text-center">
                            <h4 class="modal-title w-100 font-weight-bold">Input Password</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body mx-3">
                            <div class="md-form">
                            <input type="password" class="form-control form-control-user" name="password"
                                                id="password" placeholder="Password" required>
                            <div id="modalWarning"></div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                        <button id="btnPassword" class="btn btn-primary btn-user btn-block">Confirm</button>
                        </div>
                        </div>
                    </div>
                    </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../js/demo/chart-area-demo.js"></script>
    <script src="../../js/demo/chart-pie-demo.js"></script>
    <script>
        var accdoneFrom = false;
        var accdoneTo = false;
        var amountdone = false;
        var token = "";

        $(document).ready(function() {
            $.post('../../get_token.php',
                function(data) {
                    token = data;
                }
            );
        });

        function cekFields() {
            if (accdoneFrom && amountdone && accdoneTo) {
                $("#btnSend").prop('disabled', false);
            } else {
                $("#btnSend").prop('disabled', true);
            }
            console.log(accdone);
            console.log(amountdone);
            console.log("---------");
        }

        $('#btnPassword').on('click', function(){
            var pass = $("#password").val();
            var accId = $("#accNumberTo").val();
            var accIdFrom = $("#accNumberFrom").val();
            var amount = $("#moneyAmount").val();

            $.post('cek_password.php',
                {   
                    'acc_id' : accId,
                    'pass' : pass,
                    'amount' : amount,
                    'csrf_token' : token,
                    'acc_from' : accIdFrom
                },
                function(data) {
                    if (data == 'false') {
                        $("#modalWarning").html("<div class='alert alert-danger mt-3 mb-0' role='alert'>Wrong Password. Please try again</div>");
                    } else if (data == 'csrf') {
                        window.location.replace("login.php?err=3");
                    } else if (data == 'true') {
                        window.location.replace("customer_transactions.php?success=1");
                    }else if (data == 'ins') {
                        window.location.replace("customer_transactions.php?err=1");
                    }
                }
            );
            
        });

        $('#accNumberTo').on('keyup', function(){
            var myLength = $("#accNumberTo").val().length;
            var otherLength = $("#accNumberFrom").val().length;
            if (myLength == 16) {
                var num = $('#accNumberTo').val();
                var numFrom = $('#accNumberFrom').val();
                $.post('../../cek_account.php',
                    {'acc_id' : num},
                    function(data) {
                        if ((myLength == 16 && otherLength==16)){
                            if (num==numFrom){
                                $("#alertAccTo").html("<div class='alert alert-danger my-3' role='alert'>You can't transfer to your own account!</div>");
                                accdoneFrom = false;
                                cekFields();
                            }else{
                                $.post('../../cek_account.php',
                                    {'acc_id' : numFrom,},
                                    function(data) {
                                        if (data == 'false') {
                                            $("#alertAccFrom").html("<div class='alert alert-danger my-3' role='alert'>Destination account number not found!</div>");
                                            accdoneFrom = false;
                                            cekFields();
                                        }else if(data=='same'){
                                            $("#alertAccFrom").html("<div class='alert alert-danger my-3' role='alert'>You can't transfer to your own account!</div>");
                                            accdoneFrom = false;
                                            cekFields();
                                        } else {
                                            $("#alertAccFrom").html("<div class='alert alert-success my-3' role='alert'> Destination account found: " + data + "</div>");
                                            accdoneFrom = true;
                                            cekFields();
                                        }
                                    }
                                );
                            }
                            
                        }

                        if (data == 'false') {
                            $("#alertAccTo").html("<div class='alert alert-danger my-3' role='alert'>Destination account number not found!</div>");
                            accdoneTo = false;
                            cekFields();
                        }else if(data=='same'){
                            $("#alertAccTo").html("<div class='alert alert-danger my-3' role='alert'>You can't transfer to your own account!</div>");
                            accdoneTo = false;
                            cekFields();
                        } else {
                            $("#alertAccTo").html("<div class='alert alert-success my-3' role='alert'> Destination account found: " + data + "</div>");
                            accdoneTo = true;
                            cekFields();
                        }
                    }
                );
            } 
            else if (myLength < 16) {
                $("#alertAccTo").html("");
                accdoneTo = false;
                cekFields();
            }
            // else if (myLength > 16) {
            //     accdone = false;
            //     cekFields();
            // }
        });

        $('#accNumberFrom').on('keyup', function(){
            var myLength = $("#accNumberFrom").val().length;
            var otherLength = $('#accNumberTo').val().length;
            if (myLength == 16) {
                var num = $('#accNumberFrom').val();
                var numTo = $('#accNumberTo').val();
                $.post('../../cek_account.php',
                    {'acc_id' : num,},
                    function(data) {
                        if ((myLength == 16 && otherLength==16)){
                            if(num==numTo){
                                $("#alertAccFrom").html("<div class='alert alert-danger my-3' role='alert'>You can't transfer to your own account!</div>");
                                accdoneFrom = false;
                                cekFields();
                            }else{
                                $.post('../../cek_account.php',
                                    {'acc_id' : numTo,},
                                    function(data) {
                                        if (data == 'false') {
                                            $("#alertAccTo").html("<div class='alert alert-danger my-3' role='alert'>Destination account number not found!</div>");
                                            accdoneTo = false;
                                            cekFields();
                                        }else if(data=='same'){
                                            $("#alertAccTo").html("<div class='alert alert-danger my-3' role='alert'>You can't transfer to your own account!</div>");
                                            accdoneTo = false;
                                            cekFields();
                                        } else {
                                            $("#alertAccTo").html("<div class='alert alert-success my-3' role='alert'> Destination account found: " + data + "</div>");
                                            accdoneTo = true;
                                            cekFields();
                                        }
                                    }
                                );
                            }
                            
                        }

                        if (data == 'false') {
                            $("#alertAccFrom").html("<div class='alert alert-danger my-3' role='alert'>Destination account number not found!</div>");
                            accdoneFrom = false;
                            cekFields();
                        }else if(data=='same'){
                            $("#alertAccFrom").html("<div class='alert alert-danger my-3' role='alert'>You can't transfer to your own account!</div>");
                            accdoneFrom = false;
                            cekFields();
                        } else {
                            $("#alertAccFrom").html("<div class='alert alert-success my-3' role='alert'> Destination account found: " + data + "</div>");
                            accdoneFrom = true;
                            cekFields();
                        }
                    }
                );
            } 
            else if (myLength < 16) {
                $("#alertAccFrom").html("");
                accdoneFrom = false;
                cekFields();
            }
            // else if (myLength > 16) {
            //     accdone = false;
            //     cekFields();
            // }
        });
    </script>
</body>

</html>