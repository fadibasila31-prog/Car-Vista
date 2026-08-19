<?php 
    include "Nav.php";
    $con=OpenCon();
    $message="";
    if(isset($_POST['Signup'])){
        $Fname=$_POST['Fname'];
        $Lname=$_POST['Lname'];
        $email=$_POST['Gmail'];
        $BirthDay=$_POST['BirthDay'];
        $pass1=$_POST['Pass1'];
        $pass2=$_POST['Pass2'];
        $PhoneNumber=$_POST['PhoneNumber'];
        $IdNumber=$_POST['IDNumber'];
        $isValid=true;
        $isValid2=true;
        $HaveDriverLicense=0;
        $caps=0;
        $digits=0;

        $_SESSION['SignUpFname']=$_POST['Fname'];
        $_SESSION['SignUpLname']=$_POST['Lname'];
        $_SESSION['SignUpGmail']=$_POST['Gmail'];
        $_SESSION['SignUpBirthDay']=$_POST['BirthDay'];
        $_SESSION['SignUpPass1']=$_POST['Pass1'];
        $_SESSION['SignUpPass2']=$_POST['Pass2'];
        $_SESSION['SignUpPhoneNumber']=$_POST['PhoneNumber'];
        $_SESSION['SignUpIDNumber']=$_POST['IDNumber'];
        $_SESSION['SignUpHaveDriverLicense']=$_POST['HaveDriverLicense'];
        for($i=0;$i<strlen($PhoneNumber);$i++){
            if(($i==0 && $PhoneNumber[$i]!='0') || ($i==1 && $PhoneNumber[$i]!='5') || ($i==2 && ($PhoneNumber[$i]=='9' || $PhoneNumber[$i]=='6'))){
                $isValid=false;
                break;
            }else if(!($PhoneNumber[$i]>='0' && $PhoneNumber[$i]<='9')){
                $isValid=false;
                break;                    
            }
        }

        $Birth=strtotime($BirthDay);
        $Today=strtotime(date("Y-m-d"));
        $Age=($Today-$Birth)/(365*24*60*60);

        for($i=0;$i<strlen($IdNumber);$i++){
            if(!($IdNumber[$i]>=0 && $IdNumber[$i]<=9)){
                $isValid2=false;
            }
        }

        if($_POST['HaveDriverLicense']=="Yes"){
            $HaveDriverLicense=1;
        }else{
            $HaveDriverLicense=0;
        }

        for($i=0;$i<strlen($pass1);$i++){
            if($pass1[$i]>='A' && $pass1[$i]<='Z'){
                $caps++;
            }else if($pass1[$i]>='0' && $pass1[$i]<='9'){
                $digits++;
            }
        }

        if(trim($Fname)=="" || trim($Lname)==""){
            $message="Please Enter Your Name.";
        }else if(!$isValid2 || trim(strlen($IdNumber))!=9){
            $message="Please Enter Your ID Number Again.";
        }else if(trim(strlen($pass1))<6 || trim(strlen($pass2))<6){
            $message="Your Password must be at least 6 chars/digits.";
        }else if($pass1 != $pass2){
            $message="Confirm your Password again.";
        }else if($caps==0 || $digits<2){
            $message="your password must have at least 1 Big char and 2 digits number";
        }else if(!$isValid || strlen($PhoneNumber)!=10){
            $message="Write a Number 10 digits start with 050/051/052/053/054/055/057/058";
        }else if($Age<18 && $HaveDriverLicense==1){
            $message="You must be at least 18 years old to have a driver license.";
        }else{
            $created=false;
            $acc=mysqli_query($con,"SELECT * FROM Users");
            while($a=mysqli_fetch_array($acc)){
                if(strtolower($Lname)==strtolower($a['LastName']) && strtolower($Fname)==strtolower($a['FirstName'])){
                    $message="This User Name is already exist.";
                    $created=true;
                    break;
                }else if($email==$a['Gmail']){
                    $message="This Gmail is already exist.";
                    $created=true;
                    break;
                }else if($PhoneNumber==$a['PhoneNumber']){
                    $message="This Phone Number is already exist.";
                    $created=true;
                    break;                    
                }else if($IdNumber==$a['IdNumber']){
                    $message="This ID Number is already exist.";
                    $created=true;
                    break;                    
                }
            }   
            if(!$created){
                session_destroy();
                mysqli_query($con,"INSERT INTO Users (FirstName,LastName,Gmail,IdNumber,Password,Password1,HaveDriverLicense,Blocked,FailedTimes,BirthDay,PhoneNumber,Role) 
                VALUE ('$Fname','$Lname','$email','$IdNumber','$pass1','$pass1','$HaveDriverLicense',0,0,'$BirthDay','$PhoneNumber','Customer')");
                header("Location:Index.php");
                exit();
            }
        }
    }
    CloseCon($con);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Signup</title>
        <style>
            body{
                font-family:Arial;
                background-color: #c5c5c7;
                display: flex;
                justify-content: center;
                margin-top:70px;
                margin-bottom:70px;
            }
            .css1{
                background-color: #aeaeb6;
                padding-bottom: 20px;
                padding-left: 40px;
                padding-right: 40px;
                border-radius: 20px;
                box-shadow: 0px 20px 50px;
                width:420px;
            }
            h1{
                text-align: center;
                text-decoration: underline;
            }
            h2{
                color:red;
                background-color: #fbc2c2;
                font-size:20px;
                padding:5px 10px 5px 10px;
                border:2px solid red;
                border-radius: 10px;
            }
            label{
                display: block;
                margin-top: 10px;
            }
            input{
                display: block;
                border-radius: 5px;
                margin-top: 5px;
                width:100%;
                height: 10px;
                padding-bottom:10px;
                padding-top:10px;
            }
            button{
                display: flex;
                justify-self: center;
                font-size: 20px;
                margin-top: 10px;
                cursor: pointer;
                border-radius: 10px;
            }
            button:hover{
                color:blue;
                border:2px solid blue;
            }
            a{
                font-size: 20px;
                color:black;
                border:2px solid black;
                border-radius: 5px;
                padding-left: 10px;
                padding-right: 10px;
                text-decoration: none;
                background-color: #f3eded;
            }
            a:hover{
                color:blue;
                border:2px solid blue;
            }
            .HaveDriverLicense{
                display:flex;
                gap:10px;
            }    
        </style>
    </head>
    <body>
        <div class="css1">
            <h1>Sign UP</h1>
            <?php 
            if($message!=""){
                echo "<h2>".$message."</h2>";
            }
            ?>
            <form method="post">
                <label>First Name:</label>
                <input type="text" name="Fname" placeholder="First Name...." <?php if(isset($_SESSION['SignUpFname'])){ echo "value='".$_SESSION['SignUpFname']."'";} ?> required>
                <label>Last Name:</label>
                <input type="text" name="Lname" placeholder="Last Name...." <?php if(isset($_SESSION['SignUpLname'])){ echo "value='".$_SESSION['SignUpLname']."'";} ?> required>
                <label>Gmail:</label>
                <input type="email" name="Gmail" placeholder="Gmail...." <?php if(isset($_SESSION['SignUpGmail'])){ echo "value='".$_SESSION['SignUpGmail']."'";} ?> required>
                <label>ID Number:</label>
                <input type="text" name="IDNumber" placeholder="ID Number...." <?php if(isset($_SESSION['SignUpIDNumber'])){ echo "value='".$_SESSION['SignUpIDNumber']."'";} ?> required>                
                <label>Birth Day:</label>
                <input type="date" name="BirthDay"  max="<?php echo date("Y-m-d") ?>" <?php if(isset($_SESSION['SignUpBirthDay'])){ echo "value='".$_SESSION['SignUpBirthDay']."'";} ?> required>
                <label>Passowrd:</label>
                <input type="password" name="Pass1" placeholder="Password...." <?php if(isset($_SESSION['SignUpPass1'])){ echo "value='".$_SESSION['SignUpPass1']."'";} ?> required>
                <label>Confirm Password:</label>
                <input type="password" name="Pass2" placeholder="Confirm Pssword...." <?php if(isset($_SESSION['SignUpPass2'])){ echo "value='".$_SESSION['SignUpPass2']."'";} ?> required>
                <label>Phone Number:</label>
                <input type="text" name="PhoneNumber" placeholder="Phone Number...." <?php if(isset($_SESSION['SignUpPhoneNumber'])){ echo "value='".$_SESSION['SignUpPhoneNumber']."'";} ?> required>
                <label>Have Driver License:</label>
                <div class="HaveDriverLicense">
                    <div><input type="radio" name="HaveDriverLicense" value="Yes" <?php if(isset($_SESSION['SignUpHaveDriverLicense']) && $_SESSION['SignUpHaveDriverLicense']=="Yes"){echo "checked";} ?> required>Yes</div>
                    <div><input type="radio" name="HaveDriverLicense" value="No" <?php if(isset($_SESSION['SignUpHaveDriverLicense']) && $_SESSION['SignUpHaveDriverLicense']=="No"){echo "checked";} ?>>No</div>
                </div>
                <button type="submit" name="Signup">Sign up</button>
            </form><br>
            <center>
                <a href="Index.php">Back to Login</a>
            </center>
        </div>
    </body>
</html>