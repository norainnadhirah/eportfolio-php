<?php 

    session_start();

     if (isset($_SESSION['admin_login'])) {
       header("location: admin/index.php");
      }

     if (isset($_SESSION['mentor_login'])) {
         header("location: mentor/index.php");
      }

      if (isset($_SESSION['student_login'])) {
       header("location: student/index.php");
      }

?>


<!DOCTYPE html>
<html lang="en">
    <head>
         <?php
                include_once('tabicon.php');
                ?>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Putra MD Login</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-secondary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-sm
                                 border-0 rounded-lg mt-5 mb-3">
                                    <div class="card-header">
                                        <div class="text-center">
                                            <img src="assets/img/upmlogo.png" class="img-responsive" width="150" height="70" >
                                        <h4 class="text-center font-weight-light my-2">PUTRAMD E-PORTFOLIO</h4></div></div>
                                    <div class="card-body">
                                    
                                                      <div>  <?php if(isset($_SESSION['success'])) : ?>
                                                        <div class="alert alert-success">
                                                            <p>
                                                                <?php 
                                                                    echo $_SESSION['success'];
                                                                    unset($_SESSION['success']);
                                                                ?>
                                                            </p>
                                                        </div>
                                                    <?php endif ?>
                                                    <?php
                                                    if(isset($_SESSION['error'])):?>
                                                        <div class="alert alert-danger">
                                            
                                                                <?php 
                                                                    echo $_SESSION['error'];
                                                                    unset($_SESSION['error']);
                                                                ?>
                                                            
                                                        </div>
                                                    <?php endif ?>
                                            </div>
                                        <form action="login_auth.php" method="POST" class="form-horizontal my-5">
                                            <div class="form-floating mb-3">
                                                <input class="form-control"  id="txt_username" name="txt_username"  placeholder="Id" required />
                                                <label for="inputUsername">UPM ID</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="txt_password"  name="txt_password" type="password" placeholder="Password" required/>
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            
                                            <div class="d-flex align-items-center justify-content-between mt-3 mb-0">
                                                <input type="submit" name="btn_login"  class="btn btn-primary" value="Login">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3 mb-3">
                                        <div class="small"><a href="register.php">Sign up to active your account!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; PUTRAMD E-PORTFOLIO 2022</div>
                           
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
