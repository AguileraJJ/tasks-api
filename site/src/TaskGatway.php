<?php

class TaskGateway {

    private PDO $con;

    public function __constructor(Database $database) {
        $this->$conn = $database->getConnection();
    }


}