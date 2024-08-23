<?php
// Start session and check for existing session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Session handling
if (isset($_SESSION["user"])) {
    if ($_SESSION["user"] == "" || $_SESSION['usertype'] != 'p') {
        header("location: ../login.php");
        exit(); // Ensure script stops after redirection
    } else {
        $useremail = $_SESSION["user"];
    }
} else {
    header("location: ../login.php");
    exit(); // Ensure script stops after redirection
}

// Import database connection
include("../connection.php");

// Prepare and execute query
$sqlmain = "SELECT * FROM patient WHERE pemail=?";
$stmt = $database->prepare($sqlmain);
$stmt->bind_param("s", $useremail);
$stmt->execute();
$userrow = $stmt->get_result();
$userfetch = $userrow->fetch_assoc();
$userid = $userfetch["pid"];
$username = $userfetch["pname"];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="icon" href="../img/favicon.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.min.css">
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
        <div class="dash-body" style="margin-top: -18px">
            <table border="0" width="100%" style="border-spacing: 1;margin:0;padding:0;">
                <tr>
                    <td colspan="1" class="nav-bar">
                        <p style="font-size: 23px;padding-left:70px;font-weight: 650;margin-left:80px;">Accueil</p>
                    </td>
                    <p class="heading-sub12" style="padding: 0;margin: -0;">
                        <?php 
                        date_default_timezone_set('Africa/Algiers');
                        $today = date('Y-m-d');
                        echo $today;
                        $patientrow = $database->query("select * from patient;");
                        $doctorrow = $database->query("select * from doctor;");
                        $appointmentrow = $database->query("select * from appointment where appodate>='$today';");
                        $schedulerow = $database->query("select * from schedule where scheduledate='$today';");
                        ?>
                    </p>
                </tr>
                <tr>
                <style>
  .status-table {
    width: 100%;
    max-width: 800px;
    margin: auto;
    border-collapse: collapse;
    margin-left: 45px; /* Move the table slightly to the right */
  }

  .status-header {
    font-size: 20px;
    font-weight: 600;
    padding: 10px 0;
    text-align: center;
  }

  .dashboard-row {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    padding: 10px;
    margin-left: 20px; /* Move the 4 cards slightly to the right */
  }

  .dashboard-item {
    flex: 1 1 45%;
    padding: 20px;
    margin: 10px;
    background-color: #f5f5f5; /* Default color of the cards */
    text-align: center;
    border-radius: 8px;
    transition: background-color 0.3s ease;
  }

  /* Customize the card colors */
  .dashboard-item:nth-child(1) {
    background-color: #00bd71; /* Color for the first card */
  }
  .dashboard-item:nth-child(2) {
    background-color: #00bd71; /* Color for the second card */
  }
  .dashboard-item:nth-child(3) {
    background-color: #00bd71; /* Color for the third card */
  }
  .dashboard-item:nth-child(4) {
    background-color: #00bd71; /* Color for the fourth card */
  }

  .h1-dashboard {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 10px;
  }

  .h3-dashboard {
    font-size: 16px;
    font-weight: normal;
  }

  @media (max-width: 768px) {
    .dashboard-item {
      flex: 1 1 100%;
    }
    .h1-dashboard {
      font-size: 20px;
    }
    .h3-dashboard {
      font-size: 14px;
    }
  }
</style>

<table class="status-table">
  <tr>
    <td colspan="4">
      <p class="status-header">Statut</p>
    </td>
  </tr>
  <tr>
    <td colspan="4">
      <div class="dashboard-row">
        <div class="dashboard-item">
          <div class="h1-dashboard"><?php echo $doctorrow->num_rows ?></div>
          <div class="h3-dashboard">Tous les médecins</div>
        </div>
        <div class="dashboard-item">
          <div class="h1-dashboard"><?php echo $patientrow->num_rows ?></div>
          <div class="h3-dashboard">Tous les patients</div>
        </div>
        <div class="dashboard-item">
          <div class="h1-dashboard"><?php echo $appointmentrow->num_rows ?></div>
          <div class="h3-dashboard">Nouvelle réservation</div>
        </div>
        <div class="dashboard-item">
          <div class="h1-dashboard"><?php echo $schedulerow->num_rows ?></div>
          <div class="h3-dashboard">Séances d'aujourd'hui</div>
        </div>
      </div>
    </td>
  </tr>
</table>

            <style>
        .scroll {
    overflow-x: auto; /* Enables horizontal scrolling on small screens */
    margin: 0 auto; /* Center horizontally */
    padding: 0; /* Remove default padding */
    margin-left: 57px; /* Add space to the right */
}

.abc {
    margin-right: 0.1px; /* Adjust as needed to move the table to the right */
}

        .sub-table {
            width: 100%; /* Full width for larger screens */
            border-collapse: collapse; /* Removes space between borders */
            margin: 0 auto; /* Center horizontally */
        }

        .table-headin {
            background-color: #f4f4f4; /* Background color for headers */
            padding: 12px; /* Padding inside headers */
            font-size: 16px; /* Font size for headers */
            text-align: left; /* Aligns text to the left */
        }

        td, th {
            padding: 18px; /* Padding inside cells */
            text-align: left; /* Aligns text to the left */ 
        }

        .anime {
            font-size: 18px; /* Default font size */
            font-weight: 600; /* Font weight */
            padding-left: 4px; /* Padding on the left */
            text-align: center; /* Center text */
            margin-bottom: 10px; /* Margin below the title */
        }

        /* Media Query for tablets and larger devices */
        @media (min-width: 768px) {
            .table-headin {
                font-size: 12px; /* Larger font size for larger screens */
            }

            td, th {
                font-size: 16px; /* Larger font size for larger screens */
                padding: 12px; /* Larger padding for larger screens */
            }

            .anime {
                font-size: 22px; /* Larger font size for larger screens */
            }
        }

        /* Media Query for mobile devices */
        @media (max-width: 767px) {
            .table-headin {
                font-size: 14px; /* Smaller font size for mobile screens */
                padding: 5px; /* Smaller padding for mobile screens */
            }

            td, th {
                font-size: 12px; /* Smaller font size for mobile screens */
                padding: 6px; /* Smaller padding for mobile screens */
            }

            .anime {
                font-size: 16px; /* Smaller font size for mobile screens */
                padding-left: 0; /* Remove left padding */
                margin-bottom: 5px; /* Adjust margin below the title */
            }

            .scroll {
                height: auto; /* Adjust height for mobile */
                overflow-x: auto; /* Enable horizontal scrolling */
            }
        }
    </style>
    <table>
        <tr>
            <td>
                <p class="anime">Votre prochaine réservation</p>
                <div class="abc scroll">
                    <table class="sub-table" border="0">
                        <thead>
                            <tr>
                                <th class="table-headin">Rendez-vous numéro</th>
                                <th class="table-headin">Titre de la session</th>
                                <th class="table-headin">Médecin</th>
                                <th class="table-headin">Date et heure prévues</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nextweek = date("Y-m-d", strtotime("+1 week"));
                            $sqlmain = "SELECT * FROM schedule 
                                        INNER JOIN appointment ON schedule.scheduleid = appointment.scheduleid 
                                        INNER JOIN patient ON patient.pid = appointment.pid 
                                        INNER JOIN doctor ON schedule.docid = doctor.docid  
                                        WHERE patient.pid = $userid AND schedule.scheduledate >= '$today' 
                                        ORDER BY schedule.scheduledate ASC";
                            $result = $database->query($sqlmain);
                            if ($result->num_rows == 0) {
                                echo '<tr>
                                    <td colspan="4">
                                        <center>
                                            <img src="../img/notfound.svg" width="25%">
                                            <p class="heading-main12">Rien à montrer ici !</p>
                                            <a class="non-style-link" href="schedule.php">
                                                <button class="login-btn btn-primary-soft btn">Canalisez un docteur</button>
                                            </a>
                                        </center>
                                    </td>
                                </tr>';
                            } else {
                                for ($x = 0; $x < $result->num_rows; $x++) {
                                    $row = $result->fetch_assoc();
                                    $scheduleid = $row["scheduleid"];
                                    $title = $row["title"];
                                    $apponum = $row["apponum"];
                                    $docname = $row["docname"];
                                    $scheduledate = $row["scheduledate"];
                                    $scheduletime = $row["scheduletime"];
                                    echo '<tr>
                                        <td>' . $apponum . '</td>
                                        <td>' . substr($title, 0, 30) . '</td>
                                        <td>' . substr($docname, 0, 20) . '</td>
                                        <td>' . substr($scheduledate, 0, 10) . ' ' . substr($scheduletime, 0, 5) . '</td>
                                    </tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
    </table>
        </div>
    </div>
</body>
</html>
