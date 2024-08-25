<?php 

//learn from w3schools.com

session_start();

if(isset($_SESSION["user"])){
    if(($_SESSION["user"])=="" or $_SESSION['usertype']!='p'){
        header("location: ../login.php");
    }else{
        $useremail=$_SESSION["user"];
    }

}else{
    header("location: ../login.php");
}


//import database
include("../connection.php");
$userrow = $database->query("select * from patient where pemail='$useremail'");
$userfetch=$userrow->fetch_assoc();
$userid= $userfetch["pid"];
$username=$userfetch["pname"];

?>
   <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/animations.css">  
        <link rel="stylesheet" href="../css/main.css">  
        <link rel="stylesheet" href="../css/admin.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.min.css">
        <link rel="icon" href="../img/favicon.png" type="image/png">
        
        <title>Médecins</title>
        <style>
        .dashbord-tables {
            animation: transitionIn-Y-over 0.5s;
        }
        .filter-container {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table, .anime {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .fa-2x {
            font-size: 2em;
        }
        .fa {
            position: relative;
            display: table-cell;
            width: 60px;
            height: 74px; /* Added a value for height */
            text-align: center;
            vertical-align: middle;
            font-size: 20px;
        }
        .main-menu {
            background: #ffffff;
            border-right: 1px solid #e5e5e5;
            position: absolute;
            top: 0;
            bottom: 0;
            height: 100%;
            left: 0;
            width: 60px;
            overflow: hidden;
            -webkit-transition: width .05s linear;
            transition: width .05s linear;
            -webkit-transform: translateZ(0) scale(1, 1);
            z-index: 1000;
        }
        .main-menu:hover, nav.main-menu.expanded {
            width: 250px;
            overflow: visible;
        }
        .main-menu > ul {
            margin: 7px 0;
        }
        .main-menu li {
            position: relative;
            display: block;
            width: 250px;
        }
        .main-menu li > a {
            position: relative;
            display: table;
            border-collapse: collapse;
            border-spacing: 0;
            color: #000000;
            font-family: arial;
            font-size: 14px;
            text-decoration: none;
            -webkit-transform: translateZ(0) scale(1, 1);
            -webkit-transition: all .1s linear;
            transition: all .1s linear;
        }
        .main-menu .nav-icon {
            position: relative;
            display: table-cell;
            width: 60px;
            height: 36px;
            text-align: center;
            vertical-align: middle;
            font-size: 18px;
        }
        .main-menu .nav-text {
            position: relative;
            display: table-cell;
            vertical-align: middle;
            width: 190px;
            font-family: 'Titillium Web', sans-serif;
        }
        .main-menu > ul.logout {
            position: absolute;
            left: 0;
            bottom: 0;
        }
        .no-touch .scrollable.hover {
            overflow-y: hidden;
        }
        .no-touch .scrollable.hover:hover {
            overflow-y: auto;
            overflow: visible;
        }
        a:hover, a:focus {
            text-decoration: none;
        }
        nav {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            -o-user-select: none;
            user-select: none;
        }
        nav ul, nav li {
            outline: 0;
            margin: 0;
            padding: 0;
        }
        .main-menu li:hover > a, nav.main-menu li.active > a, .dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus, .dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus, .no-touch .dashboard-page nav.dashboard-menu ul li:hover a, .dashboard-page nav.dashboard-menu ul li.active a {
            color: #fff;
            background-color: #00bd71;
        }
        .area {
            float: left;
            background: #e2e2e2;
         .filter-container{
            display: block;
            position: absolute;
            left: 0;
            top: 30%;
        }
        @media(max-width: 768px) {
            .filter-container{
                /*display: block;*/
                position: relative;
                display: flex;
                flex-direction: column;
               
            }
            td .dashboard-items{
                position: relative;
                width: 20px;
                font-style: 10px;
                top:70%;
                left: 10%;
               
            }
        }     
        }
        @font-face {
            font-family: 'Titillium Web';
            font-style: normal;
            font-weight: 300;
            src: local('Titillium WebLight'), local('TitilliumWeb-Light'), url(http://themes.googleusercontent.com/static/fonts/titilliumweb/v2/anMUvcNT0H1YN4FII8wpr24bNCNEoFTpS2BTjF6FB5E.woff) format('woff');
        }

       
    </style>
    </head>
    <body>
        

        <div class="container">
        <nav class="main-menu">
            <ul>
                <li>
                    <a href="index.php">
                        <i class="fa fa-home fa-2x" style="color: #006950;"></i>
                        <span class="nav-text">Accueil</span>
                    </a>
                </li>
                <li class="has-subnav">
                    <a href="doctors.php">
                        <i class="fa fa-stethoscope fa-2x" style="color: #006950;"></i>
                        <span class="nav-text">Tous les médecins</span>
                    </a>
                </li>
                <li class="has-subnav">
                    <a href="schedule.php">
                    <i class="fa fa-list fa-2x" style="color:  #006950;"></i>
                        <span class="nav-text">Séances programmées</span>
                    </a>
                </li>
                <li class="has-subnav">
                    <a href="appointment.php">
                        <i class="fa fa-book fa-2x" style="color: #006950;"></i>
                        <span class="nav-text">Mes réservations</span>
                    </a>
                </li> 
            </ul>
            <ul class="logout">
                <li>
                    <a href="../logout.php">
                        <i class="fa fa-power-off fa-2x" style="color: #006950;"></i>
                        <span class="nav-text">Se déconnecter</span>
                    </a>
                </li>  
            </ul>
        </nav>
            <div class="dash-body">
                <table border="0" width="100%" style=" border-spacing: 70px;margin:0;padding:4px;margin-top:185px; ">
                    <?php
                        if($_POST){
                            $keyword=$_POST["search"];
                            
                            $sqlmain= "select * from doctor where docemail='$keyword' or docname='$keyword' or docname like '$keyword%' or docname like '%$keyword' or docname like '%$keyword%'";
                        }else{
                            $sqlmain= "select * from doctor order by docid desc";

                        }



                    ?>
                    
                    <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                            <table width="33%" class="sub-table scrolldown" border="0">
                            <thead>
                            <tr>
                                    <th class="table-headin">
                                        
                                    
                                    Nom du docteur
                                    
                                    </th>
                                    <th class="table-headin">
                                    Email
                                    </th>
                                    <th class="table-headin">
                                        
                                    Spécialités
                                        
                                    </th>
                                    <th class="table-headin">
                                        
                                    Événements
                                        
                                    </tr>
                            </thead>
                            <tbody>
                            
                                <?php

                                    
                                    $result= $database->query($sqlmain);

                                    if($result->num_rows==0){
                                        echo '<tr>
                                        <td colspan="4">
                                        <br><br><br><br>
                                        <center>
                                        <img src="../img/notfound.svg" width="25%">
                                        
                                        <br>
                                        <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">Nous n\'avons rien trouvé en rapport avec vos mots-clés!</p>
                                        <a class="non-style-link" href="doctors.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Afficher tous les médecins &nbsp;</font></button>
                                        </a>
                                        </center>
                                        <br><br><br><br>
                                        </td>
                                        </tr>';
                                        
                                    }
                                    else{
                                    for ( $x=0; $x<$result->num_rows;$x++){
                                        $row=$result->fetch_assoc();
                                        $docid=$row["docid"];
                                        $name=$row["docname"];
                                        $email=$row["docemail"];
                                        $spe=$row["specialties"];
                                        $spcil_res= $database->query("select sname from specialties where id='$spe'");
                                        $spcil_array= $spcil_res->fetch_assoc();
                                        $spcil_name=$spcil_array["sname"];
                                        echo '<tr>
                                            <td> &nbsp;'.
                                            substr($name,0,30)
                                            .'</td>
                                            <td>
                                            '.substr($email,0,20).'
                                            </td>
                                            <td>
                                                '.substr($spcil_name,0,20).'
                                            </td>

                                            <td>
                                            <div style="display:flex;justify-content: center;">
                                            
                                            <a href="?action=view&id='.$docid.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Voir</font></button></a>
                                        &nbsp;&nbsp;&nbsp;
                                        <a href="?action=session&id='.$docid.'&name='.$name.'"  class="non-style-link"><button  class="btn-primary-soft btn button-icon menu-icon-session-active"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Séances</font></button></a>
                                            </div>
                                            </td>
                                        </tr>';
                                        
                                    }
                                }
                                    
                                ?>
    
                                </tbody>

                            </table>
                            </div>
                            </center>
                    </td> 
                    </tr>
                        
                            
                            
                </table>
            </div>
            
        </div>
        <?php 
        
    $action = isset($_GET['action']) ? $_GET['action'] : '';
                                        
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
        } else {
            $action = ''; // or any default value
        }    
        if($_GET){
            
            $id=$_GET["id"];
            $action=$_GET["action"];
            if($action=='drop'){
                $nameget=$_GET["name"];
                echo '
                <div id="popup1" class="overlay">
                        <div class="popup">
                        <center>
                            <h2>Are you sure?</h2>
                            <a class="close" href="doctors.php">&times;</a>
                            <div class="content">
                            Vous souhaitez supprimer cet enregistrement <br>('.substr($nameget,0,40).').
                                
                            </div>
                            <div style="display: flex;justify-content: center;">
                            <a href="delete-doctor.php?id='.$id.'" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Oui&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                            <a href="doctors.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;Non&nbsp;&nbsp;</font></button></a>

                            </div>
                        </center>
                </div>
                </div>
                ';
            }elseif($action=='view'){
                $sqlmain = "SELECT * FROM doctor WHERE docid=?";
                $stmt = $database->prepare($sqlmain);
                $stmt->bind_param("i",$id);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                $name=$row["docname"];
                $email=$row["docemail"];
                $spe=$row["specialties"];
                
                $stmt = $database->prepare("select sname from specialties where id=?");
                $stmt->bind_param("s",$spe);
                $stmt->execute();
                $spcil_res = $stmt->get_result();
                $spcil_array= $spcil_res->fetch_assoc();
                $spcil_name=$spcil_array["sname"];
                $nic=$row['docnic'];
                $tele=$row['doctel'];
                echo '
                <div id="popup1" class="overlay">
                        <div class="popup">
                        <center>
                            <h2></h2>
                            <a class="close" href="doctors.php">&times;</a>
                            <div class="content">
                                <br>
                                
                            </div>
                            <div style="display: flex;justify-content: center;">
                            <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                            
                                <tr>
                                    <td>
                                        <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Voir les détails.</p><br><br>
                                    </td>
                                </tr>
                                
                                <tr>
                                    
                                    <td class="label-td" colspan="2">
                                        <label for="name" class="form-label">Nom: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        '.$name.'<br><br>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="Email" class="form-label">Email: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                    '.$email.'<br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="nic" class="form-label">Numero de carte d\'identification nationale: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                    '.$nic.'<br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="Tele" class="form-label">Telephone: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                    '.$tele.'<br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="spec" class="form-label">Spécialités: </label>
                                        
                                    </td>
                                </tr>
                                <tr>
                                <td class="label-td" colspan="2">
                                '.$spcil_name.'<br><br>
                                </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <a href="doctors.php"><input type="button" value="Accepter" class="login-btn btn-primary-soft btn" ></a>
                                    
                                        
                                    </td>
                    
                                </tr>
                            

                            </table>
                            </div>
                        </center>
                        <br><br>
                </div>
                </div>
                ';
            }elseif($action=='session'){
                $name=$_GET["name"];
                echo '
                <div id="popup1" class="overlay">
                        <div class="popup">
                        <center>
                            <h2>Redirection vers les séances avec les médecins ?</h2>
                            <a class="close" href="doctors.php">&times;</a>
                            <div class="content">
                            Vous souhaitez voir toutes les sessions par<br>('.substr($name,0,40).').
                                
                            </div>
                            <form action="schedule.php" method="post" style="display: flex">

                                    <input type="hidden" name="search" value="'.$name.'">

                                    
                            <div style="display: flex;justify-content:center;margin-left:45%;margin-top:6%;;margin-bottom:6%;">
                            
                            <input type="submit"  value="Oui" class="btn-primary btn"   >
                            
                            
                            </div>
                        </center>
                </div>
                </div>
                ';
            }
            }elseif($action=='edit'){
                $sqlmain= "select * from doctor where docid=?";
                $stmt = $database->prepare($sqlmain);
                $stmt->bind_param("i",$id);
                $stmt->execute();
                $result = $stmt->get_result();
                $row=$result->fetch_assoc();
        
                $name=$row["docname"];
                $email=$row["docemail"];
                $spe=$row["specialties"];
                
                $sqlmain= "select sname from specialties where id='?";
                $stmt = $database->prepare($sqlmain);
                $stmt->bind_param("s",$spe);
                $stmt->execute();
                $result = $stmt->get_result();

                $spcil_array= $spcil_res->fetch_assoc();
                $spcil_name=$spcil_array["sname"];
                $nic=$row['docnic'];
                $tele=$row['doctel'];

                $error_1=$_GET["error"];
                    $errorlist= array(
                        '1'=>'<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Vous avez déjà un compte pour cette adresse e-mail.</label>',
                        '2'=>'<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Erreur de confirmation du mot de passe ! Reconfirmer le mot de passe</label>',
                        '3'=>'<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>',
                        '4'=>"",
                        '0'=>'',

                    );

                if($error_1!='4'){
                        echo '
                        <div id="popup1" class="overlay">
                                <div class="popup">
                                <center>
                                
                                    <a class="close" href="doctors.php">&times;</a> 
                                    <div style="display: flex;justify-content: center;">
                                    <div class="abc">
                                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                    <tr>
                                            <td class="label-td" colspan="2">'.
                                                $errorlist[$error_1]
                                            .'</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Modifier les détails du médecin.</p>
                                            Doctor ID : '.$id.' (Généré automatiquement)<br><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <form action="edit-doc.php" method="POST" class="add-new-form">
                                                <label for="Email" class="form-label">Email: </label>
                                                <input type="hidden" value="'.$id.'" name="id00">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                            <input type="email" name="email" class="input-text" placeholder="Adresse email" value="'.$email.'" required><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            
                                            <td class="label-td" colspan="2">
                                                <label for="name" class="form-label">Name: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="text" name="name" class="input-text" placeholder="Nom du docteur" value="'.$name.'" required><br>
                                            </td>
                                            
                                        </tr>
                                        
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="nic" class="form-label">Numero de carte d\'identification nationale:: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="text" name="nic" class="input-text" placeholder="Numero de carte d\'identification nationale:" value="'.$nic.'" required><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="Tele" class="form-label">Telephone: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="tel" name="Tele" class="input-text" placeholder="Numéro de téléphone" value="'.$tele.'" required><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="spec" class="form-label">Choisir des spécialités: (Current'.$spcil_name.')</label>
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <select name="spec" id="" class="box">';
                                                    
                    
                                                    $list11 = $database->query("select  * from  specialties;");
                    
                                                    for ($y=0;$y<$list11->num_rows;$y++){
                                                        $row00=$list11->fetch_assoc();
                                                        $sn=$row00["sname"];
                                                        $id00=$row00["id"];
                                                        echo "<option value=".$id00.">$sn</option><br/>";
                                                    };
                    
                    
                    
                                                    
                                    echo     '       </select><br><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <label for="password" class="form-label">Mot de passe: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="password" name="password" class="input-text" placeholder="Définir un mot de passe" required><br>
                                            </td>
                                        </tr><tr>
                                            <td class="label-td" colspan="2">
                                                <label for="cpassword" class="form-label">Confirmez le mot de passe: </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="label-td" colspan="2">
                                                <input type="password" name="cpassword" class="input-text" placeholder="Confirmez le mot de passe" required><br>
                                            </td>
                                        </tr>
                                        
                            
                                        <tr>
                                            <td colspan="2"> 
                                                <input type="submit" value="Sauvegarder" class="login-btn btn-primary btn">
                                            </td>
                            
                                        </tr>
                                    
                                        </form>
                                        </tr>
                                    </table>
                                    </div>
                                    </div>
                                </center>
                                <br><br>
                        </div>
                        </div>
                        ';
            }else{
                echo '
                    <div id="popup1" class="overlay">
                            <div class="popup">
                            <center>
                            <br><br><br><br>
                                <h2>Modifier avec succès!</h2>
                                <a class="close" href="doctors.php">&times;</a>
                                <div class="content">
                                    
                                    
                                </div>
                                <div style="display: flex;justify-content: center;">
                                
                                <a href="doctors.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;Accepter&nbsp;&nbsp;</font></button></a>

                                </div>
                                <br><br>
                            </center>
                    </div>
                    </div>
        ';



            }; 
        };

    ?>
    </div>

    </body>
    </html>