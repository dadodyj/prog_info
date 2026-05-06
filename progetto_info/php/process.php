
<?php

$conn = mysqli_connect("localhost", "root", "", "secure_domus");

if (!$conn) {
    die("Errore di connessione al database");
}

// dati dal form
$email = $_POST['email'];
$pswrd = $_POST['pswrd'];
$nome = $_POST['nome'];
$citta = $_POST['citta'];
$id_catalogo = $_POST['id_catalogo'];


// 1. controllo cliente (NON deve essere creato)
$query = "SELECT id_cliente, pswrd FROM clienti WHERE email='$email'";
$result = $conn->query($query);

if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();

    // controllo password
    if ($row['pswrd'] !== $pswrd) {
        echo "<h2>Password errata</h2>";
        echo "<a href='acquista.html'>Torna indietro</a>";
        exit();
    }

    $id_cliente = $row['id_cliente'];

} else {

    // utente non esistente
    echo "<h2>Utente non registrato</h2>";
    echo "<p>Non esiste un account con questa email.</p>";
    echo "<a href='register.html'>Registrati qui</a>";
    exit();
}


// 2. centralina in base alla città
$query = "SELECT id_centralina FROM centraline WHERE posizione='$citta' LIMIT 1";
$res = $conn->query($query);

if (!$res || $res->num_rows == 0) {
    echo "<h2>Errore: città non trovata nel sistema</h2>";
    echo "<a href='acquista.html'>Torna indietro</a>";
    exit();
}

$row = $res->fetch_assoc();
$id_centralina = $row['id_centralina'];


// 3. dati prodotto (statici)
if($id_catalogo == 1){
    $tipo = "Telecamera";
    $modello = "X100";
} elseif($id_catalogo == 2){
    $tipo = "Sensore";
    $modello = "S200";
} else {
    $tipo = "Allarme";
    $modello = "A300";
}


// 4. inserimento prodotto
$query = "INSERT INTO prodotti(tipo, data_acquisto, modello, cod_cliente, cod_magazzino, cod_centralina) VALUES ('$tipo', CURDATE(), '$modello', $id_cliente, 1, $id_centralina)";

if ($conn->query($query)) {
    echo "<h2>Acquisto completato!</h2>";
    echo "<a href='shop.html'>Torna allo shop</a>";
} else {
    echo "<h2>Errore durante l'acquisto</h2>";
}

?>