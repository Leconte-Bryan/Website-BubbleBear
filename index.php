<?php
include("init.php");
include("Header.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Style.css">
</head>

<body class="body-BubbleBear">

    <div class="wrapper">

        <div id="top-left">
            <div id="container-game-data">
                <img class="game-icone" src="Main_img_BubleBear.jpg" alt="">
                <table class="game-data" cellpadding="10" cellspacing="0">
                    <tr>
                        <th class="bg"  style="width: 45%;" align="left">Title :</th>
                        <th class="bg">BubbleBear </th>
                    </tr>
                    <tr>
                        <th class="bg" align="left">Type :</th>
                        <th class="bg">Speedrun </th>
                    </tr>
                    <tr>
                        <th class="bg" align="left">Recommended age :</th>
                        <th class="bg">7 </th>
                    </tr>
                    <tr>
                        <th class="bg" align="left">Command Type :</th>
                        <th class="bg">Mouse </th>
                    </tr>
                    <tr>
                        <th class="bg" align="left">Released date :</th>
                        <th class="bg">28/01/2025 </th>
                    </tr>

                </table>
            </div>
        </div>
        <div id="top-right">

            <!--container-->
            <div class="LeaderboardBox">

                <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" style="top: 100px; display:flex">
                    <input type="text" name="username" id="username" placeholder="username to search"><br>
                    <input type="hidden" name="ActionName" value="SortingByName">
                    <input type="submit" name="SortByName" value="Sort" id="SortByUsername-button"><br>
                </form>

                <table class="LeaderboardMainMenu" cellpadding="15" cellspacing="0" style="color: blue;">
                    <caption>
                        Leaderboard
                    </caption>
                    <tr class="leaderboard-row">
                        <th class="leaderboard-bg">#</th>
                        <th class="leaderboard-bg" style="width: 250px;" align="left">Player</th>
                        <th class="leaderboard-bg" id="sort-time">
                            Time
                            <button id="SortByScore-button" method="post" style="display: inline; background-color: rgba(0, 0, 0, 0); border : rgba(0, 0, 0, 0)"> ▲ </button>
                        </th>

                        <!--eef-->
                        <th class="leaderboard-bg">Date</th>
                        <tbody id="leaderboard-body"></tbody>
                    </tr>
                </table>

                <div style="position:relative; display:flex; justify-content:space-evenly;">
                    <span style="width:45%">
                        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" style="position: relative;">
                            <input type="number" name="PageIdx" id="Input-Page-Idx" value="1" style="width: 20%;">
                            <input type="submit" name="SortByPage" id="SortByInputPage-Button">
                        </form>
                    </span>

                    <div style="position:relative; margin-right:auto;">
                        <button id="Index-Minus-Leaderboard">
                            ◀ </button>
                        <button id="Index-Plus-Leaderboard"> ▶ </button>
                    </div>
                    <div id="page-number">
                    </div>
                </div>
            </div>

        </div>
        <div id="bottom-center">

            <a target="_blank" href="BuildBB/GamePage.php"> <img class="button-play" src="Start_ui_def.png" alt=""></a>
        </div>
    </div>

    <?php
    include("Footer.php");
    ?>

 
    <script>
        const pageNbr = document.getElementById("page-number");
        let maxPage = undefined;
        const maxElementPerPage = 5;
        let page = 1;
        let reverseSort = Boolean(false);
        ActualisePageNumber();
        InitScriptData();

        function ActualisePageNumber() {
            pageNbr.textContent = "Page " + page;
        }

        function RetrieveSortButton() {
            // Sorting Page related
            const SortButtonMinus = document.getElementById("Index-Minus-Leaderboard");
            SortButtonMinus.addEventListener("click", (event) => {
                if (page === 1) {
                    return;
                }
                page--;
                ActualisePageNumber();
                FetchData(inputText.value.toLowerCase(), reverseSort);
            });
            const SortButtonPlus = document.getElementById("Index-Plus-Leaderboard");
            SortButtonPlus.addEventListener("click", (event) => {
                if (page === maxPage) {
                    return;
                }
                page++;
                ActualisePageNumber();
                console.log(page);
                FetchData(inputText.value.toLowerCase(), reverseSort);
            });
            const SortButtonScore = document.getElementById("SortByScore-button");
            SortButtonScore.addEventListener("click", (event) => {
                let currentOrientation = SortButtonScore.innerText
                reverseSort = !reverseSort;
                SortButtonScore.innerText = (currentOrientation === "▲") ? "▼" : "▲";
                console.log(SortButtonScore.innerText);
                FetchData(inputText.value.toLowerCase(), reverseSort);
            });

            const SortNameButton = document.getElementById("SortByUsername-button");
            const inputText = document.getElementById("username");
            SortNameButton.addEventListener("click", (event) => {
                event.preventDefault();
                FetchData(inputText.value.toLowerCase(), reverseSort);
                //console.log(inputText.value);
            });

            const SortPageButton = document.getElementById("SortByInputPage-Button");
            const inputPageIndex = document.getElementById("Input-Page-Idx");
            SortPageButton.addEventListener("click", (event) => {
                event.preventDefault();
                page = parseInt(inputPageIndex.value);
                if (page > maxPage) {
                    page = maxPage;
                }
                if (page < 1) {
                    page = 1;
                }
                inputPageIndex.value = page;
                FetchData(inputText.value.toLowerCase(), reverseSort);
            });
        }

        async function FetchData(input, reverse) {
            //console.log(input);
            try {
                const response = await fetch("Fetch_leaderboard.php");
                if (!response.ok) {
                    throw new Error("could not fetch ressource");
                }
                let finalArray = new Array();
                const data = await response.json();

                if (input != undefined) {
                    for (i = 0; i < data.length; i++) {
                        if (data[i].username.toLowerCase().includes(input)) {
                            finalArray.push(data[i]);
                        }
                    }
                } else {
                    finalArray = data;
                }
                if (maxPage === undefined) {
                    maxPage = Math.ceil(finalArray.length / maxElementPerPage);
                    console.log(maxPage);
                }

                if (reverse) {
                    finalArray.reverse();
                }
                
                const start = (page - 1) * maxElementPerPage; // At Page 1 -> 0
                const end = start + maxElementPerPage; //  At Page 1 -> 0 + maxElementPerPage -> elem 1 - 2 - 3
                const sliced = finalArray.slice(start, end);
                DisplayLeaderboard(sliced);
                sliced.forEach(element => {
                    console.log(element.username);
                });
            } catch (e) {
                console.error(e);
            }
        }

        function DisplayLeaderboard(data) {
            if (data.length === 0) {
                leaderboardBody.innerHTML = `<tr><td class="bg" colspan='4'>Aucun résultat</td></tr>`;
                return;
            }
            let leaderboard = null;
            leaderboardBody = document.getElementById("leaderboard-body");
            // Prevent duplicate
            leaderboardBody.innerHTML = "";
            for (i = 0; i < data.length; i++) {
                let rankInt = parseInt(data[i].rank);
                firstRow = `<tr class="leaderboard-row"><td>${data[i].rank}</td>`;
                console.log(firstRow);

                // Podium
                if (rankInt <= 3) {
                    if (rankInt === 1) {
                        firstRow =
                            `<tr class="leaderboard-row"><td style="color:gold;">${data[i].rank}</td>`
                    }
                    if (rankInt === 2) {
                        firstRow =
                            `<tr class="leaderboard-row"><td style="color:silver;">${data[i].rank}</td>`
                    }
                    if (rankInt === 3) {
                        firstRow =
                            `<tr class="leaderboard-row"><td style="color:#b1560F;">${data[i].rank}</td>`
                    }
                }
                row =
                    `${firstRow}
            <td class="leaderboard-bg">${data[i].username}</td>
            <td class="leaderboard-bg">${data[i].score}</td>
             <td class="leaderboard-bg">${data[i].date}</td></tr>`
                leaderboardBody.innerHTML += row;
            }
        }

        function InitScriptData() {
            RetrieveSortButton();
            FetchData();
        }
    </script>

</body>

</html>

<?php
// Debug
//echo $_SESSION["username"] . "<br>";
//echo $_SESSION["password"] . "<br>";
//echo $_SESSION["email"] . "<br>";
/*if (isset($_SESSION["user_id"])) {
    echo $_SESSION["user_id"] . "<br>";
    echo gettype($_SESSION["user_id"]) . "<br>";
} */

/**
 * Function called when player finish a run and set his score in the database
 * @param mixed $connexion
 * @return void
 */
function SettingScore($connexion)
{
    // Récupère le score
    $score = $_POST['score'];
    // Debug
    /*echo 'something + ' . $score . "<br>";
        echo $_SESSION["user_id"] . "<br>";
        */
    // Check if user already scored
    try {
        $sql_Select = "SELECT * FROM leaderboard WHERE user_id = ?";
        $stmt_Select = $connexion->prepare($sql_Select);
        $stmt_Select->bind_param("i", $_SESSION["user_id"]);
        $stmt_Select->execute();
        $result_Select = $stmt_Select->get_result();
        $user_Select = $result_Select->fetch_assoc();

        echo "le score initial du joueur " . $user_Select["score"] . "<br>";
        // If scored, and it did a better score (it's time so the new score is smaller)
        if ($result_Select->num_rows > 0) {

            $stmt_Select->close();
            $InitialTime = new DateTime($user_Select["score"]);
            $NewTime = new DateTime($score);
            if ($InitialTime > $NewTime) {
                echo "The Player just did a new record ! " . "<br>";
                $val = $_SESSION["user_id"];

                $sql_Alter = "UPDATE leaderboard SET score = ? WHERE user_id = ?";
                $stmt_Alter  = $connexion->prepare($sql_Alter);
                $stmt_Alter->bind_param("si", $score, $_SESSION["user_id"]);
                $stmt_Alter->execute();
                $stmt_Alter->close();
                mysqli_close($connexion);
                exit(0);
            }
        }
    } catch (mysqli_sql_exception $e) {
        echo "error during score modification" . $e->getMessage() . "<br>";
    }

    try {
        $sql = "INSERT INTO leaderboard (user_id, score) 
				VALUES(?, ?)";
        $stmt = $connexion->prepare($sql);
        // first argument : data type (s = string), second = the value
        // Type int et string
        $stmt->bind_param("is", $_SESSION["user_id"], $score);
        // Execute the query
        $stmt->execute();
    } catch (mysqli_sql_exception $e) {
        echo "error during score insertion" . $e->getMessage() . "<br>";
    }

    if (isset($stmt)) {
        $stmt->close();
    }
    mysqli_close($connexion);
}


// Check si connecté, si oui rentre info dans base de donnée
if (isset($_SESSION["user_id"])) {

    if (isset($_POST['score'])) {

        SettingScore($conn);
        /*
        // Récupère le score
        $score = $_POST['score'];

        try {
            $sql_Select = "SELECT * FROM leaderboard WHERE user_id = ?";
            $stmt_Select = $conn->prepare($sql_Select);
            $stmt_Select->bind_param("i", $_SESSION["user_id"]);
            $stmt_Select->execute();
            $result_Select = $stmt_Select->get_result();
            $user_Select = $result_Select->fetch_assoc();

            echo "le score initial du joueur " . $user_Select["score"] . "<br>";
            if ($result_Select->num_rows > 0) {

                $stmt_Select->close();
                $InitialTime = new DateTime($user_Select["score"]);
                $NewTime = new DateTime($score);
                if ($InitialTime > $NewTime) {
                    echo "The Player just did a new record ! " . "<br>";
                    $val = $_SESSION["user_id"];

                    $sql_Alter = "UPDATE leaderboard SET score = ? WHERE user_id = ?";
                    $stmt_Alter  = $conn->prepare($sql_Alter);
                    $stmt_Alter->bind_param("si", $score, $_SESSION["user_id"]);
                    $stmt_Alter->execute();
                    $stmt_Alter->close();
                    mysqli_close($conn);
                    exit(0);
                }
            }
        } catch (mysqli_sql_exception $e) {
            echo "error during score modification" . $e->getMessage() . "<br>";
        }

        try {
            $sql = "INSERT INTO leaderboard (user_id, score) 
				VALUES(?, ?)";
            $stmt = $conn->prepare($sql);
       
            $stmt->bind_param("is", $_SESSION["user_id"], $score);
            
            $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            echo "error during score insertion" . $e->getMessage() . "<br>";
        }

        if (isset($stmt)) {
            $stmt->close();
        }
        mysqli_close($conn);

        */
    }
    // If request correspond : sort depending of the entered name
    if (isset($_POST['SortingByName'])) {
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        // Valide tout les username contenant l'entré et ayant une suite
        $username = $username . '%';
        // Valide tout les usernames sans se préocupé de lowercase etc...
        $sql = "SELECT * FROM users WHERE username LIKE ?";

        // Prepare this specific request
        $stmt = $conn->prepare($sql);
        // first argument : data type (s = string), second = the value
        $stmt->bind_param("s", $username);
        // Execute the query
        $stmt->execute();
        // Get the result
        $result = $stmt->get_result();

        while ($user = mysqli_fetch_array($result)) {
            return;
        }
    }
}

// If there is an acitve session, Log out the user and then redirect him somewhere
if (isset($_POST["logout"]) && $_SESSION != null) {
    session_destroy();
    header("location: login.php");
} else {
    //debug
    //echo "unable to logout";
}


?>