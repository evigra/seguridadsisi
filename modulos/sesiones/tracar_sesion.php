
<?php
#   PBKDF2-HMAC-SHA1
#   ef38a22ac8e75f7f3a6212dbfe05273365333ef53e34c14c
$pass 			= "password";
$iteraciones 	= 1000;
$sal 			= "24";
$algo 			= "sha1";

$hmac			= hash_hmac($algo, $pass, 'PBKDF2WithHmacSHA1');
$pbkdf2 		= hash_pbkdf2($algo, $hmac, $sal, $iteraciones, 24);

$resultado		= $pbkdf2;



$pbkdf2 		= hash_pbkdf2($algo, $pass, $sal, $iteraciones, 24);
#$hmac			= hash_hmac($algo, $pbkdf2, 'PBKDF2WithHmacSHA1');


$resultado		= $hmac;








echo "<br>$resultado = RESULTADO";
/*
	<input name="email" value="e.vizcaino@soluciones-satelitales.com">
	<input name="password" value="EvG30">	
*/	

?>
<!--
<br>ef38a22ac8e75f7f3a6212dbfe05273365333ef53e34c14c  = REAL

<form action="http://solesgps.com:8082/api/login"  method="POST" >	
	<input name="email" value="example">
	<input name="password" value="password">	
	<button type="submit" value="SESIONAR">	
</form>

<br>
<br>
<br>
-->
<form action="http://solesgps.com:8082/api/command/send"  method="POST" >	
	<input name="deviceId" value="1">
	<select name="type">
		<option value="positionSingle">positionSingle</option>
		<option value="positionPeriodic">positionPeriodic</option>
		<option value="positionStop">positionStop</option>
		<option value="engineStop">engineStop</option>
		<option value="engineResume">engineResume</option>
		<option value="alarmArm">alarmArm</option>
		<option value="alarmDisarm">alarmDisarm</option>
		<option value="setTimezone">setTimezone</option>
		<option value="requestPhoto">requestPhoto</option>
		<option value="uniqueId">uniqueId</option>
		<option value="frequency">frequency</option>
		<option value="timezone">timezone</option>
		<option value="devicePassword">devicePassword</option>	
	</select>	
	<button type="submit" value="COMANDO">	
</form>

