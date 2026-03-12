<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>leading</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="navbar">
        <a href="index.php" name="home">Home</a>

        <?php 
            if (isset($_SESSION["photo"])){
                if (sizeof($_SESSION["photo"])==1){
                    echo "<img src=" . $_SESSION["photo"][0] . ">";
                } else if (sizeof($_SESSION["photo"])==3){
                    echo "<img src=" . $_SESSION["photo"][0] . ">";
                    echo "<img src=" . $_SESSION["photo"][1] . ">";
                    echo "<img src=" . $_SESSION["photo"][2] . ">";
                }
            }
        ?>
        <div class="navbar_right">
            <a href="pairs.php" name="memory">Play pairs</a>
            <?php if (isset($_SESSION["username"])): ?>
                <a href="leaderboard.php" name="leaderboard">Leaderboard</a>
            <?php else: ?>
                <a href="register.php" name="register">Register</a>
            <?php endif; ?>
        </div>
    </div>

    <div id="main" class="form">
        <?php if (isset($_SESSION["username"])): ?>
            <div class="index_button"> 
                <a href="pairs.php">Click here to play</a>
            </div>
        <?php else: ?>
            <div class="index_button"> 
                <a href="register.php">You're not using a registered session? Register now</a>
            </div>
        <?php endif; ?>


    </div>
</html>