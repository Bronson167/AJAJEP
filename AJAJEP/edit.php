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
    <title>Modifier une information</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <img src="image/AJAJEP.jpg">
        </div>

        <div class="right-links">
            <a href="edit.php">Modifier une information</a>
            <a href="php/logout.php"><button class="btn">Quitter</button></a>
        </div>
    </div>

    <div class="container">
        <div class="box form-box">
            
            <?php
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
                

                    //Mise a jours des informations dans la base de donnees
                    $id = $_SESSION["id"];

                    $edit_query = mysqli_query($con, "UPDATE users SET UserLastName ='$userLastName', UserFirstName ='$userFirstName', Sexe ='$userSexe', Phone ='$userPhone', Email ='$userMail', BirthDate ='$userBirthDate', ProfilImage ='$imageName' WHERE Id = $id") or die("Une erreur s'est produite");
                    
                    if($edit_query){

                        //si le mise a jour dans la base de donnees s'est bien deroule, on nregistre l'image dans le repertoire uploads
                        if(in_array($typeFile, $correct)){
                            if(move_uploaded_file($_FILES["fileImg"]["tmp_name"], $cheminFichier)){
                                //echo "uploaded";
                            }
                            else {
                                echo "error";
                            }
                            
                        }
                        else{
                            echo "Format de fichier incorrect";
                        }

                        //Affiche le message 
                        echo "<div class='good'>
                                <p>Modification faite avec succes !</p>
                              </div><br>";

                        echo "<a href='home.php'><button class='btn'>Afficher</button>";
                    }
                }
                else{
                    //Sinon on saisie les donnees dans la base
                    $id = $_SESSION['id'];
                    $query = mysqli_query($con, "SELECT*FROM users WHERE Id=$id");

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
    
            ?>

            <!--Formulaire de mise a jour -->
            <header>Modifier informations</header>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="field input">
                    <label for="userLastname">Nom*</label>
                    <input type="text" name="userLastname" value="<?php echo $res_ULastName; ?>" id="userLastName" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="userLastname">Prénom*</label>
                    <input type="text" name="userFirstname" value="<?php echo $res_UFirstName; ?>" id="userFirstName" autocomplete="off" required>
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
                    <input type="number" name="userPhone" value="<?php echo $res_UPhone; ?>" id="userPhone" maxlength="8" pattern="\d{1,8}" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="userMail">Email*</label>
                    <input type="email" name="userMail" value="<?php echo $res_UEmail; ?>" id="userMail" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="userBirthDate">Date de naissance*</label>
                    <input type="date" name="userBirthDate" value="<?php echo $res_UBirthDate ?>" id="userBirthDate" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="fileImg">Charger une image*</label>
                    <input type="file" name="fileImg" id="fileImg" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="modifier">
                </div>

            
            </form>
        </div>
        <?php } ?>
    </div>
</body>
</html>