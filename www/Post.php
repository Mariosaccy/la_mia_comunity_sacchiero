<?php
// Un post della community con la sua foto.
class Post
{
    public $id;
    public $autore;
    public $titolo;
    public $testo;
    public $data;
    public $percorsoFoto;
    public $didascalia;

    function __construct($id, $autore, $titolo, $testo, $data, $percorsoFoto, $didascalia)
    {
        $this->id = $id;
        $this->autore = $autore;
        $this->titolo = $titolo;
        $this->testo = $testo;
        $this->data = $data;
        $this->percorsoFoto = $percorsoFoto;
        $this->didascalia = $didascalia;
    }

    // Salva un nuovo post e la sua foto.
    function inserisci($pdo)
    {
        $sql = "INSERT INTO post (nome_autore, titolo, testo_post) VALUES (?, ?, ?)";
        $query = $pdo->prepare($sql);
        $query->execute([$this->autore, $this->titolo, $this->testo]);

        // Serve l'id del post appena creato per collegargli la foto.
        $this->id = $pdo->lastInsertId();
        $this->inserisciFoto($pdo);
    }

    // Salva le modifiche del post e sostituisce la sua foto.
    function aggiorna($pdo)
    {
        $sql = "UPDATE post SET nome_autore = ?, titolo = ?, testo_post = ? WHERE id_post = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$this->autore, $this->titolo, $this->testo, $this->id]);

        $query = $pdo->prepare("DELETE FROM foto WHERE id_post = ?");
        $query->execute([$this->id]);
        $this->inserisciFoto($pdo);
    }

    // Elimina il post: la foto viene cancellata dal database con ON DELETE CASCADE.
    function elimina($pdo)
    {
        $query = $pdo->prepare("DELETE FROM post WHERE id_post = ?");
        $query->execute([$this->id]);
    }

    function inserisciFoto($pdo)
    {
        $sql = "INSERT INTO foto (id_post, percorso_file, didascalia) VALUES (?, ?, ?)";
        $query = $pdo->prepare($sql);
        $query->execute([$this->id, $this->percorsoFoto, $this->didascalia]);
    }
}

// Crea un oggetto Post da una riga della tabella post, leggendo anche la sua foto.
function creaPost($pdo, $riga)
{
    $query = $pdo->prepare("SELECT percorso_file, didascalia FROM foto WHERE id_post = ?");
    $query->execute([$riga->id_post]);
    $foto = $query->fetch(PDO::FETCH_OBJ);

    $percorsoFoto = "";
    $didascalia = "";
    if ($foto) {
        $percorsoFoto = $foto->percorso_file;
        $didascalia = $foto->didascalia ?? "";
    }

    return new Post(
        $riga->id_post,
        $riga->nome_autore,
        $riga->titolo,
        $riga->testo_post,
        $riga->data_pubblicazione,
        $percorsoFoto,
        $didascalia
    );
}

// Restituisce tutti i post, dal più recente.
function leggiPost($pdo)
{
    $query = $pdo->query("SELECT * FROM post ORDER BY id_post DESC");
    $righe = $query->fetchAll(PDO::FETCH_OBJ);

    $posts = array();
    foreach ($righe as $riga) {
        $posts[] = creaPost($pdo, $riga);
    }
    return $posts;
}

// Restituisce un solo post, oppure null se non esiste.
function leggiPostDaId($pdo, $id)
{
    $query = $pdo->prepare("SELECT * FROM post WHERE id_post = ?");
    $query->execute([$id]);
    $riga = $query->fetch(PDO::FETCH_OBJ);

    if (!$riga) {
        return null;
    }
    return creaPost($pdo, $riga);
}
?>
