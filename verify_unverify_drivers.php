<?php
session_start();
ob_start();
include "include/conn.php";

?>
<?php
//unverify customer
if(isset($_POST['id'])){
    $driver_id=$_POST['id'];
    $sql="select email_verified from drivers where id='$driver_id'";
    $result=$conn->query($sql);
    $row=mysqli_fetch_assoc($result);
    $status=$row['email_verified'];
    if($status == 0){
      $newsql="update drivers set email_verified = 1 where id='$driver_id'";
      $run=$conn->query($newsql);
      if($run){
        $_SESSION['block_success']="Driver Verified successfully";
      }
      else{
        $conn->error;
      }
    }
    else if($status == 1){
      $newsqll="update drivers set email_verified = 0 where id='$driver_id'";
      $runn=$conn->query($newsqll);
      if($runn){
        $_SESSION['block_success']="Driver Unverified successfully";
      }
      else{
        $conn->error;
      }
    }
}
?>