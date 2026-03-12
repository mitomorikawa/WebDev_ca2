<?php
session_start();
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
                <a href="register.php" name="register">Register</a>
            <?php endif; ?>
        </div>
    </div>
    <div id="main">
        <?php
            $filename = "results.json";
            $current_data=file_get_contents($filename);
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
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
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
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
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
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
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
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
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
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
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
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
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
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
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
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
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
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>    
            </div>
        </div>       
    </div>
</html>