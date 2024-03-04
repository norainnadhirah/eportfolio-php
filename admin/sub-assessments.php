<?php 
    include('include/dbconnection.php');
    session_start();

    if (!isset($_SESSION['admin_login'])) {
        header("../logout.php");
    }else{

$idstudent=$_SESSION['upmid'];
$idass=$_GET['id'];

$sql = "SELECT IDProgram,AssessmentName, AssessmentDes FROM tblassessment WHERE ID=:idass";
$query = $dbh -> prepare($sql);
$query->bindParam(':idass',$idass,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{  
$idprogram=$result->IDProgram;
$ass_name=$result->AssessmentName;
$ass_des=$result->AssessmentDes; 

}}        

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
        <title>PutraMD E-Portfolio | List of Assessments</title>
        <<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <!--Datatable plugin CSS file -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" />
    <!--jQuery library file -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <!--Datatable plugin JS library file -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    
        <?php include_once('include/header.php');?>
        <?php include_once('include/sidebar.php');?>
        
                   <div id="layoutSidenav_content">
                    <main>
                    <div class="container-fluid px-4">
                        <h2 class="mt-4"><?php echo htmlentities($ass_name);?></h2>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                             <li class="breadcrumb-item"><a href="manageuser.php">Manage User</a></li>
                            <li class="breadcrumb-item"><a href="edit-user.php?editid=<?php echo $userid; ?>">Edit User</a></li>
                            <li class="breadcrumb-item active">Archive</a></li>
                            <li class="breadcrumb-item active"><?php echo htmlentities($ass_name);?></li>
                           
                            
                        </ol>
                       


                        <div id="main-content">
                        <div class="row">
                            <div class="col-xl-12 ">
                                <div class="card mb-4">

</div>
                                </div></div>


                            <div class="col-xl-12 ">
                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center ">
                                        <h5 class="card-title"><div class="d-flex justify-content-start "> <?php echo htmlentities($ass_name); ?></div></h5>  
                                    
                            
         
                                    </div>
                                    <div class="card-body ">
                                        <div class="col-md-12">
    <div cdiv class="accordion mb-3" id="accordionPanelsStayOpenExample">
  <div class="accordion-item ">
    <h2 class="accordion-header" id="flush-headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
       <b> Assessments Description</b>
      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body"><?php echo $ass_des ?></div>
    </div>
  </div>
  
  </div>
                                             <table id="datatablesSimple2" >
                                    <thead>
                                      



                                        <tr>
                                        
                                            <th>Assessment Title </th>
                                            <th>Date Submission</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                           
                                            <th>Assessment Title</th>
                                            <th>Date Submission</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>   
                                        <?php
                                        $sql="SELECT * from tblsubmit_ass where IDStudent=:id AND IDAssessment=:idass";
                                        $query = $dbh -> prepare($sql);
                                        $query->bindParam(':id',$idstudent,PDO::PARAM_STR);
                                        $query->bindParam(':idass',$idass,PDO::PARAM_STR);
                                        $query->execute();
                                        $results=$query->fetchAll(PDO::FETCH_OBJ);

                                        $cnt=1;
                                        if($query->rowCount() > 0)
                                        {
                                        foreach($results as $row)
                                        {     ?>  
                                         
                                            <td><?php echo htmlentities($row->AssSubmitTitle);?></td>
                                          
                                            <td><?php $timeStamp = $row->SubmitDate;
                                            echo date( "d/m/Y", strtotime($timeStamp));?></td>
                                            <td class="bg-light">

                                             <div class="status-badge">
    <?php 
    $status = $row->Status;
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

<td class="bg-light">
    <?php if ($row->Status == 3): ?>
        <span><a href="view-completed-assessment.php?SubmitID=<?php echo htmlentities ($row->ID);?>"><i class='fas fa-eye'></i></a></span>
     <?php elseif ($row->Status == 2): ?>
        <span><a href="view-completed-assessment.php?SubmitID=<?php echo htmlentities ($row->ID);?>"><i class='fas fa-eye'></i></a></span>
    <?php elseif ($row->Status == 1): ?>
        <span><a href="view-completed-assessment.php?SubmitID=<?php echo htmlentities ($row->ID);?>"><i class='fas fa-eye'></i></a></span>        
    <?php else: ?>
        <span><a href="view-completed-assessment.php?SubmitID=<?php echo htmlentities ($row->ID);?>"><i class='fas fa-eye'></i></a></span>
       
    <?php endif; ?>
</td>
                                            
                                        </tr>
                                       <?php $cnt=$cnt+1;}} ?> 
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

                <footer class="py-4 bg-light mt-auto">
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
