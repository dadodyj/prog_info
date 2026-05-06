<?php

$conn = mysqli_connect("localhost", "root", "", "secure_domus");

if (!$conn) {
    die("Errore connessione DB");
}

$email = $_POST['email'];
$pswrd = $_POST['pswrd'];
$nome = $_POST['nome'];

/* controllo utente */
$query = "SELECT id_cliente FROM clienti WHERE email='$email' AND pswrd='$pswrd' AND nome='$nome'";
$result = $conn->query($query);

if ($result->num_rows == 0) {
    echo "<h2 style='text-align:center;margin-top:50px;'>Credenziali errate</h2>";
    echo "<div style='text-align:center'><a href='prodotti.html'>Riprova</a></div>";
    exit();
}

$row = $result->fetch_assoc();
$id_cliente = $row['id_cliente'];

/* conteggio prodotti */
$query = " SELECT t.tipo, COALESCE(COUNT(p.id_prodotto), 0) AS totale FROM (SELECT 'Telecamera' AS tipo UNION ALL SELECT 'Sensore' UNION ALL SELECT 'Allarme') t LEFT JOIN prodotti p ON p.tipo = t.tipo AND p.cod_cliente = $id_cliente GROUP BY t.tipo";

/* query: SELECT t.tipo, COALESCE(COUNT(p.id_prodotto), 0) AS totale
FROM (
    SELECT 'Telecamera' AS tipo
    UNION ALL SELECT 'Sensore'
    UNION ALL SELECT 'Allarme'
) t
LEFT JOIN prodotti p
    ON p.tipo = t.tipo AND p.cod_cliente = $id_cliente
GROUP BY t.tipo
*/
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>I tuoi prodotti</title>
    <link rel="stylesheet" href="/progetto_info/css/index.css">
</head>

<body>

<header class="navbar">
    <div class="container nav-content">
        <h1 class="logo">SecureDomus</h1>
        <nav>
            <ul>
                <li><a href="/progetto_info/index.html">Home</a></li>
                <li><a href="/progetto_info/shop.html">Shop</a></li>
            </ul>
        </nav>
    </div>
</header>

<section class="section">
    <div class="container">
        <h2>I tuoi sistemi di sicurezza</h2>

        <div class="cards">

        <?php while ($row = $result->fetch_assoc()) { ?>

            <div class="card">
                <h3><?php echo $row['tipo']; ?></h3>
                <p>Quantità: <?php echo $row['totale']; ?></p>
            </div>

        <?php } ?>

        </div>
    </div>
</section>

<footer>
    <div class="container">
        <p>© 2026 SecureDomus</p>
    </div>
</footer>

</body>
</html>