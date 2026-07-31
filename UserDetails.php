<?php
    include "Nav.php";
    $con=OpenCon();
    if(isset($_POST['MoreDetails'])){// true false
        $_SESSION['UserDetails']=$_POST['UserId'];
        header("Location: PrivateUserInformations");
        exit();
    }
    $message1="";
    $message2="";
    $message3="";


    if(isset($_POST['AddManager'])){// true false
        if(trim($_POST['Fname'])==""){// true false
            $message1="Please Write Manager First Name Again.";
        }else if(trim($_POST['Lname'])==""){// true false
            $message1="Please Write Manager Last Name Again.";
        }else if(trim($_POST['IdNumber'])==""){// true false
            $message1="Please Write Manager ID Number";
        }else if(trim($_POST['Pass1'])==""){// true false
            $message1="Please Write Manager Password.";
        }else if(trim($_POST['Pass2'])==""){// true false
            $message1="Please Confirm Manager Password.";
        }else if(trim($_POST['PhoneNum'])==""){// true false
            $message1="Please Write Manager Phone Number.";
        }else{
            $Fname=$_POST['Fname'];
            $Lname=$_POST['Lname'];
            $Gmail=$_POST['Gmail'];
            $IdNumber=$_POST['IdNumber'];
            $Pass1=$_POST['Pass1'];
            $Pass2=$_POST['Pass2'];
            $PN=$_POST['PhoneNum'];
            $BD=$_POST['BirthDay'];
            $email="";
            $flag=true;
            $caps=0;
            $digits=0;  
            $users=mysqli_query($con,"SELECT * FROM Users");
            while($u=mysqli_fetch_array($users)){
                if((strtolower(trim($u['FirstName']))==strtolower(trim($Fname))) && (strtolower(trim($u['LastName']))==strtolower(trim($Lname)))){// true false
                    $flag=false;
                    $message1="This User is Arleady exist.";
                    break;
                }else if($u['IdNumber']==$IdNumber){// true false
                    $flag=false;
                    $message1="Check you'r ID Number Again.";
                    break;
                }else if($u['Gmail']==$Gmail){// true false
                    $flag=false;
                    $message1="This Gmail is Already exist.";
                    break;
                }else if($u['PhoneNumber']==$PN){// true false
                    $flag=false;
                    $message1="This Phone Number is Already exist.";
                    break;                                
                }
            }

            for($i=0;$i<strlen($Gmail);$i++){
                if($Gmail[$i]=='@'){// true false
                    for($j=$i;$j<strlen($Gmail);$j++){
                        $email.=$Gmail[$j];
                    }
                    if($email!="@gmail.com"){// true false
                        $flag=false;
                        $message1.="<br>Please Check you'r Gmail Again.";
                    }
                    break;
                }
            }

            for($i=0;$i<strlen($IdNumber);$i++){
                if($IdNumber[$i]>'9' || $IdNumber[$i]<'0'){// true false
                    $flag=false;
                    $message1.="<br>Please Check you'r ID Number Again.";
                    break;
                }
            }
            
            for($i=0;$i<strlen($PN);$i++){
                if($PN[$i]>'9' || $PN[$i]<'0'){// true false
                    $flag=false;
                    $message1.="<br>Pleas Check you'r Phone Number Again.";
                    break;
                }else if(($i==0 && $PN[$i]!=0) || ($i==1 && $PN[$i]!=5) || ($i==2 && ($PN[$i]==9 || $PN[$i]==6))){// true false
                    $flag=false;
                    $message1.="<br>you'r Phone Number must start with 050/051/052/053/054/055/057/058";
                    break;
                }
            }
            
            for($i=0;$i<strlen($Pass1);$i++){
                if($Pass1[$i]>='A' && $Pass1[$i]<='Z'){// true false
                    $caps++;
                }else if($Pass1[$i]>='0' && $Pass1[$i]<='9'){// true false
                    $digits++;
                }
            }
            
            if($caps==0 || $digits<2){// true false
                $message1.="<br>your password must have at least 1 Big char and 2 digits number and be more than 6 characters.";
            }else if($Pass1!=$Pass2){// true false
                $message1.="<br>Please Confirm you'r Password Again.";
            }else if(strlen($PN)!=10){// true false
                $message1.="<br>Phone Number must be 10 digits.";
            }else if($flag){// true false
                mysqli_query($con,"INSERT INTO Users (FirstName,LastName,Gmail,IdNumber,Password,Password1,HaveDriverLicense,Blocked,FailedTimes,BirthDay,PhoneNumber,Role)
                values ('$Fname','$Lname','$Gmail','$IdNumber','$Pass1','$Pass1',1,0,0,'$BD','$PN','Manager')");
            }
        }
    }


    if(isset($_POST['AddWorker'])){// true false
        if(trim($_POST['Fname'])==""){// true false
            $message2="Please Write Worker First Name Again.";
        }else if(trim($_POST['Lname'])==""){// true false
            $message2="Please Write Worker Last Name Again.";
        }else if(trim($_POST['IdNumber'])==""){// true false
            $message2="Please Write Worker ID Number";
        }else if(trim($_POST['Pass1'])==""){// true false
            $message2="Please Write Worker Password.";
        }else if(trim($_POST['Pass2'])==""){// true false
            $message2="Please Confirm Worker Password.";
        }else if(trim($_POST['PhoneNum'])==""){// true false
            $message2="Please Write Worker Phone Number.";
        }else{
            $Fname=$_POST['Fname'];
            $Lname=$_POST['Lname'];
            $Gmail=$_POST['Gmail'];
            $IdNumber=$_POST['IdNumber'];
            $Pass1=$_POST['Pass1'];
            $Pass2=$_POST['Pass2'];
            $PN=$_POST['PhoneNum'];
            $BD=$_POST['BirthDay'];
            $email="";
            $flag=true;
            $caps=0;
            $digits=0;  
            $users=mysqli_query($con,"SELECT * FROM Users");
            while($u=mysqli_fetch_array($users)){
                if((strtolower(trim($u['FirstName']))==strtolower(trim($Fname))) && (strtolower(trim($u['LastName']))==strtolower(trim($Lname)))){// true false
                    $flag=false;
                    $message2="This User is Arleady exist.";
                    break;
                }else if($u['IdNumber']==$IdNumber){// true false
                    $flag=false;
                    $message2="Check you'r ID Number Again.";
                    break;
                }else if($u['Gmail']==$Gmail){// true false
                    $flag=false;
                    $message2="This Gmail is Already exist.";
                    break;
                }else if($u['PhoneNumber']==$PN){// true false
                    $flag=false;
                    $message2="This Phone Number is Already exist.";
                    break;                                
                }
            } 

            for($i=0;$i<strlen($Gmail);$i++){
                if($Gmail[$i]=='@'){// true false
                    for($j=$i;$j<strlen($Gmail);$j++){
                        $email.=$Gmail[$j];
                    }
                    if($email!="@gmail.com"){// true false
                        $flag=false;
                        $message2.="<br>Please Check you'r Gmail Again.";
                    }
                    break;
                }
            }

            for($i=0;$i<strlen($IdNumber);$i++){
                if($IdNumber[$i]>'9' || $IdNumber[$i]<'0'){// true false
                    $flag=false;
                    $message2.="<br>Please Check you'r ID Number Again.";
                    break;
                }
            }
            
            for($i=0;$i<strlen($PN);$i++){
                if($PN[$i]>'9' || $PN[$i]<'0'){// true false
                    $flag=false;
                    $message2.="<br>Pleas Check you'r Phone Number Again.";
                    break;
                }else if(($i==0 && $PN[$i]!=0) || ($i==1 && $PN[$i]!=5) || ($i==2 && ($PN[$i]==9 || $PN[$i]==6))){// true false
                    $flag=false;
                    $message2.="<br>you'r Phone Number must start with 050/051/052/053/054/055/057/058";
                    break;
                }
            }
            
            for($i=0;$i<strlen($Pass1);$i++){
                if($Pass1[$i]>='A' && $Pass1[$i]<='Z'){// true false
                    $caps++;
                }else if($Pass1[$i]>='0' && $Pass1[$i]<='9'){// true false
                    $digits++;
                }
            }
            
            if($_POST['HaveDriverLicense']=="Yes"){// true false
                $HaveDriverLicense=1;
            }else{
                $HaveDriverLicense=0;
            }

            if($caps==0 || $digits<2){// true false
                $message2.="<br>your password must have at least 1 Big char and 2 digits number and be more than 6 characters.";
            }else if($Pass1!=$Pass2){// true false
                $message2.="<br>Please Confirm you'r Password Again.";
            }else if(strlen($PN)!=10){// true false
                $message2.="<br>Phone Number must be 10 digits.";
            }elseif($flag){
                mysqli_query($con,"INSERT INTO Users (FirstName,LastName,Gmail,IdNumber,Password,Password1,HaveDriverLicense,Blocked,FailedTimes,BirthDay,PhoneNumber,Role)
                values ('$Fname','$Lname','$Gmail','$IdNumber','$Pass1','$Pass1',$HaveDriverLicense,0,0,'$BD','$PN','Worker')");
            }
        }
    }


    if(isset($_POST['AddCustomer'])){// true false
        if(trim($_POST['Fname'])==""){// true false
            $message3="Please Write Customer First Name Again.";
        }else if(trim($_POST['Lname'])==""){// true false
            $message3="Please Write Customer Last Name Again.";
        }else if(trim($_POST['IdNumber'])==""){// true false
            $message3="Please Write Customer ID Number";
        }else if(trim($_POST['Pass1'])==""){// true false
            $message3="Please Write Customer Password.";
        }else if(trim($_POST['Pass2'])==""){// true false
            $message3="Please Confirm Customer Password.";
        }else if(trim($_POST['PhoneNum'])==""){// true false
            $message3="Please Write Customer Phone Number.";
        }else{
            $Fname=$_POST['Fname'];
            $Lname=$_POST['Lname'];
            $Gmail=$_POST['Gmail'];
            $IdNumber=$_POST['IdNumber'];
            $Pass1=$_POST['Pass1'];
            $Pass2=$_POST['Pass2'];
            $PN=$_POST['PhoneNum'];
            $BD=$_POST['BirthDay'];
            $email="";
            $flag=true;
            $caps=0;
            $digits=0;  
            $users=mysqli_query($con,"SELECT * FROM Users");
            while($u=mysqli_fetch_array($users)){
                if((strtolower(trim($u['FirstName']))==strtolower(trim($Fname))) && (strtolower(trim($u['LastName']))==strtolower(trim($Lname)))){// true false
                    $flag=false;
                    $message3="This User is Arleady exist.";
                    break;
                }else if($u['IdNumber']==$IdNumber){// true false
                    $flag=false;
                    $message3="Check you'r ID Number Again.";
                    break;
                }else if($u['Gmail']==$Gmail){// true false
                    $flag=false;
                    $message3="This Gmail is Already exist.";
                    break;
                }else if($u['PhoneNumber']==$PN){// true false
                    $flag=false;
                    $message3="This Phone Number is Already exist.";
                    break;                                
                }
            }

            for($i=0;$i<strlen($Gmail);$i++){
                if($Gmail[$i]=='@'){// true false
                    for($j=$i;$j<strlen($Gmail);$j++){
                        $email.=$Gmail[$j];
                    }
                    if($email!="@gmail.com"){// true false
                        $flag=false;
                        $message3.="<br>Please Check you'r Gmail Again.";
                    }
                    break;
                }
            }

            for($i=0;$i<strlen($IdNumber);$i++){
                if($IdNumber[$i]>'9' || $IdNumber[$i]<'0'){// true false
                    $flag=false;
                    $message3.="<br>Please Check you'r ID Number Again.";
                    break;
                }
            }
            
            for($i=0;$i<strlen($PN);$i++){
                if($PN[$i]>'9' || $PN[$i]<'0'){// true false
                    $flag=false;
                    $message3.="<br>Pleas Check you'r Phone Number Again.";
                    break;
                }else if(($i==0 && $PN[$i]!=0) || ($i==1 && $PN[$i]!=5) || ($i==2 && ($PN[$i]==9 || $PN[$i]==6))){// true false
                    $flag=false;
                    $message3.="<br>you'r Phone Number must start with 050/051/052/053/054/055/057/058";
                    break;
                }
            }
            
            for($i=0;$i<strlen($Pass1);$i++){
                if($Pass1[$i]>='A' && $Pass1[$i]<='Z'){// true false
                    $caps++;
                }else if($Pass1[$i]>='0' && $Pass1[$i]<='9'){// true false
                    $digits++;
                }
            }
            
            if($_POST['HaveDriverLicense']=="Yes"){// true false
                $HaveDriverLicense=1;
            }else{
                $HaveDriverLicense=0;
            }

            if($caps==0 || $digits<2){// true false
                $message3.="<br>your password must have at least 1 Big char and 2 digits number and be more than 6 characters.";
            }else if($Pass1!=$Pass2){// true false
                $message3.="<br>Please Confirm you'r Password Again.";
            }else if(strlen($PN)!=10){// true false
                $message3.="<br>Phone Number must be 10 digits.";
            }elseif($flag){// true false
                mysqli_query($con,"INSERT INTO Users (FirstName,LastName,Gmail,IdNumber,Password,Password1,HaveDriverLicense,Blocked,FailedTimes,BirthDay,PhoneNumber,Role)
                values ('$Fname','$Lname','$Gmail','$IdNumber','$Pass1','$Pass1',$HaveDriverLicense,0,0,'$BD','$PN','Customer')");
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
                margin-top: 70px;
                background-color: #c5c5c7;
            }
            .Css1{
                margin-left: 80px;
                margin-right: 20px;
            }
            .Css1 nav{
                background-color: #00b7ff;
                display:flex;
                justify-self: center;
                gap:15px;
                padding-left:20px;
                padding-right: 20px;
                padding-top:10px;
                padding-bottom:10px;
                border-radius: 10px;
                box-shadow:0px 0px 50px white;
            }
            .Css1 nav a{
                text-decoration: none;
                border:2px black solid;
                cursor: pointer;
                background-color: #c6c2c2;
                font-size: 20px;
                color:black;
                border-radius: 5px;
                padding-left: 2px;
                padding-right: 2px;
                font-weight: bold;         
                box-shadow:0px 0px 10px white;                      
            }
            .Css1 nav a:hover{
                color:blue;
                border:2px blue solid;
                background-color: white;                
                box-shadow:0px 0px 50px white;
            }
            .Css2{
                display: flex;
                gap: 10px;
            }
            table{
                border-radius: 10px;
                margin-top: 50px;
                display: flex;
                justify-self: center;
                border-spacing: 0px;
                box-shadow: 0px 0px 40px cyan;            
            }
            th{
              color:white;
                background-color: dodgerblue;
                display: inline-block;
                width: 200px;
            }
            td{
                background-color: white;
                border: 2px solid lightgray;
                display: inline-block;
                width: 197px;
            }
            h1{
                background: #007bff;
                color: white;
                padding: 10px;
                border-radius: 10px;
            }
            h2{
                color: red;
                font-size: 15px;
                text-align: center;
            }
            h3{
                font-size:15px;
                text-align: center;
            }
            label{
                display: block;
            }
            input{
                margin-top: 5px;
            }
            hr{
                border: 2px solid black;
                color: black;
            }
            #AddUser{
                font-size: 15px;
                margin-top: 10px;
                border-radius: 5px;
                border:2px solid black;
            }
            #AddUser:hover{
                color:blue;
                border:2px solid blue;
                box-shadow:0px 0px 10px blue;
            }
            #thLeft{
                border-top-left-radius:10px;
            }
            #thRight{
                border-top-right-radius: 10px;
            }
            #MoreDetails{
                border-radius:5px;
                font-size:15px;
                font-weight: bold;
                display:flex;
                justify-self: center;    
                align-items: center;
                margin-top: 12px;
                margin-bottom: 12px;
            }
            #MoreDetails:hover{
                border:2px solid black;
                background-color: yellow;
                color:blue;
            }
        </style>
    </head>
    <body>
        <div class="Css1">
           
            <nav>
                <a href="#addManager">Add Manager</a>
                <a href="#addWorker">Add Worker</a>
                <a href="#addCustomer">Add Customer</a>
                <a href="#ManagersDetails">Managers Details</a>
                <a href="#WorkersDetails">Workers Details</a>
                <a href="#CustomersDetails">Customers Details</a>
            </nav>
            <div id="addManager"></div><br>
            <h1>Add Manager 
                <?php 
                    if($message1!="")echo "<h2>".$message1."</h2>";// true false
                ?>
            </h1>

            <form method="POST">
                <div class="Css2">
                    <div><label>First Name:</label><input type="text" name="Fname" placeholder="First Name...." required></div>
                    <div><label>Last Name:</label><input type="text" name="Lname" placeholder="Last Name...." required></div>
                    <div><label>Gmail:</label><input type="email" name="Gmail" placeholder="Gmail...." required></div>
                    <div><label>Id Number:</label><input type="text" name="IdNumber" placeholder="Id Number...." required></div>
                    <div><label>Password:</label><input type="password" name="Pass1" placeholder="Password...." required></div>
                    <div><label>Confirm Password:</label><input type="password" name="Pass2" placeholder="Confirm Password...." required></div>
                    <div><label>Phone Number:</label><input type="text" name="PhoneNum" placeholder="Phone Number...." required></div>
                    <div><label>Birth Day:</label><input type="date" name="BirthDay" max="<?php echo date('Y-m-d') ?>" required></div>
                </div>
                <button id="AddUser" type="submit" name="AddManager">Add Manager</button>
            </form><hr>
            <div id="addWorker"></div><br>
            <h1>Add Worker 
                <?php 
                    if($message2!="")echo "<h2>".$message2."</h2>";// true false
                ?>
            </h1>
            <form method="POST">
                <div class="Css2">
                    <div><label>First Name:</label><input type="text" name="Fname" placeholder="First Name...." required></div>
                    <div><label>Last Name:</label><input type="text" name="Lname" placeholder="Last Name...." required></div>
                    <div><label>Gmail:</label><input type="email" name="Gmail" placeholder="Gmail...." required></div>
                    <div><label>Id Number:</label><input type="text" name="IdNumber" placeholder="Id Number...." required></div>
                    <div><label>Password:</label><input type="password" name="Pass1" placeholder="Password...." required></div>
                    <div><label>Confirm Password:</label><input type="password" name="Pass2" placeholder="Confirm Password...." required></div>
                    <div><label>Phone Number:</label><input type="text" name="PhoneNum" placeholder="Phone Number...." required></div>
                    <div><label>Birth Day:</label><input type="date" name="BirthDay" max="<?php echo date('Y-m-d') ?>" required></div>
                </div>
                <div>
                    <label style="margin-top: 10px;">Have Driver License:</label>
                    <input type="radio" name="HaveDriverLicense" value="Yes" required>Yes
                    <input type="radio" name="HaveDriverLicense" value="No">No
                </div>
                <button id="AddUser" type="submit" name="AddWorker">Add Worker</button>
            </form><hr>
            <div id="addCustomer"></div><br>
            <h1>Add Customer 
                <?php 
                    if($message3!="")echo "<h2>".$message3."</h2>";// true false
                ?>
            </h1>
            <form method="POST">
                <div class="Css2">
                    <div><label>First Name:</label><input type="text" name="Fname" placeholder="First Name...." required></div>
                    <div><label>Last Name:</label><input type="text" name="Lname" placeholder="Last Name...." required></div>
                    <div><label>Gmail:</label><input type="email" name="Gmail" placeholder="Gmail...." required></div>
                    <div><label>Id Number:</label><input type="text" name="IdNumber" placeholder="Id Number...." required></div>
                    <div><label>Password:</label><input type="password" name="Pass1" placeholder="Password...." required></div>
                    <div><label>Confirm Password:</label><input type="password" name="Pass2" placeholder="Confirm Password...." required></div>
                    <div><label>Phone Number:</label><input type="text" name="PhoneNum" placeholder="Phone Number...." required></div>
                    <div><label>Birth Day:</label><input type="date" name="BirthDay" max="<?php echo date('Y-m-d') ?>" required></div>
                </div>
                <div>
                    <label style="margin-top: 10px;">Have Driver License:</label>
                    <input type="radio" name="HaveDriverLicense" value="Yes" required>Yes
                    <input type="radio" name="HaveDriverLicense" value="No">No
                </div>
                <button id="AddUser" type="submit" name="AddCustomer">Add Customer</button>
            </form><hr>
            <div id="ManagersDetails"></div><br>
            <h1>Managers</h1>
            <table>
                <tr>
                    <th id="thLeft">Full Name</th>
                    <th>Gmail</th>
                    <th>ID Number</th>
                    <th>Birth Day</th>
                    <th>Phone Number</th>
                    <th id="thRight">Details</th>
                </tr>
                <?php
                    $customers=mysqli_query($con,"SELECT * FROM Users");
                    while($c=mysqli_fetch_array($customers)){
                        if($c['Role']=="Manager"){// true false
                            echo "<tr><td><h3>".$c['FirstName']." ".$c['LastName']."</h3></td>
                            <td><h3>".$c['Gmail']."</h3></td>
                            <td><h3>".$c['IdNumber']."</h3></td>
                            <td><h3>".$c['BirthDay']."</h3></td>
                            <td><h3>".$c['PhoneNumber']."</h3></td>
                            <td><form method='post'><input type='hidden' name='UserId' value='".$c['Id']."'><button id='MoreDetails' type='submit' name='MoreDetails'>More Details</form></td>
                            </tr>";
                        }
                    }
                ?>
            </table><hr>
            <div id="WorkersDetails"></div><br>
            <h1>Workers</h1>
            <table>
                <tr>
                    <th id="thLeft">Full Name</th>
                    <th>Gmail</th>
                    <th>ID Number</th>
                    <th>Birth Day</th>
                    <th>Phone Number</th>
                    <th id="thRight">Details</th>
                </tr>
                <?php
                    $Workers=mysqli_query($con,"SELECT * FROM Users");
                    while($w=mysqli_fetch_array($Workers)){
                        if($w['Role']=="Worker"){// true false
                            echo "<tr><td><h3>".$w['FirstName']." ".$w['LastName']."</td>
                            <td><h3>".$w['Gmail']."</h3></td>
                            <td><h3>".$w['IdNumber']."</h3></td>
                            <td><h3>".$w['BirthDay']."</h3></td>
                            <td><h3>".$w['PhoneNumber']."</h3></td>
                            <td><form method='post'><input type='hidden' name='UserId' value='".$w['Id']."'><button id='MoreDetails' type='submit' name='MoreDetails'>More Details</form></td>
                            </tr>";
                        }
                    }
                ?>
            </table><hr>
            <div id="CustomersDetails"></div><br>
            <h1>Customers</h1>
            <table>
                <tr>
                    <th id="thLeft">Full Name</th>
                    <th>Gmail</th>
                    <th>ID Number</th>
                    <th>Birth Day</th>
                    <th>Phone Number</th>
                    <th id="thRight">Details</th>
                </tr>
                <?php
                    $Managers=mysqli_query($con,"SELECT * FROM Users");
                    while($m=mysqli_fetch_array($Managers)){
                        if($m['Role']=="Customer"){// true false
                            echo "<tr><td><h3>".$m['FirstName']." ".$m['LastName']."</td>
                            <td><h3>".$m['Gmail']."</h3></td>
                            <td><h3>".$m['IdNumber']."</h3></td>
                            <td><h3>".$m['BirthDay']."</h3></td>
                            <td><h3>".$m['PhoneNumber']."</h3></td>
                            <td><form method='post'><input type='hidden' name='UserId' value='".$m['Id']."'><button id='MoreDetails' type='submit' name='MoreDetails'>More Details</form></td>
                            </tr>";
                        }
                    }
                ?>
            </table><hr>
        </div>
    </body>
</html>