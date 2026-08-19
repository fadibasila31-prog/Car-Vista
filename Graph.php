<?php
    include "Nav.php";
    $con=OpenCon();
?>
<!DOCTYPE html>
<html>
    <head>
        <style>
        body{
            font-family: Arial;
            margin:0px;
            margin-top:80px;
            margin-bottom: 40px;
            background: linear-gradient(to left,black 50%,gray 100%);
            display:flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;  
            gap:50px;     
        }
        .Css1{
            background-color: white;
            border-radius: 15px;
            width:1100px;
            padding-left:20px;
            padding-right:20px;
            padding-bottom:20px;
        }
        .Css2{
            margin-top: 20px;
            display: flex;
            align-items: flex-end;
            gap:15px;
            height:300px;
        }
        .Css3{
            display:flex;
            align-items: flex-start;
            gap:20px;
        }
        .Css4{
            position:relative;
            width:300px;
            height:200px;
        }
        .Css5{
            background-color: white;
            padding:0px 10px 5px 10px;
            border-radius: 15px;
        }
        .Css5 h1{
            margin-top:10px;
        }
        .Css6{
            display:inline-block; 
            text-align:center; 
            font-weight:bold; 
            width:10px; 
            height:10px;
        }
        .blocks{
            position:absolute;
            top:50%;
            left:50%;
            width: 14px; 
            height: 14px;
        }
        .TotalBookingStatus{
            border: 2px solid black;
            position: absolute;
            top:43%;
            left:45%;
            padding:5px 10px 5px 10px;
        }
        </style>
    </head>
    <body>
        <div class="Css3">
            <div class="Css1">
                <h1>Total Booking Per Branch</h1>
                <div>
                    <?php
                        $arr2=[];
                        $Locations=mysqli_query($con,"SELECT * FROM Vehicle");
                        while($L=mysqli_fetch_array($Locations)){
                            $found=false;
                            foreach($arr2 as $a){
                                if($a['Branch']==$L['Branch']){
                                    $found=true;
                                }
                            }
                            if(!$found){
                                $arr2[]=$L;
                            }
                        }
                        
                        $max1=0;
                        foreach($arr2 as $a){
                            $cnt=0;
                            $Locations=mysqli_query($con,"SELECT * FROM Vehicle");
                            while($L=mysqli_fetch_array($Locations)){
                                if($a['Branch']==$L['Branch']){
                                    $cnt++;
                                }
                            }
                            if($cnt>$max1){
                                $max1=$cnt;
                            }
                        }

                        foreach($arr2 as $a){
                            echo $a['Branch'];
                            $cnt=0;
                            $Vehicles=mysqli_query($con,"SELECT * FROM Vehicle");
                            while($v=mysqli_fetch_array($Vehicles)){
                                if($a['Branch']==$v['Branch']){
                                    $Booking=mysqli_query($con,"SELECT * FROM Booking");
                                    while($b=mysqli_fetch_array($Booking)){
                                        if($v['Id']==$b['VehicleId']){  
                                            $cnt++;
                                        }
                                    }
                                }
                            }
                            
                            $Width=0;
                            if($max1!=0){
                                $Width=($cnt/$max1)*1100;
                            }
                            echo "<div style='width:".$Width."px; background-color:#bfc4c7 ; color:black; padding:5px 10px 5px 10px; border-radius:10px;'>".$cnt."</div><br>";
                        }                    
                    ?>
                </div>
            </div>

            
            <?php
                $Waiting=0;
                $Active=0;
                $Finished=0;
                $Canceled=0;
                $totalBooking=0;

                $Booking=mysqli_query($con,"SELECT * FROM Booking");
                while($b=mysqli_fetch_array($Booking)){
                    if($b['Status']=="Waiting"){
                        $Waiting++;
                    }else if($b['Status']=="Active"){
                        $Active++;
                    }else if($b['Status']=="Finished"){
                        $Finished++;
                    }else if($b['Status']=="Canceled"){
                        $Canceled++;
                    }

                    $totalBooking++;
                }

                $totalBlocks=40;
                $Finished2="";
                $Waiting2="";
                $Active2="";
                $Canceled2="";


                if ($totalBooking > 0) {
                    $Finished2 = round(($Finished / $totalBooking) * $totalBlocks);
                    $Waiting2 = round(($Waiting / $totalBooking) * $totalBlocks);
                    $Active2 = round(($Active / $totalBooking) * $totalBlocks);
                    $Canceled2 = round(($Canceled / $totalBooking) * $totalBlocks);
                }
            ?>
            <div class="Css5">
                <h1>Booking Status</h1>
                <div class="Css4">
                    <div class="TotalBookingStatus">
                        <?php echo $totalBooking."<div style='font-size:12px;'>Total</div>"; ?>
                    </div>
                    <?php
                        $currentIndex=0;

                        for($i=0;$i<$Finished2;$i++){
                            $deg=$currentIndex * (360/$totalBlocks);
                            $currentIndex++;
                            echo "<div class='blocks' style='transform: rotate(".$deg."deg) translateY(-70px); background-color:green;'></div>";
                        }

                        for($i=0;$i<$Waiting2;$i++){
                            $deg=$currentIndex * (360/$totalBlocks);
                            $currentIndex++;
                            echo "<div class='blocks' style='transform: rotate(".$deg."deg) translateY(-70px); background-color:blue;'></div>";
                        }

                        for($i=0;$i<$Active2;$i++){
                            $deg=$currentIndex * (360/$totalBlocks);
                            $currentIndex++;
                            echo "<div class='blocks' style='transform: rotate(".$deg."deg) translateY(-70px); background-color:gold;'></div>";
                        }

                        for($i=0;$i<$Canceled2;$i++){
                            $deg=$currentIndex * (360/$totalBlocks);
                            $currentIndex++;
                            echo "<div class='blocks' style='transform: rotate(".$deg."deg) translateY(-70px); background-color:red;'></div>";
                        }

                        
                    ?>
                </div>
                <?php echo "Finished ".$Finished." <div class='Css6' style='background-color:green;'></div>"; ?>
                <?php echo "Waiting ".$Waiting." <div class='Css6' style='background-color:blue;'></div><br><br>"; ?>
                <?php echo "Active ".$Active." <div class='Css6' style='background-color:gold;'></div>"; ?>
                <?php echo "Canceled ".$Canceled." <div class='Css6' style='background-color:red;'></div>"; ?>
            </div>
            
        </div>

        <?php
            $arr3=[];
            $Months2=["January","February","March","April","May","June","July","August","September","October","November","December"];

            $BiggestYear=0;
            $Booking=mysqli_query($con,"SELECT * FROM Booking");
            while($b=mysqli_fetch_array($Booking)){
                $year = $b['StartDate'][0].$b['StartDate'][1].$b['StartDate'][2].$b['StartDate'][3];
                $found=false;
                foreach($arr3 as $a){
                    if($a==$year){
                        $found=true;
                    }
                }

                if($year>$BiggestYear){
                    $BiggestYear=$year;
                }

                if(!$found){
                    $arr3[]=$year;
                }
            }

            $Booking=mysqli_query($con,"SELECT * FROM Booking");
            while($b=mysqli_fetch_array($Booking)){
                $year = $b['EndDate'][0].$b['EndDate'][1].$b['EndDate'][2].$b['EndDate'][3];
                $found=false;
                foreach($arr3 as $a){
                    if($a==$year){
                        $found=true;
                    }
                }

                if($year>$BiggestYear){
                    $BiggestYear=$year;
                }

                if(!$found){
                    $arr3[]=$year;
                }
            }

            for($i=0;$i<count($arr3)-1;$i++){
                for($j=0;$j<count($arr3)-1-$i;$j++){
                    if($arr3[$j] < $arr3[$j+1]){
                        $temp=$arr3[$j];
                        $arr3[$j]=$arr3[$j+1];
                        $arr3[$j+1]=$temp;
                    }
                }
            }

            $SearchYear2=$BiggestYear;
                    
            if(isset($_POST['SearchYear2'])){
                $SearchYear2=$_POST['MoneyEarnings'];
            }
        ?>
        <div class="Css1">
            <h1>Monthly Earnings <?php echo $SearchYear2; ?></h1>
            <form method="POST">
                <select name="MoneyEarnings">
                    <option value="<?php echo $BiggestYear ?>"><?php echo $BiggestYear ?></option>
                    <?php
                        foreach($arr3 as $a){
                            if($a!=$BiggestYear){
                                echo "<option value='".$a."'";
                                if($a==$SearchYear2){
                                    echo " selected";
                                }
                                echo ">".$a."</option>";
                            }
                        }
                    ?>
                </select>
                <button type="submit" name="SearchYear2">Search</button>
            </form>
            <div>
               <?php
                    $Days=[31,28,31,30,31,30,31,31,30,31,30,31];
                    $Prices=[0,0,0,0,0,0,0,0,0,0,0,0];
                    $Booking=mysqli_query($con,"SELECT * FROM Booking");
                    while($b=mysqli_fetch_array($Booking)){
                        $cnt=0;
                        $VehiclePrice=0;

                        $StartYear="";
                        $EndYear="";

                        $StartYear=(int)$b['StartDate'][0].$b['StartDate'][1].$b['StartDate'][2].$b['StartDate'][3];
                        $EndYear=(int)$b['EndDate'][0].$b['EndDate'][1].$b['EndDate'][2].$b['EndDate'][3];
                        $StartMonth=(int)$b['StartDate'][5].$b['StartDate'][6];
                        $EndMonth=(int)$b['EndDate'][5].$b['EndDate'][6];
                        $StartDate=(int)$b['StartDate'][8].$b['StartDate'][9];
                        $EndDate=(int)$b['EndDate'][8].$b['EndDate'][9];

                        $Vehicles=mysqli_query($con,"SELECT * FROM Vehicle");
                        while($v=mysqli_fetch_array($Vehicles)){
                            if($b['VehicleId']==$v['Id']){
                                $VehiclePrice=$v['PricePerDay'];
                            }
                        }

                        if($StartYear<=$SearchYear2 && $EndYear<=$SearchYear2){
                            $cnt=0;

                            if($StartYear==$EndYear){
                                if($StartYear%4==0){
                                    $Days[1]=29;
                                }else{
                                    $Days[1]=28;
                                }

                                if($StartMonth==$EndMonth){
                                    for($i=0;$i<count($Days);$i++){
                                        if($i+1==$StartMonth){
                                            for($j=$StartDate;$j<=$EndDate;$j++){
                                                $cnt++;
                                            }

                                            $Prices[$i]+=$cnt*$VehiclePrice;
                                            break;
                                        }
                                    }
                                }else{
                                    for($i=0;$i<count($Days);$i++){
                                        if($i+1==$StartMonth){
                                            for($j=$StartDate;$j<=$Days[$i];$j++){
                                                $cnt++;
                                            }
                                            $Prices[$i]+=$cnt*$VehiclePrice;
                                            $cnt=0;
                                        }else if($i+1==$EndMonth){
                                            for($j=1;$j<=$EndDate;$j++){
                                                $cnt++;
                                            }
                                            $Prices[$i]+=$cnt*$VehiclePrice;
                                            break;
                                        }else if($i+1>$StartMonth && $i+1<$EndMonth){
                                            for($j=1;$j<=$Days[$i];$j++){
                                                $cnt++;
                                            }
                                            $Prices[$i]+=$cnt*$VehiclePrice;
                                            $cnt=0;
                                        }
                                    }
                                    
                                }
                            }else{
                                $CurrentYear=$StartYear;

                                while($CurrentYear<=$EndYear){
                                    if($CurrentYear%4==0){
                                        $Days[1]=29;
                                    }else{
                                        $Days[1]=28;
                                    }

                                    if($CurrentYear==$StartYear){
                                        for($i=0;$i<count($Days);$i++){
                                            if($i+1==$StartMonth){
                                                for($j=$StartDate;$j<=$Days[$i];$j++){
                                                    $cnt++;
                                                }
                                                $Prices[$i]+=$cnt*$VehiclePrice;
                                                $cnt=0;
                                            }else if($i+1>$StartMonth){
                                                for($j=1;$j<=$Days[$i];$j++){
                                                    $cnt++;
                                                }
                                                $Prices[$i]+=$cnt*$VehiclePrice;
                                                $cnt=0;
                                            }
                                        }
                                    }else if($CurrentYear==$EndYear){
                                        for($i=0;$i<count($Days);$i++){
                                            if($i+1==$EndMonth){
                                                for($j=1;$j<=$EndDate;$j++){
                                                    $cnt++;
                                                }
                                                $Prices[$i]+=$cnt*$VehiclePrice;
                                                $cnt=0;
                                                break;
                                            }else if($i+1<$EndMonth){
                                                for($j=1;$j<=$Days[$i];$j++){
                                                    $cnt++;
                                                }
                                                $Prices[$i]+=$cnt*$VehiclePrice;
                                                $cnt=0;
                                            }
                                        }
                                    }else{
                                        for($i=0;$i<count($Days);$i++){
                                            $Prices[$i]+=$Days[$i]*$VehiclePrice;
                                        }
                                    }

                                    $CurrentYear++;
                                }
                            }
                        }else if($StartYear<=$SearchYear2){
                            $CurrentYear=$StartYear;
                            $cnt=0;

                            while($CurrentYear<=$SearchYear2){
                                if($CurrentYear%4==0){
                                    $Days[1]=29;
                                }else{
                                    $Days[1]=28;
                                }

                                if($CurrentYear==$StartYear){
                                    for($i=0;$i<count($Days);$i++){
                                        if($i+1==$StartMonth){
                                            for($j=$StartDate;$j<=$Days[$i];$j++){
                                                $cnt++;
                                            }
                                            $Prices[$i]+=$cnt*$VehiclePrice;
                                            $cnt=0;
                                        }else if($i+1>$StartMonth){
                                            for($j=1;$j<=$Days[$i];$j++){
                                                $cnt++;
                                            }
                                            $Prices[$i]+=$cnt*$VehiclePrice;
                                            $cnt=0;
                                        }
                                    }
                                }else{
                                    for($i=0;$i<count($Days);$i++){
                                        $Prices[$i]+=$Days[$i]*$VehiclePrice;
                                    }
                                }

                                $CurrentYear++;
                            }
                        }
                    }

                    $sum=0;
                    for($i=0;$i<count($Prices);$i++){
                        $sum+=$Prices[$i];
                    }
                    
                    echo "<div class='Css2'>";
                    for($i=0;$i<count($Prices);$i++){
                        
                        $height=0;
                        if($sum!=0){
                            $height=($Prices[$i]/$sum)*270;
                        }

                        echo "<center><div><div style='height:".$height."px; display:flex; justify-self:center; align-items:flex-end; font-weight: bold;  background-color:#bfc4c7 ; color:black; padding:5px 10px 5px 10px; '>$".$Prices[$i]."</div>".$Months2[$i]."</div></center>";
                    }
                    echo "</div>";
               ?>
            </div>
        </div>


        <?php
            $arr=[];

            $BiggestYear=0;

            $Booking=mysqli_query($con,"SELECT * FROM Booking");
            while($b=mysqli_fetch_array($Booking)){
                $year = $b['StartDate'][0].$b['StartDate'][1].$b['StartDate'][2].$b['StartDate'][3];
                $found=false;
                foreach($arr as $a){
                    if($a==$year){
                        $found=true;
                    }
                }

                if($year>$BiggestYear){
                    $BiggestYear=$year;
                }

                if(!$found){
                    $arr[]=$year;
                }
            }
            
            $Booking=mysqli_query($con,"SELECT * FROM Booking");
            while($b=mysqli_fetch_array($Booking)){
                $year = $b['EndDate'][0].$b['EndDate'][1].$b['EndDate'][2].$b['EndDate'][3];
                $found=false;
                foreach($arr as $a){
                    if($a==$year){
                        $found=true;
                    }
                }

                if($year>$BiggestYear){
                    $BiggestYear=$year;
                }

                if(!$found){
                    $arr[]=$year;
                }
            }

            for($i=0;$i<count($arr)-1;$i++){
                for($j=0;$j<count($arr)-1-$i;$j++){
                    if($arr[$j] < $arr[$j+1]){
                        $temp=$arr[$j];
                        $arr[$j]=$arr[$j+1];
                        $arr[$j+1]=$temp;
                    }
                }
            }

            $SearchYear=$BiggestYear;
                    
            if(isset($_POST['SearchYear'])){
                $SearchYear=$_POST['Year'];
            }
        ?>
        <div class="Css1">
            <h1>Monthly Bookings <?php echo $SearchYear; ?></h1>
            <form method="POST">
                <select name="Year">
                    <option value="<?php echo $BiggestYear ?>"><?php echo $BiggestYear ?></option>
                    <?php
                        foreach($arr as $a){
                            if($a!=$BiggestYear){
                                echo "<option value='".$a."'";
                                if($a==$SearchYear){
                                    echo " selected";
                                }
                                echo">".$a."</option>";
                            }
                        }
                    ?>
                </select>
                <button type="submit" name="SearchYear">Search</button>
            </form>
            <div>
               <?php
                    $Months=[];
                    for($i=1;$i<=12;$i++){
                        $Months[$i]=0;
                    }
                    
                    $totalBookings=0;
                    $Booking=mysqli_query($con,"SELECT * FROM Booking");
                    while($b=mysqli_fetch_array($Booking)){
                        $StartYear="";
                        $EndYear="";

                        $StartYear=(int)$b['StartDate'][0].$b['StartDate'][1].$b['StartDate'][2].$b['StartDate'][3];
                        $EndYear=(int)$b['EndDate'][0].$b['EndDate'][1].$b['EndDate'][2].$b['EndDate'][3];
                        $StartMonth=(int)($b['StartDate'][5].$b['StartDate'][6]);
                        $EndMonth=(int)($b['EndDate'][5].$b['EndDate'][6]);

                        if($StartYear<=$SearchYear && $EndYear<=$SearchYear){
                            $CurrentYear=$StartYear;

                            while($CurrentYear<=$EndYear){
                                if($StartYear==$EndYear){
                                    for($i=$StartMonth;$i<=$EndMonth;$i++){
                                        $Months[$i]++;
                                    }
                                }else{
                                    if($CurrentYear==$StartYear){
                                        for($i=$StartMonth;$i<=12;$i++){
                                            $Months[$i]++;
                                        }
                                    }else if($CurrentYear==$EndYear){
                                        for($i=1;$i<=$EndMonth;$i++){
                                            $Months[$i]++;
                                        }
                                    }else{
                                        for($i=1;$i<=12;$i++){
                                            $Months[$i]++;
                                        }
                                    }
                                }
                                $CurrentYear++;
                            }
                            $totalBookings++;
                        }else if($StartYear<=$SearchYear){
                            $CurrentYear=$StartYear;

                            while($CurrentYear<=$SearchYear){
                                if($CurrentYear==$StartYear){
                                    for($i=$StartMonth;$i<=12;$i++){
                                        $Months[$i]++;
                                    }
                                }else{
                                    for($i=1;$i<=12;$i++){
                                        $Months[$i]++;
                                    }
                                }

                                $CurrentYear++;
                            }
                            $totalBookings++;
                        }

                    }

                    echo "<div class='Css2'>";
                    for($i=1;$i<=12;$i++){
                        $height=0;
                        if($totalBookings!=0){
                            $height=($Months[$i]/$totalBookings)*270;
                        }
                        
                    
                        echo "<div><div style='height:".$height."px; width:10px; display:flex; align-items: flex-end; justify-self:center; background-color:#bfc4c7 ; color:black; padding:5px 10px 5px 10px; '>".$Months[$i]."</div>".$Months2[$i-1]."</div>";
                    }
                    echo "</div>";
               ?>
            </div>
        </div>
    </body>
</html>