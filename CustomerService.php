<?php
    include "Nav.php";
    $con=OpenCon();
    
    $Searched=false;
    $message="";
    $Fname="";        
    $Lname="";
    $Status="";
    $message11="";
    $arr=[];
    $Role="Worker";
    if(isset($_SESSION['Role'])){// true false
        $Role=$_SESSION['Role'];
    
    if(isset($_POST['Search'])){// true false

        if(isset($_POST['Status'])){// true false
            if($_POST['Status']=="ON"){// true false
                $Status=1;
            }else if($_POST['Status']=="OFF"){// true false
                $Status=0;
            }
        }

        if(isset($_POST['FirstName'])){// true false
            $Fname=trim($_POST['FirstName']);
        }   

        if(isset($_POST['LastName'])){// true false
            $Lname=$_POST['LastName'];
        }

        $arr2=[];
        $Customers=mysqli_query($con,"SELECT * FROM Users");
        while($c=mysqli_fetch_array($Customers)){
            $Referense=mysqli_query($con,"SELECT * From Referense WHERE HandledBy='$Role'");
            while($R=mysqli_fetch_array($Referense)){
                if((strtolower($c['FirstName'])==strtolower($Fname)) || (strtolower($c['LastName'])==strtolower($Lname))){// true false
                    if(isset($Status) && $Status!=""){// true false 
                        if((strtolower($c['FirstName'])==strtolower($Fname) || strtolower($c['LastName'])==strtolower($Lname)) && $R['Status']==$Status && $c['Id']==$R['CustomerId']){// true false
                            $arr2[]=$R;
                        }
                    }else if(((strtolower($c['FirstName'])==strtolower($Fname)) || (strtolower($c['LastName'])==strtolower($Lname))) && $c['Id']==$R['CustomerId']){// true false
                        $arr2[]=$R;                        
                    }
                }else if($Status!="" && $Fname=="" && $Lname==""){// true false
                    if($R['Status']==$Status){// true false
                        $arr2[]=$R;                            
                    }
                }
            }
        }
        
        for($i=0;$i<count($arr2);$i++){
            $found=false;
            for($j=0;$j<count($arr);$j++){
                if($arr[$j]['ReferenceId']==$arr2[$i]['ReferenceId']){// true false
                    $found=true;
                }
            }
            
            if(!$found){// true false
                $arr[]=$arr2[$i];
            }
        }
        $Searched=true;
    }else if(isset($_POST['Recent'])){// true false
        if(isset($_POST['Status'])){// true false
            if($_POST['Status']=="ON"){// true false
                $Status=1;
            }else if($_POST['Status']=="OFF"){// true false
                $Status=0;
            }
        }                    
        
        if(isset($_POST['FirstName'])){// true false
            $Fname=trim($_POST['FirstName']);
        }   

        if(isset($_POST['LastName'])){// true false
            $Lname=trim($_POST['LastName']);
        }
        
        $arr=[];
        $arr2=[];
        $arr3=[];
        if($Fname != "" || $Lname != "" || (isset($Status) && $Status!="")){// true false
            if(isset($Status) && $Status!=""){// true false
                $Referense=mysqli_query($con,"SELECT * From Referense WHERE HandledBy='$Role' AND Status='$Status'");
            }else{
                $Referense=mysqli_query($con,"SELECT * From Referense WHERE HandledBy='$Role'");
            }
            
            while($R=mysqli_fetch_array($Referense)){
                $Customers=mysqli_query($con,"SELECT * FROM Users");
                while($c=mysqli_fetch_array($Customers)){
                    if(strtolower($c['FirstName'])==strtolower($Fname) || strtolower($c['LastName'])==strtolower($Lname)){// true false
                        if($Status!=""){// true false
                            if((strtolower($c['FirstName'])==strtolower($Fname) || strtolower($c['LastName'])==strtolower($Lname)) && $R['Status'] ==$Status && $c['Id']==$R['CustomerId']){// true faslse
                                $arr2[]=$R;
                            }
                        }elseif(((strtolower($c['FirstName'])==strtolower($Fname)) || (strtolower($c['LastName'])==strtolower($Lname))) && $c['Id']==$R['CustomerId']){// true false
                            $arr2[]=$R;
                        }
                    }else if($Status!=""  && $Fname=="" && $Lname==""){// true false
                        if($R['Status']==$Status){// true false
                            $arr2[]=$R;
                        }
                    }
                }
            }
        }else{
            $Referense=mysqli_query($con,"SELECT * From Referense WHERE HandledBy='$Role'");            
            while($R=mysqli_fetch_array($Referense)){
                $arr2[]=$R;
            }
        }
                    
        for($i=0;$i<count($arr2);$i++){
            $found=false;
            for($j=0;$j<count($arr3);$j++){
                if($arr3[$j]['ReferenceId']==$arr2[$i]['ReferenceId']){// true false
                    $found=true;
                }
            }
            
            if(!$found){// true false
                $arr3[]=$arr2[$i];
            }
        }
    
        for($i=count($arr3)-1;$i>=0;$i--){
            $arr[]=$arr3[$i];
        }

        if(count($arr)==0){
            $_SESSION['Message']="<h2>No messages found.</h2>";
        }
        $Searched=true;
    }else if(isset($_POST['Close'])){// true false
        $RId=$_POST['ReferenceId'];
        mysqli_query($con,"UPDATE Referense SET Status=0 WHERE ReferenceId=$RId");
    }else if(isset($_POST['Escalate'])){// true false
        $RId=$_POST['ReferenceId'];
        mysqli_query($con,"UPDATE Referense SET HandledBy='Manager' WHERE ReferenceId=$RId");
    }else if(isset($_POST['AllMessages'])){// for Manager only // true false

        if(isset($_POST['Status'])){// true false
            if($_POST['Status']=="ON"){// true false
                $Status=1;
            }else if($_POST['Status']=="OFF"){// true false
                $Status=0;
            }
        }
        
        if(isset($_POST['FirstName']) && trim($_POST['FirstName'])!=""){// true false
            $Fname=$_POST['FirstName'];
        }   

        if(isset($_POST['LastName']) && trim($_POST['LastName'])!=""){// true false
            $Lname=$_POST['LastName'];
        }
        
        $arr2=[];
        $Customers=mysqli_query($con,"SELECT * FROM Users");
        while($c=mysqli_fetch_array($Customers)){
            $Referense=mysqli_query($con,"SELECT * From Referense");
            while($R=mysqli_fetch_array($Referense)){
                if(((strtolower($c['FirstName'])==strtolower($Fname)) || (strtolower($c['LastName'])==strtolower($Lname)))){// true false
                    
                    if($Status!=""){// true false
                        if((strtolower($c['FirstName'])==strtolower($Fname) || strtolower($c['LastName'])==strtolower($Lname)) && $R['Status']==$Status && $c['Id']==$R['CustomerId']){// true false
                            $arr2[]=$R;
                        }
                    }else if((strtolower($c['FirstName'])==strtolower($Fname) || strtolower($c['LastName'])==strtolower($Lname)) && $c['Id']==$R['CustomerId']){// true false
                        $arr2[]=$R;                            
                    }
                }else if($Status!=""  && $Fname=="" && $Lname==""){// true false
                    if($R['Status']==$Status){// true false
                        $arr2[]=$R;                            
                    }
                }
            }
        }
        
        for($i=0;$i<count($arr2);$i++){
            $found=false;
            for($j=0;$j<count($arr);$j++){
                if($arr[$j]['ReferenceId']==$arr2[$i]['ReferenceId']){// true false
                    $found=true;
                }
            }
            if(!$found){// true false
                $arr[]=$arr2[$i];
            }
        }
        $message11=count($arr)." ".$Status." ".$Fname." ".$Lname;
        if(count($arr)==0 && $Status=="" && $Fname=="" && $Lname==""){// true false
            $Referense=mysqli_query($con,"SELECT * FROM Referense");
            while($R=mysqli_fetch_array($Referense)){
                $arr[]=$R;
            }
        }else{
            $_SESSION['Message']="<h2>No messages found.</h2>";
        }
        $Searched=true;
    }else if(isset($_POST['SendReply'])){// true false
        $text=$_POST['MessageReplay'];
        if(trim($text)!=""){// true false
            $ReferenseId=$_POST['ReferenceId'];
            $email="";
            $RId="";
            $CId="";
            $fullConv="";
            $Referenses=mysqli_query($con,"SELECT * FROM Referense");
            while($R=mysqli_fetch_array($Referenses)){
                if($R['ReferenceId']==$ReferenseId){// true false
                    $CId=$R['CustomerId'];
                    $RId=$R['ReferenseId'];
                    $fullConv=$R['Conversation'];
                    break;
                }
            }
        
            if($CId!=""){// true false
                $Customer=mysqli_query($con,"SELECT * FROM Users");
                while($c=mysqli_fetch_array($Customer)){
                    if($c['Id']==$CId){// true false
                        $email=$c['Gmail'];
                        break;
                    }
                }
                $fullConv.="\n[".date("d/m/Y H:i")."] ".$_SESSION['UserFullName'].": ".$text;
                $to=$email;
                $subject = "Reply to your message";
                $message2=$fullConv;
                $header="From: minimarket@example.com\r\n";
                
                $retval=mail($to,$subject,$message2,$header);

                if($retval){// true false
                    mysqli_query($con,"UPDATE Referense SET Conversation='$message2' WHERE ReferenceId='$ReferenseId'");
                    $_SESSION['Message']="<h3>Message sent successfully.</h3>";
                    header("Location: CustomerService.php");
                    exit();
                }else{
                    $_SESSION['Message']="<h2>Message could not be sent...</h2>";
                    header("Location: CustomerService.php");
                    exit();                                
                }
            }
        }else{
            $_SESSION['Message']="<h2>you cant send empty message.</h2>";
            header("Location: CustomerService.php");
            exit();                        
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
                margin: 0px;
                background-color: #c5c5c7;
            }
            .Css1{
                margin-top: 100px;
                margin-left: 60px;
                margin-right: 60px;
            }
            .Css1 nav{
                display:flex;
                gap: 20px;
                padding-left: 20px;
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
            }
            .Css1 nav a:hover{
                color:blue;
                border:2px blue solid;
            }    
            .Css1 form{
                display: flex;
                gap: 20px;
            }        
            .Css2{
                display: flex;
                flex-direction: column;
                justify-content: center;
                gap: 10px;
            }
            .Css3{
                display: flex;
                flex-direction: column;
            }
            .Css4{
                display:flex;
                justify-content: center;
                align-items: center;
            }    
            .CssClosed{
                display:flex;
                justify-content: center;
                align-items: center;
                font-weight: bold;
                color:red;
                font-size: 20px;
            }       
            h1{
                background-color: #007bff;
                padding: 10px;
                color: white;
                border-radius: 5px;
            }
            h2{
                background:white;
                color:red;
                display:flex;
                justify-self: center;
                padding:12px;
                border-radius:6px;
                margin-top:40px;
            }
            h3{
                background:white;
                color:green;
                display:flex;
                justify-self: center;                
                padding:12px;
                border-radius:6px;
                margin-top:40px;                
            }
            table{
                margin-top: 30px;
                display:flex;
                justify-content: center;                
                border-spacing: 0px;
            }
             td{
                background-color: white;
                border: 2px solid lightgray;
                padding-top:5px;
                padding-bottom:5px;
                width: 120px;
                text-align: center;
            }
            th{
                margin-top:5px;
                padding-top:5px;
                padding-bottom:5px;
                color:white;
                background-color: dodgerblue;
                width:150px;
            }
            #thLeft{
                border-top-left-radius:10px;
            }
            #thRight{
                border-top-right-radius: 10px;
            }
            input[type="radio"]{
                display: none;
            }
            input[type="radio"]:checked + span{
                border:2px solid greenyellow;
            }
            span{
                border:2px solid black;
                cursor: pointer;
                padding: 3px;
                background-color: white;
            }
            textarea{
                width:350px;
                height: 50px;
                margin:5px;
            }
            #Textarea{
            }
            hr{
                background-color:black;
                height: 5px;
            }
            button{
                cursor: pointer;
            }
            #text{
                text-align: center;
                font-size:20px;
            }
            #Close{
                width:20vh;
            }
            #Close form{
                display:flex;
                justify-content: center;
                align-content: center;
            }
            #Close button{
                font-size: 20px;
                border:3px black solid;
                border-radius: 10px;
                font-weight: bold;
            }
            #Close button:hover{
                color:blue;
                background-color: yellow;
                border:3px blue solid;
            }
            #Escalate{
                width:20vh;
            }
            #Escalate form{
                display:flex;
                justify-content: center;
            }
            #Escalate button{
                font-size: 20px;
                border:3px black solid;
                border-radius: 10px;
            }
            #Escalate button:hover{
                color:blue;
                border:3px blue solid;
                background-color: yellow;
            }
            #Conversation{
                width:400px;
            }
            #StatusClose:hover{
                background-color: red;
                color: white;
                border:2px solid blue
            }
            #StatusOpen:hover{
                background-color: green;
                color:white;
                border:2px solid blue;
            }
            #RecentSearchViewAll{
                border-radius: 5px;
                border:2px solid black;                
                font-weight: bold;
                margin-top:20px;
                padding-top:5px;
                padding-bottom:5px;
                padding-left:10px;
                padding-right:10px;
            }
            #RecentSearchViewAll:hover{
                border:2px solid blue;
                color:blue;
            }
            #SendReply{
                margin-left: 120px;
                margin-right: 120px;
                border-radius: 5px;
                border:2px solid black;
                font-weight: bold;
            }
            #SendReply:hover{
                color:white;
                border:2px solid blue;
                background-color: green;
            }
        </style>
    </head>
    <body>
        <div class="Css1">
            <nav>
                <a href="#Search">Search</a>
                <a href="#Open">Open Messages</a>
                <a href="#CloseMasseges">Close Messages</a>
            </nav>
            <h1 id="Search">Search Messages</h1>
            <?php if(isset($_SESSION['Message'])){echo $_SESSION['Message']; unset($_SESSION['Message']);}// true false ?>
            <form method="POST">
                <div>
                    <label style="display: block;">Customer First Name:</label>
                    <input type="text" name="FirstName" placeholder="Customer First Name....">
                </div>
                <div>
                    <label style="display: block;">Customer Last Name:</label>
                    <input type="text" name="LastName" placeholder="Customer Last Name....">
                </div>
                <div class="Css3">
                    <label style="text-align:center; display: block;">Status</label>
                    <div style="margin-top:5px;">
                        <label>
                            <input type="radio" name="Status" value="ON">
                            <span id="StatusOpen">OPEN</span>
                        </label>
                        <label>
                            <input type="radio" name="Status" value="OFF">
                            <span id="StatusClose">CLOSE</span>
                        </label>
                    </div>
                </div>
                <button id="RecentSearchViewAll" type="submit" name="Recent">Recent Messages</button>
                <button id="RecentSearchViewAll" type="submit" name="Search">Search</button>
                <?php if(isset($Role)){// for Manager only true false
                    if($Role=="Manager"){
                        echo "<button id='RecentSearchViewAll' type='submit' name='AllMessages'>View All Messages</button>";
                    }
                }
                ?>
            </form>
            <?php
                if($Searched){
                    echo $message11;
            ?>
            <table>
                <tr>
                    <th id="thLeft">Customer Name</th>
                    <th>Subject</th>
                    <th>Conversation</th>
                    <th>Reply</th>
                    <th <?php if(isset($_SESSION['Role']) && $_SESSION['Role']=="Manager"){?>id="thRight" <?php }?>>Close</th>
                    <?php 
                        if(isset($_SESSION['Role']) && $_SESSION['Role']=="Worker"){// true false
                            echo "<th id='thRight'>Escalate to Manager</th>";
                        } 
                    ?>
                </tr>
                    <?php
                        for($i=0;$i<count($arr);$i++){
                            echo"<tr>
                            <td id='text'>";
                            $Customers=mysqli_query($con,"SELECT * FROM Users");
                            while($c=mysqli_fetch_array($Customers)){
                                if($arr[$i]['CustomerId']==$c['Id']){// true false
                                    echo $c['FirstName']." ".$c['LastName'];
                                    break;
                                }
                            }
                            echo"</td>
                            <td id='text'>".$arr[$i]['Subject']."</td>
                            <td id='Conversation'><textarea>".$arr[$i]['Conversation']."</textarea></td>
                            <td id='Textarea'>";
                            if($arr[$i]['Status']==1){// true false
                                echo "<form method='POST'><div class='Css2'><textarea name='MessageReplay'></textarea><input type='hidden' name='ReferenceId' value='".$arr[$i]['ReferenceId']."'><button type='submit' name='SendReply'>Send Reply</button></div></form>";
                            }else{
                                echo "<div class='CssClosed'>Closed</div>";
                            }
                            echo "</td><td id='Close'>";
                            if($arr[$i]['Status']==1){// true false
                                echo "<form method='POST'><input type='hidden' name='ReferenceId' value='".$arr[$i]['ReferenceId']."'><button type='submit' name='Close'>Close</button></form>";
                            }else{
                                echo "<div class='CssClosed'>Closed</div>";
                            }
                            echo "</td>";
                            if(isset($_SESSION['Role']) && $_SESSION['Role']=="Worker"){// true false
                                if($arr[$i]['Status']==1){// true false
                                    echo "<td id='Escalate'>
                                        <form method='POST'>
                                            <input type='hidden' name='ReferenceId' value='".$arr[$i]['ReferenceId']."'>
                                            <button type='submit' name='Escalate'>Escalate</button>
                                        </form>
                                    </td>";
                                }else{
                                    echo "<td><div class='CssClosed'>Closed</div></td>";
                                }
                            } echo"
                            </tr>";
                        }
                    ?>
            </table><br><hr>
            <?php }?>
            <br>
            <h1 id="Open">Open Messages</h1>
            <table>
                <tr>
                    <th id="thLeft">Customer Name</th>
                    <th>Subject</th>
                    <th>Conversation</th>
                    <th>Reply</th>
                    <th <?php if(isset($_SESSION['Role']) && $_SESSION['Role']=="Manager"){?>id="thRight" <?php }?>>Close</th>
                    <?php 
                        if(isset($Role)){// true false
                            if($Role=="Worker"){
                                echo "<th id='thRight'>Escalate to Manager</th>";
                            }
                        } 
                    ?>
                </tr>
                    <?php
                        $OpenReferense=mysqli_query($con,"SELECT * FROM Referense WHERE HandledBy='$Role' AND Status=1");
                        while($OR=mysqli_fetch_array($OpenReferense)){
                            if($OR['Status']==1){// true false
                                echo "<tr><td>";
                                    $Customers2=mysqli_query($con,"SELECT * FROM Users");
                                    while($c2=mysqli_fetch_array($Customers2)){
                                        if($c2['Id']==$OR['CustomerId']){// true false
                                            echo $c2['FirstName']." ".$c2['LastName'];
                                            break;
                                        }
                                    }
                                echo "</td>
                                <td>".$OR['Subject']."</td>
                                <td id='Conversation'><div class='Css4'><textarea>".$OR['Conversation']."</textarea></div></td>
                                <td id='Textarea'><div class='Css4'><form method='POST'><div class='Css2'><textarea name='MessageReplay'></textarea><input type='hidden' name='ReferenceId' value='".$OR['ReferenceId']."'><button id='SendReply' type='submit' name='SendReply'>Send Reply</button></div></form></td>
                                <td id='Close'><form method='POST'><input type='hidden' name='ReferenceId' value='".$OR['ReferenceId']."'><button type='submit' name='Close'>Close</button></form></div></td>";
                                if(isset($_SESSION['Role']) && $_SESSION['Role']=="Worker"){// true false
                                    echo "<td id='Escalate'><form method='POST'><input type='hidden' name='ReferenceId' value='".$OR['ReferenceId']."'><button type='submit' name='Escalate'>Escalate</button></form></td>";
                                }echo"
                                </tr>";
                            }
                        }
                    ?>
            </table><br><hr><br>
            <h1 id="CloseMasseges">Close Messages</h1>
            <table>
                <tr>
                    <th id="thLeft">Customer Name</th>
                    <th>Subject</th>
                    <th>Convesation</th>
                    <th id="thRight">Close Date</th>
                </tr>
                <?php
                    $CloseReferense=mysqli_query($con,"SELECT * FROM Referense WHERE Handledby='$Role' AND Status=0");
                    while($CR=mysqli_fetch_array($CloseReferense)){
                        if($CR['Status']==0){// true false
                            echo "<tr><td>";
                                $Customers3=mysqli_query($con,"SELECT * FROM Users");
                                while($c3=mysqli_fetch_array($Customers3)){
                                    if($c3['Id']==$CR['CustomerId']){// true false
                                        echo $c3['FirstName']." ".$c3['LastName'];
                                        break;
                                    }
                                }
                                echo"</td>
                                <td>".$CR['Subject']."</td>
                                <td id='Conversation'><textarea>".$CR['Conversation']."</textarea></td>
                                <td>".$CR['LastUpdated']."</td>
                            </tr>";
                        }
                    }
                ?>
            </table>
            <?php 
                }else{
                    echo "<br><br><br><br> you have to login";
                }
            ?>
        </div>
    </body>
</html>