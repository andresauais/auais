<?php
//log in section
if (isset($_POST['login-submit'])) {
    require 'connectDB.php';
    //gets login info from user when logging in.
    $username = $_POST['username'];
    $password = $_POST['password'];

    //checks if fields are empty
    if (empty($username) || empty($password)){
        header("Location: ../Home.php?errorfields");
        exit();
    }
    //if not empty checks if user exists and checks credentials
    else{
        $sql = "SELECT * FROM Member WHERE Username=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../Home.php?error=sqlerror");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);

            if(!empty($row)){
                if ($password != $row['Password']){
                    header("Location: ../Home.php?error=wrongpass");
                    exit();
                }
                elseif($password == $row['Password']){
                    session_start();
                    $_SESSION['Username'] = $row['Username'];
                    header("Location: ../Home.php?success");
                    exit();
                }
                else{
                    header("Location: ../Home.php?error=wrongwrongpass");
                    exit();
                }
            }
            else{
                header("Location: ../Home.php?error=nouser");
                exit();
            }
        }
    }

}
else{
    header("Location: ../Home.php");
    exit();
}

