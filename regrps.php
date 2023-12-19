<?php
session_start();
include 'conn.php';
if (isset($_SESSION['id'])) {
    header('location:rpst.php');
} else {
    if (isset($_POST['reg'])) {
        if (!empty($_POST['email'])) {
            $email = htmlspecialchars($_POST['email']);
            $username = explode('@', $email);
            $username = $username['0'];
        } else {
            $_SESSION['emailerr'] = true;
        }

        if (!empty($_POST['password'])) {
            $password = htmlspecialchars($_POST['password']);
            $hashedpassword = password_hash($password,PASSWORD_DEFAULT);
        } else {
            $_SESSION['passerr'] = true;
        }
        $date = date('y-m-d');


        if (empty($_SESSION)) {
            $sql2 = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($con, $sql2);
            if (mysqli_num_rows($result) > 0) {
                $result = mysqli_fetch_assoc($result);
                if (password_verify($password, $result['password'])) {
                    $sql = "UPDATE users SET online_status = '1' WHERE email = '$email'";
                     mysqli_query($con, $sql);
                    $_SESSION['actionN'] = 'control';
                    $_SESSION['game_status'] = 'NOT RUNNING';
                    $_SESSION['username'] =   ucfirst($result['usename']);
                    $_SESSION['id'] = $result['id'];
                    $_SESSION['email'] = $result['email'];
                    $_SESSION['score'] = 0;
                    $_SESSION['action'] = 'START GAME';
                    header("location:rpst.php");
                } else {
                }
            } else {

                $sql = "INSERT INTO users (usename,email,password,date,online_status) VALUES('$username','$email','$hashedpassword','$date','1')";
                if(mysqli_query($con, $sql)){
                $uid = mysqli_insert_id($con);
                $_SESSION['actionN'] = 'control';
                $_SESSION['game_status'] = 'NOT RUNNING';
                $_SESSION['username'] =  ucfirst($username);
                $_SESSION['id'] = $uid;
                $_SESSION['email'] = $email;
                $_SESSION['score'] = 0;
                $_SESSION['action'] = 'START GAME';
                
                header("location:rpst.php");
            }
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>rps</title>
</head>


<body>
    <P>
        <?php if (isset($page_err)) {
            echo $page_err;
        } ?>
    </P>


    <div class="div resultdiv">
        <h1>SIGN IN TO PLAY</h1>
        <form action="" method="post">

            <input type="email" placeholder="Enter Eail" name="email"> <br>
            <label for="" class="err"><?php

                                        if (isset($_SESSION['emailerr'])) {
                                            echo 'Error Email field cannot be empty<br>';
                                        };
                                        unset($_SESSION['emailerr']);

                                        ?></label>
            <br>
            <br>
            <input type="password" placeholder="password" name="password"><br>
            <label for="" class="err"><?php
                                        if (isset($_SESSION['passerr'])) {
                                            echo 'Error Password field cannot be empty';
                                            unset($_SESSION['passerr']);
                                        }
                                        ?>
            </label>
            <br>
            <br>

            <button type="submit" name="reg">submit</button>
        </form>
    </div>

</body>

</html>