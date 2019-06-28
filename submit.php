<html><head><style>
.btn {
	padding: 7.5px 12px;
	font-size: 12px;
	border: 1px solid #cccccc;
	border-radius: 4px;
	box-shadow: inset 0 1px 0 rgba(255,255,255,.2), 0 1px 2px rgba(0,0,0,.05);
	color: #ffffff;
	text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
	background-color: #229ac8;
	background-image: linear-gradient(to bottom, #23a1d1, #1f90bb);
	background-repeat: repeat-x;
	border-color: #1f90bb #1f90bb #145e7a;
}
.btn:hover, .btn-primary:active, .btn-primary.active, .btn-primary.disabled, .btn-primary[disabled] {
	background-color: #1f90bb;
	background-position: 0 -15px;
}
}
</style></head></html>    
<?php
$txidErr = "";
$txid = "";
         
if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (empty($_POST["txid"])) {
$nameErr = "txid is required";
}else {
  $txid = test_input($_POST["txid"]);
 }
}
         
function test_input($data) {
$data = trim($data);
$data = stripslashes($data);
return $data;
}
?>
<center>		            
<form method = "POST" action = "<?php echo ($_SERVER["PHP_SELF"]);?>">
Please Enter Your <strong>64 Character Long</strong> Payment Transaction ID (TXID) <br>
<input type = "text" name = "txid" style="text-align:center; height:30px; width:470px" class="myButton">
<span class = "error"><?php echo $txidErr;?></span><br><br>
<button class="btn" type="submit" value="Submit">Save TXID</button>
</form></center>
      
<?php 
$con=mysqli_connect("localhost","username","password","database"); //Edit to match your database
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$sql="UPDATE oc_order SET `payment_custom_field` = 'Supplied TXID: $txid', `order_status_id` = '1' ORDER BY oc_order.order_id DESC LIMIT 1";

if ($con->query($sql) === TRUE) {
    echo "<center>Your TXID Has Been Saved As <br>$txid</center>";
} else {
    echo "Error updating record: " . $conn->error;
}

mysqli_close($con);
?>
      
