<?php
// Connessione al database: i dati arrivano dal file compose.yaml.
$pdo = new PDO(
    "mysql:host=" . getenv("DB_HOST") . ";dbname=" . getenv("DB_NAME") . ";charset=utf8mb4",
    getenv("DB_USER"),
    getenv("DB_PASSWORD")
);
?>
