<?php
$query = parse_url($_SERVER['REQUEST_URI'])["query"];
header('Location: web/index.php?r=site/get_config&'.$query);
/*//$connection = mysqli_connect('localhost', 'root', '', 'u479413');
$connection = mysqli_connect('u479413.mysql.masterhost.ru', 'u479413', 's.7nSKI-9sePI', 'u479413');

$query = 'SELECT * FROM licenses WHERE id = \''.$_GET['id'].'\'';
$result = mysqli_query($connection, $query) or die('Bad request: ' . mysqli_error($connection));

if(mysqli_num_rows($result))
{
    $query = 'UPDATE licenses SET last_check=NOW() WHERE id = \'' . $_GET['id'] . '\'';
    $update_result = mysqli_query($connection, $query) or die('Bad request: ' . mysqli_error($connection));
    while ($data = mysqli_fetch_array($result))
    {
        $query = 'SELECT * FROM config WHERE device_id = '.$data['id'];
        $result2 = mysqli_query($connection, $query) or die('Bad request: ' . mysqli_error($connection));

        while ($data = mysqli_fetch_array($result2))
        {
            echo'<?xml version="1.0" encoding="utf-8" ?>';
            echo'<data>';
            echo'<wedding_price>'.$data['wedding_price'].'</wedding_price>';
            echo'<reprint_price>'.$data['reprint_price'].'</reprint_price>';
            echo'<talisman_price>'.$data['talisman_price'].'</talisman_price>';
            echo'<kinoselfie_price>'.$data['kinoselfie_price'].'</kinoselfie_price>';
            echo'<disabled>'.$data['disabled'].'</disabled>';
            echo'<bills>50,100,200,500</bills>';
            echo'<multitouch_enabled>'.$data['multitouch_enabled'].'</multitouch_enabled>';
            echo'<quiet_time_start>'.$data['quiet_time_start'].'</quiet_time_start>';
            echo'<quiet_time_end>'.$data['quiet_time_end'].'</quiet_time_end>';
            echo'</data>';
        }
    }

    $fill_wedding = ( isset($_GET['fill_wedding']) )? intval( $_GET['fill_wedding'], 10 ): 'NULL';
    $fill_talisman = ( isset($_GET['fill_talisman']) )? intval( $_GET['fill_talisman'], 10 ): 'NULL';
    $printer_media_count = ( isset($_GET['printer_media_count']) )? intval( $_GET['printer_media_count'], 10 ): 'NULL';

    // TODO: check if we have anything to write to db

    $query = 'INSERT INTO current_status (device_id, fill_wedding, fill_talisman, printer_media_count) VALUES (\'' . $_GET['id'] . '\', '.$fill_wedding.', '.$fill_talisman.', '.$printer_media_count.') ON DUPLICATE KEY UPDATE fill_wedding='.$fill_wedding.', fill_talisman='.$fill_talisman.', printer_media_count='.$printer_media_count.'';
    $update_result = mysqli_query($connection, $query) or die('Bad request: ' . mysqli_error($connection));
} else {
    echo'<?xml version="1.0" encoding="utf-8" ?>';
    echo'<data>';
    echo'</data>';
}

mysqli_close($connection);*/

?>