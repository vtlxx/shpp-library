<?php

setup();

function setup() : void
{
    $mysql = new mysqli('localhost', 'root', '');

    //creating database
    $mysql->query('CREATE DATABASE library');

    //creating tables
    $mysql->query('CREATE TABLE books (id  INT AUTO_INCREMENT KEY, title VARCHAR, description TEXT, pages INT, year INT)');
    $mysql->query('CREATE TABLE authors (id INT AUTO_INCREMENT KEY, name VARCHAR)');
    $mysql->query('CREATE TABLE books_authors (book_id INT, author_id INT,
 FOREIGN KEY (author_id) REFERENCES authors (id) ON DELETE CASCADE');
}
