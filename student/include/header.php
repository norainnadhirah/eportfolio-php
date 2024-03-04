<body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">


            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Brand-->
            <img src="../assets/img/upmlogo.png" class="position-relative" width="80" height=""><a class="navbar-brand ps-3" href="index.php">PUTRAMD E-PORTFOLIO</a>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                 
                </div>
            </form>
            <!-- Navbar-->
             <!-- Notification dropdown -->
      <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-bell"></i>
                      
<?php 
//counter for badge notification
$isread=0;
$idstudent=$_SESSION['student_login'];
$sql = "SELECT ID, IDMentor from tblstudent_mentor where StdIsRead=:isread AND IDStudent=:idstudent AND Status='Approved'";
$query = $dbh -> prepare($sql);
$query->bindParam(':isread',$isread,PDO::PARAM_STR);
$query->bindParam(':idstudent',$idstudent,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$unreadcount=$query->rowCount();


//count notification for assessment
$isread1=0;
$idstudent=$_SESSION['student_login'];
$sql_submit = "SELECT ID, IDMentor from tblsubmit_ass where stdIsRead=:isread1 AND IDStudent=:idstudent AND Status='3'";
$query = $dbh -> prepare($sql_submit);
$query->bindParam(':isread1',$isread1,PDO::PARAM_STR);
$query->bindParam(':idstudent',$idstudent,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$unreadcount_ass=$query->rowCount();

?>



                                  <span class="badge rounded-pill badge-notification bg-danger">
<?php echo ($unreadcount + $unreadcount_ass) !== 0 ? htmlentities($unreadcount + $unreadcount_ass) : '';
?></span></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li class="dropdown-item">Notifications</li>


<?php 

//fetch idmentor
$stmt = $dbh->prepare("SELECT IDMentor FROM tblsubmit_ass WHERE IDStudent = :idstudent");
$stmt->bindParam(':idstudent', $idstudent, PDO::PARAM_STR);
$stmt->execute();
$idmentor = $stmt->fetchColumn();

$status=3;
$isread1=0;
$sql = "SELECT tblsubmit_ass.ID as SubmitID,user.name,user.username,tblsubmit_ass.EvaluateDate , tblsubmit_ass.Status from tblsubmit_ass join user on tblsubmit_ass.IDMentor=user.username where tblsubmit_ass.IDStudent=:idstudent AND tblsubmit_ass.stdIsRead=:isread  AND tblsubmit_ass.Status=:status
ORDER BY tblsubmit_ass.EvaluateDate ";
$query = $dbh -> prepare($sql);
$query->bindParam(':idstudent',$idstudent,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':isread',$isread1,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{             

 $timeStamp = $result->EvaluateDate;
$timeStamp1 = date("d/m/Y h:i a", strtotime($timeStamp));  ?>  


                                
                                     <li><a class="dropdown-item" href="view-completed-assessment.php?SubmitID=<?php echo htmlentities($result->SubmitID);?>"><p><b>
<?php 

    $name = $result->name;
    if (stripos($name, "Dr.") === false) {
        echo "Dr. " . $name;
    } else {
        echo $name;
    }




?></b> has evaluated your assessment <span>at <b><?php echo htmlentities($timeStamp1);?></p></b></a></li>
                                   <?php }} ?>



<?php
//notification supervisor approved you
$isread=0;
$sql = "SELECT tblstudent_mentor.ID as StSvID,user.name,user.username,tblstudent_mentor.DateAsssigned from tblstudent_mentor join user on tblstudent_mentor.IDMentor=user.username where tblstudent_mentor.IDStudent=:idstudent AND tblstudent_mentor.StdIsRead=:isread AND tblstudent_mentor.Status='Approved'";
$query = $dbh -> prepare($sql);
$query->bindParam(':idstudent',$idstudent,PDO::PARAM_STR);
$query->bindParam(':isread',$isread,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{             
 ?>  
                                
        <li><a class="dropdown-item" href="supervisor.php?stsvid=<?php 
         //stsvid stand for student supervisor id
    echo htmlentities($result->StSvID);?>"><p><b><?php 
    $name = $result->name;if (stripos($name, "Dr.") === false) {echo "Dr. " . $name;} 
    else { echo $name;}

?></b></br> has approved you.</p></b></a></li>
                                   <?php }} ?> 

                         <li class="dropdown-item"><a href="oldnoti.php" class="text-center">See All</a></li>                                              
                    </ul>

                </li>
              
      <!-- Notification dropdown -->
            </ul>

            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="setting.php">Settings</a></li>
                        <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                    </ul>

                </li>
   
        </nav>