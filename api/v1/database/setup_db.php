<?php

setup();

function setup() : void
{
    $mysql = new mysqli('localhost', 'root', '');

    //creating database
    $mysql->query('CREATE DATABASE library');


    $mysql = new mysqli('localhost', 'root', '', 'library');
    //creating tables
    $mysql->query('CREATE TABLE books (id INT AUTO_INCREMENT KEY, title VARCHAR(100), description VARCHAR(400),
 pages INT, year INT, views INT DEFAULT 0, clicks INT DEFAULT 0)');
    $mysql->query('CREATE TABLE authors (id INT AUTO_INCREMENT KEY, name VARCHAR(50) UNIQUE)');
    $mysql->query('CREATE TABLE books_authors (book_id INT, author_id INT,
 FOREIGN KEY (author_id) REFERENCES authors (id) ON DELETE CASCADE,
 FOREIGN KEY (book_id) REFERENCES books (id) ON DELETE CASCADE)');
    $mysql->query('CREATE TABLE admins (login VARCHAR(30) KEY, password VARCHAR(30))');
}
