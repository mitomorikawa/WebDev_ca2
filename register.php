<?php
session_start();

if (isset($_POST["submit"])){
    $_SESSION["username"] = $_POST["username"];
    $URL = "pairs.php";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}



if (isset($_POST["medium"])){
    $_SESSION["photo"] = "emoji/medium/" . $_POST["medium"] . ".png";
} else if (isset($_POST["complex"])){

} else {
    $_SESSION["photo"] = "emoji/medium/happy.png";
}
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
        <form action="" method="post" class="register">
            <label for="username">Username: </label>
            <input type="text" id="username" name="username" pattern="^[^!@#%&^*()+={}\[\]\-;:&quot;\';:<>?/]+$" required><br>
            <label for="username">Avatar: </label> <br>
            <input type="radio" name="avatar" value="simple" required>
            <label for="siple"> simple </label> <br>
            <input type="radio" name="avatar" value="medium" onclick="setMedium()" required>
            <label for="medium" id="medium"> medium </label> <br>
            <input type="radio" name="avatar" value="complex" required>
            <label for="complex"> complex </label> <br>
            <br>

            <div id="mediumPhotoGenerator">
                <p> Select an avatar </p>
                <div class="mediumPhotoContainer">
                    <div id="mediumPhoto">
                        <input type="radio" name="medium" value="happy" onclick="setMediumPhoto()">
                        <img src="emoji/medium/happy.png">
                        <p> happy </p> 
                    </div>
                    <div id="mediumPhoto">
                        <input type="radio" name="medium" value="laugh" onclick="setMediumPhoto()">
                        <img src="emoji/medium/laugh.png">
                        <p> laugh </p>
                    </div>
                    <div id="mediumPhoto">
                        <input type="radio" name="medium" value="surprise" onclick="setMediumPhoto()">
                        <img src="emoji/medium/surprise.png">
                        <p> surprise </p>
                    </div>
                    <div id="mediumPhoto">
                        <input type="radio" name="medium" value="wink" onclick="setMediumPhoto()">
                        <img src="emoji/medium/wink.png">
                        <p> wink </p>
                    </div>
                </div>
            </div>

            <input name="submit" type="submit" value="Submit"> 
            
        </form>

    </div>
</html>