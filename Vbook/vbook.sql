CREATE DATABASE VBOOK;

CREATE TABLE `user`(
    `userID` INT NOT NULL AUTO_INCREMENT,
    `userName` varchar(20) NOT NULL,
    `userEmail` varchar(100) NOT NULL UNIQUE,
    `userPwd` varchar(255) NOT NULL,
    `userRoles` int(11) NOT NULL DEFAULT 2 COMMENT '1 - Admin, 2 - User, 3 - Manager',
    `registrationDate` date NOT NULL DEFAULT CURRENT_DATE(),
    `contact` varchar(20),
    PRIMARY  KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE user ADD user_avatar VARCHAR(255) NULL;

CREATE TABLE venue(
    venue_id INT PRIMARY KEY AUTO_INCREMENT,
    userID INT,
    venue_name VARCHAR(100),
    venue_type varchar(10),
    venue_price DOUBLE,
    venue_location varchar(10),
    venue_description TEXT,
    venue_media varchar(10),
    FOREIGN KEY (userID) REFERENCES User(userID) ON DELETE CASCADE
);

CREATE TABLE booking(
    booking_id INT PRIMARY KEY AUTO_INCREMENT,
    venue_id INT,
    userID INT,
    event_name varchar(30),
    event_type varchar(100),
    event_no_guest INT,
    event_date date,
    event_alt_date  date,
    event_description  text,
    hotel_room  INT,
    FOREIGN KEY (userID) REFERENCES user(userID) ON DELETE CASCADE,
    FOREIGN KEY (venue_id) REFERENCES venue(venue_id) ON DELETE CASCADE
);

CREATE TABLE comments (
    comment_id INT PRIMARY KEY AUTO_INCREMENT,
    venue_id INT,
    userID INT,
    comment_text TEXT,
    star_rating INT,
    comment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (venue_id) REFERENCES venue(venue_id) ON DELETE CASCADE,
    FOREIGN KEY (userID) REFERENCES user(userID) ON DELETE CASCADE
);