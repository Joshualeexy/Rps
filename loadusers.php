<?php
//Starting the session
session_start();

//Including the connection file
include 'conn.php';

//If the user sends a game request
if (isset($_POST['sendreq'])) {
    //Fetching the data from the form
    $receiver = htmlspecialchars($_POST['receiver']);
    $sender = htmlspecialchars($_SESSION['id']);

    //Fetching the current date
    $date = date('y-m-d');

    //Query to get the details of the receiver
    $sql = "SELECT * FROM users WHERE id = '$receiver'";
    $result = mysqli_query($con, $sql);
    $receiver_array = mysqli_fetch_assoc($result);

    //Query to get the details of the sender
    $sql = "SELECT * FROM users WHERE id = '$sender'";
    $result = mysqli_query($con, $sql);
    $sender_array = mysqli_fetch_assoc($result);

    //Inserting the game request details into the database
    $sql = "INSERT INTO gamreq (sender,receiver,status,date) VALUES('$sender', '$receiver','pending', '$date' )";
    $result = mysqli_query($con, $sql);

    /*************************send game request email to receiver************************/
    //Email configuration
    $from = $siteEmailforgamerequest;
    $fromName = $sitenameforgamerequest;
    $to = $receiver_array['email'];
    $subject = 'New Game Request';
    $headers = "";
    $msg = "";
}

//Fetching the id of the user who is currently logged in
$id = $_SESSION['id'];

//Fetching the details of the sender
$sender = htmlspecialchars($_SESSION['id']);

//Fetching the list of users excluding the current user
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