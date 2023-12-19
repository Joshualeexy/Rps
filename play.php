<?php
// error_reporting(0);
include 'play-logic.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery.js"></script>
    <title>rps</title>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
        /* height: 100vh; */
    }

    .div-moves {
        display: flex !important;
        width: 100%;
        justify-content: center;
        align-items: center;
        flex-direction: column;

    }

    .choice {
        width: 100%;
        color: black;
        background-color: transparent;
        border: none;
        font-weight: bolder;
        background-color: crimson;
        align-items: center;
        padding: 10px 30px;
        border-radius: 5px;
    }

    .nav-div {
        background-color: skyblue;
        /* height: 100px; */
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-direction: column;
        padding: 10px 0px;
        /* border: solid; */

    }

    .page {
        background-color: green;
        color: white;
        width: 100%;
        text-align: center;
        height: 50px;
        font-weight: bolder;
        padding-top: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .page>marquee {
        width: 50%;
        font-size: 1.5rem;
        font-weight: bolder;
    }

    .nav-div div {
        width: 100%;
        height: 40px;
        /* border: solid 2px; */
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        margin-bottom: 10px;
    }

    .nav-div div button {
        background-color: crimson;
        padding: 10px 10px;
        color: white;
        font-style: italic;
        width: 49%;
        border-radius: 15px;
        font-weight: bolder;
        border: inset white 5px;
        cursor: pointer;
    }

    .nav-div div form {
        width: 49%;

    }

    .nav-div div form>button {
        width: 100%;

    }


    .nav-div div i:last-child {
        margin-right: 9%;
    }

    .div {

        margin-bottom: 20px;
        width: 20%;
        height: 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        border-radius: 10px;

    }

    .moves {
        padding: 10px 20px;
        background-color: transparent;
        font-weight: bolder;
        border: none;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .div:nth-child(even) {
        background-color: skyblue;
    }

    .div:nth-child(odd) {
        background-color: crimson;
    }

    .resultdiv {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;

        color: white;
        width: 80%;
        height: 250px;
        padding: 20px;
    }

    .result {
        padding: 10px 10px;
        background-color: transparent;
        font-weight: bolder;
        border: none;
        width: 100%;
        cursor: pointer;
        background-color: grey;
        margin-bottom: 20px;
        border-radius: 15px;
        text-transform: capitalize;
    }

    .reset {
        padding: 10px 20px;
        background-color: transparent;
        font-weight: bolder;
        border: none;
        width: 100%;
        height: 100%;
        cursor: pointer;


    }

    .alert-box {
        border: solid 2px;
        padding: 20px;
        width: 300px;
        height: 200px;
        background-color: grey;
        color: white;
        font-weight: bolder;
        font-size: 1.2rem;
        display: flex;
        flex-direction: column;
        gap: 10px;
        justify-content: center;
        align-items: center;
        z-index: 1;
        position: absolute;
display: none;   
 }
    .alert-box>button{
        background-color: crimson;
        padding: 10px 20px;
        color: white;

    }
    .show{
        display: flex;
    }

    
</style>

<body>
    <P class="page">
        <marquee id="currPlayer" class="currPlayer">

        </marquee>
    </P>
    <div class="nav-div">
        <div> <button class="topbtn">PLAYER 1: <?= ucfirst($player1) ?></button>

            <button class="topbtn">PLAYER 2: <?= ucfirst($player2) ?></button>
        </div>






        <div>
            <button class="topbtn"> GAME STATUS: <?= $gameStatus ?></button>
            <form method="POST" action=""> <button class="topbtn" name="togglegame" type="submit"> <?= $gamedata['status'] ?> </button> </form>

        </div>
    </div>
    <div class="alert-box <?php if ($_SESSION['played'] == 'yes') {
       echo 'show'; unset( $_SESSION['played']);
    }?>">
        <p>Your move has been sent</p>
        <button id="close-alert"> OK</button>
    </div>
    <div class="div-moves ">
        <div class="div">
            <form action="" method="post" id="rockform">
                <input type="radio" checked value="Rock" hidden name="usermove"><button class="moves" id="rock" type="submit" name="play">ROCK</button>
            </form>
        </div>
        <div class="div">
            <form action="" method="post" id="papperform">
                <input type="radio" checked value="Papper" hidden name="usermove"><button class="moves" id="papper" type="submit" name="play">PAPPER</button>
            </form>
        </div>
        <div class="div">
            <form action="" method="post" id="scissorsform">
                <input type="radio" checked value="Scissors" hidden name="usermove">
                <button class="moves" type="submit" name="play">SCISSORS</button>
            </form>
        </div>
    </div>

    <div class="div">
        <form>

            <button class="currPlayer choice" id="" type="button" name="">

            </button>
        </form>
    </div>

    <div class="div" style="margin-top: 100px;">
        <form action="" method="post">
            <input type="text" name="gameid" id="gameid" value="<?= $_GET['gameid'] ?>" hidden>
            <button class="reset" id="reset" type="submit" name="logout">LOGOUT</button>
        </form>
    </div>
    <script src="rps.js"></script>
</body>

</html>