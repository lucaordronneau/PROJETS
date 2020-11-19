-- auto-generated definition
create table personne
(
    id     int auto_increment
        primary key,
    pseudo varchar(255) not null,
    email  varchar(255) null,
    pays   varchar(255) null,
    mdp    varchar(255) not null,
    statut varchar(255) null,
    score  int          null
);
