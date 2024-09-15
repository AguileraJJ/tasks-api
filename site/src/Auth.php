<?php

class Auth{

    private UserGateway $user_gateway;
    private int $user_id;

    public function __construct($user_gateway) {
        $this->user_gateway = $user_gateway;
    }

    public function authenticationAPIKey() : bool {
        if(empty($_SERVER["HTTP_X_API_KEY"])){

            http_response_code(400);
            echo json_encode(["message" => "missing API Key"]);
            return false;
        }

        $api_key = $_SERVER["HTTP_X_API_KEY"];

        $user = $this->user_gateway->getByApiKey($api_key);

        if ($user === false){
            http_response_code(401);
            echo json_encode(["message" => "invalid API Key"]);
            return false;
        }

        $this->user_id = $user['id'];

        return true;
    }

    public function getUserId():int {
        return $this->user_id;
    }
}