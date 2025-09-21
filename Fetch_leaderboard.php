<?php
include("init.php");
$Rows = [];

$sql = "WITH RankedLeaderboard AS (
    SELECT 
        username, 
        score, 
        game_date,
        RANK() OVER (ORDER BY score ASC) AS global_rank
    FROM leaderboard
INNER JOIN users ON leaderboard.user_id = users.user_id 
)
SELECT * FROM RankedLeaderboard
ORDER BY score ASC;";

$result_DisplayLeaderboard = mysqli_query($conn, $sql);
while ($row_LeaderBoard = mysqli_fetch_array($result_DisplayLeaderboard)) {
    $Rows[] = [
        'rank' => $row_LeaderBoard['global_rank'],
        'username' => $row_LeaderBoard['username'],
        'score' => $row_LeaderBoard['score'],
        'date' => $row_LeaderBoard['game_date'],
    ];
}

echo json_encode( $Rows);
?>

