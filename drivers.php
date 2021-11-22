<?php include "include/header.php";?>

<?php 
//login check
if (empty(isset($_SESSION['user']))) {
  header('Location: login.php');
  die();
}
?>
<?php
if(isset($_GET['remove_driver'])){
  $id=$_GET['remove_driver'];
  $query = "SELECT * FROM drivers WHERE id='$id'";
        $result = $conn->query($query);

        while ($roww = mysqli_fetch_assoc($result)) {
            $image = $roww['profile_picture'];
            $file= "apisss/data/images/drivers/".$image;
            unlink($file);
            $imagee = $roww['proof'];
            $filee= "apisss/data/images/drivers/".$imagee;
            unlink($filee);
        }
        $sql="Delete from drivers where id='$id'";
        $delete=$conn->query($sql);
        if($delete)
        {
            $_SESSION['remove_customer_success']="Driver Profile Deleted Successfully";
            header("location: drivers.php");
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
        <?php if(isset($_SESSION['edit_customer_success'])){?>
                <div class="alert alert-success" role="alert">
                    <?php echo $_SESSION['edit_customer_success'];?>
                </div>
            <?php }unset($_SESSION['edit_customer_success']);?>
            <?php if(isset($_SESSION['add_customer_success'])){?>
                <div class="alert alert-success" role="alert">
                    <?php echo $_SESSION['add_customer_success'];?>
                </div>
            <?php }unset($_SESSION['add_customer_success']);?>
            <?php if(isset($_SESSION['block_success'])){?>
                <div class="alert alert-success" role="alert">
                    <?php echo $_SESSION['block_success'];?>
                </div>
            <?php }unset($_SESSION['block_success']);?>
            <?php if(isset($_SESSION['remove_customer_success'])){?>
                <div class="alert alert-success" role="alert">
                    <?php echo $_SESSION['remove_customer_success'];?>
                </div>
            <?php }unset($_SESSION['remove_customer_success']);?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                      <div class="card-icon">
                        <i class="fa fa-id-badge" style="font-size:24px;"></i>
                      </div>
                      <h4 class="card-title">Customers</h4>
                    </div>
                        <!-- DataTales Example -->
    
        <div class="card-body">
            <div class="table-responsive text-center">
            <table class="table table-reflow table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%;white-space: nowrap;">
                      <thead>
                        <tr>
                          <th>Sr No.</th>
                          <th>Id</th>
                          <th>Profile Picture</th>
                          <th>Full Name</th>
                        <th>Email</th>
                        <th>Date Of Birth</th>
                        <th>Country</th>
                        <th>Password</th>
                            <th>Proof</th>
                            <th>Verify / Unverify</th>
                            <th>Availability Status</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                          <th class="disabled-sorting">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                      $sql="select * from drivers order by id desc";
                      $result=$conn->query($sql);
                      while($row=mysqli_fetch_assoc($result)){
                            $sr_no=$row['id'];
                          $id=$row['uid'];
                          $profile_picture=$row['profile_picture'];
                          $full_name=$row['full_name'];
                          $demail=$row['email'];
                          $dob=$row['date_of_birth'];
                          $country=$row['country'];
                          $passwrod=$row['password'];
                          $proof=$row['proof'];
                          $verify=$row['email_verified'];
                          $status=$row['status'];
                          $created_at=$row['created_at'];
                          $updated_at=$row['updated_at'];
                      ?>
                        <tr>
                          <td><?php echo $sr_no;?></td>
                            <td><?php echo $id;?></td>
                            <td><?php echo "<a href='apisss/data/images/drivers/".$profile_picture."' data-lightbox='$profile_picture'><div style='position: relative;text-align: center;color: white;'><img src='apisss/data/images/drivers/".$profile_picture."' height='100' width='100' ><div style='position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);'><b>Click To View</b> <br> <i class='fa fa-eye'></i></div></div></a>"?></td>
                            <td><?php echo $full_name;?></td>
                            <td><?php echo $demail;?></td>
                            <td><?php echo $dob;?></td>
                            <td><?php echo $country;?></td>
                            <td><?php echo $passwrod;?></td>
                            <td><?php echo "<a href='apisss/data/images/drivers/".$proof."' data-lightbox='$proof'><div style='position: relative;text-align: center;color: white;'><img src='apisss/data/images/drivers/".$proof."' height='100' width='100' ><div style='position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);'><b>Click To View</b> <br> <i class='fa fa-eye'></i></div></div></a>"?></td>
                            <td>
                                <div class="togglebutton">
                                        <label>
                                            <input type="checkbox" name="verify_status" value="<?php echo $sr_no;?>" <?php if($verify == 1){echo 'checked=""';}?>>
                                            <span class="toggle"></span>
                                        </label>
                                  </div>
                            </td>
                            <td>
                                <div class="togglebutton">
                                        <label>
                                            <input type="checkbox" disabled <?php if($status == 1){echo 'checked=""';}?>>
                                            <span class="toggle"></span>
                                        </label>
                                  </div>
                            </td>
                            <td><?php echo $created_at;?></td>
                            <td><?php echo $updated_at;?></td>
                          <td class="td-actions">
                            <a href="?remove_driver=<?php echo $sr_no;?>" onclick="alert('Are You Sure?')">
                            <button type="button" data-toggle="tooltip" class="btn btn-danger btn-round" data-original-title="" title="">
                              <i class="material-icons">close</i>
                            </button>
                            </a>
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
    <script>
      $(document).ready(function(){
      $('input[name=verify_status]').change(function(){
		    var id=$( this ).val();
        $.ajax({
          type:'POST',
          url:'verify_unverify_drivers.php',
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