<?php
    session_start();
    if (isset($_COOKIE["username"])&&isset($_COOKIE["photo"])) {
        $_SESSION["username"] = $_COOKIE["username"];
        $_SESSION["photo"] = json_decode($_COOKIE["photo"], true);
    } else {
        unset($_SESSION["username"]);
        unset($_SESSION["photo"]);
    }
   
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pairs</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="script.js"></script>
</head>
<body>

    <?php
        $filename =  "results.json";
        if (file_exists($filename)) { // Load stored results from results.json.
            $data = json_decode(file_get_contents($filename), true) ?? [
                "simple" => [],
                "medium" => [],
                "complex" => [
                    "total"=>[], "1"=>[], "2"=>[], "3"=>[], "4"=>[], "5"=>[], "6"=>[]
                ]
            ];
        } else {
            $data = [
                "simple" => [],
                "medium" => [],
                "complex" => [
                    "total"=>[], "1"=>[], "2"=>[], "3"=>[], "4"=>[], "5"=>[], "6"=>[]
                ]
            ];
        }

        // if the submit button is clicked and all the variables are set
        if (isset($_POST["score"]) && isset($_POST["type"]) && isset($_POST["level"]) && isset($_SESSION["username"])) {

            $username = $_SESSION["username"];
            $type = $_POST["type"];
            $level = $_POST["level"];
            $score = $_POST["score"];

            if ($type == "simple" || $type == "medium") { // if the game type is simple or medium

                $found = false; // true if the user is found in the loaded array

                foreach ($data[$type] as &$item) {
                    if ($item["username"] == $username) { // find the user in the loaded data
                        if ((float)$item["score"] < (float)$score) { // if the current score is better than the stored score
                            $item["score"] = $score; // update the score in the array
                        }
                        $found = true; // the user is found in the array
                        break; 
                    }
                }

                if (!$found) { // if the user is not found in the array, create a new element for the user
                    $data[$type][] = [
                        "username"=>$username,
                        "score"=>$score
                    ];
                }

            } else if ($type == "complex") {

                $scores = explode(",", $score); // in the complex mode, the score variable is an array containing the score of each level
                $total =  number_format((float)array_sum($scores), 2, '.', '');

                // Update the total score of the complex mode. same process as in the simple/medium mode
                $found = false;
                foreach ($data["complex"]["total"] as &$item) {
                    if ($item["username"] == $username) {
                        if ((float)$item["score"] < (float)$total) {
                            $item["score"] = $total;
                        }
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    $data["complex"]["total"][] = [
                        "username"=>$username,
                        "score"=>$total
                    ];
                }

                // update the score of each levels in the dictionary. Same process as in the simple/medium mode
                for ($i=1; $i <= $level; $i++) {

                    $found = false;

                    foreach ($data["complex"][$i] as &$item) {
                        if ($item["username"] == $username) {
                            if ((float)$item["score"] < (float)$scores[$i-1]) {
                                $item["score"] = $scores[$i-1];
                            }
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
            // Store the modified array in results.json
            file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
        } 

        // A php variable to store the previous best scores of the complex mode. This will be passed to script.js, so that the background colour can be changed to gold when the score improves 
        $complex_best_score = [
            "1"=> PHP_FLOAT_MAX, "2"=>PHP_FLOAT_MAX, "3"=>PHP_FLOAT_MAX, "4"=>PHP_FLOAT_MAX, "5"=>PHP_FLOAT_MAX, "6"=>PHP_FLOAT_MAX
        ]; // If the previous value doesnt exist it will be initialised as Float_max, so that the background colour wont turn gold when you play for the first time
        if (isset($_SESSION["username"]) && isset($data["complex"])) {
            for ($i = 1; $i <= 6; $i++) {
                
                foreach ($data["complex"][$i] as $entry) {
                    if ($entry["username"] == $_SESSION["username"]) {
                        $complex_best_score[$i] = (float)$entry["score"]; // Populate $complex_best_score with the previous best scores
                        break; // Found the user for this level, move to next level
                    }
                }
            
            }
        }
    ?>
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

        <script>
            let complexBestScore = <?php echo json_encode($complex_best_score); ?>; // pass $complex_best_scor to javascript
        </script>
        <div class="navbar_right">
            <a href="pairs.php" name="memory">Play pairs</a>
            <?php if (isset($_SESSION["username"])): ?>
                <a href="leaderboard.php" name="leaderboard">Leaderboard</a>
            <?php else: ?>
                <a href="registration.php" name="register">Register</a>
            <?php endif; ?>
        </div>
    </div>

    <div id="main">
        <div class="start_screen"> 
            <div class="start_button">
                <button onclick="startGame()">Start the game</button>
            </div>
            <div class="type_selection">
                <h3>Select a game type </h3><br> <!-- radio buttons for selecting a gametype-->
                <input type="radio" name="type" value="simple">
                <label for="simple"> simple </label> <br>
                <input type="radio" name="type" value="medium">
                <label for="medium"> medium </label> <br>
                <input type="radio" name="type" value="complex">
                <label for="complex"> complex </label> <br>
            </div>
        </div>
        
        <div class="game_status"> <!--Shows the game status during the game. Hidden before the game starts. -->
            <div class="level">
            </div>
            <div class="score">
            </div>
            <div class="attempts">
            </div>
            <div class="time">
            </div>
            <div class="game_description"> 
            </div>
        </div>
        <table class="complex_table"> <!-- Shows the scores for all levels in the complex game -->
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
        <div class="end_game"> <!-- displayed when the game ends -->
            <form action="" method="post">
                <p> Too many attempts </p>
                <a href="pairs.php">Play again</a>
                <?php if (isset($_COOKIE["username"])): ?> <!--if the user is registered, display the submit button -->
                    <input id="submit" type="submit" value="Submit">
                <?php endif; ?>
                <button type="button" onclick="runComplexLevel();"> Next level </button>

                <!--These variables will be stored in results.json when the submit button is clicked-->
                <input type="hidden" name="score" id="score_input">  <!-- score -->
                <input type="hidden" name="type" id="type_input"> <!-- game type -->
                <input type="hidden" name="level" id="level_input"> <!-- level in the complex game. 0 if the game type is simple or medium -->
            </form>
        </div>
        <div class="game_screen"> <!-- The cards are displayed here -->
            <div class="game_grid"> <!-- The cards are arranged on this grid -->
                
            </div>
        </div>
    </div>
</body>
</html>