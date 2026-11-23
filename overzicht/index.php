<!DOCTYPE html>
<?php 
session_start();
if (!isset($_SESSION["employee_id"])) {
    header('Location: ../index.php');
exit;
} 
include '../connect.php';


?>
<html lang="nl">

<head>
    <title>Overzicht</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="../css/overzicht.css">
    <link rel="icon" href="../img/Afbeelding1.png">
</head>

<?php
    if ($is_error === false) {
    $query_all = "SELECT * FROM `timesheets` as t
JOIN employees as em on t.employee_id = em.employee_id
JOIN projects as p on p.project_id = t.project_id ORDER BY `datum` DESC";

    

    
    $data_all = $conn->prepare($query_all);
    $data_all->execute(array());
    $data_all = $data_all->fetchAll(PDO::FETCH_ASSOC);

    $query_medewerker = "SELECT * FROM employees";

    $data_medewerker = $conn->prepare($query_medewerker);
    $data_medewerker->execute(array());
    
    $query_project = "SELECT * FROM projects";

    $data_projects = $conn->prepare($query_project);
    $data_projects->execute(array());

    $query_filter = "SELECT * FROM timesheets AS t
JOIN employees AS em 
    ON t.employee_id = em.employee_id
JOIN projects AS p 
    ON p.project_id = t.project_id 
WHERE 
    (t.employee_id = :te_id OR :te_id IS NULL)
AND (p.project_id = :pp_id OR :pp_id IS NULL) 
AND (:tv_date IS NULL OR t.datum >= :tv_date)
AND (:tt_date IS NULL OR t.datum <= :tt_date)
ORDER BY t.datum DESC";

$query_filter = $conn->prepare($query_filter);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

if ($_SESSION["functie"] == "hr") {
    $employee_id = $_POST["employee_id"];
    }
    $projects_id = $_POST["project_id"];
    $date_van = $_POST["datum_van"];
    $date_tot = $_POST["datum_tot"];

    if ($_SESSION["functie"] == "hr") {
    if ($_POST["employee_id"] === "0") {$employee_id = NULL; }
} else {$employee_id = NULL;}
    if ($_POST["project_id"] === "0") {$projects_id = NULL; }
    if ($_POST["datum_van"] === "") {$date_van = NULL; }
    if ($_POST["datum_tot"] === "") {$date_tot = NULL; }
    $query_filter->execute(['te_id' => $employee_id, 'pp_id' => $projects_id, 'tv_date' => $date_van, 'tt_date' => $date_tot]); 
    $data_all = $query_filter->fetchAll(PDO::FETCH_ASSOC);
    }
    }
?>

<body> <div id = "no_print">
    <nav id="navbar">
        <div id="nav-links">
            <img src="../img/Afbeelding1.png" alt="Devops Logo" id="logo" />
            <?php if ($_SESSION["functie"] == "medewerker") { ?>
            <a href="../registratie/index.php">Tijdregistratie </a> 
            <?php } ?>

            <a href="../account/index.php" id="account"><img src="../img/IconAccount.svg" alt="Icoon acount"
                    id="acount_icoon">
                <span id="account_txt"><?php echo $_SESSION["naam"]; ?></span></a>
            <a href=../home/index.php>Home</a>
        </div>
    </nav></div>
    <main>
        <section>
            <header id="header_sect">
                <h1>Overzicht geregistreerden tijden</h1>
            </header>

            <?php if ($is_error === true) {?>
                <p class = "error">Er is een probleem met de database connectie</p>
                <p class = "error"><?php echo $error_Message; ?></p>
                
                <?php exit;
                }
                ?>
            <form action="index.php" method="POST">
                <?php if ($_SESSION["functie"] == "hr" || $_SESSION["functie"] == "facturatie") { ?>
                <?php if ($_SESSION["functie"] == "hr") { ?>
                <select name="employee_id" id="medewerker" class="filter_invoer">
                    <option value="0">Alle medewerkers</option>
                    <?php foreach ($data_medewerker as $medewerker) { ?>
                    <option value="<?php echo $medewerker["employee_id"] ?>">
                        <?php echo htmlspecialchars($medewerker["voornaam"]); echo " " . htmlspecialchars($medewerker["tussenvoegsel"]); echo " " . htmlspecialchars($medewerker["achternaam"]);?>
                    </option>
                    <?php
                        } 
                        } ?>
                </select>
                <select name="project_id" id="project" class="filter_invoer">
                    <option value="0">Alle projecten</option>
                    <?php foreach ($data_projects as $projects) { ?>
                    <option value=<?php echo $projects["project_id"] ?>>
                        <?php echo $projects["project_nummer"] . " " . $projects["projectnaam"]?>
                    </option>
                    <?php } ?>
                </select>
                <input type="date" name="datum_van" class="filter_invoer">
                <input type="date" name="datum_tot" class="filter_invoer">

                <input type="submit" value = "Filteren">
                <?php if (true) { ?>
                    <img src="../img/printer_icon.png" id = "printer_icon" onclick = "window.print()"></img>
                <?php } ?>
                
                <?php } ?>
            </form>
            

            <div id="all_data_tonen">
                <?php foreach ($data_all as $data) { ?>
                <table id="tabel_data">
                    <tr class="tabel_tonen_data">
                        <th>Naam</th>
                        <td>
                            <?php echo $data["voornaam"]; echo " " . $data["tussenvoegsel"]; echo " " . $data["achternaam"];?>
                        </td>
                        <th>userstory</th>
                        <td>
                            <?php echo $data["project_nummer"] . " " . $data["projectnaam"]; ?>
                        </td>
                        <th>datum</th>
                        <td>
                            <?php echo $data["datum"]; ?>
                        </td>
                        <th>Tijd gewerkt</th>
                        <td>
                            <?php echo $data["aantal_uren"]; ?>
                        </td>
                        <th>Werkzaamheden</th>
                        <td id="beschrijving_werkzaamheden">
                            <?php echo $data["omschrijving"]; ?>
                        </td>
                        <th>afgerond</th>
                            <td> <?php if ($data["afgerond"] === 1) { echo "Ja"; } else { echo "Nee"; }; ?> 
                            </td>
                    </tr>
                </table>
                <?php } ?>
            </div>
        </section>
    </main>
</body>

</html>