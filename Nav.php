<?php
    session_start();
    if(isset($_POST['Logout'])){
        session_destroy();
        header("Location:Index.php");
        exit();
    }
    include "DB_Connection.php";
    $con=OpenCon();
    $Start="";
    $End="";
    $now="";
    $now2=date("Y-m-d H:i");
    $Status=mysqli_query($con,"SELECT * FROM Booking");
    while($s=mysqli_fetch_array($Status)){
        $Start=strtotime($s['StartDate']);
        $End=strtotime($s['EndDate']);
        $now=time();
        $now2=date("Y-m-d H:i");
        $BookingId=$s['BookingId'];
        if($Start<=$now && $now<=$End){
            mysqli_query($con,"UPDATE Booking SET Status='Active' WHERE BookingId='$BookingId' AND StartDate<='$now2' AND EndDate>='$now2'");
        }else if($now<$Start){
            mysqli_query($con,"UPDATE Booking SET Status='Waiting' WHERE BookingId='$BookingId' AND StartDate>'$now2'");
        }else if($now>$End){
            mysqli_query($con,"UPDATE Booking SET Status='Finished' WHERE BookingId='$BookingId' AND EndDate<'$now2'");                    
        }
    }

    $RandomPassTimer=mysqli_query($con,"SELECT * FROM Users");
    while($timer=mysqli_fetch_array($RandomPassTimer)){
        if($timer['StartTimeExpired']!=null ){
            if($timer['StartTimeExpired'] < $timer['EndTimeExpired']){
                mysqli_query($con, "UPDATE Users SET StartTimeExpired = NOW()");
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <style>
            body{
                font-family: Arial;
                margin:0px;
            }
            #Nav{
                height: 50px;
                position: fixed;
                top:0px;
                right: 0px;
                left:0px;
                z-index:1;
                display: flex;                
                background-color: gray;
            }
            #Nav a{
                text-decoration: none;
                color:black;
                padding-left: 10px;
                padding-right: 10px;
                padding-top:3px;
                margin-left: 10px;
                font-size: 18px;
                border:2px solid black;
                border-radius: 10px;
                background-color: white;
            }
            #Nav a:hover{
                color:blue;
                border:2px solid blue;
            }
            #Nav img{
                width:120px;
                height:50px;
                position: absolute;
                right: 10px;
                top:0px;
            }
            button[name="Logout"]{
                border:2px solid black;
                border-radius: 10px;
                font-size: 20px;
                margin-left: 10px;
            }
            button[name="Logout"]:hover{
                color:blue;
                border:2px solid blue;
            }
            .MenuTag{
                margin-left:10px;
                padding:5px 10px 5px 10px;
                font-weight: bold;
                font-size: 30px;
                color:white;
            }
            button{
                cursor:pointer;
            }
            .Menu:hover .MenuOpened{
                margin-left: 0px;
                transition: 1s;
                padding-right:10px;
            }
            .MenuOpened{
                display: flex;
                flex-direction: column;
                gap:8px;
                background-color: gray;
                height: 100vh;
                width:200px;
                margin-left: -210px;
                padding-top: 10px;
                padding-bottom:10px;
                padding-right:10px;
                transition: margin-left 1s;
            }
        </style>
    </head>
    <body>
        <nav id="Nav">
            <div class="Menu">
                <div class="MenuTag">☰</div>
                <div class="MenuOpened">
                    <a href="Index.php">Home Page</a>
                    <a href='VehiclesPage.php'>Vehicles</a>
                    <a href="QuickSearch.php">Quick Search</a>
                    <?php 
                        if(isset($_SESSION['Role'])){
                            if($_SESSION['Role']=="Manager"){
                                echo "<a href='Profile.php'>My Profile</a>
                                <a href='Graph.php'>Graph</a>
                                <a href='UserDetails.php'>Users Details</a>
                                <a href='VehiclesManagement.php'>Vehicles Details</a>
                                <a href='CustomerService.php'>Customer Service</a>
                                <a href='ManagerVehicleManagement.php'>Vehicle Management</a>
                                <a href='VehicleRentalHistory.php'>Vehicle Rental History</a>
                                <form method='post'><button type='submit' name='Logout'>Logout</button></form>";
                            }else if($_SESSION['Role']=="Worker"){
                                echo"<a href='Profile.php'>My Profile</a>
                                <a href='VehiclesManagement.php'>Vehicles Details</a>
                                <a href='CustomerService.php'>Customer Service</a>
                                <form method='post'><button type='submit' name='Logout'>Logout</button></form>";
                            }else{
                                echo"<a href='Profile.php'>My Profile</a>";
                                echo "<a href='ContactPage.php'>Customer Support</a>
                                <form method='post'><button type='submit' name='Logout'>Logout</button></form>";
                            }
                        }else{
                            echo "<a href='Login.php'>Login</a>";
                        }
                    ?>
                </div>
            </div>
            <img src="Pictures/CarVistaLogo">
        </nav>
    </body>
</html>