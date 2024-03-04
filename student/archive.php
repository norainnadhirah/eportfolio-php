<?php 
    include('include/dbconnection.php');
    session_start();

    if (!isset($_SESSION['student_login'])) {
        header("../logout.php");
    }else{




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
        <title>PutraMD Student | Archive</title>
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
                        <h2 class="mt-4">Student Archive</h2>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Archive</a></li>
                            
                        </ol>
                       


                        <div id="main-content">
             <main>
              <div class="h2"><?php echo  $_SESSION['std_name']; ?>'s Archive.</div>
<?php
$idstudent=$_SESSION['student_login'];
$sql = "SELECT tblstudent_program.*, tblprogram.*
FROM tblstudent_program
JOIN tblprogram ON tblstudent_program.IDProgram = tblprogram.ID
WHERE tblprogram.StartDate > CURDATE() OR tblprogram.EndDate < CURDATE()
AND tblstudent_program.IDStudent = :idstd";
$query = $dbh -> prepare($sql);
$query->bindParam(':idstd',$idstudent,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
 $cnt=1;
           if($query->rowCount() > 0)
           {
       foreach($results as $row)
            { 
              $idprogram=$row->IDProgram;
             ?>

                             <div class="card border-success mb-3" style="max-width: 60rem;">
                               
                                <div class="card-body">
                                  <h5 class="card-title text-success"><?php echo htmlentities($row->ProgramName) ?> (<?php echo htmlentities($row->ProgramCode) ?>)<a href="archived-assessment.php?id=<?php echo $row->ID; ?>" ></a></h5>
                                    <h6><?php echo "Start date: " .date("d/m/Y", strtotime($row->StartDate));
 ?> - <?php echo "End date: " .date("d/m/Y", strtotime($row->EndDate)); ?></h6>
                                  <p class="card-text">Archived Assessment:</p>

                                   <div class="list-group">
                               
                                  <?php
$idstudent=$_SESSION['student_login'];
$sql = "SELECT tblstudent_program.*, tblassessment.*, tblassessment.ID AS IDAss
FROM tblstudent_program
JOIN tblprogram ON tblstudent_program.IDProgram = tblprogram.ID
JOIN tblassessment ON tblstudent_program.ID = tblassessment.IDProgram
WHERE tblstudent_program.IDStudent = :idstd AND tblassessment.IDProgram=:idprogram";
$query = $dbh -> prepare($sql);
$query->bindParam(':idstd',$idstudent,PDO::PARAM_STR);
$query->bindParam(':idprogram',$idprogram,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
           if($query->rowCount() > 0)
           {
            foreach($results as $row1){
              ?>
              <a href="all-assessments.php?id=<?php echo $row1->IDAss; ?>" class="list-group-item list-group-item-action"><?php echo $row1->AssessmentName; ?></a>
             
            <?php }} 
            else {
echo "<p class='fst-italic'>No archived assessment found.</p>";
}
?>  </div>



</div>
                              </div>
<?php }} ?>






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
