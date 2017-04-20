
<?php
echo $_POST['company'];
echo "<br>";
echo $_POST['name'];
echo "<br>";
echo $_POST['email'];
echo "<br>";
echo $_POST['ip'];
echo "<br>";
echo $_POST['root_password'];
echo "<br>";
echo $_POST['plesk_password'];
echo "<br>";	
echo $_POST['plesk_hostname'];
echo "<br>";

global $ip,$root_password,$plesk_password,$plesk_hostname,$username,$email,$company;

 $ip=$_POST['ip'];
 $root_password=$_POST['root_password'];
 $plesk_password=$_POST['plesk_password'];
 $plesk_hostname=$_POST['plesk_hostname'];
 $username=$_POST['name'];
 $email=$_POST['email'];
 $company=$_POST['company'];

include './init.php';
include './install.php';

$cmd='';

$connection = ssh2_connect($ip, 22);
ssh2_auth_password($connection, 'root', $root_password);
$stream = ssh2_exec($connection, 'ls -la;');
stream_set_blocking( $stream, true );
$cmd=fread($stream,4096);
fclose($stream); 

echo "<pre>";
echo $cmd;
echo "</pre>";
echo "<br>";


$stream = ssh2_exec($connection, 'echo $plesk_password>password');
stream_set_blocking( $stream, true );
$cmd=fread($stream,4096);
fclose($stream);
echo $cmd;


$connection = ssh2_connect($ip, 22);
ssh2_auth_password($connection, 'root', $root_password);

$stream = ssh2_exec($connection, 'sh 10getlogin.sh');
stream_set_blocking( $stream, true );
$cmd=fread($stream,4096);
fclose($stream);

echo $cmd;


echo "<br>";

	$file='installer/init.sh';
	$static="#!/bin/bash \n setenforce 0\n /usr/local/psa/admin/sbin/reset_instance_data --do-what-I-say --force\n";
	$dynamic = "/usr/sbin/plesk bin init_conf --init -default-ip {$ip} -netmask 255.255.255.0 -iface eth0 -ip-type shared -hostname {$plesk_hostname} -name {$username} -passwd {$plesk_password} -email {$email} -company {$company} -license_agreed true -admin_info_not_required true\n";
	$ending="plesk bin poweruser --off\niptables -I INPUT -p tcp --dport 8443 -j ACCEPT";
	$content=$static . $dynamic . $ending;
	file_put_contents($file, $content);

echo $content;

echo "<br>";


echo "<iframe src=install.html width=500 height=300></iframe>";

//$stream = ssh2_exec($connection, 'wget http://provider.nextgen/installer/init.sh');
//stream_set_blocking( $stream, true );
//$cmd=fread($stream,4096);
//fclose($stream);
//echo $cmd;

echo "<br>";

//$stream = ssh2_exec($connection, 'sh init.sh');
//stream_set_blocking( $stream, true );
//$cmd=fread($stream,4096);
//fclose($stream);
//echo $cmd;


?>
