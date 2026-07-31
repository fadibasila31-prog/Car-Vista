<?php
    include "Nav.php";
    $con=OpenCon();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <style>
            body{
                font-family: Arial;
                margin: 0px;
            }
            .Css1{
                background-color:cyan;
                margin-top: 100px;
                display: flex;
                justify-content: center;
                padding-left:90px;
                gap: 50px;
            }
            .Css1 img{
                height: 165px;
                width:282px;
            }
            th{
                border: 2px solid red;
            }
            td{
                border: 2px solid red;
            }
        </style>
    </head>
    <body>
        <div class="Css1">
            <?php
                if($_SESSION['VehicleId']){
                    $VehicleId=$_SESSION['VehicleId'];
                    $Vehicle=mysqli_query($con,"SELECT * FROM Vehicle");
                    while($v=mysqli_fetch_array($Vehicle)){
                        if($VehicleId==$v['Id']){
                            echo "<table>
                            <tr><th>Number Plate</th><td>".$v['NumberPlate']."</td></tr>
                            <tr><th>Vehicle Brand</th><td>".$v['VehicleBrand']."</td></tr>
                            <tr><th>Vehicle Name</th><td>".$v['VehicleName']."</td></tr>
                            <tr><th>Gear Box</th><td>".$v['GearBox']."</td></tr>
                            <tr><th>Seats</th><td>".$v['Seats']."</td></tr>
                            <tr><th>Doors</th><td>".$v['Doors']."</td></tr>
                            <tr><th>Price Per Day</th><td>".$v['PricePerDay']."</td></tr>
                            <tr><th>Drive Style</th><td>";if($v['DriveStyle']==0){echo"Off Road";}else{echo"On Road";}echo"</td></tr>
                            <tr><th>Miles</th><td>".$v['Miles']."</td></tr>
                            <tr><th>Horse Power</th><td>".$v['HorsePower']."</td></tr>
                            <tr><th>Fuel Type</th><td>".$v['EnergyType']."</td></tr>
                            <tr><th>Drive Type</th><td>".$v['DriveType']."</td></tr>
                            <tr><th>Max Speed</th><td>".$v['MaxSpeed']."</td></tr>
                            <tr><th>Tank Size</th><td>".$v['TankSize']."</td></tr>
                            <tr><th>Air Conditioner</th><td>";if($v['AirConditioner']==0){echo"No ";}echo"AC</td></tr>
                            <tr><th>Convertible</th><td>";if($v['Convertible']==0){echo"Not ";}echo"Convertible</td></tr>
                            <tr><th>Color</th><td>".$v['Color']."</td></tr>
                            </table>
                            <div>
                            <img src='Pictures/".$v['Image']."'>
                            <img src='Pictures/".$v['VehicleInside1']."'>
                            <img src='Pictures/".$v['VehicleInside2']."'>
                            <img src='Pictures/".$v['VehicleInside3']."'>
                            <img src='Pictures/".$v['VehicleInside4']."'></div>";
                            $Booked=mysqli_query($con,"SELECT * FROM Booking");
                            while($b=mysqli_fetch_array($Booked)){
                                if(($v['Id']==$b['VehicleId']) && $b['Status']=="In Use"){
                                    echo "<h1>This Car In Use<h1>";
                                    break;
                                }
                            }
                            break;
                        }
                    }
                }
            ?>
        </div>
    </body>
</html>