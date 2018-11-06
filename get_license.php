<?php
$secret_string = 'secret string';

//$connection = mysqli_connect('localhost', 'root', '', 'u479413');
$connection = mysqli_connect('u479413.mysql.masterhost.ru', 'u479413', 's.7nSKI-9sePI', 'u479413');
$query = 'SELECT * FROM licenses WHERE license = "'.$_GET['fingerprint'].'"';
$result = mysqli_query($connection, $query) or die('Bad request: ' . mysqli_error($connection));

if(mysqli_num_rows($result)) {
    $data = mysqli_fetch_array($result);
    echo '<LicenseInfo>';
    echo '<CurrentTimestamp>' . date('n.Y') . '</CurrentTimestamp>';
    $next = new DateTime();
    $next->modify('first day of next month');
    echo '<NextTimestamp>' . $next->format('n.Y') . '</NextTimestamp>';
    echo '<CurrentKey>' . hash('sha256', $_GET['fingerprint'] . date('n.Y') . $secret_string) . '</CurrentKey>';
    echo '<NextKey>' . hash('sha256', $_GET['fingerprint'] . $next->format('n.Y') . $secret_string) . '</NextKey>';
    echo '<RequestId>-1</RequestId>';
    echo '<LicenceId>'.$data['id'].'</LicenceId>';
    echo '</LicenseInfo>';
    mysqli_free_result($result);
}
else
{
    $query = 'SELECT * FROM license_requests WHERE license = \''.$_GET['fingerprint'].'\'';
//    echo $query.'   \n';
    $result = mysqli_query($connection, $query) or die('Bad request: ' . mysqli_error($connection));

    if(mysqli_num_rows($result))
    {
        $data = mysqli_fetch_array($result);
        echo '<!--found-->';
        echo '<LicenseInfo>';
        echo '<CurrentTimestamp>' . date('n.Y') . '</CurrentTimestamp>';
        $next = new DateTime();
        $next->modify('first day of next month');
        echo '<NextTimestamp>' . $next->format('n.Y') . '</NextTimestamp>';
        echo '<CurrentKey></CurrentKey>';
        echo '<NextKey></NextKey>';
        echo '<RequestId>'.$data['id'].'</RequestId>';
        echo '<LicenceId>-1</LicenceId>';
        echo '</LicenseInfo>';
        mysqli_free_result($result);
    } else {
        $query = 'INSERT INTO license_requests (license) VALUES (\''.$_GET['fingerprint'].'\')';
        $result = mysqli_query($connection, $query) or die('Bad request: ' . mysqli_error($connection));
        echo '<!--creating-->';
        echo '<LicenseInfo>';
        echo '<CurrentTimestamp>' . date('n.Y') . '</CurrentTimestamp>';
        $next = new DateTime();
        $next->modify('first day of next month');
        echo '<NextTimestamp>' . $next->format('n.Y') . '</NextTimestamp>';
        echo '<CurrentKey></CurrentKey>';
        echo '<NextKey></NextKey>';
        echo '<RequestId>'.mysqli_insert_id($connection).'</RequestId>';
        echo '<LicenceId>-1</LicenceId>';
        echo '</LicenseInfo>';
    }
}

mysqli_close($connection);