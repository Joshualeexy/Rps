<?php
session_start();
include 'conn.php';
if (isset($_POST['sendreq'])) {
    $receiver = htmlspecialchars($_POST['receiver']);
    $sender = htmlspecialchars($_SESSION['id']);
    $date = date('y-m-d');
    $sql = "SELECT * FROM users WHERE id = '$receiver'";
    $result = mysqli_query($con, $sql);
    $receiver_array = mysqli_fetch_assoc($result);

    $sql = "SELECT * FROM users WHERE id = '$sender'";
    $result = mysqli_query($con, $sql);
    $sender_array = mysqli_fetch_assoc($result);

    $sql = "INSERT INTO gamreq (sender,receiver,status,date) VALUES('$sender', '$receiver','pending', '$date' )";
    $result = mysqli_query($con, $sql);

    /*************************send game request email to receiver************************/
    $from = $siteEmailforgamerequest;
    $fromName = $sitenameforgamerequest;
    $to = $receiver_array['email'];
    $subject = 'New Game Request';
    $headers;
    $msg = "";
}
$id = $_SESSION['id'];
$sender = htmlspecialchars($_SESSION['id']);
$sql = "SELECT * FROM users WHERE id != '$id'";
$result = mysqli_query($con, $sql);
?>

<div class="container">
    <?php
    while ($sser = mysqli_fetch_assoc($result)) {
        $receiver = $sser['id'];
        $sender = $_SESSION['id'];
        $sqlrt = "SELECT * FROM gamreq WHERE sender = '$sender' AND receiver = '$receiver'";
        $statusresult = mysqli_query($con, $sqlrt);
        if (mysqli_num_rows($statusresult) > 0) {
            $statusrow = mysqli_fetch_assoc($statusresult);
            $statusAct = $statusrow['status'];
            $statusActcolor = 'black';
        }

            else {
            $statusAct = 'send';
            $statusActcolor = 'crimson';
        }



        if ($sser['online_status'] == '1') {
            $onlinestatus = 'online';
        } else {

            $onlinestatus = 'offline';
        }
    ?>
        <a>
            <button type="button" name="uservsuser" class="choice ">
                <p><?= ucfirst($sser['usename']) ?>
                </p>
                <small><?php echo $onlinestatus ?></small>
            </button>
            <form action="" method="POST">
                <input type="text" hidden value="<?= $sser['id'] ?>" name="receiver">
                <button type="submit" class="choicee" style="background-color: <?= $statusActcolor ?>;" name="sendreq"><?= $statusAct ?></button>
            </form>
        </a>
    <?php } ?>
</div>