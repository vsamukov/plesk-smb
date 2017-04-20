<?php

$name=$_POST['name'];
$email=$_POST['email'];
$company=$_POST['company'];
$ip=$_POST['ip'];
$root_password=$_POST['root_password'];
$plesk_password=$_POST['plesk_password'];
$hostname=$_POST['hostname'];

echo "received from form <br>";

echo $name . $email . $company . $ip . $root_password . $plesk_password . $hostname;

echo "<br>";


// UPLOAD EXTENSION LIST AND SCRIPTa 

$CMD="wget http://provider.nextgen/extensions;wget http://provider.nextgen/install_extensions.sh";

 echo "<br>";
echo $CMD;
 echo "<br>";

$ssh=ssh2_connect($ip, 22);
ssh2_auth_password($ssh, 'root', $root_password);

$stdout = ssh2_exec($ssh, $CMD);
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

    } while (($span < 300) && ($done < 2));

    echo "STDERR:\n$err_buf\n";
    echo "STDOUT:\n$out_buf\n";

    echo "Keys and script uploaded: Done\n";
        echo "<br>";
fclose($stdoud);
fclose($stderr);
} else {
    echo "Failed to Shell\n";
}

//INSTALL EXTENSIONS 

$CMD2="sh install_extensions.sh";

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

        // Wait here so we don't hammer in this loop
        sleep(1);

    } while (($span < 300) && ($done < 2));

    echo "STDERR:\n$err_buf\n";
    echo "STDOUT:\n$out_buf\n";

    echo "Keys Installed: Done\n";
        echo "<br>";
fclose($stdoud);
fclose($stderr);
} else {
    echo "Failed to Shell\n";
}


?>
