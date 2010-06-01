CREATE TABLE day (date DATE, title VARCHAR(100) NOT NULL, start_latt FLOAT(18, 2), start_long FLOAT(18, 2), end_latt FLOAT(18, 2), end_long FLOAT(18, 2), notes LONGTEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME, PRIMARY KEY(date)) ENGINE = INNODB;
CREATE TABLE position (id INT AUTO_INCREMENT, device_key VARCHAR(30), device_label VARCHAR(50), timestamp INT, latitude FLOAT(18, 2), longitude FLOAT(18, 2), altitude FLOAT(18, 2) DEFAULT 0, speed FLOAT(18, 2) DEFAULT 0, heading FLOAT(18, 2), added INT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE tweet (id bigint, text VARCHAR(140) NOT NULL, html TEXT NOT NULL, uri VARCHAR(255) NOT NULL, reply_id bigint, reply_user_id INT, reply_username VARCHAR(100), language VARCHAR(2) NOT NULL, source VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;