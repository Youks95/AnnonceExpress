-- On vérifie que la bdd existe, si c'est le cas on écrase tout
drop database if exists annonce_express;

-- On crée la bdd
create database annonce_express;

-- On accède à la bdd
use annonce_express;

create table user(
iduser int auto_increment not null primary key,
pseudo varchar(50),
mdp varchar(50),
role varchar(10)
);

create table annonce(
idannonce int auto_increment not null primary key,
titre varchar(100),
description varchar(1500),
prix decimal(10,2),
categorie varchar(50),
photo varchar(150),
iduser int,
constraint fk_user foreign key(iduser) references user(iduser)
);

-- Comptes utilisateurs
insert into user values(null, 'admin', 'admin123', 'admin');
insert into user values(null, 'abdel', 'abdel123', 'user');
insert into user values(null, 'sarah', 'sarah123', 'user');
insert into user values(null, 'karim', 'karim123', 'user');
insert into user values(null, 'julia', 'julia123', 'user');
insert into user values(null, 'thomas', 'thomas123', 'user');

-- Annonces
insert into annonce values(null, 'iPhone 13', 'iPhone 13 128Go noir, très bon état, batterie 89%', 350.00, 'Electronique', 'images/OIP.jpg', 2);
insert into annonce values(null, 'Vélo de ville', 'Vélo bleu, cadre aluminium, peu utilisé, taille M', 80.00, 'Sport', 'images/Capture d''écran 2026-05-18 155639.png', 2);
insert into annonce values(null, 'Canapé 3 places', 'Canapé gris anthracite, très confortable, 2 ans', 150.00, 'Mobilier', 'images/OIP.webp', 3);
insert into annonce values(null, 'Bureau en angle', 'Bureau noir en angle, 160x120cm, bon état', 199.99, 'Mobilier', 'images/OIP (1).webp', 3);
insert into annonce values(null, 'PS5 + 2 manettes', 'PS5 édition standard avec 2 manettes et 3 jeux', 450.00, 'Electronique', 'images/télécharger.webp', 4);
insert into annonce values(null, 'Veste Nike', 'Veste Nike grise taille L, portée 2 fois', 35.00, 'Vêtements', 'images/OIP (2).webp', 4);
insert into annonce values(null, 'Guitare acoustique', 'Guitare Yamaha F310, idéale débutant, avec housse', 90.00, 'Musique', 'images/OIP (3).webp', 5);
insert into annonce values(null, 'Réfrigérateur', 'Réfrigérateur Samsung 300L, classe A+, 3 ans', 220.00, 'Electroménager', 'images/télécharger (1).webp', 5);
insert into annonce values(null, 'Table basse', 'Table basse en bois clair, 110x60cm, style scandinave', 60.00, 'Mobilier', 'images/OIP (4).webp', 6);
insert into annonce values(null, 'Trottinette électrique', 'Trottinette Xiaomi M365, autonomie 25km, chargeur inclus', 180.00, 'Transport', 'images/télécharger (2).webp', 6);
insert into annonce values(null, 'MacBook Air M1', 'MacBook Air M1 2021, 8Go RAM, 256Go SSD, très bon état', 750.00, 'Electronique', 'images/OIP (5).webp', 2);
insert into annonce values(null, 'Raquette de tennis', 'Raquette Wilson Pro Staff, cordée, housse incluse', 45.00, 'Sport', 'images/télécharger (3).webp', 3);
insert into annonce values(null, 'Micro-ondes', 'Micro-ondes Whirlpool 25L, fonctionne parfaitement', 40.00, 'Electroménager', 'images/télécharger (5).webp', 4);
insert into annonce values(null, 'Chaise de bureau', 'Chaise de bureau ergonomique, accoudoirs réglables', 85.00, 'Mobilier', 'images/télécharger (6).webp', 5);
insert into annonce values(null, 'Nike Air Force 1', 'Nike Air Force 1 blanches, pointure 42, jamais portées', 70.00, 'Vêtements', 'images/OIP (6).webp', 6);
