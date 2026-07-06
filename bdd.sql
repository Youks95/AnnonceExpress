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
insert into annonce values(null, 'iPhone 13', 'iPhone 13 128Go noir, très bon état, batterie 89%', 350.00, 'Electronique', null, 2);
insert into annonce values(null, 'Vélo de ville', 'Vélo bleu, cadre aluminium, peu utilisé, taille M', 80.00, 'Sport', null, 2);
insert into annonce values(null, 'Canapé 3 places', 'Canapé gris anthracite, très confortable, 2 ans', 150.00, 'Mobilier', null, 3);
insert into annonce values(null, 'Bureau en angle', 'Bureau noir en angle, 160x120cm, bon état', 199.99, 'Mobilier', null, 3);
insert into annonce values(null, 'PS5 + 2 manettes', 'PS5 édition standard avec 2 manettes et 3 jeux', 450.00, 'Electronique', null, 4);
insert into annonce values(null, 'Veste Nike', 'Veste Nike grise taille L, portée 2 fois', 35.00, 'Vêtements', null, 4);
insert into annonce values(null, 'Guitare acoustique', 'Guitare Yamaha F310, idéale débutant, avec housse', 90.00, 'Musique', null, 5);
insert into annonce values(null, 'Réfrigérateur', 'Réfrigérateur Samsung 300L, classe A+, 3 ans', 220.00, 'Electroménager', null, 5);
insert into annonce values(null, 'Table basse', 'Table basse en bois clair, 110x60cm, style scandinave', 60.00, 'Mobilier', null, 6);
insert into annonce values(null, 'Trottinette électrique', 'Trottinette Xiaomi M365, autonomie 25km, chargeur inclus', 180.00, 'Transport', null, 6);
insert into annonce values(null, 'MacBook Air M1', 'MacBook Air M1 2021, 8Go RAM, 256Go SSD, très bon état', 750.00, 'Electronique', null, 2);
insert into annonce values(null, 'Raquette de tennis', 'Raquette Wilson Pro Staff, cordée, housse incluse', 45.00, 'Sport', null, 3);
insert into annonce values(null, 'Micro-ondes', 'Micro-ondes Whirlpool 25L, fonctionne parfaitement', 40.00, 'Electroménager', null, 4);
insert into annonce values(null, 'Chaise de bureau', 'Chaise de bureau ergonomique, accoudoirs réglables', 85.00, 'Mobilier', null, 5);
insert into annonce values(null, 'Nike Air Force 1', 'Nike Air Force 1 blanches, pointure 42, jamais portées', 70.00, 'Vêtements', null, 6);
