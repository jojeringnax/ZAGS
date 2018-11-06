<?php
//$connection = mysqli_connect('localhost', 'root', '', 'u479413');
$connection = mysqli_connect('u479413.mysql.masterhost.ru', 'u479413', 's.7nSKI-9sePI', 'u479413');
mysqli_set_charset($connection, "utf8");

if (strpos(rawurldecode($_GET['message']), 'Memory') !== 0)
{
$query = 'INSERT INTO u479413.logs (device_id, time, level, sender, message)  VALUES (\'' . $_GET['id'] . '\',\'' . $_GET['time'] . '\',\'' . $_GET['level'] . '\',\'' . rawurldecode($_GET['sender']) . '\',\'' . rawurldecode($_GET['message']) . '\');';
$result = mysqli_query($connection, $query) or die('Bad request: ' . $query);
}
echo 'Added';

if (($_GET['message'] = 'Cleaning old logs and events') && (rand(0, 9) == 0)) {
    switch (rand(0, 5)) {
        case 0:
            $query = 'DELETE FROM logs WHERE level = \'Trace\' AND  time < NOW() - INTERVAL 50 DAY';
            break;
        case 1:
           $query = 'DELETE FROM logs WHERE level = \'Debug\' AND  time < NOW() - INTERVAL 100 DAY';
           break;
        case 2:
            $query = 'DELETE FROM logs WHERE level = \'Info\' AND  time < NOW() - INTERVAL 200 DAY';
            break;
        case 3:
            $query = 'DELETE FROM logs WHERE level = \'Warning\' AND  time < NOW() - INTERVAL 400 DAY';
            break;
       case 4:
            $query = 'DELETE FROM logs WHERE level = \'Error\' AND  time < NOW() - INTERVAL 80 DAY';
            break;
        case 5:
            $query = 'DELETE FROM logs WHERE level = \'Fatal\' AND  time < NOW() - INTERVAL 160 DAY';
            break;
    }
    $result = mysqli_query($connection, $query) or die('Bad request: ' . $query);
}

mysqli_close($connection);