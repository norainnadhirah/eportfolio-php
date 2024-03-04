<?php 
session_start();
error_reporting(0);
include('include/dbconnection.php');

 if (strlen($_SESSION['admin_login'])==0) {
  header("location: logout.php");
    exit();
}

$uid=$_GET['editid'];


// code for update the read notification status
if(isset($_GET['editid']))
{
$isread=1;
$did=intval($_GET['editid']);
$sql="update user set IsRead=:isread where userid=:did";
$query = $dbh->prepare($sql);
$query->bindParam(':isread',$isread,PDO::PARAM_STR);
$query->bindParam(':did',$did,PDO::PARAM_STR);
$query->execute(); 

}


if(isset($_POST['update']))
  {
    $fname=$_POST['fullname'];

    $pnotel=$_POST['notel'];
    $pemail=$_POST['email'];
    $sql="update user set name=:name, notel=:notel , email=:email where userid=:uid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':name',$fname,PDO::PARAM_STR);
    $query->bindParam(':notel',$pnotel,PDO::PARAM_STR);
    $query->bindParam(':email',$pemail,PDO::PARAM_STR);
    $query->bindParam(':uid',$uid,PDO::PARAM_STR);
    $query->execute();
    if ($query->rowCount() > 0) {
        echo '<script>alert("Profile has been updated");</script>';
    } else {
        echo '<script>alert("Error updating profile, please try again");</script>';
    }
  }






?>


<!DOCTYPE html>
<html lang="en">
 <html lang="en">
     <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>PutraMD E-Portfolio | Edit User Profile</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    
        <?php include_once('include/header.php');?>
        <?php include_once('include/sidebar.php');?>
        
                   <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Edit User <?php ?></h1>
                        <ol class="breadcrumb mb-4">
                         <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="manageuser.php">Manage User</a></li>
                                <li class="breadcrumb-item active">Edit User</li>
                         
                        </ol>
                        


                <main>
<?php
                        if (isset($_SESSION['upmid'])) {
                               unset($_SESSION['upmid']);
                            }


                        $sql="SELECT * from user where userid=:uid";
                        $query = $dbh -> prepare($sql);
                        $query->bindParam(':uid',$uid,PDO::PARAM_STR);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);

                        $cnt=1;
                        if($query->rowCount() > 0)
                        {
                        foreach($results as $row)
                        {   

                            $_SESSION['upmid']=$row->username;
                            $upmid=$_SESSION['upmid'];
  
                                ?>
                              
                    <div class="card mb-4">
                            <div class="card-header">
                                <div class="row">
<?php

$user_dp=($row->user_dp);
$default_photo_url = "dp.png";

// Profile photo URL
$profile_photo_url = (empty($user_dp)) ? $default_photo_url : $user_dp;

$role=$row->role;

if ($row->role == "Supervisor") {
  $directory = "../mentor/img_dir/";
} elseif ($row->role == "Student") {
  $directory = "../student/img_dir/";
}

$profile_photo_url = $directory . $profile_photo_url;

echo '<img src="' . $profile_photo_url . '" class="img-thumbnail" style="width: 150px;" alt="No Profile Photo" alt="Profile Picture">';

$role=$row->role;


   if($role == 'Student'){
echo '<div class="col-md-6 mt-4"><a href="student-archive.php?id='.$upmid.'"><button class="btn btn-default btn-secondary" title="Student Assessment Archive">Student Assessment Archive</button></a></div>';
}
if($role == 'Supervisor'){
    echo '<div class="col-md-6 mt-4"><a href="supervisor-student.php?id='.$upmid.'"><button class="btn btn-default btn-secondary" title="View students under this supervisor"> View Student</button></a></div>';
}

?>


      

</div>


                            </div>
                           <div class="card-body">
                               
                    
                                    <form method="post" name="hjhgh" enctype="multipart/form-data">
                                         <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" type="text" value="<?php  echo $upmid;?>"  name="upmid" required="true" disabled/>
                                                        <label for="UPMID">UPMID</label>
                                                    </div>
                                                </div>
                                           
                                            </div>

                                        
                                        <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" type="text" value="<?php  echo htmlentities($row->name);?>" placeholder="name" name="fullname" required="true" />
                                                        <label for="">Name</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                      <div class="form-floating">
                                                        <input class="form-control" type="tel" value="<?php  echo htmlentities($row->regdate);?>" placeholder="Telephone Number" name="notel"  disabled/>
                                            
                                                        <label for="">Date Register</label>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" type="email_form"  placeholder="email" name="email" value="<?php  echo htmlentities($row->email);?>" required="true" />
                                                        <label for="">Email</label>
                                                    </div>
                                                </div>
                                            
                                                <div class="col-md-6">


                                                  
                                          
                                                    <div class="form-floating">
                                                        <input class="form-control" type="tel" value="<?php  echo htmlentities($row->notel);?>" placeholder="Telephone Number" name="notel" pattern="[0-9]{3}-[0-9]{7}" required="true"  />
                                                        <small>01X-XXXXXXX 
                                                            </small>
                                                        <label for="">Telephone Number</label>
                                                    </div>
                                                </div>
                                            </div>

                                <button class="btn btn-default bg-info sbmt-btn" type="submit" name="update">Update</button>
                            </form></div>
                                
                            


                                        



                                
                                





                          
                        </div>

                          <div class="card mb-4">
                            <div class="card-header">
                                <i class="fa-solid fa-lock me-1"></i>
                                                               Reset User Password
                            </div>
                            <div class="card-body">
                         

                                <div class="form-floating mb-3">
                                    <script>
                                        
    var check = function() {
        if (document.getElementById('password').value.length < 6) {
            document.getElementById('message').style.color = 'red';
            document.getElementById('message').innerHTML = 'Password must be atleast 6 characters';
        } else if (document.getElementById('password').value ==
            document.getElementById('confirm_password').value) {
            document.getElementById('message').style.color = 'green';
            document.getElementById('message').innerHTML = 'Matching';
        } else {
            document.getElementById('message').style.color = 'red';
            document.getElementById('message').innerHTML = 'Not matching';
        }
    }
</script>   <form method="post" enctype="multipart"> 
                                        <div class="form-floating mb-3">  
                                            <input class="form-control" id="password" type="password"
                                                name="txt_password" placeholder="Password" onkeyup='check();' required/>
                                            <label for="password">New Password</label>
                                        </div>
                                     
                                          <div class="form-floating mb-3">
                                            <input class="form-control" id="confirm_password" type="password"
                                                placeholder="Password" onkeyup='check();' />
                                            <label for="password">Confirm Password</label>
                                            <span id='message'></span>
                                        </div>

                                    </div>
                                    <div class="form-floating mb-3">   <div class="form-floating"><button class="btn btn-default bg-info sbmt-btn"" name="password_submit" type="submit">Confirm Password</button></div>
                                </form>
                                </div>
                           
                            </div>
                        </div>

                  
          
                        
                                                <?php

if(isset($_POST['password_submit']))
{
$uid=$_SESSION['student_login'];
$ppass=$_POST['txt_password'];
if(!empty($ppass)){
$sql="update user set password=:pass where username=:uid";
$query = $dbh->prepare($sql);
$query->bindParam(':pass',$ppass,PDO::PARAM_STR);
$query->bindParam(':uid',$uid,PDO::PARAM_STR);
$query->execute();
echo '<script>alert("Password has been updated")</script>';
echo "<script>window.location.href = 'index.php'</script>";
}
else{
echo '<script>alert("Password cannot be blank")</script>';
}

}?>
                        
                    
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fa-solid fa-user-large-slash me-1"></i>
                                User Status
                            </div>
                            <div class="card-body">
                                <form method="post" action="active_user.php?editid=<?php echo $uid; ?>" name ="active_user" enctype="multipart/form-data">
                                              <label class="form-floating mb-1">User Status:</label>
     <p><b><label class="form-floating text-danger"><?php echo ($row->Status == 1) ? "Active" : "Inactive";?></label></b></p>
                   
                              <?php 
    $user_status = $row->Status; // replace this with the actual user status from your database
    if($user_status == 0) {
        echo '<button class="btn btn-default bg-info sbmt-btn" name="activate_user" type="submit" onclick="return confirm(\'Do you want tu activete this user?\');">Activate User</button>';
    } else {
        echo '<button class="btn btn-default bg-warning sbmt-btn" name="deactivate_user" type="submit" onclick="return confirm(\'Do you want tu deactivate this user?\');">Deactivate User</button>';

    } 
?></form>
                            </div>
                        </div>

                                            
<?php $cnt=$cnt+1;}}  

?> 
                </main>

             

 
</div>
                 
                        
                                                <?php
                include_once('include/footer.php');
                ?>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="../assets/demo/chart-area-demo.js"></script>
        <script src="../assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="../js/datatables-simple-demo.js"></script>
    </body>
</html>

                                             
                                