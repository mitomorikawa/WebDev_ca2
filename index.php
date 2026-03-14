<?php
    session_start();
    
    if (isset($_COOKIE["username"])&&isset($_COOKIE["photo"])) { // If cookies are set
        $_SESSION["username"] = $_COOKIE["username"]; // store cookie variables in session variables
        $_SESSION["photo"] = json_decode($_COOKIE["photo"], true);
    } else { // otherwise unset session variables
        unset($_SESSION["username"]);
        unset($_SESSION["photo"]);
    }
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
                if (sizeof($_SESSION["photo"])==1){ // if $_SESSION["photo"]==1, it's a default photo (simple, medium). 
                    echo "<img src=" . $_SESSION["photo"][0] . ">";
                } else if (sizeof($_SESSION["photo"])==3){ // otherwise it's an array of component photos (complex)
                    echo "<img src=" . $_SESSION["photo"][0] . ">";
                    echo "<img src=" . $_SESSION["photo"][1] . ">";
                    echo "<img src=" . $_SESSION["photo"][2] . ">";
                }
            }
        ?>
        <div class="navbar_right">
            <a href="pairs.php" name="memory">Play pairs</a>
            <?php if (isset($_SESSION["username"])): ?>  <!-- if session vars aren't set, show a link to leaderboard.php-->
                <a href="leaderboard.php" name="leaderboard">Leaderboard</a>
            <?php else: ?> <!-- if session vars are set, show a link to registration.php-->
                <a href="registration.php" name="register">Register</a>
            <?php endif; ?>
        </div>
    </div>

    <div id="main" class="form">
        <?php if (isset($_SESSION["username"])): ?> <!-- if session vars aren't set-->
            <p> Welcome to Pairs </p>
            <div class="index_button"> 
                <a href="pairs.php">Click here to play</a>
            </div>
        <?php else: ?> <!-- if session vars are set-->
            <p> You're not using a registered session? </p>
            <a href="registration.php">Register now</a>
        <?php endif; ?>


    </div>
</html>