<!DOCTYPE html>
<html lang="nl">
    <?php 
    session_start();
if (!isset($_SESSION["employee_id"])) {
    header('Location: ../index.php');
exit;
} 
    include '../connect.php';
    if ($is_error === false) {
    $query_project = "SELECT * FROM projects";
    $data_project = $conn->prepare($query_project);
    $data_project->execute(array());
    }
    ?>

<head>
    <title>Tijdregistratie</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="../css/registratie.css">
    <link rel="icon" href="../img/Afbeelding1.png">
</head>

<body>
    <nav id="navbar">
        <div id="nav-links">
            <a href="../overzicht/index.php">Overzicht</a>
            <img src="../img/Afbeelding1.png" alt="Devops Logo" id="logo" />
            <a href="../account/index.php" id="account"><img src="../img/IconAccount.svg" alt="Icoon acount" id="acount_icoon">
            <span id="account_txt"><?php echo $_SESSION["naam"]; ?></span></a>
            <a href="../home/index.php">Home</a>
        </div>
    </nav>
    <main>
        <section id="sect">
            <header id="header">
                <h1>Tijdregistratie</h1>
            </header>

            <?php if ($is_error === true) {?>
                <p class = "error">Er is een probleem met de database connectie</p>
                <p class = "error"><?php echo $error_Message; ?></p>
                <?php exit;
                }
                ?>
            <form id="form" name="formulier" action="../registratie/index.php" method="post">

            <span><?php echo "Medewerken: " . htmlspecialchars($_SESSION["naam"]) . ""; ?></span>
            <span> <?php echo "Medewerker ID: " . $_SESSION["employee_id"] ?></span>
            


                <label for="us_kiezen">Welke userstory</label>
                <select name="userstory" required>
                    <option>Selecteer een userstory</option>
                    <?php foreach ($data_project as $projects) {
                        if ($projects['afgerond'] === 0) { ?>
                            <option value=<?php echo $projects["project_id"]; ?>>
                        <?php echo $projects["project_nummer"] . " " . $projects["projectnaam"];  ?>
                        </option>
                        <?php }
                    } ?>
                </select>

                <label for="">datum</label>
                <input type="date" name="datum">
                <label for="">Tijd aan gewerkt</label>
                <input type="time" name="werktijd" step = "900" placeholder = "Kan alleen per was">

                <label for="tip">Werzaamheden</label>
                <textarea name="werkzaamheden" id="werkzaamheden" rows="3" cols="30"
                    class="for-textarea">@ media maken en uiterlijk tabel voor overzichts pagina</textarea>

                <input type="submit" value="Insturen" id="submit" name="submit">

            </form>
        </section>
    </main>
    <?php 


        if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $project_id = $_POST["userstory"];
        $datum = $_POST["datum"];
        $aantal_uren = $_POST["werktijd"];
        $Werkzaamheden = $_POST["werkzaamheden"];
        $query_insert = "INSERT INTO `timesheets`(`employee_id`, `project_id`, `aantal_uren`, `omschrijving`, `datum`) 
        VALUES (?, ?, ?, ?, ?)";
        $data_insert = $conn->prepare($query_insert);
        $data_insert->execute([$_SESSION["employee_id"], $project_id, $aantal_uren, $Werkzaamheden, $datum]);
        }

    ?>
</body>