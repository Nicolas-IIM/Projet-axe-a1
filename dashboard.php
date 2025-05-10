<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music App</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <nav class="sidebar">
        <div class="sidebar-section">
            <h2>Musicard</h2>
            <ul>
                <li class="sidebar-section-hover">🎵 Découverte</li>
                <li>🔍 Recherche</li>
                <li>🎙️ Podcast</li>
            </ul>
        </div>
        <div class="sidebar-section">
            <h2>Mon espace</h2>
            <ul>
                <li>🎶 Mes musiques</li>
                <li>🖼️ Mes cover</li>
                <li>📦 Mes booster</li>
            </ul>
        </div>
        <div class="sidebar-section">
            <h2>Autre</h2>
            <ul>
                <li>✨ Boutique</li>
                <li>✨ Marketplace</li>
                <li>✨ Rareté</li>
            </ul>
        </div>
        <div class="sidebar-section">
            <h2>Mon compte</h2>
            <ul>
                <li>
                    <?php
                    if (isset($_SESSION["useruid"])) {

                        echo "<li>✨ Mon compte (" . $_SESSION["useruid"] . ")</li>";


                    } else {
                        echo "non connecté.";
                    }
                    ?></li>
                <li class="sans-mise-en-forme-liens"><a href="pages/includes/logout.inc.php">✨ Déconnexion </a></li>
                <li class="sans-mise-en-forme-liens"><a href="pages/includes/logout.inc.php">✨ Aide </a></li>
                <li>✨ Mes likes</li>
            </ul>
        </div>
    </nav>


    <main class="main-content">
        <div class="greeting">
            <?php
            if (isset($_SESSION["useruid"])) {

                echo "<h1>Bonjour " . $_SESSION["useruid"] . " !</h1>";


            } else {
                echo "non connecté.";
            }
            ?>
            
            <p>Top picks for you, Updated daily.</p>
        </div>


        <div class="grid">

            <div class="card">
                <div class="placeholder-img"></div>
                <h3>React Rendecroxia</h3>
                <p>Elijah Brie</p>
            </div>
            <div class="card">
                <div class="placeholder-img"></div>
                <h3>React Rendecroxia</h3>
                <p>Elijah Brie</p>
            </div>
            <div class="card">
                <div class="placeholder-img"></div>
                <h3>React Rendecroxia</h3>
                <p>Elijah Brie</p>
            </div>
            <div class="card">
                <div class="placeholder-img"></div>
                <h3>React Rendecroxia</h3>
                <p>Elijah Brie</p>
            </div>
            <div class="card">
                <div class="placeholder-img"></div>
                <h3>React Rendecroxia</h3>
                <p>Elijah Brie</p>
            </div>
            <div class="card">
                <div class="placeholder-img"></div>
                <h3>React Rendecroxia</h3>
                <p>Elijah Brie</p>
            </div>
            <div class="card">
                <div class="placeholder-img"></div>
                <h3>React Rendecroxia</h3>
                <p>Elijah Brie</p>
            </div>
            <div class="card">
                <div class="placeholder-img"></div>
                <h3>React Rendecroxia</h3>
                <p>Elijah Brie</p>
            </div>
            <div class="card">
                <div class="placeholder-img"></div>
                <h3>React Rendecroxia</h3>
                <p>Elijah Brie</p>
            </div>
            <div class="card">
                <div class="placeholder-img"></div>
                <h3>React Rendecroxia</h3>
                <p>Elijah Brie</p>
            </div>
            <div class="card">
                <div class="placeholder-img"></div>
                <h3>React Rendecroxia</h3>
                <p>Elijah Brie</p>
            </div>
            <div class="card">
                <div class="placeholder-img"></div>
                <h3>React Rendecroxia</h3>
                <p>Elijah Brie</p>
            </div>
            <div class="card">
                <div class="placeholder-img"></div>
                <h3>React Rendecroxia</h3>
                <p>Elijah Brie</p>
            </div>
            <div class="card">
                <div class="placeholder-img"></div>
                <h3>React Rendecroxia</h3>
                <p>Elijah Brie</p>
            </div>

        </div>

        <h2 class="h2-pour-toi"">Pour toi</h2>
        <div class="grid">

            <div class="card">
                <div class="placeholder-img"></div>
                <h3>React Rendecroxia</h3>
                <p>Elijah Brie</p>
            </div>
            <div class="card">
                <div class="placeholder-img"></div>
                <h3>React Rendecroxia</h3>
                <p>Elijah Brie</p>
            </div>
            <div class="card">
                <div class="placeholder-img"></div>
                <h3>React Rendecroxia</h3>
                <p>Elijah Brie</p>
            </div>
            <div class="card">
                <div class="placeholder-img"></div>
                <h3>React Rendecroxia</h3>
                <p>Elijah Brie</p>
            </div>
            <div class="card">
                <div class="placeholder-img"></div>
                <h3>React Rendecroxia</h3>
                <p>Elijah Brie</p>
            </div>
            <div class="card">
                <div class="placeholder-img"></div>
                <h3>React Rendecroxia</h3>
                <p>Elijah Brie</p>
            </div>



        </div>
    </main>
</div>


</body>
</html>