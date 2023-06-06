<?php
// Ukoliko nam se errori ne prikazuju uopste, potrebno je otkomentarisati narednu liniju koda
// error_reporting(E_ALL);

// Korisnike cuvamo u JSON fajlu, pa je potrebno da ih ili preuzmemo iz fajla ili kreiramo prazan fajl ukoliko on ne postoji.
// Niz svih korisnika smestamo u $users promenljivu ukoliko fajl postoji, a ako ne postoji onda promenljivoj $users dodeljujemo prazan niz.
session_start();
$loginuser = $_SESSION["user"];
$vaseime = $loginuser["name"];



$filename = 'users.json';

if (file_exists($filename)) {
    $users = json_decode(file_get_contents($filename), true);
} else {
    file_put_contents($filename, json_encode([]));
    $users = [];
}

?>
<html>

<head>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <div class="header-content">
            <!-- TODO: Home stranica ima drugaciji header, pa je ovde potrebno to odraditi -->
            <p>Welcome</p>
            <p><?php echo $vaseime  ?></p>
            <!--             <a href="logout.php">Logout</a>
 -->
        </div>
        <hr>
    </header>
    <section>
        <!-- TODO: Ovde je potrebno izlistati sve korisnike -->
        <p> All customers: </p>
        <?php foreach ($users as $user) { ?>
            <li><?php echo $user["name"];    ?></li>
        <?php }   ?>
    </section>
    <?php include('footer.php'); ?>
</body>

</html>