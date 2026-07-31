 <?php
    $message="";
    $age="";
    include "Nav.php";
    $con=OpenCon();
    
    if(isset($_SESSION['Age'])){// true false
        $age=$_SESSION['Age'];
    }else{
        $age="";
    }
    $message="";
    if(isset($_POST['Search'])){// true false
        if(isset($_SESSION['Gmail'])){// false true
            if(isset($_POST['Type'])){//false true
                $location=$_POST['location'];
                $_SESSION['VehicleType']=$_POST['Type'];
                $pickup=strtotime($_POST['pickup']);
                $return=strtotime($_POST['return']);
                $gmail=$_SESSION['Gmail'];
                if($age>=18){// false true
                    if($location!=""){ // false true
                        if($return>$pickup){// true false
                            $_SESSION['Branch']=$location;
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
                    $message="You are not old enough to drive";
                }
            }else{
                $message="Please select a vehicle type (Car or Van)";
            }
        }else{
            $message="You have to login first.";
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
                            <img src="Pictures/Car.webp" class="Car">
                        </label>
                        <label>
                            <input type="radio" name="Type" value="Van" >
                            <img src="Pictures/Van.jpg" class="Van">
                        </label>
                        <?php         
                            if($message!=""){echo "<h2>".$message."</h2>";}// true false
                        ?>
                    </div>
                    <div class="Css4">
                        <div>
                        <h1>Pickup location:</h1>
                        <select name="location" required>
                            <option value="">-</option>
                            <?php
                            $arrlocations=[];
                            $locations=mysqli_query($con,"SELECT * FROM Vehicle");
                            while($L=mysqli_fetch_array($locations)){
                                $found=false;
                                for($i=0;$i<count($arrlocations);$i++){
                                    if($arrlocations[$i]==$L['Branch']){//true false
                                        $found=true;
                                    }
                                }
                                if(!$found){// true false
                                    $arrlocations[]=$L['Branch'];
                                    echo "<option value='".$L['Branch']."'>".$L['Branch']."</option>";
                                }
                                
                            }
                            ?>
                        </select>
                        </div>
                        <div>
                            <h1>Pickup date and time:</h1>
                            <input type="datetime-local" min="<?php echo date('Y-m-d\TH:i',strtotime('+1 day'));?>" name="pickup" required>
                        </div>
                        <div>
                            <h1>Return date and time:</h1>
                            <input type="datetime-local" min="<?php echo date('Y-m-d\TH:i',strtotime('+2 day'));?>" name="return" required>
                        </div>
                    </div>
                    <div class="Css5">
                        <div>
                        <label>You'r age:</label>
                        <p><?php echo $age;?></p>
                        </div>
                        <div>
                        <button id="Search" type="submit" name="Search">Search</button></div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>