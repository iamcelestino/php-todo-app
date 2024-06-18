<?php


class Database {

    private $user;
    private $hostname;
    private $dbname;
    private $password;

    public function __construct($user = "root", $hostname = "localhost", $dbname = "todo__app", $password = "")
    {
        $this->user = $user;
        $this->hostname = $hostname;
        $this->dbname = $dbname;
        $this->password = $password;
    }

    public function connect()
    {
        $pdo = null;

        try {
            $dsn = "mysql:host=".$this->hostname.";dbname".$this->dbname.";charset=utf-8";
            $pdo = new PDO($dsn, $this->user, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);

            if($pdo) {
                echo "CONNECTED TO".$this->dbname."DATABASE SUCCESSFULLY";
            }
        } catch (PDOException $e) {
            echo "CONNECTION FAILED". $e->getMessage();
        }

        return $pdo;
    }
}

