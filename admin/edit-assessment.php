
<?php


    include('include/dbconnection.php');
    session_start();

   if (!isset($_SESSION['admin_login'])) {
        header("../logout.php");
    }

$eid=$_GET['editid'];
                        $sql="SELECT * from tblassessment where ID=$eid";
                        $query = $dbh -> prepare($sql);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);

                        $cnt=1;
                        if($query->rowCount() > 0)
                        {
                        foreach($results as $row)
                        {   

                        $idprogram=$row->IDProgram;
                        $submissionnumber=$row->NumberofAssessment;
                        $description=$row->AssessmentDes;
                        $ass_name=$row->AssessmentName;
                    
}}

$sql="SELECT * from tblprogram where ID=:idprogram";
                        $query = $dbh -> prepare($sql);
                        $query->bindParam(':idprogram',$idprogram,PDO::PARAM_STR);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);

                        $cnt=1;
                        if($query->rowCount() > 0)
                        {
                        foreach($results as $row)
                        {   

                        $programname=$row->ProgramName;
                        $programcode=$row->ProgramCode;
                       
}}





if(isset($_POST['submit']))
{

$passname=$_POST['assname'];
$pnumass=$_POST['numass'];   
$passdesc=$_POST['editor'];
$eid=$_GET['editid'];


$sql="UPDATE tblassessment set AssessmentName=:ass_name ,NumberofAssessment=:num_ass, AssessmentDes=:ass_desc where ID=:idass";


$query = $dbh->prepare($sql);
$query->bindParam(':ass_name',$passname,PDO::PARAM_STR);
$query->bindParam(':num_ass',$pnumass,PDO::PARAM_STR);
$query->bindParam(':ass_desc',$passdesc,PDO::PARAM_STR);
$query->bindParam(':idass',$eid,PDO::PARAM_STR);
$query->execute();



if ($query->execute()) {
    $lastInsertId = $dbh->lastInsertId();
    echo "<script>alert('Assessment updated.');</script>"; 
    header("Refresh:0; url=edit-assessment.php?editid=$eid");
} else {
    echo "<script>alert('Error updating assessment, please try again.');</script>";
}

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
        <title>PutraMD E-Portfolio | Edit Assessment</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Include stylesheet -->

        <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
    </head>
    
        <?php include_once('include/header.php');?>
        <?php include_once('include/sidebar.php');?>
        
                   <div id="layoutSidenav_content">
                    <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Edit Assessment</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="manageprogram.php">Manage Program</a></li>
                            <li class="breadcrumb-item active"><a href="manageassessment.php">Manage Assessment</a></li>
                            <li class="breadcrumb-item active">Edit Assessment</li>
                        </ol>
                       


                        <div id="main-content">
                    <div class="row">
                            
                                <div class="card-header bg-info">
                                    <h4>Assessment Information</h4> </div>
                                    <form method="post" name="hjhgh">
                                    <div class="card-body mb-4">
                                        <div class="row mb-3">
                                        <div class="col-md-6">
                                             <div class="form-floating">

                                                <input class="form-control" id="name" type="name" 
                                                placeholder="Name" value ="<?php echo $programname; ?>" />

                                            <label>Code Program</label>
                                             </div>
                                         </div>
                                             <div class="col-md-6">   
                                             <div class="form-floating">

                                                <input class="form-control" id="name" type="name" placeholder="Name" value ="<?php echo $programcode; ?>" disabled/>

                                            <label>Course Program Code</label>
                                             </div>
                                         </div>
                                  


                                      </div>
                                      <div class="row mb-3">
                                        <div class="col-md-8">
                                             <div class="form-floating">  
                                                <input class="form-control" type="text"  name="assname" required="true" value="<?php echo $ass_name?>" />
                                                        <label for="">Assessment Title</label>

                                      </div> </div> 

                                        <div class="col-md-4">
                                             <div class="form-floating">  
  <!-- create a label and input field for the number -->

  <input class="form-control" type="number" name="numass" value="<?php echo $submissionnumber; ?>" required>
  <label for="number">Number of Assessment</label>



</div></div></div> 


<div class="row mb-3">
                                        <div class="col-md-8">
                                            <label for="">Assessment Description:</label>
                                             <div class="form-floating ">
<!-- Create the editor container -->            
    
  <textarea class="form-control" placeholder="Write Description" id="editor"  name="editor" rows="10" cols="50" value="<?php  echo $description; ?>"><?php  echo $description; ?></textarea>


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




                                             </div></div></div>
                                    </div>
   
                                           
                                <div class=" card-footer d-flex form-floating">
                                    <button class="btn btn-default bg-info sbmt-btn" type="submit" name="submit">Save</button>
                                <button class="btn btn-default btn-lg sbmt-btn" type="reset">Reset</button>

                                </div></form>
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
