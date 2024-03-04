<?php 
    require_once 'dbconnection.php';

    session_start();

    if (isset($_POST['btn_login'])) {
        $username = $_POST['txt_username']; // username value
        $password = $_POST['txt_password']; // password

            try {
                                $select_stmt = $dbh->prepare("SELECT username, password,role FROM user WHERE username = :u_username AND password = :upassword");
                                $select_stmt->bindParam(":u_username", $username);
                                $select_stmt->bindParam(":upassword", $password);

                                if($select_stmt->execute()){
                                    //trying to fetch role from selected row
                                    $stmt = $dbh->prepare("SELECT role, Status FROM user WHERE username = :u_username"); 
                                    $stmt->bindValue('u_username', $username);
                                    $stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$role = $result['role'];
$dbstatus = $result['Status'];

                                    while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $dbusername = $row['username'];
                                        $dbpassword = $row['password'];
                                        $dbrole = $role;
                                       
                                    }
                                                if ($username != null AND $password != null AND $role != null) {
                                                    if ($select_stmt->rowCount() > 0) {
                                                                        if ($username == $dbusername AND $password == $dbpassword AND $role == $dbrole) {
                                                            
                                                                                    switch($dbstatus){

                                                                                        case '1' :
                                                                                            switch($dbrole) {
                                                                                                case 'admin':
                                                                                                    $_SESSION['admin_login'] = $username;
                                                                                                    
                                                                                                    $_SESSION['success'] = "Admin... Successfully Login...";
                                                                                                    header("location: ../putramd/admin/index.php");


                                                                                                break;
                                                                                                case 'Supervisor':
                                                                                                    $_SESSION['mentor_login'] = $username;
                                                                                                    //$_SESSION['success'] = "User... Successfully Login...";
                                                                                                    header("location: ../putramd/mentor/index.php");
                                                                
                                                                                                break;
                                                                                                case 'Student':
                                                                                                    $_SESSION['student_login'] = $username;


$stmt = $dbh->prepare("SELECT * FROM tblstudent_mentor WHERE IDStudent = ?");
$stmt->execute([ $_SESSION['student_login'] ]);

// Fetch the student's data as an associative array
$student = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the student has a supervisor
if ($student['Status'] == 'Approved') {
// The student has a teacher
/* head to index index*/
header("location: ../putramd/student/index.php");

} if($student['Status'] == null){
// The student does not have a supervisor
 header("location: ../putramd/student/assign-mentor.php?editid=<?php echo htmlentities ($row->ID);?>");
}if($student['Status'] == 'In process'){
// The student in process/ in waiting
 header("location: ../putramd/student/waiting.php?editid=<?php echo htmlentities ($row->ID);?>");
}if($student['Status'] == 'Not Approved'){
// The student supervisor is Not Approved
 header("location: ../putramd/student/assign-mentor2.php?editid=<?php echo htmlentities ($row->ID);?>");
}



                                                                                                    
                                                                                                break;
                                                                                                default:      
                                                                                            }

                                                                                            break;
                                                                                        case '0':
                                                                                            $_SESSION['error'] = "Not active. contact admin to active your account";
                                                                                            header("location: ../putramd/index.php");
                                                                                            break;
                                                                                            default:    
                                                                                            

                                                                                            
                                                                                    }



                                                                                               




                                                                                                
                                                                        }
                                                                        
                                                        }
                                                        else{
                                                                         $_SESSION['error'] = "Wrong Password";
                                                                        header("location: ../putramd/index.php");
                                                
                                                                            }


                                                    }else{
                                                        //when the upmid is wrong
                                                        $_SESSION['error'] = "Wrong UPMID";
                                                        header("location: ../putramd/index.php");           
                                                    }
                                }

            }
             catch(PDOException $e) {
               // $e->getMessage();

            }
        
    }

?>