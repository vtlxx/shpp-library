<?php

function connect_db(){
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'library';

    return new mysqli($host, $username, $password, $database);
}
