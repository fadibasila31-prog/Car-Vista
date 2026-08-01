<?php 
    include "Nav.php";
    $con=OpenCon();

    $VehicleBrand="";
    $Doors="";
    $Color="";
    $Miles="";
    $VehicleName="";
    $HorsePower="";
    $NumberPlate="";
    $MaxSpeed="";
    $PricePerDay="";
    $TankSize="";
    $Seats="";
    $VehicleType="";
    $GearBox="";
    $DriveStyle="";
    $EnergyType="";
    $Convertible="";
    $Branch="";
    $AirConditioner="";
    $DriveType="";
    $VehicleImage="";
    $InteriorImage1="";
    $InteriorImage2="";
    $InteriorImage3="";
    $InteriorImage4="";
    $VehicleLogo="";
    $VId="";
    $message="";
    $message2="";
    if(isset($_POST['AddVehicle'])){
        if(isset($_POST['VehicleId'])){
            if(trim($_POST['VehicleId'])!=""){
                $message.="<h2>You cant enter a Vehicle ID when adding a new Vehicle</h2>\n";
            }
        }
    
        if(isset($_POST['VehicleBrand']) && $_POST['VehicleBrand']!=""){
            if(trim($_POST['VehicleBrand'])!=""){
                $VehicleBrand=$_POST['VehicleBrand'];
                if(!empty($_FILES['VehicleLogo']['name'])){
                    $VehicleLogo=time()."_".$VehicleBrand;
                    move_uploaded_file($_FILES['VehicleLogo']['tmp_name'], "Pictures/$VehicleLogo");
                } else {
                    $message .= "<h2>Please Upload Vehicle Logo</h2>\n";
                }
            }else{
                $message.="<h2>Vehicle Brand Is Empty</h2>\n";
            }
        }else{
            $message.="<h2>Please Enter The Vehicle Brand</h2>\n";
        }
        
        if(isset($_POST['Color']) && $_POST['Color']!=""){
            if(trim($_POST['Color'])!=""){
                $Color=$_POST['Color'];
            }else{
                $message.="<h2>Vehicle Color Is Empty</h2>\n";
            }
        }else{
            $message.="<h2>Please Enter The Vehicle Color</h2>\n";
        }
        
        if(isset($_POST['VehicleName']) && $_POST['VehicleName']!=""){
            if(trim($_POST['VehicleName'])!=""){
                $VehicleName=$_POST['VehicleName'];
            }else{
                $message.="<h2>Vehicle Name Is Empty</h2>\n";
            }
        }else{
            $message.="<h2>Please Enter The Vehicle Name</h2>\n";
        }
        
        if(isset($_POST['NumberPlat']) && $_POST['NumberPlat']!=""){
            if(trim($_POST['NumberPlat'])!=""){
                $NumberPlate=$_POST['NumberPlat'];
                $found=false;
                $CheckCopy=mysqli_query($con,"SELECT * FROM Vehicle");
                while($check=mysqli_fetch_array($CheckCopy)){
                    if(trim($check['NumberPlate'])==trim($NumberPlate)){
                        $found=true;
                        break;
                    }
                }

                if($found){
                    $message.="<h2>You Already Have This Number Plate</h2>\n";
                }
            }else{
                $message.="<h2>Vehicle Number Plate Is Empty</h2>\n";
            }
        }else{
            $message.="<h2>Please Enter The Vehicle Number Plate</h2>\n";
        }
        
        if(isset($_POST['PricePerDay']) && trim($_POST['PricePerDay'])!=""){
            $PricePerDay=$_POST['PricePerDay'];
            if($PricePerDay<=0){
                $message.="<h2>Price Must Be Greater Than 0</h2>\n";
            }
        }else{
            $message.="<h2>Please Enter The Vehicle Price Per Day</h2>\n";
        }
        
        if(isset($_POST['Seats']) && trim($_POST['Seats'])!=""){
            $Seats=$_POST['Seats'];
            if($Seats<=1){
                $message.="<h2>Must Be At Least 2 Seats</h2>\n";
            }
        }else{
            $message.="<h2>Please Enter The Vehicle Seats Number</h2>\n";
        }
        
        if(isset($_POST['Doors']) && trim($_POST['Doors'])!=""){
            $Doors=$_POST['Doors'];
            if($Doors<=1){
                $message.="<h2>Must Be At Least 2 Doors</h2>\n";
            }
        }else{
            $message.="<h2>Please Enter The Vehicle Doors Number</h2>\n";
        }
        
        if(isset($_POST['Miles']) && trim($_POST['Miles'])!=""){
            $Miles=$_POST['Miles'];
            if($Miles<0){
                $message.="<h2>Vehicle Miles Cant Be Lower Than 0</h2>\n";
            }
        }else{
            $message.="<h2>Please Enter The Vehicle Miles Number</h2>\n";
        }
        
        if(isset($_POST['HorsePower']) && trim($_POST['HorsePower'])!=""){
            $HorsePower=$_POST['HorsePower'];
            if($HorsePower<=0){
                $message.="<h2>Horse Power Must Be Greater Than 0</h2>\n";
            }
        }else{
            $message.="<h2>Please Enter The Vehicle Horse Power</h2>\n";
        }
        
        if(isset($_POST['MaxSpeed']) && trim($_POST['MaxSpeed'])!=""){
            $MaxSpeed=$_POST['MaxSpeed'];
            if($MaxSpeed<=0){
                $message.="<h2>Max Speed Must Be Greater Than 0</h2>\n"; 
            }
        }else{
            $message.="<h2>Please Enter The Vehicle Max Speed</h2>\n";
        }
        
        if(isset($_POST['TankSize']) && trim($_POST['TankSize'])!=""){
            $TankSize=$_POST['TankSize'];
            if($TankSize<10){
                $message.="<h2>Tank Size Must Be At Least 10 Liters</h2>\n";
            }
        }else{
            $message.="<h2>Please Enter The Vehicle Tank Size</h2>\n";
        }
        
        if(isset($_POST['VehicleType'])){
            $VehicleType=$_POST['VehicleType'];
        }else{
            $message.="<h2>Please Enter The Vehicle Type</h2>\n";
        }
        
        if(isset($_POST['GearBox'])){
            $GearBox=$_POST['GearBox'];
        }else{
            $message.="<h2>Please Enter The Vehicle Gear Box</h2>\n";
        }
        
        if(isset($_POST['DriveStyle'])){
            if($_POST['DriveStyle']=="OnRoad"){
                $DriveStyle=1;
            }else{
                $DriveStyle=0;
            }
        }else{
            $message.="<h2>Please Enter The Vehicle Drive Style</h2>\n";
        }
        
        if(isset($_POST['EnergyType'])){
            $EnergyType=$_POST['EnergyType'];
        }else{
            $message.="<h2>Please Enter The Vehicle Energy Type</h2>\n";
        }
    
        if(isset($_POST['Convertible'])){
            if($_POST['Convertible']=="Yes"){
                $Convertible=1;
            }else{
                $Convertible=0;
            }
        }else{
            $message.="<h2>Convertible status must be selected</h2>\n";
        }
        
        if(isset($_POST['Branch'])){
            $Branch=$_POST['Branch'];
        }else{
            $message.="<h2>Please Enter The Vehicle Branch</h2>\n";
        }

        if(isset($_POST['AirConditioner'])){
            if($_POST['AirConditioner']=="Yes"){
                $AirConditioner=1;
            }else{
                $AirConditioner=0;
            }
        }else{
            $message.="<h2>Air Conditioner status must be selected</h2>\n";
        }

        if(isset($_POST['DriveType'])){
            $DriveType=$_POST['DriveType'];
        }else{
            $message.="<h2>Please Enter The Vehicle Drive Type</h2>\n";
        }
        
        if(!empty($_FILES['VehicleImage']['name'])){
            $VehicleImage=$_FILES['VehicleImage']['name'];
            $VehicleImage=time()."_".$VehicleImage;
            move_uploaded_file($_FILES['VehicleImage']['tmp_name'],"Pictures/$VehicleImage");
        }else{
            $message.="<h2>Please upload the vehicle exterior image</h2>\n";
        }

        if(!empty($_FILES['VehicleInside1']['name'])){
            $InteriorImage1=$_FILES['VehicleInside1']['name'];
            $InteriorImage1=time()."_".$InteriorImage1;
            move_uploaded_file($_FILES['VehicleInside1']['tmp_name'],"Pictures/$InteriorImage1");
        }else{
            $message.="<h2>Please upload interior image 1</h2>\n";
        }

        if(!empty($_FILES['VehicleInside2']['name'])){
            $InteriorImage2=$_FILES['VehicleInside2']['name'];
            $InteriorImage2=time()."_".$InteriorImage2;
            move_uploaded_file($_FILES['VehicleInside2']['tmp_name'],"Pictures/$InteriorImage2");
        }else{
            $message.="<h2>Please upload interior image 2</h2>\n";
        }

        if(!empty($_FILES['VehicleInside3']['name'])){
            $InteriorImage3=$_FILES['VehicleInside3']['name'];
            $InteriorImage3=time()."_".$InteriorImage3;
            move_uploaded_file($_FILES['VehicleInside3']['tmp_name'],"Pictures/$InteriorImage3");
        }else{
            $message.="<h2>Please upload interior image 3</h2>\n";
        }

        if(!empty($_FILES['VehicleInside4']['name'])){
            $InteriorImage4=$_FILES['VehicleInside4']['name'];
            $InteriorImage4=time()."_".$InteriorImage4;
            move_uploaded_file($_FILES['VehicleInside4']['tmp_name'],"Pictures/$InteriorImage4");
        }else{
            $message.="<h2>Please upload interior image 4</h2>\n";
        }

    
        if($message==""){
            mysqli_query($con,"INSERT INTO Vehicle (VehicleType,NumberPlate,VehicleBrand,Image,PricePerDay,GearBox,Seats,Doors,DriveStyle,Miles,Color,Convertible,EnergyType,HorsePower,VehicleName,MaxSpeed,DriveType,TankSize,AirConditioner,VehicleInside1,VehicleInside2,VehicleInside3,VehicleInside4,VehicleLogo) 
            values ('$VehicleType','$NumberPlate','$VehicleBrand','$VehicleImage','$PricePerDay','$GearBox','$Seats','$Doors','$DriveStyle','$Miles','$Color','$Convertible','$EnergyType','$HorsePower','$VehicleName','$MaxSpeed','$DriveType','$TankSize','$AirConditioner','$InteriorImage1','$InteriorImage2','$InteriorImage3','$InteriorImage4','$VehicleLogo')");
            $message2="<h3>Vehicle Added Successful</h3>";
        }


    }else if(isset($_POST['Change'])){
        if(trim($_POST['VehicleId'])){
            $VId=$_POST['VehicleId'];
            $found=false;
             $Changes=mysqli_query($con,"SELECT * FROM Vehicle");
                while($c=mysqli_fetch_array($Changes)){
                    if($c['Id']==$VId){
                        $found=true;
                        if(isset($_POST['VehicleBrand']) && $_POST['VehicleBrand']!=""){
                            if(trim($_POST['VehicleBrand'])!=""){
                                $VehicleBrand=$_POST['VehicleBrand'];
                            }else{
                                $message.="<h2>You Cant Change To Empty Vehicle Brand</h2>\n";
                            }
                        }else{
                            $VehicleBrand=$c['VehicleBrand'];
                        }

                        if(isset($_POST['Color']) && $_POST['Color']!=""){
                            if(trim($_POST['Color'])!=""){
                                $Color=$_POST['Color'];
                            }else{
                                $message.="<h2>You Cant Change To Empty Vehicle Color</h2>\n";
                            }
                        }else{
                            $Color=$c['Color'];
                        }

                        if(isset($_POST['VehicleName']) && $_POST['VehicleName']!=""){
                            if(trim($_POST['VehicleName'])!=""){
                                $VehicleName=$_POST['VehicleName'];
                            }else{
                                $message.="<h2>You Cant Change To Empty Vehicle Name</h2>\n";
                            }
                        }else{
                            $VehicleName=$c['VehicleName'];
                        }

                        if(isset($_POST['NumberPlat']) && $_POST['NumberPlat']!=""){
                            if(trim($_POST['NumberPlat'])!=""){
                                $NumberPlate=$_POST['NumberPlat'];
                                $found2=false;
                                $CheckCopy=mysqli_query($con,"SELECT * FROM Vehicle");
                                while($check=mysqli_fetch_array($CheckCopy)){
                                    if($check['NumberPlate']==$NumberPlate){
                                        $found2=true;
                                        break;
                                    }
                                }

                                if($found2){
                                    $message.="<h2>You Already Have This Vehicle Number Plate</h2>\n";
                                }                                                                
                            }else{
                                $message.="<h2>You Cant Change To Empty Vehicle Number Plate</h2>\n";
                            }
                        }else{
                            $NumberPlate=$c['NumberPlate'];
                        }

                        if(isset($_POST['PricePerDay']) && trim($_POST['PricePerDay'])!=""){
                            $PricePerDay=$_POST['PricePerDay'];
                            if($PricePerDay<=0){
                                $message.="<h2>Price Must Be Greater Than 0</h2>\n";
                            }
                        }else{
                            $PricePerDay=$c['PricePerDay'];
                        }

                        if(isset($_POST['Seats']) && trim($_POST['Seats'])!=""){
                            $Seats=$_POST['Seats'];
                            if($Seats<=1){
                                $message.="<h2>Must Be At Least 2 Seats</h2>\n";
                            }
                        }else{
                            $Seats=$c['Seats'];
                        }

                        if(isset($_POST['Doors']) && trim($_POST['Doors'])!=""){
                            $Doors=$_POST['Doors'];
                            if($Doors<=1){
                                $message.="<h2>Must Be At Least 2 Doors</h2>\n";
                            }
                        }else{
                            $Doors=$c['Doors'];
                        }

                        if(isset($_POST['Miles']) && trim($_POST['Miles'])!=""){
                            $Miles=$_POST['Miles'];
                            if($Miles<0){
                                $message.="<h2>Vehicle Miles Cant Be Lower Than 0</h2>\n";
                            }
                        }else{
                            $Miles=$c['Miles'];
                        }

                        if(isset($_POST['HorsePower']) && trim($_POST['HorsePower'])!=""){
                            $HorsePower=$_POST['HorsePower'];
                            if($HorsePower<=0){
                                $message.="<h2>Horse Power Must Be Greater Than 0</h2>\n";
                            }
                        }else{
                            $HorsePower=$c['HorsePower'];
                        }

                        if(isset($_POST['MaxSpeed']) && trim($_POST['MaxSpeed'])!=""){
                            $MaxSpeed=$_POST['MaxSpeed'];
                            if($MaxSpeed<=0){
                                $message.="<h2>Max Speed Must Be Greater Than 0</h2>\n";
                            }
                        }else{
                            $MaxSpeed=$c['MaxSpeed'];
                        }

                        if(isset($_POST['TankSize']) && trim($_POST['TankSize'])!=""){
                            $TankSize=$_POST['TankSize'];
                            if($TankSize<10){
                                $message.="<h2>Tank Size Must Be At Least 10 Liters</h2>\n";
                            }
                        }else{
                            $TankSize=$c['TankSize'];
                        }

                        if(isset($_POST['VehicleType'])){
                            $VehicleType=$_POST['VehicleType'];
                        }else{
                            $VehicleType=$c['VehicleType'];
                        }

                        if(isset($_POST['GearBox'])){
                            $GearBox=$_POST['GearBox'];
                        }else{
                            $GearBox=$c['GearBox'];
                        }

                        if(isset($_POST['DriveStyle'])){
                            if($_POST['DriveStyle']=="OnRoad"){
                                $DriveStyle=1;
                            }else{
                                $DriveStyle=0;
                            }
                        }else{
                            $DriveStyle=$c['DriveStyle'];
                        }

                        if(isset($_POST['EnergyType'])){
                            $EnergyType=$_POST['EnergyType'];
                        }else{
                            $EnergyType=$c['EnergyType'];
                        }

                        if(isset($_POST['Convertible'])){
                            if($_POST['Convertible']=="Yes"){
                                $Convertible=1;
                            }else{
                                $Convertible=0;
                            }
                        }else{
                            $Convertible=$c['Convertible'];
                        }

                        if(isset($_POST['Branch'])){
                            $Branch=$_POST['Branch'];
                        }else{
                            $Branch=$c['Branch'];
                        }

                        if(isset($_POST['AirConditioner'])){
                            if($_POST['AirConditioner']=="Yes"){
                                $AirConditioner=1;
                            }else{
                                $AirConditioner=0;
                            }
                        }else{
                            $AirConditioner=$c['AirConditioner'];
                        }

                        if(isset($_POST['DriveType'])){
                            $DriveType=$_POST['DriveType'];
                        }else{
                            $DriveType=$c['DriveType'];
                        }

                        if(!empty($_FILES['VehicleImage']['name'])){
                            $VehicleImage=$_FILES['VehicleImage']['name'];
                            $VehicleImage=time()."_".$VehicleImage;
                            move_uploaded_file($_FILES['VehicleImage']['tmp_name'],"Pictures/$VehicleImage");
                        }else{
                            $VehicleImage=$c['Image'];
                        }

                        if(!empty($_FILES['VehicleInside1']['name'])){
                            $InteriorImage1=$_FILES['VehicleInside1']['name'];
                            $InteriorImage1=time()."_".$InteriorImage1;
                            move_uploaded_file($_FILES['VehicleInside1']['tmp_name'],"Pictures/$InteriorImage1");
                        }else{
                            $InteriorImage1=$c['VehicleInside1'];
                        }

                        if(!empty($_FILES['VehicleInside2']['name'])){
                            $InteriorImage2=$_FILES['VehicleInside2']['name'];
                            $InteriorImage2=time()."_".$InteriorImage2;
                            move_uploaded_file($_FILES['VehicleInside2']['tmp_name'],"Pictures/$InteriorImage2");
                        }else{
                            $InteriorImage2=$c['VehicleInside2'];
                        }

                        if(!empty($_FILES['VehicleInside3']['name'])){
                            $InteriorImage3=$_FILES['VehicleInside3']['name'];
                            $InteriorImage3=time()."_".$InteriorImage3;
                            move_uploaded_file($_FILES['VehicleInside3']['tmp_name'],"Pictures/$InteriorImage3");
                        }else{
                            $InteriorImage3=$c['VehicleInside3'];
                        }

                        if(!empty($_FILES['VehicleInside4']['name'])){
                            $InteriorImage4=$_FILES['VehicleInside4']['name'];
                            $InteriorImage4=time()."_".$InteriorImage4;
                            move_uploaded_file($_FILES['VehicleInside4']['tmp_name'],"Pictures/$InteriorImage4");
                        }else{
                            $InteriorImage4=$c['VehicleInside4'];
                        }

                        if(!empty($_FILES['VehicleLogo']['name'])){
                            $VehicleLogo=$_FILES['VehicleLogo']['name'];
                            $VehicleLogo=time()."_".$VehicleLogo;
                            move_uploaded_file($_FILES['VehicleLogo']['tmp_name'],"Pictures/$VehicleLogo");
                        }else{
                            $VehicleLogo=$c['VehicleLogo'];
                        }


                        if($message==""){
                            mysqli_query($con,"UPDATE Vehicle SET VehicleType='$VehicleType' , NumberPlate='$NumberPlate' , VehicleBrand='$VehicleBrand' , Image='$VehicleImage' , PricePerDay='$PricePerDay' , GearBox='$GearBox' , Seats='$Seats' , Doors='$Doors' , DriveStyle='$DriveStyle' ,Miles='$Miles' , Color='$Color' , Convertible='$Convertible' , EnergyType='$EnergyType' 
                            , HorsePower='$HorsePower' , VehicleName='$VehicleName' , MaxSpeed='$MaxSpeed' , DriveType='$DriveType' , TankSize='$TankSize' , AirConditioner='$AirConditioner' , VehicleInside1='$InteriorImage1' , VehicleInside2='$InteriorImage2' , VehicleInside3='$InteriorImage3' , VehicleInside4='$InteriorImage4' , VehicleLogo='$VehicleLogo' WHERE Id='$VId'");
                        }
                        break;
                    }
                }

                if(!$found){
                    $message="<h2>Vehicle ID Not Found!!!</h2>";
                }
        }else{
            $message.="<h2>You Have To Enter Vehicle ID, You Can Check It In Vehicles Details Page</h2>\n";
        }
    }else if(isset($_POST['Delete'])){
        if(isset($_POST['VehicleId']) && trim($_POST['VehicleId'])!=""){
                $VId=$_POST['VehicleId'];
                $found=false;
                $Delete=mysqli_query($con,"SELECT * FROM Vehicle");
                while($D=mysqli_fetch_array($Delete)){
                    if($D['Id']==trim($VId)){
                        $found=true;
                    }
                }

                if($found){
                    $Deleted=mysqli_query($con,"DELETE FROM Vehicle WHERE Id=$VId");
                    if($Deleted){
                        $message2.="<h3>Vehicle Deleted Successful</h3>\n";
                    }else{
                        $message.="<h2>Vehicle didnt Deleted try again</h2>\n";
                    }
                }else{
                    $message.="<h2>Vehicle ID is didnt found</h2>\n";
                }
        }else{
            $message="<h2>You Have To Enter Vehicle ID, You Can Check It In Vehicles Details Page</h2>";
        }
    }

    if($message!=""){
        $_SESSION['ErrorMessage']=$message;
        header("Location: ManagerVehicleManagement.php");
        exit(); 
    }else if($message2!=""){
        $_SESSION['successfulMessage']=$message2;
        header("Location: ManagerVehicleManagement.php");
        exit(); 
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <style>
            body{
                font-family: Arial;
                margin: 0px;
                height: 100vh;
                display:flex;
                justify-content: center;
                align-items: center;
                font-size: 17px;
                background-color: #d8efef;
            }
            .Css1{
                margin-top: 50px;
            }
            .Css2{
                display:flex;
                gap:20px;
            }
            .Css3{
                box-shadow: 0 0 20px rgb(0, 0, 0,1);
                padding:10px;
                border-radius: 10px;
                background-color: white;
                display:flex;
                gap:10px;
            }
            .Css4{
                display:flex;
                flex-direction: column;
                gap:10px;
                
            }
            .Css5{
                padding:10px;
                background-color: ;
                display:flex;
                gap:50px;                
            }
            .errormessagecss{
                overflow:auto;
                height: 200px;
                background-color: #e49696;
                border: 5px red solid;
                border-radius: 10px;
                margin-bottom: 20px;
            }
            .successfulMessagecss{
                height: 200px;
                background-color: #9eeaa3;
                border: 5px green solid;
                border-radius: 10px;
                margin-bottom: 20px;
            }
            .Shadow{
                box-shadow: 0 0 20px;
                border-radius: 10px;
                background-color: white;
            }
            h1{
                text-align: center;
                margin-bottom: 50px;
            }
            h2{
                color: red;
                text-align: center;
                font-size: 20px;
            }
            h3{
                color: green;
                text-align: center;
                font-size: 20px;
            }            
            label{
                display:block;
                text-align: center;
            }
            input[name="VehicleId"]{
                width:200px;
            }
            #Imagelabel{
                display:block;
                text-align: left;
            }
            #DeleteButton{
                border:2px solid red;
                border-radius: 5px;
                color:red;
                font-size:15px;
                padding:5px;
                padding-left: 5px;
                padding-right: 5px;
                background-color: #ffb1b1;      
            }
            #DeleteButton:hover{
                background-color: red;
                color:white;
            }
            #ChangeButton:hover{
                border:2px solid blue;
                color:blue;
            }
            #AddVehicleButton{
                border:2px solid black;
                border-radius: 5px;
                background-color: #294dff;
                color:white;
                font-size:15px;
                padding:5px;
                padding-left: 5px;
                padding-right: 5px;
            }
            #AddVehicleButton:hover{
                background-color: #002aff;
            }
        </style>
    </head>
    <body>
        <div class="Css1">
            <h1>Vehicle Management</h1>
            <?php 
                if(isset($_SESSION['ErrorMessage'])){
                    echo "<div class='errormessagecss'>".$_SESSION['ErrorMessage']."</div>";
                    unset($_SESSION['ErrorMessage']);
                }else if(isset($_SESSION['successfulMessage'])){
                    echo "<div class='successfulMessagecss'>".$_SESSION['successfulMessage']."</div>";
                    unset($_SESSION['successfulMessage']);
                }
            ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="Css2">
                    <div class="Css3">
                        <div class="Css4">
                            <div>
                                <label>Vehicle Brand:</label>
                                <input type="text" name="VehicleBrand" >
                            </div>
                            <div>
                                <label>Color:</label>
                                <input type="text" name="Color" >
                            </div>
                            <div>
                                <label>Vehicle Name:</label>
                                <input type="text" name="VehicleName" >
                            </div>
                            <div>
                                <label>Number Plate:</label>
                                <input type="text" name="NumberPlat" >
                            </div> 
                            <div>
                                <label>Price Per Day:</label>
                                <input type="number" name="PricePerDay" >
                            </div>
                            <div>
                                <label>Seats:</label>
                                <input type="number" name="Seats" >
                            </div>
                        </div>
                        <div class="Css4">
                            <div>
                                <label>Doors:</label>
                                <input type="number" name="Doors" >
                            </div>
                            <div>
                                <label>Miles:</label>
                                <input type="number" name="Miles" >
                            </div>
                            <div>
                                <label>Horse Power:</label>
                                <input type="number" name="HorsePower" >
                            </div>
                            <div>
                                <label>Max Speed:</label>
                                <input type="number" name="MaxSpeed" >
                            </div>
                            <div>
                                <label>Tank Size:</label>
                                <input type="number" name="TankSize" >
                            </div>
                        </div>
                    </div>
                    <div class="Shadow">
                        <div class="Css5">
                            <div>
                                <label>Vehicle Type:</label>
                                <input type="radio" name="VehicleType" value="Car" >Car
                                <input type="radio" name="VehicleType" value="Van">Van
                            </div>
                            <div>
                                <label>Gear Box:</label>
                                <input type="radio" name="GearBox" value="Automatic" >Automatic
                                <input type="radio" name="GearBox" value="Manual">Manual
                            </div>
                            <div>
                                <label>Drive Style:</label>
                                <input type="radio" name="DriveStyle" value="OffRoad" >OffRoad
                                <input type="radio" name="DriveStyle" value="OnRoad">OnRoad
                            </div>
                        </div>
                        <div class="Css5">
                            <div>
                                <label>Energy Type:</label>
                                <input type="radio" name="EnergyType" value="Gas" >Gas
                                <input type="radio" name="EnergyType" value="Electric">Electric
                                <input type="radio" name="EnergyType" value="Hybrid">Hybrid
                            </div>
                            <div>
                                <label>Convertible:</label>
                                <input type="radio" name="Convertible" value="Yes" >Yes
                                <input type="radio" name="Convertible" value="No">No
                            </div>
                            <div>
                                <label>Branch:</label>
                                <input type="radio" name="Branch" value="Haifa" >Haifa
                                <input type="radio" name="Branch" value="Tel-Aviv">Tel-Aviv
                                <input type="radio" name="Branch" value="Rama">Rama
                            </div>                                    
                        </div>
                        <div class="Css5">
                            <div>
                                <label>Air Conditioner:</label>
                                <input type="radio" name="AirConditioner" value="Yes" >Yes
                                <input type="radio" name="AirConditioner" value="No">No
                            </div>
                            <div>
                                <label>Drive Type:</label>
                                <input type="radio" name="DriveType" value="FWD" >FWD(Front-Wheel Drive)
                                <input type="radio" name="DriveType" value="RWD">RWD(Rear-Wheel Drive)
                                <input type="radio" name="DriveType" value="AWD">AWD(All-Wheel Drive)
                                <input type="radio" name="DriveType" value="4WD">4WD(Four-Wheel Drive)
                            </div>
                        </div>
                        <div class="Css5">
                            <div>
                                <label id="Imagelabel">Vehicle Image:</label>
                                <input type="file" name="VehicleImage" >
                            </div>
                            <div>
                                <label id="Imagelabel">Interior Image 1:</label>
                                <input type="file" name="VehicleInside1" >
                            </div>
                            <div>
                                <label id="Imagelabel">Interior Image 2:</label>
                                <input type="file" name="VehicleInside2" >
                            </div>
                        </div>
                        <div class="Css5">
                            <div id="f">
                                <label id="Imagelabel">Interior Image 3:</label>
                                <input type="file" name="VehicleInside3" >
                            </div>
                            <div>
                                <label id="Imagelabel">Interior Image 4:</label>
                                <input type="file" name="VehicleInside4">
                            </div>
                            <div>
                                <label id="Imagelabel">Vehicle Logo:</label>
                                <input type="file" name="VehicleLogo">                                
                            </div>
                        </div>
                        <div class="Css5">
                            <div>
                                <input type="number" name="VehicleId" placeholder="Enter Vehicle ID to change or Delete...">
                                <button id="ChangeButton" type="submit" name="Change">Change</button>
                            </div>
                            <button id="DeleteButton" type="submit" name="Delete">Delete</button>
                            <button id="AddVehicleButton" type="submit" name="AddVehicle">Add Vehicle</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>