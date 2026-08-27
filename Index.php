 <?php
    $message="";
    include "Nav.php";
    $con=OpenCon();

    if(isset($_SESSION['UserId'])){
        if(!isset($_SESSION['CloseRating'])){
            $CustomerId=$_SESSION['UserId'];
            $RatingStatus=true;
            $VehicleStatus="";
            $VehicleId="";
            $BookingId="";
            $Rating=mysqli_query($con,"SELECT * FROM Booking WHERE CustomerId='$CustomerId'");
            while($R=mysqli_fetch_array($Rating)){
                if($R['CustomerId']==$CustomerId){
                    if($R['RatingStatus']=="Not Rated" && $R['Status']=="Finished"){
                        $RatingStatus=false;
                        $VehicleStatus=$R['Status'];
                        $VehicleId=$R['VehicleId'];
                        $BookingId=$R['BookingId'];
                        break;
                    }
                }
            }

            if(isset($_POST['CloseRating'])){
                if(isset($_POST['DontShowAgain'])){
                    mysqli_query($con,"UPDATE Booking SET RatingStatus='Skipped' WHERE BookingId='$BookingId'");
                }else{
                    $_SESSION['CloseRating']=true;
                }
                header("Location:Index.php");
                exit();
            }

            if(isset($_POST['Submit'])){
                if(isset($_POST['Rating'])  ){
                    $rate=$_POST['Rating'];
                    $UpadteRating="";
                    $TotalRating="";
                    $Vehicles=mysqli_query($con,"SELECT * FROM Vehicle");
                    while($v=mysqli_fetch_array($Vehicles)){
                        if($v['Id']==$VehicleId){
                            $UpadteRating=$v['Rating'];
                            $TotalRating=$v['TotalRating'];
                            $UpadteRating=(int)$UpadteRating;
                            $TotalRating=(int)$TotalRating;
                            break;
                        }
                    }

                    if($TotalRating!="" && $UpadteRating!=""){
                        $rate=(int)$rate;
                        $UpadteRating=(int)(($UpadteRating*$TotalRating+$rate)/++$TotalRating);
                        mysqli_query($con,"UPDATE Vehicle SET Rating='$UpadteRating' , TotalRating='$TotalRating' WHERE Id='$VehicleId'");
                        mysqli_query($con,"UPDATE Booking SET RatingStatus='Rated' WHERE BookingId='$BookingId'");
                        header("Location:Index.php");
                        exit();
                    }
                }else{
                    $_SESSION['RatingErrorMessage']="Please select a rating before submitting";
                    header("Location:Index.php");
                    exit();
                }
            }

            if(!$RatingStatus && $VehicleStatus=="Finished" && !isset($_SESSION['CloseRating'])){
                echo "<div class='Css6'>
                    <form method='POST'>
                        <button type='submit' name='CloseRating'>x</button><br><br>";
                        if(isset($_SESSION['RatingErrorMessage'])){
                            echo "<h3>".$_SESSION['RatingErrorMessage']."</h3><br>";
                            unset($_SESSION['RatingErrorMessage']);
                        }
                        echo"
                        <label>How was your rental experience?<br>
                        Please share your feedback and rate the vehicle you rented.</label><br>
                        <input type='radio' name='Rating' value='1'>⭐<br>
                        <input type='radio' name='Rating' value='2'>⭐⭐<br>
                        <input type='radio' name='Rating' value='3'>⭐⭐⭐<br>
                        <input type='radio' name='Rating' value='4'>⭐⭐⭐⭐<br>
                        <input type='radio' name='Rating' value='5'>⭐⭐⭐⭐⭐<br><br>
                        <input type='checkbox' name='DontShowAgain'>Dont Show This Again.<br>
                        <button type='submit' name='Submit'>Submit</button>
                    </form>
                </div>";
            }
        }else{
            unset($_SESSION['CloseRating']);
        }
        
    }
   
    if(isset($_POST['Search'])){
        if(isset($_POST['Type'])){
            $Branch=$_POST['Branch'];
            $_SESSION['VehicleType']=$_POST['Type'];
            $pickup=strtotime($_POST['pickup']);
            $return=strtotime($_POST['return']);
            if($Branch!=""){ 
                if($return>$pickup){
                    $_SESSION['Branch']=$Branch;
                    $_SESSION['StartUse']=$_POST['pickup'];
                    $_SESSION['EndUse']=$_POST['return'];
                    header("Location:VehiclesPage.php");
                    exit();
                }else{
                    $message="The return date cannot be before the pickup date";
                }
            }else{
                $message="Please select a branch";
            }
        }else{
            $message="Please select a vehicle type (Car or Van)";
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
                background: linear-gradient(to left,black 50%,gray 100%);
                margin-bottom: 100px;
            }
            .Css1{
                background-color: whitesmoke;
                margin-top: 230px;
                margin-right: 110px;
                margin-left: 300px;
                padding-top:15px;
                padding-bottom:15px;
                border-radius: 15px;
                box-shadow: 0px 20px 40px seashell;
            }
            .Css2{               
                margin-right: 100px;
                margin-left: 100px;
                background-color: #c5c5c7;
                padding-bottom: 10px;
                display: flex;
                justify-content: center;
                border-radius: 20px;
            }
            .Css2 input[type="radio"]{
                display: none;
            }
            .Css2 input[type="radio"]:checked + img{
                border-color:greenyellow ;
                border-width: 5px;
            }
            .Pic img{
                position: absolute;
                top: 100px;
                right: 110px;
                width: 380px;
                height: 120px;
            }
            .Css3{
                display: flex;
                align-items: center;
            }
            .Css4{
                display: flex;
                gap: 40px;
            }
            .Css5{
                display:flex;
                justify-content: space-between;
                display: flex;
            }
            .Css6{
                position: fixed;
                top:0px;
                width: 100%;
                height: 100%;
                background: #00000080;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .Css6 form{
                background-color: white;
                padding:20px;
                border-radius: 10px;
                border:3px solid blue;
            }
            .Css6 label{
                display: block;                
            }
            button{
                cursor: pointer;
            }
            form img.Car{
                width:120px;
                height: 100px;
                border-top-left-radius: 20px;
                border-bottom-left-radius: 20px;
                border-color: black;
                border-style: solid;  
                border-width: 2px;  cursor: pointer;
            }
            form img.Van{
                width:150px;
                height: 100px;
                border-top-right-radius: 20px;
                border-bottom-right-radius: 20px;
                border-color:black;
                border-style: solid;
                border-width: 2px;  
                cursor: pointer;
            }
            h1{
                font-size: 20px;
                margin-bottom: 0px;
            }  
            h2{
                background-color: #feb4b4;
                border-radius: 5px;
                color:red;
                font-size: 15px;
                border:2px solid red;
                margin-top: 10px;
                margin-left: 50px;
                padding:5px 10px 5px 10px;
            }
            h3{
                color:red;
                text-align: center;
                padding:5px 10px 5px 10px;
                background-color: #feb4b4;
                border-radius: 5px;
                border:2px solid red;
            }
            button[name="CloseRating"]{
                margin-left: 400px;
                border-radius: 15px;
                font-weight: bold;
            }
            button[name="CloseRating"]:hover{
                border-color: red;
                color:red;
            }
            input[type="checkbox"]{
                margin-top: 15px;
            }
            button[name="Submit"]{
                margin-top:10px;
                display:flex;
                justify-self: center;
            }
            button[name="Submit"]:hover{
                border-color: blue;
                color:blue;
            }
            p{
                color:white;
                font-size: 20px;
                font-weight: bold;
                margin-top: 100px;
                display:flex;
                align-items: flex-start;
                margin-left:50vh;;
            }
            #Search{
                margin-top:30px;
                margin-right: 10px;
                border-radius: 10px;
                font-size: 15px;
                font-weight: bold;
                padding-top:5px;
                padding-bottom:5px;
                padding-left: 15px;
                padding-right: 15px;
            }
            #Search:hover{
                border:2px solid blue;
                color:blue;
            }
        </style>
    </head>
    <body>
        <div class="Css1">
            <div class="Pic">
                <img src="Pictures/HomePageCar.png">
            </div>
            <div class="Css2">
                <form method="post">
                    <h1>Vehicle type (Car/Van):</h1>
                    <div class="Css3">
                        <label>
                            <input type="radio" name="Type" value="Car"> 
                            <img src="Pictures/Car.png" class="Car">
                        </label>
                        <label>
                            <input type="radio" name="Type" value="Van" >
                            <img src="Pictures/Van.jpg" class="Van">
                        </label>
                        <?php         
                            if($message!=""){echo "<h2>".$message."</h2>";}
                        ?>
                    </div>
                    <div class="Css4">
                        <div>
                        <h1>Pickup Branch:</h1>
                        <select name="Branch" required>
                            <option value="">-</option>
                            <?php
                            $arrlocations=[];
                            $locations=mysqli_query($con,"SELECT * FROM Vehicle");
                            while($L=mysqli_fetch_array($locations)){
                                $found=false;
                                for($i=0;$i<count($arrlocations);$i++){
                                    if($arrlocations[$i]==$L['Branch']){
                                        $found=true;
                                    }
                                }
                                if(!$found){
                                    $arrlocations[]=$L['Branch'];
                                    echo "<option value='".$L['Branch']."'>".$L['Branch']."</option>";
                                }
                                
                            }
                            ?>
                        </select>
                        </div>
                        <div>
                            <h1>Pickup date:</h1>
                            <input type="date" min="<?php echo date('Y-m-d',strtotime('+1 day'));?>" name="pickup" required>
                        </div>
                        <div>
                            <h1>Return date:</h1>
                            <input type="date" min="<?php echo date('Y-m-d',strtotime('+2 day'));?>" name="return" required>
                        </div>
                    </div>
                    
                    <button id="Search" type="submit" name="Search">Search</button>
                </form>
            </div>
        </div>
        
        <p>CarVista makes renting a car or van simple, convenient, and reliable. Choose your vehicle type, <br>pickup location, and rental dates to find the best vehicle for your journey. Explore our available<br> vehicles and enjoy an easy and comfortable rental experience from start to finish.</p>
    </body>
</html>