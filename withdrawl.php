<?php include "include/header.php";?>

<?php 
//login check
if (empty(isset($_SESSION['user']))) {
  header('Location: login.php');
  die();
}
?>

<?php 
if(isset($_GET['completestatus'])){
    $sid = $_GET['completestatus'];
    $bal = $_GET['balance'];
    $driver_id = $_GET['driverid'];
    $sql1="select balance from driver_wallet where driver_id = '$driver_id'";
    $result1 = $conn->query($sql1);
    if($row1=mysqli_fetch_assoc($result1)){
        $current_bal = $row1['balance'];
    }
    $updated_bal = $current_bal - $bal;
    $sql2 = "update driver_wallet set balance = '$updated_bal' where driver_id = '$driver_id'";
    $result2 = $conn->query($sql2);
    if($result2){
        $dt = date('Y-m-d h:i:s'); 
        $uniqueid=uniqid();
        $msg = "$".$bal." "."has been successfully Transferred to your Paypal Account";
        $sql5 = "insert into driver_notifications (uid,driver_id,msg,state,created_at,updated_at) values('$uniqueid','$driver_id','$msg',0,'$dt','$dt')";
        $result5 = $conn->query($sql5);
        $sql="update driver_withdraws set status = 1 where id = '$sid'";
        $result=$conn->query($sql);
        if($result){
            $_SESSION['msg']="Status Updated As Completed";
            header("location:withdrawl.php");
            die();
        }
        else{
            $conn->error;
        }
    }
    else{
        $_SESSION['msg']="Unable To Update Withdraw Status";
        header("location:withdrawl.php");
    }
    
}

?>

<?php 
if(isset($_GET['canclestatus'])){
    $sid = $_GET['canclestatus'];
    $bal = $_GET['balance'];
    $driver_id = $_GET['driverid'];
    $sql1="select balance from driver_wallet where driver_id = '$driver_id'";
    $result1 = $conn->query($sql1);
    if($row1=mysqli_fetch_assoc($result1)){
        $current_bal = $row1['balance'];
    }
    $updated_bal = $current_bal + $bal;
    $sql2 = "update driver_wallet set balance = '$updated_bal' where driver_id = '$driver_id'";
    $result2 = $conn->query($sql2);
    if($result2){
        $dt = date('Y-m-d h:i:s'); 
        $uniqueid=uniqid();
        $msg = "Your Request to withdraw the Amount $".$bal." "."have been cancelled.";
        $sql5 = "insert into driver_notifications (uid,driver_id,msg,state,created_at,updated_at) values('$uniqueid','$driver_id','$msg',0,'$dt','$dt')";
        $result5 = $conn->query($sql5);
        $sql="update driver_withdraws set status = 2 where id = '$sid'";
        $result=$conn->query($sql);
        if($result){
            $_SESSION['msgs']="Status Updated As Canceled";
            header("location:withdrawl.php");
            die();
        }
        else{
            $conn->error;
        }
    }
    else{
        $_SESSION['msg']="Unable To Update Withdraw Status";
        header("location:withdrawl.php");
    }
}
?>

<body class="">
    <?php include "include/navbar.php";?>
    <!--Content Start-->
    <div class="content">
        <div class="container-fluid">
        <?php if(isset($_SESSION['msg'])){?>
			<div class="alert alert-success" role="alert">
			<?php echo $_SESSION['msg'];?>
			</div>
		<?php }unset($_SESSION['msg']);?>
        <?php if(isset($_SESSION['msgs'])){?>
			<div class="alert alert-danger" role="alert">
			<?php echo $_SESSION['msgs'];?>
			</div>
		<?php }unset($_SESSION['msgs']);?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                      <div class="card-icon">
                        <i class="fa fa-plus" style="font-size:24px;"></i>
                      </div>
                      <h4 class="card-title">Withdrawl Requests</h4>
                    </div>
    <!-- DataTales Example -->
    
        <div class="card-body">
            <div class="table-responsive text-center">
            <table id="dataTable" class="table table-reflow table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%;white-space: nowrap;">
                      <thead>
                        <tr>
                        <th>Sr No.</th>
                        <th>Driver Name</th>
                        <th>Withdrawl(Pay Pal) Email</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Created On</th>
                        <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                      $i=1;
                      $sql1 = "select * from driver_withdraws";
                      $result1 = $conn->query($sql1);
                      while($row1=mysqli_fetch_assoc($result1)){
                        $ddid = $row1['id'];
                        $driver_id = $row1['driver_id'];
                        $withdraw_email = $row1['withdraw_email'];
                        $balance = $row1['amount'];
                        $status = $row1['status'];
                        $deposit_date = $row1['created_at'];
                      ?>
                        <tr>
                          <td><?php echo $ddid;?></td>
                          <?php 
                          $sql="select * from drivers where id = '$driver_id'";
                          $result=$conn->query($sql);
                          while($row=mysqli_fetch_assoc($result)){
                              $fullname=$row['full_name'];
                              $ddemail=$row['email'];
                          }
                          ?>
                            <td><?php echo $fullname;?></td>
                            <td><?php echo $ddemail;?></td>
                            <td><?php echo $balance;?></td>
                            <?php if($status == 0){?>
                            <td><span class="badge badge-warning" style="font-size:22px;">Pending</span></td>
                            <?php }else if($status == 1){?>
                                <td><span class="badge badge-success" style="font-size:22px;">Completed</span></td>
                            <?php }else if($status == 2){?>
                                <td><span class="badge badge-danger" style="font-size:22px;">Cancelled</span></td>
                            <?php }?>
                            <td><?php echo $deposit_date;?></td>
                            <td>
                                <a href="withdrawl.php?completestatus=<?php echo $ddid;?>&&balance=<?php echo $balance;?>&&driverid=<?php echo $driver_id;?>" name="" <?php if($status == 1 || $status == 2){echo "style='pointer-events:none'";}?>><button class="btn btn-block btn-success mb-2">Complete</button></a>
                                <a href="withdrawl.php?canclestatus=<?php echo $ddid;?>&&balance=<?php echo $balance;?>&&driverid=<?php echo $driver_id;?>" name="" <?php if($status == 1 || $status == 2){echo "style='pointer-events:none'";}?>><button class="btn btn-block btn-danger mb-2">Cancle</button></a>
                            </td>
                        </tr>
                      <?php }?>
                      </tbody>
                    </table>
            </div>
        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--Content End-->
    <?php include "include/footer.php";?>

    <?php include "include/scripts.php";?>
</body>

</html>