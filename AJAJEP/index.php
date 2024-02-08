<?php
    error_reporting(0);
    ini_set("display_errors", 0);
    session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Enregistrement</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">

            <?php
                include("php/config.php");

                if(isset($_POST['submit']) && !empty($_POST['submit'])){
                    //Si le formulaire est soumis on recupere les donnees dans des variables
                    $userLastName = mysqli_real_escape_string($con, $_POST['userLastName']);
                    $userFirstName = mysqli_real_escape_string($con, $_POST['userFirstName']);
                    $userMail = mysqli_real_escape_string($con, $_POST['userMail']);
                    
                    //on eregistre toutes les informations dans $result
                    $result = mysqli_query($con, "SELECT * FROM users WHERE UserLastName ='$userLastName' AND UserFirstName = '$userFirstName' AND Email = '$userMail'") or die("Select error");

        
                    $row = mysqli_fetch_assoc($result);

                    if(is_array($row) && !empty($row)){
                        $_SESSION['valid'] = $row['Email'];
                        $_SESSION['userLastName'] = $row['UserLastName'];
                        $_SESSION['userFirstName'] = $row['UserFirstName'];
                        $_SESSION['sexe'] = $row['Sexe'];
                        $_SESSION['phone'] = $row['Phone'];
                        $_SESSION['birthDate'] = $row['BirthDate'];
                        $_SESSION['profilImage'] = $row['ProfilImage'];
                        $_SESSION['id'] = $row['Id'];
                    }
                    else{
                        echo "<div class='message'>
                                <p>Informations incorrects</p>
                              </div><br>";

                        echo "<a href='index.php'><button class='btn'>Retour</button>";
                    }

                    if(isset($_SESSION['valid'])){
                        header("Location: home.php");
                    }
                }
                else{
            ?>

            <header>Formulaire d'enregistrement <span>AJAJEP</span></header>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="field input">
                    <label for="userLastName">Nom*</label>
                    <input type="text" name="userLastName" id="userLastName" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="userLastName">Prénom*</label>
                    <input type="text" name="userFirstName" id="userFirstName" autocomplete="off" required>
                </div>


                <div class="field input">
                    <label for="userMail">Email*</label>
                    <input type="email" name="userMail" id="userMail" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Verifier">
                </div>

                <div class="link">
                    <p>Vous n'avez pas encore rempli le formulaire <a href="register.php">Cliquez ici</a></p>
                </div>
            
            </form>
        </div>
            <?php } ?>
    </div>
</body>
</html>