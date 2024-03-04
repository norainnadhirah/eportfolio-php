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
        <title>PutraMD E-Portfolio | Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    
        <?php include_once('include/header.php');?>
		<?php include_once('include/sidebar.php');?>
		
		
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Admin's Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row">
                          
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-info text-center mb-4 shadow p-3 mb-5">
                                    <div class="card-body ">
                                    <h5 class="card-title">Manage User</h5>
                                    <div><br></div>
                                        <a class="small text-white stretched-link" href="manageuser.php"></a>
                                         <i class="fas fa-users-cog fa-5x" style="color:black"></i>
                                         <div><br></div>
                                    </div>
                                </div>
                            </div>
 

                        <div class="col-xl-3 col-md-6">
                        <div class="card bg-info text-center mb-4 shadow p-3 mb-5">
                                    <div class="card-body ">
                                    <h5 class="card-title">Manage Program</h5>
                                    <div><br></div>
                                        <a class="small text-white stretched-link" href="manageprogram.php"></a>
                                         <i class="fas fa-stethoscope fa-5x" style="color:black"></i>
                                         <div><br></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                        Welcome
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title"><?php if(isset($_SESSION['admin_login'])) { ?>
                                            Welcome, <?php echo $_SESSION['admin_login']; }?></h4>
                                        <p class="card-text"></p>
                                        <a href="../logout.php" class="btn btn-danger">Logout</a>
                              
                                      </div>

                                </div>
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