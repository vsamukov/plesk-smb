<?php

$name=$_POST['name'];
$email=$_POST['email'];
$company=$_POST['company'];
$ip=$_POST['ip'];
$root_password=$_POST['root_password'];
$plesk_password=$_POST['plesk_password'];
$hostname=$_POST['hostname'];

echo $name . $email . $company . $ip . $root_password . $plesk_password . $hostname;


echo "<br>";


$connection = ssh2_connect($ip, 22);
ssh2_auth_password($connection, 'root', $root_password);
$stream = ssh2_exec($connection, '/usr/sbin/plesk bin admin --get-login-link');
stream_set_blocking( $stream, true );
$cmd=fread($stream,4096);
fclose($stream);
echo $cmd;

echo "<br>";


?>
