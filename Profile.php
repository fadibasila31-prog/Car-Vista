<?php 
    include "Nav.php";
    $con=opencon();
    $CustomerId=$_SESSION['UserId'];
    $message="";
    
    if(isset($_POST['Cancel'])){
        $BookingId=$_POST['BookingId'];
        mysqli_query($con,"UPDATE Booking SET Status='Canceled' Where BookingId='$BookingId' AND CustomerId=$CustomerId AND Status='Waiting'");
    }

    if(isset($_POST['Delete'])){
        echo "<div class='Css1'>
            <form method='POST'>
                <label>Are You Sure You Want To Delete Your Account?</label>
                <button type='submit' name='AcceptDelete'>Yes</button>
                <button type='submit' name='CancelDelete'>No</button>
            </form>
        </div>";
    }

    if(isset($_POST['AcceptDelete'])){
        mysqli_query($con,"DELETE FROM Booking WHERE CustomerId='$CustomerId'");
        mysqli_query($con,"DELETE FROM Referense WHERE CustomerId='$CustomerId'");
        mysqli_query($con,"DELETE FROM Users WHERE Id='$CustomerId'");
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
        $Update="";
        $isValid=true;
        $cnt=0;


        if((isset($_POST['FirstName']) && trim($_POST['FirstName'])!="") && (isset($_POST['LastName']) && trim($_POST['LastName'])!="")){
            $Fname=$_POST['FirstName'];
            $Lname=$_POST['LastName'];
            $Users=mysqli_query($con,"SELECT * FROM Users");
            while($u=mysqli_fetch_array($Users)){
                if(strtolower($u['FirstName'])==strtolower($Fname) && strtolower($u['LastName'])==strtolower($Lname)){
                    $message.="This User Name is already exist\n";
                    $isValid=false;
                    break;
                }
            }

            if($isValid){
                $Update="FirstName='$Fname' , LastName='$Lname'";
                $cnt++;
            }
        } else if(isset($_POST['FirstName']) && trim($_POST['FirstName'])!=""){
            $Fname=$_POST['FirstName'];
            $Update="FirstName='$Fname'";
            $cnt++;
        }else if(isset($_POST['LastName']) && trim($_POST['LastName'])!=""){
            $Lname=$_POST['LastName'];
            $Update="LastName='$Lname'";
            $cnt++;
        }


        if(isset($_POST['Gmail']) && trim($_POST['Gmail'])!=""){
            $Gmail=$_POST['Gmail'];

            $GmailTest="";
            for($i=0;$i<strlen($Gmail);$i++){
                if($Gmail[$i]=='@' && $i!=0){
                    for($j=$i;$j<strlen($Gmail);$j++){
                        $GmailTest.=$Gmail[$j];
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

            if($isValid){
                if($cnt==0){
                    $Update="Gmail='$Gmail'";
                    $cnt++;
                }else{
                    $Update.=" , Gmail='$Gmail'";
                }
            }
        }


        if(isset($_POST['IDNumber']) && trim($_POST['IDNumber'])!=""){
            $IdNumber=$_POST['IDNumber'];

            for($i=0;$i<strlen($IdNumber);$i++){
                if(!($IdNumber[$i]>='0' && $IdNumber[$i]<='9')){
                    $message.="ID Must Be Only Digits.";
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

            if($isValid){
                if($cnt==0){
                    $Update="IdNumber='$IdNumber'";
                    $cnt++;
                }else{
                    $Update.=" , IdNumber='$IdNumber'";
                }
            }
        }


        if(isset($_POST['PhoneNumber']) && trim($_POST['PhoneNumber'])!=""){
            $PhoneNumber=$_POST['PhoneNumber'];

            for($i=0;$i<strlen($PhoneNumber);$i++){
                if(!($PhoneNumber[$i]>='0' && $PhoneNumber[$i]<='9')){
                    $message.="Phone Number Must Be Only Digits.";
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

            if($isValid){
                if($cnt==0){
                    $Update="PhoneNumber='$PhoneNumber'";
                    $cnt++;
                }else{
                    $Update.=" , PhoneNumber='$PhoneNumber'";
                }
            }
        }

        if(isset($_POST['HaveDriverLicense']) && (isset($_POST['BirthDay']) && trim($_POST['BirthDay']) != "")){
            if($_POST['HaveDriverLicense']=="Yes"){
                $HaveDriverLicense=1;
            }else if($_POST['HaveDriverLicense']=="No"){
                $HaveDriverLicense=0;
            }

            $BirthDay=$_POST['BirthDay'];
            $birth=strtotime($BirthDay);
            $today=strtotime(date("Y-m-d"));
            $age=(int)(($today-$birth)/60/60/24/365);
            $_SESSION['Age']=$age;

            if($age<18 && $HaveDriverLicense==1){
                $HaveDriverLicense=0;
            }

            if($cnt==0){
                $Update="BirthDay='$BirthDay' , HaveDriverLicense=$HaveDriverLicense";
                $cnt++;
            }else{
                $Update.=" , BirthDay='$BirthDay' , HaveDriverLicense=$HaveDriverLicense";
            }
        }else if(isset($_POST['HaveDriverLicense'])){
            if($_POST['HaveDriverLicense']=="Yes"){
                $HaveDriverLicense=1;
                $DriverLicense=mysqli_query($con,"SELECT * FROM Users");
                while($DL=mysqli_fetch_array($DriverLicense)){
                    if($DL['Id']==$CustomerId){
                        $BirthDay=$DL['BirthDay'];
                        break;
                    }
                }
                $birth=strtotime($BirthDay);
                $today=strtotime(date("Y-m-d"));
                $age=(int)(($today-$birth)/60/60/24/365);
                
                if($age<18 && $HaveDriverLicense==1){
                    $HaveDriverLicense=0;
                }

                if($cnt==0){
                    $Update="HaveDriverLicense='$HaveDriverLicense'";
                    $cnt++;
                }else{
                    $Update.=" , HaveDriverLicense='$HaveDriverLicense'";
                }
            }else if($_POST['HaveDriverLicense']=="No"){
                $HaveDriverLicense=0;
                if($cnt==0){
                    $Update="HaveDriverLicense='$HaveDriverLicense'";
                    $cnt++;
                }else{
                    $Update.=" , HaveDriverLicense='$HaveDriverLicense'";
                }
            }
            
            if($cnt==0){
                if($HaveDriverLicense==0){
                    $Update="Birthday='$BirthDay' , HaveDriverLicense=$HaveDriverLicense";
                }else{
                    $Update="HaveDriverLicense=$HaveDriverLicense";
                }
                $cnt++;
            }else{
                if($HaveDriverLicense==0){
                    $Update.=" , Birthday='$BirthDay' , HaveDriverLicense=$HaveDriverLicense";
                }else{
                    $Update.=" , HaveDriverLicense=$HaveDriverLicense";
                }
            }
        }else if(isset($_POST['BirthDay']) && trim($_POST['BirthDay']) != ""){
            $BirthDay=$_POST['BirthDay'];
    
            $birth=strtotime($BirthDay);
            $today=strtotime(date("Y-m-d"));

            $age=(int)(($today-$birth)/60/60/24/365);

            $_SESSION['Age']=$age;
            if($HaveDriverLicense==""){
                $DriverLicense=mysqli_query($con,"SELECT * FROM Users");
                while($DL=mysqli_fetch_array($DriverLicense)){
                    if($DL['Id']==$CustomerId){
                        $HaveDriverLicense=$DL['HaveDriverLicense'];
                        break;
                    }
                }
            }

            if($age<18 && $HaveDriverLicense==1){
                $HaveDriverLicense=0;
            }

            if($cnt==0){
                if($HaveDriverLicense==0){
                    $Update="Birthday='$BirthDay' , HaveDriverLicense=$HaveDriverLicense";
                }else{
                    $Update="Birthday='$BirthDay'";
                }
                $cnt++;
            }else{
                if($HaveDriverLicense==0){
                    $Update.=" , Birthday='$BirthDay' , HaveDriverLicense=$HaveDriverLicense";
                }else{
                    $Update.=" , Birthday='$BirthDay'";
                }
            }
        }

   
        if($isValid && $Update!=""){
            mysqli_query($con,"UPDATE Users SET $Update WHERE Id=$CustomerId");
        }else if($message!=""){
            $_SESSION['ChangeDetailsMessage']=$message;
            header("Location: Profile.php");
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
                margin-bottom: 60px;
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
            }-
            .Css1 label{
                background-color: #ffffffb3;
                border-radius: 10px; 
                padding:5px 10px 5px 10px;           
            }
            #FormShowRents{
                display:flex;
                justify-content: center;
                margin-top: 40px;
                gap:40px;
            }
            .Css2{
                display:inline-block;
            }
            .Css2 button{
                font-weight: bold;
                border: 2px solid transparent;
                padding:20px 70px 20px 70px;
                box-shadow: -5px 5px 10px black;
                background-color: #c5c5c7;
            }
            .Css2:hover button{
                border:2px solid black;
            }
            .Css2 h3{
                display:inline;
            }
            .Css2:hover h3{
                color: darkgoldenrod;
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
                box-shadow: -5px 5px 10px black;
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
                        <input type="date" name="BirthDay" max="<?php echo date("Y-m-d") ?>">
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

        <form id="FormShowRents" method="POST">
            <div class="Css2"><button type="submit" name="Soon"><h3>Soon</h3><br><br>Rental not started</button></div>
            <div class="Css2"><button type="submit" name="Active"><h3>Active</h3><br><br>Rental Active</button></div>
            <div class="Css2"><button type="submit" name="Finished"><h3>Finished</h3><br><br>Rental Finished</button></div>
            <div class="Css2"><button type="submit" name="Canceled"><h3>Canceled</h3><br><br>Rental canceled</button></div>
            <div class="Css2"><button type="submit" name="AllRents"><h3>All Rentals</h3><br><br>View all rentals</button></div>
        </form>

        <table>
            <tr>
                <th id="thLeft">Vehicle Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Last Update At</th>
                <th>Total Price</th>
                <th id="thRight">Cancel Order</t>
            </tr>
            <?php
                if(isset($_POST['Soon'])){
                    $Booking=mysqli_query($con,"SELECT * FROM Booking WHERE Status='Waiting' AND CustomerId=$CustomerId");
                }else if(isset($_POST['Active'])){
                    $Booking=mysqli_query($con,"SELECT * FROM Booking WHERE Status='Active' AND CustomerId=$CustomerId");
                }else if(isset($_POST['Finished'])){
                    $Booking=mysqli_query($con,"SELECT * FROM Booking WHERE Status='Finished' AND CustomerId=$CustomerId");
                }else if(isset($_POST['Canceled'])){
                    $Booking=mysqli_query($con,"SELECT * FROM Booking WHERE Status='Canceled' AND CustomerId=$CustomerId");
                }else{
                    $Booking=mysqli_query($con,"SELECT * FROM Booking WHERE CustomerId=$CustomerId");
                }

                $found=false;
                while($b=mysqli_fetch_array($Booking)){
                    $found=true;
                    $CarId=$b['VehicleId'];
                    $Cars=mysqli_query($con,"SELECT * FROM Vehicle");
                    while($c=mysqli_fetch_array($Cars)){
                        if($c['Id']==$CarId){
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
                    if($b['Status']=='Waiting'){
                        echo "<form method='post'><input type='hidden' name='BookingId' value='".$b['BookingId']."'><button type='submit' name='Cancel'>Cancel</button></form>";
                    }else{
                        echo "-";
                    }
                    echo "</h1></td></tr>";
                }
            ?>
        </table>
        <?php                  
            if(!$found){
                echo "<div class='Cssp'><p>You haven't rented a vehicle yet.</p></div>";
            }
        ?>
    </body>
</html>