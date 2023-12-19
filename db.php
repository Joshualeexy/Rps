<?php
$db_name = 'rps';
$db_user = 'root';
$db_pass = '';
$dsn = "mysql:host=localhost;dbname=".$db_name;
try {
    $db = new PDO($dsn, $db_user, $db_pass);
    if ($db) {
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    }
    
} catch (Exception $E) {
    echo 'Failed to connect to the database'.$E->getMessage();
}

