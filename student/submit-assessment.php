<?php 
    include('include/dbconnection.php');
    session_start();

    if (!isset($_SESSION['student_login'])) {
        header("../logout.php");
    }else{



$idass=$_GET['id'];
//retreive IDprogram and assesssment from tblasessement
$sql = "SELECT IDProgram,AssessmentName FROM tblassessment WHERE ID=:idass";
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

}}


//retrieve ID mentor from tblstudent_mentor
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



//data will submit to the supervisor

if(isset($_POST['submit']))
{
  $pidprogram=$idprogram; 
  $pidmentor=$idmentor;
  $pidstudent=$idstd;
  $pidass=$idass;
  $ptitle_ass=$_POST['title_ass'];
  $pstatus=1;  
  $preflection=$_POST['std_reflection'];
  $pfile = $_FILES["ass_file"]["name"];
  $extension = substr($pfile,strlen($pfile)-4,strlen($pfile));
  $allowed_extensions = array("docs",".doc",".pdf",);
   


    //to validate type of file if not the same data will submit without file
    if(!in_array($extension,$allowed_extensions))
    {
    echo "<script>alert('Invalid type of file. Should be in .pdf, .docs, or .doc');</script>" ; 
        

     $sql_insert="INSERT INTO tblsubmit_ass(IDProgram,IDAssessment,IDStudent,IDMentor,AssSubmitTitle,Student_Reflection,Status) VALUES (:programid,:idass,:idstudent,:idmentor,:ass_title,:std_refl,:status)";
    $query = $dbh->prepare($sql_insert);
    $query->bindParam(':programid',$pidprogram,PDO::PARAM_STR);
    $query->bindParam(':idass',$pidass,PDO::PARAM_STR);
    $query->bindParam(':idstudent',$pidstudent,PDO::PARAM_STR);
    $query->bindParam(':idmentor',$pidmentor,PDO::PARAM_STR);
    $query->bindParam(':ass_title',$ptitle_ass,PDO::PARAM_STR);
    $query->bindParam(':std_refl',$preflection,PDO::PARAM_STR);
    $query->bindParam(':status',$pstatus,PDO::PARAM_STR);
    $query->execute();
    echo "<script>alert('Assessment Submit Without Document Uploaded');</script>"; 
     ?> <script>window.location.href = 'manage-assessments.php'' ?>'</script>  
  <?php
}



  else
  {
    $pfile = time().$pfile;
    move_uploaded_file($_FILES["ass_file"]["tmp_name"],"ass_upload/".$pfile);
    $sql_insert="INSERT INTO tblsubmit_ass(IDProgram,IDAssessment,IDStudent,IDMentor,AssSubmitTitle,AssessmentFile,Student_Reflection,Status) VALUES (:programid,:idass,:idstudent,:idmentor,:ass_title,:file,:std_refl,:status)";
    $query = $dbh->prepare($sql_insert);
    $query->bindParam(':programid',$pidprogram,PDO::PARAM_STR);
    $query->bindParam(':idass',$pidass,PDO::PARAM_STR);
    $query->bindParam(':idstudent',$pidstudent,PDO::PARAM_STR);
    $query->bindParam(':idmentor',$pidmentor,PDO::PARAM_STR);
    $query->bindParam(':ass_title',$ptitle_ass,PDO::PARAM_STR);
    $query->bindParam(':file',$pfile,PDO::PARAM_STR);
    $query->bindParam(':std_refl',$preflection,PDO::PARAM_STR);
    $query->bindParam(':status',$pstatus,PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    echo "<script>alert('Assessment Submit to the Supervisor');</script>"; 
    echo "<script>window.location.href = 'manage-assessments.php'</script>";   
  }

}


//save assessment as draft
if(isset($_POST['save_draft']))
{
  $pidprogram=$idprogram; 
  $pidmentor=$idmentor;
  $pidstudent=$idstd;
  $pidass=$idass;
  $ptitle_ass=$_POST['title_ass'];
  $pstatus=0;  
  $preflection=$_POST['std_reflection'];
  $pfile = $_FILES["ass_file"]["name"];
  $extension = substr($pfile,strlen($pfile)-4,strlen($pfile));
  $allowed_extensions = array("docs",".doc",".pdf",".mp4",".png",".jpg",".jpeg");
   


    //to validate type of file if not the same data will submit without file
    if(!in_array($extension,$allowed_extensions))
    {
    echo "<script>alert('Invalid type of file. Should be in .pdf, .docs, .doc, .mp4, .png, .jpg, or .jpeg');</script>" ; 
        

     $sql_insert="INSERT INTO tblsubmit_ass(IDProgram,IDAssessment,IDStudent,IDMentor,AssSubmitTitle,Student_Reflection,Status) VALUES (:programid,:idass,:idstudent,:idmentor,:ass_title,:std_refl,:status)";
    $query = $dbh->prepare($sql_insert);
    $query->bindParam(':programid',$pidprogram,PDO::PARAM_STR);
    $query->bindParam(':idass',$pidass,PDO::PARAM_STR);
    $query->bindParam(':idstudent',$pidstudent,PDO::PARAM_STR);
    $query->bindParam(':idmentor',$pidmentor,PDO::PARAM_STR);
    $query->bindParam(':ass_title',$ptitle_ass,PDO::PARAM_STR);
    $query->bindParam(':std_refl',$preflection,PDO::PARAM_STR);
    $query->bindParam(':status',$pstatus,PDO::PARAM_STR);
    $query->execute();
    echo "<script>alert('Assessment Saved as draft without document upload');</script>"; 
     ?> <script>window.location.href = 'manage-assessments.php'</script>  
  <?php
}



  else
  {
    $pfile = time().$pfile;
    move_uploaded_file($_FILES["ass_file"]["tmp_name"],"ass_upload/".$pfile);
    $sql_insert="INSERT INTO tblsubmit_ass(IDProgram,IDAssessment,IDStudent,IDMentor,AssSubmitTitle,AssessmentFile,Student_Reflection,Status) VALUES (:programid,:idass,:idstudent,:idmentor,:ass_title,:file,:std_refl,:status)";
    $query = $dbh->prepare($sql_insert);
    $query->bindParam(':programid',$pidprogram,PDO::PARAM_STR);
    $query->bindParam(':idass',$pidass,PDO::PARAM_STR);
    $query->bindParam(':idstudent',$pidstudent,PDO::PARAM_STR);
    $query->bindParam(':idmentor',$pidmentor,PDO::PARAM_STR);
    $query->bindParam(':ass_title',$ptitle_ass,PDO::PARAM_STR);
    $query->bindParam(':file',$pfile,PDO::PARAM_STR);
    $query->bindParam(':std_refl',$preflection,PDO::PARAM_STR);
    $query->bindParam(':status',$pstatus,PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    echo "<script>alert('Assessment Saved as draft');</script>"; 
    echo "<script>window.location.href = 'manage-assessments.php'</script>";   
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
      <title>PutraMD Student | Assessment</title>

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
                        <h1 class="mt-4">Submit New Assessments</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                           
                            <li class="breadcrumb-item active"><a href="all-assessments.php?id=<?php echo$idass;?>"><?php echo htmlentities($ass_name); ?></a></li>
                            <li class="breadcrumb-item active">Submit New Assessments</li>
                            
                        </ol>
                       

<div class="modal" id="invalidFileModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Invalid file format</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p>Only .pdf and .doc file formats are allowed.</p>
      </div>
    </div>
  </div>
</div>

                        <div id="main-content">
                        <div class="row">
                            <div class="col-xl-12 ">
                                <div class="card mb-4">
                                    <div class="card-header bg-info">
                                        <i class="fa-solid fa-pen-to-square me-1"></i> 
                                        Submit New 
                                        <?php 
                                        echo $ass_name;
                                        ?>
                                    </div>
                                     <form method="post" name="hjhgh" enctype="multipart/form-data">
                                    <div class="card-body">
                                     <div class="col-md-12">
                                              <div class="form-floating mb-4">
                                                        <input class="form-control" id="title_ass" type="text"  name="title_ass" required />
                                                        <label for="title_ass" class="form-label">Assessments Title</label>
                                                    </div>


                                                    <div class="col-md-12 mb-4">
                                             <div class="form-floating">  
                                                 <div class="col-md-4 mb-2">
                                                    <label for="formFile" class="form-label">Upload file:</label>
                                                    <label class="mb-2"><b>
                                                    Only mp4, png, jpg, jpeg and pdf format allowed.</b></label>
                                                    <input class="form-control" type="file" name="ass_file" accept=".pdf, .doc, .docs, .mp4, .png, .jpg, .jpeg" onchange="checkFileType(this)">
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

                                      </div> </div> 

<div class="col-md-12 d-flex align-items-center mb-4">
    <div class="col-md-12 ">

   

</div></div>
                                      <div class="col-md-12">
                                             <div class="form-floating">  
                                                 <div class="col-md-9">


                                                    <label for="formFile" class="form-label"><b>Student's Reflection:</b></label>
                                                    <p class="font-italic">Write your reflection after completed your activity assessments.</p>
                                             <div class="form-floating ">
<!-- Create the editor container -->            
    
  <textarea class="form-control" placeholder="Write Description" id="editor" name="std_reflection" ></textarea>


    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );

            } );


    </script>




                                             </div>

                                                  
                                                </div>

                                      </div> </div> 

                                         </div>






                                    </div>
             
                                     <div class=" card-footer d-flex form-floating">
             
                                <button class="btn btn-sm bg-info" type="submit" name="submit" onclick="return confirm('Are sure you want to submit?');">Submit</button>
                                <button class="btn btn-outline-info btn-sm " type="submit" name="save_draft">Save as Draft</button>
                               
                                </div>

                                </div>

                                </div>
                            </div>




</form><?php } ?>


                     
                        
                    </div>
                </main>

                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; PutraMD Eportfolio 2022</div>
                          
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
       
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="../assets/demo/chart-area-demo.js"></script>
        <script src="../assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="../js/datatables-simple-demo.js"></script>
        <script src="../js/ckeditor.js"></script>
        <script src="../js/ckeditor.js.map"></script>
    </body>
</html>


