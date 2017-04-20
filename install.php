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
$stream = ssh2_exec($connection, 'echo 192.168.145.4	provider.nextgen >> /etc/hosts');
stream_set_blocking( $stream, true );
$cmd=fread($stream,4096);
fclose($stream);
echo "<br>";
echo "hosts entry added <br>";
echo $cmd;



$connection = ssh2_connect($ip, 22);
ssh2_auth_password($connection, 'root', $root_password);

$stream = ssh2_exec($connection, 'wget http://provider.nextgen/installer/install_smb.sh;wget http://provider.nextgen/installer/components');
stream_set_blocking( $stream, true );
$cmd=fread($stream,4096);
fclose($stream);
echo $cmd;

echo "<br>";

echo "components list and installed script uploaded<br>";


$CMD1="sh install_smb.sh";

 echo "<br>";
echo $CMD1;
 echo "<br>";

$ssh=ssh2_connect($ip, 22);
ssh2_auth_password($ssh, 'root', $root_password);

$stdout = ssh2_exec($ssh, $CMD1);
$stderr = ssh2_fetch_stream($stdout, SSH2_STREAM_STDERR);
if (!empty($stdout)) {

    $t0 = time();
    $err_buf = null;
    $out_buf = null;

    // Try for 30s
    do {
        $err_buf.= fread($stderr, 4096);
        $out_buf.= fread($stdout, 4096);

        $done = 0;
        if (feof($stderr)) {
            $done++;
        }
        if (feof($stdout)) {
            $done++;
        }
        $t1 = time();
        $span = $t1 - $t0;

        // Wait here so we don't hammer in this loop
        sleep(1);

    } while (($span < 1800) && ($done < 2));

    echo "STDERR:\n$err_buf\n";
    echo "STDOUT:\n$out_buf\n";
echo "<br>";
    echo "Installed Plesk: Done\n<BR>Continue to step 2 Initialization<br>";
        echo "<br>";
fclose($stdoud);
fclose($stderr);
} else {
    echo "Failed to Shell\n";
}



//$stream = ssh2_exec($connection, 'sh install_smb.sh');
//stream_set_blocking( $stream, true );
//$cmd=fread($stream,4096);
//fclose($stream);
//echo $cmd;

//$stream = ssh2_exec($connection, 'rm install_smb.sh components -f');
//stream_set_blocking( $stream, true );
//$cmd=fread($stream,4096);
//fclose($stream);
//echo $cmd;


?>
