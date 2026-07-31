<?php
    include "Nav.php";
    $con=OpenCon();
    $CustomerId=$_SESSION['UserId'];
    $CustomerName=$_SESSION['UserFullName'];

    $message="";
    $ChatStatus=0;
    $chat="";
    $sub="";
    $conv="";
    $RId=-1;
    $Referense=mysqli_query($con,"SELECT * FROM Referense");
    while($R=mysqli_fetch_array($Referense)){
        if($R['CustomerId']==$CustomerId){
            if($R['Status']==1){
                $ChatStatus=1;
                $chat=$R['Conversation'];
                $sub=$R['Subject'];
                $RId=$R['ReferenceId'];
            }else{
                $ChatStatus=0;
            }
        }
    }
    
    if(isset($_POST['send'])){
        if($ChatStatus==0){
            $subject=$_POST['subject'];
            $problem=$_POST['Problem'];
            if(trim($subject)!=""){
                if(trim($problem)!=""){
                    $conv=$_POST['Problem'];
                    $chat.="\n[".date("d-m-Y H:i")."]".$CustomerName.": ".$conv;
                    mysqli_query($con,"INSERT INTO Referense (CustomerId,Subject,Conversation,Status,Created,LastUpdated,HandledBy)
                    VALUES ($CustomerId,'$subject','$chat',1,NOW(),NOW(),'Worker')");
                    header("Location:ContactPage.php");
                    exit();
                }else{
                    $message="Please Write you'r problem agian";
                }
            }else{
                $message="Please Write Subject of you'r problem";
            }
        
        }else{
            if($RId!=-1){
                if(trim($_POST['addtoConversation'])!=""){
                    $conv=$_POST['addtoConversation'];
                    $chat.="\n[".date("d-m-Y H:i")."]".$CustomerName.": ".$conv;
                    mysqli_query($con,"UPDATE Referense SET Conversation='$chat' , LastUpdated=NOW() WHERE ReferenceId=$RId");
                    header("Location:ContactPage.php");
                    exit();
                }else{
                    $message="you cant send Empty Message";
                }
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
                margin: 0px;
                margin-top: 50px;
                background-color: #909094;
            }
            .Css1{
                margin: 0px;
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .Css2{
                background-color: white;
                padding-right: 40px;
                padding-left:40px;
                padding-bottom:40px;
                border-radius:15px;
                box-shadow: 0px 0px 10px blue;
            }
            .Css2 form{
                padding-top:10px;
            }
            h1{
                text-align: center;
                margin-top:20px;
            }
            h2{
                font-size: 15px;
                background-color: white;
                border: 2px black solid;
                border-radius: 5px;
                padding:5px;
            }
            h3{
                font-size: 15px;
                font-weight: bold;
                text-align: center;
                color:red;
                border:2px solid red;
                border-radius: 5px;
                background-color: #ffb1b1;
                padding-top:5px;
                padding-bottom:5px;
                padding-left: 10px;
                padding-right: 10px;
            }
            label{
                display: block;
                margin-top: 10px;
                font-weight: bold;
            }   
            textarea{
                height: 150px;
                width:300px;
                display: block;
            }
            input{
                margin-top: 2px;
                width: 300px;
                height: 30px;
                border-radius: 5px;
            }
            #SendButton{
                margin-top:20px;
                display:flex;
                justify-self: center;
                border-radius: 5px;
                border:2px solid black;
                font-weight: bold;
                font-size:20px;
                padding-left:10px;
                padding-right:10px;
            }
            #SendButton:hover{
                color:white;
                border:2px solid blue;
                background-color: green;
            }
        </style>
    </head>
    <body>
        <div class="Css1">
            <div class="Css2">
                <?php
                    if($ChatStatus==0){
                ?>
                <h1>Customer Support</h1>
                <?php if($message!=""){echo "<h3>".$message."</h3>";}?>
                <form method="post">
                    <label>Subject:</label>
                    <input type="text" name="subject" required>
                    <label>Write your Prolem here:</label>
                    <textarea name="Problem" placeholder="Write here...." required></textarea>
                    <button id="SendButton" type="submit" name="send">Send</button>
                </form>
                <?php }else{ ?>
                <h1>Customer Support</h1>
                <?php if($message!=""){echo "<h3>".$message."</h3>";}?>
                <form method="post">
                    <label>Subject:</label>
                    <h2><?php echo $sub;?></h2>
                    <label>Conversation:</label>
                    <textarea><?php echo $chat ?></textarea>
                    <label>Add to Conversation:</label>
                    <textarea name="addtoConversation" placeholder="add to Conversation...." required></textarea>
                    <button id="SendButton" type="submit" name="send">Send</button>
                </form>
                <?php } ?>
            </div>
        </div>
    </body>
</html>