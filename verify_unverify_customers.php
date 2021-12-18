<?php
session_start();
ob_start();
include "include/conn.php";
?>
<?php
//unverify customer
if(isset($_POST['id'])){
    $driver_id=$_POST['id'];
    $sql="select account_verified from customers where id='$driver_id'";
    $result=$conn->query($sql);
    $row=mysqli_fetch_assoc($result);
    $status=$row['account_verified'];
    if($status == 0){
        $newsql="update customers set account_verified = 1 where id='$driver_id'";
        $run=$conn->query($newsql);
        if($run){
          $_SESSION['block_success']="Customer Verified successfully";
        }
        else{
          $conn->error;
        }
    }
    else if($status == 1){
        $newsqll="update customers set account_verified = 0 where id='$driver_id'";
        $runn=$conn->query($newsqll);
        if($runn){
          $_SESSION['block_success']="Customer Unverified successfully";
        }
        else{
          $conn->error;
        }
    }
}
?>