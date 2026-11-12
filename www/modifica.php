<?php
require_once "connessione.php";
require_once "Post.php";

// L'id arriva dal pulsante Modifica (get) o dal form di questa pagina (post).
$id = $_POST["id"] ?? $_GET["id"] ?? "";
$post = leggiPostDaId($pdo, $id);

if (!$post) {
    header("Location: gestione.php");
    exit;
}

// Esegue il codice quando viene premuto Salva.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $post->autore = $_POST["autore"] ?? "";
    $post->titolo = $_POST["titolo"] ?? "";
    $post->testo = $_POST["testo"] ?? "";
    $post->percorsoFoto = $_POST["percorso_foto"] ?? "";
    $post->didascalia = $_POST["didascalia"] ?? "";
    $post->aggiorna($pdo);

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica un post</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <?php readfile("menu.html"); ?>

    <h1>Modifica un post</h1>

    <form method="post" action="modifica.php">
        <input type="hidden" name="id" value="<?php echo $post->id; ?>">

        <label for="autore">Autore</label>
        <input type="text" id="autore" name="autore" maxlength="50" value="<?php echo htmlspecialchars($post->autore); ?>" required>

        <label for="titolo">Titolo</label>
        <input type="text" id="titolo" name="titolo" maxlength="150" value="<?php echo htmlspecialchars($post->titolo); ?>" required>

        <label for="testo">Testo</label>
        <textarea id="testo" name="testo" rows="5" required><?php echo htmlspecialchars($post->testo); ?></textarea>

        <label for="percorso_foto">Percorso della foto</label>
        <input type="text" id="percorso_foto" name="percorso_foto" maxlength="255" value="<?php echo htmlspecialchars($post->percorsoFoto); ?>" required>

        <label for="didascalia">Didascalia</label>
        <input type="text" id="didascalia" name="didascalia" maxlength="200" value="<?php echo htmlspecialchars($post->didascalia); ?>">

        <button type="submit">Salva</button>
    </form>
</body>
</html>
