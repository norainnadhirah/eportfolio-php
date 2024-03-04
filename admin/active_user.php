<?php
require_once "include/dbconnection.php";


    session_start();

if(isset($_POST['activate_user']))
  {
    $st=1;
    $uid=$_GET['editid'];
    $sql="update user set Status=:status where userid=:uid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':status',$st,PDO::PARAM_STR);
    $query->bindParam(':uid',$uid,PDO::PARAM_STR);
    $query->execute();
    if ($query->rowCount() > 0) {
        echo '<script>alert("Profile has been updated");</script>';
        header("Location: edit-user.php?editid=$uid");
    } else {
        echo '<script>alert("Error updating profile, please try again");</script>';
    }
  }
   

if(isset($_POST['deactivate_user']))
  {
    $st=0;
    $uid=$_GET['editid'];
    $sql="update user set Status=:status where userid=:uid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':status',$st,PDO::PARAM_STR);
    $query->bindParam(':uid',$uid,PDO::PARAM_STR);
    $query->execute();
    if ($query->rowCount() > 0) {
        echo '<script>alert("Profile has been updated");</script>';
        header("Location: edit-user.php?editid=$uid");


    } else {
        echo '<script>alert("Error updating profile, please try again");</script>';
    }
  }

  ?>