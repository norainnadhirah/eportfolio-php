<?php 

include('include/dbconnection.php');
    session_start();

    if (!isset($_SESSION['admin_login'])) {
        header("../logout.php");}

    else{
    if(isset($_POST['submit']))
  {
$eid=$_GET['editid'];
$Pname=$_POST['programname'];
 $Pcode=$_POST['programcode'];

 $Sdate=$_POST['startdate'];
 $Edate=$_POST['enddate'];
$sql="update tblprogram set ProgramName=:programname, ProgramCode=:programcode,StartDate=:startdate, EndDate=:enddate where ID=:eid";
$query=$dbh->prepare($sql);
$query->bindParam(':programname',$Pname,PDO::PARAM_STR);
$query->bindParam(':programcode',$Pcode,PDO::PARAM_STR);

$query->bindParam(':startdate',$Sdate,PDO::PARAM_STR);
$query->bindParam(':enddate',$Edate,PDO::PARAM_STR);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
 $query->execute();

    echo '<script>alert("Detail has been updated.")</script>';
}

  }


// remove student
if(isset($_GET['delid']))
{
$rid=intval($_GET['delid']);
$sql="update tblstudent_program set deleted='1' where ID=:rid";
$query=$dbh->prepare($sql);
$query->bindParam(':rid',$rid,PDO::PARAM_STR);
$query->execute();
 echo "<script>alert('student is remove');</script>"; 
  echo "<script>window.location.href = 'edit-program.php'</script>";     


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
        <title>PutraMD E-Portfolio | Edit Course Program</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <!--Datatable plugin CSS file -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" />
  
    <!--jQuery library file -->
    <script type="text/javascript" 
        src="https://code.jquery.com/jquery-3.5.1.js">
    </script>
  
    <!--Datatable plugin JS library file -->
    <script type="text/javascript" 
src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js">
    </script
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    
        <?php include_once('include/header.php');?>
        <?php include_once('include/sidebar.php');?>
        
                   <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Edit Course Program</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="manageprogram.php">Manage Program</a></li>
                            <li class="breadcrumb-item active">View and Update Course Program</li>
                        </ol>

<?php $eid=$_GET['editid'];
                        $sql="SELECT * from tblprogram where ID=$eid";
                        $query = $dbh -> prepare($sql);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);

                        $cnt=1;
                        if($query->rowCount() > 0)
                        {
                        foreach($results as $row)
                        {   

                        $namecourse=$row->ProgramName;

                                    ?>


                        <div id="main-content">
                    <div class="row">
                        <div class="col-md-">
                            <div class="card alert">
                                <div class="card-header pr">
                                    <h4>EDIT  <?php  echo htmlentities($row->ProgramName);?></h4>
                                    <form method="post" name="hjhgh">

                                        

                                        <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" type="text" value="<?php  echo htmlentities($row->ProgramName);?>" placeholder="Program name" name="programname" required="true" />
                                                        <label for="">Program Name</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input class="form-control" placeholder="Program code" value="<?php  echo htmlentities($row->ProgramCode);?>" name="programcode" required="true"  />
                                                        <label for="">Program Code</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input type="date" class="form-control border-none input-flat bg-ash" name="startdate" required="true" value="<?php echo htmlentities($row->StartDate); ?>">
                                                        <label for="date">Start Date Of Program</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input class="form-control" placeholder="Program code" value="<?php  echo htmlentities($row->EndDate); ?>"
                                                                name="enddate" type="date"  required="true"  />
                                                        <label for="date">End Date Of Program</label>
                                                    </div>
                                                </div>
                                            </div>

                                           <?php $cnt=$cnt+1;}} ?> 
                                <button class="btn btn-default bg-info sbmt-btn" type="submit" name="submit">Update</button>
                                <button class="btn btn-default btn-lg sbmt-btn" type="reset">Reset</button> 
                            </form>
                            </div>
                        </div>


                     
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                
                               
                            <div class="d-flex justify-content-between"><i class="fa fa-book me-1"></i>ASSESSMENTS UNDER <?php echo $namecourse; ?><a href="newassessment.php"><button type="button"  class="btn btn-info">Create Assessment</button></a></div></div>
                            <div class="card-body">
                               <table id="" class="display">



                                         <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Assessment Name</th>
                                   
                                            <th>Number of Submission</th>
                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        <tr>   
                                        <?php
                                        $sql="SELECT tblprogram.ProgramName as coursename, tblprogram.ID, tblassessment.AssessmentName, tblassessment.ID as IDass ,tblassessment.NumberofAssessment FROM tblassessment JOIN tblprogram on tblprogram.ID=tblassessment.IDProgram WHERE tblassessment.IDProgram=:eid";
                                        $query = $dbh -> prepare($sql);
                                        $query->bindParam(':eid',$eid,PDO::PARAM_STR);
                                        $query->execute();
                                        $results=$query->fetchAll(PDO::FETCH_OBJ);

                                        $cnt=1;
                                        if($query->rowCount() > 0)
                                        {
                                        foreach($results as $row)
                                        {     ?>       
                                            
                                            <td><?php echo htmlentities($cnt);?></td>
                                            <td><?php echo htmlentities($row->AssessmentName);?></td>
                                            <td><?php echo htmlentities($row->NumberofAssessment);?></td>
                                            
                                            
                                        <td>
                                                       
                                                        <span><a href="edit-assessment.php?editid=<?php echo htmlentities ($row->IDass);?>">Edit</a></span>
                                                        <span>| <a href="manageprogram.php?delid=<?php echo ($row->IDass);?>"  onclick="return confirm('Do you really want to Delete ?');">Delete</a></span>
                                            
                                         </tr>
                                                 <?php $cnt=$cnt+1;}} ?> 

                                        </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header bg-success text-white">
                                <i class="fa fa-users me-1"></i>
                               STUDENT ENROLL UNDER <?php echo $namecourse; ?>
                            </div>
                            <div class="card-body">
                                <script type="text/javascript">
                           $(document).ready( function () {
    var table = $('#example').dataTable();
    var tableTools = new $.fn.dataTable.TableTools( table, {
        "buttons": [
            "copy",
            "csv",
            "xls",
            "pdf",
            { "type": "print", "buttonText": "Print me!" }
        ]
    } );
      
    $( tableTools.fnContainer() ).insertAfter('div.info');
} )
                                </script>
                                  <table id="example" class="display">
                                         <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Student Name</th>
                                            <th>Matric Number</th>
                                         
                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <tr>   
                                        <?php
                                        $sql="SELECT user.name as fullname, user.username, user.userid
FROM user
JOIN tblstudent_program ON tblstudent_program.IDStudent = user.username
WHERE tblstudent_program.IDProgram = :eid AND deleted='0'";
                                        $query = $dbh -> prepare($sql);
                                         $query->bindParam(':eid',$eid,PDO::PARAM_STR);
                                        $query->execute();
                                        $results=$query->fetchAll(PDO::FETCH_OBJ);

                                        $cnt=1;
                                        if($query->rowCount() > 0)
                                        {
                                        foreach($results as $row)
                                        {     ?>       
                                            
                                            <td><?php echo htmlentities($cnt);?></td>
                                            <td><?php echo htmlentities($row->fullname);?></td>
                                            <td><?php echo htmlentities($row->username);?></td>
                                           
                                            
                                            
                                        <td>
                                                       
                                                        <span><a href="view-studentinfo.php?veiwid=<?php echo htmlentities ($row->username);?>">View</a></span> | 
                                                        <span><a href="edit-program.php?delid=<?php echo ($row->username);?>"  onclick="return confirm('Do you really want to remove student ?');">Remove</a></span>
                                            
                                         </tr></tbody>
                                                 <?php $cnt=$cnt+1;}} ?> 

                                        
                                </table>
                            </div>
                        </div>


                    </div>
                </main>
                <?php
                include_once('include/footer.php');
                ?>
                       </div>
        </div>
        <script>
        /* Initialization of datatables */
        $(document).ready(function () {
            $('table.display').DataTable();
        });
    </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
        <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
 
<script type="text/javascript" src="DataTables/datatables.min.js"></script>
    </body>
</html>

                                             
                                