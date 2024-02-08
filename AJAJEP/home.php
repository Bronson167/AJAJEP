<?php
    error_reporting(0);
    ini_set("display_errors", 0);
    session_start();

    include("php/config.php");

    if(!isset($_SESSION['valid'])){
        header("Location: index.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Home</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <img src="image/AJAJEP.jpg">
        </div>

        <div class="right-links">

            <?php
            
                $id = $_SESSION['id'];
                $query = mysqli_query($con, "SELECT*FROM users WHERE Id = $id");

                while($result = mysqli_fetch_assoc($query)){
                    $res_ULastName = $result["UserLastName"];
                    $res_UFirstName = $result["UserFirstName"];
                    $res_USexe= $result["Sexe"];
                    $res_UPhone = $result["Phone"];
                    $res_UEmail = $result["Email"];
                    $res_UBirthDate = $result["BirthDate"];
                    $res_UProfilImage = $result["ProfilImage"];
                    $res_Id = $result["Id"];
                }

                echo "<a href='edit.php?Id=$res_Id'>Modifier une information</a>";

            ?>
            <a href="php/logout.php"><button class="btn">Enregistrer</button></a>
        </div>
    </div>

    <main>
        <div class="main-box top">
            
            <div class="bottom">
                <div class="box">
                    <?php echo "<p>Hello <b>$res_UFirstName $res_ULastName</b>! Voici les informations que vous avez saisies</p>"; ?>
                </div>
            </div>

            <div class="top">

            
                <div class="box">
                    <?php echo "<p>Nom : <b>".htmlspecialchars($res_ULastName)."</b>.</p>"; ?>
                </div>

                <div class="box">
                    <?php echo "<p>Prénom : <b>".htmlspecialchars($res_UFirstName)."</b>.</p>"; ?>
                </div>

                <div class="box">
                    <?php echo "<p>Sexe : <b>".htmlspecialchars($res_USexe)."</b>.</p>"; ?>
                </div>

                <div class="box">
                    <?php echo "<p>Date de naissance : <b>".htmlspecialchars($res_UBirthDate)."</b>.</p>"; ?>
                </div>

                <div class="box">
                    <?php echo "<p>Téléphone : <b>".htmlspecialchars($res_UPhone)."</b>.</p>"; ?>
                </div>

                <div class="box">
                    <?php echo "<p>Email : <b>".htmlspecialchars($res_UEmail)."</b>.</p>"; ?>
                </div>
            </div>

            <div class="bottom">
                <div class="box">
                    <p><em><b>AJAJEP toujours plus haut !</b></em></p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>