<?php
include 'conn.php';
$gameid = $_POST['gameid'];

$sql = "SELECT * FROM users INNER JOIN game ON users.id = game.turn WHERE game.id = '$gameid'";
$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {
    $gamedata = mysqli_fetch_assoc($result);
    $currplayer = ucfirst($gamedata['usename']);
   echo "It's $currplayer's Turn To Play";
}
