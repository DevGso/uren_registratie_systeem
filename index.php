<!DOCTYPE html>
<?php 
include 'connect.php';
?>
<html lang="nl">

<head>
    <title>Inloggen</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="css/inloggen.css">
    <link rel="icon" href="img/Afbeelding1.png">
</head>

<body>
    <main>
        <section>
        <img src="img/Afbeelding1.png" alt="Devops Logo" id="logo" />
        <?php if ($is_error === true) {?>
                <p class = "error">Er is een probleem met de database connectie</p>
                <?php exit;
                } ?>
        <form action="index.php" method="post">
            <label for="Naam">Gebruikers naam</label>
            <input type="text" name="gebruikers_naam" id="gebruikers_naam" required>
            <label for="">wachtwoord</label>
            <input type="password" name="wachtwoord" id="wachtwoord" required>
            <input type="submit" value="inloggen">
        </form>

<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$input_naam = $_POST["gebruikers_naam"];
$input_password = $_POST["wachtwoord"];

$login_data_query = "SELECT * From employees 
where CONCAT_WS(' ', voornaam, tussenvoegsel, achternaam) = ?
and wachtwoord = ? ";
$login_data = $conn->prepare($login_data_query);
$login_data->execute([$input_naam, $input_password]);
$login_data = $login_data->fetchAll(PDO::FETCH_ASSOC);

if (empty($login_data)){ ?>
        <div id = "fout_ww">
            <span>De gebruikersnaam en het wachtwoord komt niet overheen</span>
        </div>
    <?php
} else {
    $opgehaalde_data = $login_data[0];
            session_start();
            session_regenerate_id();
            $_SESSION["naam"] = $input_naam;
            $_SESSION["employee_id"] = $opgehaalde_data['employee_id'];
            $_SESSION["functie"] = $opgehaalde_data['functie'];
            header('Location: ./home/index.php');
            exit;
}
}

?>
</section>
</main>
</body>
</html>