<?php 

//this page will show list of all assesment of student
//you can filter either to view all student or 1 of the student assessments

    include('include/dbconnection.php');
    session_start();

    if (!isset($_SESSION['mentor_login'])) {
        header("../logout.php");
    }else{


$idmentor=$_SESSION['mentor_login'];




?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>PutraMD Mentor | List Assessments</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <!-- Include stylesheet -->
        <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
     
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>




    </head>
    
        <?php include_once('include/header.php');?>
        <?php include_once('include/sidebar.php');?>
        
                   <div id="layoutSidenav_content">
                    <main>
                    <div class="container-fluid px-4">
                        <h2 class="mt-4">List of All Student Assessments</h2>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
               
                            <li class="breadcrumb-item active">List of Assessments  </a></li>
                            
                        </ol>
                       


                        <div id="main-content">








                        <div class="row">
                            <div class="col-xl-12 ">
                                <div class="row mb-1">
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
<?php
$sql1="SELECT tblstudent_mentor.IDStudent , user.name as studentname, tblprogram.ProgramName 
FROM tblstudent_mentor 
JOIN user ON user.username = tblstudent_mentor.IDStudent
JOIN tblstudent_program ON tblstudent_program.IDStudent = tblstudent_mentor.IDStudent
JOIN tblprogram ON tblprogram.ID = tblstudent_program.IDProgram
WHERE tblstudent_mentor.IDMentor =:idmentor  AND tblstudent_mentor.Status='Approved' AND tblprogram.StartDate <= CURDATE() AND tblprogram.EndDate >= CURDATE()";
$query = $dbh -> prepare($sql1);
$query->bindParam(':idmentor',$idmentor,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

                                        $cnt=1;
                                        if($query->rowCount() > 0)
                                        {
                                        foreach($results as $row1)
                                        {

?>                                        
  <a href="stdassessment.php?id=<?php echo $row1->IDStudent; ?>"><button class="btn btn-primary rounded-pill" type="button" hr ><?php echo $row1->studentname;?> </button></a>

  <?php   }} ?>
</div>

                                          </div>
                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center ">
                                        <h5 class="card-title"><div class="d-flex justify-content-start "> All Student Assessments <div></h5>  </div>

                                    <div class="card-body">
                                        
                                        <div class="col-md-12">
<table id="datatablesSimple">



                                         <thead>
                                        <tr>
                                            <th>No</th>
                                          
                                            <th>Assessment Name</th>
                                            <th>Student Name</th>
                                            <th>Date Submit</th>
                                            <th>Date Evaluated</th>
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
                                            <th>Date Evaluated</th>
                                            <th>Status</th>
                            
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>   
                                        <?php
//select student name under sv id and save value in id_student_list[] array

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


//select assessment submission information 
$placeholder = implode(',', array_fill(0, count($id_student_list), '?'));

$sql = "SELECT tblsubmit_ass.*, tblsubmit_ass.ID AS IDSub, user.name, tblsubmit_ass.Status as ass_status, tblprogram.*
FROM tblsubmit_ass
JOIN user ON user.username = tblsubmit_ass.IDStudent
JOIN tblprogram ON tblsubmit_ass.IDProgram = tblprogram.ID
WHERE tblsubmit_ass.IDStudent IN ({$placeholder}) AND (tblsubmit_ass.Status IS NOT NULL AND tblsubmit_ass.Status <> 0) AND tblprogram.StartDate <= CURDATE() AND tblprogram.EndDate >= CURDATE()
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
$timeStamp1 = date("d/m/Y", strtotime($timeStamp));
echo htmlentities($timeStamp1); ?></td>
                                            <td><?php $timeStamp2 = $row->EvaluateDate;
$timeStamp3 = date("d/m/Y", strtotime($timeStamp2));
echo htmlentities($timeStamp3); ?></td>
                                           <td class="bg-light">

                                             <div class="status-badge">
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
</div>



                                            </td>
                                            
                                            
                                            
                                        <td>
                                                 

  <?php if ($row->ass_status == 1 || $row->ass_status == 2) { ?>
    <span><a href="evaluate-assessment.php?SubmitID=<?php echo htmlentities ($row->IDSub);?>"><i class='fas fa-pen'></i></a></span>
  <?php } elseif ($row->ass_status == 3) { ?>
    <span><a href="view-assessment.php?SubmitID=<?php echo htmlentities ($row->IDSub);?>"><i class='fas fa-eye'></i></a></span>
  <?php } ?>
      
                                                        
                                                    
                                            </td>
                                         </tr>
                                                 <?php $cnt=$cnt+1;}}}?> 

                                        </tbody>
                                </table>




                                        </div>
                                    </div>



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
