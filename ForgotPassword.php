<?php 
    include "Nav.php";
    $message="";
    if(isset($_POST['Submit'])){
        if(trim($_POST['FullName']) != ""){
            $FullName=$_POST['FullName'];
            $gmail=$_POST['Gmail'];
            $Fname="";
            $Lname="";
            for($i=0;$i<strlen($FullName);$i++){
                if($FullName[$i]==" "){
                    for($j=$i+1;$j<strlen($FullName);$j++){
                        $Lname.=$FullName[$j];
                    }
                    break;
                }else{
                    $Fname.=$FullName[$i];
                }
            }

            $users=mysqli_query($con,"SELECT * FROM Users");
            $found=false;
            while($u = mysqli_fetch_array($users)){
                if(strtolower(trim($Fname))==strtolower($u['FirstName']) && strtolower(trim($Lname))==strtolower($u['LastName'])){
                    $found=true;
                    if($gmail==$u['Gmail']){
                        $RandPass="";
                        $str1="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
                        for($i=0;$i<6;$i++){
                            $x=rand(0,1);
                            if($x==0){
                                $z=rand(0,51);
                                $RandPass.=$str1[$z];
                            }else{
                                $z=rand(0,9);
                                $RandPass.=$z;
                            }
                        }
                        $to=$gmail;
                        $message2="Your Random Password is: ".$RandPass.".\n Use it to update your Password.";
                        $subject="Reset Password.";
                        $header="From: fadibasila31@gmail.com";
                        $result=mail($to,$subject,$message2,$header);
                        if($result){
                            $message="<h3>You can receive the Random Password in your Gmail.</h3>";
                            $_SESSION['RandomPassMessage']=$message;
                            $_SESSION['SaveGmail']=$gmail;
                            $StartTime=date("Y-m-d H:i:s");
                            $EndTime=date("Y-m-d H:i:s",strtotime("+5 minutes"));
                            mysqli_query($con,"UPDATE Users SET Password='$RandPass',StartTimeExpired='$StartTime',EndTimeExpired='$EndTime' WHERE Gmail='$gmail'");
                            header("Location: UpdatePassword.php");
                        }else{
                            $message="<h2>Something Went Wrong, try again.</h2>";
                        }
                    }else{
                        $message="<h2>Wrong Gmail, try again.</h2>";
                    }
                    break;
                }
            }
            if(!$found){
                $message="<h2>User Name not found.</h2>";
            }
        }else{
            $message="<h2>Write your name again.</h2>";
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
                border-radius: 15px;
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
                padding-left: 10px;
                padding-right: 10px;
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
            .Css1 a{
                display: flex;
                justify-self: center;
                text-decoration: none;
                color: black;
                border:2px solid black;
                font-weight: bold;
                margin-top: 10px;
                background-color: #f3ededc5;
                border-radius: 5px;
                padding: 5px;
            }
            .Css1 a:hover{
                color:blue;
                border:2px solid blue;
            }
        </style>
    </head>
    <body>
        <div class="Css1">
            <form method="post">
                <h1>Write your User Name and your Gmail.</h1>
                <?php 
                    echo $message;
                ?>
                <label>Full Name:</label>
                <input type="text" name="FullName" placeholder="Full Name...." required>
                <label>Gmail:</label>
                <input type="email" name="Gmail" placeholder="Gmail...." required>
                <button type="submit" name="Submit">Send</button>
            </form>
            <a href="Index.php">Go Back To Login Page</a>
        </div>
    </body>
</html>