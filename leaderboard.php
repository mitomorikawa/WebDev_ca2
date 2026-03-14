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
    <title>leaderboard</title>
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
                <a href="registration.php" name="register">Register</a>
            <?php endif; ?>
        </div>
    </div>
    <div id="main">
        <?php
            $filename = "results.json";
            // Load stored results from results.json.
            $data = json_decode(file_get_contents($filename), true) ?? [
                "simple" => [],
                "medium" => [],
                "complex" => [
                    "1"=>[], "2"=>[], "3"=>[], "4"=>[], "5"=>[], "6"=>[]
                ]
            ];

            function score_sort($a, $b) { // function to sort the elements in an array based on the score attribute
                if ($a["score"] == $b["score"]) {
                    return 0;
                } 
                return ($a["score"] < $b["score"]) ? 1 : -1;
            }

            // Sort each array in the dictionary
            usort($data["simple"], "score_sort"); 
            usort($data["medium"], "score_sort");
            usort($data["complex"]["total"], "score_sort");

            foreach ($data["complex"] as $level => $scores) {
                usort($data["complex"][$level], "score_sort");
            }
            

        ?>
        
        <div class="score_board">
            <h3> Ranking </h3>
            <div class="ranking">
                <div class="ranking_table" id="simple_ranking">
                    <p>Simple </p>
                    <table>
                        <tr>
                            <th>Username</th>
                            <th>Score</th>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["simple"][0]["username"]) ? $data["simple"][0]["username"] : "" ?></td> <!--Populate the table cell with the score and username in the arrays, if they exist-->
                            <td><?php echo isset($data["simple"][0]["score"]) ? $data["simple"][0]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["simple"][1]["username"]) ? $data["simple"][1]["username"] : "" ?></td>
                            <td><?php echo isset($data["simple"][1]["score"]) ? $data["simple"][1]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["simple"][2]["username"]) ? $data["simple"][2]["username"] : "" ?></td>
                            <td><?php echo isset($data["simple"][2]["score"]) ? $data["simple"][2]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["simple"][3]["username"]) ? $data["simple"][3]["username"] : "" ?></td>
                            <td><?php echo isset($data["simple"][3]["score"]) ? $data["simple"][3]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["simple"][4]["username"]) ? $data["simple"][4]["username"] : "" ?></td>
                            <td><?php echo isset($data["simple"][4]["score"]) ? $data["simple"][4]["score"] : "" ?></td>
                        </tr>
                    </table>
                </div>
                <div class="ranking_table" id="medium_ranking">
                    <p>Medium </p>
                    <table>
                        <tr>
                            <th>Username</th>
                            <th>Score</th>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["medium"][0]["username"]) ? $data["medium"][0]["username"] : "" ?></td>
                            <td><?php echo isset($data["medium"][0]["score"]) ? $data["medium"][0]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["medium"][1]["username"]) ? $data["medium"][1]["username"] : "" ?></td>
                            <td><?php echo isset($data["medium"][1]["score"]) ? $data["medium"][1]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["medium"][2]["username"]) ? $data["medium"][2]["username"] : "" ?></td>
                            <td><?php echo isset($data["medium"][2]["score"]) ? $data["medium"][2]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["medium"][3]["username"]) ? $data["medium"][3]["username"] : "" ?></td>
                            <td><?php echo isset($data["medium"][3]["score"]) ? $data["medium"][3]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["medium"][4]["username"]) ? $data["medium"][4]["username"] : "" ?></td>
                            <td><?php echo isset($data["medium"][4]["score"]) ? $data["medium"][4]["score"] : "" ?></td>
                        </tr>
                    </table>
                </div>
                <div class="ranking_table" id="complex_ranking">
                    <p>Complex (Total) </p>
                    <table>
                        <tr>
                            <th>Username</th>
                            <th>Score</th>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["total"][0]["username"]) ? $data["complex"]["total"][0]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["total"][0]["score"]) ? $data["complex"]["total"][0]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["total"][1]["username"]) ? $data["complex"]["total"][1]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["total"][1]["score"]) ? $data["complex"]["total"][1]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["total"][2]["username"]) ? $data["complex"]["total"][2]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["total"][2]["score"]) ? $data["complex"]["total"][2]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["total"][3]["username"]) ? $data["complex"]["total"][3]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["total"][3]["score"]) ? $data["complex"]["total"][3]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["total"][4]["username"]) ? $data["complex"]["total"][4]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["total"][4]["score"]) ? $data["complex"]["total"][4]["score"] : "" ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="ranking">
                <div class="ranking_table" id="complex1_ranking">
                    <p>Complex Level 1 </p>
                    <table>
                        <tr>
                            <th>Username</th>
                            <th>Score</th>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["1"][0]["username"]) ? $data["complex"]["1"][0]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["1"][0]["score"]) ? $data["complex"]["1"][0]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["1"][1]["username"]) ? $data["complex"]["1"][1]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["1"][1]["score"]) ? $data["complex"]["1"][1]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["1"][2]["username"]) ? $data["complex"]["1"][2]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["1"][2]["score"]) ? $data["complex"]["1"][2]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["1"][3]["username"]) ? $data["complex"]["1"][3]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["1"][3]["score"]) ? $data["complex"]["1"][3]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["1"][4]["username"]) ? $data["complex"]["1"][4]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["1"][4]["score"]) ? $data["complex"]["1"][4]["score"] : "" ?></td>
                        </tr>
                    </table>
                </div>
                <div class="ranking_table" id="complex2_ranking">
                    <p>Complex Level 2</p>
                    <table>
                        <tr>
                            <th>Username</th>
                            <th>Score</th>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["2"][0]["username"]) ? $data["complex"]["2"][0]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["2"][0]["score"]) ? $data["complex"]["2"][0]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["2"][1]["username"]) ? $data["complex"]["2"][1]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["2"][1]["score"]) ? $data["complex"]["2"][1]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["2"][2]["username"]) ? $data["complex"]["2"][2]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["2"][2]["score"]) ? $data["complex"]["2"][2]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["2"][3]["username"]) ? $data["complex"]["2"][3]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["2"][3]["score"]) ? $data["complex"]["2"][3]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["2"][4]["username"]) ? $data["complex"]["2"][4]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["2"][4]["score"]) ? $data["complex"]["2"][4]["score"] : "" ?></td>
                        </tr>
                    </table>
                </div>
                <div class="ranking_table"  id="complex3_ranking">                    <p>Complex Level 3</p>
                    <table>
                        <tr>
                            <th>Username</th>
                            <th>Score</th>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["3"][0]["username"]) ? $data["complex"]["3"][0]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["3"][0]["score"]) ? $data["complex"]["3"][0]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["3"][1]["username"]) ? $data["complex"]["3"][1]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["3"][1]["score"]) ? $data["complex"]["3"][1]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["3"][2]["username"]) ? $data["complex"]["3"][2]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["3"][2]["score"]) ? $data["complex"]["3"][2]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["3"][3]["username"]) ? $data["complex"]["3"][3]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["3"][3]["score"]) ? $data["complex"]["3"][3]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["3"][4]["username"]) ? $data["complex"]["3"][4]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["3"][4]["score"]) ? $data["complex"]["3"][4]["score"] : "" ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        
            <div class="ranking">
                <div class="ranking_table"  id="complex4_ranking">
                    <p>Complex Level 4 </p>
                    <table>
                        <tr>
                            <th>Username</th>
                            <th>Score</th>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["4"][0]["username"]) ? $data["complex"]["4"][0]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["4"][0]["score"]) ? $data["complex"]["4"][0]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["4"][1]["username"]) ? $data["complex"]["4"][1]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["4"][1]["score"]) ? $data["complex"]["4"][1]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["4"][2]["username"]) ? $data["complex"]["4"][2]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["4"][2]["score"]) ? $data["complex"]["4"][2]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["4"][3]["username"]) ? $data["complex"]["4"][3]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["4"][3]["score"]) ? $data["complex"]["4"][3]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["4"][4]["username"]) ? $data["complex"]["4"][4]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["4"][4]["score"]) ? $data["complex"]["4"][4]["score"] : "" ?></td>
                        </tr>
                    </table>
                </div>
        
                <div class="ranking_table" id="complex5_ranking">
                    <p>Complex Level 5</p>
                    <table>
                        <tr>
                            <th>Username</th>
                            <th>Score</th>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["5"][0]["username"]) ? $data["complex"]["5"][0]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["5"][0]["score"]) ? $data["complex"]["5"][0]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["5"][1]["username"]) ? $data["complex"]["5"][1]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["5"][1]["score"]) ? $data["complex"]["5"][1]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["5"][2]["username"]) ? $data["complex"]["5"][2]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["5"][2]["score"]) ? $data["complex"]["5"][2]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["5"][3]["username"]) ? $data["complex"]["5"][3]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["5"][3]["score"]) ? $data["complex"]["5"][3]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["5"][4]["username"]) ? $data["complex"]["5"][4]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["5"][4]["score"]) ? $data["complex"]["5"][4]["score"] : "" ?></td>
                        </tr>
                    </table>
                </div>
                <div class="ranking_table" id="complex6_ranking">
                    <p>Complex Level 6</p>
                    <table>
                        <tr>
                            <th>Username</th>
                            <th>Score</th>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["6"][0]["username"]) ? $data["complex"]["6"][0]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["6"][0]["score"]) ? $data["complex"]["6"][0]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["6"][1]["username"]) ? $data["complex"]["6"][1]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["6"][1]["score"]) ? $data["complex"]["6"][1]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["6"][2]["username"]) ? $data["complex"]["6"][2]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["6"][2]["score"]) ? $data["complex"]["6"][2]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["6"][3]["username"]) ? $data["complex"]["6"][3]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["6"][3]["score"]) ? $data["complex"]["6"][3]["score"] : "" ?></td>
                        </tr>
                        <tr>
                            <td><?php echo isset($data["complex"]["6"][4]["username"]) ? $data["complex"]["6"][4]["username"] : "" ?></td>
                            <td><?php echo isset($data["complex"]["6"][4]["score"]) ? $data["complex"]["6"][4]["score"] : "" ?></td>
                        </tr>
                    </table>
                </div>    
            </div>
        </div>       
    </div>
</html>