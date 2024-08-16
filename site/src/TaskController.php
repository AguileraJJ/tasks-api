<?php

class TaskController{

    private TaskGateway $gw;

    public function __construct($gateway) {
        $this->gw = $gateway;
    }

    public function processRequest(string $method, ?string $id): void{
        if($id === null){
            if ($method == "GET"){
                //echo "index";
                echo json_encode($this->gw->getAll());

            }elseif ($method == "POST"){
                echo "create";
            }else{
                $this->respondMethodNotAllowed("GET, POST");
            }
        }else{

            $task = $this->gw->get($id);

            if($task === false) {
                $this->responseNotFound($id);
                return;

            }

            switch ($method){
                case "GET":
                    //echo "show $id";
                    echo json_encode($task);
                    break;

                case "PATCH":
                    echo "update $id";
                    break;

                case "DELETE":
                    echo "delete $id";
                    break;

                default:
                    $this->respondMethodNotAllowed("GET, PATCH, DELETE");
            }
        }
    }

    private function respondMethodNotAllowed (string $allowed_method): void {
        http_response_code(405);
        header("Allow: GET, POST");
    }

    private function responseNotFound(string $id) :void {
        http_response_code(404);
        echo json_encode(["message" => "Task with ID $id not found"]);
    }

}