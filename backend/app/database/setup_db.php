<?php

const USER = 'root';
const PASSWORD = '';
const DB_HOST = 'localhost';
const DB_NAME = 'librarySecond';

setup();

function setup() : void
{
    $mysql = new mysqli(DB_HOST, USER, PASSWORD);

    //creating database
    echo "Database '" . DB_NAME . "':\t";
    $databases = $mysql->query("SHOW DATABASES LIKE '". DB_NAME ."';");

    if($databases->num_rows == 0) {
        echo $mysql->query(file_get_contents('createDB.sql')) ? 'created' : 'creation failed';
    }
    else {
        echo 'exists';
    }

    $mysql->select_db(DB_NAME);
    //CREATING TABLES
    //books table
    echo "\nTable 'books':\t\t";
    $tables = $mysql->query("SHOW TABLES LIKE 'books'");
    if($tables->num_rows == 0) {
        echo $mysql->query(file_get_contents('createTableBooks.sql')) ? 'created' : 'creation failed';
    } else {
        echo 'exists';
    }
    //authors table
    echo "\nTable 'authors':\t";
    $tables = $mysql->query("SHOW TABLES LIKE 'authors'");
    if($tables->num_rows == 0) {
        echo $mysql->query(file_get_contents('createTableAuthors.sql')) ? 'created' : 'creation failed';
    } else {
        echo 'exists';
    }
    //books authors table
    echo "\nTable 'books_authors':\t";
    $tables = $mysql->query("SHOW TABLES LIKE 'books_authors'");
    if($tables->num_rows == 0) {
        echo $mysql->query(file_get_contents('createTableBooksAuthors.sql')) ? 'created' : 'creation failed';
    } else {
        echo 'exists';
    }
    //admins table
    echo "\nTable 'admins':\t\t";
    $tables = $mysql->query("SHOW TABLES LIKE 'admins'");
    if($tables->num_rows == 0) {
        echo $mysql->query(file_get_contents('createTableAdmins.sql')) ? 'created' : 'creation failed';
    } else {
        echo 'exists';
    }

    //migration
    $mysql->query(file_get_contents('migration_addColumnDelete.sql'));
    echo "\n";
}
