<?php 
include('include/dbconnection.php');
    session_start();

    if (!isset($_SESSION['student_login'])) {
        header("location: ../logout.php");
    }


$userid = $_SESSION['student_login'];   
$sql = "SELECT IDProgram FROM tblstudent_program WHERE IDStudent=:eid AND CURDATE() BETWEEN (SELECT StartDate FROM tblprogram WHERE ID=tblstudent_program.IDProgram) AND (SELECT EndDate FROM tblprogram WHERE ID=tblstudent_program.IDProgram)";
$query = $dbh -> prepare($sql);
$query->bindParam(':eid',$userid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{  
$idprogram=$result->IDProgram;

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
        <title>PutraMD E-Portfolio | Student's Dashboard</title>
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
                        <h1 class="mt-4">Student's Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                <main> 
                    
                    <div class="row container-fluid">
                        <div class="col-md-8">
 
<div class="row">
    <?php


$sql = "SELECT tblassessment.ID, tblassessment.AssessmentName, tblassessment.NumberofAssessment, COUNT(tblsubmit_ass.ID) as TotalSubmits
FROM tblassessment
LEFT JOIN (SELECT * FROM tblsubmit_ass WHERE IDStudent=:idstudent) tblsubmit_ass
ON tblassessment.ID = tblsubmit_ass.IDAssessment  AND tblassessment.IDProgram = tblsubmit_ass.IDProgram
WHERE tblassessment.IDProgram=:idp
GROUP BY tblassessment.ID
";
$query = $dbh -> prepare($sql);
$query->bindParam(':idp',$idprogram,PDO::PARAM_STR);
$query->bindParam(':idstudent',$userid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{  
?>

                            
                              <div class="col-md-6 ">
                                  <div class="shadow p-3 card bg-info mb-4 ">
                                    <div class="card-header bg-info"> 
                                        <i class="fa-solid fa-house-medical-circle-check"></i></div>
                                      <div class="card-body align-items-left">
                                         <label class="mb-2">You Has</label> <h4> <?php echo htmlentities($result->TotalSubmits);?>/<?php echo htmlentities($result->NumberofAssessment);?></h4>
                                          <?php echo htmlentities($result->AssessmentName);?>
                                          <a href="all-assessments.php?id=<?php echo ($result->ID);?>" class="stretched-link"></a>

                                      </div>
                                     
                                     
                                  </div>

                              </div>

<?php 
}}
?>                       


                    

                            </div>
  

                        </div>
    <?php


$sql = "SELECT ID,ProgramName,StartDate,EndDate FROM `tblprogram` WHERE ID=:idp";
$query = $dbh -> prepare($sql);
$query->bindParam(':idp',$idprogram,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{ 

$programname=$result->ProgramName;
$startdate=$result->StartDate;
$enddate=$result->EndDate; 

}}
?>

                        <div class="col-md-4"> 
                            <div class="col mb-3"> 
                            <div class="card-body ">
                                Counting Days Before end of Program
                                <div class=""><div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
<script>
//get StartDate and EndDate from tblprogram
var startDate = new Date("<?php echo $startdate; ?>");
var endDate = new Date("<?php echo $enddate; ?>");

//Calculate the difference between startDate and endDate
var totalDays = (endDate - startDate) / (1000 * 60 * 60 * 24);

//update the progress bar
setInterval(function(){
  var currentDate = new Date();
  var completedDays = (currentDate - startDate) / (1000 * 60 * 60 * 24);
  var percentage = Math.floor((completedDays / totalDays) * 100);
  var days = Math.floor(completedDays);
  var daysLeft = Math.floor(totalDays - completedDays);
  $('.progress-bar').css('width', percentage+'%').attr('aria-valuenow', percentage);
  $('.progress-bar').text(days + " days passed, " + daysLeft + " days left");
}, 1000);
</script>









  </div>
</div>

                            </div></div>
                            <div class="card mb-4">
                            <div class="card-header">
                                        <i class="fas fa-user-graduate me-1"></i>
                                        Welcome
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title">
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
                                            Welcome,<?php echo htmlentities($row->name);
                                            $_SESSION['std_name']=$row->name;
$cnt=$cnt+1;}} 


}?></h4>
                                        <p class="card-text">

 <?php     
//fetch name 
$sql = "SELECT user.name FROM tblstudent_mentor JOIN user ON user.username=tblstudent_mentor.IDMentor WHERE tblstudent_mentor.IDStudent=:id";
$stmt = $dbh->prepare($sql);
$stmt->execute(array(':id' => $eid));
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$value = $result['name'];


//fetch program name
$sql1 = "SELECT ProgramName FROM tblprogram WHERE ID = :id";
$stmt1 = $dbh->prepare($sql1);
$stmt1->execute(array(':id' => $idprogram));
$result1 = $stmt1->fetch(PDO::FETCH_ASSOC);
$namecourse = $result1['ProgramName'];


//fetch user_dp
$sql2 = "SELECT user_dp FROM user WHERE username= :idstudent";
$stmt2 = $dbh->prepare($sql2);
$stmt2->execute(array(':idstudent' => $userid));
$result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
$user_dp = $result2['user_dp'];



 
?>                                         

<img src="<?php

$default_photo_url = "../img_dir/dp.png";
  // Profile photo URL
$profile_photo_url = (empty($user_dp)) ? $default_photo_url : $user_dp;
echo "./img_dir/".$profile_photo_url; ?>" class="img-thumbnail"
  style="width: 150px;" alt="No Profile Photo" />    

                                           <br><b>Course Enroll:</b><br><?php echo $namecourse; ?></br>
                                           <b>Supervisor Name:</b><br> <?php

                                            if (stripos($value, "Dr.") === false) {
                                                        echo "Dr. " . $value;
                                                    } else {
                                                        echo $value;
                                                    }                           

?>

                                        </p>
                                        <a href="../logout.php" class="btn btn-danger">Logout</a>
                                       
                                      </div>
                                  </div></div>
                        </div>







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

                                             
                                