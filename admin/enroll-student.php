<?php 

include('include/dbconnection.php');
    session_start();



if (!isset($_SESSION['admin_login'])) {
    header("location: logout.php");
    exit();
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
        <title>PutraMD E-Portfolio | Enroll Student</title>
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
                        <h1 class="mt-4">Enroll Student</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="manageprogram.php">Manage Program</a></li>
                            <li class="breadcrumb-item active">Enroll Student</li>
                        </ol>

<div class="row mb-3">
                         <div class="col-xl-3 col-md-6">
                                <div class="card bg-info text-white mb-4">
                                    
                                    <div class="card-body"><i class="fas fa-add me-1"></i><b>Enroll Student</b></div>
                                  <a class="small text-white stretched-link" href="enroll-student.php"></a>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-info text-white mb-4">
                                    <div class="card-body"><i class="fas fa-users me-1"></i><b> Manage Enroll Student</b></div>
                                    <a class="small text-white stretched-link" href="manage-enroll-student.php"></a>
                            </div>
                            </div>

                            <div class="col-xl-3 col-md-6">



                            </div>
                        </div

                   

                <div id="main-content">
                    
                    <div class="col-md-12">


                                <div class="card mb-4">
                                    <div class="card-header"> 
                                        <i class="fa fa-book me-1"></i> Select Course Program</div>
                                        <div class="card-body">
                                             


    <div class="form-floating">
<form  method="get">

    </span><label for="course-select">Course Program:</label>
    <select class="form-control" id="course-select" name="idprogram" required>
  <!-- add options to the select dropdown -->
  <option>Select Course Program</option>
  <?php

//to select id program
$sql="SELECT * from tblprogram where status = 1;";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>   
<option value="<?php  echo htmlentities($row->ID);?>"><?php  echo htmlentities($row->ProgramName);?>(<?php  echo htmlentities($row->ProgramCode);?>)</option><?php $cnt=$cnt+1;}} ?>

</select>   <span class="input-group-btn"><br>
                                             <div class="col-md-6">
                                                <button class="btn btn-default bg-info sbmt-btn" type="submit" name="formSubmit">Select</button></div></span></div>
 
                                                                                          
</form>

                                        </div></div>


           
                 <?php
    if(isset($_GET['formSubmit'])) 
    {
        $pidprogram = $_GET['idprogram'];
        $errorMessage = "";
        
        if(empty($pidprogram)) 
        {
            $errorMessage = "<li >You forgot to select a course program</li>";
        }
        
        if($errorMessage != "") 
        {
            echo("<p>There was an error with your form:</p>\n");
            echo("<ul>" . $errorMessage . "</ul>\n");
        } 
        else 
        {


$sql="SELECT * from tblprogram where ID=:idprogram";
$query = $dbh -> prepare($sql);
$query->bindParam(':idprogram',$pidprogram,PDO::PARAM_STR);
$query->execute();
$result=$query->fetch(PDO::FETCH_OBJ);
if($result){




            ?>
            <div class="card mb-4">

            <div class="card-header">  <i class="fa fa-users me-1"></i> Enroll Students in <?php echo htmlentities($result->ProgramName); ?>(<?php echo $result->ProgramCode; echo $pidprogram; }?>)</div>
            <div class="card-body">
<form name="enroll" method="post" ">
                  <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>UPMID</th>
                                            <th>Student Name</th>
                                     
                                       
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>UPMID</th>
                                            <th>Name</th>
                                            
                                        
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>
<?php 
$sql="SELECT tblstudent_mentor.IDStudent, tblstudent_mentor.IDMentor, user.name FROM tblstudent_mentor 
JOIN user ON tblstudent_mentor.IDStudent = user.username 
WHERE tblstudent_mentor.Status ='Approved' AND user.role ='Student' 
AND tblstudent_mentor.IDStudent NOT IN (SELECT IDStudent FROM tblstudent_program WHERE IDProgram = :idprogram)";
                                        $query = $dbh -> prepare($sql);
                                        $query->bindParam(':idprogram',$pidprogram,PDO::PARAM_STR); 
                                        $query->execute();
                                        $results=$query->fetchAll(PDO::FETCH_OBJ);

                                        $cnt=1;
                                        if($query->rowCount() > 0)
                                        {
                                        foreach($results as $row)
                                        {     ?> 
<td><input class="form-check-input" type="checkbox" name="idstudent[]" value="<?php echo $row->IDStudent; ?> "> </td>
 <td><?php echo htmlentities($row->IDStudent);?> </td>
<td><?php echo htmlentities($row->name);?></td>   
                                        </input></tr> <?php $cnt=$cnt+1;}} ?> 
                                        

                                    </tbody>
                


            </table><div></div>
<div class=" card-footer d-flex form-floating">
                             <button class="btn btn-default bg-info sbmt-btn" type="submit" name="submit_std" onclick="return confirm('Do you want to enroll these students?');">Enroll Student</button>
                                <button class="btn btn-default btn-lg sbmt-btn" type="reset">Reset</button>

                                </div></form>







<?php
      











            
        }




  


  


if (isset($_POST['submit_std'])) {
  if (isset($_POST['idstudent'])) {
    try {
        $dbh->beginTransaction();
        $selected_values = $_POST['idstudent'];
        $program = $pidprogram;
      
        $sql = "INSERT INTO tblstudent_program (IDStudent,IDProgram) VALUES (:IDStudent,:IDProgram)";
        $query = $dbh->prepare($sql);
        $query->bindValue(':IDProgram', $program, PDO::PARAM_STR);
        foreach ($selected_values as $key => $value) {
          $query->bindValue(':IDStudent' . $key, $value, PDO::PARAM_STR);
          $query->execute();
        }
        $dbh->commit();
        echo "<script>alert('Enrollment is Success');</script>";
        header('Location: enroll-student.php');
      } catch (PDOException $e) {
        $dbh->rollBack();
        echo "<script>alert('Enrollment is NOT Success');</script>";
      }
  }
}

}

?>




            </div>
               

           </div>                             
        


                        
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

                                             
                                