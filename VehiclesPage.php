<?php
    include "Nav.php";    
    $con=OpenCon();
    if(isset($_POST['select'])){
        $CarLocation=mysqli_query($con,"SELECT * FROM Vehicle");
        while($CL=mysqli_fetch_array($CarLocation)){
            if($CL['Id']==$_POST['Id']){
                $_SESSION['Branch']=$CL['Branch'];
                break;  
            }
        }
        $_SESSION['VehicleId']=$_POST['Id'];
        header("Location:VehicleDetails.php");
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
                display: flex;
                margin-top: 40px;
                height: calc(100vh - 40px);
            }
            .Css2{
                background-color: #d0c8c8;
                width: 16%;
                padding-left: 20px; 
                overflow: auto;
            }
            .Css3{
                width: 84%;
                overflow: auto;
            }
            .Css3 button{
                padding-left:10px;
                padding-right:10px;
                font-size: 25px;
                font-style:italic;  
                font-weight: bold;
                background-color: yellow;
                border-radius: 10px;
                display: flex;
                justify-self: center;
            }
            .Css3 button:hover{
                color:blue;
                border:2px solid blue;
                background-color: white;
            }
            .Css3 a{
                text-align: center;
                margin-top: 50px;
                background-color: #f4f3f3;
                border-radius: 15px;
                font-size: 17px;
                border:2px black solid;
                text-decoration: none;
                padding:5px 10px 5px 10px;
                color:black;
                font-weight: bold;
            }
            .Css3 a:hover{
                border:2px solid blue;
                color:blue;
            }
            .Css4{
                display: flex;
                gap: 20px;
            }
            .Css4 h1{
                display: inline;
            }
            .Css4 button{
                color:black;
                height: 23px;
                font-size: 15px;
                margin-top: 17px;
                border:2px solid black;
                border-radius: 5px;
            }
            .Css4 button:hover{
                color:blue;
                border:2px solid blue;
            }
            .Css5 label{
                display: block;
            }
            .Css6{
                display: flex;
                gap: 10px;
            }
            .Css6 input{
                display: none;
            }
            .Css6 p{
                font-size: 20px;
                border: 3px  solid black;
                background-color: white;
                border-radius: 5px;
                border-width: 2px;
            }
            .Css6 input:checked + p{
                border-color: greenyellow;
                border-width: 5px;
            }
            .Css7{
                width: 60%;
                display: flex;
                flex-direction: column;
            }
            .Css7 img{
                width: 100px;
                height: 80px;
                margin-left: 10px;
                margin-top: 20px;
            }
            .Css9{
                display: flex;
            }
            .Css10{
                display: flex;
                gap:35px;
                padding-left:30px ;
            }
            .Css10 img{
                width: 25px;
                height: 25px;
            }
            .Css10 p{
                display: inline-block;
                font-size: 20px;
                font-weight: bold;
            }
             .Css11{
                background-color: #c8c8cc;
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100vh;
            }
            .Css11 p{
                border-radius: 10px;
                background-color: lightgray;
                padding: 10px;
                font-size: 30px;
                font-weight: bold;
                border: 3px black solid;
            } 
            select{
                margin-top: 15px;
            }
            h1{
                font-size: 20px;
                margin-bottom: 0px;   
            }
            h2{
                margin-left:40px ;
                padding:4px;
                font-style: italic;
                border:2px solid black;
                border-radius: 5px;
                font-size: 30px;
                display: inline-block;
            }
            h3{
                background-color: yellow;
                border:2px solid black;
                border-radius: 7px;
                margin-top: 60px;
                font-size: 25px;
                font-style: italic;
                display: inline-block;
                padding: 3px 7px 3px 7px;
            }
            h4{
                color: red;
            }
            h5{
                display: inline;
                margin-left: 40px;
                font-size: 20px;
            }
            table{
                width: 100%;
                border-spacing:20px 20px;
            }
            td{
                border-radius: 20px;
                height: 250px;
                width:100%;
                background-color: white;
                display: flex;
                box-shadow: 0px 0px 20px;
            }
            td img{
                height: 200px;
                width: 300px;
                border-radius: 20px;
            }
            hr{
                background-color:black;
                height: 2px;
            }
            .buttons{
                display: flex;
                gap: 10px;
            }
        </style>
    </head>
    <body>
        <?php
            $GB="";
            $DS="";
            $F="";
            $seats="";
            $Brand="";
            $Price="";
            $searching="";
            $VT="";
            $select=0;
            $arr=[];

            if(isset($_SESSION['Branch'])){
                $Branch=$_SESSION['Branch'];
                $searching="WHERE Branch='$Branch'";
                $select++;
            }else{
                $Branch="";
            }

            if(isset($_SESSION['DriveStyle'])){
                if($_SESSION['DriveStyle']=="OnRoad"){
                    $DS=1;
                }else{
                    $DS=0;
                }

                if($select==0){
                    $searching="WHERE DriveStyle='$DS'";
                    $select++;
                }else{
                    $searching.=" AND DriveStyle='$DS'";
                }
            }else{
                $DS="";
            }
            
            if(isset($_SESSION['Seats'])){
                $seats=$_SESSION['Seats'];
                if($select==0){
                    $searching="WHERE Seats>='$seats'";
                    $select++;
                }else{
                    $searching.=" AND Seats>='$seats'";
                }
            }else{
                $seats="";
            }

            if(isset($_SESSION['GearBox'])){
                $GB=$_SESSION['GearBox'];
                if($select==0){
                    $searching="WHERE GearBox='$GB'";
                    $select++;
                }else{
                    $searching.=" AND GearBox='$GB'";
                }
            }else{
                $GB="";
            }

            if(isset($_SESSION['VehicleType'])){
                $VT=$_SESSION['VehicleType'];
                if($select==0){
                    $searching="WHERE VehicleType='$VT'";
                    $select++;
                }else{
                    $searching.=" AND VehicleType='$VT'";
                }
            }else{
                $VT="";
            }

            if(isset($_POST['resetall'])){
                unset($_SESSION['Branch']);
                unset($_SESSION['VehicleType']);
                unset($_SESSION['Seats']);
                unset($_SESSION['DriveStyle']);
                unset($_SESSION['GearBox']);
                $searching="";
                $GB="";
                $DS="";
                $F="";
                $seats="";
                $Brand="";
                $Price="";
                $VT="";
                $Branch="";
            }
                

            if(isset($_POST['search'])){
                $searching="";
                $select=0;

                if(isset($_POST['GearBox'])){
                    $GB=$_POST['GearBox'];
                    if($GB!="Both1"){ 
                        $searching="WHERE GearBox='$GB'";
                        $select++;         
                    }
                }   

                if(isset($_POST['VehicleType'])){
                    $VT=$_POST['VehicleType'];
                    if($VT!="Both2"){
                        if($select==0){
                            $searching="WHERE VehicleType='$VT'";
                            $select++;
                        }else{
                            $searching.=" AND VehicleType='$VT'";
                        }
                    }
                }

                if(isset($_POST['DriveStyle'])){
                    $DS=$_POST['DriveStyle'];
                    if($DS!="Both3"){
                        if($DS=="OffRoad"){
                            if($select==0){
                                $searching="WHERE DriveStyle=0";
                                $select++;
                            }else{
                                $searching.=" AND DriveStyle=0";
                            }
                        }else{
                            if($select==0){
                                $searching="WHERE DriveStyle=1";
                                $select++;
                            }else{
                                $searching.=" AND DriveStyle=1";
                            }
                        }
                    }
                }

                if(isset($_POST['Fuel'])){
                    $F=$_POST['Fuel'];
                    if($F!="AllFuelTypes"){
                        if($select==0){
                            $searching="WHERE EnergyType='$F'";    
                            $select++;
                        }else{
                            $searching.=" AND EnergyType='$F'";
                        }
                    }
                }
                
                if(isset($_POST['seats'])){
                    $seats=$_POST['seats'];
                    if($seats=='2'){
                        if($select==0){
                            $searching="WHERE Seats>=2";
                            $select++;
                        }else{
                            $searching.=" AND Seats>=2";
                        }
                    }else if($seats=='4'){
                        if($select==0){
                            $searching="WHERE Seats>=4";
                            $select++;
                        }else{
                            $searching.=" AND Seats>=4";
                        }
                    }else if($seats=='6'){
                        if($select==0){
                            $searching="WHERE Seats>=6";
                            $select++;
                        }else{
                            $searching.=" AND Seats>=6";
                        }
                    }else{
                        if($select==0){
                            $searching="WHERE Seats>=8";
                            $select++;
                        }else{
                            $searching.=" AND Seats>=8";
                        }
                    }
                }
                
                if(isset($_POST['Brand'])){
                    $Brand=$_POST['Brand'];
                    if($Brand!=""){
                        if($select==0){
                            $searching="WHERE VehicleBrand='$Brand'";
                            $select++;
                        }else{
                            $searching.=" AND VehicleBrand='$Brand'";
                        }
                    }
                }
                
                if(isset($_POST['Branch'])){
                    $Branch=$_POST['Branch'];
                    if($Branch!=""){
                        if($select==0){
                            $searching="WHERE Branch='$Branch'";
                            $select++;
                        }else{
                            $searching.=" AND Branch='$Branch'";
                        }
                    }
                }

                $Price=$_POST['Price'];
                $search=mysqli_query($con,"SELECT * FROM Vehicle $searching");   
                $arr=[];
                if($Price=="LOW"){
                    $temp=[];
                    while($s=mysqli_fetch_array($search)){
                        $temp[]=$s;
                    }
                    for($i=0;$i<count($temp)-1;$i++){
                        for($j=0;$j<count($temp)-$i-1;$j++){
                            if($temp[$j]['PricePerDay']>$temp[$j+1]['PricePerDay']){
                                $swamp=$temp[$j];
                                $temp[$j]=$temp[$j+1];
                                $temp[$j+1]=$swamp;
                            }
                        }
                    }
                    $arr=$temp;
                }else if($Price=="HIGH"){
                    $temp=[];
                    while($s=mysqli_fetch_array($search)){
                        $temp[]=$s;
                    }
                    for($i=0;$i<count($temp)-1;$i++){
                        for($j=0;$j<count($temp)-$i-1;$j++){
                            if($temp[$j]['PricePerDay']<$temp[$j+1]['PricePerDay']){
                                $swamp=$temp[$j];
                                $temp[$j]=$temp[$j+1];
                                $temp[$j+1]=$swamp;
                            }
                        }
                    }
                    $arr=$temp;
                }else{
                    $temp=[];
                    while($s=mysqli_fetch_array($search)){
                        $temp[]=$s;
                    }
                    for($i=0;$i<count($temp)-1;$i++){
                        for($j=0;$j<count($temp)-$i-1;$j++){
                            if($temp[$j]['Rating']<$temp[$j+1]['Rating']){
                                $swamp=$temp[$j];
                                $temp[$j]=$temp[$j+1];
                                $temp[$j+1]=$swamp;
                            }
                        }
                    }
                    $arr=$temp;
                }
            }else{
                $temp=[];
                $search=mysqli_query($con,"SELECT * FROM Vehicle $searching");
                while($s=mysqli_fetch_array($search)){
                    $temp[]=$s;
                }
                for($i=0;$i<count($temp)-1;$i++){
                    for($j=0;$j<count($temp)-$i-1;$j++){
                        if($temp[$j]['Rating']<$temp[$j+1]['Rating']){
                            $swamp=$temp[$j];
                            $temp[$j]=$temp[$j+1];
                            $temp[$j+1]=$swamp;
                        }
                    }
                }
                $arr=$temp;
            }
            
        ?>
        <div class="Css1">
            <div class="Css2">
                <form method='post'>
                    <div class='Css4'>
                        <h1>Filters</h1>
                        <div class="buttons">
                            <button type='submit' name='search'>Search</button>
                            <button type='submit' name='resetall'>Rest all</button>
                        </div>
                    </div><hr>
                    <div class='Css5'>
                        <h1>Gearbox</h1>
                        <label><input type='radio' name='GearBox' value='Automatic' <?php if($GB=="Automatic"){echo "checked";}?>>Automatic</label>
                        <label><input type='radio' name='GearBox' value='Manual' <?php if($GB=="Manual"){echo "checked";}?>>Manual</label>
                        <label><input type='radio' name='GearBox' value='Both1' <?php if($GB!="Automatic" && $GB!="Manual"){echo "checked";}?>>Both</label><hr>
                        <h1>Vehicle type</h1>
                        <label><input type='radio' name='VehicleType' value='Car' <?php if($VT=="Car"){echo "checked";}?>>Car</label>
                        <label><input type='radio' name='VehicleType' value='Van' <?php if($VT=="Van"){echo "checked";}?>>Vans</label>
                        <label><input type='radio' name='VehicleType' value='Both2' <?php if($VT!="Car" && $VT!="Van"){echo "checked";}?>>Both</label><hr>
                        <h1>Road Capability</h1>
                        <label><input type="radio" name="DriveStyle" value="OffRoad" <?php if($DS=="OffRoad"){echo "checked";}?>>OffRoad</label>
                        <label><input type="radio" name="DriveStyle" value="OnRoad" <?php if($DS=="OnRoad"){echo "checked";}?>>OnRoad</label>
                        <label><input type="radio" name="DriveStyle" value="Both3" <?php if($DS!="OffRoad" && $DS!="OnRoad"){echo "checked";}?>>Both</label><hr>
                        <h1>Fuel Type</h1>
                         <label><input type="radio" name="Fuel" value="Gas" <?php if($F=="Gas"){echo "checked";}?>>Gas</label>
                        <label><input type="radio" name="Fuel" value="Electric" <?php if($F=="Electric"){echo "checked";}?>>Electric</label>
                        <label><input type="radio" name="Fuel" value="Hybrid" <?php if($F=="Hybrid"){echo "checked";}?>>Hybrid</label>
                        <label><input type="radio" name="Fuel" value="AllFuelTypes" <?php if($F!="Gas" && $F!="Electric" && $F!="Hybrid"){echo "checked";}?>>All</label>
                    </div><hr> 
                        <h1>Seats</h1>
                    <div class='Css6'>
                        <label><input type='radio' name='seats' value='2' <?php if($seats=="2"){echo "checked";}?>><p>+2</p></label>
                        <label><input type='radio' name='seats' value='4' <?php if($seats=='4'){echo "checked";}?>><p>+4</p></label>
                        <label><input type='radio' name='seats' value='6' <?php if($seats=="6"){echo "checked";}?>><p>+6</p></label>
                        <label><input type='radio' name='seats' value='8' <?php if($seats=="8"){echo "checked";}?>><p>+8</p></label>
                    </div><hr>
                        <h1>Brand</h1>
                    <select name="Brand">
                        <option value="">All Cars</option>
                        <?php 
                        $selected2="";
                        $arrbrand=[];
                        $brands=mysqli_query($con,"SELECT * FROM Vehicle");
                        while($b=mysqli_fetch_array($brands)){
                            $found1=false;
                            for($i=0;$i<count($arrbrand);$i++){
                                if($arrbrand[$i]==$b['VehicleBrand']){
                                    $found1=true;
                                }
                            }
                            if(!$found1){
                                $arrbrand[]=$b['VehicleBrand'];
                                echo "<option value='".$b['VehicleBrand']."'";
                                if($b['VehicleBrand']==$Brand){
                                    echo "selected";
                                }
                                echo ">".$b['VehicleBrand']."</option>";
                            }
                        }
                        ?>
                    </select><hr>
                        <h1>Price</h1>
                    <select name="Price">
                        <option value="" <?php if($Price!="LOW" && $Price!="HIGH"){echo "selected";}?>>-</option>
                        <option value="LOW"<?php if($Price=="LOW"){echo "selected";}?>>From Low to High</option>
                        <option value="HIGH" <?php if($Price=="HIGH"){echo "selected";}?>>From High to Low</option>
                    </select><hr>
                    <h1>Branch:</h1>
                    <select name="Branch">
                        <option value="">-</option>
                        <?php
                        $arrbracn=[];
                        $locations=mysqli_query($con,"SELECT * FROM Vehicle");
                        while($L=mysqli_fetch_array($locations)){
                            $found2=false;
                            for($i=0;$i<count($arrbracn);$i++){
                                if($arrbracn[$i]==$L['Branch']){
                                    $found2=true;
                                }
                            }
                            if(!$found2){
                                $arrbracn[]=$L['Branch'];
                                echo "<option value='".$L['Branch']."'";
                                if($Branch==$L['Branch']){
                                    echo "selected";
                                }
                                echo ">".$L['Branch']."</option>";
                            }

                        }
                        ?>
                    </select>
                </form>
            </div>
            <div class="Css3"><?php 
                echo "<table>";
                if(count($arr)!=0){
                    foreach ($arr as $c){
                        echo "<tr><td><img src='Pictures/".$c['Image']."'> 
                        <div class='Css7'>
                            <div>
                                <h5>";
                                    if($c['Rating']!=0){
                                        for($i=0;$i<$c['Rating'];$i++){
                                            echo "⭐";
                                        }   
                                    }else{
                                        echo "No ratings yet";
                                    }
                                echo"</h5>
                                <div class='Css9'>
                                    <div>
                                        <h2>".$c['VehicleBrand']."</h2>
                                    </div>
                                    <img src='Pictures/".$c['VehicleLogo']."'>
                                </div>
                                </div>
                                <div class='Css10'>
                                    <div>
                                        <p>".$c['Seats']."</p>
                                        <img src='Pictures/Seats'>
                                    </div>
                                    <div>
                                        <p>".$c['Doors']."</p>
                                        <img src='Pictures/Doors'>
                                    </div>
                                    <div>
                                        <p>".$c['GearBox']."</p>
                                        <img src='Pictures/GearBox'>
                                    </div>
                                    <div>
                                        <p>".$c['EnergyType']."</p>
                                        <img src='Pictures/EnergyType'>
                                    </div>
                                <div>";
                                $Booked=mysqli_query($con,"SELECT * FROM Booking");
                                while($Active=mysqli_fetch_array($Booked)){
                                    if($c['Id']==$Active['VehicleId']){
                                        if($Active['Status']=='Active'){
                                            echo "<h4>Active</h4>";
                                        }
                                        break;
                                    }
                                }
                                echo"</div>
                                </div>
                            <div class='Css10'>
                                <div>
                                    <p>Miles ".$c['Miles']."</p>
                                </div>
                                <div>
                                    <p>";
                                if($c['DriveStyle']==0){
                                    echo "OffRoad";
                                }else{
                                    echo "OnRoad";
                                }
                                    echo"</p>
                                </div>
                        <div><p>HP ".$c['HorsePower']."</p></div></div></div>
                        <div><h3>$".$c['PricePerDay']."/day</h3><br><br><br>";
                        $CarId2=$c['Id'];
                        if(isset($_SESSION['UserId'])){
                            echo"<form method='post'>
                                <input type='hidden' name='Id' value='".$c['Id']."'>
                                <button type='submit' name='select'>select</button>
                            </form></div></td></tr>";
                        }else{
                            echo "<a href='Login.php'>you have to Login</a>";
                        }
                    }
                }else{
                    echo "<div class='Css11'><p>we dont have this Vehicle</p></div>";
                }
                
                CloseCon($con);
                echo "</table>";
            ?></div>
        </div>
    </body>
</html>