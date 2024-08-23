<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/signup.css">
    <link rel="icon" href="./img/favicon.png" type="image/png">
    <title>S'inscrire</title>
</head>
<body>
<?php
session_start();
$_SESSION["user"] = "";
$_SESSION["usertype"] = "";
date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d');
$_SESSION["date"] = $date;

if ($_POST) {
    $_SESSION["personal"] = array(
        'fname' => $_POST['fname'],
        'lname' => $_POST['lname'],
        'address' => $_POST['address'],
        'nic' => $_POST['nic'],
        'dob' => $_POST['dob']
    );

    print_r($_SESSION["personal"]);
    header("location: create-account.php");
}
?>

<center>
    <div class="container">
        <form action="" method="POST">
            <table border="0">
                <tr>
                    <td colspan="2">
                        <p class="header-text">Allons-y</p>
                        <p class="sub-text">Ajoutez vos informations personnelles pour continuer</p>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="name" class="form-label">Nom: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td">
                        <input type="text" name="fname" class="input-text" placeholder="Prénom" required>
                    </td>
                    <td class="label-td">
                        <input type="text" name="lname" class="input-text" placeholder="Nom de famille" required>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="address" class="form-label">Adresse: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="text" name="address" class="input-text" placeholder="où habites-tu Adresse" required>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="nic" class="form-label">Numero de carte d'identification nationale:</label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="text" name="nic" class="input-text" placeholder="Numero de carte d'identification nationale:" required>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="dob" class="form-label">Date de naissance: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="date" name="dob" class="input-text" required>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" value="Suivant" class="login-btn btn-primary btn">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <br>
                        <label for="" class="sub-text" style="font-weight: 280;">Vous avez déjà un compte&#63; </label>
                        <a href="login.php" class="hover-link1 non-style-link">Se connecter</a>
                        <br><br><br>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</center>
</body>
</html>
