<?php include "include/header.php";?>

<?php 
//login check
if (empty(isset($_SESSION['user']))) {
  header('Location: login.php');
  die();
}
?>
<?php 
if(isset($_POST['add_country'])){
  $dt = date('Y-m-d h:i:s'); 
  $id=uniqid();
  $name=$_POST['name'];
  $code=$_POST['code'];
  $sql="insert into countries(id,name,code,status,created_at,updated_at)values('$id','$name','$code',1,'$dt','$dt')";
  $result=$conn->query($sql);
  if($result){
    $_SESSION['add_country_success']="Country Added Successfully";
    header("location:countries.php");
    die();
  }
  else{
    $conn->error;
  }
}

?>
<?php 
if(isset($_GET['remove_country'])){
  $id=$_GET['remove_country'];
  $sql="delete from countries where id='$id'";
  $result=$conn->query($sql);
  if($result){
    $_SESSION['remove_country_success']="Country Removed Successfully";
    header("location:countries.php");
    die();
  }
  else{
    $conn->error;
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
                      <div class="card-header card-header-primary card-header-icon" >
                      <div class="card-icon">
                        <i class="fa fa-globe" style="font-size:24px;"></i>
                      </div>
                      <h4 class="card-title">Driver Partners</h4>
                    </div>
                        <!-- DataTales Example -->
        <div class="card-body">
            <div class="table-responsive text-center">
            <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Driver Name</th>
                          <th>Partner Name</th>
                          <th>Partner Type</th>
                          <th>Created At</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                      $sql="select * from driver_partners order by id";
                      $result=$conn->query($sql);
                      while($row=mysqli_fetch_assoc($result)){
                      $partnerid=$row['id'];
                      $driver_id=$row['driver_id'];
                      $sql1 = "select full_name from drivers where id = '$driver_id'";
                      $result1=$conn->query($sql1);
                      if($row1=mysqli_fetch_assoc($result1)){
                        $driver_name = $row1['full_name'];
                      }
                      $partner_id=$row['partner_id'];
                      $sql2 = "select full_name from drivers where id = '$partner_id'";
                      $result2=$conn->query($sql2);
                      if($row2=mysqli_fetch_assoc($result2)){
                        $partner_name = $row2['full_name'];
                      }
                      $partner_type=$row['partner_type'];
                      $status = $row['status'];
                      $created_at=$row['created_at'];
                      ?>
                        <tr>
                          <td><?php echo $partner_id;?></td>
                          <td><?php echo $driver_name;?></td>
                          <td><?php echo $partner_name;?></td>
                          <td><?php echo $partner_type;?></td>
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
    <script>
      $(document).ready(function(){
      $('input[name=enable_disable]').change(function(){
		    var id=$( this ).val();
        $.ajax({
          type:'POST',
          url:'enable_disable_country.php',
          data:{id : id},
          success:function(data)
          {
            window.location.reload(true);
          }
        });
      });
    });
    
    </script>
</body>

</html>