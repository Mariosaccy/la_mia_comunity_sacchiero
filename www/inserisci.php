<?php
require_once "connessione.php";
require_once "Post.php";

// Esegue il codice quando viene inviato il form.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $post = new Post(
        null,
        $_POST["autore"] ?? "",
        $_POST["titolo"] ?? "",
        $_POST["testo"] ?? "",
        null,
        $_POST["percorso_foto"] ?? "",
        $_POST["didascalia"] ?? ""
    );
    $post->inserisci($pdo);

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserisci un post</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <?php readfile("menu.html"); ?>

    <h1>Inserisci un post</h1>

    <form method="post" action="inserisci.php">
        <label for="autore">Autore</label>
        <input type="text" id="autore" name="autore" maxlength="50" required>

        <label for="titolo">Titolo</label>
        <input type="text" id="titolo" name="titolo" maxlength="150" required>

        <label for="testo">Testo</label>
        <textarea id="testo" name="testo" rows="5" required></textarea>

        <label for="percorso_foto">Percorso della foto</label>
        <input type="text" id="percorso_foto" name="percorso_foto" maxlength="255" placeholder="img/tramonto.jpg" required>

        <label for="didascalia">Didascalia</label>
        <input type="text" id="didascalia" name="didascalia" maxlength="200">

        <button type="submit">Invia</button>
    </form>

    <form method="get" action="gestione.php">
        <button type="submit">Elimina o modifica elementi</button>
    </form>
</body>
</html>
