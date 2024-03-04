<?php 

include('include/dbconnection.php');
    session_start();

    if (!isset($_SESSION['admin_login'])) {
        header("../login.php");}

    
// Code for deleting program
if(isset($_GET['delid']))
{
$rid=intval($_GET['delid']);
$sql="update tblprogram set deleted='1' where ID=:rid";
$query=$dbh->prepare($sql);
$query->bindParam(':rid',$rid,PDO::PARAM_STR);
$query->execute();
 echo "<script>alert('Course is deleted');</script>"; 
  echo "<script>window.location.href = 'manageprogram.php'</script>";     


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
        <title>PutraMD E-Portfolio | Manage Course Program</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    
        <?php include_once('include/header.php');?>
        <?php include_once('include/sidebar.php');?>
        
                   <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Manage Course Program</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="manageprogram.php">Manage Course Program</a></li>
                        </ol>
                        <div class="row mb-3">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-info text-white mb-4">
                                    
                                    <div class="card-body"><i class="fas fa-add me-1"></i><b>Create Course Program</b></div>
                                  <a class="small text-white stretched-link" href="newprogram.php"></a>
                                </div>
                            </div>
                          
                            

                         <div class="col-xl-3 col-md-6">
                                <div class="card bg-info text-white mb-4">
                                    
                                    <div class="card-body"><i class="fas fa-add me-1"></i><b>Create Assessment</b></div>
                                  <a class="small text-white stretched-link" href="newassessment.php"></a>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-info text-white mb-4">
                                    <div class="card-body"><i class="fas fa-check me-1"></i><b>Enroll Student</b></div>
                                    <a class="small text-white stretched-link" href="enroll-student.php"></a>
                            </div>
                            </div>

                            <div class="col-xl-3 col-md-6">



                            </div>
                        </div>


                     
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                               All Program
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">



                                         <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Program Name</th>
                                            <th>Program Code</th>
                                         
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                             <th>No</th>
                                         <th>Program Name</th>
                                            <th>Program Code</th>
                                  
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>   
                                        <?php
                                        $sql="SELECT * from tblprogram where deleted='0'";
                                        $query = $dbh -> prepare($sql);
                                        $query->execute();
                                        $results=$query->fetchAll(PDO::FETCH_OBJ);

                                        $cnt=1;
                                        if($query->rowCount() > 0)
                                        {
                                        foreach($results as $row)
                                        {     ?>       
                                            
                                            <td><?php echo htmlentities($cnt);?></td>
                                            <td><?php echo htmlentities($row->ProgramName);?></td>
                                            <td><?php echo htmlentities($row->ProgramCode);?></td>
                                         
                                            <td><?php $timeStamp = $row->StartDate;
                                            echo date( "d/m/Y", strtotime($timeStamp));
                                        ?></td>
                                            <td><?php $timeStamp1 = $row->EndDate;
                                            echo date( "d/m/Y", strtotime($timeStamp1))?></td>  
                                        <td>
                                                       
                                                        <span><a href="edit-program.php?editid=<?php echo htmlentities ($row->ID);?>"><i class='fas fa-pen'></i></a></span>
                                                        <span><a href="manageprogram.php?delid=<?php echo ($row->ID);?>"  onclick="return confirm('Do you really want to Delete ?');"><i class="fa fa-trash"></i></a></span>
                                            
                                         </tr>
                                                 <?php $cnt=$cnt+1;}} ?> 

                                        </tbody>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>

                                             
                                