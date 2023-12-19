<?php
session_start();
include 'conn.php';

//checking if user is logged inor not then refirect to login page if user is not loggedd in

if (!isset($_SESSION['id'])) {
    header('location:regrps.php');
}

// define and initialize empty variables
error_reporting(0);
$compmove = '';
$usermove = '';
$result = '';

//game controls to start the game

if (isset($_POST['control'])) {
    $_SESSION['game_status'] = 'RUNNING';
    $_SESSION['round'] = 1;
    $_SESSION['action'] = 'STOP GAME';
    $_SESSION['actionN'] = 'endaction';
}
//game controls to  end the game

elseif (isset($_POST['endaction'])) {
    $_SESSION['actionN'] = 'control';

    $_SESSION['game_status'] = 'NOT RUNNING';
    $_SESSION['action'] = 'START GAME';
    $_SESSION['game'] = 0;
    $_SESSION['score'] = 0;
    $_SESSION['round'] = 0;

    $_SESSION['winner'] = ' ';
}

//get user and computer move upon selecting an option
if (isset($_POST['submit'])) {
    if ($_SESSION['game_status'] == 'RUNNING') {
        //get result for the current round upon selecting an option
        $usermove = $_POST['usermove'];
        $compmove =  getcompmove();
        $result = getresult($usermove, $compmove);
        $_SESSION['round'] = $_SESSION['round'] + 1;

        if ($result == 'Draw') {
            $_SESSION['winner'] = 'Draw It\'s A Tie';
        } elseif ($result == 'You Won') {
            $_SESSION['winner'] = 'You Won';
        } elseif ($result == 'You Lost') {
            $_SESSION['winner'] = 'You Lost';
        }
    } else {
        $page_err = "<script> alert('YOU SHOULD START THE GAME BEFORE PLAYING')</script>";
    }
    
}


// a function to get the computer mpve automatically using the switch method
function getcompmove()
{
    $compmove = rand(1, 3);
    switch ($compmove) {
        case 1:
            $compmove = 'Rock';
            break;

        case 2:
            $compmove = 'Papper';
            break;

        case 3:
            $compmove = 'Scissors';
    }

    return $compmove;
}

// a function to get the result of the game automatically//

function getresult($user, $comp)
{
    if ($user == $comp) {
        $result = 'Draw';
    } elseif ($comp == 'Papper' && $user == 'Rock') {
        $result = 'You Lost';
    } elseif ($comp == 'Scissors' && $user == 'Rock') {
        $result = 'You won';
    } elseif ($comp == 'Scissors' && $user == 'Papper') {
        $result = 'You Lost';
    } elseif ($comp == 'Rock' && $user == 'Papper') {
        $result = 'You Won';
    } elseif ($comp == 'Rock' && $user == 'Scissors') {
        $result = 'You Lost';
    } elseif ($comp == 'Papper' && $user == 'Scissors') {
        $result = 'You Won';
    }

    return $result;
}
if (isset($_POST['logout'])) {
    $id = $_SESSION['id'];
    $sql = "UPDATE users SET online_status = '0' WHERE id = '$id'";
    mysqli_query($con, $sql);
    session_unset();
    header('location:regrps.php');
}
