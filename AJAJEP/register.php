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
                error_reporting(0);
                ini_set("display_errors", 0);
                include("php/config.php");

                if(isset($_POST["submit"]) && !empty($_POST["submit"]))
                {
                    //Si le formulaire est soumis on recupere les donnees dans des variables
                    $userLastName = $_POST["userLastname"];
                    $userFirstName = $_POST["userFirstname"];
                    $userSexe = $_POST["userSexe"];
                    $userPhone = $_POST["userPhone"];
                    $userMail = $_POST["userMail"];
                    $userBirthDate = $_POST["userBirthDate"];

                    /******** image */
                    $nameFile = $_FILES['fileImg']['name'];
                    $tmpFile = $_FILES['fileImg']['tmp_name'];
                    $typeFile = explode(".", $nameFile)[1];
            
                
                    $extension = pathinfo($nameFile, PATHINFO_EXTENSION);
                
                    $imageName = $userFirstName . "." . $extension;
                
                    $dossierDestination = "uploads/";
                
                    $cheminFichier = $dossierDestination . $imageName;
                
                    $correct = array("png", "jpg");
                

                    //Verifying the unique email

                    $verify_query = mysqli_query($con, "SELECT Email From users WHERE Email='$userMail'");

                    if(mysqli_num_rows($verify_query) != 0){
                        echo "<div class='message'>
                                <p>Cet email existe deja, essaie un autre</p>
                              </div><br>";

                        echo "<a href='javascript:self.history.back()'><button class='btn'>Retour</button>";
                    }
                    else{
    
                       
                        
                        //On enregistre l'image soumis dans le repertoire uploads
                        if(in_array($typeFile, $correct)){

                            if(move_uploaded_file($_FILES["fileImg"]["tmp_name"], $cheminFichier)){
                                mysqli_query($con, "INSERT INTO users(UserLastName, UserFirstName, Sexe, Phone, Email, BirthDate, ProfilImage) VALUES('$userLastName', '$userFirstName', '$userSexe', '$userPhone', '$userMail', '$userBirthDate','$imageName')") or die("Erreur !");
                                echo "<div class='good'>
                                <p>Enregistrement fait avec succes !</p>
                              </div><br>";

                                echo "<a href='index.php'><button class='btn'>Retour</button></a>";
                            }
                            else {
                                echo "error";
                            }
                            
                        }
                        else{
                            echo "Format de fichier incorrect";
                        }

                    }

                }
                else{

            ?>
            <!--Formulaire d'enregistrement' -->
            <header>Formulaire d'enregistrement <span>AJAJEP</span></header>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="field input">
                    <label for="userLastname">Nom*</label>
                    <input type="text" name="userLastname" id="userLastName" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="userLastname">Prénom*</label>
                    <input type="text" name="userFirstname" id="userFirstName" autocomplete="off" required>
                </div>

                <div class="field-radio">
                    <label for="userLastname">Sexe*<br></label>
                    <div class="radio-point">
                        <div class="el">
                            <input type="radio"   name="userSexe" id="userSexe" value="M" required> <span >M</span>
                        </div>

                        <div class="el">
                            <input type="radio"  name="userSexe" id="userSexe" value="F" required> <span >F</span>
                        </div>
                        
                    </div>
                </div>

                <div class="field input">
                    <label for="userPhone">Téléphone*</label>
                    <input type="number" name="userPhone" id="userPhone" id="numero" min="0" max="99999999" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="userMail">Email*</label>
                    <input type="email" name="userMail" id="userMail" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="userBirthDate">Date de naissance*</label>
                    <input type="date" name="userBirthDate" id="userBirthDate" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="fileImg">Charger une image*</label>
                    <input type="file" name="fileImg" id="fileImg" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="enregistrer">
                </div>

            
            </form>
        </div>
        <?php } ?>
    </div>
</body>
</html>