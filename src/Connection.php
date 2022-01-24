<?php 
namespace App;

use \PDO;

class Connection {
    public static function getPDO(): PDO
    {
        return new PDO ("mysql:dbname={$_ENV["DB_NAME"]};host={$_ENV["HOST_NAME"]}", "{$_ENV["USERNAME"]}", "{$_ENV["PASSWORD"]}", 
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        
    }
}


/*
Local development code : 
new PDO ('mysql:dbname=blog;host=127.0.0.1', 'root', 'root', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
*/