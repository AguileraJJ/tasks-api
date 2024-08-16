<?php

class TaskGateway {

    private PDO $conn;

    public function __construct(Database $database) {
        $this->conn = $database->getConnection();
    }

    public function getAll() :array {

        $sql = "SELECT * FROM task ORDER BY name";

        $stmnt = $this->conn->query($sql); //Retruns PDO

        //return $stmnt->fetchAll(PDO::FETCH_ASSOC);

        $data = [];

        while ($row = $stmnt->fetch(PDO::FETCH_ASSOC)){
            $row['is_complete'] = (bool) $row['is_complete'];
            $data[] = $row;
        }

        return $data;
    }

    public function get(string $id) : array|false{

        $sql = "SELECT * FROM task WHERE id = :id";

        $stmnt = $this->conn->prepare($sql);

        $stmnt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmnt->execute();

        $data = $stmnt->fetch(PDO::FETCH_ASSOC);

        //var_dump($data);

        if($data !== false){
            $data['is_complete'] = (bool) $data['is_complete'];
        }

        return $data;

    }

}