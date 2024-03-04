<?php 

    require_once "dbconnection.php";

    session_start();
						
	if(isset($_POST['btn_register'])) {	
	$name=$_POST['txt_name'];
	$username= $_POST['txt_username'];
	$password= $_POST['txt_password'];
    $role=$_POST['txt_role'];
     $status=1;
  
	
		
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
            $errorMsg[] = "Sorry id already exists";
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
                header("location: index.php");
            }
        }
            
        }
         catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
            }

       
    }
}
?>