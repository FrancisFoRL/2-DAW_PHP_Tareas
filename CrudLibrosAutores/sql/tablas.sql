CREATE TABLE autores(
    id int auto_increment primary key,
    nombre varchar(20) not null,
    apellidos varchar(50) not null,
    fecha_nacimiento Date,
    foto varchar(50) default 'img/autores/default.png'
);

CREATE TABLE libros(
    id int auto_increment primary key,
    nombre varchar(30) not null,
    isbn varchar(15) unique not null,
    categoria enum('Cuentos', 'Humor', 'Aventuras', 'Suspense', 'Ciencia Ficcion', 'Romantica'),
    descripcion varchar(120),
    portada varchar(50) default 'img/libros/default.png',
    autor_id int,
    constraint autor_libros foreign key (autor_id) references autores(id) on delete cascade on update cascade
);

 