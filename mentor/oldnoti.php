<?php 
include('include/dbconnection.php');
    session_start();

    if (!isset($_SESSION['mentor_login'])) {
        header("location: ../logout.php");
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
        <title>Supervisor Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    
        <?php include_once('include/header.php');?>
        <?php include_once('include/sidebar.php');?>


        
        
            <div id="layoutSidenav_content">


           


                                

                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Notification</h1>
                        <ol class="breadcrumb mb-4">
                         
                        </ol>

                <main> 
                    

<ul class="list-group list-group-light">
  <?php 
$isread=0;
$status=1;
$sql = "SELECT tblstudent_mentor.ID as StSvID,user.name,user.username,tblstudent_mentor.DateAsssigned from tblstudent_mentor join user on tblstudent_mentor.IDStudent=user.username where tblstudent_mentor.IDMentor=:idmentor 
ORDER BY tblstudent_mentor.DateAsssigned DESC";
$query = $dbh -> prepare($sql);
$query->bindParam(':idmentor',$idmentor,PDO::PARAM_STR);
//$query->bindParam(':isread',$isread,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{             

 $timeStamp = $result->DateAsssigned;
$timeStamp1 = date("m/d/Y H:i a", strtotime($timeStamp)); ?>  
  <li class="list-group-item d-flex justify-content-between align-items-center">
    <div>
      <div class="fw-bold"><?php echo htmlentities($result->name);?>(<?php echo htmlentities($result->username);?>)</div>
      <div class="text-muted">choose you as supervisor <span>at <b><?php echo htmlentities($timeStamp1);?></b></div>
    </div>
    <a href="confirm-mentor.php?stsvid=<?php echo htmlentities($result->StSvID);?>" class="stretched-link">View</a>
  </li><?php }} ?>

  <?php 
$isread=0;
$sql = "SELECT tblsubmit_ass.ID as SubmitID,user.name,user.username,tblsubmit_ass.SubmitDate from tblsubmit_ass join user on tblsubmit_ass.IDStudent=user.username where tblsubmit_ass.IDMentor=:idmentor
ORDER BY tblsubmit_ass.SubmitDate DESC";
$query = $dbh -> prepare($sql);
$query->bindParam(':idmentor',$idmentor,PDO::PARAM_STR);
//$query->bindParam(':isread',$isread,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{             

 $timeStamp = $result->SubmitDate;
$timeStamp1 = date("m/d/Y H:i a", strtotime($timeStamp)); ?>  
  <li class="list-group-item d-flex justify-content-between align-items-center">
    <div>
      <div class="fw-bold"><?php echo htmlentities($result->name);?>(<?php echo htmlentities($result->username);?>)</div>
      <div class="text-muted">has submit an assessment at <span>at <b><?php echo htmlentities($timeStamp1);?></b></div>
    </div>
    <a href="evaluate-assessment.php?SubmitID=<?php echo htmlentities($result->SubmitID);?>" class="stretched-link">View</a>
  </li><?php }} ?>

</ul>




</div>

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

                                             
                                