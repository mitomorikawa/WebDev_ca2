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

            $filename = "results.json";

            if (isset($_POST["score"]) && isset($_POST["type"]) && isset($_POST["level"]) && isset($_SESSION["username"])) {

                if (file_exists($filename)) {
                    $data = json_decode(file_get_contents($filename), true) ?? [
                        "simple" => [],
                        "medium" => [],
                        "complex" => [
                            "1"=>[], "2"=>[], "3"=>[], "4"=>[], "5"=>[], "6"=>[]
                        ]
                    ];
                } else {
                    $data = [
                        "simple" => [],
                        "medium" => [],
                        "complex" => [
                            "1"=>[], "2"=>[], "3"=>[], "4"=>[], "5"=>[], "6"=>[]
                        ]
                    ];
                }

                $username = $_SESSION["username"];
                $type = $_POST["type"];
                $level = $_POST["level"];
                $score = $_POST["score"];

                if ($type == "simple" || $type == "medium") {

                    $found = false;

                    foreach ($data[$type] as &$item) {
                        if ($item["username"] == $username) {
                            $item["score"] = $score;
                            $found = true;
                            break;
                        }
                    }

                    if (!$found) {
                        $data[$type][] = [
                            "username"=>$username,
                            "score"=>$score
                        ];
                    }

                } else if ($type == "complex") {

                    $scores = explode(",", $score);

                    for ($i=1; $i <= $level; $i++) {

                        $found = false;

                        foreach ($data["complex"][$i] as &$item) {
                            if ($item["username"] == $username) {
                                $item["score"] = $scores[$i-1];
                                $found = true;
                                break;
                            }
                        }

                        if (!$found) {
                            $data["complex"][$i][] = [
                                "username"=>$username,
                                "score"=>$scores[$i-1]
                            ];
                        }
                    }
                }

                file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
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
        <table class="complex_table">
                <tr>
                    <th>Level</th>
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                    <th>4</th>
                    <th>5</th>
                    <th>6</th>
                    <th>Total</th>
                </tr>
                <tr>
                    <th>Score</th>
                    <td id="level1_cell"></td>
                    <td id="level2_cell"></td>
                    <td id="level3_cell"></td>
                    <td id="level4_cell"></td>
                    <td id="level5_cell"></td>
                    <td id="level6_cell"></td>
                    <td id="total_cell"></td>
                </tr>

        </table>
        <div class="end_game">
            <form action="" method="post">
                <p> Too many attempts </p>
                <a href="pairs.php">Play again</a>
                <input id="submit" type="submit" value="Submit">
                <button type="button" onclick="runComplexLevel();"> Next level </button>
                <input type="hidden" name="score" id="score_input">
                <input type="hidden" name="type" id="type_input">
                <input type="hidden" name="level" id="level_input">
            </form>
        </div>
        <div class="game_screen">
            <div class="game_grid">
                
            </div>
        </div>
    </div>
</body>
</html>