<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-02-02
 * Time: 오후 3:49
 */

namespace mysql;


use mysqli;

class MysqlInfo extends mysqli
{
    protected $mysql_host = "";
    protected $mysql_user = "";
    protected $mysql_password = "";
    protected $mysql_db = "";

    public function __construct($name)
    {
        $data_str = file_get_contents(__DIR__ . '/mysqlInfo.json');
        $json = json_decode($data_str, true);


        $mysql_host = $json[$name]['host'];
        $mysql_user = $json[$name]['user'];
        $mysql_password = $json[$name]['password'];
        $mysql_db = $json[$name]['db'];


// DB Connecting test
        parent::__construct($mysql_host, $mysql_user, $mysql_password, $mysql_db);
        if ($this->connect_errno) {
            die('Connection Error : ' . $this->connect_error);
        } else {
            $this->query('set session character_set_connection = utf8;');
            $this->query('set session character_set_results = utf8;');
            $this->query('set session character_set_client = utf8;');
        }


    }


}