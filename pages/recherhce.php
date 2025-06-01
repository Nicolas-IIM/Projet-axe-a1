<?php
session_start();


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music App</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container">
    <nav class="sidebar">
        <div class="sidebar-section">
            <h2>Musicard</h2>
            <ul>
                <li> <a href="../dashboard.php">🎵 Découverte</a></li>
                <li> <a href="recherhce.php">🔍 Recherche</a> </li>
                <li>🎙️ Podcast</li>
            </ul>
        </div>
        <div class="sidebar-section">
            <h2>Mon espace</h2>
            <ul>
                <li> <a href="profile.php">🎶 Mes musiques</a></li>
                <li>🖼️ Mes cover</li>
                <li><a href="add-msc.php">🎶 📦 Mes booster</a></li>
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
            <h2 >Mon compte</h2>
            <ul>
                <li>
                    <?php
                    if (isset($_SESSION["useruid"])) {
                        echo "<li>✨ Mon compte (" . $_SESSION["useruid"] . ")</li>";
                    } else {
                        echo "non connecté.";
                    }
                    ?>
                </li>
                <li class="sans-mise-en-forme-liens"><a href="pages/includes/logout.inc.php">✨ Déconnexion</a></li>
                <li class="sans-mise-en-forme-liens"><a href="pages/help/help.php">✨ Aide</a></li>
                <li>✨ Mes likes</li>

            </ul>
            <input id="searchInput" type="text" placeholder="Titre à chercher..." size="30" class="input">
            <button id="recherche" class="button-connextion">Rechercher</button>
        </div>
    </nav>

    <main class="main-content">
        <div class="greeting">
            <?php
            if (isset($_SESSION["useruid"])) {
                echo "<h1>Recherche ce que tu veux  " . $_SESSION["useruid"] . " !</h1>";
            } else {
                echo "non connecté.";
            }
            ?>

        </div>


        <div class="grid" id="results">




            <script>
                document.getElementById("recherche").onclick = () => { // lance le script au clic
                    const q = document.getElementById("searchInput").value.trim();
                    if (!q) return alert("Entrez une tracks !"); // erreur si le champ est vide
                    fetch("search.php?q=" + encodeURIComponent(q)) // requete asynchrone vers search.php
                        .then(r => r.json())
                        .then(data => {
                            const container = document.getElementById("results"); // récupère l'élément avec l'id "results"
                            container.innerHTML = ""; // vide le contenu de l'élément

                            if (!data.tracks || !data.tracks.items.length) { // vérifie si des résultats existent
                                container.textContent = "Aucun résultat.";
                                return;
                            }

                            data.tracks.items.forEach(track => { // pour chaque track dans les résultat
                                const div = document.createElement("div");
                                div.className = "card";

                                const img = track.album.images[0]?.url || '';
                                const artists = track.artists.map(artist => artist.name).join(', '); // joint avec une ,

                                div.innerHTML = `
                <div class="placeholder-img" style="background-image: url('${img}'); background-size: cover; background-position: center;"></div>
                <h3>${track.name}</h3>
                <p>${artists}</p>
            `;

                                container.appendChild(div); // ajoute la div créée dans le container

                                fetch("add.php", { // requete pour ajouter la track
                                    method: "POST",
                                    headers: { "Content-Type": "application/json" },
                                    body: JSON.stringify(track) // envoie les données de la track en JSON
                                })
                                    .then(res => res.json()) // récupère la réponse de l'ajout
                                    .then(r => { // traite la réponse

                                        const statusEl = document.createElement("p"); // bug
                                        statusEl.className = "status";
                                        statusEl.textContent = r.status === "ok" ? "✅ Dans la base de donnée" : "❌ Erreur";
                                        div.appendChild(statusEl);
                                    });
                            });
                        });
                };
            </script>

</body>
</html>
