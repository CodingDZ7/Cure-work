<?php


session_start();

if(isset($_SESSION["user"])){
    if(($_SESSION["user"])=="" or $_SESSION['usertype']!='d'){
        header("location: ../login.php");
    }else{
        $useremail=$_SESSION["user"];
    }

}else{
    header("location: ../login.php");
}


//import database
include("../connection.php");
$userrow = $database->query("select * from doctor where docemail='$useremail'");
$userfetch=$userrow->fetch_assoc();
$userid= $userfetch["docid"];
$username=$userfetch["docname"];


//echo $userid;
//echo $username;

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
            
        <title>Tableau de bord</title>
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
            </div>
            <div class="dash-body" style="margin-top: 15px">
                <table border="0" width="100%"   >
                            
                            <tr>
                                
                                <td colspan="1" class="nav-bar" >
                                <p style="font-size: 25px;padding-left:12px;font-weight: 600;margin-left:20px;">Tableau de bord</p>

                                </td>
                                <td width="25%">

                                </td>
                                <td width="15%">
                                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                                        Date d'aujourd'hui
                                    </p>
                                    <p class="heading-sub12" style="padding: 0;margin: 0;">
                                        <?php 
                                    date_default_timezone_set('Africa/Algiers');
            
                                    $today = date('Y-m-d');
                                    echo $today;


                                    $patientrow = $database->query("select  * from  patient;");
                                    $doctorrow = $database->query("select  * from  doctor;");
                                    $appointmentrow = $database->query("select  * from  appointment where appodate>='$today';");
                                    $schedulerow = $database->query("select  * from  schedule where scheduledate='$today';");


                                    ?>
                                    </p>
                                </td>
                             
            
                            </tr>
                    <tr>
                        <td colspan="4" >
                        
                    </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <table border="0" width="100%">
                                <tr>
                                    <td width="50%">

                                        




                                        <center>
                                            <table class="filter-container" style="border: none;" border="0">
                                                <tr>
                                                    <td colspan="4">
                                                        <p style="font-size: 25px;font-weight:600;padding-left: 12px;">Statut</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 10%;">
                                                        <div  class="dashboard-items"  style="padding:20px;margin:auto;width:95%;display: flex">
                                                            <div>
                                                                    <div class="h1-dashboard">
                                                                        <?php    echo $doctorrow->num_rows  ?>
                                                                    </div><br>
                                                                    <div class="h3-dashboard">
                                                                        Tous les médecins &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    </div>
                                                            </div>
                                                                    <div class="btn-icon-back dashboard-icons" style="background-image: url('../img/icons/doctors-hover.svg');"></div>
                                                        </div>
                                                    </td>
                                                    <td style="width: 10%;">
                                                        <div  class="dashboard-items"  style="padding:20px;margin:auto;width:95%;display: flex;">
                                                            <div>
                                                                    <div class="h1-dashboard">
                                                                        <?php    echo $patientrow->num_rows  ?>
                                                                    </div><br>
                                                                    <div class="h3-dashboard">
                                                                        Tous les Patients &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    </div>
                                                            </div>
                                                                    <div class="btn-icon-back dashboard-icons" style="background-image: url('../img/icons/patients-hover.svg');"></div>
                                                        </div>
                                                    </td>
                                                    </tr>
                                                    <tr>
                                                    <td style="width: 10%;">
                                                        <div  class="dashboard-items"  style="padding:20px;margin:auto;width:100%;display: flex; ">
                                                            <div>
                                                                    <div class="h1-dashboard" >
                                                                        <?php    echo $appointmentrow ->num_rows  ?>
                                                                    </div><br>
                                                                    <div class="h3-dashboard" >
                                                                        Nouveau Réservation &nbsp;&nbsp;
                                                                    </div>
                                                            </div>
                                                                    <div class="btn-icon-back dashboard-icons" style="margin-left: 0px;background-image: url('../img/icons/book-hover.svg');"></div>
                                                        </div>
                                                        
                                                    </td>

                                                    <td style="width: 10%;">
                                                        <div  class="dashboard-items"  style="padding:20px;margin:auto;width:95%;display: flex;padding-top:21px;padding-bottom:21px;">
                                                            <div>
                                                                    <div class="h1-dashboard">
                                                                        <?php    echo $schedulerow ->num_rows  ?>
                                                                    </div><br>
                                                                    <div class="h3-dashboard" style="font-size: 25px">
                                                                        Tous les sèances
                                                                    </div>
                                                            </div>
                                                                    <div class="btn-icon-back dashboard-icons" style="background-image: url('../img/icons/session-iceblue.svg');"></div>
                                                        </div>
                                                    </td>
                                                    
                                                </tr>
                                            </table>
                                        </center>


                                    </td>
                                   
                                            </div>
                                            </center>







                                    </td>
                                </tr>
                            </table>
                        </td>
                    <tr>
                </table>
            </div>
        </div>


    </body>
    </html>
