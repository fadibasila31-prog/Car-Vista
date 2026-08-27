<?php
    include "Nav.php";
    $con=OpenCon();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <style>
            body{
                font-family: Arial;
                margin: 0;
                background-color: #c5c5c7;
            }
            .Css1{
                margin-top: 50px;
                padding-top: 20px;
            }
            table{
                border-radius: 10px;
                margin-top: 100px;
                display: flex;
                justify-self: center;
                border-spacing: 0px;
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
                margin-top: 20px;
                text-align: center;
            }
            h2{
                text-align: center;
                color:red;
                border:2px solid red;
                background-color: #ffbaba;
                margin-left: 500px;
                margin-right: 500px;
                padding-top:5px;
                padding-bottom:5px;
            }
            
        </style>
    </head>
    <body>
        <div class="Css1">
            <table>
                <tr>
                    <th>Full Name</th>
                    <th>Id Number</th>
                    <th>Gmail</th>
                    <th>Beginner Driver</th>
                    <th>Birth Day</th>
                    <th>Phone Number</th>
                    <th>Role</th>
                </tr>
                <tr>
                    <?php
                        if(isset($_SESSION['UserDetails'])){
                            $UD=$_SESSION['UserDetails'];
                            $Inf=mysqli_query($con,"SELECT * FROM Users");
                            while($i=mysqli_fetch_array($Inf)){
                                if($UD==$i['Id']){
                                    echo "<tr><td>".$i['FirstName']." ".$i['LastName']."</td>
                                    <td>".$i['IdNumber']."</td>
                                    <td>".$i['Gmail']."</td><td>";
                                    if($i['HaveDriverLicense']==1){
                                        echo "Available";
                                    }else{
                                        echo "Not Available";
                                    }
                                    echo "</td><td>".$i['BirthDay']."</td>
                                    <td>".$i['PhoneNumber']."</td>
                                    <td>".$i['Role']."</td></tr>";
                                    break;
                                }
                            }                    
                    ?>
                </tr>
            </table>
            <h1>Orders</h1>
            <table>
                <tr>
                    <th id="thLeft">Vehicle Name</th>
                    <th>Number Plate</th>
                    <th>Booking Date</th>
                    <th>Booking Date Last Updates</th>
                    <th>Status</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th id="thRight">Total Price</th>
                </tr><tr>
                <?php
                    $found=false; 
                    $Booked=mysqli_query($con,"SELECT * FROM Booking");
                    while($b=mysqli_fetch_array($Booked)){
                        if($b['CustomerId']==$UD){
                            $Vehicle=mysqli_query($con,"SELECT * FROM Vehicle");
                            while($v=mysqli_fetch_array($Vehicle)){
                                if($b['VehicleId']==$v['Id']){
                                    $found=true;
                                    echo "<tr><td>".$v['VehicleName']."</td>
                                    <td>".$v['NumberPlate']."</td>";
                                    break;
                                }
                            }
                            echo "</td>
                            <td>".$b['CreatedAt']."</td>
                            <td>".$b['UpdatedAt']."</td>
                            <td>".$b['Status']."</td>                                           
                            <td>".$b['StartDate']."</td>  
                            <td>".$b['EndDate']."</td>  
                            <td>".$b['TotalPrice']."</td></tr>";
                        }
                    } 
                    if(!$found){
                        echo "<h2>You haven't booked any rentals yet!!</h2>";
                    }
                }else{
                    echo "<h2>Unable to load your account details. Please try signing in again.</h2>";
                }
                ?>
                </tr>
            </table>
        </div>
    </body>
</html>