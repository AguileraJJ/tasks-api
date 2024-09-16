<?php

class UserGateway{

    private PDO $conn;

    public function __construct(Database $database) {
        $this->conn = $database->getConnection();
    }

    public function getByApiKey(string $key):array|false{

        $sql = "SELECT * FROM user WHERE api_key = :api_key";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":api_key", $key, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public function getByUsername(string $username): array | false {

        $sql = "SELECT * FROM user WHERE username = :username";

        $stmnt = $this->conn->prepare($sql);
        $stmnt->bindValue(":username", $username, PDO::PARAM_STR);

        $stmnt->execute();

        return $stmnt->fetch(PDO::FETCH_ASSOC);

    }
}