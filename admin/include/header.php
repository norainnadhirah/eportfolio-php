<body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Brand-->
            <img src="../assets/img/upmlogo.png" class="position-relative" width="80" height=""><a class="navbar-brand ps-3" href="index.php">PUTRAMD E-PORTFOLIO ADMIN</a>
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
$sql = "SELECT * FROM user WHERE IsRead=:isread AND username != 'admin'";
$query = $dbh -> prepare($sql);
$query->bindParam(':isread',$isread,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$unreadcount=$query->rowCount();
?>

                                  <span class="badge rounded-pill badge-notification bg-danger">
<?php echo ($unreadcount) !== 0 ? htmlentities($unreadcount) : '';
?></span></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li class="dropdown-item">Notifications</li>


<?php 

//fetch user id name 
$query = $dbh->prepare("SELECT username, userid, name, regdate,role FROM user where IsRead=0 AND username != 'admin'");
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
     {
foreach($results as $result)
{             

 $timeStamp = $result->regdate;
$timeStamp1 = date("d/m/Y h:i a", strtotime($timeStamp)); 

$id = $result->userid;

?>  


                                
                                     <li><a class="dropdown-item" href="edit-user.php?editid=<?php echo $id;?>"><p><b>
<?php 
$name = $result->name;
$role = $result->role;
if ($role === "Supervisor" && stripos($name, "Dr.") === false) {
    echo "Dr. " . $name;
} else {
    echo $name;
}

?></b> created account <span>at <b><?php echo htmlentities($timeStamp1);?></p></b></a></li>
                                   <?php }} ?>

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