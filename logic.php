<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['id'])) {
    header('location:regrps.php');
};
if (isset($_POST['logout'])) {
    $id = $_SESSION['id'];
    $sql = "UPDATE users SET online_status = '0' WHERE id = '$id'";
    mysqli_query($con, $sql);
    session_unset();
    header('location:regrps.php');
}
error_reporting(0);
// define and initialize empty variables

if (isset($_POST['control'])) {
    $_SESSION['game_status'] = 'RUNNING';
    $_SESSION['action'] = 'STOP GAME';
    $_SESSION['actionN'] = 'endaction';
} elseif (isset($_POST['endaction'])) {
    $_SESSION['actionN'] = 'control';

    $_SESSION['game_status'] = 'NOT RUNNING';
    $_SESSION['action'] = 'START GAME';
};


if (isset($_POST['player1'])) {
    if ($_SESSION['game_status'] == 'RUNNING') {
        $_SESSION['turns'] = "player2";
        $_SESSION['player1moves'] = $_POST['usermove'];
        $page_err = "PLAYER 2 TURNS";
    } else {
        $page_err = "<script> alert('YOU SHOULD START THE GAME BEFORE PLAYING')</script>";
    }
};

if (isset($_POST['player2'])) {
    if ($_SESSION['game_status'] == 'RUNNING') {
        $_SESSION['player1move'] = $_SESSION['player1moves'];

        $_SESSION['player2move'] = $_POST['usermove'];
        $_SESSION['turns'] = "player1";
        $page_err = "PLAYER 1 TURNS";


        $result = getresult($_SESSION['player1move'], $_SESSION['player2move']);


        if ($result == 'Player 1 Won') {
            $_SESSION['player1score'] = $_SESSION['player1score'] + 500;
        } elseif ($result == 'Player 2 Won') {
            $_SESSION['player2score'] = $_SESSION['player2score'] + 500;
        }
    }
}

// a function to get the computer mpve automatically using the switch method

// a function to get the result of the game automatically//

function getresult($user, $comp)
{
    if ($user == $comp) {
        $result = 'Draw';
    } elseif ($comp == 'Papper' && $user == 'Rock') {
        $result = 'Player 2 Won';
    } elseif ($comp == 'Scissors' && $user == 'Rock') {
        $result = 'Player 1 Won';
    } elseif ($comp == 'Scissors' && $user == 'Papper') {
        $result = 'Player 2 Won';
    } elseif ($comp == 'Rock' && $user == 'Papper') {
        $result = 'Player 1 Won';
    } elseif ($comp == 'Rock' && $user == 'Scissors') {
        $result = 'Player 2 Won';
    } elseif ($comp == 'Papper' && $user == 'Scissors') {
        $result = 'Player 1 Won';
    }

    return $result;
}

// get user move then declare the winner by passing arguments to the getwinnwe fuction//fff
