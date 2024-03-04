<?php 
    include('include/dbconnection.php');
    session_start();

    if (!isset($_SESSION['admin_login'])) {
        header("newassessment.php");
    }

if(isset($_POST['btn_register'])) { 
    $name=$_POST['txt_name'];
    $username= $_POST['txt_username'];
    $password= $_POST['txt_password'];
    $role=$_POST['txt_role'];
  
    
        
    // checking empty fields
    if (empty($username)) {
        $errorMsg[] = "Please enter username";
    } else if (empty($name)) {
        $errorMsg[] = "Please enter name";
    } else if (empty($password)) {
        $errorMsg[] = "Please enter password";
    } else if (strlen($password) < 6) {
        $errorMsg[] = "Password must be atleast 6 characters";
    } else if (empty($role)) {
        $errorMsg[] = "please select role";
    } else {
        // if all the fields are filled (not empty) 
        //insert data to database
       try{

        $select_stmt = $dbh->prepare("SELECT username, name FROM user WHERE username = :u_username OR name = :uname");
        $select_stmt->bindParam(":u_username", $username);
        $select_stmt->bindParam(":uname", $name);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['username'] == $username) {
            $errorMsg[] = "Sorry UPMID already exists";
        } else if ($row['name'] == $name) {
            $errorMsg[] = "Sorry name already exists";
        } else if (!isset($errorMsg)) {
            $status=1;
            $insert_stmt = $dbh->prepare("INSERT INTO user(username, name, password, role,status)
             VALUES
             (:u_username, :uname, :upassword, :urole, :ustatus)");
            $insert_stmt->bindParam(":ustatus", $status);
            $insert_stmt->bindParam(":u_username", $username);
            $insert_stmt->bindParam(":uname", $name);
            $insert_stmt->bindParam(":upassword", $password);
            $insert_stmt->bindParam(":urole", $role);

            if ($insert_stmt->execute()) {
                $_SESSION['success'] = "Register Successfully...";
                header("location: manageuser.php");
            }
        }
            
        }
         catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
            }

       
    }}


?>

<!DOCTYPE html>
<html lang="en">


 <html lang="en">
     <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>PutraMD E-Portfolio | Create New user</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    
        <?php include_once('include/header.php');?>
        <?php include_once('include/sidebar.php');?>
        
                   <div id="layoutSidenav_content">
                    <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4"> Create New User</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="manageuser.php">Manage User</a></li>
                            <li class="breadcrumb-item active">Create New User</li>
                        </ol>
                       


                        <div id="main-content">
                            <div class="card-header bg-info">
                                    <h4>Create New User</h4> </div>
                            
                                    <div class="card-body mb-4">
                                         <div class="card-body">
                                                                                <?php 
                                            if (!empty($errorMsg)) {
                                                echo "<div class='alert alert-danger'>";
                                                foreach ($errorMsg as $error) {
                                                    echo $error . "<br>";
                                                }
                                                echo "</div>";
                                            }
                                        ?>

                                                        <?php if(isset($_SESSION['success'])) : ?>
                                    <div class="alert alert-success">
                                        <h3>
                                            <?php 
                                                echo $_SESSION['success'];
                                                unset($_SESSION['success']);
                                            ?>
                                        </h3>

                                        <?php endif ?>

                                    <?php if(isset($_SESSION['error'])) : ?>
                                        <div class="alert alert-danger">
                                            <h3>
                                                <?php 
                                                    echo $_SESSION['error'];
                                                    unset($_SESSION['error']);
                                                ?>
                                            </h3>
                                        </div>
                                    <?php endif ?>
                    <div class="row">
                            <div class="card mb-4">
                                
                                        <div class="row mb-3">
                                        <div class="col-md-6">
                                             <div class="form-floating">

                                             <form enctype="multipart/form-data" method="post">
                                       
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="name" type="name" name="txt_name"
                                                placeholder="Name" required/>

                                            <label for="txt_name">Fullname User</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="username" type="username"
                                                name="txt_username" placeholder="Matric Number/Mentor ID" required/>
                                            <label for="username">UPM ID</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="password" type="password"
                                                name="txt_password" placeholder="Password" onkeyup='check();' required/>
                                            <label for="password">Password</label>
                                        </div>
                                          <div class="form-floating mb-3">
                                            <input class="form-control" id="confirm_password" type="password"
                                                name="txt_password2" placeholder="Password" onkeyup='check();' />
                                            <label for="password">Confirm Password</label>
                                            <span id='message'></span>
                                        </div>
                                        <script>
    var check = function() {
        if (document.getElementById('password').value.length < 6) {
            document.getElementById('message').style.color = 'red';
            document.getElementById('message').innerHTML = 'Password must be atleast 6 characters';
        } else if (document.getElementById('password').value ==
            document.getElementById('confirm_password').value) {
            document.getElementById('message').style.color = 'green';
            document.getElementById('message').innerHTML = 'Matching';
        } else {
            document.getElementById('message').style.color = 'red';
            document.getElementById('message').innerHTML = 'Not matching';
        }
    }
</script>


                                        <div class="form-floating mb-3">
                                            <select class="form-select" aria-label="Choose Role" id="floatingSelect" name="txt_role" required>
                                            <label for="">Choose Role</label>
                                                <option >Select Role</option>
                                                <option value="Student">Student</option>
                                                <option value="Supervisor">Supervisor</option>
                                            </select>
                                            <label for="floatingSelect">Choose Role</label>
                                        </div>

                               
                                        <div class="form-floating">
                                            <div class="d-grid"><input class="btn btn-info " type="submit"
                                                    name="btn_register"></input></div>
                                        </div>
                                    




                                 
                            </form></div>
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
