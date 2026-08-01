<?php
    include "Nav.php";
    $con=OpenCon();
    if(isset($_SESSION['VehicleId'])){
        $CarId=$_SESSION['VehicleId'];
    }else{
        $CarId=-1;
    }
    if(isset($_POST['Rent'])){
        header("Location: Payment.php");
        exit();
    }else if(isset($_POST['GoBack'])){
        unset($_SESSION['VehicleId']);
        unset($_SESSION['Branch']);
        header("Location: VehiclesPage.php");
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
            margin: 0px;
            margin-top: 30px;
        }
        .Css1{
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .Css2{
            background-color: #c5c5c7;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0px 0px 50px black;
        }
        .Css2 img{
            width: 370px;
            height: 250px;
        }
        .Css2 button{
            font-weight: bold;
            font-style: italic;
            border-radius: 10px;
            background-color: yellow;
            font-size: 25px;
            padding-left: 40px;
            padding-right:40px;
        }
        .Css2 button:hover{
            border:2px solid blue;
            color:blue;
        }
        .Css3{
            width: 50%;
            display: flex;
            gap: 100px;
            padding-left: 30px;
            padding-top: 30px;
        }
        .Css3 img{
            width: 200px;
            height: 160px;
        }
        .Css3 p{
            font-weight: bold;
            font-size: 25px;
        }
        .Css4{
            display: flex;
        }
        .Css5{
            padding-top:80px ;
            width: 60%;
            display: flex;
            flex-direction: column;
        }
        .Css5 img{
            width: 35px;
            height: 35px;
        }
        .Css6{
            display: flex;
            gap:20px;
        }
        .Css7{
            width: 40%;
            display: flex;
            flex-direction: column;
        }
        .Css7 img{
            width: 190px;
            height: 150px;
        }
        .Css8{
            width: 20%;
            display: flex;
            flex-direction: column;
            padding-top:50px;
            gap: 50px;
            text-align: center;
        }
        .Css9{ 
            font-weight: bold;
            font-style: italic;
            border-radius: 10px;
            border:2px solid black;
            background-color: yellow;
            padding-left: 40px;
            padding-right:40px;
            font-size: 30px;
        }
        .Css10{
            display: flex;
        }
        .Css10 img{
            border: 3px solid black;
        }
        .Css10 img:hover{
            transform: scale(1.7);
            transition: 1s;
        }
        .Css11{
            display: flex;
            gap: 30px;
        }
        .Css12{
            padding-top:30px;
            display: flex;
            gap: 30px;
        }
        p{
            display: inline;
            font-weight: bold;
            font-size: 20px;
        }
        .CarDetails{
            display: flex;
            gap:5px;
        }
        </style>
    </head>
    <body>
        <div class="Css1">
            <div class="Css2">
                <form method="POST">
                    <button type="submit" name="GoBack"><-- Go Back</button>
                </form>
                <?php
                    $cars=mysqli_query($con,"SELECT * FROM Vehicle");
                    while($c=mysqli_fetch_array($cars)){
                        if($c['Id']==$CarId){
                            echo "<div class='Css4'>
                                    <img src='Pictures/".$c['Image']."'>
                                    <div class='Css3'>
                                            <div><p>".$c['VehicleName']."</p></div>
                                            <img src='Pictures/".$c['VehicleLogo']."'>
                                    </div>
                                    <div class='Css8'>
                                        <div class='Css9'>$".$c['PricePerDay']."</div>
                                        <div><form method='post'><label><button type='submit' name='Rent'>Rent</form></div>
                                    </div>
                                </div>
                            <div class='Css6'>
                                <div class='Css7'>
                                    <div class='Css10'><img src='Pictures/".$c['VehicleInside1']."'><img src='Pictures/".$c['VehicleInside2']."'></div>
                                    <div class='Css10'><img src='Pictures/".$c['VehicleInside3']."'><img src='Pictures/".$c['VehicleInside4']."'></div>
                                </div>
                                <div class='Css5'>
                                    <div class='Css11'>
                                        <div class='CarDetails'><div><p>".$c['GearBox']."</p></div><img src='Pictures/GearBox'></div>
                                        <div class='CarDetails'><div><p>".$c['Seats']."</p></div><img src='Pictures/Seats'></div>
                                        <div class='CarDetails'><div><p>".$c['Doors']."</p></div><img src='Pictures/Doors'></div>
                                        <div class='CarDetails'><div><p>".$c['EnergyType']."</p></div><img src='Pictures/EnergyType'></div>";
                                        if($c['AirConditioner']==1){
                                            echo "<div class='CarDetails'><div><p>A/C </p></div><img src='Pictures/AC'></div>";
                                        }
                                    echO"
                                    </div>
                                    <div class='Css12'>
                                    <div><p>";
                                        if($c['DriveStyle']==1){
                                            echo "OnRoad";
                                        }else{  
                                            echo "OffRoad";
                                        }
                                        echo "</p></div>
                                        <div><p>Miles ".$c['Miles']."</p></div>
                                        <div><p>".$c['DriveType']."</p></div>
                                        <div><p>HP ".$c['HorsePower']."</p></div>";
                                        if($c['Convertible']==1){
                                            echo "<div><p>Convertible</p></div>";
                                        }
                                        echo "
                                    </div>
                                    <div class='Css12'><div><p>Max Speed ".$c['MaxSpeed']."</p></div>
                                    <div><p>Tank Size ".$c['TankSize']."</p></div>
                                    <div><p>Color ".$c['Color']."</p></div>
                                    </div>
                                </div>
                            </div>";
                            break;
                        }
                    }
                    CloseCon($con);
                ?>
            </div>
        </div>
    </body>
</html>