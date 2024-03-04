<?php 
session_start();
error_reporting(0);
include('include/dbconnection.php');

 if (strlen($_SESSION['student_login'])==0) {
  header("location: logout.php");
    exit();
}


   

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>PutraMD: Edit Profile</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    
        <?php include_once('include/header.php');?>
        <?php include_once('include/sidebar.php');?>
        
                   <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Edit User Profile</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Profile</a></li>
                            
                        </ol>
                        


                <main>
<?php $eid=$_SESSION['student_login'];

                        $sql="SELECT * from user where username=:eid";
                        $query = $dbh -> prepare($sql);
                        $query->bindParam(':eid',$eid,PDO::PARAM_STR);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);

                        $cnt=1;
                        if($query->rowCount() > 0)
                        {
                        foreach($results as $row)
                        {      


 $cnt=$cnt+1;}} 

?> 

                        

       

                  <div class="card mb-4">
                            <div class="card-header">
                                <i class="fa-solid fa-lock me-1"></i>
                                Change Password
                            </div>
                            <div class="card-body">
                             
                                    <div class="form-floating mb-3">
                                            <input class="form-control" type="password" id="oldPassword" placeholder="Password" onkeyup='checkpass();' />
                                            <label for="password">Older Password</label>
                                            <span id='checkoldpass'></span>
                                        </div>

                                <div class="form-floating mb-3">
                                    <script>
    var checkpass= function checkOldPassword() {
    var oldPassword = document.getElementById("oldPassword").value;
    var actualPassword = "<?php echo $row->password; ?>";

    if (oldPassword != actualPassword) {
      document.getElementById('checkoldpass').style.color = 'red';
            document.getElementById('checkoldpass').innerHTML = 'Wrong old password';
    } else {
       document.getElementById('checkoldpass').style.color = 'green';
            document.getElementById('checkoldpass').innerHTML = 'Match with older password';
    }
  }
                                        
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

                    </main>
          
                        
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

}
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

                                             
                                