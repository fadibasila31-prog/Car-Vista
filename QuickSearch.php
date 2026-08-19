<?php
    include "Nav.php";

    $message="";

    $arr=[];
    $Vehicles=mysqli_query($con,"SELECT * FROM Vehicle");
    while($v=mysqli_fetch_array($Vehicles)){
        $found=false;
        foreach($arr as $a){
            if($a['Branch']==$v['Branch']){
                $found=true;
            }
        }
        if(!$found){
            $arr[]=$v;
        }
    }


    if(isset($_POST['Q1Next'])){
        if(isset($_POST['VehicleType'])){
            $_SESSION['VehicleType']=$_POST['VehicleType'];
            $_SESSION['QuickSearchVehicleType']=$_POST['VehicleType'];
            $_SESSION['Q2']=true;
            header("Location: QuickSearch.php");
            exit();
        }
    }

    if(isset($_POST['Q2Next'])){
        if(isset($_POST['DriveStyle'])){
            $_SESSION['DriveStyle']=$_POST['DriveStyle'];
            $_SESSION['QuickSearchDriveStyle']=$_POST['DriveStyle'];
            $_SESSION['Q3']=true;
            unset($_SESSION['Q2']);
            header("Location: QuickSearch.php");
            exit();            
        }
    }else if(isset($_POST['Q2Prev'])){
        unset($_SESSION['Q2']);
        header("Location: QuickSearch.php");
        exit();
    }

    if(isset($_POST['Q3Next'])){
        if(isset($_POST['GearBox'])){
            $_SESSION['GearBox']=$_POST['GearBox'];
            $_SESSION['QuickSearchGearBox']=$_POST['GearBox'];
            $_SESSION['Q4']=true;
            unset($_SESSION['Q3']);
            $_SESSION['Q4']=true;
            header("Location: QuickSearch.php");
            exit();            
        }
    }else if(isset($_POST['Q3Prev'])){
        unset($_SESSION['Q3']);
        $_SESSION['Q2']=true;
        header("Location: QuickSearch.php");
        exit();
    }

    if(isset($_POST['Q4Next'])){
        if(isset($_POST['Seats']) && trim($_POST['Seats'])!="" && $_POST['Seats']>0){
            $_SESSION['Seats']=$_POST['Seats'];
            $_SESSION['QuickSearchSeats']=$_POST['Seats'];
            $_SESSION['Q5']=true;
            unset($_SESSION['Q4']);
            header("Location: QuickSearch.php");
            exit();
        }else{
            $message="Please enter a valid number of people traveling.";
        }
    }else if(isset($_POST['Q4Prev'])){
        unset($_SESSION['Q4']);
        $_SESSION['Q2']=true;
        header("Location: QuickSearch.php");
        exit();
    }

    if(isset($_POST['Q5Next'])){
        $_SESSION['QuickSearchBranch']=$_POST['Branch'];
        if(isset($_POST['Branch']) && $_POST['Branch']!="-"){
            $_SESSION['Branch']=$_POST['Branch'];
            $_SESSION['Q6']=true;
            unset($_SESSION['Q5']);
            header("Location: QuickSearch.php");
            exit();
        }else{
            $message="Please select a pickup branch.";
        }
    }else if(isset($_POST['Q5Prev'])){
        unset($_SESSION['Q5']);
        $_SESSION['Q4']=true;
        header("Location: QuickSearch.php");
        exit();
    }
    
    if(isset($_POST['Q6Next'])){
        $_SESSION['QuickSearchLocation']=$_POST['Location'];
        if(isset($_POST['Location']) && $_POST['Location']!="-"){
            $_SESSION['Location']=$_POST['Location'];
            $_SESSION['Q7']=true;
            unset($_SESSION['Q6']);
            header("Location: QuickSearch.php");
            exit();
        }else{
            $message="Please select a pickup location.";
        }
    }else if(isset($_POST['Q6Prev'])){
        unset($_SESSION['Q6']);
        $_SESSION['Q5']=true;
        header("Location: QuickSearch.php");
        exit();
    }
    
    if(isset($_POST['Search'])){
        $pickup=0;
        $return=0;

        if(isset($_POST['pickup'])){
            $pickup=strtotime($_POST['pickup']);
        }

        if(isset($_POST['return'])){
            $return=strtotime($_POST['return']);
        }
        
        $_SESSION['QuickSearchPickup']=$_POST['pickup'];
        $_SESSION['QuickSearchReturn']=$_POST['return'];

        if($return>$pickup){
            $_SESSION['StartUse']=$_POST['pickup'];
            $_SESSION['EndUse']=$_POST['return'];
            unset($_SESSION['Q7']);
            unset($_SESSION['QuickSearchVehicleType']);
            unset($_SESSION['QuickSearchDriveStyle']);
            unset($_SESSION['QuickSearchGearBox']);
            unset($_SESSION['QuickSearchSeats']);
            unset($_SESSION['QuickSearchBranch']);
            unset($_SESSION['QuickSearchLocation']);
            unset($_SESSION['QuickSearchPickup']);
            unset($_SESSION['QuickSearchReturn']);
            header("Location: VehiclesPage.php");
            exit();
        }else{
            $message="Return date must be after the pickup date.";
        }
    }else if(isset($_POST['Q7Prev'])){
        unset($_SESSION['Q7']);
        $_SESSION['Q6']=true;
        header("Location: QuickSearch.php");
        exit();
    }


    if(isset($_SESSION['Q2'])){
        echo "<div class='Css1'>
            <form method='POST'>
                <label>What type of driving will you be doing?</label>
                <div>
                    <input type='radio' name='DriveStyle' value='OnRoad' "; if(isset($_SESSION['QuickSearchDriveStyle']) && $_SESSION['QuickSearchDriveStyle']=="OnRoad"){echo " checked";} echo">OnRoad
                    <input type='radio' name='DriveStyle' value='OffRoad' "; if(isset($_SESSION['QuickSearchDriveStyle']) && $_SESSION['QuickSearchDriveStyle']=="OffRoad"){echo " checked";} echo" >OffRoad
                </div>
                <div class='Css3'>
                    <button type='submit' name='Q2Prev'>Prev</button>
                    <button type='submit' name='Q2Next'>Next</button>
                </div>
            </form>
        </div>";
    }else if(isset($_SESSION['Q3'])){
        echo "<div class='Css1'>
            <form method='POST'>
                <label>What type of Gear Box do you prefer?</label>
                <div>
                    <input type='radio' name='GearBox' value='Automatic' "; if(isset($_SESSION['QuickSearchGearBox']) && $_SESSION['QuickSearchGearBox']=="Automatic"){echo " checked";} echo">Automatic
                    <input type='radio' name='GearBox' value='Manual' "; if(isset($_SESSION['QuickSearchGearBox']) && $_SESSION['QuickSearchGearBox']=="Manual"){echo " checked";} echo" >Manual
                </div>
                <div class='Css3'>
                    <button type='submit' name='Q3Prev'>Prev</button>
                    <button type='submit' name='Q3Next'>Next</button>
                </div>
            </form>
        </div>";
    }else if(isset($_SESSION['Q4'])){
        echo "<div class='Css1'>
            <form method='POST'>";
                if($message!=""){
                    echo "<div class='Message'>".$message."</div>";
                }
                echo "<label>How many people will be traveling?</label>
                <input type='number' name='Seats'"; if(isset($_SESSION['QuickSearchSeats'])){$QuickSearchSeats=$_SESSION['QuickSearchSeats']; echo" value='$QuickSearchSeats'";}echo">
                <div class='Css3'>
                    <button type='submit' name='Q4Prev'>Prev</button>
                    <button type='submit' name='Q4Next'>Next</button>
                </div>
            </form>
        </div>";
    }else if(isset($_SESSION['Q5'])){
        echo "<div class='Css1'>";
            if($message!=""){
                echo "<div class='Message'>".$message."</div><br>";
            }
            echo "<form method='POST'>
                <label>Pick up Branch:</label>
                <select name='Branch' required>
                    <option value='-'>-</option>";
                    foreach($arr as $a){
                        echo "<option value='".$a['Branch']."' ";
                        if(isset($_SESSION['QuickSearchBranch']) && $_SESSION['QuickSearchBranch']==$a['Branch']){
                            echo " selected";
                        }
                        echo ">".$a['Branch']."</option>";
                    }
                echo "</select>
                <div class='Css3'>
                    <button type='submit' name='Q5Prev'>Prev</button>
                    <button type='submit' name='Q5Next'>Next</button>
                </div>
            </form>
        </div>";
    }else if(isset($_SESSION['Q6'])){
        echo "<div class='Css1'>";
            if($message!=""){
                echo "<div class='Message'>".$message."</div><br>";
            }
            echo "<form method='POST'>
                <label>Pick up Location:</label>
                <select name='Location' required>
                    <option value='-'>-</option>";
                    if($_SESSION['Branch']=="Haifa"){
                        echo "<option value='CarmelCenter'"; if(isset($_SESSION['QuickSearchLocation']) && $_SESSION['QuickSearchLocation']=="CarmelCenter"){ echo " selected";} echo">Carmel Center</option>
                        <option value='Hadar'"; if(isset($_SESSION['QuickSearchLocation']) && $_SESSION['QuickSearchLocation']=="Hadar"){ echo " selected";} echo">Hadar</option>
                        <option value='RamatAlon'"; if(isset($_SESSION['QuickSearchLocation']) && $_SESSION['QuickSearchLocation']=="RamatAlon"){ echo " selected";} echo">Ramat Alon</option>";
                    }else if($_SESSION['Branch']=="Tel Aviv"){
                        echo "<option value='Dizengoff'"; if(isset($_SESSION['QuickSearchLocation']) && $_SESSION['QuickSearchLocation']=="Dizengoff"){ echo " selected";} echo">Dizengoff</option>
                        <option value='Rothschild'"; if(isset($_SESSION['QuickSearchLocation']) && $_SESSION['QuickSearchLocation']=="Rothschild"){ echo " selected";} echo">Rothschild</option>
                        <option value='Jaffa'"; if(isset($_SESSION['QuickSearchLocation']) && $_SESSION['QuickSearchLocation']=="Jaffa"){ echo " selected";} echo">Jaffa</option>";
                    }else if($_SESSION['Branch']=="Jerusalem"){
                        echo "<option value='CityCenter'"; if(isset($_SESSION['QuickSearchLocation']) && $_SESSION['QuickSearchLocation']=="CityCenter"){ echo " selected";} echo">City Center</option>
                        <option value='Talpiot'"; if(isset($_SESSION['QuickSearchLocation']) && $_SESSION['QuickSearchLocation']=="Talpiot"){ echo " selected";} echo">Talpiot</option>
                        <option value='Malha'"; if(isset($_SESSION['QuickSearchLocation']) && $_SESSION['QuickSearchLocation']=="Malha"){ echo " selected";} echo">Malha</option>";
                    }
                echo "</select>
                <div class='Css3'>
                    <button type='submit' name='Q6Prev'>Prev</button>
                    <button type='submit' name='Q6Next'>Next</button>
                </div>
            </form>
        </div>";
    }else if(isset($_SESSION['Q7'])){
        echo "<div class='Css1'>";
            if($message!=""){
                echo "<div class='Message'>".$message."</div><br>";
            }
            echo "<form method='POST'>
                <div>
                    <label>Pickup date:</label>
                    <input type='date' min='".date('Y-m-d',strtotime('+1 day'))."' name='pickup'"; if(isset($_SESSION['QuickSearchPickup'])){$QuickSearchPickup=$_SESSION['QuickSearchPickup']; echo "value='$QuickSearchPickup'";} echo">
                </div>
                <div>
                    <label>Return date:</label>
                    <input type='date' min='".date('Y-m-d',strtotime('+2 day'))."' name='return'"; if(isset($_SESSION['QuickSearchReturn'])){$QuickSearchReturn=$_SESSION['QuickSearchReturn']; echo "value='$QuickSearchReturn'";} echo">
                </div>
                <div class='Css3'>
                    <button type='submit' name='Q7Prev'>Prev</button>
                    <button type='submit' name='Search'>Search</button>
                </div>
            </form>
        </div>";
    }else{
        echo "<div class='Css1'>
            <form method='POST'>
                <label>What type of car do you prefer?</label>
                <div>
                    <input type='radio' name='VehicleType' value='Car' "; if(isset($_SESSION['QuickSearchVehicleType']) && $_SESSION['QuickSearchVehicleType']=="Car"){echo " checked";} echo" required>Car
                    <input type='radio' name='VehicleType' value='Van' "; if(isset($_SESSION['QuickSearchVehicleType']) && $_SESSION['QuickSearchVehicleType']=="Van"){echo " checked";} echo" >Van
                </div>
                <div class='Css2'>
                    <button type='submit' name='Q1Next'>Next</button>
                </div>
            </form>
        </div>";
    }
?>
<!DOCTYPE HTML>
<html>
    <head>
        <style>
            body{
                display:flex;
                justify-self: center;
                align-items: center;
                height: 100vh;
                background-color: #c5c5c7;
            }
            .Css1{
                width:450px;
                background-color: white;
                padding:20px 40px 20px 40px;
                border-radius: 10px;
                box-shadow:-7px 7px 20px;
            }
            .Css1 form{
                display:flex;
                flex-direction: column;
                gap:40px;
                font-size: 20px;
            }
            .Css1 label{
                font-size: 25px;
                font-weight: bold;
            }
            .Css1 input[type="number"]{
                border-radius: 5px;
                width:250px;
                font-size:15;
            }
            .Css1 select{
                border-radius: 5px;
                width:250px;
                font-size:15px;
            }
            .Css1 button{
                border-radius: 5px;
                font-size: 20px;
            }
            .Css1 button:hover{
                border:2px solid blue;
                color:blue;
            }
            .Css2{
                text-align: right;
            }
            .Css3{
                display: flex;
                justify-content: space-between;
            }
            .Message{
                color:red;
                border:2px solid red;
                border-radius: 5px;
                background-color: #f7b7b7;
                text-align: center;
                padding:5px 10px 5px 10px;
            }
        </style>
    </head>
    <body>
    </body>
</html>