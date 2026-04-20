<?php
$conn = mysqli_connect("localhost", "root", "", "secure_domus");
if (!$conn) {
die("Errore di connessione al database");
}

$nome = $_POST["nome"];
$email = $_POST["email"];
$password = $_POST["pswrd"];

$sql = "INSERT INTO clienti (nome, email, pswrd) VALUES ('$nome', '$email', '$password')";

if (mysqli_query($conn, $sql)) {
echo "Registrazione avvenuta con successo";
} else {
echo "Errore durante la registrazione: " . mysqli_error($conn);
}

mysqli_close($conn);
?>