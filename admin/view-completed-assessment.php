<?php 
    include('include/dbconnection.php');
    session_start();

    if (!isset($_SESSION['admin_login'])) {
        header("../logout.php");
    }else{




// code for update the read notification status
$isread=1;
$did=intval($_GET['SubmitID']);
$sql="update  tblsubmit_ass set stdIsRead=:isread where id=:did";
$query = $dbh->prepare($sql);
$query->bindParam(':isread',$isread,PDO::PARAM_STR);
$query->bindParam(':did',$did,PDO::PARAM_STR);
$query->execute();         

$SubmitID=$_GET['SubmitID'];
$idstudent=$_SESSION['upmid'];




//get assessment ID
$sql = "SELECT IDAssessment FROM tblsubmit_ass WHERE ID=:submitid";
$query = $dbh -> prepare($sql);
$query->bindParam(':submitid',$SubmitID,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{  
$idassessment=$result->IDAssessment;

}}

//retrieve Program Course ID and Assessment Name
$sql = "SELECT IDProgram,AssessmentName FROM tblassessment WHERE ID=:id";
$query = $dbh -> prepare($sql);
$query->bindParam(':id',$idassessment,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{  
$idprogram=$result->IDProgram;
$ass_name=$result->AssessmentName;

}}




?>




<!DOCTYPE html>
<html lang="en">
 <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>PutraMD E-Portfolio | View Completed Assessment</title>
          <<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <!--Datatable plugin CSS file -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" />
    <!--jQuery library file -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <!--Datatable plugin JS library file -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    
        <?php include_once('include/header.php');?>
        <?php include_once('include/sidebar.php');?>
        
                   <div id="layoutSidenav_content">
                    <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4"><?php echo htmlentities($ass_name);?></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                             <li class="breadcrumb-item"><a href="manageuser.php">Manage User</a></li>
                            <li class="breadcrumb-item"><a href="edit-user.php?editid=<?php echo $userid; ?>">Edit User</a></li>
                            <li class="breadcrumb-item active"><a href="student-archive.php?id=<?php echo $idstudent; ?>">Archive</a></li>
                            <li class="breadcrumb-item active"><a href="sub-assessments.php?id=<?php echo $idassessment;?>"> <?php echo htmlentities($ass_name);?></a></li>
                            
                        </ol>
                       


                        <div id="main-content">
                        <div class="row">
                            <div class="col-xl-12 ">
                                <div class="card mb-4">

                                     <?php
                                        $sql="SELECT tblsubmit_ass.*, user.name FROM tblsubmit_ass JOIN user ON tblsubmit_ass.IDStudent = user.username WHERE tblsubmit_ass.ID=:id";
                                        $query = $dbh -> prepare($sql);
                                        $query->bindParam(':id',$SubmitID,PDO::PARAM_STR);
                                        $query->execute();
                                        $results=$query->fetchAll(PDO::FETCH_OBJ);

                                        $cnt=1;
                                        if($query->rowCount() > 0)
                                        {
                                        foreach($results as $row)
                                        {     ?>  
                                     <form method="post" name="hjhgh" enctype="multipart/form-data">
                                    <div class="card-body">
                                     <div class="col-md-12">

                                         <div class="col-lg-8">
        <div class="card mb-4 bg-light">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Assessment's Title:</p>
              </div>
              <div class="col-sm-9">
                <p class="mb-0"><b><?php echo htmlentities($row->AssSubmitTitle); ?></b></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Submit By:</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><b><?php echo htmlentities($row->name); ?></b></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Matric Number:</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><b><?php echo htmlentities($row->IDStudent); ?></b></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Submit Date:</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><b><?php $timeStamp = $row->SubmitDate;
$timeStamp1 = date("m/d/Y H:i a", strtotime($timeStamp));
echo htmlentities($timeStamp1); ?></b></p>
              </div>
            </div>
                        <hr>
                        <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Date of Evaluation:</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><b><?php $timeStamp = $row->EvaluateDate;
$timeStamp2 = date("m/d/Y H:i a", strtotime($timeStamp));
echo htmlentities($timeStamp2); ?></b></p>
              </div>
            </div>
<hr>

            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">File Name:</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><b><?php echo htmlentities($row->AssessmentFile); ?></b></p>
              </div>
            </div>
            </div>
        </div>
                                        


<div class="col-md-12 d-flex align-items-center mb-4">
    <div class="col-md-12 ">
<?php
$file = $row->AssessmentFile;
$ext = pathinfo($file, PATHINFO_EXTENSION);
if(!empty($file) && ($ext == 'pdf' || $ext == 'doc')) {
    echo '<iframe src="../student/ass_upload/'.$file.'" width="700" height="900"></iframe>';
} else {
    echo '<alert class="text-info">Invalid file format or No document found.</alert>';
}
echo $file;
?>




   

</div></div>
<div class="card bg-light mb-3">
  <div class="card-header bg-info">Student's Reflection:</div>
  <div class="card-body">
    <?php echo $row->Student_Reflection; ?>
  </div>
</div>                                      <div class="col-md-12 mb-4">
                                             <div class="form-floating">  
                                    <div class="card bg-light mb-3">
  <div class="card-header bg-info">Supervisor's Reflection:</div>
  <div class="card-body">
    <?php echo $row->Mentor_Evaluation; ?>
  </div>
</div>  

                                      </div> </div> 

                                         </div>






                                   <?php } } }


                                 ?> </div>



                                </div>
                            </div>







</form>


                     
                        
                    </div>
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
