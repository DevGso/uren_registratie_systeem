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
    <title>Home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="icon" href="../img/Afbeelding1.png">
</head>

<body>
    <nav id="navbar">
        <div id="nav-links">
            <a href="../overzicht/index.php">Overzicht</a>
            <img src="../img/Afbeelding1.png" alt="Devops Logo" id="logo" />
            <a href="../account/index.php" id="account"><img src="../img/IconAccount.svg" alt="Icoon acount" id="acount_icoon">
            <span id="account_txt"><?php echo $_SESSION["naam"]; ?></span></a>
            <?php if ($_SESSION["functie"] == "medewerker") { ?>
            <a href="../registratie/index.php">Tijdregistratie </a> 
            <?php } ?>
        </div>
    </nav>
    <main>
        <article>
            <header id="header_arti">
                <h1>Welkom op de Tijdregistratie website</h1>
            </header>
            
            <div id="inhoud_arti">
            <span>Hier kunt u de tijden die je gewerkt hebt aan welk project registreren en terugkijken op wat jij en
            andere al hebben gedaan. Kies een van de opties in de navigatiebalk.</span>
            </div>
        </article>
    </main>
</body>