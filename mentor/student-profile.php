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
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Your Student</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    
        <?php include_once('include/header.php');?>
        <?php include_once('include/sidebar.php');?>
        
        
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4 text-info">Your Students</h1>
                        <ol class="breadcrumb mb-4">
                          
                        </ol>

                <main> 
                    
                    <div class="row container-fluid">
          <div class="container profile-page">

<?php
$sql_student="SELECT *, tblstudent_mentor.IDStudent , user.name as studentname, tblprogram.ProgramName 
FROM tblstudent_mentor 
JOIN user ON user.username = tblstudent_mentor.IDStudent
JOIN tblstudent_program ON tblstudent_program.IDStudent = tblstudent_mentor.IDStudent
JOIN tblprogram ON tblprogram.ID = tblstudent_program.IDProgram
WHERE tblstudent_mentor.IDMentor = :idmentor AND tblstudent_mentor.Status='Approved' AND tblprogram.StartDate <= CURDATE() AND tblprogram.EndDate >= CURDATE()";
$query = $dbh -> prepare($sql_student);
$query->bindParam(':idmentor',$idmentor,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

                                        if($query->rowCount() > 0)
                                        {
                                        foreach($results as $row)
                                        { 

$user_dp=($row->user_dp);
$default_photo_url = "../img_dir/dp.png";
  // Profile photo URL
$profile_photo_url = (empty($user_dp)) ? $default_photo_url : $user_dp;


?>
    <div class="row mb-4">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card profile-header">
                <div class="body">
                    <div class="row justify-content-between">
                        <div class="col-lg-4 col-md-4 col-12 d-flex">
                            <div class="profile-image float-md-right">  <img src="../student/img_dir/<?php echo $profile_photo_url; ?>"  class="img-thumbnail"
  style="width: 150px;" alt="No Profile Photo">
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-12">
                            <h4 class="m-t-0 m-b-0"><strong><?php  echo htmlentities($row->name);?></strong></h4>
                            <span class="d-flex">Matric Number: <?php  echo htmlentities($row->username);?>
                                
                            </span>
                            <span class="d-flex">Course Enroll: <?php  echo htmlentities($row->ProgramName);?>
                                
                            </span>
                            <span class="d-flex">Phone No: <?php  echo htmlentities($row->notel);?>
                                
                            </span>
                            <span class="d-flex">Email: <?php  echo htmlentities($row->email);?></span>
                            <span class="mb3"><a href="student-archive.php?id=<?php  echo htmlentities($row->username);?>"><button class="btn btn-default btn-secondary" title="Student Assessment Archive">View Archive</button></a></span>
                                
                            </span>
                            
                            
                        </div>                
                    </div>
                </div>                    
            </div>
        </div>
    </div>
<?php
}}

?>






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
                                             
                                