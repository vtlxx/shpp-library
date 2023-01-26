<?php
const USER = 'root';
const DB_NAME = 'library';
shell_exec('mysqldump -u ' . USER . ' ' . DB_NAME . ' > library.sql');
