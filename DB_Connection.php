<?php
function OpenCon(){
    $con=mysqli_connect("localhost","root","","CarVista") or die("Connect failed: %s\n". $con -> error);
    return $con;
}
function CloseCon($con){
    $con -> close();
}
?>