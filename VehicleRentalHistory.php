<?php
    include "Nav.php";
    $con=OpenCon();

    $message="";
    $StartDate="";
    $EndDate="";
    $Vehicle="";
    $Fname="";
    $Lname="";
    $Search="";
    $Search2="";
    $Search3="";
    $found=false;
    if(isset($_POST['Search'])){

        if(isset($_POST['VehicleType'])){
            $Vehicle=$_POST['VehicleType'];
            $Search="WHERE VehicleType='$Vehicle'";
        }
        
        if(isset($_POST['StartDate']) && $_POST['StartDate']!=""){
            $StartDate=$_POST['StartDate'];
        }

        if(isset($_POST['Fname']) && trim($_POST['Fname'])!=""){
            $Fname=$_POST['Fname'];
            if(isset($_POST['Lname']) && trim($_POST['Lname'])!=""){
                $Lname=$_POST['Lname'];
                $Search3="WHERE FirstName='$Fname' OR LastName='$Lname'";
            }else{
                $Search3="WHERE FirstName='$Fname'";
            }
        }else if(isset($_POST['Lname']) && trim($_POST['Lname'])!=""){
            $Lname=$_POST['Lname'];
            $Search3="WHERE LastName='$Lname'";
        }

        if(isset($_POST['EndDate']) && $_POST['EndDate']!=""){
            $EndDate=$_POST['EndDate'];
            if($StartDate!=""){
                if(strtotime($StartDate)>strtotime($EndDate)){
                    $message.="The end date must be after the start date.";
                }
            }else{
                $message.="Please select a start date before choosing the end date.";
            }
        }

        if($StartDate!="" && $EndDate==""){
            $message.="Please select an end date.";
        }else if($StartDate!="" && $EndDate!=""){
            $Search2="WHERE StartDate>='$StartDate' AND EndDate<='$EndDate'";
        }

        if($message!=""){
            $_SESSION['Message3']=$message;
        }
    }
?>
<!DOCTYPE HTML>
<html>
    <head>
        <style>
            body{
                font-family:arial;
                margin-top:80px;
                margin-bottom:80px;
            }
            .Css1{
                display: flex;
                padding-top:10px ;
            }
            .Css2{
                display: flex;
                gap:10px;
            }
            button[name="Search"]{
                border-radius: 10px;
                border:2px solid black;
                margin-top: 20px;
                padding-left: 10px;
                padding-right: 10px;
            }
            button[name="Search"]:hover{
                color:blue;
                border:2px solid blue;
            }
            button[name="Reset"]{
                border-radius: 10px;
                border:2px solid black;
                margin-top: 20px;
                padding-left: 10px;
                padding-right: 10px;
            }
            button[name="Reset"]:hover{
                color:blue;
                border:2px solid blue;
            }
            .nav{
                margin-left: 180px;
                margin-right: 180px;   
                padding:10px 20px 10px 20px; 
                border-radius: 20px;            
                background-color: #cfcecefd;
            }
            .nav form{
                display:flex;
                gap:30px;
                justify-content: center;
            }

            input[type="radio"]{
                display: none;
            }
            input[type="radio"]:checked+span{
                border:3px green solid;
                cursor: pointer;
            }
            span{
                background-color: white;
                padding-left:15px;
                padding-right:15px;
                padding-top:5px;
                padding-bottom: 5px;
                font-size:20px;
                border: 3px red solid; 
                cursor: pointer;
            }
            label{
                font-size: 20px;
            }
            table{
                border-radius: 10px;
                margin-top: 40px;
                display: flex;
                justify-self: center;
                border-spacing: 0px;
                box-shadow: -5px 5px 10px black;
            }
            th{
                width: 180px;
                margin-top:5px;
                padding-top:5px;
                padding-bottom:5px;
                color:white;
                background-color: dodgerblue;
            }
            #thLeft{
                border-top-left-radius:10px;
            }
            #thRight{
                border-top-right-radius: 10px;
            }
            td{
                background-color: white;
                border: 2px solid lightgray;
                width: 180px;
                margin-top:5px;
                padding-top:5px;
                padding-bottom:5px;
            }
            h1{
                font-size:15px;
                text-align: center;
            }
            h2{
                color:red;
                border-radius: 10px;
                border:2px solid red;
                background-color: #ffc5c5;
                display:flex;
                justify-self: center;
                padding:5px 10px 5px 10px;
            }
            #DateCss{
                display:block;
                font-size: 20px;
            }
            #Car{
                border-top-left-radius: 20px;
                border-bottom-left-radius: 20px;
            }
            #Van{
                border-top-right-radius: 20px;
                border-bottom-right-radius: 20px;
            }            
        </style>
    </head>
    <body>
        <nav class="nav">
            <form method="POST">
                <div class="Css1">
                    <label>
                        <input type="radio" name="VehicleType" value="Car" <?php if($Vehicle=="Car"){echo "checked";} ?>>
                        <span id="Car">Car</span>    
                    </label>
                    <label>
                        <input type="radio" name="VehicleType" value="Van" <?php if($Vehicle=="Van"){echo "checked";} ?>>
                        <span id="Van">Van</span> 
                    </label>
                </div>
                <div>
                    <label>First Name:</label>
                    <input type="text" name="Fname" <?php if($Fname!=""){echo "value='$Fname'";} ?>>
                </div>
                <div>
                    <label>Last Name:</label>
                    <input type="text" name="Lname" <?php if($Lname!=""){echo "value='$Lname'";} ?>>
                </div>
                <div>
                    <label id="DateCss">Start Date:</label>
                    <input type="datetime-local" name="StartDate" <?php if($StartDate!=""){echo "value='$StartDate'";} ?>>
                </div>
                <div>
                    <label id="DateCss">End Date:</label>
                    <input type="datetime-local" name="EndDate" <?php if($EndDate!=""){echo "value='$EndDate'";} ?>>
                </div>
                <div class="Css2">
                    <button type="submit" name="Search">Search</button>
                    <button type="submit" name="Reset">Reset</button>
                </div>
            </form>
        </nav>
        <?php 
            if(isset($_SESSION['Message3'])){
                echo $_SESSION['Message3'];
                unset($_SESSION['Message3']);
            }else{
        ?>
        <table>
            <th id="thLeft">Vehicle ID</th>
            <th>Full Name</th>
            <th>Vehicle Type</th>
            <th>Number Plate</th>
            <th>Vehicle Brand</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th id="thRight">Status</th>
            <?php
                if($Search3==""){
                    $Booking=mysqli_query($con,"SELECT * FROM Booking $Search2");
                    while($b=mysqli_fetch_array($Booking)){
                        $VehiclesRentalHistory=mysqli_query($con,"SELECT * FROM Vehicle $Search");
                        while($v=mysqli_fetch_array($VehiclesRentalHistory)){
                            if($v['Id']==$b['VehicleId']){
                                $found=true;
                                echo"<tr><td><h1>".$v['Id']."</h1></td>";
                                $Users=mysqli_query($con,"SELECT * FROM Users");
                                while($u=mysqli_fetch_array($Users)){
                                    if($b['CustomerId']==$u['Id']){
                                        echo "<td><h1>".$u['FirstName']." ".$u['LastName']."</h1></td>";
                                    }
                                }
                                echo"<td><h1>".$v['VehicleType']."</h1></td>
                                <td><h1>".$v['NumberPlate']."</h1></td>
                                <td><h1>".$v['VehicleBrand']."</h1></td>
                                <td><h1>".$b['StartDate']."</h1></td>
                                <td><h1>".$b['EndDate']."</h1></td>
                                <td><h1>".$b['Status']."</h1></td></tr>";
                                break;
                            }
                        }
                    }
                }else{
                    $Booking=mysqli_query($con,"SELECT * FROM Booking $Search2");
                    while($b=mysqli_fetch_array($Booking)){
                        $Users=mysqli_query($con,"SELECT * FROM Users $Search3");
                        while($u=mysqli_fetch_array($Users)){
                            if($b['CustomerId']==$u['Id']){
                                $VehiclesRentalHistory=mysqli_query($con,"SELECT * FROM Vehicle $Search");
                                while($v=mysqli_fetch_array($VehiclesRentalHistory)){
                                    if($v['Id']==$b['VehicleId']){
                                        $found=true;
                                        echo"<tr><td><h1>".$v['Id']."</h1></td>
                                        <td><h1>".$u['FirstName']." ".$u['LastName']."</h1></td>
                                        <td><h1>".$v['VehicleType']."</h1></td>
                                        <td><h1>".$v['NumberPlate']."</h1></td>
                                        <td><h1>".$v['VehicleBrand']."</h1></td>
                                        <td><h1>".$b['StartDate']."</h1></td>
                                        <td><h1>".$b['EndDate']."</h1></td>
                                        <td><h1>".$b['Status']."</h1></td></tr>";
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            ?>
        </table>
        <?php
            if(!$found){
                echo "<br><h2>Rental Not Found</h2>";
            }
        ?>
    </body>
</html>