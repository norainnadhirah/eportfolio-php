
<?php

//call id detail of student_mentor table = stsvid
//Supervisor to confirm if he agree to be supervisor to the student
// show student details email phone number photo 

session_start();
error_reporting(0);
include('include/dbconnection.php');

 if (strlen($_SESSION['mentor_login'])==0) {
header('location:index.php');}

else{

 // code for update the read notification status
$isread=1;
$did=intval($_GET['stsvid']);  
$sql="update  tblstudent_mentor set IsRead=:isread where id=:did";
$query = $dbh->prepare($sql);
$query->bindParam(':isread',$isread,PDO::PARAM_STR);
$query->bindParam(':did',$did,PDO::PARAM_STR);
$query->execute();


// code for action taken on leave
if(isset($_POST['submit']))
{ 
$did=intval($_GET['stsvid']);
$status=$_POST['status'];   


$sql="update tblstudent_mentor set Status=:status, DescriptionNotApproved=:DescriptionNotApproved where id=:did";
$query = $dbh->prepare($sql);

$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':DescriptionNotApproved',$DescriptionNotApproved,PDO::PARAM_STR);
$query->bindParam(':did',$did,PDO::PARAM_STR);
$query->execute();
$msg="Application updated Successfully";



}
   


$did=intval($_GET['stsvid']); 
$sql = "SELECT tblstudent_mentor.ID as StSvID,user.name,user.username, user.user_dp, user.email, user.notel, user.regdate,tblstudent_mentor.DateAsssigned ,tblstudent_mentor.Status from tblstudent_mentor join user on tblstudent_mentor.IDStudent=user.username where tblstudent_mentor.ID=:did";
$query = $dbh -> prepare($sql);
$query->bindParam(':did',$did,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $row)
{             

$name=($row->name);
$matricnumber=($row->username);
$user_dp=($row->user_dp);
$default_photo_url = "../img_dir/dp.png";


  // Profile photo URL
  $profile_photo_url = (empty($user_dp)) ? $default_photo_url : $user_dp;


 ?>


    <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>PutraMD: Student Details</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    
        <?php include_once('include/header.php');?>
        <?php include_once('include/sidebar.php');?>
        
                   <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                           <h1 class="mt-4">Student's Details</h1>
                        <h1 class="mt-4"></h1>
               

                <main>


    <div class="row">
      <div class="col-lg-12">
<?php if($msg){?><div class="alert alert-success"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
        <div class="card mb-2">
          <div class="card-body text-center">
       
            <img src="../student/img_dir/<?php echo $profile_photo_url; ?>"  class="img-thumbnail"
  style="width: 150px;" alt="No Profile Photo">
            
              
            <h5 class="my-3"><?php  echo htmlentities($row->name);?></h5>
   
          
          </div>
        </div>

        <div class="col-lg-12">
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Full Name</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php  echo htmlentities($row->name);?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Matric Number</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php  echo htmlentities($row->username);?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Email</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php  echo htmlentities($row->email);?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Phone</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php  echo htmlentities($row->notel);?></p>
              </div>
            </div>
            
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Date Register</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php   $timeStamp = $row->regdate;
                                                            $timeStamp1 = date( "m/d/Y", strtotime($timeStamp));
                                                            echo $timeStamp1
                                                           

                                                            ?></p>
              </div>
            </div>
            <hr>
              <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Date Applied</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php   $timeStamp2 = $row->DateAsssigned;
                                                            $timeStamp3 = date( "m/d/Y", strtotime($timeStamp2));
                                                            echo $timeStamp3
                                                           

                                                            ?></p>
              </div>
            </div>

                        <hr>
              <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Status of Application</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php   echo htmlentities($row->Status); 
                $status=$row->Status;       

                                                            ?></p>
              </div>
            </div>

            <hr>
              <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Reason</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php   echo htmlentities($row->DescriptionNotApproved);        

                                                            ?></p>
              </div>
            </div>

            <hr>
            


            <div class="row">
              <div class="col-sm-3">
                
               
                 <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" <?php if ($status == "Approved") echo 'style="display: none;"'; ?>>Take Action</button  >

              </div>
              <div class="col-sm-9">
                
              </div>
            </div>

          </div>
        </div>


     
</div>
                               


                                            
<?php $cnt=$cnt+1;}} 


}
?> 



<script>
  function showInput() {
    var status = document.getElementById("status");
    var selected = status.options[status.selectedIndex].value;
    if (selected === "Not Approved") {
      document.getElementById("reasonGroup").style.display = "block";
    } else {
      document.getElementById("reasonGroup").style.display = "none";
    }
  }
</script>
                        
                                
       <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"><p>Do you accept <b><?php echo htmlentities($name);?> (<?php echo htmlentities($matricnumber);?>)</b> as your student?</p>
                <div class ="">     
<form method="post" name="hjhgh" >
  
     <select class="form-select form-select-lg mb-3" id="status" onchange="showInput()" name="status"  required="">
                                           <small> <option value="">Choose your option</option>
                                            <option value="Approved">Approved</option>
                                            <option value="Not Approved">Not Approved</option>
                                        </select></p></small>

 

<div class="form-group" id="reasonGroup" style="display:none">
      <label for="reason">Reason:</label>
      <input type="text" class="form-control" id="reason" name="DescriptionNotApproved">
    </div>


            <div class="modal-footer">



                <button class="btn btn-primary " type="submit" name="submit">Submit</button></div></form>
        </div>
    </div>
</div>                     
                                
<script>
 
</script>




                            




                </main>
                 
                        
              </main>
                <?php
                include_once('include/footer.php');
                ?>
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
                                             
                                