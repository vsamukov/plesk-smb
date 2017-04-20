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

//        $file='installer/init.sh';
//        $static="#!/bin/bash \n setenforce 0\n #/usr/local/psa/admin/sbin/reset_instance_data --do-what-I-say --force\n";
//        $dynamic = "/usr/sbin/plesk bin init_conf --init -default-ip {$ip} -netmask 255.255.255.0 -iface eth0 -ip-type shared -hostname {$hostname} -name {$name} -passwd {$plesk_password} -email {$email} -company {$company} -license_agreed true -admin_info_not_required true\n";
//        $ending="/usr/sbin/plesk bin poweruser --off\niptables -I INPUT -p tcp --dport 8443 -j ACCEPT";
//        $content=$static . $dynamic . $ending;
 //       file_put_contents($file, $content);
//echo $content;

echo "<br>";

//$connection = ssh2_connect($ip, 22);
//ssh2_auth_password($connection, 'root', $root_password);

//$stream = ssh2_exec($connection, 'wget http://provider.nextgen/installer/init.sh');
//stream_set_blocking( $stream, true );
//$cmd=fread($stream,4096);
//fclose($stream);
//echo $cmd;
//
//echo "<br>";


$ssh=ssh2_connect($ip, 22);
ssh2_auth_password($ssh, 'root', $root_password);


//DISABLE SELINUX AND RESET INSTANCE DATA


$CMD1="setenforce 0;/usr/local/psa/admin/sbin/reset_instance_data --do-what-I-say --force";
//$CMD1="setenforce 0; echo hello";
echo $CMD1;
echo "<br>";

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

        // Info note
 //       echo "while (($tD < 20) && ($done < 2));\n";

        // Wait here so we don't hammer in this loop
        sleep(1);

    } while (($span < 300) && ($done < 2));

    echo "STDERR:\n$err_buf\n";
    echo "STDOUT:\n$out_buf\n";

    echo "Done\n";
	echo "<br>";
fclose($stdoud);
fclose($stderr);
} else {
    echo "Failed to Shell\n";
}


//RUN INIT COMMAND

$CMD2="/usr/sbin/plesk bin init_conf --init -default-ip {$ip} -netmask 255.255.255.0 -iface eth0 -ip-type shared -hostname {$hostname} -name {$name} -passwd {$plesk_password} -email {$email} -company {$company} -license_agreed true -admin_info_not_required true";

 echo "<br>";
echo $CMD2;
 echo "<br>";

$ssh=ssh2_connect($ip, 22);
ssh2_auth_password($ssh, 'root', $root_password);

$stdout = ssh2_exec($ssh, $CMD2);
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

        // Info note
 //       echo "while (($tD < 20) && ($done < 2));\n";

        // Wait here so we don't hammer in this loop
        sleep(1);

    } while (($span < 300) && ($done < 2));

    echo "STDERR:\n$err_buf\n";
    echo "STDOUT:\n$out_buf\n";

    echo "Done\n";
        echo "<br>";
fclose($stdoud);
fclose($stderr);
} else {
    echo "Failed to Shell\n";
}



//PROVIDER VIEW and FIREWALL RULE


$CMD3="/usr/sbin/plesk bin poweruser --off ; iptables -I INPUT -p tcp --dport 8443 -j ACCEPT";
echo "<br>";
echo $CMD3;

 echo "<br>";

$ssh=ssh2_connect($ip, 22);
ssh2_auth_password($ssh, 'root', $root_password);

$stdout = ssh2_exec($ssh, $CMD3);
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

        // Info note
 //       echo "while (($tD < 20) && ($done < 2));\n";

        // Wait here so we don't hammer in this loop
        sleep(1);

    } while (($span < 300) && ($done < 2));

    echo "STDERR:\n$err_buf\n";
    echo "STDOUT:\n$out_buf\n";

    echo "Done\n";
        echo "<br>";
fclose($stdoud);
fclose($stderr);
} else {
    echo "Failed to Shell\n";
}



?>
