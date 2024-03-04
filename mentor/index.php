<?php 
include('include/dbconnection.php');
    session_start();

    if (!isset($_SESSION['mentor_login'])) {
        header("location: ../logout.php");
    }

$idmentor=$_SESSION['mentor_login'];

?>

<!DOCTYPE html>
<html lang="en">
      <head>
      <meta http-equiv="Content-Security-Policy" content="style-src 'self' 'unsafe-inline'">

        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>PutraMD E-Portfolio | Supervisor Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <!--Datatable plugin CSS file -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" />
  
    <!--jQuery library file -->
    <script type="text/javascript"  src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!--Datatable plugin JS library file -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    
        <?php include_once('include/header.php');?>
        <?php include_once('include/sidebar.php');?>
        
        
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4 text-info">Supervisor's Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                          
                        </ol>

                <main>                    
                    <div class="row container-fluid">
  
                      <div class="col-md-8">
                         <div class="row">


                             <h4 class="mt-4 mb-3">Student Progress</h4>
<?php

$student_sql="SELECT IDStudent FROM `tblstudent_mentor` WHERE IDMentor=:idmentor AND Status='Approved'";  

$query = $dbh -> prepare($student_sql);
$query->bindParam(':idmentor',$idmentor,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
$id_student_list = array();
if($query->rowCount() > 0)
{
    foreach($results as $row)
    { 
        $id_student_list[] = $row->IDStudent;
    }
}


$program_sql = "SELECT tblstudent_program.IDProgram, user.name, tblstudent_program.IDStudent 
FROM tblstudent_program 
JOIN user ON user.username = tblstudent_program.IDStudent 
WHERE tblstudent_program.IDStudent IN (".implode(",",$id_student_list).") 
AND CURDATE() BETWEEN (SELECT StartDate FROM tblprogram WHERE ID=tblstudent_program.IDProgram) 
AND (SELECT EndDate FROM tblprogram WHERE ID=tblstudent_program.IDProgram)";

$program_query = $dbh->prepare($program_sql);
$program_query->execute();
$program_results = $program_query->fetchAll(PDO::FETCH_OBJ);

if ($program_query->rowCount() > 0) {
  foreach ($program_results as $program_row) {
    echo '<div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body"> ' . $program_row->name;


                                   ?>
                                     </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="stdassessment.php?id=<?php echo $program_row->IDStudent; ?>"> 
                                   
                                   <?php 

     $sql_ttlsubmission = "SELECT COUNT(IDStudent) as 'totalsubmit' FROM tblsubmit_ass WHERE IDStudent = :idstudent AND IDProgram = :idprogram";
$ttlsubmission_query = $dbh->prepare($sql_ttlsubmission);
$ttlsubmission_query->bindParam(':idstudent', $program_row->IDStudent, PDO::PARAM_STR);
$ttlsubmission_query->bindParam(':idprogram', $program_row->IDProgram, PDO::PARAM_STR);
$ttlsubmission_query->execute();
$ttlsubmission_results = $ttlsubmission_query->fetch(PDO::FETCH_OBJ);

if ($ttlsubmission_query->rowCount() > 0) {
  echo $ttlsubmission_results->totalsubmit;
} else {
  echo 0;
}
?>

</a>
                                        
                                    </div>
                                </div>
                            </div>
 <?php  

  }
}
                     ?></div>

                            





                  


           <div class="card mb-4">
                                    <div class="card-header"> 
                                        <i class="fa fa-users me-1"></i> List Submitted Assessment</div>
                                        <div class="card-body">
                                            <table id="datatablesSimple" >
                                                <script>
$(document).ready(function() {
  $('#datatablesSimple').DataTable({
    "order": [[4, "desc"]]
  });
});
</script>


                                         <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Assessment Name</th>
                                            <th>Student Name</th>
                                            <th>Date Submit</th>
                                            <th>Date Evaluation</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            
                                            <th>Assessment Name</th>
                                            <th>Student Name</th>
                                            <th>Date Submit</th>
                                            <th>Date Evaluation</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>   
                                        <?php
$placeholder = implode(',', array_fill(0, count($id_student_list), '?'));

$sql = "SELECT tblsubmit_ass.*, tblsubmit_ass.ID AS IDSub, user.name, tblsubmit_ass.Status as ass_status, tblprogram.*
FROM tblsubmit_ass
JOIN user ON user.username = tblsubmit_ass.IDStudent
JOIN tblprogram ON tblsubmit_ass.IDProgram = tblprogram.ID
WHERE tblsubmit_ass.IDStudent IN ({$placeholder}) AND tblsubmit_ass.Status IS NOT NULL AND tblsubmit_ass.Status <> 0 AND tblprogram.StartDate <= CURDATE() AND tblprogram.EndDate >= CURDATE()
ORDER BY tblsubmit_ass.SubmitDate DESC
";

$query= $dbh->prepare($sql);
$query->execute($id_student_list);
$results=$query->fetchAll(PDO::FETCH_OBJ);

                                        $cnt=1;
                                        if($query->rowCount() > 0)
                                        {
                                        foreach($results as $row)
                                        {     ?>       
                                            
                                            <td><?php echo htmlentities($cnt);?></td>
                                            <td><?php echo htmlentities($row->AssSubmitTitle);?></td>
                                            <td><?php echo htmlentities($row->name);?></td>
                                            <td><?php $timeStamp = $row->SubmitDate;
$timeStamp1 = date("d/m/Y h:i a", strtotime($timeStamp));
echo htmlentities($timeStamp1); ?></td>
<td><?php $timeStamp2 = $row->EvaluateDate;
if ($timeStamp2) {
  $timeStamp3 = date("d/m/Y", strtotime($timeStamp2));
  echo htmlentities($timeStamp3);
} else {
  echo "-";
}
?></td>
                                            

                                             <td><div class="status-badge">
    <?php 
    $status = $row->ass_status;
    switch($status) {
        case 0:
            echo '<span class="badge rounded-pill bg-warning">Draft</span>';
            break;
        case 1:
            echo '<span class="badge rounded-pill bg-info">Submitted</span>';
            break;
        case 2:
            echo '<span class="badge rounded-pill bg-success">Received by Supervisor</span>';
            break;
        case 3:
            echo '<span class="badge rounded-pill bg-primary">Evaluated</span>';
            break;
        default:
            echo '<span class="badge rounded-pill bg-warning">Draft</span>';
    } 
    ?>
</div>   </td>
                           <td>
                                                 

  <?php if ($row->ass_status == 1 || $row->ass_status == 2) { ?>
    <span><a href="evaluate-assessment.php?SubmitID=<?php echo htmlentities ($row->ID);?>">Evaluate</a></span>
  <?php } elseif ($row->ass_status == 3) { ?>
    <span><a href="view-assessment.php?SubmitID=<?php echo htmlentities ($row->ID);?>">View</i></a></span>
  <?php } ?>
                            
                               </td>
                                </tr>
                                                 <?php $cnt=$cnt+1;}} ?> 

                                </tbody>
                                </table>

                                    </div>
                                    </div>
                                </div>

                                              <!----welcome card---->
                        <div class="col-md-4 d-flex"> 
                            <div class="card mb-4">
                            <div class="card-header">
                                        <i class="fas fa-user-graduate me-1"></i>
                                        Welcome
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title">

<?php

if(isset($_SESSION['mentor_login'])) {

$eid=$_SESSION['mentor_login'];
$sql="SELECT * from user where username=:eid";
$query = $dbh -> prepare($sql);

// Bind the parameters
$query->bindParam(":eid", $eid);

// Execute the statement
$query->execute();

$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
 {
foreach($results as $row)
{         ?>
Welcome, <?php
 
    $name = $row->name;
    if (stripos($name, "Dr.") === false) {
        echo "Dr. " . $name;
    } else {
        echo $name;
    }
}} }?>
                                        
                                        <p class="card-text">
                                           <?php     



$sql2 = "SELECT * FROM user WHERE username= :id";
$stmt2 = $dbh->prepare($sql2);
$stmt2->execute(array(':id' => $eid));
$result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
$user_dp = $result2['user_dp'];
 
?>                                         

<img src="<?php

$default_photo_url = "../img_dir/dp.png";
  // Profile photo URL
$profile_photo_url = (empty($user_dp)) ? $default_photo_url : $user_dp;
echo './img_dir/'.$profile_photo_url; ?>" class="img-thumbnail"
  style="width: 150px;" alt="No Profile Photo" />   

   <a href="../logout.php" class="btn btn-danger">Logout</a> 

                             
                    </div>  </div>

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

                                             
                                