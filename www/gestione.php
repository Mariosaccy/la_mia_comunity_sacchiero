<?php
require_once "connessione.php";
require_once "Post.php";

$posts = leggiPost($pdo);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione dei post</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <?php readfile("menu.html"); ?>

    <h1>Gestione dei post</h1>

    <?php
    if (count($posts) === 0) {
        echo "<p>Nessun post presente.</p>";
    } else {
        echo "<table>";
        echo "<tr><th>Titolo</th><th>Autore</th><th>Azioni</th></tr>";

        foreach ($posts as $post) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($post->titolo) . "</td>";
            echo "<td>" . htmlspecialchars($post->autore) . "</td>";
            echo "<td class='azioni'>";
            echo "<form method='get' action='modifica.php'>";
            echo "<input type='hidden' name='id' value='" . $post->id . "'>";
            echo "<button type='submit'>Modifica</button>";
            echo "</form>";
            echo "<form method='get' action='elimina.php'>";
            echo "<input type='hidden' name='id' value='" . $post->id . "'>";
            echo "<button type='submit'>Elimina</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    }
    ?>
</body>
</html>
