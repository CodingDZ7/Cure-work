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

//$sqlmain= "select * from patient where pemail=?";
//$stmt = $database->prepare($sqlmain);
//$stmt->bind_param("s",$useremail);
//$stmt->execute();
//$result = $stmt->get_result();
//$userfetch=$userrow->fetch_assoc();
//$userid= $userfetch["pid"];
//$username=$userfetch["pname"];
$sqlmain = "SELECT * FROM patient WHERE pemail=?";
$stmt = $database->prepare($sqlmain);
$stmt->bind_param("s", $useremail);
$stmt->execute();
$result = $stmt->get_result();  // Use $result to fetch data

if ($result->num_rows > 0) {
$userfetch = $result->fetch_assoc();
$userid = $userfetch["pid"];
$username = $userfetch["pname"];
} else {
die('Aucun utilisateur trouvé avec cet email.');
}




//echo $userid;
//echo $username;



date_default_timezone_set('Africa/Algiers');

$today = date('Y-m-d');


//echo $userid;
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
        
    <title>Réserver</title>
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
            width: 100%;
            height: 100%;
        }
        @font-face {
            font-family: 'Titillium Web';
            font-style: normal;
            font-weight: 300;
            src: local('Titillium WebLight'), local('TitilliumWeb-Light'), url(http://themes.googleusercontent.com/static/fonts/titilliumweb/v2/anMUvcNT0H1YN4FII8wpr24bNCNEoFTpS2BTjF6FB5E.woff) format('woff');
        }

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
        }
    </style>
</head>
<body>
   
 <div class="container">
     <div class="menu">
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
                <li>
                    <a href="settings.php">
                        <i class="fa fa-gear fa-2x" style="color: #006950;"></i>
                        <span class="nav-text">Paramètres</span>
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
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
              
                <tr>
                   <td colspan="4">
                       <center>
                        <div class="abc scroll">
                        <table width="150%" class="sub-table scrolldown" border="0" style="padding: 100px;border:none">
                            
                        <tbody>
                        
                            <?php
                            
                            if(($_GET)){
                                
                                
                                if(isset($_GET["id"])){
                                    

                                    $id=$_GET["id"];

                                    $sqlmain= "select * from schedule inner join doctor on schedule.docid=doctor.docid where schedule.scheduleid=? order by schedule.scheduledate desc";
                                    $stmt = $database->prepare($sqlmain);
                                    $stmt->bind_param("i", $id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    //echo $sqlmain;
                                    $row=$result->fetch_assoc();
                                    $scheduleid=$row["scheduleid"];
                                    $title=$row["title"];
                                    $docname=$row["docname"];
                                    $docemail=$row["docemail"];
                                    $scheduledate=$row["scheduledate"];
                                    $scheduletime=$row["scheduletime"];
                                    $sql2="select * from appointment where scheduleid=$id";
                                    //echo $sql2;
                                     $result12= $database->query($sql2);
                                     $apponum=($result12->num_rows)+1;
                                    
                                    echo '
                                        <form action="booking-complete.php" method="post">
                                            <input type="hidden" name="scheduleid" value="'.$scheduleid.'" >
                                            <input type="hidden" name="apponum" value="'.$apponum.'" >
                                            <input type="hidden" name="date" value="'.$today.'" >

                                        
                                    
                                    ';
                                     

                                    echo '
                                    <td style="width: 50%;" rowspan="2">
                                            <div  class="dashboard-items search-items"  >
                                            
                                                <div style="width:100%">
                                                        <div class="h1-search" style="font-size:25px;">
                                                           Détails de la séance
                                                        </div><br><br>
                                                        <div class="h3-search" style="font-size:18px;line-height:30px">
                                                            Nom du docteur : &nbsp;&nbsp;<b>'.$docname.'</b><br>
                                                            Docteur E-mail:  &nbsp;&nbsp;<b>'.$docemail.'</b> 
                                                        </div>
                                                        <div class="h3-search" style="font-size:18px;">
                                                          
                                                        </div><br>
                                                        <div class="h3-search" style="font-size:18px;">
                                                            Titre de la séance : '.$title.'<br>
                                                            Date prévue de la session :'.$scheduledate.'<br>
                                                            Début de la session :'.$scheduletime.'<br>
                                                            Frais de canalisation : <b>.2 000.00</b>

                                                        </div>
                                                        <br>
                                                        
                                                </div>
                                                        
                                            </div>
                                        </td>
                                        
                                        
                                        
                                        <td style="width: 25%;">
                                            <div  class="dashboard-items search-items"  >
                                            
                                                <div style="width:100%;padding-top: 15px;padding-bottom: 15px;">
                                                        <div class="h1-search" style="font-size:20px;line-height: 35px;margin-left:8px;text-align:center;">
                                                            Votre numéro de rendez-vous
                                                        </div>
                                                        <center>
                                                        <div class=" dashboard-icons" style="margin-left: 0px;width:90%;font-size:70px;font-weight:800;text-align:center;color:var(--btnnictext);background-color: var(--btnice)">'.$apponum.'</div>
                                                    </center>
                                                       
                                                        </div><br>
                                                        
                                                        <br>
                                                        <br>
                                                </div>
                                                        
                                            </div>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="Submit" class="login-btn btn-primary btn btn-book" style="margin-left:10px;padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;width:95%;text-align: center;" value="Réservez maintenant" name="booknow"></button>
                                            </form>
                                            </td>
                                        </tr>
                                        '; 
                                        




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
    
    
   
    </div>

</body>
</html>