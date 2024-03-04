<?php 
session_start();
error_reporting(0);
include('include/dbconnection.php');

 if (strlen($_SESSION['student_login'])==0) {
  header("location: logout.php");
    exit();
}



if(isset($_POST['submit']))
  {
    $uid=$_SESSION['student_login'];
    $fname=$_POST['name'];
    $pnotel=$_POST['notel'];
    $pemail=$_POST['email'];
    $sql="update user set name=:name, notel=:notel , email=:email where username=:uid";
     $query = $dbh->prepare($sql);
     $query->bindParam(':name',$fname,PDO::PARAM_STR);
     $query->bindParam(':notel',$pnotel,PDO::PARAM_STR);
     $query->bindParam(':email',$pemail,PDO::PARAM_STR);
     $query->bindParam(':uid',$uid,PDO::PARAM_STR);
     $query->execute();

        echo '<script>alert("Profile has been updated")</script>';
       echo "<script>window.location.href = 'profile.php'</script>"; 

  }
   


   if(isset($_POST['upload_file']))
{

$image= $_FILES["image_file"]["name"];
move_uploaded_file($_FILES["image_file"]["tmp_name"],"img_dir/".$_FILES["image_file"]["name"]);


$puser_dp=$image;
 $uid=$_SESSION['student_login'];
    $fname=$_POST['name'];
    $pnotel=$_POST['notel'];
    $pemail=$_POST['email'];
    $sql="update user set user_dp=:file where username=:uid";
     $query = $dbh->prepare($sql);
     $query->bindParam(':file',$image,PDO::PARAM_STR);
     $query->bindParam(':uid',$uid,PDO::PARAM_STR);
     $query->execute();

        echo '<script>alert("Profile has been updated")</script>';
       echo "<script>window.location.href = 'edit-profile.php'</script>"; 

 
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
        <title>PutraMD: Edit Profile</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    
        <?php include_once('include/header.php');?>
        <?php include_once('include/sidebar.php');?>
        
                   <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Edit User Profile</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Profile</a></li>
                            
                        </ol>
                        


                <main>
<?php $eid=$_SESSION['student_login'];

                        $sql="SELECT * from user where username=:eid";
                        $query = $dbh -> prepare($sql);
                        $query->bindParam(':eid',$eid,PDO::PARAM_STR);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);

                        $cnt=1;
                        if($query->rowCount() > 0)
                        {
                        foreach($results as $row)
                        {      

$user_dp=($row->user_dp);
$default_photo_url = "../img_dir/dp.png";
  // Profile photo URL
$profile_photo_url = (empty($user_dp)) ? $default_photo_url : $user_dp;

                        echo $_SESSION['imgsuccess'];         ?>
                              
                    <div class="card mb-4">
                            <div class="card-header">

  <img src="../student/img_dir/<?php echo $profile_photo_url; ?>"  class="img-thumbnail"
  style="width: 150px;" alt="No Profile Photo">
      <button class="btn btn-default bg-info" title="Edit Profile Photo" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa-solid fa-pen-to-square"></i></button>




                            </div>
                            <div class="card-body">
                               
                    
                                    <form method="post" name="hjhgh" enctype="multipart/form-data">

                                        
                                        <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" type="text" value="<?php  echo htmlentities($row->name);?>" placeholder="name" name="name" required="true" />
                                                        <label for="">Name</label>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" type="email_form"  placeholder="email" name="email" value="<?php  echo htmlentities($row->email);?>" required="true" />
                                                        <label for="">Email</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input class="form-control" type="tel" value="<?php  echo htmlentities($row->notel);?>" placeholder="Telephone Number" name="notel" pattern="[0-9]{3}-[0-9]{7}" required="true"  />
                                                        <small>01X-XXXXXXX 
                                                            </small>
                                                        <label for="">Telephone Number</label>
                                                    </div>
                                                </div>
                                            </div>
                                        


                                            
<?php $cnt=$cnt+1;}} 

?> 
                                <button class="btn btn-default bg-info sbmt-btn" type="submit" name="submit">Update</button>
                            </form>
                                





                            </div>
                        </div>
                    




                </main>

                <!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Change Profile Photo </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="upload_form" method="post" enctype="multipart/form-data">
           
  <img src="" id="preview_image" class="img-thumbnail"  style="width: 150px;" >

   <input class="form-control" type="file"  name="image_file" id="image_file" onchange="previewImage()" accept=".png, .jpg, .jpeg">

   
 <script>
  function previewImage() {
    var file = document.querySelector('#image_file').files[0];
    var preview = document.querySelector('#preview_image');
    var reader = new FileReader();
    reader.onloadend = function() {
      preview.src = reader.result;
    }
    if (file) {
      preview.style.display = "block";
      reader.readAsDataURL(file);
    } else {
      preview.src = "";
    }
  }
</script>
              

      </div>
      <div class="modal-footer">
      
        <button  type="submit" name="upload_file" class="btn btn-secondary" data-bs-dismiss="modal">Apply</button></form>
      </div>
    </div>
  </div>

 
</div>
       


          
                        
                                                <?php
                include_once('include/footer.php');
                ?>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="../assets/demo/chart-area-demo.js"></script>
        <script src="../assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="../js/datatables-simple-demo.js"></script>
    </body>
</html>

                                             
                                