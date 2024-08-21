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

    public function create(array $data) : string{

        $sql = "INSERT INTO task (name, priority, is_complete)
                VALUES (:name, :priority, :is_complete)";

        $stmnt = $this->conn->prepare($sql);
        
        $stmnt->bindValue(":name", $data['name'], PDO::PARAM_STR);

        if(empty($data['priority'])){
            $stmnt->bindValue(":priority", null, PDO::PARAM_NULL);
        }else{
            $stmnt->bindValue(":priority", $data['priority'], PDO::PARAM_INT);
        }

        $stmnt->bindValue(":is_complete", $data['is_complete'] ?? false, PDO::PARAM_BOOL);

        $stmnt->execute();

        //Return the ID of the task created lastInsertID() method 
        return $this->conn->lastInsertID();
    }

    public function update(string $id, array $data) : int {
        $field = [];
        
        if(!empty($data['name'])) {
            $field["name"] = [$data["name"], PDO::PARAM_STR];
        }
        if(array_key_exists("priority", $data)) {
            $field["priority"] = [$data["priority"], $data["priority"] === null? PDO::PARAM_NULL : PDO::PARAM_INT];
        }
        if(array_key_exists("is_complete", $data)) {
            $field["is_complete"] = [$data["is_complete"], PDO::PARAM_BOOL];
        }

        if(empty($field)){
            return 0;
        }else{

            $sets = array_map(function($value) {

                return "$value = :$value";

            }, array_keys($field));

            $sql = "UPDATE task SET " . implode(", " , $sets) . " WHERE id = :id";

            $stmnt = $this->conn->prepare($sql);

            $stmnt->bindValue(":id", $id, PDO::PARAM_INT);

            foreach ($field as $name=>$value){
                $stmnt->bindValue(":$name", $value[0], $value[1]);
            }

            $stmnt->execute();

            return $stmnt->rowCount();
        }
    }

    public function delete(string $id) : int{

        $sql = "DELETE FROM task WHERE id = :id";

        $stmnt = $this->conn->prepare($sql);
        $stmnt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmnt->execute();

        return $stmnt->rowCount();
    }


}