<?php
/**
 * Created by PhpStorm.
 * User: Thijs
 * Date: 2-1-2019
 * Time: 21:58
 */

class Database {

    private static $instance;
    private function __construct() {

    }

    public static function getInstance() : \Simplon\Mysql\Mysql {

        if(empty(static::$instance)) {
            //https://packagist.org/packages/simplon/mysql

            $key = Config::get('database.default_connection');

            $pdoConnector = new \Simplon\Mysql\PDOConnector(
                Config::get('database.connections.' . $key. '.server'),
                Config::get('database.connections.' . $key. '.username'),
                Config::get('database.connections.' . $key. '.password'),
                Config::get('database.connections.' . $key. '.database'));
            $dbConn = new \Simplon\Mysql\Mysql($pdoConnector->connect(Config::get('database.connections.' . $key. '.charset'), []));

            static::$instance = $dbConn;
        }
        return static::$instance;
    }
}