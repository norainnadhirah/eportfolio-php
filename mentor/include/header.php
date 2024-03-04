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
$isread=0;
$idmentor=$_SESSION['mentor_login'];
$sql = "SELECT ID from tblstudent_mentor where IsRead=:isread AND IDMentor=:idmentor";
$query = $dbh -> prepare($sql);
$query->bindParam(':isread',$isread,PDO::PARAM_STR);
$query->bindParam(':idmentor',$idmentor,PDO::PARAM_STR);

$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$unreadcount=$query->rowCount();


//count notification for assessment
$isread1=0;
$idmentor=$_SESSION['mentor_login'];
$sql_submit = "SELECT ID from tblsubmit_ass where IsRead=:isread1 AND IDMentor=:id AND Status='1'";
$query = $dbh -> prepare($sql_submit);
$query->bindParam(':isread1',$isread1,PDO::PARAM_STR);
$query->bindParam(':id',$idmentor,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$unreadcount_ass=$query->rowCount();



?>


                                  <span class="badge rounded-pill badge-notification bg-danger"><?php echo ($unreadcount + $unreadcount_ass) !== 0 ? htmlentities($unreadcount + $unreadcount_ass) : '';
?></span></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li class="dropdown-item">Notifications</a></li>
<?php 
$status=1;
$isread1=0;
$sql = "SELECT tblsubmit_ass.ID as SubmitID,user.name,user.username,tblsubmit_ass.SubmitDate from tblsubmit_ass join user on tblsubmit_ass.IDStudent=user.username where tblsubmit_ass.IDMentor=:idmentor AND tblsubmit_ass.isRead=:isread AND tblsubmit_ass.Status=:status ORDER BY tblsubmit_ass.SubmitDate DESC";
$query = $dbh -> prepare($sql);
$query->bindParam(':idmentor',$idmentor,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':isread',$isread1,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{             

 $timeStamp = $result->SubmitDate;
$timeStamp1 = date("d/m/Y h:i a", strtotime($timeStamp));  ?>  


                                
                                     <li><a class="dropdown-item" href="evaluate-assessment.php?SubmitID=<?php echo htmlentities($result->SubmitID);?>"><p><b>
<?php echo htmlentities($result->name);?>(<?php echo htmlentities($result->username);?>)</b></br> has submit an assessment <span>at <b><?php echo htmlentities($timeStamp1);?></p></b></a></li>
                                   <?php }} ?>

<?php
//show notification of student choose the doctor as supervisor 
$isread=0;
$sql = "SELECT tblstudent_mentor.ID as StSvID,user.name,user.username,tblstudent_mentor.DateAsssigned from tblstudent_mentor join user on tblstudent_mentor.IDStudent=user.username where tblstudent_mentor.IDMentor=:idmentor AND tblstudent_mentor.IsRead=:isread";
$query = $dbh -> prepare($sql);
$query->bindParam(':idmentor',$idmentor,PDO::PARAM_STR);
$query->bindParam(':isread',$isread,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{             

 $timeStamp = $result->DateAsssigned;
$timeStamp1 = date("d/m/Y H:i a", strtotime($timeStamp));  ?>  


                                
                                     <li><a class="dropdown-item" href="confirm-mentor.php?stsvid=<?php 
                                     //stsvid stand for student supervisor id
                                     echo htmlentities($result->StSvID);?>"><p><b>
<?php echo htmlentities($result->name);?>(<?php echo htmlentities($result->username);?>)</b></br> choose you as supervisor <span>at <b><?php echo htmlentities($timeStamp1);?></p></b></a></li>
                                   <?php }} ?>   
                                    <li class="dropdown-item"><a href="oldnoti.php">See All</a></li>                                
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