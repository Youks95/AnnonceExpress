-- On vérifie que la bdd existe, si c'est le cas on écrase tout
drop database if exists annonce_express;

-- On crée la bdd
create database annonce_express;

-- On accède à la bdd
use annonce_express;

create table annonce(
idannonce int auto_increment not null primary key,
titre varchar(100),
description varchar(1500),
prix decimal(10,2),
categorie varchar(50),
photo varchar(150)
);

insert into annonce values(null, 'iPhone 13', 'iPhone 13 en très bon état, 128Go', 350.00, 'Electronique', null);
insert into annonce values(null, 'Vélo de ville', 'Vélo bleu, peu utilisé', 80.00, 'Sport', null);
insert into annonce values(null, 'Canapé 3 places', 'Canapé gris, très confortable', 150.00, 'Mobilier', null);
insert into annonce values(null, 'Bureau', 'Bureau noir en angle', 199.99, 'Mobilier', null);