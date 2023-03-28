create table oc_relocation_history (
relocation_id INT NOT NULL AUTO_INCREMENT,
vin VARCHAR(64) NOT NULL,
old_address VARCHAR(512) NOT NULL,
new_address varchar(512) NOT NULL,
relocation_date DATETIME NOT NULL,
manager INT(11) NOT NULL,
PRIMARY KEY(relocation_id),
FOREIGN KEY (manager) REFERENCES oc_user(user_id)
);