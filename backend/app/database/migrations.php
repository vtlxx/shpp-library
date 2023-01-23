<?php

const USER = 'root';
const PASSWORD = '';
const DB_HOST = 'localhost';
const DB_NAME = 'library';

addDeleteColumn();

function addDeleteColumn() : void
{
    $command = 'mysql --user='.USER.' --password='.PASSWORD.' -h localhost' . ' -D '.DB_NAME.' < ';
    $res = shell_exec($command . 'migration_addColumnDelete.sql');
    print_r($res);
}
