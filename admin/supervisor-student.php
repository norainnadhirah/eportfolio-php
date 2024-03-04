<?php 
    include('include/dbconnection.php');
    session_start();

    if (!isset($_SESSION['admin_login'])) {
        header("location: index.php");
    }

// Code for deleting 
if(isset($_GET['delid']))
{
$rid=intval($_GET['delid']);
$sql="delete from tblstudent_mentor where IDStudent=:rid";
$query=$dbh->prepare($sql);
$query->bindParam(':rid',$rid,PDO::PARAM_STR);
$query->execute();
 echo "<script>alert('Student have been remove');</script>"; 
  echo "<script>window.location.href = 'supervisor-student.php'</script>";     


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
    <title>PutraMD E-Portfolio | View Students</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<?php include_once('include/header.php');?>
<?php include_once('include/sidebar.php');?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">View Student Under Supervisor</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="manageuser.php">Manage User</li></a>
                <li class="breadcrumb-item active">Edit User</li>
                <li class="breadcrumb-item active">View Student</li>

            </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        <b>Student Under 
                            
<?php                         
$idmentor1=$_SESSION['upmid'];
$sql_fetch="SELECT * FROM user
WHERE username=:rid";
$query = $dbh -> prepare($sql_fetch);
$query->bindParam(':rid',$idmentor1,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row1)
{ 

        $name=$row1->name;
        if (strpos($name, 'Dr.') === false) {
            $name = 'Dr. '.$name;
        }
        echo $name;

        
        

 }}?></b>
                    </div>
                    <div class="card-body">


                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>UPMID</th>
                                    <th>Name</th>
                                    <th>Date Assign</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>UPMID</th>
                                    <th>Name</th>
                                    <th>Date Assign</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>

                            

                                <?php
                                        $idmentor=$_SESSION['upmid'];
                                        $sql="SELECT user.userid as stduserid, user.name, user.username, tblstudent_mentor.DateAsssigned, tblstudent_mentor.Status
                                        from user JOIN tblstudent_mentor
                                        ON user.username=tblstudent_mentor.IDStudent
                                        WHERE tblstudent_mentor.IDMentor=:rid AND user.role='Student'";
                                        
                                        $query = $dbh -> prepare($sql);
                                        $query->bindParam(':rid',$idmentor,PDO::PARAM_STR);
                                        $query->execute();
                                        $results=$query->fetchAll(PDO::FETCH_OBJ);

                                        $cnt=1;
                                        if($query->rowCount() > 0)
                                        {
                                        foreach($results as $row)
                                        {   
                                            
                                           
                                            
                                          
                                             ?>
                                <tr>
                                    <td><?php echo htmlentities($row->username); ?></td>
                                    <td><?php echo htmlentities($row->name);?></td>

                                    <td><?php $timeStamp = $row->DateAsssigned;
                                            echo date( "d/m/Y", strtotime($timeStamp));?></td>
                                    <td>


                                        <?php $stats=$row->Status;
    if ($stats == 'Approved') {
        echo '<span class="badge rounded-pill bg-success">Approved</span>';
    } 
    elseif($stats=='In process'){
        echo '<span class="badge rounded-pill bg-warning">Pending from Supervisor</span>';
    }
    else {
        echo '<span class="badge rounded-pill bg-secondary">Not Approve</span>';
    }
    ?>


                                    </td>
                                    <td>
                                        <span><a href="edit-user.php?editid=<?php echo htmlentities ($row->stduserid);?>"><i
                                                    class='fas fa-pen' title="view student"></i></a></span> |
                                       
                                       
                                                    <span><a href="manageuser.php?delid=<?php echo htmlentities ($row->username);?>"
                                                onclick="return confirm('Do you really want to remove this student ?');"
                                                title="delete student?"><i class="fa fa-trash"></i></a></span>

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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
</script>
<script src="js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/chart-area-demo.js"></script>
<script src="assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>
</body>

</html>