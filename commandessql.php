CREATE TABLE Adresse(
   idAdresse INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
   NumeroVoie INT,
   Ville CHAR(50),
   Pays CHAR(50),
   Rue CHAR(50),
  Complément CHAR(50),
   Boite_Postale VARCHAR(50),
   Code_Postal VARCHAR(50),
   CEDEX INT
);
 
INSERT INTO Adresse(NumeroVoie, Rue, Ville, Code_Postal)
SELECT DISTINCT adr_fede_numVoie, adr_fede_rue, adr_fede_ville, adr_fede_cp
FROM donnees_fournies.instances1
WHERE NOT EXISTS (
   SELECT * FROM `Adresse` A
   WHERE A.NumeroVoie = adr_fede_numVoie AND A.Rue= adr_fede_rue AND A.Ville = adr_fede_ville AND A.Code_Postal= adr_fede_cp
) ;
 
INSERT INTO Adresse(NumeroVoie, Rue, Ville, Code_Postal)
SELECT DISTINCT adr_comite_reg_numVoie, adr_comite_reg_rue, adr_comite_reg_ville, adr_comite_reg_cp
FROM donnees_fournies.instances1
WHERE NOT EXISTS (
   SELECT * FROM `Adresse` A
   WHERE A.NumeroVoie = adr_comite_reg_numVoie AND A.Rue= adr_comite_reg_rue AND A.Ville = adr_comite_reg_ville AND A.Code_Postal= adr_comite_reg_cp
) ;
 
INSERT INTO Adresse(NumeroVoie, Rue, Ville, Code_Postal)
SELECT DISTINCT adr_comite_dept_numVoie, adr_comite_dept_rue, adr_comite_dept_ville, adr_comite_dept_cp
FROM donnees_fournies.instances1
WHERE NOT EXISTS (
   SELECT * FROM `Adresse` A
   WHERE A.NumeroVoie = adr_comite_dept_numVoie AND A.Rue= adr_comite_dept_rue AND A.Ville = adr_comite_dept_ville AND A.Code_Postal= adr_comite_dept_cp
);
 
INSERT INTO Adresse(NumeroVoie, Rue, Ville, Code_Postal)
SELECT DISTINCT adr_ecole_numVoie, adr_ecole_rue, adr_ecole_cp, adr_ecole_ville
FROM donnees_fournies.instances3
WHERE NOT EXISTS (
   SELECT * FROM `Adresse` A
   WHERE A.NumeroVoie= adr_ecole_numVoie AND A.Rue= adr_ecole_rue AND A.Ville = adr_ecole_ville AND A.Code_Postal= adr_ecole_cp
) ;
 
INSERT INTO Adresse(NumeroVoie, Rue, Ville, Code_Postal)
SELECT DISTINCT adr_danseur_numVoie, adr_danseur_rue, adr_danseur_cp, adr_danseur_ville
FROM donnees_fournies.instances4
WHERE NOT EXISTS (
   SELECT * FROM `Adresse` A
   WHERE A.NumeroVoie = adr_danseur_numVoie AND A.Rue= adr_danseur_rue AND A.Ville = adr_danseur_ville AND A.Code_Postal= adr_danseur_cp
);

CREATE TABLE Federation(
   IdFede INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
   Nom CHAR(50),
   Sigle CHAR(50),
   Nom__Prenom__President VARCHAR(50),
   idAdresse INT NOT NULL,
   FOREIGN KEY (idAdresse) REFERENCES Adresse(idAdresse)
);
 
INSERT INTO Federation(Nom, Sigle, Nom__Prenom__President, idAdresse)
SELECT DISTINCT F.fede_nom, F.fede_sigle, F.fede_dirigeant, A.idAdresse
FROM donnees_fournies.instances1 F
JOIN Adresse A ON A.NumeroVoie = F.adr_fede_numVoie AND A.Rue= adr_fede_rue AND A .Ville  = F.adr_fede_ville AND A.Code_Postal = F.adr_fede_cp;
 
CREATE TABLE Ecole_De_Danse(
   IdEcole INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
   NomEcole CHAR(50) NOT NULL,
   NomFondateur VARCHAR(50),
   IdFede INT NOT NULL,
   idAdresse INT NOT NULL,
   FOREIGN KEY(IdFede) REFERENCES Federation (IdFede),
   FOREIGN KEY(idAdresse) REFERENCES Adresse(idAdresse)
);






INSERT INTO Ecole_De_Danse(nomEcole,NomFondateur,IdFede,idAdresse)
SELECT DISTINCT E.ecole_nom, E.ecole_fondateur, F.IdFede, A.idAdresse
FROM donnees_fournies.instances3 E
JOIN Adresse A ON A.NumeroVoie = E.adr_ecole_numVoie AND A.Rue= E.adr_ecole_rue AND A .Ville  = E.adr_ecole_ville AND A.Code_Postal = E.adr_ecole_cp
JOIN Federation F ON F.Nom = E.fede_nom;
 


CREATE TABLE Comite(
   idComite INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
   Libelle CHAR(50),
   Niveau CHAR(50),
   IdFede INT NOT NULL,
   idAdresse INT NOT NULL,
   FOREIGN KEY(IdFede) REFERENCES Federation (IdFede),
   FOREIGN KEY(idAdresse) REFERENCES Adresse (idAdresse)
);
 
INSERT INTO Comite(Libelle, Niveau, IdFede, idAdresse)
SELECT DISTINCT C.comite_dept_nom, C.comite_dept_niveau, F.IdFede, A.idAdresse
FROM donnees_fournies.instances1 C
JOIN Adresse A ON A.NumeroVoie = C.adr_comite_dept_numVoie AND A.Rue= C.adr_comite_dept_rue AND A .Ville  = C.adr_comite_dept_ville AND A.Code_Postal = C.adr_comite_dept_cp
JOIN Federation F ON F.Nom = C.fede_nom;

INSERT INTO Comite(Libelle, Niveau, IdFede, idAdresse)
SELECT DISTINCT C.comite_reg_nom, C.comite_reg_niveau, F.IdFede, A.idAdresse
FROM donnees_fournies.instances1 C
JOIN Adresse A ON A.NumeroVoie = C.adr_comite_reg_numVoie AND A.Rue= C.adr_comite_reg_rue AND A .Ville  = C.adr_comite_reg_ville AND A.Code_Postal = C.adr_comite_reg_cp
JOIN Federation F ON F.Nom = C.fede_nom;




CREATE TABLE Employe( 
idEmp INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
 nom VARCHAR(50), prenom VARCHAR(50) );

INSERT INTO Employe (prenom, nom) SELECT DISTINCT I.cours_resp_prénom, I.cours_resp_nom FROM donnees_fournies.instances3 I ;
CREATE TABLE Periode( 
annee INT NOT NULL PRIMARY KEY ) ;
CREATE TABLE travaille ( idEmp int NOT NULL, 
idEcole int NOT NULL, 
fonction VARCHAR(50), 
annee INT, 
FOREIGN KEY (idEmp) REFERENCES Employe(idEmp),
 FOREIGN KEY (idEcole) REFERENCES Ecole_De_Danse(idEcole) ,
FOREIGN KEY (annee) REFERENCES Periode(annee), 
UNIQUE KEY(idEmp, idEcole, annee, fonction) ) ;
INSERT INTO Periode(annee)
SELECT 2001;

INSERT INTO travaille (idEmp, idEcole, fonction) 
SELECT DISTINCT Emp.idEmp, Ec.IdEcole, I.cours_libellé 
FROM donnees_fournies.instances3 I 
JOIN Ecole_De_Danse Ec ON Ec.NomEcole = I.ecole_nom AND Ec.NomFondateur = I.ecole_fondateur 
JOIN Employe Emp ON Emp.nom = I.cours_resp_nom AND Emp.prenom = I.cours_resp_prénom;

CREATE TABLE Adherent (
  numLicence INT NOT NULL PRIMARY KEY,
  Nom CHAR(50),
  Prenom CHAR(50),
  dateNaiss DATE,
  idAdresse INT NOT NULL,
  anneeAdhesion INT NOT NULL,
  numEcole INT NOT NULL,
  FOREIGN KEY (idAdresse) REFERENCES Adresse(idAdresse),
  FOREIGN KEY (numEcole) REFERENCES Ecole_De_Danse(idEcole)
);
 

INSERT IGNORE INTO Adherent(numLicence, Nom, Prenom, dateNaiss, idAdresse,anneeAdhesion,numEcole)
SELECT DISTINCT D.danseur_numLicence, D.danseur_nom, D.danseur_prenom, D.danseur_date_naissance, A.idAdresse,D.annee_inscription,E.idEcole
FROM donnees_fournies.instances4 D
JOIN Ecole_De_Danse E ON D.ecole_nom = E.NomEcole
JOIN Adresse A ON A.NumeroVoie = D.adr_danseur_numVoie AND A.Rue= D.adr_danseur_rue AND A .Ville  = D.adr_danseur_cp AND A.Code_Postal = D.adr_danseur_ville;




CREATE TABLE est_rattache (
  idComite1 int NOT NULL,
  idComite2 int NOT NULL,
  FOREIGN KEY (idComite1) REFERENCES Comite(idComite),
                    	 
  FOREIGN KEY (idComite2) REFERENCES Comite(idComite)
                    	 
); 
CREATE TABLE Cours(
   code INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
   Libelle VARCHAR(50),
   Age CHAR(50)
);

CREATE TABLE EveilDanse(
   code INT PRIMARY KEY REFERENCES Cours (code)
);

CREATE TABLE Danse(
   code INT PRIMARY KEY REFERENCES Cours (code),
   categorie VARCHAR(50)
);
CREATE TABLE TypeDanse (
  type VARCHAR(50) PRIMARY KEY
);

CREATE TABLE influence (
  influencer_type VARCHAR(50) NOT NULL,
  influenced_type VARCHAR(50) NOT NULL,
  PRIMARY KEY (influencer_type, influenced_type),
  FOREIGN KEY (influencer_type) REFERENCES TypeDanse (type),
  FOREIGN KEY (influenced_type) REFERENCES TypeDanse (type)
);


CREATE TABLE Atype(
   code INT NOT NULL,
   type VARCHAR(50) NOT NULL,
   PRIMARY KEY (code, type),
   FOREIGN KEY (code) REFERENCES Danse (code),
   FOREIGN KEY (type) REFERENCES TypeDanse (type)
);

INSERT IGNORE INTO TypeDanse (type)
SELECT type_danse FROM donnees_fournies.type_danse;
CREATE TABLE Zumba(
   code INT PRIMARY KEY REFERENCES Cours (code),
   ambiance VARCHAR(50)
);

INSERT INTO Cours(Libelle, Age)
SELECT DISTINCT I.cours_libellé, I.cours_categorie_age
FROM donnees_fournies.instances3 I;


CREATE TABLE delivre(
  codeCours int NOT NULL,
  idEmploye int NOT NULL,
  idEc int NOT NULL,
  annee INT,
  FOREIGN KEY (codeCours) REFERENCES Cours(code),           	 
  FOREIGN KEY (idEmploye) REFERENCES Employe(idEmp),                 	 
  FOREIGN KEY (idEc) REFERENCES Ecole_De_Danse(idEcole),                 	 
  FOREIGN KEY (annee) REFERENCES Periode(annee),
  UNIQUE KEY(codeCours, idEmploye ,idEc ,  annee)
) ;



INSERT INTO delivre(codeCours, idEmploye, idEc, annee)
SELECT C.code, E.idEmp, Ec.IdEcole, 2001
FROM donnees_fournies.instances3 I
JOIN Cours C ON C.Libelle = I.cours_libellé AND C.Age = cours_categorie_age
JOIN Employe E ON E.prenom = I.cours_resp_prénom AND E.nom = cours_resp_nom
JOIN Ecole_De_Danse Ec ON Ec.NomEcole = I.ecole_nom AND Ec.NomFondateur = I.ecole_fondateur ;

INSERT INTO Zumba(code, ambiance)
SELECT C.code , C.Libelle
FROM Cours C
WHERE C.Libelle LIKE "%Zumba%";

INSERT INTO Danse(code, categorie)
SELECT C.code, "JO 2024"
FROM Cours C
WHERE C.Libelle NOT LIKE "%Zumba%";

INSERT INTO est_rattache(idComite1, idComite2)
SELECT DISTINCT C1.idComite, C2.idComite
FROM donnees_fournies.instances1 I
JOIN Comite C1 ON C1.Libelle = I.comite_reg_nom AND C1.Niveau = "reg"
JOIN Comite C2 ON C2.Libelle = I.comite_dept_nom AND C2.Niveau = "dept";

CREATE TABLE Competition (
	Code VARCHAR(50) PRIMARY KEY NOT NULL,
    Libelle VARCHAR(80),
    Niveau VARCHAR(50)
);

INSERT INTO Competition(Code, Libelle, Niveau)
SELECT DISTINCT Ins.compet_code, Ins.compet_libellé, Ins.compet_niveau
FROM donnees_fournies.instances2 Ins;

CREATE TABLE Certificat_Medical(
   idCert INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
   periodeAdhesion DATE,
   numero_licence INT NOT NULL,
   FOREIGN KEY(numero_licence) REFERENCES Adherent(numLicence)
);
 
CREATE TABLE Structure_sportive(
   idStructSport INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
   Nom VARCHAR(50),
   TypeStructSport VARCHAR(50),
   idAdresse INT NOT NULL,
   FOREIGN KEY(idAdresse) REFERENCES Adresse(idAdresse)
);

CREATE TABLE Groupe_De_Danse(
   idGroupe INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
   nom VARCHAR(50),
   genre VARCHAR(50));
 
CREATE TABLE couple(
   idCouple INT PRIMARY KEY NOT NULL AUTO_INCREMENT
);

CREATE TABLE dansentGroupe(
  idGroupe int NOT NULL,
  numLicence int NOT NULL,
  FOREIGN KEY (numLicence) REFERENCES Adherent(numLicence),
                    	 
  FOREIGN KEY (idGroupe) REFERENCES Groupe_De_Danse(idGroupe),
                    	 
  UNIQUE KEY(idGroupe , numLicence)
);

CREATE TABLE dansentCouple(
  idCouple int NOT NULL,
  numLicence1 int NOT NULL,
  numLicence2 int NOT NULL,
  FOREIGN KEY (idCouple) REFERENCES couple(idCouple),
  FOREIGN KEY (numLicence1) REFERENCES Adherent(numLicence),
  FOREIGN KEY (numLicence2) REFERENCES Adherent(numLicence),
  UNIQUE KEY(idCouple, numLicence1, numLicence2)
);CREATE TABLE Edition(
   annee INT PRIMARY KEY NOT NULL,
   ville VARCHAR(50),
   idStructSport INT NOT NULL,
   FOREIGN KEY (idStructSport ) REFERENCES Structure_sportive(idStructSport)
);

CREATE TABLE organise(
  idComite int NOT NULL,
  Code VARCHAR(50) NOT NULL,
  FOREIGN KEY (idComite) REFERENCES Comite(idComite),
                    	 
  FOREIGN KEY (Code) REFERENCES Competition(Code)
                    	 
);

CREATE TABLE Seance(
   code INT NOT NULL,
   num INT NOT NULL,
   jour VARCHAR(50),
   creneauHoraire VARCHAR(50),
   PRIMARY KEY(code, num),
   FOREIGN KEY(code) REFERENCES Cours(code)
);

CREATE TABLE participationCouple(
numPassage INT NOT NULL,
rang INT NOT NULL,
idCouple INT NOT NULL,
annee INT NOT NULL,
FOREIGN KEY(annee) REFERENCES Edition(annee),
FOREIGN KEY(idCouple) REFERENCES couple(idCouple)
);




CREATE TABLE participationGroupe(
numPassage INT NOT NULL,
rang INT NOT NULL,
idGroupe INT NOT NULL,
annee INT NOT NULL,
FOREIGN KEY(annee) REFERENCES Edition(annee),
FOREIGN KEY(idGroupe) REFERENCES Groupe_De_Danse(idGroupe)
);