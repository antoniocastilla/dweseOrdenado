create database nombrebd
  default character set utf8
  collate utf8_general_ci;
  
create user usuariobd@localhost
  identified by 'clavebd';

grant all
  on nombrebd.*
  to usuariobd@localhost;

flush privileges;

create table producto (
    id bigint not null auto_increment primary key,
    nombre varchar(30) not null,
    precio numeric(10, 3) not null,
    observaciones text
) engine = innodb
  character set utf8
  collate utf8_general_ci;
  
create table usuario (
    id bigint not null auto_increment primary key,
    correo varchar (60) not null unique,
    alias varchar (30) unique, 
    nombre varchar (255) not null,
    clave varchar(255) not null,
    activo tinyint (1) default 0,
    fechaalta timestamp default current_timestamp
) engine = innodb
  character set utf8
  collate utf8_general_ci;
  
create table usuario2 (
    id bigint not null auto_increment primary key,
    correo varchar (60) not null unique,
    alias varchar (30) unique, 
    nombre varchar (255) not null,
    clave varchar(255) not null,
    admin tinyint (1) default 0,
    activo tinyint (1) default 0,
    fechaalta timestamp default current_timestamp
) engine = innodb
  character set utf8
  collate utf8_general_ci;
  
create table fecha (
    id bigint not null auto_increment primary key,
    fecha date,
    fechahora datetime,
    marcatiempo timestamp default current_timestamp on update current_timestamp
    <!--on update current_timestamp para ultima mdificacion -->
) engine = innodb
  character set utf8
  collate utf8_general_ci;
  
  <--SELECT CURDATE(), CURTIME(), CURRENT_TIMESTAMP(), NOW()-->
  insert into fecha values (null, curdate(), now(), null);