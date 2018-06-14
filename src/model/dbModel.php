<?php

namespace app\model;

use \Slim\PDO\Database as PDO;

class DbModel
{

    private $dbh;
    private $config;

    public function __construct($conf = [])
    {   
        // Get config data
        $this->config = $conf;

        // Connect to db
        $dbData = $this->config['db'];
        $this->dbh = new PDO("mysql:host=".$dbData['host'].";dbname=".$dbData['dbname'].";charset=".$dbData['charset'], $dbData['user'], $dbData['password']);
    }

    public function getDbh(){
        return $this->dbh;
    }

}