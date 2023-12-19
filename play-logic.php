<?php
session_start();
include 'conn.php';
$gameid = $_GET['gameid'];

$sql = "SELECT * FROM game INNER JOIN users ON game.player_1 = users.id WHERE game.id = '$gameid'";
$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {
    $gamedata = mysqli_fetch_assoc($result);
    $player1 = $gamedata['usename'];
    if ($gamedata['status'] == 'START GAME') {
        $gameStatus = 'NOT RUNNING';
    } elseif ($gamedata['status'] == 'STOP GAME') {
        $gameStatus = 'RUNNING';
    }
    $sql = "SELECT * FROM game INNER JOIN users ON game.player_2 = users.id WHERE game.id = '$gameid'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
        $player2data = mysqli_fetch_assoc($result);
        $player2 = $player2data['usename'];
        $player2id = $player2data['id'];
    }
    /********************Toggle the game status *********************************/
    if (isset($_POST['togglegame'])) {
        if ($gameStatus == 'NOT RUNNING') {
            $sql = "UPDATE game SET status = 'STOP GAME' WHERE id = '$gameid'";
            mysqli_query($con, $sql);
            header("location:play.php?gameid=$gameid");
        } elseif ($gameStatus == 'RUNNING') {
            $sql = "UPDATE game SET status = 'START GAME' WHERE id = '$gameid'";
            mysqli_query($con, $sql);
            header("location:play.php?gameid=$gameid");
        }
    }

    /********************get game result function ******************************/
    function getgameresult($player1, $player2)
    {
        if ($player1 == $player2) {
            $result = 'Tie';
        } elseif ($player1 == 'Papper' && $player2 == 'Rock') {
            $result = '1';
        } elseif ($player1 == 'Scissors' && $player2 == 'Rock') {
            $result = '2';
        } elseif ($player1 == 'Scissors' && $player2 == 'Papper') {
            $result = '1';
        } elseif ($player1 == 'Rock' && $player2 == 'Papper') {
            $result = '2';
        } elseif ($player1 == 'Rock' && $player2 == 'Scissors') {
            $result = '1';
        } elseif ($player1 == 'Papper' && $player2 == 'Scissors') {
            $result = '2';
        }
        return $result;
    }
    


    /********************get player move *********************************/
    if (isset($_POST['play'])) {
        $usermove = $_POST['usermove'];
        $_SESSION['played'] = 'yes';

        $sql = "SELECT * FROM game WHERE id = '$gameid'";
        $turn_result = mysqli_query($con, $sql);
        $turn_array = mysqli_fetch_assoc($turn_result);
        $curr_player = $turn_array['turn'];
        $p1 = $turn_array['player_1'];
        $p2 = $turn_array['player_2'];
        if ($curr_player == $p2) {
            $sql = "UPDATE game SET player2played = '$usermove', turn  = '$p1' WHERE id = '$gameid'";
            mysqli_query($con, $sql);

            $sql = "SELECT * FROM game WHERE id = '$gameid'";
            $result = mysqli_query($con, $sql);
            $result = mysqli_fetch_assoc($result);
            $winner = getgameresult($result['player1played'], $result['player2played']);

            $sql = "UPDATE game SET winner = '$winner' WHERE id = '$gameid'";
             mysqli_query($con, $sql);



        } elseif ($curr_player == $p1) {
            $sql = "UPDATE game SET player1played = '$usermove', turn  = '$p2' WHERE id = '$gameid'";
            mysqli_query($con, $sql);
        }
    }
}
