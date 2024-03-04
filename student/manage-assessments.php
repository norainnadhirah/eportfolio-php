<?php 
    include('include/dbconnection.php');
    session_start();

    if (!isset($_SESSION['student_login'])) {
        header("../logout.php");
    }else{

$idstudent=$_SESSION['student_login'];
//$idass=$_GET['id'];
//retrieve program id of the student enroll
$sql = "SELECT IDProgram FROM tblstudent_program WHERE IDStudent=:eid AND CURDATE() BETWEEN (SELECT StartDate FROM tblprogram WHERE ID=tblstudent_program.IDProgram) AND (SELECT EndDate FROM tblprogram WHERE ID=tblstudent_program.IDProgram)";
$query = $dbh -> prepare($sql);
$query->bindParam(':eid',$idstudent,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{  
$idprogram=$result->IDProgram;

}}  



//retrieve program and assessment information
$sqlprogram = "SELECT * from tblprogram WHERE ID=:idprogram";
$query1 = $dbh -> prepare($sqlprogram);
$query1->bindParam(':idprogram',$idprogram,PDO::PARAM_STR);
$query1->execute();
$results1=$query1->fetchAll(PDO::FETCH_OBJ);
if($query1->rowCount() > 0)
{
foreach($results1 as $row)
{  
$programname=$row->ProgramName;
$programcode=$row->ProgramCode;
$startdate=$row->StartDate;
$enddate=$row->EndDate;

}} 


}

// Code for deleting program
if(isset($_GET['delid']))
{
$rid=intval($_GET['delid']);
$sql="delete from tblsubmit_ass where ID=:rid";
$query=$dbh->prepare($sql);
$query->bindParam(':rid',$rid,PDO::PARAM_STR);
$query->execute();
?> <script>alert('Assessments deleted.'); location.href = 'all-assessments.php?id=<?php echo $idass; ?>' </script> <?php ;

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
        <title>PutraMD E-Portfolio | List Assessment</title>
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
                        <h2 class="mt-4">Assessments of <?php echo htmlentities($programname);?>(<?php echo htmlentities($programcode);?>)</h2>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                           
                            <li class="breadcrumb-item active">List of Assessments <?php echo htmlentities($programname);?>(<?php echo htmlentities($programcode);?>)</a></li>
                            
                        </ol>
                       


                        <div id="main-content">
                        <div class="row">
                            <div class="col-xl-12 ">
                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center ">
                                        <h5 class="card-title"><div class="d-flex justify-content-start "> <?php echo htmlentities($programname);?>(<?php echo htmlentities($programcode);?>)</div></h5>  
                                    
                            
                                       
         </div>
                                    <div class="card-body">
                                        <div class="col-md-12">
                                             <table id="datatablesSimple" class="table-sm">
                                    <thead>
                                      



                                        <tr>
                                            <th>Assessment</th>
                                            <th>Assessment Title </th>
                                            <th>Date Submission</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                           <th>Assessment</th>
                                            <th>Assessment Title</th>
                                            <th>Date Submission</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>   
<?php
$sql="SELECT tblsubmit_ass.ID,tblsubmit_ass.IDProgram, tblsubmit_ass.IDAssessment, tblsubmit_ass.AssSubmitTitle, tblsubmit_ass.Status, tblsubmit_ass.SubmitDate, tblassessment.AssessmentName
FROM tblsubmit_ass
JOIN tblassessment ON tblassessment.ID = tblsubmit_ass.IDAssessment
WHERE tblsubmit_ass.IDProgram = :idprogram AND tblsubmit_ass.IDStudent = :idstd";
$query = $dbh -> prepare($sql);
$query->bindParam(':idstd',$idstudent,PDO::PARAM_STR);
$query->bindParam(':idprogram',$idprogram,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{     ?>  
                                         
                                            <td><?php echo htmlentities($row->AssessmentName);?></td>
                                            <td><?php echo htmlentities($row->AssSubmitTitle);?></td>
                                          
                                            <td><?php $timeStamp = $row->SubmitDate;
                                            echo date( "d/m/Y", strtotime($timeStamp));?></td>
                                            <td class="bg-light">

                                             <div class="status-badge">
    <?php 
    $status = $row->Status;
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
</div>



                                            </td>
                                           <td class="bg-light">
    <?php if ($row->Status == 3): ?>
        <span><a href="view-completed-assessment.php?SubmitID=<?php echo htmlentities ($row->ID);?>"><i class='fas fa-eye'></i></a></span>
     <?php elseif ($row->Status == 2): ?>
        <span><a href="view-completed-assessment.php?SubmitID=<?php echo htmlentities ($row->ID);?>"><i class='fas fa-eye'></i></a></span>
    <?php elseif ($row->Status == 1): ?>
        <span><a href="view-completed-assessment.php?SubmitID=<?php echo htmlentities ($row->ID);?>"><i class='fas fa-eye'></i></a></span>        
    <?php else: ?>
        <span><a href="editsubmit-assessment.php?editid=<?php echo htmlentities ($row->ID);?>"><i class='fas fa-pen'></i></a></span>
        <span><a href="all-assessments.php?delid=<?php echo ($row->ID);?>"  onclick="return confirm('Do you really want to Delete the assessment?');"><i class="fa fa-trash"></i></a></span>
    <?php endif; ?>
</td>
                                            
                                        </tr>
                                       <?php $cnt=$cnt+1;}} ?> 
                                    </tbody>
                                </table>




                                        </div>
                                    </div>



                                </div>
                            </div>
</form>


                     
                        
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
