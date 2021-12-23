<?php include "include/header.php";?>

<?php 
//login check
if (empty(isset($_SESSION['user']))) {
  header('Location: login.php');
  die();
}
?>

<?php
if(isset($_POST['add_charges_settings'])){
  $sql1="select * from currency_charges";
  $result1=$conn->query($sql1);
  while($row1=mysqli_fetch_assoc($result1)){
    $ic=$row1['from_id'];
    $fc=$row1['to_id'];
  }
  $from=$_POST['i_currency'];
  $to=$_POST['f_currency'];
  if($ic == $from && $fc == $to){
    $_SESSION['charges_settings_error']="Settings Already existed";
  }
  else{
  $rate=$_POST['rate'];
  $dt = date('Y-m-d h:i:s'); 
  $id=uniqid();
  $sql="insert into currency_charges(id,from_id,to_id,rate,created_at,updated_at)values ('$id','$from','$to','$rate','$dt','$dt')";
  $result=$conn->query($sql);
  if($result){
    $_SESSION['charges_settings_success']="Settings Added Successfully";
    header("location:charges_settings.php");
    die();
  }
  else{
    $conn->error;
  }
}
}
?>

<?php
if(isset($_GET['remove_setting'])){
  $id=$_GET['remove_setting'];
  $sql="Delete from currency_charges where id='$id'";
  $delete=$conn->query($sql);
  if($delete)
    {
      $_SESSION['remove_setting_success']="Charges Setting Removed Successfully";
      header("location: charges_settings.php");
      die();
    }
    else{
        echo $conn->error;
    }
}
?>
<?php 
if(isset($_POST['add_d_fee'])){
    $fee= $_POST['d-fee'];
    $sql="update deposit_fee set deposit_fee = '$fee' where id = 'deposit-fee'";
    $result=$conn->query($sql);
    if($result){
      $_SESSION['remove_setting_success']="Deposit Fee Updated Successfully";
      header("location: charges_settings.php");
      die();
    }
    else{
      echo $conn->error;
    }
}

?>

<?php 
if(isset($_POST['add_p_fee'])){
    $fee= $_POST['p-fee'];
    $sql="update withdraw_fee set withdraw_fee = '$fee' where id = 'withdraw-fee'";
    $result=$conn->query($sql);
    if($result){
      $_SESSION['remove_setting_success']="Withdraw Fee Updated Successfully";
      header("location: charges_settings.php");
      die();
    }
    else{
      echo $conn->error;
    }
}

?>

<?php 
if(isset($_POST['add_s_fee'])){
    $fee= $_POST['s-fee'];
    $sql="update send_fee set send_fee = '$fee' where id = 'send-fee'";
    $result=$conn->query($sql);
    if($result){
      $_SESSION['remove_setting_success']="P2P Fee Updated Successfully";
      header("location: charges_settings.php");
      die();
    }
    else{
      echo $conn->error;
    }
}

?>

<?php 
if(isset($_POST['add_c_fee'])){
    $fee= $_POST['c-fee'];
    $sql="update currency_fee set currency_fee = '$fee' where id = 'currency-fee'";
    $result=$conn->query($sql);
    if($result){
      $_SESSION['remove_setting_success']="Currency Fee Updated Successfully";
      header("location: charges_settings.php");
      die();
    }
    else{
      echo $conn->error;
    }
}

?>

<body class="">
  <?php include "include/navbar.php";?>
  <!--Content Start-->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="fa fa-sliders" style="font-size:24px;"></i>
              </div>
              <h4 class="card-title">Completed Delivery Requests</h4>
            </div>
            <!-- DataTales Example -->
            <div class="card-body">
              <div class="table-responsive text-center">
                <table id="dataTable" class="table table-striped table-bordered table-hover" cellspacing="0"
                  width="100%" style="width:100%">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Driver</th>
                      <th>Customer</th>
                      <th>Item Names</th>
                      <th>Description</th>
                      <th>Pickup Location</th>
                      <th>Delivery Destination</th>
                      <th>Date Of Delivery</th>
                      <th>Pickup Time</th>
                      <th>vehicle Type</th>
                      <th>Item Weight</th>
                      <th>Instructions</th>
                      <th>Created At</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                          $sql="select * from delivery where pending = 3";	
                          $result=$conn->query($sql);
                          while($row=mysqli_fetch_assoc($result)){
                            $id=$row['id'];
                            $customer_id=$row['customer_id'];
                            // $sql1="select name from currency where id= '$from_id'";
                            // $result1=$conn->query($sql1);
                            // $row1=mysqli_fetch_assoc($result1);
                            $customer="";
                            $driver_id=$row['driver_id'];
                            $items=$row['item_names'];
                            $description=$row['description'];
                            $pickup_location=$row['pickup_location'];
                            $delivery_destination=$row['delivery_destination'];
                            $date_of_delivery=$row['date_of_delivery'];
                            $pickup_time=$row['pickup_time'];
                            $vehicle_type=$row['vehicle_type'];
                            $items_weight=$row['items_weight'];
                            $instructions=$row['instructions'];
                            $status=$row['pending'];
                            $created_at=$row['created_at'];

                            $sql2="select * from drivers where id= '$driver_id'";
                            $result2=$conn->query($sql2);
                            $row2=mysqli_fetch_assoc($result2);
                            $driver=$row2['full_name'];
                            $sql3="select * from customers where id= '$customer_id'";
                            $result6=$conn->query($sql3);
                            $row3=mysqli_fetch_assoc($result6);
                            $customer=$row3['first_name'].' '.$row3['last_name'];
                        ?>
                    <tr>
                      <td><?php echo $id;?></td>
                      <td><?php echo $driver;?></td>
                      <td><?php echo $customer;?></td>
                      <td><?php echo $items;?></td>
                      <td><?php echo $description;?></td>
                      <td><?php echo $pickup_location;?></td>
                      <td><?php echo $delivery_destination;?></td>
                      <td><?php echo $date_of_delivery;?></td>
                      <td><?php echo $pickup_time;?></td>
                      <td><?php echo $vehicle_type;?></td>
                      <td><?php echo $items_weight;?> KG</td>
                      <td><?php echo $instructions;?></td>
                      <td><?php echo $created_at;?></td>
                    </tr>
                    <?php }?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="fa fa-sliders" style="font-size:24px;"></i>
              </div>
              <h4 class="card-title">Pending Delivery Requests</h4>
            </div>
            <!-- DataTales Example -->
            <div class="card-body">
              <div class="table-responsive text-center">
                <table id="dataTable" class="table table-striped table-bordered table-hover" cellspacing="0"
                  width="100%" style="width:100%">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Driver</th>
                      <th>Customer</th>
                      <th>Item Names</th>
                      <th>Description</th>
                      <th>Pickup Location</th>
                      <th>Delivery Destination</th>
                      <th>Date Of Delivery</th>
                      <th>Pickup Time</th>
                      <th>vehicle Type</th>
                      <th>Item Weight</th>
                      <th>Instructions</th>
                      <th>Created At</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                          $sql="select * from delivery where pending = 0";	
                          $result=$conn->query($sql);
                          while($row=mysqli_fetch_assoc($result)){
                            $id=$row['id'];
                            $customer_id=$row['customer_id'];
                            // $sql1="select name from currency where id= '$from_id'";
                            // $result1=$conn->query($sql1);
                            // $row1=mysqli_fetch_assoc($result1);
                            $customer="";
                            $driver_id=$row['driver_id'];
                            $items=$row['item_names'];
                            $description=$row['description'];
                            $pickup_location=$row['pickup_location'];
                            $delivery_destination=$row['delivery_destination'];
                            $date_of_delivery=$row['date_of_delivery'];
                            $pickup_time=$row['pickup_time'];
                            $vehicle_type=$row['vehicle_type'];
                            $items_weight=$row['items_weight'];
                            $instructions=$row['instructions'];
                            $status=$row['pending'];
                            $created_at=$row['created_at'];

                            $sql2="select * from drivers where id= '$driver_id'";
                            $result2=$conn->query($sql2);
                            $row2=mysqli_fetch_assoc($result2);
                            $driver=$row2['full_name'];
                            $sql3="select * from customers where id= '$customer_id'";
                            $result6=$conn->query($sql3);
                            $row3=mysqli_fetch_assoc($result6);
                            $customer=$row3['first_name'].' '.$row3['last_name'];
                        ?>
                    <tr>
                      <td><?php echo $id;?></td>
                      <td><?php echo $driver;?></td>
                      <td><?php echo $customer;?></td>
                      <td><?php echo $items;?></td>
                      <td><?php echo $description;?></td>
                      <td><?php echo $pickup_location;?></td>
                      <td><?php echo $delivery_destination;?></td>
                      <td><?php echo $date_of_delivery;?></td>
                      <td><?php echo $pickup_time;?></td>
                      <td><?php echo $vehicle_type;?></td>
                      <td><?php echo $items_weight;?> KG</td>
                      <td><?php echo $instructions;?></td>
                      <td><?php echo $created_at;?></td>
                    </tr>
                    <?php }?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="fa fa-sliders" style="font-size:24px;"></i>
              </div>
              <h4 class="card-title">Canceled Delivery Requests</h4>
            </div>
            <!-- DataTales Example -->
            <div class="card-body">
              <div class="table-responsive text-center">
                <table id="dataTable" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%"
                  style="width:100%">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Driver</th>
                      <th>Customer</th>
                      <th>Item Names</th>
                      <th>Description</th>
                      <th>Pickup Location</th>
                      <th>Delivery Destination</th>
                      <th>Date Of Delivery</th>
                      <th>Pickup Time</th>
                      <th>vehicle Type</th>
                      <th>Item Weight</th>
                      <th>Instructions</th>
                      <th>Created At</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                          $sql="select * from delivery where pending = 2";	
                          $result=$conn->query($sql);
                          while($row=mysqli_fetch_assoc($result)){
                            $id=$row['id'];
                            $customer_id=$row['customer_id'];
                            $driver_id=$row['driver_id'];
                            $items=$row['item_names'];
                            $description=$row['description'];
                            $pickup_location=$row['pickup_location'];
                            $delivery_destination=$row['delivery_destination'];
                            $date_of_delivery=$row['date_of_delivery'];
                            $pickup_time=$row['pickup_time'];
                            $vehicle_type=$row['vehicle_type'];
                            $items_weight=$row['items_weight'];
                            $instructions=$row['instructions'];
                            $status=$row['pending'];
                            $created_at=$row['created_at'];

                            $sql2="select * from drivers where id= '$driver_id'";
                            $result5=$conn->query($sql2);
                            $row2=mysqli_fetch_assoc($result2);
                            $driver=$row2['full_name'];
                            $sql3="select * from customers where id= '$customer_id'";
                            $result6=$conn->query($sql3);
                            $row3=mysqli_fetch_assoc($result6);
                            $customer=$row3['first_name'].' '.$row3['last_name'];
                        ?>
                    <tr>
                      <td><?php echo $id;?></td>
                      <td><?php echo $driver;?></td>
                      <td><?php echo $customer;?></td>
                      <td><?php echo $items;?></td>
                      <td><?php echo $description;?></td>
                      <td><?php echo $pickup_location;?></td>
                      <td><?php echo $delivery_destination;?></td>
                      <td><?php echo $date_of_delivery;?></td>
                      <td><?php echo $pickup_time;?></td>
                      <td><?php echo $vehicle_type;?></td>
                      <td><?php echo $items_weight;?> KG</td>
                      <td><?php echo $instructions;?></td>
                      <td><?php echo $created_at;?></td>
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