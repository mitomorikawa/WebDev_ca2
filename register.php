<?php
session_start();

if (isset($_POST["avatar"])){
    if ($_POST["avatar"]=="medium"){
        $_SESSION["photo"] = array("emoji/medium/" . $_POST["medium"] . ".png");
    } else if ($_POST["avatar"]=="complex"){
        $_SESSION["photo"] = array("emoji/skin/" . $_POST["complexSkin"] . ".png", "emoji/eyes/" . $_POST["complexEyes"] . ".png", "emoji/mouth/" . $_POST["complexMouth"] . ".png");
    } else {
        $_SESSION["photo"] = array("emoji/medium/happy.png");
    }
}

if (isset($_POST["submit"])){
    $_SESSION["username"] = $_POST["username"];
    header("Location: pairs.php");
    exit();
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
            <div class="avatarContainer">
                <div class="avatarSelection">
                    <label for="username">Avatar: </label> <br>
                    <input type="radio" name="avatar" value="simple" onclick="setSimple()" required>
                    <label for="siple"> simple </label> <br>
                    <input type="radio" name="avatar" value="medium" onclick="setMedium()" required>
                    <label for="medium" id="medium"> medium </label> <br>
                    <input type="radio" name="avatar" value="complex" onclick="setComplex()" required>
                    <label for="complex"> complex </label> <br>
                </div>

                <!-- 
                <div class="avatarPreview">
                    add avatar preview here
                </div>
                -->
            </div>
            <br>

            <div id="mediumPhotoGenerator">
                <p> Select an avatar </p>
                <div class="mediumPhotoContainer">
                    <div id="mediumPhoto">
                        <input type="radio" name="medium" value="happy" onclick="setMediumPhoto()"
                        <?php
                            if (isset($_POST["avatar"])) {
                                if ($_POST["avatar"]=="medium") {
                                    echo " required";
                                 } else {
                                    echo "";
                                }
                            }
                        ?>
                        >
                        <img src="emoji/medium/happy.png">
                        <p> happy </p> 
                    </div>
                    <div id="mediumPhoto">
                        <input type="radio" name="medium" value="laugh" onclick="setMediumPhoto()"
                        <?php
                            if (isset($_POST["avatar"])) {
                                if ($_POST["avatar"]=="medium") {
                                    echo " required";
                                 } else {
                                    echo "";
                                }
                            }
                        ?>
                        >
                        <img src="emoji/medium/laugh.png">
                        <p> laugh </p>
                    </div>
                    <div id="mediumPhoto">
                        <input type="radio" name="medium" value="surprise" onclick="setMediumPhoto()" 
                        <?php
                            if (isset($_POST["avatar"])) {
                                if ($_POST["avatar"]=="medium") {
                                    echo " required";
                                 } else {
                                    echo "";
                                }
                            }
                        ?>
                        >
                        <img src="emoji/medium/surprise.png">
                        <p> surprise </p>
                    </div>
                    <div id="mediumPhoto">
                        <input type="radio" name="medium" value="wink" onclick="setMediumPhoto()"
                        <?php
                            if (isset($_POST["avatar"])) {
                                if ($_POST["avatar"]=="medium") {
                                    echo " required";
                                 } else {
                                    echo "";
                                }
                            }
                        ?>
                        >
                        <img src="emoji/medium/wink.png">
                        <p> wink </p>
                    </div>
                </div>
            </div>

            <div id="complexPhotoGenerator">
                <p> Select components </p>
                <p> eyes </p>
                <div class="complexPhotoContainer">
                    <div id="complexPhoto">
                        <input type="radio" name="complexEyes" value="closed" onclick="setComplexPhoto()"
                        <?php
                            if (isset($_POST["avatar"])) {
                                if ($_POST["avatar"]=="complex") {
                                    echo " required";
                                 } else {
                                    echo "";
                                }
                            }
                        ?>
                        >
                        <img src="emoji/eyes/closed.png">
                        <p> closed </p>
                    </div>
                    <div id="complexPhoto">
                        <input type="radio" name="complexEyes" value="laughing" onclick="setComplexPhoto()"
                        <?php
                            if (isset($_POST["avatar"])) {
                                if ($_POST["avatar"]=="complex") {
                                    echo " required";
                                 } else {
                                    echo "";
                                }
                            }
                        ?>
                        >
                        <img src="emoji/eyes/laughing.png">
                        <p> laughing </p>
                    </div>
                    <div id="complexPhoto">
                        <input type="radio" name="complexEyes" value="long" onclick="setComplexPhoto()" 
                        <?php
                            if (isset($_POST["avatar"])) {
                                if ($_POST["avatar"]=="complex") {
                                    echo " required";
                                 } else {
                                    echo "";
                                }
                            }
                        ?>
                        >
                        <img src="emoji/eyes/long.png">
                        <p> long </p>
                    </div>
                    <div id="complexPhoto">
                        <input type="radio" name="complexEyes" value="normal" onclick="setComplexPhoto()"
                        <?php
                            if (isset($_POST["avatar"])) {
                                if ($_POST["avatar"]=="complex") {
                                    echo " required";
                                 } else {
                                    echo "";
                                }
                            }
                        ?>
                        >
                        <img src="emoji/eyes/normal.png">
                        <p> normal </p>
                    </div>
                    <div id="complexPhoto">
                        <input type="radio" name="complexEyes" value="rolling" onclick="setComplexPhoto()"
                        <?php
                            if (isset($_POST["avatar"])) {
                                if ($_POST["avatar"]=="complex") {
                                    echo " required";
                                 } else {
                                    echo "";
                                }
                            }
                        ?>
                        >
                        <img src="emoji/eyes/rolling.png">
                        <p> rolling </p>
                    </div>
                    <div id="complexPhoto">
                        <input type="radio" name="complexEyes" value="winking" onclick="setComplexPhoto()"
                        <?php
                            if (isset($_POST["avatar"])) {
                                if ($_POST["avatar"]=="complex") {
                                    echo " required";
                                 } else {
                                    echo "";
                                }
                            }
                        ?>
                        >
                        <img src="emoji/eyes/winking.png">
                        <p> winking </p>
                    </div>
                </div>
                <br>
                <p> mouth </p>
                <div class="complexPhotoContainer">
                    <div id="complexPhoto">
                        <input type="radio" name="complexMouth" value="open" onclick="setComplexPhoto()" 
                        <?php
                            if (isset($_POST["avatar"])) {
                                if ($_POST["avatar"]=="complex") {
                                    echo " required";
                                 } else {
                                    echo "";
                                }
                            }
                        ?>
                        >
                        <img src="emoji/mouth/open.png">
                        <p> open </p>
                    </div>
                    <div id="complexPhoto">
                        <input type="radio" name="complexMouth" value="sad" onclick="setComplexPhoto()"
                        <?php
                            if (isset($_POST["avatar"])) {
                                if ($_POST["avatar"]=="complex") {
                                    echo " required";
                                 } else {
                                    echo "";
                                }
                            }
                        ?>
                        >
                        <img src="emoji/mouth/sad.png">
                        <p> sad </p>
                    </div>
                    <div id="complexPhoto">
                        <input type="radio" name="complexMouth" value="smiling" onclick="setComplexPhoto()"
                        <?php
                            if (isset($_POST["avatar"])) {
                                if ($_POST["avatar"]=="complex") {
                                    echo " required";
                                 } else {
                                    echo "";
                                }
                            }
                        ?>
                        >
                        <img src="emoji/mouth/smiling.png">
                        <p> smiling </p>
                    </div>
                    <div id="complexPhoto">
                        <input type="radio" name="complexMouth" value="straight" onclick="setComplexPhoto()" 
                        <?php
                            if (isset($_POST["avatar"])) {
                                if ($_POST["avatar"]=="complex") {
                                    echo " required";
                                 } else {
                                    echo "";
                                }
                            }
                        ?>
                        >
                        <img src="emoji/mouth/straight.png">
                        <p> straight </p>
                    </div>
                    <div id="complexPhoto">
                        <input type="radio" name="complexMouth" value="surprise" onclick="setComplexPhoto()" 
                        <?php
                            if (isset($_POST["avatar"])) {
                                if ($_POST["avatar"]=="complex") {
                                    echo " required";
                                 } else {
                                    echo "";
                                }
                            }
                        ?>
                        >
                        <img src="emoji/mouth/surprise.png">
                        <p> surprise </p>
                    </div>
                    <div id="complexPhoto">
                        <input type="radio" name="complexMouth" value="teeth" onclick="setComplexPhoto()" 
                        <?php
                            if (isset($_POST["avatar"])) {
                                if ($_POST["avatar"]=="complex") {
                                    echo " required";
                                 } else {
                                    echo "";
                                }
                            }
                        ?>
                        >
                        <img src="emoji/mouth/teeth.png">
                        <p> teeth </p>
                    </div>
                </div>
                <br>
                <p> skin </p>
                <div class="complexPhotoContainer">
                    <div id="complexPhoto">
                        <input type="radio" name="complexSkin" value="yellow" onclick="setComplexPhoto()" 
                        <?php
                            if (isset($_POST["avatar"])) {
                                if ($_POST["avatar"]=="complex") {
                                    echo " required";
                                 } else {
                                    echo "";
                                }
                            }
                        ?>
                        >
                        <img src="emoji/skin/yellow.png">
                        <p> yellow </p>
                    </div>
                    <div id="complexPhoto">
                        <input type="radio" name="complexSkin" value="green" onclick="setComplexPhoto()"
                        <?php
                            if (isset($_POST["avatar"])) {
                                if ($_POST["avatar"]=="complex") {
                                    echo " required";
                                 } else {
                                    echo "";
                                }
                            }
                        ?>
                        >
                        <img src="emoji/skin/green.png">
                        <p> green </p>
                    </div>
                    <div id="complexPhoto">
                        <input type="radio" name="complexSkin" value="red" onclick="setComplexPhoto()" 
                        <?php
                            if (isset($_POST["avatar"])) {
                                if ($_POST["avatar"]=="complex") {
                                    echo " required";
                                 } else {
                                    echo "";
                                }
                            }
                        ?>
                        >
                        <img src="emoji/skin/red.png">
                        <p> red </p>
                    </div>
                </div>
                
                

            </div>

            <input name="submit" type="submit" value="Submit"> 
            
        </form>

    </div>
</html>