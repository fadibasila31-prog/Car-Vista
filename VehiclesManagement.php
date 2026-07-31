<?php
    include "Nav.php";
    $con=OpenCon();
    if(isset($_POST['VehicleDetaild'])){// false true
        $_SESSION['VehicleId']=$_POST['VehicleId'];
        header("Location: VehicleDetailsManagment.php");
        exit();
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
                margin-top:50px;
                padding-top: 50px;
                display: flex;
                align-items: center;
                flex-direction: column;
            }
            .Css1 img{
                display: block;
                margin-bottom: 10px;
                height: 165px;
                width:282px;
            }
            .Css1 table{
                border-spacing: 20px;
                height: 100vh;
            }
            .Css1 td{
                border-radius: 15px;
                padding:10px;
                background-color:#f0f0f0;
                box-shadow: 0 0 20px rgba(0, 0, 0, 1); 
           }
            .Css1 td:hover{
                transform: scale(1.08) ;
            }
            .Css1 button{
                margin-top: 10px;
                border:2px solid black;
                border-radius: 5px;
                font-size: 15px;
            }
            .Css1 button:hover{
                border:2px solid blue;
                color:blue;
            }
            .Css2 form{
                display:flex;
                gap:40px;
                background-color: #c5c5c7;
                padding-top:5px;
                padding-bottom:5px;
                padding-left:10px;
                padding-right:10px;
            }
            .Css3 label{
                display:block;
            }
            .Css4{
                display:flex;
                margin-top: 10px;
            }
            h2{
                font-size: 20px;
                display:inline;
            }
            h3{
                background-color: #bdbcbcf3;
                border:4px black solid;
                border-radius: 10px;
                padding-left:20px;
                padding-right: 20px;
                padding-top: 5px;
                padding-bottom: 5px;
                font-size: 30px;
                margin-top: 200px;
            }
            span{
                background-color:white;
                padding-left:15px;
                padding-right:15px;
                padding-top:5px;
                padding-bottom: 5px;
                font-size:20px;
                border: 3px red solid; 
                cursor: pointer;
            }
            input[type="radio"]{
                display:none;
            }
            input[type="radio"]:checked + span{
                border: 3px green solid;
            }
            #Car{
                border-top-left-radius: 20px;
                border-bottom-left-radius: 20px;
            }
            #Van{
                border-top-right-radius: 20px;
                border-bottom-right-radius: 20px;
            }
            #Automatic{
                border-top-left-radius: 20px;
                border-bottom-left-radius: 20px; 
            }
            #Manual{
                border-top-right-radius: 20px;
                border-bottom-right-radius: 20px;                
            }
            #MoreDetails:hover{
                background-color: yellow;
            }
        </style>
    </head>
    <body>
        <div class="Css1">
            <div class="Css2">
            <?php
                $search="";
                $cnt=0;
                $Type="";
                $NP="";
                $brand="";
                $GB="";
                $branch="";

   
                if(isset($_POST['search'])){// false true
                    
                    if(isset($_POST['Type'])){// true false
                        $Type=$_POST['Type'];
                        if($Type!=""){// true false
                            $search="WHERE VehicleType='$Type'";
                            $cnt=1;
                        }
                    }

                    if(isset($_POST['NumberPlate'])){// false true
                        $NP=trim($_POST['NumberPlate']);
                        if($NP!=""){// true false
                            if($cnt==0){//true false
                                $search="WHERE NumberPlate='$NP'";
                                $cnt=1;
                            }else{
                                $search.=" AND NumberPlate='$NP'";
                            }
                        }
                    }

                    if(isset($_POST['Brand'])){// false true
                        $brand=$_POST['Brand'];
                        if($brand!=""){// true false
                            if($cnt==0){// true false
                                $search="WHERE VehicleBrand='$brand'";
                                $cnt=1;
                            }else{
                                $search.=" AND VehicleBrand='$brand'";
                            }
                        }
                    }

                    if(isset($_POST['GearBox'])){// true false
                        $GB=$_POST['GearBox'];
                        if($GB!=""){// true false
                            if($cnt==0){// true false
                                $search="WHERE GearBox='$GB'";
                                $cnt=1;
                            }else{
                                $search.=" AND GearBox='$GB'";
                            }
                        }
                    }

                    if(isset($_POST['Branch'])){// true false
                        $branch=$_POST['Branch'];
                        if($branch!=""){// true false
                            if($cnt==0){// true false
                                $search="WHERE Branch='$branch'";
                                $cnt=1;
                            }else{
                                $search.=" AND Branch='$branch'";
                            }
                        }
                    }
                }
            ?>
                <form method="POST">
                    <div class="Css4">
                        <label>
                            <input type="radio" name="Type" value="Car">
                            <span id="Car">Car</span>
                        </label>
                        <label>
                            <input type="radio" name="Type" value="Van">
                            <span id="Van">Van</span>
                        </label>
                    </div>
                    <div class="Css3">
                        <label>Number Plate:</label>
                        <input type="text" name="NumberPlate" placeholder="Number Plate...." <?php if($NP!=""){echo "value='$NP'";}// true false?>>
                    </div>
                    <div class="Css3">
                        <label>Vehicle Brand:</label>
                        <select name="Brand">
                            <option value="">All</option>
                            <?php
                                $arrbrand=[];
                                $brands=mysqli_query($con,"SELECT * FROM Vehicle");
                                while($brand2=mysqli_fetch_array($brands)){
                                    $found2=false;
                                    for($i=0;$i<count($arrbrand);$i++){
                                        if($arrbrand[$i]==$brand2['VehicleBrand']){// true false
                                            $found2=true;
                                        }
                                    }

                                    if(!$found2){// true false
                                        $arrbrand[]=$brand2['VehicleBrand'];
                                        echo "<option value='".$brand2['VehicleBrand']."'";
                                        if($brand==$brand2['VehicleBrand']){// true false
                                            echo "selected";
                                        }
                                        echo ">".$brand2['VehicleBrand']."</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="Css4">
                        <label>
                            <input type="radio" name="GearBox" value="Automatic">
                            <span id="Automatic">Automatic</span>
                        </label>
                        <label>
                            <input type="radio" name="GearBox" value="Manual">
                            <span id="Manual">Manual</span>
                        </label>
                    </div>
                    <div class="Css3">
                        <label>Branch:</label>
                        <select name="Branch">
                            <option value="">All</option>
                            <?php
                                $arrbranch=[];
                                $branches=mysqli_query($con,"SELECT * FROM Vehicle");
                                while($b=mysqli_fetch_array($branches)){
                                    $found2=false;
                                    for($i=0;$i<count($arrbranch);$i++){
                                        if($b['Branch']==$arrbranch[$i]){// true false
                                            $found2=true;                                        
                                        }
                                    }
                                    if(!$found2){// true false
                                        $arrbranch[]=$b['Branch'];
                                        echo "<option value='".$b['Branch']."'";
                                        if($branch==$b['Branch']){// true false
                                            echo "selected";
                                        }
                                        echo ">".$b['Branch']."</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div>
                        <button type="submit" name="search">Search</button>
                        <button type="submit" name="reset">Reset</button>
                    </div>
                </form>
            </div>
            <h1>Vehicles</h1>
            <table>
                <tr>
                <?php
                    $colums=0;
                    $found=false;

                    $Vehicles=mysqli_query($con,"SELECT * FROM Vehicle $search");
                    while($v=mysqli_fetch_array($Vehicles)){
                        $found=true;
                        echo "<td>
                                <img src='Pictures/".$v['Image']."'>";
                                if(isset($_SESSION['Role'])){// true false for worker and manager
                                    if($_SESSION['Role']=="Manager"){// true false for worker and manager
                                        echo "<h2>Vehicle Id: ".$v['Id']."</h2><br><br>";
                                    }
                                }
                                echo"
                                <h2>Number Plate: ".$v['NumberPlate']."</h2><br><br>
                                <h2>Brand: ".$v['VehicleBrand']."</h2><br><br>
                                <h2>Energy Type: ".$v['EnergyType']."</h2><br><br>
                                <h2>Vehicle in Branch: ".$v['Branch']."</h2><br><br>
                                <h2>Vehicle Type: ".$v['VehicleType']."</h2>
                                <form method='post'><input type='hidden' name='VehicleId' value='".$v['Id']."'><button id='MoreDetails' type='submit' name='VehicleDetaild'>More Details</button></form>
                        </td>";
                        $colums++;
                        if($colums==4){// true false
                            echo "</tr><tr>";
                            $colums=0;
                        }
                    }     
                    
                    if(!$found){// true false
                        echo "<h3>We dont have this Vehicle.</h3>";
                    }
                ?>
                </tr>
            </table>
        </div>
    </body>
</html>