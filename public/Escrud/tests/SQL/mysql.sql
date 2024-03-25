/**
 * Este archivo es parte del proyecto Escrud.
 * 
 * @author    Juan Felipe Valencia Murillo  <juanfe0245@gmail.com>
 * @copyright 2020 - presente  Juan Felipe Valencia Murillo
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @version   GIT:  2.6.7
 * @link      https://escrud.proes.io
 * @since     Fecha inicio de creación del proyecto  2020-05-31
 */

drop table if exists usuarios;
drop table if exists usuario;

create table usuarios (
	id int primary key auto_increment not null,
	nombres varchar(50),
	apellidos varchar(50),
	correo varchar(50),
	telefono varchar(50),
	creado_en timestamp null,
	actualizado_en timestamp null
);

create table usuario (
	codigo int primary key auto_increment not null,
	nombres varchar(50),
	apellidos varchar(50),
	correo varchar(50),
	telefono varchar(50),
	fecha_creacion timestamp null,
	fecha_actualizacion timestamp null
);
