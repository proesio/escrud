/**
 * Este archivo es parte del proyecto Escrud.
 * 
 * @author    Juan Felipe Valencia Murillo  <juanfe0245@gmail.com>
 * @copyright 2020 - presente  Juan Felipe Valencia Murillo
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @version   GIT:  2.6.0
 * @link      https://escrud.proes.io
 * @since     Fecha inicio de creación del proyecto  2020-05-31
 */

drop table if exists usuarios;
drop table if exists usuario;

create table usuarios (
	id int identity(1, 1) primary key not null,
	nombres varchar(50),
	apellidos varchar(50),
	correo varchar(50),
	telefono varchar(50),
	creado_en datetime null,
	actualizado_en datetime null
);

create table usuario (
	codigo int identity(1, 1) primary key not null,
	nombres varchar(50),
	apellidos varchar(50),
	correo varchar(50),
	telefono varchar(50),
	fecha_creacion datetime null,
	fecha_actualizacion datetime null
);
