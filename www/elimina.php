<?php
require_once "connessione.php";
require_once "Post.php";

// L'id arriva dal pulsante Elimina (get) o dalla conferma (post).
$id = $_POST["id"] ?? $_GET["id"] ?? "";
$post = leggiPostDaId($pdo, $id);

if (!$post) {
    header("Location: gestione.php");
    exit;
}

// Il post viene eliminato solo dopo la conferma.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $post->elimina($pdo);

    header("Location: gestione.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elimina un post</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <?php readfile("menu.html"); ?>

    <h1>Elimina un post</h1>

    <p>Vuoi davvero eliminare il post "<?php echo htmlspecialchars($post->titolo); ?>"?</p>

    <div class="azioni">
        <form method="post" action="elimina.php">
            <input type="hidden" name="id" value="<?php echo $post->id; ?>">
            <button type="submit">Sì, elimina</button>
        </form>
        <form method="get" action="gestione.php">
            <button type="submit">No, annulla</button>
        </form>
    </div>
</body>
</html>
