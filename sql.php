<?php
$severname = "localhost";   //db =tiger ,table= lion 
$username = "root";
$password = "";
$dbname = "tiger";

$conn = mysqli_connect($severname,$username,$password,$dbname);
if($conn)
{
  echo "Successfully connected to server";
}
else
{ 
  echo "Failed";
}
?>