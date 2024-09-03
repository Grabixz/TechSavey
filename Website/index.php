<?php
    //This is to start a new session
    session_start();

    //This is to retrieve the database connection details
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'TechSavey';

    try {
        //This will then create a new PDO connection to the database using the provided details
        $pdo = new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
        //This will then set the PDO error mode to exception for better error handling
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        //If there is an error connection to the database, the following message will be displayed and it will exit
        die("ERROR: Could not connect. " . $e->getMessage());
    }
?>