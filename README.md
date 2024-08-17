
# Tasks API

Tasks project to add tasks to be done with in the group.

## Installation

Download Docker and docker compose.
Run the docker deamon.
Open a terminal to run the following
```sh
docker compose -f docker-compose.local.yml up -d
```

## Database

Create a .env file in the root directory with the following keys
```sh
DB_HOST = <mysql_hostname> 
DB_NAME = <database_name>
DB_USER = <username>
DB_PASS = <password>
```

The MySql DB is not part of a git ignore so pulling from this Repo will not sync or update to any other DB
Insert into mysql DB:

```sh
CREATE TABLE task (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(128) NOT NULL,
    priority INT DEFAULT NULL,
    is_completed BOOLEAN NOT NULL DEFAULT FALSE,
    PRIMARY KEY (id),
    INDEX (name)
);
 ```

## API endpoints

Get all Task items
- <localhost>/api/tasks

Get Task item by Id
- <localhost>/api/tasks/id
