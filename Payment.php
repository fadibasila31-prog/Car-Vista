<?php
    include "Nav.php";
    $con=OpenCon();
    $VehicleId=$_SESSION['VehicleId'];
    $CustomerId=$_SESSION['UserId'];
    $gmail=$_SESSION['Gmail'];
    $branch=$_SESSION['Branch'];
    if(isset($_SESSION['StartUse'])){// true false
        $pickup=$_SESSION['StartUse'];
    }else{
        $pickup="";
    }
    
    if(isset($_SESSION['StartUse'])){// true false
        $return=$_SESSION['EndUse'];
    }else{
        $return="";
    }
    $message="";
    $TotalPrice=1;
    $HaveDriverLicense="";

    if(isset($_POST['ChangeDates'])){// true false
        if($return2 > $pickup2){// true false
            $_SESSION['StartUse']=$_POST['pickup'];
            $_SESSION['EndUse']=$_POST['return'];
        }else{
            $message="The return date cannot be before the pickup date";
        }
    }

    if(isset($_POST['Pay'])){// true false
        if(isset($_SESSION['HaveDriverLicense'])){  
            if($_SESSION['HaveDriverLicense']==0){
                $message="You Cant Rent a Vehicle, You Dont Have Driver License.";
                $HaveDriverLicense="You Cant Rent a Vehicle, You Dont Have Driver License.<br>";
            }else{
                $PN=$_POST['PhoneNumber'];
                $CN=$_POST['CardNumber'];
                $isSameNumber=false;
                $InvalCardNumber=false;
                $InUse=false;
                $pickup2=strtotime($pickup);
                $return2=strtotime($return);

                $Booking=mysqli_query($con,"SELECT * FROM Booking");
                while($b=mysqli_fetch_array($Booking)){
                    if($b['VehicleId']==$VehicleId){// true false
                        if(($pickup2>=strtotime($b['StartDate']) && $pickup2<=strtotime($b['EndDate'])) || ($return2>=strtotime($b['StartDate']) && $return2<=strtotime($b['EndDate']))){// true false
                            $InUse=true;
                            $message .= "Someone has already booked this vehicle for the selected dates. Please choose different dates.";
                            break;
                        }else if($pickup2<strtotime($b['StartDate']) && $return2>strtotime($b['EndDate'])){// true false
                            $InUse=true;
                            $message .= "Someone has already booked this vehicle for the selected dates. Please choose different dates.";
                            break;
                        }
                    }
                }

                if(!$InUse){// true false
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
                        if(!($CN[$i]>=0 && $CN[$i]<=9)){// true false
                            $InvalCardNumber=true;
                            break;
                        }
                    }
                    
                    

                    if($isSameNumber==false){// true false
                        $message="Check You'r Number Again.";
                    }else if($InvalCardNumber || strlen($CN)!=16){// true false
                        $message="Write your Card Number Again.";
                    }else{
                        $to=$gmail;
                        $message2="";
                        $subject = "Car Rental Booking Confirmation";
                        $pickup2="";
                        $return2="";
                
                        $pickup2=strtotime($pickup);
                        $return2=strtotime($return);
                        $diff=(($return2-$pickup2)/60/60/24)+1;
                        $Vehicles=mysqli_query($con,"SELECT * FROM Vehicle");
                        while($v=mysqli_fetch_array($Vehicles)){
                            if($v['Id']==$VehicleId){// true false
                                $TotalPrice=$diff * $v['PricePerDay'];
                                break;
                            }
                        }
            
                        $pickup2="";
                        $return2="";
                    
                        for($i=0;$i<strlen($pickup);$i++){
                            if($pickup[$i]=='T'){// true false
                                $pickup2.=" ";
                            }else{
                                $pickup2.=$pickup[$i];
                            }
                        }

                        for($i=0;$i<strlen($return);$i++){
                            if($return[$i]=='T'){// true false
                                $return2.=" ";
                            }else{
                                $return2.=$return[$i];
                            }
                        }

                        $Vehicles=mysqli_query($con,"SELECT * FROM Vehicle");
                        while($v=mysqli_fetch_array($Vehicles)){
                            if($v['Id']==$VehicleId){// true false
                                $Customers=mysqli_query($con,"SELECT * FROM Users");
                                while($c=mysqli_fetch_array($Customers)){
                                    if($c['Id']==$CustomerId){// true false
                                        $message2 = "
                                        Thank you for choosing our Car Rental Service.

                                        Your payment has been received successfully, and your reservation has been confirmed.

                                        Reservation Details

                                        Customer: ".$c['FirstName']." ".$c['LastName']."
                                        Email: ".$gmail."
                                        Vehicle: ".$v['VehicleBrand']." ".$v['VehicleName']."
                                        Vehicle Type: ".$v['VehicleType']."
                                        Pickup Branch: ".$branch."
                                        Pickup Date & Time: ".$pickup2."
                                        Return Date & Time: ".$return2."
                                        Price Per Day: $".$v['PricePerDay']."
                                        Total Amount Paid: $".$TotalPrice."

                                        Please arrive at the pickup branch on time and bring:
                                        - Your driver's license.
                                        - A valid photo ID.
                                        - The payment card used for this booking.

                                        If you need to cancel your reservation, you can do so through your account by visiting the Rental History page on our website.

                                        Thank you for choosing our Car Rental Service.
                                        We wish you a safe and enjoyable journey!
                                        ";
                                    }
                                }
                            }
                        }

                        $header="From: fadibasila31@gmail.com";
                        $retval=mail($to,$subject,$message2,$header);
                        if($retval){// true false
                            mysqli_query($con,"INSERT INTO Booking (CustomerId,	VehicleId,StartDate,EndDate,Status,CreatedAt,UpdatedAt,TotalPrice) 
                            value ($CustomerId,$VehicleId,'$pickup','$return','Confirmed',NOW(),NOW(),$TotalPrice)");
                            $_SESSION['PaymentSuccecfully']="Payment Succecfully";
                            header("Location: HomePage.php");
                            exit();
                        }else{
                        $message="Try again.";
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
                box-shadow:0px 0px 30px seashell;
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
        <div class="Css1">
            <div class="Css2">
                <div class="Css3">
                    <h1>Car Informations</h1><br>
                    <?php 
                        $cars=mysqli_query($con,"SELECT * FROM Vehicle");
                        while($car=mysqli_fetch_array($cars)){
                            if($car['Id']==$VehicleId){// true false
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
                                if($car['AirConditioner']==1){// true false
                                    echo "A/C <br>";
                                }
                                if($car['Convertible']==1){// true false
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
                        <?php if($message!=""){echo "<h4>".$message."</h4>";}// true false ?>
                        <h1>Payment & Booking</h1><br>
                        <label><input type="tel" name="PhoneNumber" placeholder="Phone Number...." required></label>
                        <label><input type="text" name="CardNumber" placeholder="Card Number...." required></label>
                        <label><input type="tel" name="CVV" pattern="[0-9]{3,4}" placeholder="CVV..." required></label>
                        <button type="submit" name="Pay">Pay</button>
                    </form>
                    
                    <form method="post">
                        <h2>Pickup date and time:</h2>
                        <input type="datetime-local" min="<?php echo date('Y-m-d\TH:i',strtotime('+1 day'));?>" name="pickup" required>
                        <h2>Return date and time:</h2>
                        <input type="datetime-local" min="<?php echo date('Y-m-d\TH:i',strtotime('+2 day'));?>" name="return" required>
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
                            if($c['Gmail']==$gmail){// true false
                                echo "<h3>Full Name: ".$c['FirstName']." ".$c['LastName']."</h3><br>
                                <h3>Gmail: ".$c['Gmail']."</h3><br>
                                <h3>Birth Day: ".$c['BirthDay']."</h3><br>";

                                for($i=0;$i<strlen($pickup);$i++){
                                    if($pickup[$i]=='T'){// true false
                                        $pickup2.=" ";
                                    }else{
                                        $pickup2.=$pickup[$i];
                                    }
                                }

                                for($i=0;$i<strlen($return);$i++){
                                    if($return[$i]=='T'){// true false
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
                                    if($v['Id']==$VehicleId){// true false
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