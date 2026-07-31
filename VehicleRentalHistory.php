<?php
    include "Nav.php";
    $con=OpenCon();

    $message="";
    $StartDate="";
    $EndDate="";
    $Vehicle="";
    $Search="";
    $Search2="";
    $found=false;
    if(isset($_POST['Search'])){// true false

        if(isset($_POST['VehicleType'])){// true false
            $Vehicle=$_POST['VehicleType'];
            $Search="WHERE VehicleType='$Vehicle'";
        }
        
        if(isset($_POST['StartDate']) && $_POST['StartDate']!=""){// true false
            $StartDate=$_POST['StartDate'];
        }

        if(isset($_POST['EndDate']) && $_POST['EndDate']!=""){// true false
            $EndDate=$_POST['EndDate'];
            if($StartDate!=""){// true false
                if(strtotime($StartDate)>=strtotime($EndDate)){// true false
                    $message.="The end date must be after the start date.";
                }
            }else{
                $message.="Please select a start date before choosing the end date.";
            }
        }

        if($StartDate!="" && $EndDate==""){// true false
            $message.="Please select an end date.";
        }else if($StartDate!="" && $EndDate!=""){// true false
            $Search2="WHERE StartDate>='$StartDate' AND EndDate<='$EndDate'";
        }

        if($message!=""){// true false
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
            }
            .Css1{
                display: flex;
                padding-top:10px ;
            }a
            .nav form button{
                border-radius: 10px;
                border:2px solid black;
                margin-top: 15px;
                padding-left: 10px;
                padding-right: 10px;
            }
            form button:hover{
                color:blue;
                border:2px solid blue;
            }
            .nav{
                margin-left: 400px;
                margin-right: 400px;   
                padding-top: 10px;
                padding-bottom: 10px; 
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
                box-shadow: 0px 0px 20px cyan;
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
                        <input type="radio" name="VehicleType" value="Car">
                        <span id="Car">Car</span>    
                    </label>
                    <label>
                        <input type="radio" name="VehicleType" value="Van">
                        <span id="Van">Van</span> 
                    </label>
                </div>
                <div>
                    <label id="DateCss">Start Date:</label>
                    <input type="datetime-local" name="StartDate">
                </div>
                <div>
                    <label id="DateCss">End Date:</label>
                    <input type="datetime-local" name="EndDate">
                </div>
                <button type="submit" name="Search">Search</button>
            </form>
        </nav>
        <?php 
            if(isset($_SESSION['Message3'])){// true false
                echo $_SESSION['Message3'];
                unset($_SESSION['Message3']);
            }else{
        ?>
        <table>
            <th id="thLeft">Vehicle ID</th>
            <th>Vehicle Type</th>
            <th>Number Plate</th>
            <th>Vehicle Brand</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th id="thRight">Status</th>
            <?php
                $Booking=mysqli_query($con,"SELECT * FROM Booking $Search2");
                while($b=mysqli_fetch_array($Booking)){
                    echo "<tr>";
                        $VehiclesRentalHistory=mysqli_query($con,"SELECT * FROM Vehicle $Search");
                        while($v=mysqli_fetch_array($VehiclesRentalHistory)){
                            if($v['Id']==$b['VehicleId']){// true false
                                $found=true;
                                echo"<td><h1>".$v['Id']."</h1></td>
                                <td><h1>".$v['VehicleType']."</h1></td>
                                <td><h1>".$v['NumberPlate']."</h1></td>
                                <td><h1>".$v['VehicleBrand']."</h1></td>
                                <td><h1>".$b['StartDate']."</h1></td>
                                <td><h1>".$b['EndDate']."</h1></td>
                                <td><h1>".$b['Status']."</h1></td>";
                                break;
                            }
                        }
                    echo "</tr>";
                }
            }
            ?>
        </table>
        <?php
            if(!$found){// true false
                echo "<br>Vehicle Not Found";
            }
        ?>
    </body>
</html>