<?php 
include('include/dbconnection.php');
    session_start();

    if (!isset($_SESSION['student_login'])) {
        header("location: index.php");
    }
else{
if(isset($_POST['submit']))
{

$image= $_FILES["user_dp"]["name"];
move_uploaded_file($_FILES["user_dp"]["tmp_name"],"img_dir/".$_FILES["user_dp"]["name"]);

$pstid=$_SESSION['student_login'];  
$pemail=$_POST['email'];   
$pnotel=$_POST['notel'];
$pidmentor=$_POST['IDMentor'];
$puser_dp=$image;
$pisRead=0;
$status="In process";


$sql="update user set email=:pemail,notel=:pnotel,user_dp=:puser_dp where username=:pstid";
$sql2="INSERT INTO tblstudent_mentor(IDMentor, IDStudent, status, IsRead) VALUES
             (:pidmentor, :pstid, :status,:pisRead)";

$query = $dbh->prepare($sql);
$query->bindParam(':pstid',$pstid,PDO::PARAM_STR);
$query->bindParam(':pemail',$pemail,PDO::PARAM_STR);
$query->bindParam(':pnotel',$pnotel,PDO::PARAM_STR);
$query->bindParam(':puser_dp',$puser_dp,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();


$query2 = $dbh->prepare($sql2);
$query2->bindParam(':pidmentor',$pidmentor,PDO::PARAM_STR);
$query2->bindParam(':pstid',$pstid,PDO::PARAM_STR);
$query2->bindParam(':status',$status,PDO::PARAM_STR);
$query2->bindParam(':pisRead',$pisRead,PDO::PARAM_STR);
$query2->execute();
$lastInsertId = $dbh->lastInsertId();


echo "<script>alert('Data Update');</script>"; 
  echo "<script>window.location.href = '../student/waiting.php?editid=<?php echo $pstid;?>'</script>";   
 







}}

  
    
$eid=$_SESSION['student_login'];

                        $sql="SELECT * from user where username=$eid";
                        $query = $dbh -> prepare($sql);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);

                        $cnt=1;
                        if($query->rowCount() > 0)
                        {
                        foreach($results as $row)
                        {               ?>



<!-- Modal for Success Insert -->
<div class="modal fade" id="modalsuccess" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Success</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">Information successfully updated!</div> 
                <a href="index.php" class="btn btn-primary">Go to Next Page</a></div></form>
        </div>
    </div>
</div>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>First Time Login</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>

    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
             <img src="../assets/img/upmlogo.png" class="position-relative" width="80" height=""><a class="navbar-brand ps-3" href="index.php">PUTRAMD E-PORTFOLIO</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"></i></button>
           
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                 
                        <li><a class="dropdown-item" href="#!">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            
           



            <div id="layoutSidenav_content">
                <main>
                   <div class="row container-fluid">
                        <div class="col-md-8">
                            
                            </div>

<!----Complete Registration---->


                               <div class="col-md-12"> <div class="card mb-4">
                                    <div class="card-header">

 <form method="post" name="hjhgh" enctype="multipart/form-data">
 <?php if(isset($_SESSION['student_login'])) {

$eid=$_SESSION['student_login'];
$sql="SELECT * from user where username=$eid";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
 {
foreach($results as $row)
{         ?>
                                           

                                        <b> Welcome, <?php echo htmlentities($row->name);?></b>

                                        <?php $cnt=$cnt+1;}} 


}?>




                                        </div>
                                        <div class="card-body">
                                        <p class="card-text">Complete your registration and select your supervisor to continue this page.</p>

                                        <p>
                                            <img src="<?php
$user_dp=($row->user_dp);
$default_photo_url = "../img_dir/dp.png";


  // Profile photo URL
$profile_photo_url = (empty($user_dp)) ? $default_photo_url : $user_dp;

                                             echo $profile_photo_url; ?>" class="rounded-circle shadow-4"
  style="width: 150px;" alt="No Profile Photo" />

                                                <div class="col-md-4 py-4">
                                                    <label for="formFile" class="form-label">Upload profile photo:</label>
                                                    <input class="form-control" type="file" name="user_dp" id="user_dp"  accept="image/png, image/jpeg">
                                                </div>
                                               




                                        
                                        <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" type="text" value="<?php  echo htmlentities($row->name);?>" placeholder="name" name="name" disabled />
                                                        <label for="">Name</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input class="form-control" placeholder="Program code" value="<?php   $timeStamp = $row->regdate;
                                                            $timeStamp1 = date( "m/d/Y", strtotime($timeStamp));
                                                            echo $timeStamp1
                                                           

                                                            ?>" name="programcode" disabled/>
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

                                            
<?php $cnt=$cnt+1;}} 

?> 
                              
                                        </p>
<div class="col-md-6">
                                                        <label for="">Select your Supervisor</label>
                                                    <div class="form-floating mb-3 mb-md-0">

                                                         <select class="form-control" name="IDMentor" id="IDMentor"  required="true">
                                                            <option value="">Supervisor Name(ID)</option>
<?php
$sql="SELECT * from user where role='Supervisor' AND Status='1'";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
        
                                                            <option value="<?php  echo htmlentities($row->username);?>"><?php  echo htmlentities($row->name);?>(<?php  echo htmlentities($row->username);?>)</option><?php $cnt=$cnt+1;}} ?>
        </select>
                                                    </div>
                                                </div>




                       
                        </div>


                         <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Submit</button>
                                <button class="btn btn-default btn-lg sbmt-btn" type="reset">Reset</button>
                                                    </div>
                                                </div>
                                            </div>




<div class="row mb-3">
    <div class="col-md-6"></div>

        <div class="col-md-6">
        
          <!-- Button trigger modal -->

<div class="row">
                                                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                                        
                                                     
                                                </div>
                                                
                                            </div>
            



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">Are you sure with the information you will submit?</div> 
            <div class="modal-footer"><button class="btn btn-secondary" type="button" data-bs-dismiss="modal">No</button>
                <button class="btn btn-default bg-info sbmt-btn" type="submit" name="submit">Yes</button></div></form>
        </div>
    </div>
</div>
    </div>
    

</div>

                                          

                        </div>


                    </div>







                </main>
               
                              
                
            </div>
        </div>
            
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
