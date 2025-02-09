<!-- This page allows you to search for the quizs -->
<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="CSS/admin_search.css">
        <title>PAGE D'ACCUEIL </title>
    </head>
    <body>
        <header>
            <div class="tete">
                <div class="logo">
                    <a href="admin_homepage.php"><img src="MEDIA/logo.png" alt="logo"></a>
                </div>
                <div class="connect_btn">
                    <div class="connect">
                        <a href="disconnect.php"><input type="button" value="Se déconnecter" class="button_head"></a>
                    </div>
                </div>
            </div>
        </header>
        <div class="button">
            <a href="admin_homepage.php"><input type="button" value="Page d'accueil" class="button_ajout" ></a>
            <a href="admin_panel.php"><input type="button" value="Panneau d'administration" class="button_ajout"></a>
        </div>
        <div class="navbar">
            <div class="h2">
                <a href="homepage.php"><h2>Nos quizs</h2></a>
            </div>
            <div class="searchform">
                <form action="homepage_search.php" method="post">
                    <input class="searchbar" type="text" id="searchbar" name="searchbar" placeholder="Rechercher par nom">
                    <input class="searchbtn" type="submit" value="Rechercher"></input>
                </form>
            </div>
        </div>

        <?php

            // Call for session cookies containing important information, including the type of user
            session_start();

            // If admin
            if($_SESSION['type'] == 'administrator'){

            // Infos for db link
            $server="localhost";
            $username="root";
            $password="root";
            $db="quizzeo";

            // Link to db
            $conn = new mysqli($server,$username,$password,$db);

            // If link to db failed, showing error
            if($conn->connect_error) {
                die("Connexion échouée: " . $conn->connect_error);
            }

            // Attribute input value for $search variable
            if(isset($_POST['searchbar'])){
                $search=$_POST['searchbar'];
            }

            // sending request to db to search quiz
            $req="SELECT * FROM quizz WHERE titre LIKE '%$search%'";
            $res=$conn->query($req);

            // If quizs exist, showing them in grid
            if($res->num_rows > 0){
                echo '<div class="grid">';
                while($row=$res->fetch_assoc()){
                    echo "<a href='quiz.php?id=". $row['id'] ."'>";
                    echo '<div class="quiz">';
                    echo '<img style="position: relative; width: 180px;" class="bg" src="MEDIA/quiz.png" alt="IMG_BG">';
                    echo "Nom du quiz: " . $row["titre"];
                    echo " - Difficulté: " . $row["difficulte"];
                    echo '"</div>"';
                }
                echo "</div>";
            }else{
                echo "Aucun quiz trouvé.";
            }
            
            $conn->close();
        } else { // Redirection if not admin
            Header("Location: error.html");
        }
        ?>

        <!-- <script>
            const html = document.getElementsByTagName("html")[0];
            const themeSwicth = document.getElementById("themeLogo");
            themeSwicth.addEventListener("click", () => {
            html.classList.toggle("nuit");
            if (html.classList.contains("nuit")) {
                themeSwicth.innerHTML = 'LIGHT'.fontsize(4);
            } else {
                themeSwicth.innerHTML = 'DARK'.fontsize(4);
            }
        });
        </script>   -->

    </body>
    
</html>