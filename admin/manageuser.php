<?php 
    include('include/dbconnection.php');
    session_start();

    if (!isset($_SESSION['admin_login'])) {
        header("location: index.php");
    }
    if (isset($_SESSION['upmid'])) {
        unset($_SESSION['upmid']);
     }



// Code for deleting 
if(isset($_GET['delid']))
{
$rid=intval($_GET['delid']);
$sql="delete from user where userid=:rid";
$query=$dbh->prepare($sql);
$query->bindParam(':rid',$rid,PDO::PARAM_STR);
$query->execute();
 echo "<script>alert('Data deleted');</script>"; 
  echo "<script>window.location.href = 'manageuser.php'</script>";     


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
        <title>PutraMD E-Portfolio | Manage User</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    
        <?php include_once('include/header.php');?>
        <?php include_once('include/sidebar.php');?>
        
                   <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Manage User</h1>
                        <ol class="breadcrumb mb-4">
                         <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="manageuser.php">Manage User</li>
                         
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-info text-white mb-4">
                                    
                                    <div class="card-body"><i class="fas fa-add me-1"></i><b>New User</b></div>
                                  <a class="small text-white stretched-link" href="new-user.php"></a>
                                </div>
                            </div>
                          
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body"><i class="fas fa-user-graduate me-1"></i><b>Student</b></div>
                                    <a class="small text-white stretched-link" href="viewstudent.php"></a>
                            </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body"><i class="fas fa-user-md me-1"></i><b>Supervisor</b></div>
                                    <a class="small text-white stretched-link" href="viewsupervisor.php"></a>
                            </div>
                            </div>

                            <div class="col-xl-3 col-md-6">

                            </div>
                        </div>
                     
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                               <b>All User</b>
                            </div>
                            <div class="card-body">
                      
                                 
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>UPMID</th>
                                            <th>Name</th>
                                            
                                            <th>Date Register</th>
                                             <th>Role</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                         <th>UPMID</th>
                                            <th>Name</th>
                                            
                                            <th>Date Register</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                           
                                        <?php
                                        $sql="SELECT * from user";
                                        $query = $dbh -> prepare($sql);
                                        $query->execute();
                                        $results=$query->fetchAll(PDO::FETCH_OBJ);

                                        $cnt=1;
                                        if($query->rowCount() > 0)
                                        {
                                        foreach($results as $row)
                                        {     ?>
                                        <tr>  
                                            <td><?php echo htmlentities($row->username);?></td>
                                            <td><?php echo htmlentities($row->name);?></td>
                                          
                                            <td><?php $timeStamp = $row->regdate;
                                            echo date( "d/m/Y", strtotime($timeStamp));?></td>
                                            <td><?php echo htmlentities($row->role);?></td>
                                            <td>


                                                <?php $stats=$row->Status;
    if ($stats == 1) {
        echo '<span class="badge rounded-pill bg-primary">active</span>';
    } else {
        echo '<span class="badge rounded-pill bg-secondary">inactive</span>';
    }
    ?>


                                            </td>
                                            <td>
                                               <span><a href="edit-user.php?editid=<?php echo htmlentities ($row->userid);?>"><i class='fas fa-pen' title="edit user"></i></a></span>
                                                        <span><a href="manageuser.php?delid=<?php echo ($row->userid);?>"  onclick="return confirm('Do you really want to Delete ?');" title="delete user?"><i class="fa fa-trash"></i></a></span>

                                            </td>
                                            
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
