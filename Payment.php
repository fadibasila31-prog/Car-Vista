<?php
    include "Nav.php";
    $con=OpenCon();
    $VehicleId=$_SESSION['VehicleId'];
    $CustomerId=$_SESSION['UserId'];
    $gmail=$_SESSION['Gmail'];
    $branch=$_SESSION['Branch'];
    $return2="";
    $pickup2="";
    

    if(isset($_SESSION['StartUse'])){
        $pickup=$_SESSION['StartUse'];
    }else{
        $pickup="";
    }
    
    if(isset($_SESSION['EndUse'])){
        $return=$_SESSION['EndUse'];
    }else{
        $return="";
    }

    $message="";
    $TotalPrice=1;
    $HaveDriverLicense="";

    if(isset($_POST['ChangeDates'])){
        if(isset($_POST['pickup'])){
            $pickup2=strtotime($_POST['pickup']);
        }

        if(isset($_POST['return'])){
            $return2=strtotime($_POST['return']);
        }

        if($return2 > $pickup2){
            $_SESSION['StartUse']=$_POST['pickup'];
            $_SESSION['EndUse']=$_POST['return'];
            header("Location:Payment.php");
            exit();
        }else{
            $message="The return date cannot be before the pickup date";
        }
    }

    if(isset($_POST['Pay'])){
        if(isset($_SESSION['HaveDriverLicense'])){  
            if($_SESSION['HaveDriverLicense']==0){
                $message="You Cant Rent a Vehicle, You Dont Have Driver License.";
                $HaveDriverLicense="You Cant Rent a Vehicle, You Dont Have Driver License.<br>";
            }else{
                $PN=$_POST['PhoneNumber'];
                $CN=$_POST['CardNumber'];
                $_SESSION['PN']=$PN;
                $_SESSION['CN']=$CN;
                $_SESSION['CVV']=$_POST['CVV'];
                $_SESSION['Location']=$_POST['Location'];
                $isSameNumber=false;
                $InvalCardNumber=false;
                $Active=false;
                $pickup2=strtotime($pickup);
                $return2=strtotime($return);

                $Booking=mysqli_query($con,"SELECT * FROM Booking");
                while($b=mysqli_fetch_array($Booking)){
                    if($b['VehicleId']==$VehicleId){
                        if((($pickup2>=strtotime($b['StartDate']) && $pickup2<=strtotime($b['EndDate'])) || ($return2>=strtotime($b['StartDate']) && $return2<=strtotime($b['EndDate']))) && $b['Status']!="Canceled"){
                            $Active=true;
                            $message .= "Someone has already booked this vehicle for the selected dates. Please choose different dates.";
                            break;
                        }else if($pickup2<strtotime($b['StartDate']) && $return2>strtotime($b['EndDate']) && $b['Status']!="Canceled"){
                            $Active=true;
                            $message .= "Someone has already booked this vehicle for the selected dates. Please choose different dates.";
                            break;
                        }
                    }
                }

                if(!$Active){

                    $age=0;
                    if(isset($_SESSION['Age'])){
                        $age=$_SESSION['Age'];
                    }

                    $Users=mysqli_query($con,"SELECT * FROM Users");
                    while($u=mysqli_fetch_array($Users)){
                        if($u['Id']==$CustomerId){
                            if($u['PhoneNumber']==$PN){
                                $isSameNumber=true;
                                break;
                            }
                        }
                   }

                    for($i=0;$i<strlen($CN);$i++){
                        if(!($CN[$i]>='0' && $CN[$i]<='9')){
                            $InvalCardNumber=true;
                            break;
                        }
                    }
                    
                    

                    if($isSameNumber==false){
                        $message="The phone number does not match the phone number registered to your account.";
                    }else if($age<18){
                        $message="You must be at least 18 years old to rent a vehicle.";
                    }else if($InvalCardNumber || strlen($CN)!=16){
                        $message="The card number must contain exactly 16 digits.";
                    }else if(!isset($_SESSION['Location']) || $_SESSION['Location']=="-"){
                        $message="Please select a pickup location.";
                    }else if(!isset($_SESSION['StartUse']) || !isset($_SESSION['EndUse'])){
                        $message="Please select both pickup and return dates.";
                    }else{
                        $to=$gmail;
                        $message2="";
                        $subject = "Car Rental Booking Confirmation";
                        $pickup2="";
                        $return2="";

                        $pickup2=strtotime($pickup);
                        $return2=strtotime($return);
                        
                        $BD="";
                        if(isset($_SESSION['BirthDay'])){
                            $BD=$_SESSION['BirthDay'];
                        }

                        $PickupYear=(int)date("Y",strtotime($pickup));
                        $ReturnYear=(int)date("Y",strtotime($return));
                        $PickupMonth=(int)date("m",strtotime($pickup));
                        $ReturnMonth=(int)date("m",strtotime($return));
                        $PickupDay=(int)date("d",strtotime($pickup));
                        $ReturnDay=(int)date("d",strtotime($return));
                        $BDMonth="";
                        $BDDay="";

                        if($BD!=""){
                            $BDMonth=(int)date("m",strtotime($BD));
                            $BDDay=(int)date("d",strtotime($BD));
                        }
                        
                        $GotDiscount=false;

                        if($BD!=""){
                            if($PickupYear==$ReturnYear){
                                if($PickupMonth==$ReturnMonth){
                                    if($PickupDay<=$BDDay && $ReturnDay>=$BDDay){
                                        $GotDiscount=true;
                                    }
                                }else{
                                    if($PickupMonth<$BDMonth && $ReturnMonth>$BDMonth){
                                        $GotDiscount=true;
                                    }else if($PickupMonth==$BDMonth){
                                        if($PickupDay<=$BDDay){
                                            $GotDiscount=true;
                                        }
                                    }else if($ReturnMonth==$BDMonth){
                                        if($ReturnDay>=$BDDay){
                                            $GotDiscount=true;
                                        }
                                    }
                                }
                            }else if($PickupYear+2<=$ReturnYear){
                                $GotDiscount=true;
                            }else{
                                if($PickupMonth==$ReturnMonth){
                                    if($PickupDay<=$BDDay && $ReturnDay>=$BDDay){
                                        $GotDiscount=true;
                                    }
                                }
                                if($PickupMonth==$BDMonth){
                                    if($PickupDay<=$BDDay){
                                        $GotDiscount=true;
                                    }
                                }else if($PickupMonth<$BDMonth){
                                    $GotDiscount=true;
                                }
                                
                                if($ReturnMonth==$BDMonth){
                                    if($ReturnDay>=$BDDay){
                                        $GotDiscount=true;
                                    }
                                }else if($ReturnMonth>$BDMonth){
                                    $GotDiscount=true;
                                }
                            }
                        }

                        $diff=(($return2-$pickup2)/60/60/24)+1;
                        $Vehicles=mysqli_query($con,"SELECT * FROM Vehicle");
                        while($v=mysqli_fetch_array($Vehicles)){
                            if($v['Id']==$VehicleId){
                                $TotalPrice=$diff * $v['PricePerDay'];
                                if($GotDiscount){
                                    $TotalPrice=$TotalPrice*0.90;
                                }
                                break;
                            }
                        }
            

                        $Vehicles=mysqli_query($con,"SELECT * FROM Vehicle");
                        while($v=mysqli_fetch_array($Vehicles)){
                            if($v['Id']==$VehicleId){
                                $Customers=mysqli_query($con,"SELECT * FROM Users");
                                while($c=mysqli_fetch_array($Customers)){
                                    if($c['Id']==$CustomerId){
                                        $message2 = "
                                        Thank you for choosing our Car Rental Service.

                                        Your payment has been received successfully, and your reservation has been confirmed.

                                        Reservation Details

                                        Customer: ".$c['FirstName']." ".$c['LastName']."
                                        Email: ".$gmail."
                                        Vehicle: ".$v['VehicleBrand']." ".$v['VehicleName']."
                                        Vehicle Type: ".$v['VehicleType']."
                                        Pickup Branch: ".$branch;
                                        if(isset($_SESSION['Location'])){
                                            $message2.="Location: ".$_SESSION['Location'];
                                        }
                                        $message2.= "Pickup Date & Time: ".$pickup."
                                        Return Date & Time: ".$return."
                                        Price Per Day: $".$v['PricePerDay'];

                                        if($GotDiscount){
                                            $Subtotal = $diff * $v['PricePerDay'];
                                            $Discount = $Subtotal * 0.10;
                                            $message2 .= "
                                            Subtotal: $".$Subtotal."
                                            Birthday Discount (10%): -$".$Discount;
                                        }

                                        $message2.="
                                        Total Amount Paid: $".$TotalPrice."
                                        Please arrive at the pickup branch on time and bring:
                                        - Your driver's license.
                                        - A valid photo ID.
                                        - The payment card used for this booking.

                                        If you need to cancel your reservation, you can do so through your account by visiting the Rental History page on our website.

                                        Thank you for choosing our Car Rental Service.
                                        We wish you a safe and enjoyable journey!";
                                    }
                                }
                            }
                        }

                        $header="From: fadibasila31@gmail.com";
                        $retval=mail($to,$subject,$message2,$header);
                        if($retval){
                            mysqli_query($con,"INSERT INTO Booking (CustomerId,	VehicleId,StartDate,EndDate,Status,CreatedAt,UpdatedAt,TotalPrice,RatingStatus) 
                            value ($CustomerId,$VehicleId,'$pickup','$return','Waiting',NOW(),NOW(),$TotalPrice,'Not Rated')");
                            unset($_SESSION['PN']);
                            unset($_SESSION['CVV']);
                            unset($_SESSION['CN']);
                            header("Location: Index.php");
                            exit();
                        }else{
                        $message="The booking confirmation could not be sent. Please try again.";
                        }
                    }
                }
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
                margin: 0px;
                margin-top: 150px;
                margin-bottom: 100px;
                background-color: #adacac;
            }
            .Css1{
                display: flex;
                justify-content: center;
            }
            .Css2{
                display: flex;
                gap:20px;
            }
            .Css3{
                padding-left:10px;
                padding-right:10px;
                padding-bottom:10px;
                background-color: white;
                border-radius: 10px;
                box-shadow:-10px 10px 20px black;
            }
            .Css3 button{
                border-radius: 5px;
            }
            .Css3 button[name="Pay"]:hover{
                background-color: green;
                color:white;
            }
            .Css3 button[name="ChangeDates"]:hover{
                background-color: blue;
                color:white;
            }
            .Css3 a{
                display: block;
                margin-top: 50px;
                margin-left:15px;
                margin-right: 440px;
                text-decoration: none;
                background-color: #e9e9e9;
                border: 2px solid black;
                border-radius: 5px;
                color:black;
                padding-top: 5px;
                padding-left: 10px;
                padding-bottom:5px;
                padding-right: 5px;
            }
            .Css3 a:hover{
                border:2px solid blue;
                color:blue;
                background-color: white;
            }
            h1{
                text-align: center;
                color: #2929f9;;
                background-color: #e9e9e9;
                padding:5px 10px 5px 10px;
                border-radius: 5px;
                display:flex;
                justify-self: center;
            }
            h3{
               margin-top: 5px;
               display:inline-block;
            }
            h4{
                color:red;
                border-radius: 10px;
                border:2px solid red;
                background-color: #fda0a0;
                display: flex;
                justify-self: center;
                padding:5px 10px 5px 10px;
            }
            input{
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <?php if($message!=""){echo "<h4>".$message."</h4>";} ?>
        <div class="Css1">
            <div class="Css2">
                <div class="Css3">
                    <h1>Car Informations</h1><br>
                    <?php 
                        $cars=mysqli_query($con,"SELECT * FROM Vehicle");
                        while($car=mysqli_fetch_array($cars)){
                            if($car['Id']==$VehicleId){
                                if($car['Rating']!=0){
                                    echo"Rating: ";
                                    for($i=0;$i<$car['Rating'];$i++){
                                        echo "⭐";
                                    }   
                                }else{
                                    echo "No ratings yet";
                                }
                                echo"<br>
                                Branch: ".$_SESSION['Branch']."<br>";
                                if(!isset($_SESSION['Location']) || $_SESSION['Location']=="-"){
                                    echo "<h4>Please Select a Location</h4>";
                                }else{
                                    echo "Location: ".$_SESSION['Location']."<br>";
                                }
                                echo "Vehicle Type: ".$car['VehicleType']."<br>
                                Vehicle Brand: ".$car['VehicleBrand']."<br>
                                Vehicle Name:".$car['VehicleName']."<br>
                                Price Per Day: $".$car['PricePerDay']."<br>
                                Gear Box: ".$car['GearBox']."<br>
                                Seats: ".$car['Seats']."<br>
                                Doors: ".$car['Doors']."<br>
                                Miles: ".$car['Miles']."<br>
                                Color: ".$car['Color']."<br>
                                Horse Power: ".$car['HorsePower']."<br>
                                Energy Type: ".$car['EnergyType']."<br>
                                Max Speed: ".$car['MaxSpeed']."<br>
                                Drive Type: ".$car['DriveType']."<br>
                                Tank Size: ".$car['TankSize']."<br>";
                                if($car['AirConditioner']==1){
                                    echo "A/C <br>";
                                }
                                if($car['Convertible']==1){
                                    echo "Convertible <br>";
                                }
                                echo "Pickup from: ".$branch;
                                break;
                            }
                        }
                    ?>
                </div>
                
                <div class="Css3">
                    <form method="post">
                        <h1>Payment & Booking</h1><br>
                        <label><input type="tel" name="PhoneNumber" placeholder="Phone Number...." <?php if(isset($_SESSION['PN'])){$PN=$_SESSION['PN']; echo "value='$PN'";}?> required></label>
                        <label><input type="text" name="CardNumber" placeholder="Card Number...." <?php if(isset($_SESSION['CN'])){$CN=$_SESSION['CN']; echo "value='$CN'";}?> required></label>
                        <label><input type="tel" name="CVV" pattern="[0-9]{3,4}" placeholder="CVV..." <?php if(isset($_SESSION['CVV'])){$CVV=$_SESSION['CVV']; echo "value='$CVV'";}?> required></label><br><br>
                        <?php
                            if(isset($_SESSION['Branch'])){
                                echo "<label>Pick up Location:</label>
                                <select name='Location' required>
                                    <option value='-'>-</option>";
                                    if($_SESSION['Branch']=="Haifa"){
                                        echo "<option value='CarmelCenter' "; if(isset($_SESSION['Location']) && $_SESSION['Location']=="CarmelCenter"){echo "selected";} echo ">Carmel Center</option>
                                        <option value='Hadar' "; if(isset($_SESSION['Location']) && $_SESSION['Location']=="Hadar"){echo "selected";} echo ">Hadar</option>
                                        <option value='RamatAlon' "; if(isset($_SESSION['Location']) && $_SESSION['Location']=="RamatAlon"){echo "selected";} echo ">Ramat Alon</option>";
                                    }else if($_SESSION['Branch']=="Tel Aviv"){
                                        echo "<option value='Dizengoff' "; if(isset($_SESSION['Location']) && $_SESSION['Location']=="Dizengoff"){echo "selected";} echo ">Dizengoff</option>
                                        <option value='Rothschild' "; if(isset($_SESSION['Location']) && $_SESSION['Location']=="Rothschild"){echo "selected";} echo ">Rothschild</option>
                                        <option value='Jaffa' "; if(isset($_SESSION['Location']) && $_SESSION['Location']=="Jaffa"){echo "selected";} echo ">Jaffa</option>";
                                    }else if($_SESSION['Branch']=="Jerusalem"){
                                        echo "<option value='CityCenter' "; if(isset($_SESSION['Location']) && $_SESSION['Location']=="CityCenter"){echo "selected";} echo ">City Center</option>
                                        <option value='Talpiot' "; if(isset($_SESSION['Location']) && $_SESSION['Location']=="Talpiot"){echo "selected";} echo ">Talpiot</option>
                                        <option value='Malha' "; if(isset($_SESSION['Location']) && $_SESSION['Location']=="Malha"){echo "selected";} echo ">Malha</option>";
                                    }
                                echo "</select>";
                            }
                        ?>
                        <button type="submit" name="Pay">Pay</button>
                    </form>
                    
                    <form method="post">
                        <h2>Change Pickup date:</h2>
                        <input type="date" min="<?php echo date('Y-m-d',strtotime('+1 day'));?>" name="pickup" required>
                        <h2>Change Return date:</h2>
                        <input type="date" min="<?php echo date('Y-m-d',strtotime('+2 day'));?>" name="return" required>
                        <button type="submit" name="ChangeDates">Change Dates</button>
                    </form>
                    <a href="VehicleDetails.php"><-- Go Back</a>
                </div>
                <div class="Css3">
                    <h1>Renter Datails</h1>
                    <?php
                        $pickup2="";
                        $return2="";
                        $customers=mysqli_query($con,"SELECT * FROM Users");
                        while($c=mysqli_fetch_array($customers)){
                            if($c['Gmail']==$gmail){
                                echo "<h3>Full Name: ".$c['FirstName']." ".$c['LastName']."</h3><br>
                                <h3>Gmail: ".$c['Gmail']."</h3><br>
                                <h3>Birth Day: ".$c['BirthDay']."</h3><br>";

                                for($i=0;$i<strlen($pickup);$i++){
                                    if($pickup[$i]=='T'){
                                        $pickup2.=" ";
                                    }else{
                                        $pickup2.=$pickup[$i];
                                    }
                                }

                                for($i=0;$i<strlen($return);$i++){
                                    if($return[$i]=='T'){
                                        $return2.=" ";
                                    }else{
                                        $return2.=$return[$i];
                                    }
                                }

                                echo $HaveDriverLicense."<h3>Rental Dates: ".$pickup2." - ".$return2."</h3><br>";
                                $pickup2=strtotime($pickup);
                                $return2=strtotime($return);
                                $diff=(($return2-$pickup2)/60/60/24)+1;
                                $Vehicles=mysqli_query($con,"SELECT * FROM Vehicle");
                                while($v=mysqli_fetch_array($Vehicles)){
                                    if($v['Id']==$VehicleId){
                                        $TotalPrice=$diff * $v['PricePerDay'];
                                        echo "<h3 style='color:green; font-size:25px;'>$".$TotalPrice."</h3>";
                                        break;
                                    }
                                }
                                break;
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>