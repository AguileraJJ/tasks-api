Tasks project to add tasks to be done with in the group.

Create a .env file with the following keys
DB_HOST
DB_NAME
DB_USER
DB_PASS

The MySql DB is not part of a git ignore so pulling from this Repo will not sync or update to any other DB
Insert into mysql DB:
CREATE TABLE task (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(128) NOT NULL,
    priority INT DEFAULT NULL,
    is_completed BOOLEAN NOT NULL DEFAULT FALSE,
    PRIMARY KEY (id),
    INDEX (name)
);
 

API endpoints coming soon
