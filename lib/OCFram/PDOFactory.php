<?php
namespace OCFram;

class PDOFactory
{
    public static function getMysqlConnexion()
    {
        $conf= conf::getInstance();
        $db_user = $conf->get('db_user');
        $db_pass = $conf->get('db_pass');
        $db_host = $conf->get('db_host');
        $db_name = $conf->get('db_name');

        $db = new \PDO("mysql:host=$db_host;dbname=phpblog", $db_user, $db_pass );
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $db;
    }
}
