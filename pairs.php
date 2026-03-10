<?php
    session_start();

?>

<!DOCTYPE html>
<html>
<head>
    <title>register</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="script.js"></script>
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

    <div id="main">
        <div class="start_screen"> 
            <div class="start_button">
                <button onclick="startGame()">Start the game</button>
            </div>
            <div class="type_selection">
                <h3>Select the game type </h3><br>
                <input type="radio" name="type" value="simple" required>
                <label for="simple"> simple </label> <br>
                <input type="radio" name="type" value="medium" required>
                <label for="medium"> medium </label> <br>
                <input type="radio" name="type" value="complex" required>
                <label for="complex"> complex </label> <br>
            </div>
        </div>
        
        <div class="game_status">
            <div class="level">
            </div>
            <div class="score">
            </div>
            <div class="attempts">
            </div>
            <div class="time">
            </div>
            </div>
        <div class="end_game">
            <p> Too many attempts </p>
            <a href="pairs.php">Play again</a>
            <input id="submit" type="submit" value="Submit">
            <button onclick="runComplexLevel();"> Next level </button>
        </div>
        <div class="game_screen">
            <div class="game_grid">
                
            </div>
        </div>
    </div>
</body>
</html>