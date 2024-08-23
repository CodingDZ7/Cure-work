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
$sqlmain= "select * from patient where pemail=?";
$stmt = $database->prepare($sqlmain);
$stmt->bind_param("s",$useremail);
$stmt->execute();
$userrow = $stmt->get_result();
$userfetch=$userrow->fetch_assoc();
$userid= $userfetch["pid"];
$username=$userfetch["pname"];


//echo $userid;
//echo $username;


//TODO
$sqlmain= "select appointment.appoid,schedule.scheduleid,schedule.title,doctor.docname,patient.pname,schedule.scheduledate,schedule.scheduletime,appointment.apponum,appointment.appodate from schedule inner join appointment on schedule.scheduleid=appointment.scheduleid inner join patient on patient.pid=appointment.pid inner join doctor on schedule.docid=doctor.docid  where  patient.pid=$userid ";

if($_POST){
    //print_r($_POST);
    


    
    if(!empty($_POST["sheduledate"])){
        $sheduledate=$_POST["sheduledate"];
        $sqlmain.=" and schedule.scheduledate='$sheduledate' ";
    };



    //echo $sqlmain;

}

$sqlmain.="order by appointment.appodate  asc";
$result= $database->query($sqlmain);
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
        
    <title>Rendez-vous</title>
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
            position: relative;
            left: 10px;
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
                left: 90%;
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
        </div>
        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding: 10px;0;margin-top:25px; ">
                <tr >
                    <td>
                        <p style="font-size: 23px;padding-left:45px;font-weight: 600;">Mon historique de réservations</p>
                                           
                    </td>
                    <td width="17%">
                      
                    </td>


                </tr>
               
                <!-- <tr>
                    <td colspan="4" >
                        <div style="display: flex;margin-top: 40px;">
                        <div class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49);margin-top: 5px;">Schedule a Session</div>
                        <a href="?action=add-session&id=none&error=0" class="non-style-link"><button  class="login-btn btn-primary btn button-icon"  style="margin-left:25px;background-image: url('../img/icons/add.svg');">Add a Session</font></button>
                        </a>
                        </div>
                    </td>
                </tr>  
                <tr>
                    <td colspan="4" style="padding-top:10px;width: 100%;" >
                    
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">Mes réservations (<?php echo $result->num_rows; ?>)</p>
                    </td>
                    
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:0px;width: 100%;" >
                        <center>
                        <table class="filter-container" border="0" >
                        <tr>
                           <td width="10%">

                           </td> 
                        <td width="5%" style="text-align: center;">
                        Date:
                        </td>
                        <td width="30%">
                        <form action="" method="post">
                            
                            <input type="date" name="sheduledate" id="date" class="input-text filter-container-items" style="margin: 0;width: 95%;">

                        </td>
                        
                    <td width="12%">
                        <input type="submit"  name="filter" value=" Filtrer" class=" btn-primary-soft btn button-icon btn-filter"  style="padding: 15px; margin :0;width:100%">
                        </form>
                    </td>

                    </tr>
                            </table>

                        </center>
                    </td>
                    
                </tr>
                
               
                  -->
                <tr>
                   <td colspan="4">
                       <center>
                        <div class="abc scroll">
                        <table width="93%" class="sub-table scrolldown" border="0" style="border:none">
                        
                        <tbody>
                        
                            <?php

                                
                                

                                if($result->num_rows==0){
                                    echo '<tr>
                                    <td colspan="7">
                                    <br><br><br><br>
                                    <center>
                                    <img src="../img/notfound.svg" width="25%">
                                    
                                    <br>
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">Nous n\'avons rien trouvé en rapport avec vos mots-clés !</p>
                                    <a class="non-style-link" href="appointment.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Afficher tous les rendez-vous &nbsp;</font></button>
                                    </a>
                                    </center>
                                    <br><br><br><br>
                                    </td>
                                    </tr>';
                                    
                                }
                                else{

                                    for ( $x=0; $x<($result->num_rows);$x++){
                                        echo "<tr>";
                                        for($q=0;$q<3;$q++){
                                            $row=$result->fetch_assoc();
                                            if (!isset($row)){
                                            break;
                                            };
                                            $scheduleid=$row["scheduleid"];
                                            $title=$row["title"];
                                            $docname=$row["docname"];
                                            $scheduledate=$row["scheduledate"];
                                            $scheduletime=$row["scheduletime"];
                                            $apponum=$row["apponum"];
                                            $appodate=$row["appodate"];
                                            $appoid=$row["appoid"];
    
                                            if($scheduleid==""){
                                                break;
                                            }
    
                                            echo '
                                            <td style="width: 25%; padding: left 20px;">
                                                    <div  class="dashboard-items search-items"  >
                                                    
                                                        <div style="width:150%;">
                                                        <div class="h3-search">
                                                                    Date de réservation : '.substr($appodate,0,30).'<br>
                                                                    Numéro de référence : OC-000-'.$appoid.'
                                                                </div>
                                                                <div class="h1-search">
                                                                    '.substr($title,0,21).'<br>
                                                                </div>
                                                                <div class="h3-search">
                                                                    Numéro de rendez-vous:<div class="h1-search">0'.$apponum.'</div>
                                                                </div>
                                                                <div class="h3-search">
                                                                    '.substr($docname,0,30).'
                                                                </div>
                                                                
                                                                
                                                                <div class="h4-search">
                                                                    Date prévue : '.$scheduledate.'<br>Debut: <b>@'.substr($scheduletime,0,5).'</b> (24h)
                                                                </div>
                                                                <br>
                                                                <a href="?action=drop&id='.$appoid.'&title='.$title.'&doc='.$docname.'" ><button  class="login-btn btn-primary-soft btn "  style="padding-top:11px;padding-bottom:11px;width:100%"><font class="tn-in-text">Annuler la réservation</font></button></a>
                                                        </div>
                                                                
                                                    </div>
                                                </td>';
    
                                        }
                                        echo "</tr>";
                           
                                // for ( $x=0; $x<$result->num_rows;$x++){
                                //     $row=$result->fetch_assoc();
                                //     $appoid=$row["appoid"];
                                //     $scheduleid=$row["scheduleid"];
                                //     $title=$row["title"];
                                //     $docname=$row["docname"];
                                //     $scheduledate=$row["scheduledate"];
                                //     $scheduletime=$row["scheduletime"];
                                //     $pname=$row["pname"];
                                //     
                                //     
                                //     echo '<tr >
                                //         <td style="font-weight:600;"> &nbsp;'.
                                        
                                //         substr($pname,0,25)
                                //         .'</td >
                                //         <td style="text-align:center;font-size:23px;font-weight:500; color: var(--btnnicetext);">
                                //         '.$apponum.'
                                        
                                //         </td>
                                //         <td>
                                //         '.substr($title,0,15).'
                                //         </td>
                                //         <td style="text-align:center;;">
                                //             '.substr($scheduledate,0,10).' @'.substr($scheduletime,0,5).'
                                //         </td>
                                        
                                //         <td style="text-align:center;">
                                //             '.$appodate.'
                                //         </td>

                                //         <td>
                                //         <div style="display:flex;justify-content: center;">
                                        
                                //         <!--<a href="?action=view&id='.$appoid.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">View</font></button></a>
                                //        &nbsp;&nbsp;&nbsp;-->
                                //        <a href="?action=drop&id='.$appoid.'&name='.$pname.'&session='.$title.'&apponum='.$apponum.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-delete"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Cancel</font></button></a>
                                //        &nbsp;&nbsp;&nbsp;</div>
                                //         </td>
                                //     </tr>';
                                    
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
    
    if($_GET){
        $id=$_GET["id"];
        $action=$_GET["action"];
        if($action=='booking-added'){
            
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                    <br><br>
                        <h2>Réservation réussie.</h2>
                        <a class="close" href="appointment.php">&times;</a>
                        <div class="content">
                        Votre numéro de rendez-vous est '.$id.'.<br><br>
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        
                        <a href="appointment.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;Accepter&nbsp;&nbsp;</font></button></a>
                        <br><br><br><br>
                        </div>
                    </center>
            </div>
            </div>
            ';
        }elseif($action=='drop'){
            $title=$_GET["title"];
            $docname=$_GET["doc"];
            
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2>Es-tu sûr?</h2>
                        <a class="close" href="appointment.php">&times;</a>
                        <div class="content">
                            Vous souhaitez annuler ce rendez-vous ?<br><br>
                            Nom de la session: &nbsp;<b>'.substr($title,0,40).'</b><br>
                           Nom du médecin&nbsp; : <b>'.substr($docname,0,40).'</b><br><br>
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <a href="delete-appointment.php?id='.$id.'" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Oui&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="appointment.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;Non&nbsp;&nbsp;</font></button></a>

                        </div>
                    </center>
            </div>
            </div>
            '; 
        }elseif($action=='view'){
            $sqlmain= "select * from doctor where docid=?";
            $stmt = $database->prepare($sqlmain);
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row=$result->fetch_assoc();
            $name=$row["docname"];
            $email=$row["docemail"];
            $spe=$row["specialties"];
            
            $sqlmain= "select sname from specialties where id=?";
            $stmt = $database->prepare($sqlmain);
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
    }
}

    ?>
    </div>

</body>
</html>
