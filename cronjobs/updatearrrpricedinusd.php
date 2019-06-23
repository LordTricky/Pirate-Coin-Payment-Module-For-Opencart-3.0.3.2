<?php
$url='https://bitpay.com/api/rates';
$json=json_decode( file_get_contents( $url ) );
$usd=$btc=0;

foreach( $json as $obj ){
    if( $obj->code=='USD' )$btc=$obj->rate;
}

$usd=1 / $btc;

function printValues($arr) {
    global $count;
    global $values;
    
    if(!is_array($arr)){
        die("ERROR: Input is not an array");
    }
    
    foreach($arr as $key=>$value){
        if(is_array($value)){
            printValues($value);
        } else{
            $values[] = $value;
            $count++;
        }
    }
    
    return array('total' => $count, 'values' => $values);
}
 
$url1 = "https://graviex.net//api/v2/tickers/arrrbtc";
$json1 = file_get_contents($url1);
$arr = json_decode($json1, true);
 
$result = printValues($arr);

$plp = $arr["ticker"]["last"] . "<br>";
$usdpv = ($usd / $plp);

$con=mysqli_connect("localhost","username","password","dbname"); //Change to match your database
      // Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$sqlpp="UPDATE `oc_currency` SET `value` = '$usdpv' WHERE `oc_currency`.`currency_id` = 4;"; //Change currency_id 4 to match the id of your pirate currency in your database

if($con->query($sqlpp)===TRUE){echo"";}else{echo"Error updating record: ".$conn->error;}

mysqli_close($con);

?>