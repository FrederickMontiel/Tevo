drop database if exists DBTevo;

create database DBTevo;
use DBTevo;

create table Roles(
    idRol int not null primary key auto_increment,
    nombreRol varchar(100) not null
);

create table Usuarios(
    idUsuario     int          not null primary key auto_increment,
    apodoUsuario  varchar(40)  not null,
    correoUsuario varchar(70)  not null,
    claveUsuario  varchar(500) not null
);

create table Sesiones(
    idSesion varchar(100) primary key not null,
    usuarioSesion int not null,

    foreign key (usuarioSesion) references Usuarios(idUsuario)
);

create table RolesUsuario(
    rolAsignacion int not null,
    usuarioAsignacion int not null,

    foreign key (rolAsignacion) references Roles(idRol),
    foreign key (usuarioAsignacion) references Usuarios(idUsuario)
);

create table Notas(
    idNota int not null primary key auto_increment,
    usuarioNota int not null,
    tituloNota varchar(200) not null,
    contenidoNota varchar(50000) not null,
    fechaNota datetime not null,

    foreign key (usuarioNota) references Usuarios(idUsuario)
);

INSERT INTO Roles (idRol, nombreRol) VALUES (1, "Admin");
INSERT INTO Roles (idRol, nombreRol) VALUES (2, "Usuario");
INSERT INTO Roles (idRol, nombreRol) VALUES (3, "Premium");
INSERT INTO Roles (idRol, nombreRol) VALUES (4, "Donador");

INSERT INTO `Usuarios`(`idUsuario`, `apodoUsuario`, `correoUsuario`, `claveUsuario`) VALUES (1,"DickyM","fmontiel2019145@gmail.com","$2y$10$UADp4CVgDfMiKhNd1zB.guM0455zRf/DL1rECh00MvSXNQmKC4sPi");
