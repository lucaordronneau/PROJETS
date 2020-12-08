create table personne
(
    id     int auto_increment
        primary key,
    pseudo varchar(255) not null,
    email  varchar(255) null,
    pays   varchar(255) null,
    mdp    varchar(255) not null,
    statut varchar(255) null,
    score  int          null,
    sexe   varchar(12)  null
);

create table messagerie
(
    id          int auto_increment
        primary key,
    message     varchar(255) not null,
    date        varchar(255) not null,
    id_personne int          not null,
    constraint messagerie_personne_id_fk
        foreign key (id_personne) references personne (id)
);

