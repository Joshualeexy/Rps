<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['id'])) {
  header('location:index.php');
} elseif (isset($_SESSION['game_status']) && $_SESSION['game_status'] == 'RUNNING') {
  header('location:rps.php');
}

if (isset($_POST['uservscomp'])) {
  $_SESSION['round'] = 1;
  $_SESSION['game'] = 0;
  $_SESSION['winner'] = ' ';

  header("location: rps.php");
}


if (isset($_POST['logout'])) {
  $id = $_SESSION['id'];
  $sql = "UPDATE users SET online_status = '0' WHERE id = '$id'";
  mysqli_query($con, $sql);
  session_unset();
  header('location:index.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css">
  <title>rps</title>
</head>
<style>
  form {
    width: 100%;
  }
</style>

<body>
  <p>
    <?php if (isset($page_err)) {
      echo $page_err;
    } ?>
  </p>

  <div class="resultdiv">
    <h2>CHOOSE YOUR GAME STYLE</h2>
    <form action="" method="post">



    <form action="" method="post">
      <button type="submit" name="uservscomp" class="choice">
        <span>player 1</span>
        <span>vs</span>
        <span>computer </span>
      </button>
    </form>

    <form action="" method="post">
      <button class="choice logout" id="reset" type="submit" name="logout">LOGOUT</button>
    </form>
  </div>
</body>

</html>