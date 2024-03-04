<?php 
    include('include/dbconnection.php');
    session_start();

    if (!isset($_SESSION['mentor_login'])) {
        header("../logout.php");
    }else{

// code for update the read notification status
$isread=1;
$did=intval($_GET['SubmitID']);  
$status=2;
$sql="update  tblsubmit_ass set Status=:status ,  isRead=:isread where id=:did";
$query = $dbh->prepare($sql);
$query->bindParam(':isread',$isread,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':did',$did,PDO::PARAM_STR);
$query->execute();        

$SubmitID=$_GET['SubmitID'];
$idmentor=$_SESSION['mentor_login'];


//get assessment ID
$sql = "SELECT IDAssessment FROM tblsubmit_ass WHERE ID=:SubmitID";
$query = $dbh -> prepare($sql);
$query->bindParam(':SubmitID',$SubmitID,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{  
$idassessment=$result->IDAssessment;

}}

//retrieve Program Course ID and Assessment Name
$sql = "SELECT IDProgram,AssessmentName FROM tblassessment WHERE ID=:idass";
$query = $dbh -> prepare($sql);
$query->bindParam(':idass',$idassessment,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{  
$idprogram=$result->IDProgram;
$ass_name=$result->AssessmentName;

}}

//The evaluation will update as draft 
if(isset($_POST['save_draft']))
{
  $status=2; //receive by the supervisor 
  $peva=$_POST['eva'];

$sql_update = "UPDATE tblsubmit_ass 
SET Mentor_Evaluation=:eva , Status=:status
WHERE ID = :did";

$query = $dbh->prepare($sql_update);
$query->bindParam(':eva',$peva,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':did',$did,PDO::PARAM_STR);
$query->execute(); 
    echo "<script>alert('Evaluation is save as draft');</script>"; 
    echo "<script>window.location.href = 'student-assessments.php?id=<php? echo $SubmitID;?>'</script>";   
  }




//the evaluation will be submit and notify to the student
if(isset($_POST['submit']))
{
  $status=3; //evaluate by the supervisor 
  $peva=$_POST['eva'];



$sql_submit = "UPDATE tblsubmit_ass 
SET Mentor_Evaluation=:eva , Status=:status, EvaluateDate=:evaluatedate
WHERE ID = :did";

$query = $dbh->prepare($sql_submit);
$query->bindParam(':eva',$peva,PDO::PARAM_STR);
$query->bindParam(':evaluatedate', date("Y-m-d H:i:s"), PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':did',$did,PDO::PARAM_STR);

$query->execute(); 
    echo "<script>alert('Evaluation is Completed');</script>"; 
    echo "<script>window.location.href = 'student-assessments.php?id=<php? echo $SubmitID;?>'</script>"; 
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
      <title>PutraMD Supervisor | Evaluate Assessment</title>

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
                        <h1 class="mt-4">View Assessments</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                           
                            <li class="breadcrumb-item active"><a href="all-assessments.php?id=<?php echo$idass;?>"><?php echo htmlentities($ass_name); ?></a></li>
                            <li class="breadcrumb-item active">View Assessments</li>
                            
                        </ol>
                       


                        <div id="main-content">
                        <div class="row">
                            <div class="col-xl-12 ">
                                <div class="card mb-4">

                                     <?php
                                        $sql="SELECT tblsubmit_ass.*, user.name FROM tblsubmit_ass JOIN user ON tblsubmit_ass.IDStudent = user.username WHERE tblsubmit_ass.ID=:id";
                                        $query = $dbh -> prepare($sql);
                                        $query->bindParam(':id',$SubmitID,PDO::PARAM_STR);
                                        $query->execute();
                                        $results=$query->fetchAll(PDO::FETCH_OBJ);

                                        $cnt=1;
                                        if($query->rowCount() > 0)
                                        {
                                        foreach($results as $row)
                                        {     ?>  
                                     <form method="post" name="hjhgh" enctype="multipart/form-data">
                                    <div class="card-body">
                                     <div class="col-md-12">

                                         <div class="col-lg-8">
        <div class="card mb-4 bg-light">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Assessment's Title:</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo htmlentities($row->AssSubmitTitle); ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Submit By:</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo htmlentities($row->name); ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Matric Number:</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo htmlentities($row->IDStudent); ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Submit Date:</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php $timeStamp = $row->SubmitDate;
$timeStamp1 = date("d/m/Y h:i a", strtotime($timeStamp));
echo htmlentities($timeStamp1); ?></p>
              </div>
            </div>
                        <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">File Name:</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo htmlentities($row->AssessmentFile); ?></p>
              </div>
            </div>
            </div>
        </div>
                                        


<div class="col-md-12 d-flex align-items-center mb-4">
    <div class="col-md-12 ">
   <?php
$file = $row->AssessmentFile;
$ext = pathinfo($file, PATHINFO_EXTENSION);
$file_download="../student/ass_upload/".$file;

if(!empty($file)) {
  if($ext == 'doc') {
    echo '<button onclick="location.href=\''.$file_download.'\'" type="button" class="btn btn-primary">Download</button>';
  } elseif($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg'){
    echo '<img src="'.$file_download.'" alt="image" width="700" height="900">';
  } elseif($ext == 'mp4'){
    echo '<video width="320" height="240" controls>
            <source src="'.$file_download.'" type="video/mp4">
            Your browser does not support the video tag.
          </video>';
  } elseif ($ext == 'pdf') {
    echo '<iframe class="embed-responsive-item" src="'.$file_download.'" width="700" height="500"></iframe>';
  } else {
    echo '<alert class="text-info">Invalid file format or No document found.</alert>';
  }
}



?>



   

</div></div>
<div class="card bg-light mb-3">
  <div class="card-header">Student's Reflection:</div>
  <div class="card-body">
    <?php echo $row->Student_Reflection; ?>
  </div>
</div>                                      <div class="col-md-12 mb-4">
                                             <div class="form-floating">  
                                                 <div class="col-md-12">


                                                    <label for="formFile" class="form-label"><b>Supervisor's Evaluation:</b></label>
                                                    <p class="font-italic">Write your evaluation.</p>
                                             <div class="form-floating ">
<!-- Create the editor container -->            
    
  <textarea class="form-control" placeholder="Your Evaluation" id="editor" name="eva"></textarea>


    <script src="js/ckeditor.js"></script>

<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ), {
           toolbar: {
    items: [
        'heading', '|',
        'fontfamily', 'fontsize', '|',
        'alignment', '|',
        'fontColor', 'fontBackgroundColor', '|',
        'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', '|',
        'link', '|',
        'outdent', 'indent', '|',
        'bulletedList', 'numberedList', 'todoList', '|',
        'insertTable', '|',
         'blockQuote', '|',
        'undo', 'redo'
    ],
    shouldNotGroupWhenFull: true
}

        } )
        .then( editor => {
            window.editor = editor;
        } )
        .catch( err => {
            console.error( err.stack );
        } );
</script>






                                             </div>

                                                  
                                                </div>

                                      </div> </div> 

                                         </div>






                                   <?php } } }


                                 ?> </div>

                                      <div class=" card-footer d-flex form-floating">
             
                                <button class="btn btn-sm bg-info" type="submit" name="submit" onclick="return confirm('Are you sure you want to submit your evaluation?');">Finish Evaluate</button>
                                <button class="btn btn-outline-info btn-sm " type="submit" name="save_draft">Save as Draft</button>
                               <script type="text/javascript">
                                   document.querySelector("[name='save_draft']").addEventListener("click", function(event) {
  event.preventDefault();
  var saveBtn = this;
  saveBtn.innerHTML = "saving...";
  saveBtn.disabled = true;
  //save data as draft

});
                               </script> 
                                </div>

                                
                            </div>







</form>


                     
                        
                    </div>
                </main>
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
