<?php include 'compgamelogic.php';
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
    <div class="nav-div">
        <div>
            <button class="topbtn">PLAYER: <?= $_SESSION['username'] ?></button>

            <button class="topbtn"> GAME STATUS: <?= $_SESSION['game_status'] ?></button>
        </div>

        <div>
            <button class="topbtn">WINNER: <?= $_SESSION['winner'] ?></button>
            <form action="" method="post">
                <button class="topbtn" name="<?= $_SESSION['actionN'] ?>" type="submit"> <?= $_SESSION['action'] ?> </button>
            </form>
        </div>
        <div class="">
            </button>
            <button style="width:100%;">ROUND NO:&nbsp; <?= $_SESSION['round'] ?></button>
        </div>

    </div>
    <div class="div">
        <form action="" method="post">
            <input type="radio" checked value="Rock" hidden name="usermove"><button class="moves" id="rock" type="submit" name="submit">ROCK</button>
        </form>
    </div>
    <div class="div">
        <form action="" method="post">
            <input type="radio" checked value="Papper" hidden name="usermove"><button class="moves" id="papper" type="submit" name="submit">PAPPER</button>
        </form>
    </div>
    <div class="div">
        <form action="" method="post">
            <input type="radio" checked value="Scissors" hidden name="usermove"><button class="moves" id="scissors" type="submit" name="submit">SCISSORS</button>
        </form>
    </div>
    <div class="div resultdiv">

        <p class="result " id="usermove">you picked : <span id="user"><?= $usermove ?></span></p>
        <p class="result" id="compmove">computer picked : <span id="comp"><?= $compmove ?></span></p>
        <p class="result " id="result">Result : <?= $result ?></p>
    </div>
    <div class="div">
        <form action="" method="post">
            <button class="reset" id="reset" type="submit" name="logout">LOGOUT</button>
        </form>
    </div>
    <!-- <script src="rps.js"></script> -->
</body>

</html>