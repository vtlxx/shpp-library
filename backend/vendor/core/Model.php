<?php

namespace vendor\core;

use mysqli;

abstract class Model
{
    protected array $databaseData;
    public function __construct()
    {

    }

    /**
     * Checks the connection to the database and, if successful, remembers the login data
     * @param string $dbName
     * @param string $dbUser
     * @param string $dbPassword
     * @param string $dbHost
     * @return bool whether the connection was successfully established
     */
    public function setDB(string $dbName, string $dbUser, string $dbPassword, string $dbHost = 'localhost') : bool
    {
        $db = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
        if($db->connect_error) {
            return false;
        }
        $this->databaseData['name'] = $dbName;
        $this->databaseData['user'] = $dbUser;
        $this->databaseData['password'] = $dbPassword;
        $this->databaseData['host'] = $dbHost;
        return true;
    }

    /** Makes a query to the database and returns the result
     * @param string $query mysql query
     * @param string $paramsType the type of each parameter (each element of array)
     * @param array $params params in numeric array
     * @return array|bool array (fetched stmt_result) if success and false if fail
     */
    public function executeDB(string $query, string $paramsType = '', array $params = []) : array|bool
    {
        //connecting to the database
        $mysql = new mysqli($this->databaseData['host'], $this->databaseData['user'],
            $this->databaseData['password'], $this->databaseData['name']);
        $stmt = $mysql->prepare($query);
        if($params) {
            $stmt->bind_param($paramsType, ...$params);
        }
        //returning result
        if($stmt->execute() && $result = $stmt->get_result()) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    protected function getMysqli() : mysqli {
        return new mysqli($this->databaseData['host'], $this->databaseData['user'],
            $this->databaseData['password'], $this->databaseData['name']);
    }
}