<?php
namespace App\Services;

class DbService
{
    public static function findOne(int $task_id): bool|array
    {
        $conn = self::createConnect();

        return $conn->query("SELECT * from tasks where `task_id`=$task_id",  \PDO::FETCH_ASSOC)->fetch();
    }

    public static function create(array $data): bool|array
    {

        $param_1 = 'ready';
        $param_2 = $data['result'];

        $sql = 'INSERT INTO tasks (status, result) VALUES (?, ?)';
        $conn = self::createConnect();
        $sth = $conn->prepare($sql);
        $sth->bindParam(1, $param_1);
        $sth->bindParam(2, $param_2);
        return $sth->execute();
    }

    private static function createConnect(): \PDO
    {
        $username = "merlin_face_app";
        $password = "merlin_face_app";
        $database = "merlin_face_app";
        $port = "3306";

        return new \PDO("mysql:host=mysql;port=$port;dbname=$database", $username, $password);
    }

}