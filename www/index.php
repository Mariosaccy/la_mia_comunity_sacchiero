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
    <title>La mia community</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <?php readfile("menu.html"); ?>

    <h1>La mia community di fotografia</h1>

    <?php
    if (count($posts) === 0) {
        echo "<p>Nessun post presente.</p>";
    } else {
        echo "<table>";
        echo "<tr><th>Foto</th><th>Titolo</th><th>Autore</th><th>Testo</th><th>Data</th></tr>";

        foreach ($posts as $post) {
            echo "<tr>";
            echo "<td>";
            if ($post->percorsoFoto !== "") {
                echo "<img src='" . htmlspecialchars($post->percorsoFoto, ENT_QUOTES) . "' alt='" . htmlspecialchars($post->titolo, ENT_QUOTES) . "'>";
            }
            echo "<span class='didascalia'>" . htmlspecialchars($post->didascalia) . "</span>";
            echo "</td>";
            echo "<td>" . htmlspecialchars($post->titolo) . "</td>";
            echo "<td>" . htmlspecialchars($post->autore) . "</td>";
            echo "<td class='testo'>" . htmlspecialchars($post->testo) . "</td>";
            echo "<td>" . htmlspecialchars($post->data) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    }
    ?>
</body>
</html>