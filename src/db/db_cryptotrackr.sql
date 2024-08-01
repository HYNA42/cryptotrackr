--24.05.2024
-- cryptotrackr
CREATE DATABASE `db_cryptotrackr`;

USE DATABASE `db_cryptotrackr`;

CREATE TABLE  `Role`(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(25) NOT NULL
);

CREATE TABLE  `User`(
    id VARCHAR(36) NOT NULL PRIMARY KEY ,
    firstname VARCHAR(50) NOT NULL, 
    lastname VARCHAR(50) NOT NULL, 
    pseudo VARCHAR(50) NOT NULL UNIQUE, 
    birthday DATE NOT NULL, 
    email VARCHAR(100) NOT NULL UNIQUE, 
    password VARCHAR(256) NOT NULL, 
    profil_picture VARCHAR(255) DEFAULT "src/db/img/default_picture.png",
    role_id INT DEFAULT 2,
    FOREIGN KEY(role_id) REFERENCES Role(id)
);

CREATE TABLE `Cryptocurrency` (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    rankCrypto INT,
    image VARCHAR(255) NOT NULL,
    symbol VARCHAR(10) NOT NULL,
    name VARCHAR(50) NOT NULL UNIQUE,
    price DECIMAL(10, 2) NOT NULL,
    evolution DECIMAL(10, 2) NOT NULL,
    historical_data JSON NOT NULL
);



CREATE TABLE  `Preference`(
    user_id VARCHAR(36) NOT NULL,
    cryptocurrency_id VARCHAR(36) NOT NULL,
   
    
    PRIMARY KEY(user_id,cryptocurrency_id),

    FOREIGN KEY (user_id) REFERENCES User(id),
    FOREIGN KEY (cryptocurrency_id) REFERENCES Cryptocurrency(id),
);





--ENREGISTREMENT DES VALEURS
INSERT INTO Role(name) VALUES('admin'),('user');


INSERT INTO User(id,firstname,lastname,birthday,email,password,pseudo,profil_picture,role_id)
            VALUES
            (UUID(),'Joh','NANTES','2024-05-24','ola@duck.com','$2y$10$JYFDlWFCyU3dFIWKO37Ageh.7qFeCKf2.6lWg17XCaPh7j4YwC2rW','Hyna','src/db/img/default_picture.png',1),

            (UUID(),'Nafi','TANGER','2024-05-24','coucou2005@gmail.com','$2y$10$JYFDlWFCyU3dFIWKO37Ageh.7qFeCKf2.6lWg17XCaPh7j4YwC2rW','NS42','src/db/img/default_picture.png',2),

            (UUID(),'Kim','DALLAS','2000-01-17','elhakeem3@gmail.com','$2y$10$JYFDlWFCyU3dFIWKO37Ageh.7qFeCKf2.6lWg17XCaPh7j4YwC2rW','ELHAKIM','src/db/img/default_picture.png',2);
           

INSERT INTO Cryptocurrency(id,name,price,symbol,evolution)
            VALUES
            (UUID(),'Bitcoin',68000.78,'BTC',1.13),
            (UUID(),'Ethereum',3000.94,'ETH',2.76),
            (UUID(),'Ripple', 1.50, 'XRP', 1.80),
            (UUID(),'Litecoin', 180.00, 'LTC', 2.90),
            (UUID(),'Cardano', 1.20, 'ADA', 2.10);


INSERT INTO Preference(user_id,cryptocurrency_id)
            VALUES
            ((SELECT id FROM User WHERE pseudo='Hyna'),(SELECT id FROM Cryptocurrency WHERE name = 'Ethereum')), 
            ((SELECT id FROM User WHERE pseudo='NS42'),(SELECT id FROM Cryptocurrency WHERE name = 'Ripple')), 
            ((SELECT id FROM User WHERE pseudo='ELHAKIM'),(SELECT id FROM Cryptocurrency WHERE name = 'Bitcoin')); 

INSERT INTO Preference(user_id,cryptocurrency_id,user_pseudo,cryptocurrency_name)
            VALUES
            ((SELECT id FROM User WHERE pseudo='Hyna'),(SELECT id FROM Cryptocurrency WHERE name = 'Ethereum'),'Hyna',); 


