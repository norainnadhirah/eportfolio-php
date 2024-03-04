<?php 
session_start();
error_reporting(0);
include('include/dbconnection.php');

 if (strlen($_SESSION['student_login'])==0) {
header('location:index.php');}

else{
  
    
$eid=$_SESSION['student_login'];

                        //fetch idmentor 
                        $sql_idmentor="SELECT * from tblstudent_mentor where IDStudent=$eid";
                        $query = $dbh -> prepare( $sql_idmentor);
                        $query->execute();
                        $results1=$query->fetchAll(PDO::FETCH_OBJ);

                        if($query->rowCount() > 0)
                        {
                        foreach($results1 as $row)
                        {    $idmentor=$row->IDMentor;  }}   




                        $sql="SELECT * from user where username=$idmentor";
                        $query = $dbh -> prepare($sql);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);

                        $cnt=1;
                        if($query->rowCount() > 0)
                        {
                        foreach($results as $row)
                        {               



 // Default profile photo URL
  $user_dp=($row->user_dp);
$default_photo_url = "../img_dir/dp.png";


  // Profile photo URL
  $profile_photo_url = (empty($user_dp)) ? $default_photo_url : $user_dp;


?>
    <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>PutraMD: Supervisor</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    
        <?php include_once('include/header.php');?>
        <?php include_once('include/sidebar.php');?>
        
                   <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Supervisor Profile</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Supervisor Profile</a></li>
                            
                        </ol>
                        


                <main>


    <div class="row">
      <div class="col-lg-12">
        <div class="card mb-2">
          <div class="card-body text-center">
            <img src="../mentor/img_dir/<?php echo $profile_photo_url; ?>" alt="avatar"
              class="rounded-circle img-fluid" style="width: 150px;">
            <h5 class="my-3"><?php  $name = $row->name;
                              if (stripos($name, "Dr.") === false) {
                                  echo "Dr. " . $name;
                              } else {
                                  echo $name;
                              }?></h5>
   
            <div class="d-flex justify-content-center mb-2">
             
            </div>
          </div>
        </div>

        <div class="col-lg-12">
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Full Name</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php  $name = $row->name;
                                            if (stripos($name, "Dr.") === false) {
                                                echo "Dr. " . $name;
                                            } else {
                                                echo $name; }?></p>
                                                      </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Email</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php  echo htmlentities($row->email);?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Phone</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php  echo htmlentities($row->notel);?></p>
              </div>
            </div>
            
            <hr>
          </div>
        </div>
       
</div>
                               


                                            
<?php }} 

} 

?> 
                        
                                
                            
                                





                            



</div>
                </main>
                 </div>
                        
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

                                             
                                