<!DOCTYPE html>
<html lang="en">

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







<head>
      <?php
                include_once('tabicon.php');
                ?>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Register PutraMD E-Portfolio</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-info">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-4">
                                <div class="card-header">
                                    <h4 class="text-center font-weight-light my-2">PUTRAMD E-PORTFOLIO REGISTRATION
                                    </h4>
                                </div>
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
                                    
                                    <form action="register_auth.php" method="post">
                                       
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="name" type="name" name="txt_name"
                                                placeholder="Name" required/>
                                            <label for="txt_name">Your Name</label>
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

                                        <div class="form-floating mb-3">
                                            <select class="form-select" aria-label="Choose Role" id="floatingSelect" name="txt_role" required>
                                            <label for="">Choose Role</label>
                                             
                                                <option value="Student">Student</option>
                                                <option value="Supervisor">Supervisor</option>
                                            </select>
                                            <label for="floatingSelect">Choose Role</label>
                                        </div>

                               
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid"><input class="btn btn-primary btn-block" type="submit"
                                                    name="btn_register"></input></div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="index.php">Go to login</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-info mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; PutraMD Eportfolio 2022</div>
                        <div>

                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js"></script>


</body>

</html>