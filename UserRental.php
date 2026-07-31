<?php 
    include "Nav.php";
    $con=opencon();
    $CustomerId=$_SESSION['UserId'];
    $message="";
    
    if(isset($_POST['Cancel'])){// true false
        $BookingId=$_POST['BookingId'];
        mysqli_query($con,"UPDATE Booking SET Status='Canceled' Where BookingId='$BookingId'");
    }

    if(isset($_POST['Delete'])){
        $_SESSION['Delete']=true;
    }

    if(isset($_SESSION['Delete'])){
        echo "<div class='Css1'>
            <form method='POST'>
                <label>Are You Sure You Want To Delete Your Account?</label>
                <button type='submit' name='AcceptDelete'>Yes</button>
                <button type='submit' name='CancelDelete'>No</button>
            </form>
        </div>";
        unset($_SESSION['Delete']);
    }

    if(isset($_POST['AcceptDelete'])){
        mysqli_query($con,"DELETE FROM Users WHERE Id='$CustomerId'");
        mysqli_query($con,"DELETE FROM Booking WHERE CustomerId='$CustomerId'");
        mysqli_query($con,"DELETE FROM Referense WHERE CustomerId='$CustomerId'");
        session_destroy();
        header("Location:HomePage.php");
        exit();
    }


    if(isset($_POST['ChangeInformations'])){
        $Fname="";
        $Lname="";
        $Gmail="";
        $IdNumber="";
        $BirthDay="";
        $PhoneNumber="";
        $HaveDriverLicense="";
        $isValid=true;

        if(isset($_POST['FirstName']) && trim($_POST['FirstName'])!=""){
            $Fname=$_POST['FirstName'];

            $Users=mysqli_query($con,"SELECT * FROM Users");
            while($u=mysqli_fetch_array($Users)){
                if(strtolower($u['FirstName'])==strtolower($Fname)){
                    $message.="This User Name is already exist\n";
                    $isValid=false;
                    break;
                }
            }
        }else{
            $Users=mysqli_query($con,"SELECT * FROM Users");
            while($u=mysqli_fetch_array($Users)){
                if($u['Id']==$CustomerId){
                    $Fname=$u['FirstName'];
                    break;
                }
            }
        }

        if(isset($_POST['LastName']) && trim($_POST['LastName'])!=""){
            $Lname=$_POST['LastName'];

            $Users=mysqli_query($con,"SELECT * FROM Users");
            while($u=mysqli_fetch_array($Users)){
                if(strtolower($u['LastName'])==strtolower($Lname)){
                    $message.="This User Name is already exist\n";
                    $isValid=false;
                    break;
                }
            }            
        }else{
            $Users=mysqli_query($con,"SELECT * FROM Users");
            while($u=mysqli_fetch_array($Users)){
                if($u['Id']==$CustomerId){
                    $Lname=$u['LastName'];
                    break;
                }
            }
        }

        if(isset($_POST['Gmail']) && trim($_POST['Gmail'])!=""){
            $Gmail=$_POST['Gmail'];

            $GmailTest="";
            for($i=0;$i<strlen($Gmail);$i++){
                if($Gmail[$i]=='@' && $i!=0){
                    for($j=$i;$j<strlen($Gmail);$j++){
                        $GmailTest.=$Gmail;
                    }
                    if($GmailTest!="@gmail.com"){
                        $message.="check gmail\n";
                        $isValid=false;
                    }
                }else if($i==0 && $Gmail[$i]=='@'){
                    $message.="check gmail again\n";
                    $isValid=false;
                    break;
                }
            }

            if($isValid){
                $Users=mysqli_query($con,"SELECT * FROM Users");
                while($u=mysqli_fetch_array($Users)){
                    if($u['Gmail']==$Gmail){
                        $message.="This Gmail is already exist\n";
                        $isValid=false;
                        break;
                    }
                }  
            }
        }else{
            $Users=mysqli_query($con,"SELECT * FROM Users");
            while($u=mysqli_fetch_array($Users)){
                if($u['Id']==$CustomerId){
                    $Gmail=$u['Gmail'];
                    break;
                }
            }
        }

        if(isset($_POST['IDNumber']) && trim($_POST['IDNumber'])!=""){
            $IdNumber=$_POST['IDNumber'];

            for($i=0;$i<strlen($IdNumber);$i++){
                if(!($IdNumber[$i]>='0' && $IdNumber[$i]<='9')){
                    $message.="check id again";
                    $isValid=false;
                    break;
                }
            }

            if($isValid){
                $Users=mysqli_query($con,"SELECT * FROM Users");
                while($u=mysqli_fetch_array($Users)){
                    if($u['IdNumber']==$IdNumber){
                        $message.="This ID Number is already exist\n";
                        $isValid=false;
                        break;
                    }
                }  
            }
        }else{
            $Users=mysqli_query($con,"SELECT * FROM Users");
            while($u=mysqli_fetch_array($Users)){
                if($u['Id']==$CustomerId){
                    $IdNumber=$u['IdNumber'];
                    break;
                }
            }
        }

        if(isset($_POST['PhoneNumber']) && trim($_POST['PhoneNumber'])!=""){
            $PhoneNumber=$_POST['PhoneNumber'];

            for($i=0;$i<strlen($PhoneNumber);$i++){
                if(!($PhoneNumber[$i]>='0' && $PhoneNumber[$i]<='9')){
                    $message.="check id again";
                    $isValid=false;
                    break;
                }
            }

            if($isValid){
                $Users=mysqli_query($con,"SELECT * FROM Users");
                while($u=mysqli_fetch_array($Users)){
                    if($u['PhoneNumber']==$PhoneNumber){
                        $message.="This Phone Number is already exist\n";
                        $isValid=false;
                        break;
                    }
                }  
            }
        }else{
            $Users=mysqli_query($con,"SELECT * FROM Users");
            while($u=mysqli_fetch_array($Users)){
                if($u['Id']==$CustomerId){
                    $PhoneNumber=$u['PhoneNumber'];
                    break;
                }
            }
        }


        if(isset($_POST['HaveDriverLicense'])){
            if($_POST['HaveDriverLicense']=="Yes"){
                $HaveDriverLicense=1;
            }else{
                $HaveDriverLicense=0;
            }            
        }else{
            $Users=mysqli_query($con,"SELECT * FROM Users");
            while($u=mysqli_fetch_array($Users)){
                if($u['Id']==$CustomerId){
                    $HaveDriverLicense=$u['HaveDriverLicense'];
                    break;
                }
            }
        }


        if(isset($_POST['BirthDay'])){
            $BirthDay=$_POST['BirthDay'];
    
            $birth=strtotime($BirthDay);
            $today=strtotime(date("Y-m-d"));

            $age=($today-$birth)/(365*24*60*60);
            if($age<18 && $HaveDriverLicense==1){
                $message="You must be at least 18 years old to have a driver license.";
            }
        
            if($age<18 && $HaveDriverLicense==1){
                $HaveDriverLicense=0;
            }  
        }else{
            $Users=mysqli_query($con,"SELECT * FROM Users");
            while($u=mysqli_fetch_array($Users)){
                if($u['Id']==$CustomerId){
                    $BirthDay=$u['BirthDay'];
                    break;
                }
            }
        }

   
        if($isValid){
            mysqli_query($con,"UPDATE Users SET FirstName='$Fname' , LastName='$Lname' , Gmail='$Gmail' , IdNumber='$IdNumber' , HaveDriverLicense='$HaveDriverLicense' , BirthDay='$BirthDay' , PhoneNumber='$PhoneNumber' WHERE Id=$CustomerId");
        }else{
            $_SESSION['ChangeDetailsMessage']=$message;
            header("Location: UserRental.php");
            exit();
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
            }
           .Css1{
                position: fixed;
                top:0px;
                width: 100%;
                height: 100%;
                background: #00000080;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .Css1 label{
                background-color: #ffffffb3;
                border-radius: 10px; 
                padding:5px 10px 5px 10px;           
            }
            button[name="ChangeInformations"]{
                display:flex;
                justify-self: center;
                border-radius: 5px;
                margin-top: 20px;
                padding:5px 10px 5px 10px;
                font-weight: bold;
            }
            button[name="ChangeInformations"]:hover{
                border:2px solid blue;
                color:blue;
            }
            .form {
                display:flex;
                gap:20px;
                margin-left: 100px;
                margin-right:100px;
                padding-bottom:10px;
            }
            .form label{
                background-color: #ffffffb3;
                border-radius: 10px;            
                display: block;
            }
            .form input{
                margin-top: 15px;
                border-radius: 5px;
            }
            table{
                border-radius: 10px;
                margin-top: 100px;
                display: flex;
                justify-self: center;
                border-spacing: 0px;
                box-shadow: 0px 0px 40px cyan;
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
            .Cssp{
                text-align: center;
                height: 70vh;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            p{
                border-radius: 10px;
                padding: 10px;
                font-size: 20px;
                font-weight: bold;
                border: 3px black solid;
            }
            h1{
                font-size:15px;
                text-align: center;
            }
            h2{
                color:red;
                border: 2px solid red;
                border-radius: 5px;
                padding:5px 10px 5px 10px;
                background-color: #ffaeae;
                display:flex;
                justify-self: center;
            }
            button[name='Delete']{
                padding-left:10px;
                padding-right:10px;
                border-radius: 5px;
                border:2px solid black;
                font-weight: bold;
            }
            button[name='Delete']:hover{
                color:red;
                border:2px solid red;
                background-color: #fcbcbc;
            }
            button[name='AcceptDelete']{
                border-radius: 5px;
                border:2px solid black;
                padding:5px 10px 5px 10px;
                font-weight: bold;
            }
            button[name='AcceptDelete']:hover{
                color:red;
                border:2px solid red;
                background-color: #fcbcbc;
            }
            button[name='CancelDelete']{
                border-radius: 5px;
                border:2px solid black;
                padding:5px 10px 5px 10px;
                font-weight: bold;
            }
            button[name='CancelDelete']:hover{
                color:green;
                border:2px solid lightgreen;
                background-color: #b0fcb5;
            }
            .Shadow{
                background-color: white;
                box-shadow: 0px 0px 30px black;
                display: flex;
                justify-self: center;
                margin-top:70px;
                padding-top: 15px;
                padding-bottom: 15px;
                border-radius: 10px;
            }
        </style>
    </head>
    <body>
        <table>
            <th id="thLeft">First Name</th>
            <th>Last Name</th>
            <th>Gmail</th>
            <th>Id Number</th>
            <th>Have Driver License</th>
            <th>Birth Day</th>
            <th>Phone Number</th>
            <th id="thRight">Delet Aaccount</th>
            <?php 
                $Users=mysqli_query($con,"SELECT * FROM Users");
                while($u=mysqli_fetch_array($Users)){
                    if($u['Id']==$CustomerId){
                        echo "<tr><td><h1>".$u['FirstName']."</h1></td>
                        <td><h1>".$u['LastName']."</h1></td>
                        <td><h1>".$u['Gmail']."</h1></td>
                        <td><h1>".$u['IdNumber']."</h1></td>
                        <td><h1>"; 
                        if($u['HaveDriverLicense']){
                            echo "Yes";
                        }else{
                            echo "No";
                        }
                        echo"</h1></td>
                        <td><h1>".$u['BirthDay']."</h1></td>
                        <td><h1>".$u['PhoneNumber']."</h1></td>
                        <td><h1><form method='post'><button type='submit' name='Delete'>Delete</button></form></h1></td></tr>";
                    }
                }
            ?>
        </table>

        <?php
            if(isset($_SESSION['ChangeDetailsMessage'])){
                echo "<h2>".$_SESSION['ChangeDetailsMessage']."</h2>";
                unset($_SESSION['ChangeDetailsMessage']);
            }
        ?>
        <div class="Shadow">
            <form method="POST">
                <div class="form">
                    <div>
                        <label>First Name:</label>
                        <input type="text" name="FirstName" placeholder="First Name...." >
                    </div>
                    <div>
                        <label>Last Name:</label>
                        <input type="text" name="LastName" placeholder="Last Name...." >
                    </div>
                    <div>
                        <label>Gmail:</label>
                        <input type="email" name="Gmail" placeholder="Gmail...." >
                    </div>
                    <div>
                        <label>ID Number:</label>
                        <input type="text" name="IDNumber" placeholder="ID Number...." >
                    </div>
                    <div>
                        <label>Birth Day:</label>
                        <input type="date" name="BirthDay" >
                    </div>
                    <div>
                        <label>Phone Number:</label>
                        <input type="text" name="PhoneNumber" placeholder="Phone Number...." >
                    </div>
                    <div>
                        <label>Have Driver License</label>
                        Yes<input type="radio" name="HaveDriverLicense" value="Yes" >
                        No<input type="radio" name="HaveDriverLicense" value="No">
                    </div>
                </div>
                <button type="submit" name="ChangeInformations">Change</button>
            </form>
        </div>
        <table>
            <tr>
                <th id="thLeft">Car/Van</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Last Update At</th>
                <th>Total Price</th>
                <th id="thRight">Cancel Order</t>
            </tr>
            <?php
                $found=false;
                $Booking=mysqli_query($con,"SELECT * FROM Booking");
                while($b=mysqli_fetch_array($Booking)){
                    if($b['CustomerId']==$CustomerId){// true false
                        $found=true;
                        $CarId=$b['VehicleId'];
                        $Cars=mysqli_query($con,"SELECT * FROM Vehicle");
                        while($c=mysqli_fetch_array($Cars)){
                            if($c['Id']==$CarId){// true false
                                echo "<tr><td><h1>".$c['VehicleName']."</h1></td>";
                                break;
                            }
                        }
                        echo "<td><h1>".$b['StartDate']."</h1></td>
                        <td><h1>".$b['EndDate']."</h1></td>
                        <td><h1>".$b['Status']."</h1></td>
                        <td><h1>".$b['CreatedAt']."</h1></td>
                        <td><h1>".$b['UpdatedAt']."</h1></td>
                        <td><h1>".$b['TotalPrice']."</h1></td>
                        <td><h1>";
                        if($b['Status']=='Confirmed'){// true false
                            echo "<form method='post'><input type='hidden' name='BookingId' value='".$b['BookingId']."'><button type='submit' name='Cancel'>Cancel</button></form>";
                        }else{
                            echo "-";
                        }
                        echo "</h1></td></tr>";
                    }
                }
            ?>
        </table>
        <?php                  
            if(!$found){// ture false
                echo "<div class='Cssp'><p>You haven't rented a vehicle yet.</p></div>";
            }
        ?>
    </body>
</html>