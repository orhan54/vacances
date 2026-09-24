CREATE TABLE User_(
   Id_User INT AUTO_INCREMENT,
   user_prenom VARCHAR(20) ,
   user_nom VARCHAR(30) ,
   user_adresse VARCHAR(80) ,
   user_cp VARCHAR(5) ,
   user_telephone VARCHAR(50) ,
   user_email VARCHAR(250) ,
   user_mp VARCHAR(250) ,
   user_role VARCHAR(20) DEFAULT 'utilisateur',
   user_created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY(Id_User),
   UNIQUE(user_email)
);

CREATE TABLE Lieu(
   Id_Lieu INT AUTO_INCREMENT,
   lieu_nom VARCHAR(50) ,
   lieu_description TEXT,
   lieu_prix DECIMAL(15,2)  ,
   lieu_image VARCHAR(250) ,
   lieu_created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY(Id_Lieu)
);

CREATE TABLE Reservation(
   Id_Reservation INT AUTO_INCREMENT,
   reservation_date_debut DATE,
   reservation_date_fin DATE,
   reservation_status VARCHAR(20) DEFAULT 'confirmee',
   reservation_created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
   Id_User INT NOT NULL,
   Id_Lieu INT NOT NULL,
   PRIMARY KEY(Id_Reservation),
   FOREIGN KEY(Id_User) REFERENCES User_(Id_User),
   FOREIGN KEY(Id_Lieu) REFERENCES Lieu(Id_Lieu)
);

CREATE TABLE Like_(
   Id_User INT,
   Id_Lieu INT,
   like_created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY(Id_User, Id_Lieu),
   FOREIGN KEY(Id_User) REFERENCES User_(Id_User),
   FOREIGN KEY(Id_Lieu) REFERENCES Lieu(Id_Lieu)
);

CREATE TABLE Commenter(
   Id_User INT,
   Id_Lieu INT,
   contenu TEXT,
   commenter_created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY(Id_User, Id_Lieu),
   FOREIGN KEY(Id_User) REFERENCES User_(Id_User),
   FOREIGN KEY(Id_Lieu) REFERENCES Lieu(Id_Lieu)
);
