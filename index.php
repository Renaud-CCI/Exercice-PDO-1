<?php
$bdd = "mysql:host=127.0.0.1;dbname=colyseum;charset=utf8";
$user= "root";
$password = "";


try{
    $dataBase = new PDO($bdd, $user, $password);
    echo "Connexion OK <br>";
}
catch(Exception $e){
    die('Erreur : ' . $e->getMessage());
}

$colyseumClients = $dataBase->query('SELECT *, DATE_FORMAT(birthDate,"%d/%m/%Y") AS niceBirthDate FROM clients');

$clients = $colyseumClients->fetchAll();

function prettyDump($data){
    highlight_string("<?php\n\$data =\n" . var_export($data, true) . ";\n?>");
}

// prettyDump($clients[0]);

?>
//------------EXERCICE 1-----------
<hr>
<h2>Liste des clients</h2>
<ul>
    <?php
    foreach ($clients as $client) {
        echo "<li> {$client['firstName']} {$client['lastName']} </li>";
    } 
    ?>
</ul>


<!-- -------------EXERCICE 2---------------- -->
<?php
$colyseumGenres = $dataBase->query('SELECT * FROM showTypes');
$showTypes = $colyseumGenres->fetchAll();
?>
<hr>
<h2>Liste des types de spectacles</h2>
<ul>
    <?php
    foreach ($showTypes as $showType){
        echo "<li> {$showType['type']}</li>";
    }
    ?>
</ul>

<!-- -----------EXERCICE 3---------------- -->

<hr>
<h2>20 premiers clients</h2>
<!-- <?php prettyDump($clients) ?> -->
<ul>
    <?php
    foreach ($clients as $key => $client) {
        if ($key < 20){
          echo "<li>Client n°" . $key+1 . " : ". $client['firstName'] . " " . $client['lastName'] . "</li>"; 
        }
    } 
    ?>
</ul>

<!-- --------------EXERCICE 4-------------------- -->
<hr>
<h2>Clients avec carte de fidélité</h2>
<ul>
    <?php
    foreach ($clients as $client) {
        if ($client['cardNumber']){
          echo "<li>" . $client['firstName'] . " " . $client['lastName'] . "</li>"; 
        }
    } 
    ?>
</ul>


<!-- --------------EXERCICE 5------------- -->
<?php
$colyseumClientsM = $dataBase->query('SELECT * FROM clients WHERE lastname LIKE "m%" ORDER BY lastname');

$clientsM = $colyseumClientsM->fetchAll();

?>
<hr>
<h2>Clients avec nom commençant par M</h2>
<ul>
    <?php
    foreach ($clientsM as $clientM) {
          echo "<li> <strong>Nom :</strong> " . $clientM['lastName'] . " - <strong>Prénom : </strong>" . $clientM['firstName'] . "</li>";
    } 
    ?>
</ul>


<!-- -------------------EXERCICE 6--------------- -->
<?php
$colyseumShows = $dataBase->query('SELECT *, DATE_FORMAT(date,"%d/%m/%Y") AS niceDate, DATE_FORMAT(startTime, "%Hh%i") AS niceStartTime FROM shows');

$shows = $colyseumShows->fetchAll();

?>
<hr>
<h2>Spectacles</h2>
<ul>
    <?php
    foreach ($shows as $show) {
          echo "<li>" . $show['title']. " par " . $show['performer']. ", le " .  $show['niceDate']. " à " . $show['niceStartTime'] . ".</li>";
    } 
    ?>
</ul>


<!-- ------------EXERCICE 7------------ -->
<hr>
<h2>Identité des clients</h2>
<ul>
    <?php
    foreach ($clients as $client) {
        echo 
        "<li>" .
        "<strong>Nom : </strong>" . $client["lastName"]. "<br>" .
        "<strong>Prénom : </strong>" . $client["firstName"]. "<br>" .
        "<strong>Date de naissance : </strong>" . $client["niceBirthDate"]. "<br>" .
        "<strong>Carte de fidélité : </strong>" . (($client["card"]==1)? "oui" : "non"). "<br>" .
        ($client["cardNumber"]?  "<strong>Numéro de carte : </strong>" .$client["cardNumber"] . "<br>":""). 
        "<br>" .
        "</li>";
    } 
    ?>
</ul>



