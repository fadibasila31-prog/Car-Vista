<?php
    session_start();
    if(isset($_POST['Logout'])){
        session_destroy();
        header("Location:HomePage.php");
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
            mysqli_query($con,"UPDATE Booking SET Status='In Use' WHERE BookingId='$BookingId' AND StartDate<='$now2' AND EndDate>='$now2'");
        }else if($now<$Start){
            mysqli_query($con,"UPDATE Booking SET Status='Confirmed' WHERE BookingId='$BookingId' AND StartDate>'$now2'");
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
                display: flex;                
                background-color: gray;
            }
            #Nav a{
                text-decoration: none;
                color:black;
                margin-top: 10px;
                margin-left: 7px;
                margin-bottom: 10px;
                padding-left: 10px;
                padding-right: 10px;
                font-size: 20px;
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
            #Nav form{
                margin-top: 10px;
                margin-left: 10px;
            }
            #Nav button{
                border:2px solid black;
                border-radius: 10px;
                font-size: 20px;
            }
            #Nav button:hover{
                color:blue;
                border:2px solid blue;
            }
            button{
                cursor:pointer;
            }
        </style>
    </head>
    <body>
        <?php 
        $RentTime=mysqli_query($con,"SELECT * FROM Booking");
        while($RT=mysqli_fetch_array($RentTime)){
            $Now=strtotime("Y-M-d:TH:i");
            $GetCar=strtotime($RT['StartDate']);
            $ReturnCar=strtotime(($RT['EndDate']));
            if($Now>=$GetCar && $Now<=$ReturnCar){
                mysqli_query($con,"UPDATE Booking SET Status='InUse'");
            }else if($Now>$ReturnCar){
                mysqli_query($con,"UPDATE Booking SET Status='Finished'");
            }
        }
        ?>
        <nav id="Nav">
            <a href="HomePage.php">Home Page</a>
            <?php 
            if(isset($_SESSION['Role'])){
                if($_SESSION['Role']=="Manager"){
                    echo "<a href='Profile.php'>My Profile</a>
                    <a href='UserDetails.php'>Users Details</a>
                    <a href='VehiclesManagement.php'>Vehicles Details</a>
                    <a href='CustomerService.php'>Customer Service</a>
                    <a href='ManagerVehicleManagement.php'>Vehicle Managment</a>
                    <a href='VehicleRentalHistory.php'>Vehicle Rental History</a>
                    <form method='post'><button type='submit' name='Logout'>Logout</button></form>";
                }else if($_SESSION['Role']=="Worker"){
                    echo"<a href='Profile.php'>My Profile</a>
                    <a href='VehiclesManagement.php'>Vehicles Details</a>
                    <a href='CustomerService.php'>Customer Service</a>
                    <form method='post'><button type='submit' name='Logout'>Logout</button></form>";
                }else{
                      echo"<a href='Profile.php'>My Profile</a>
                      <a href='ContactPage.php'>Customer Supprot</a>
                    <form method='post'><button type='submit' name='Logout'>Logout</button></form>";
                }
            }else{
                echo "<a href='Index.php'>Login</a>
                <a href='VehiclesPage.php'>Vehicles</a>";
            }
            ?>
            <img src="Pictures/CarVistaLogo">
        </nav>    
    </body>
</html>