<?php
session_start();
include 'conn.php';
if (!isset($_SESSION['id'])) {
    header('location:regrps.php');
}
if (isset($_POST['logout'])) {
    $id = $_SESSION['id'];
    $sql = "UPDATE users SET online_status = '0' WHERE id = '$id'";
    mysqli_query($con, $sql);
    session_unset();
    header('location:regrps.php');
}
if (isset($_POST['sendreq'])) {
    $receiver = htmlspecialchars($_POST['receiver']);
    $sender = htmlspecialchars($_SESSION['id']);
    $date = date('y-m-d');
    $sql = "SELECT * FROM users WHERE id = '$receiver'";
    $result = mysqli_query($con,$sql);
    $receiver_array = mysqli_fetch_assoc($result);
    
    $sql = "SELECT * FROM users WHERE id = '$sender'";
    $result = mysqli_query($con,$sql);
    $sender_array = mysqli_fetch_assoc($result);

    $sql = "INSERT INTO gamreq (sender,receiver,status,date) VALUES('$sender', '$receiver','pending', '$date' )";
    $result = mysqli_query($con, $sql);

    /*************************send game request email to receiver************************/
    $from = $siteEmailforgamerequest;
    $fromName = $sitenameforgamerequest;
    $to = $receiver_array['email'];
    $subject = 'New Game Request';
    $headers;
    $msg ="
    
    
    ";
}

if (isset($_POST['reject'])) {
    $reqid = htmlspecialchars($_POST['reqid']);
    $sql = "DELETE FROM gamreq WHERE gid = '$reqid'";
    mysqli_query($con, $sql);

}


$id = $_SESSION['id'];
$sender = htmlspecialchars($_SESSION['id']);

$sql = "SELECT * FROM users WHERE id != '$id'";
$result = mysqli_query($con, $sql);

$sql = "SELECT * FROM gamreq INNER JOIN users ON gamreq.sender = users.id WHERE receiver = '$id' AND status = 'pending'";

$gr = mysqli_query($con, $sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="main.css">
    <script src="jquery.js"></script>
    <title>rps</title>
</head>


<body>
    <p>
        <?php if (isset($page_err)) {
            echo $page_err;
        } ?>
    </p>

    <div class="resultdivv">
        <h2>SEND GAME REQUEST</h2>
        <form action="" method="post">
            <input type="search" name="searchfriend" placeholder="Enter Friend's Username"> <button type="submit" value="search" name="search">search </button>
            <br>
            <br>
        </form>


        <section>
       <div class="" id="loadusersdiv">
        
       </div>


            <div class="container">
                <h2>RECEIVED GAME REQUEST</h2>
                <br>
                <br>
                <?php
                while ($req = mysqli_fetch_assoc($gr)) { ?>

                    <div style="margin-bottom:20px">
                        <div class="" style="margin-bottom:10px">
                            <button type="button" name="gamesender" value="" class="choice ert">
                                <p><?= $req['usename'] ?> :</p>
                                <small>sent you a game request</small>
                            </button>
                        </div>

                        <form action="" method="post" class="actform">
                            <button type="submit" name="accept">Accept</button>
                            <input type="text" name="reqsender" hidden value="<?= $req['sender'] ?>">

                            <input type="text" name="reqid" hidden value="<?= $req['gid'] ?>">
                            <button type="submit" name="reject">Reject</button>
                        </form>
                    </div>
                <?php } ?>

            </div>
        </section>


        <form action="" method="post" style="margin-top:20px">
            <button class="choice logout" id="reset" type="submit" name="logout">LOGOUT</button>
        </form>
    </div>
    <?php
    if (isset($_POST['accept'])) {
        $requestid = $_POST['reqid'];
        $sql = "SELECT * FROM gamreq WHERE gid = '$requestid'";
        $result = mysqli_query($con,$sql);
        $result = mysqli_fetch_assoc($result);
        $sender = $result['sender'];
        $receiver = $result['receiver'];
        $gamerequestid = $result['gid'];
        $date = date('Y-m-d h:i:s');
        $sql = "DELETE FROM gamreq WHERE gid = '$gamerequestid'";
        mysqli_query($con, $sql);

        $sql = "INSERT INTO game (player_1,player_2,gamerequestid,date,turn) VALUE('$receiver','$sender',$gamerequestid,'$date','$receiver')";
        $result = mysqli_query($con, $sql);
        $gamerequestid = mysqli_insert_id($con);
        echo "<script> window.location.href = 'play.php?gameid=$gamerequestid'</script>
";

    }
    ?>
    <script src="rps.js"></script>
</body>

</html>