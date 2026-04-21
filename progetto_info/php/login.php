<?php

$conn = mysqli_connect("localhost", "root", "", "secure_domus");
if (!$conn) {
die("Errore di connessione al database");
}

$email = $_POST["email"];
$password = $_POST["pswrd"];

$sql = "SELECT * FROM clienti WHERE email = '$email' AND pswrd = '$password'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    
        header('Location: /progetto_info/index.html');
        exit();
    
} else {
    echo "Email o password errati o già registrati";
}

mysqli_close($conn);

?>