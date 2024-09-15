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
                //echo "create";
		        //print_r($_POST);
		        $data = (array) json_decode(file_get_contents("php://input"), true);
                //var_dump($data);
                $errors = $this->getValidationErrors($data); 
                if(!empty($errors)){
                    $this->responseUnprocessableEntity($errors);
                    return;
                }
                
                $id = $this->gw->create($data);
                $this->respondCreated($id);


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
                    $data = (array) json_decode(file_get_contents("php://input"), true);
                    $errors = $this->getValidationErrors($data, false); 
                    if(!empty($errors)){
                        $this->responseUnprocessableEntity($errors);
                        return;
                    }
                    //echo "update $id";
                    
                    $rows = $this->gw->update($id, $data);
                    echo json_encode(["message" => "Task Updated", "rows" => $rows]);
                    break;

                case "DELETE":
                    //echo "delete $id";
                    $rows = $this->gw->delete($id);
                    echo json_encode(["message" => "Task Deleted", "rows" => $rows]);
                    break;

                default:
                    $this->respondMethodNotAllowed("GET, PATCH, DELETE");
            }
        }
    }

    private function responseUnprocessableEntity(array $errors) :void {
        http_response_code(422);
        echo json_encode(["errors" => $errors]);
    }

    private function respondMethodNotAllowed (string $allowed_method): void {
        http_response_code(405);
        header("Allow: GET, POST");
    }

    private function responseNotFound(string $id) :void {
        http_response_code(404);
        echo json_encode(["message" => "Task with ID $id not found"]);
    }

    private function respondCreated(string $id) :void {
        http_response_code(201);
        echo json_encode(["message" => "Task Created", "id" => $id]);
    }

    private function getValidationErrors(array $data, bool $is_new = true) : array {

        $errors = [];

        if($is_new && empty($data["name"])){
            $errors[] = "The name is required";    
        }
        if(!empty($data['priority'] )) {
            
            if(filter_var($data['priority'], FILTER_VALIDATE_INT) === false){
                $errors[] = "priority must be an integer"; 
            }
        }

        return $errors;
    }

}
