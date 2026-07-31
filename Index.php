 <?php
    include "Nav.php";
    $con=OpenCon();
    $message="";
    if(isset($_POST['Login'])){
        $pass=$_POST['Pass'];
        $FullName=$_POST['FullName'];
        $Fname="";
        $Lname="";
        for($i=0;$i<strlen($FullName);$i++){
            if($FullName[$i]==" "){// true false
                for($j=$i+1;$j<strlen($FullName);$j++){
                    $Lname.=$FullName[$j];
                }

                break;
            }else{
                $Fname.=$FullName[$i];
            }
        }

        if(trim($pass)!="" && trim($Fname)!="" && trim($Lname)!=""){//false  true
            $found=false;
            $acc=mysqli_query($con,"SELECT * FROM Users");
            while($a=mysqli_fetch_array($acc)){
                if(strtolower(trim($Fname))==strtolower(trim($a['FirstName'])) && strtolower(trim($Lname))==strtolower(trim($a['LastName']))){// false true
                    $found=true;
                    if($a['Blocked']==0 && $a['FailedTimes']<3){// true false
                        $Gmail=$a['Gmail'];
                        if($pass==$a['Password1']){// false true
                            mysqli_query($con,"UPDATE Users SET FailedTimes=0,Blocked=0 Where Gmail='$Gmail'");
                            $_SESSION['Gmail']=$Gmail;
                            $_SESSION['UserId']=$a['Id'];
                            $_SESSION['UserFullName']=$a['FirstName']." ".$a['LastName'];
                            $_SESSION['Role']=$a['Role'];
                            $_SESSION['HaveDriverLicense']=$a['HaveDriverLicense'];
                            $date1=strtotime(date("Y-m-d"));
                            $date2=strtotime($a['BirthDay']);
                            $_SESSION['Age']=(int)(($date1-$date2)/60/60/24/365);
                            header("Location:HomePage.php");
                            exit();
                        }else{
                            $FailedTimes=2-$a['FailedTimes'];
                            $message="Wrong password. You have ".$FailedTimes." attempts left";
                            mysqli_query($con,"UPDATE Users SET FailedTimes=FailedTimes+1 Where Gmail='$Gmail'");
                            $a['FailedTimes']++;
                            if($a['FailedTimes']==3){// false ture
                                $message="Your Account ".$a['FirstName']." ".$a['LastName']." locked after 3 failed attempts. Reset your password to continue.";
                                mysqli_query($con,"UPDATE Users SET Blocked=1 Where Gmail='$Gmail'");
                            }
                        }
                    }else{
                        $message="Your Account ".$a['FirstName']." ".$a['LastName']." locked after 3 failed attempts. Reset your password to continue.";
                    }
                    break;
                }
            }
            if(!$found){// false true
                $message="User Name not found.";
            }
        }else{
            $message="Your Password or User Name is wrong.";
        }
    }

    if($message!=""){ // true false
        $_SESSION['LoginMessage']=$message;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <style>
            body{
                font-family: Arial;
                background-color: #c5c5c7;
            }
            .css1{
                display: flex;
                justify-content: center;
                margin-top: 130px;
            }
            .css2{
                background-color: white;
                border-top-left-radius: 10px;
                border-top-right-radius: 100px;
                border-bottom-left-radius: 100px;
                border-bottom-right-radius: 10px;
                box-shadow:10px 10px 100px;
                width: 500px;
                height: 400px;
                text-align: center;
            }
            .css2 a{
                text-decoration: none;
                font-size: 20px;
                padding:10px;
                border:2px solid black;
                border-radius: 5px;
                background-color: #e9e9e9;
                color:black;
            }
            .css2 a:hover{
                border:2px solid blue;
                color:blue;
            }
            input {
                display: block;
                margin-top: 15px;
                font-size: 20px;
                border-radius: 5px;
            }
            button{
                cursor: pointer;
                margin-top: 15px;
                font-size: 20px;
                border-radius: 5px;
            }
            form{
                margin-top:50px;
            }
            h2{
               color: red; 
            }
            #LogIn{
                padding-left: 15px;
                padding-right:15px;
            }      
            #LogIn:hover{
                border:2px solid blue;
                color:blue;
            }
        </style>
    </head>
    <body> 
        <div class="css1">
            <div class="css2">
                <h1>Login</h1>
                <center>
                    <?php
                        if(isset($_SESSION['LoginMessage'])){ // true false
                            echo "<h2>".$_SESSION['LoginMessage']."</h2>";
                            unset($_SESSION['LoginMessage']);
                        }
                    ?>
                    <form method="post">
                        <input type="text" name="FullName" placeholder="Full Name...." required>
                        <input type="password" name="Pass" placeholder="Password...." required>
                        <button id="LogIn" type="submit" name="Login">Login</button>
                    </form>
                </center><br><br>
                    <a href="Signup.php">Sign up</a>
                    <a href="ForgotPassword.php">Forgot Password</a>
            </div>
        </div>
    </body>
</html>