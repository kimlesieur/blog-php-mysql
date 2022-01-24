<?php 
namespace App;

use \PDO;

class Connection {
    public static function getPDO(): PDO
    {
        return new PDO ("mysql:dbname={$_SERVER["DB_NAME"]};host={$_SERVER["HOST_NAME"]}", "{$_SERVER["USERNAME"]}", "{$_SERVER["PASSWORD"]}", 
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        
    }
}


/*
Local development code : 
new PDO ('mysql:dbname=blog;host=127.0.0.1', 'root', 'root', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
*/