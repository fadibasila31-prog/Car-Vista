<?php 
    include "Nav.php";
    if(isset($_SESSION['SaveGmail'])){
        $message="";
        if(isset($_POST['Submit'])){
            $rand=$_POST['Random'];
            $pass1=$_POST['Pass1'];
            $pass2=$_POST['Pass2'];
            $gmail=$_SESSION['SaveGmail'];
            if(trim($rand)!=""){      
                while($p= mysqli_fetch_array(mysqli_query($con,"SELECT * FROM Users"))){
                    if($p['Gmail']==$gmail){
                        if($rand==$p['Password']){
                            if(trim($pass1)!=""){
                                $count=0;
                                $caps=false;
                                $number=false;
                                for($i=0;$i<strlen($pass1);$i++){
                                    if($pass1[$i]>='A' && $pass1[$i]<='Z'){
                                        $caps=true;
                                    }else if($pass1[$i]>='0' && $pass1[$i]<='9'){
                                        $number=true;
                                    }
                                    $count++;
                                }
                                if($count<6 || !$caps || !$number){ 
                                    $message="<h2>Password must be at least 6 characters and include a capital letter and a number.</h2>";
                                }else{
                                    if($pass1==$pass2){
                                        if($pass1!=$p['Password1'] && $pass1!=$p['Password2'] && $pass1!=$p['Password3']){
                                            if($p['StartTimeExpired'] < $p['EndTimeExpired']){
                                                mysqli_query($con,"UPDATE Users SET Password3=Password2,Password2=Password1,Password1='$pass1',Password='$pass1',Blocked=0,FailedTimes=0 WHERE Gmail='$gmail'");
                                                unset($_SESSION['SaveGmail']);
                                                header("Location: UpdatePassword.php");
                                                exit();
                                            }else{
                                                $message="<h2>The verification code has expired after 5 minutes. Please request a new code to continue the password reset process.</h2>";
                                            }
                                        }else{
                                            $message="<h2>You cannot reuse any of your last 3 passwords. Please choose a new one.</h2>";
                                        }
                                    }else{
                                        $message="<h2>Passwords do not match. Please try again.</h2>";
                                    }
                                }
                            }else{
                                $message="<h2>Please enter a new password.</h2>";
                            }
                        }else{
                            $message="<h2>Please enter the random password code sent to your email.</h2>";
                        }
                        break;
                    }
                }
            }else{
                $message="<h2>Incorrect verification code. Please try again.</h2>";        
            }
        }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <style>
            body{
                font-family: Arial;
                display: flex;
                justify-content: center;
                background-color: #c5c5c7;
                margin-top: 50px;
            }
            .Css1{
                background-color: white;
                border-radius: 10px;
                margin-top: 120px;
                width: 420px;
                padding: 40px;
            }
            label{
                display: block;
                margin-top: 10px;
            }
            input{
                border-radius: 5px;
                width: 90%;
                padding-bottom: 5px;
                padding-top: 5px;
            }
            h1{
                font-size: 20px;
                text-align: center;
                margin-bottom: 30px;
            }
            button{
                cursor: pointer;
                margin-top: 10px;
                display: flex;
                justify-self: center;
                font-size: 17px;
                color:black;
                border:2px solid black;
                border-radius: 5px;
            }
            button:hover{
                color:blue;
                border:2px solid blue;
            }
            h2{
                color: red;
                text-align: center;
            }
            h3{
                color: green;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="Css1">
            <form method="post">
                <h1>Write your New password here</h1>
                <?php 
                    if(isset($_SESSION['RandomPassMessage'])){
                        echo $_SESSION['RandomPassMessage'];
                        unset($_SESSION['RandomPassMessage']);
                    }else{
                        echo $message;
                    }
                ?>
                <label>Random Password:</label>
                <input type="text" name="Random" placeholder="Random Password...." required>
                <label>New Password:</label>
                <input type="password" name="Pass1" placeholder="New Password...." required>
                <label>Confirm New Password:</label>
                <input type="password" name="Pass2" placeholder="Confirm Password...." required>
                <button type="submit" name="Submit">Change Password</button>
            </form>
        </div>
        <?php 
            }else{
                echo '<div class="Css1">Password changed successfully. You can now log in with your new password.</div>' ;
            }

            CloseCon($con);
            ?>
    </body>
</html>