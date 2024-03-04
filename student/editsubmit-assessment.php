<?php 

//this php file will view if the student has create new assesssment and save it as draft
    include('include/dbconnection.php');
    session_start();

    if (!isset($_SESSION['student_login'])) {
        header("../logout.php");
    }else{

$editid=$_GET['editid'];

//fetch id assessment type of assessmnet
$sql = "SELECT IDAssessment FROM tblsubmit_ass WHERE ID=:editid";
$query = $dbh -> prepare($sql);
$query->bindParam(':editid',$editid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{  
$idassessment=$result->IDAssessment;

}}


//fetch id program and type assessment name
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


//fetch mentor id
$idstd=$_SESSION['student_login'];

$sql_idmentor = "SELECT IDMentor FROM tblstudent_mentor WHERE IDStudent=:idstd";
$query = $dbh -> prepare($sql_idmentor);
$query->bindParam(':idstd',$idstd,PDO::PARAM_STR);
$query->execute();
$r1=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($r1 as $r)
{  
$idmentor=$r->IDMentor;
 
}}


if(isset($_POST['save_draft'])){
  $ptitle_ass=$_POST['title_ass'];
  $pstatus=0;  
  $preflection=$_POST['std_reflection'];


     $sql_update="UPDATE tblsubmit_ass SET AssSubmitTitle =:ass_title, Student_Reflection =:std_refl, Status =:status WHERE ID =:id";
    $query = $dbh->prepare($sql_update);
    $query->bindParam(':ass_title',$ptitle_ass,PDO::PARAM_STR);
    $query->bindParam(':std_refl',$preflection,PDO::PARAM_STR);
    $query->bindParam(':status',$pstatus,PDO::PARAM_STR); 
    $query->bindParam(':id',$editid,PDO::PARAM_STR);   
    $query->execute();   
    echo "<script>alert('Assessment Saved as draft ');</script>"; 
     echo "<script>window.location.href = 'all-assessments.php?id=".$idassessment."'</script>";


}



if(isset($_POST['submit'])){
  $ptitle_ass=$_POST['title_ass'];
  $pstatus=1;  
  $preflection=$_POST['std_reflection'];


     $sql_update="UPDATE tblsubmit_ass SET AssSubmitTitle =:ass_title, Student_Reflection =:std_refl, Status =:status WHERE ID =:id";
    $query = $dbh->prepare($sql_update);
    $query->bindParam(':ass_title',$ptitle_ass,PDO::PARAM_STR);
    $query->bindParam(':std_refl',$preflection,PDO::PARAM_STR);
    $query->bindParam(':status',$pstatus,PDO::PARAM_STR); 
    $query->bindParam(':id',$editid,PDO::PARAM_STR);   
    $query->execute();   
    echo "<script>alert('Assessment Submitted to Supervisor ');</script>"; 
     echo "<script>window.location.href = 'all-assessments.php?id=".$idassessment."'</script>";


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
        <title>PutraMD E-Portfolio | Draft Assessment</title>
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
                        <h1 class="mt-4">Edit Assessments</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="all-assessments.php?id=<?php echo $idassessment?>"><?php echo htmlentities($ass_name);?></a></li>
                            <li class="breadcrumb-item active">Edit Assessments</li>
                            
                        </ol>
                       


                        <div id="main-content">
                        <div class="row">
                            <div class="col-xl-12 ">
                                <div class="card mb-4">
                                    <div class="card-header bg-info">
                                        <i class="fa-solid fa-pen-to-square me-1"></i> 
                                        Edit  
                                        <?php 
                                        echo $ass_name;
                                        ?>
                                    </div>
                                     <?php
                                        $sql="SELECT * from tblsubmit_ass where ID=:id";
                                        $query = $dbh -> prepare($sql);
                                        $query->bindParam(':id',$editid,PDO::PARAM_STR);
                                        $query->execute();
                                        $results=$query->fetchAll(PDO::FETCH_OBJ);

                                        $cnt=1;
                                        if($query->rowCount() > 0)
                                        {
                                        foreach($results as $row)
                                        {     

                                         $currentfile=$row->AssessmentFile;   ?>  
                                     <form method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                     <div class="col-md-12">
                                              <div class="form-floating mb-4">
                                                        <input class="form-control" id="title_ass" type="text"  name="title_ass" value="<?php echo htmlentities($row->AssSubmitTitle); ?>" required />
                                                        <label for="title_ass" class="form-label">Assessments Title</label>
                                                    </div>


                                      <div class="col-md-12 mb-4">
    <div class="form-floating">

                                                                    <div class="">
<?php
$file = $row->AssessmentFile;
$ext = pathinfo($file, PATHINFO_EXTENSION);

switch ($ext) {
    case 'txt':
        $icon = '<img src="txt-icon.png" alt="Text file">';
        break;
    case 'docs':
        $icon = '<i class="fa-sharp fa-solid fa-file-word fa-5x"></i>';
        break;
    case 'doc':
        $icon = '<i class="fa-sharp fa-solid fa-file-word fa-5x"></i>';
        break;
    case 'docx':
        $icon = '<i class="fa-sharp fa-solid fa-file-word fa-5x"></i>';
        break;
    case 'jpg':
        $icon = '<i class=" fa-sharp fa-solid fa-file-image fa-5x"></i>';
        break;
    case 'jpeg':
        $icon = '<i class=" fa-sharp fa-solid fa-file-image fa-5x"></i>';
        break;
    case 'png':
        $icon = '<i class=" fa-sharp fa-solid fa-file-image fa-5x"></i>';
        break;
    case 'mp4':
        $icon = '<i class=" fa-sharp fa-solid fa-file-video fa-5x"></i>';
        break;
    case 'pdf':
        $icon = '<i class=" fa-sharp fa-solid fa-file-pdf fa-5x"></i>';
        break;
    default:
        $icon = '<i class="fa-solid fa-circle-question fa-5x"></i>';
        break;
}

$file_download="../student/ass_upload/".$file;

?>


<div class="col-md-4">
   
   <?php echo $icon;  ?>
   <div class="col-sm-3"><label class="label"> <?php echo $file;  ?></label></a>
      
      </div>
</div>

<div class="col-md-4">

       <!-- Button trigger modal -->
<button type="button" class="btn btn-default btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
 Edit Submission
</button>


<button onclick="location.href='<?php echo $file_download ; ?>';" type="button" class="btn btn-primary">Download</button>



      
</div>



                            </div> 




    </div></div>
       
                                      <div class="col-md-12">
                                             <div class="form-floating">  
                                                 <div class="col-md-9">


                                                    <label for="formFile" class="form-label"><b>Student's Reflection:</b></label>
                                                    <p class="font-italic">Write your reflection after completed your activity assessments.</p>
                                             <div class="form-floating ">
<!-- Create the editor container -->            
    
  <textarea class="form-control" placeholder="Write Description" id="editor" name="std_reflection"  value="<?php  echo htmlentities($row->Student_Reflection); ?>"><?php  echo htmlentities($row->Student_Reflection); ?></textarea>


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


                                  <div class="col-md-4">
             <button class="btn btn-sm bg-info" type="submit" name="submit" onclick="return confirm('Are sure you want to submit?');">Submit</button>
                                <button class="btn btn-outline-info btn-sm " type="submit" name="save_draft">Save as Draft</button></div></form>
        
                               
             
 </div>
                                </div>
                            </div>
            <div>





</div>


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit File</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="upload_form" method="post" enctype="multipart/form-data">
           

   <!-- File Input -->
<div class="form-group">
  <label for="formFile">Upload file:</label>
  <label class="mb-2"><b>Only docs / doc/ pdf / mp4 / jpg /jpeg /png format allowed.</b></label>
<input class="form-control" type="file" name="ass_file" accept=".pdf, .doc, .docs, mp4, .png, .jpg, .jpeg" onchange="checkFileType(this)">
  <small class="form-text text-muted">Replace the current file by uploading a new one.</small>
</div>

<script>
  function checkFileType(input) {
    var file = input.files[0];
    var fileType = file.type;
    var allowedTypes = ["application/pdf", "application/msword", "video/mp4", "image/png", "image/jpg", "image/jpeg"];

    if (!allowedTypes.includes(fileType)) {
      if (!confirm("Invalid file type. Should be in .pdf, .docs, .doc, mp4, png, jpg, or jpeg.")) {
         input.value = "";
        return false;
      }
    }
    return true;
  }
</script>

<!-- Current File -->
<div class="form-group">
  <label for="currentFile">Current File:</label>
  <p id="currentFile" class="form-control-plaintext">
    <?php echo $currentfile; ?>
  </p>
</div>

<!-- Preview -->
<div class="form-group">
  <img id="preview" src="#" alt="File Preview" style="display: none; width: 150px;">
</div>

<!-- Upload/Replace button -->
<button type="submit" class="btn btn-primary" name="submit_file">Upload/Replace File</button></form>

<?php 

if(isset($_POST['submit_file'])){

  $pfile = $_FILES["ass_file"]["name"];
  $extension = substr($pfile,strlen($pfile)-4,strlen($pfile));
  $allowed_extensions = array("docs",".doc",".pdf",".mp4",".png",".jpg",".jpeg");
   

  


    //to validate type of file if not the same data will submit without file
    if(!in_array($extension,$allowed_extensions))
    {
      echo "<script>alert('Invalid type of file. Should be in .pdf, .docs, .doc, .mp4, .png, .jpg, or .jpeg');</script>" ;  
}
 else
  {

     if(file_exists('../student/ass_upload/'.$currentfile)){
    unlink('../student/ass_upload/'.$currentfile);
    $pfile = time().$pfile;
    move_uploaded_file($_FILES["ass_file"]["tmp_name"],"ass_upload/".$pfile);
    $sql_update="UPDATE tblsubmit_ass SET AssessmentFile=:file WHERE ID =:id";
    $query = $dbh->prepare($sql_update);
    $query->bindParam(':id',$editid,PDO::PARAM_STR); 
    $query->bindParam(':file',$pfile,PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    echo "<script>alert('File is replaced');</script>";  
  }else{
    $pfile = time().$pfile;
    move_uploaded_file($_FILES["ass_file"]["tmp_name"],"ass_upload/".$pfile);
    $sql_update="UPDATE tblsubmit_ass SET AssessmentFile=:file WHERE ID =:id";
    $query = $dbh->prepare($sql_update);
    $query->bindParam(':id',$editid,PDO::PARAM_STR); 
    $query->bindParam(':file',$pfile,PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    echo "<script>alert('File is replaced 1');</script>"; 
  }}
}


?>        
   

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
