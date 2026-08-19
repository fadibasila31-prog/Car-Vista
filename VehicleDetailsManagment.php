<?php
    include "Nav.php";
    $con=OpenCon();
    if(isset($_POST['GoBack'])){
        unset($_SESSION['VehicleId']);
        header("Location: VehiclesManagement.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <style>
            body{
                font-family: Arial;
                display:flex;
                justify-content: center;
                margin-top: 50px;
            }
            .Css1{
                margin-top:10px;
                display: flex;
                background-color: #c5c5c7;
            }
            .Css1 form{
                margin-top:10px;
                margin-left: auto;
            }
            .Css1 form button{
                font-size: 20px;
                border-radius: 10px;
                border:2px solid black;
                background-color: yellow;
            }
            .Css1 form button:hover{
                border:2px solid blue;
                color:blue;
            }
            .Css2{ 
                padding-left: 10px;
                display: flex;
                flex-direction: column;
                gap:5px;
            }
            .Css3{
                display: flex;
                gap:50px;
                margin-top:20px;
            }
            .Css4{
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .Css5{
                display: flex;
                justify-self: center;
                margin-top: 50px;
                margin-bottom:100px;
            }
            .Css5 table{
                border-spacing: 0px;
                box-shadow: -7px 7px 10px black;
                border-top-left-radius: 10px;
                border-top-right-radius: 10px;
                background-color: #dcdede;
            }
            .Css5 th{
                border:2px solid black ;
                width:150px;
                padding-top:5px;
                padding-bottom:5px;
            }
            .Css5 td{
                border:2px solid black;
                text-align: center;
                padding-top: 10px;
                padding-bottom:10px;
            }
            .Shadow{
                box-shadow: -7px 7px 10px black;
                border-radius: 15px;
                padding-left: 10px;
                padding-right: 10px;
                padding-bottom: 10px;                
                background-color: #c5c5c7;
            }       
            td{
                border:5px black solid;
            }
            h1{
                background-color: whitesmoke;
                margin-right: 250px;
                border:2px solid black;
                border-radius: 5px;
                font-size: 20px;
            }
            h2{
                background-color: aquamarine;
                border:2px solid green;
                border-radius: 10px;
                color:green;
                padding:5px 10px 5px 10px;
            }
            span{
                font-size:15px;
                font-weight: bold;
            }
            #logo{
                height: 80px;
                width: 100px;
                border:2px solid black;
            }
            #Brand{
                font-weight: bold;
                font-size: 18px;
            }
            #NumberPlate{
                font-weight: bold;
                border:3px black solid;
                border-radius: 5px;
                padding:2px;
                padding-left: 5px;
                padding-right:5px;
            }
            #VehicleInside{
                height: 170px;
                width: 370px;
                margin: 10px;  
                border:3px dashed blue;            
            }
            #Vehicleimageoutside{
                width:370px;
                height:250px;
                border:4px dashed blue;
            }
            #InfImage{
                width:30px;
                height: 30px;
            }
            #InfImage2{
                padding-left: 10px;
                width:30px;
                height: 30px;
            }
            #Inftd{
                display: flex;
            }
            #span{
                border-radius: 5px;
                border:2px solid black;
                text-align: center;
                padding-left: 5px;
                padding-right:5px;
            }
            #Leftth{
                border-top-left-radius: 10px;
            }
            #Rightth{
                border-top-right-radius: 10px;
            }
        </style>
    </head>
    <body>
        <?php
            if(isset($_SESSION['VehicleId'])){
                $VehicleId=$_SESSION['VehicleId'];
                $Vehicle=mysqli_query($con,"SELECT * FROM Vehicle");
                while($v=mysqli_fetch_array($Vehicle)){
                    if($VehicleId==$v['Id']){           
                        echo "<div>
                                <div class='Css1'>
                                    <img id='logo' src='Pictures/".$v['VehicleLogo']."'>
                                    <div class='Css2'>
                                        <span id='span' style='margin-top:10px;'>".$v['VehicleBrand']."</span>
                                        <span id='span'>".$v['NumberPlate']."</span>
                                    </div>
                                    <form method='POST'>
                                        <button type='submit' name='GoBack'><-- Go Back</button>
                                    </form>
                                </div>
                                <div class='Css3'>
                                    <div class='Shadow'>
                                        <div class='Css4'>
                                            <img id='Vehicleimageoutside' src='Pictures/".$v['Image']."'>
                                            <div class='Css2'>
                                                <img id='VehicleInside' src='Pictures/".$v['VehicleInside1']."'>
                                                <img id='VehicleInside' src='Pictures/".$v['VehicleInside2']."'>
                                            </div>
                                        </div>
                                        <img id='VehicleInside' src='Pictures/".$v['VehicleInside3']."'>
                                        <img id='VehicleInside' src='Pictures/".$v['VehicleInside4']."'>
                                    </div>
                                    <div class='Shadow'>
                                        <h1>Vehicle Information</h1>
                                        <table>
                                            <tr>
                                                <td id='Inftd'>
                                                    <img id='InfImage' src='Pictures/GearBox'>
                                                    <div class='Css2'>
                                                        <span>Gear Box</span>
                                                        <span>".$v['GearBox']."</span>
                                                    </div>
                                                    <img id='InfImage2' src='Pictures/Seats'>
                                                    <div class='Css2'>
                                                        <span>Seats</span>
                                                        <span>".$v['Seats']."</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td id='Inftd'>
                                                    <img id='InfImage' src='Pictures/PricePerDay'>
                                                    <div class='Css2'>
                                                        <span>Price Per Day</span>
                                                        <span>".$v['PricePerDay']."</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        <table>


                                        <h1>Pricing & Efficiency</h1>
                                        <table>
                                            <tr>
                                                <td id='Inftd'>
                                                        <img id='InfImage' src='Pictures/Miles'>
                                                        <div class='Css2'>
                                                            <span>Miles</span>
                                                            <span>".$v['Miles']."</span>
                                                        </div>
                                                        <img id='InfImage2' src='Pictures/EnergyType'>
                                                        <div class='Css2'>
                                                            <span>Energy Type</span>
                                                            <span>".$v['EnergyType']."</span>
                                                        </div>

                                                        <img id='InfImage2' src='Pictures/DriveType'>
                                                        <div class='Css2'>
                                                            <span>Drive Type</span>
                                                            <span>".$v['DriveType']."</span>
                                                        </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td id='Inftd'>
                                                    <img id='InfImage' src='Pictures/HorsePower'>
                                                    <div class='Css2'>
                                                        <span>Horse Power</span>
                                                        <span>".$v['HorsePower']."</span>
                                                    </div>
                                                    <img id='InfImage2' src='Pictures/MaxSpeed'>
                                                    <div class='Css2'>
                                                        <span>Max Speed</span>
                                                        <span>".$v['MaxSpeed']."</span>
                                                    </div>
                                                    <img id='InfImage2' src='Pictures/AC'>
                                                    <div class='Css2'>
                                                        <span>Air Conditioner</span>
                                                        <span>";
                                                            if($v['AirConditioner']==1){
                                                                echo "Available";
                                                            }else{
                                                                echo "Not Available";
                                                            }
                                                        echo "</span>                                                    
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td id='Inftd'>
                                                    <img id='InfImage' src='Pictures/Drive-Style'>
                                                    <div class='Css2'>
                                                        <span>Drive Style</span>
                                                        <span>";
                                                            if($v['DriveStyle']==1){
                                                                echo "On Road";
                                                            }else{
                                                                echo "Off Road";
                                                            }
                                                        echo "</span>                                           
                                                    </div>
                                                </td>
                                            </tr>                                                
                                        </table>


                                        <h1>Specifications</h1>
                                        <table>
                                            <tr>
                                                <td id='Inftd'>
                                                    <img id='InfImage' src='Pictures/NumberPlate'>
                                                    <div class='Css2'>
                                                        <span>Number Plate</span>
                                                        <span>".$v['NumberPlate']."</span>
                                                    </div>
                                                    <img id='InfImage2' src='Pictures/VehicleBrand'>
                                                    <div class='Css2'>
                                                        <span>Vehicle Brand</span>
                                                        <span>".$v['VehicleBrand']."</span>
                                                    </div>
                                                    <img id='InfImage2' src='Pictures/VehicleName'>
                                                    <div class='Css2'>
                                                        <span>Vehicle Name</span>   
                                                        <span>".$v['VehicleName']."</span>                                                    
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td id='Inftd'>
                                                    <img id='InfImage' src='Pictures/Doors'>
                                                    <div class='Css2'>
                                                        <span>Doors</span>
                                                        <span>".$v['Doors']."</span>
                                                    </div>
                                                    <img id='InfImage2' src='Pictures/TankSize'>
                                                    <div class='Css2'>
                                                        <span>Tank Size</span>
                                                        <span>".$v['TankSize']."</span>
                                                    </div>
                                                    <img id='InfImage2' src='Pictures/Convertible'>
                                                    <div class='Css2'>
                                                        <span>Convertible</span>
                                                        <span>";
                                                            if($v['Convertible']==1){
                                                                echo "Available";
                                                            }else{
                                                                echo "Not Available";
                                                            }
                                                        echo "</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td id='Inftd'>
                                                    <img id='InfImage' src='Pictures/Color'>
                                                    <div class='Css3'>
                                                        <span>Color</span>
                                                        <span>".$v['Color']."</span>                                                 
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class='Css5'>";
                                    $arr=[];
                                    $Booking=mysqli_query($con,"SELECT * FROM Booking");
                                    while($b=mysqli_fetch_array($Booking)){
                                        if($b['VehicleId']==$v['Id'] && ($b['Status']=="Active" || $b['Status']=="Waiting")){
                                            $arr[]=$b;
                                        }
                                    }

                                    if(count($arr)!=0){
                                        echo "<table>
                                        <th id='Leftth'>Start Date</th>
                                        <th>End Date</th>
                                        <th id='Rightth'>Status</th>";
                                        foreach($arr as $a){
                                            echo "<tr>
                                            <td>".$a['StartDate']."</td>
                                            <td>".$a['EndDate']."</td>
                                            <td>".$a['Status']."</td>
                                            </tr>";
                                        }
                                        echo "</table>";
                                    }else{
                                        echo "<h2>This vehicle is available and ready for rental</h2>";
                                    }
                                echo"</div>
                            </div>";
                        break;
                    }
                }
            }
        ?>
    </body>
</html>