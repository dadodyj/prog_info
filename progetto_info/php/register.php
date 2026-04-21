<?php
$conn = mysqli_connect("localhost", "root", "", "secure_domus");
if (!$conn) {
die("Errore di connessione al database");
}

$nome = $_POST["nome"];
$email = $_POST["email"];
$password = $_POST["pswrd"];
$check = false;

$sql = "INSERT INTO clienti (nome, email, pswrd) VALUES ('$nome', '$email', '$password')";
$sql1 = "SELECT * FROM clienti WHERE email = '$email' AND pswrd = '$password'";

while($check == false){
    
    if (mysqli_query($conn, $sql1)) {
        $result = mysqli_query($conn, $sql1);
        if (mysqli_num_rows($result) > 0) {
            echo "utente già registrato";
            $check = true;
        } else if(mysqli_query($conn, $sql)) {
            echo "Registrazione avvenuta con successo";
            $check = true;
            header('Location: /progetto_info/index.html');
            exit();        
        }
    }
}


mysqli_close($conn);
?>