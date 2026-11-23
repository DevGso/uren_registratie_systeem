<!DOCTYPE html>
<html lang="nl">

<?php 
session_start();
if (!isset($_SESSION["employee_id"])) {
    header('Location: ../index.php');
exit;
} 
?>

<head>
    <title>Account</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="../css/account.css">
    <link rel="icon" href="../img/Afbeelding1.png">
</head>

<body>
    <nav id="navbar">
        
        <div id="nav-links">
            <img src="../img/Afbeelding1.png" alt="Devops Logo" id="logo" />
            <a href="../overzicht/index.php">Overzicht</a>
            <a href="../home/index.php">Home</a>
            <?php if ($_SESSION["functie"] == "medewerker") { ?>
            <a href="../registratie/index.php">Tijdregistratie </a> 
            <?php } ?>
        </div>
    </nav>
    <main>
        <article>
            <header id="header_arti">
                <h1>Account</h1>
            </header>
            
            <div id="inhoud_arti">
            <p>Je bent ingelogd op het account: <?php echo htmlspecialchars($_SESSION["naam"])?></p>
            <p>Medewerker ID: <?php echo $_SESSION["employee_id"] ?></p>
            <form action="index.php" method = "post">
            <input id="uitloggen" type = "submit" value = "uitloggen"></form>
            </div>
        </article>
    </main>

    <?php if($_SERVER["REQUEST_METHOD"] == "POST"){
    session_destroy();
    header('Location: ../index.php');
    exit;
    }
    ?>
</body>