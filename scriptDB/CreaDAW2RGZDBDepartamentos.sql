/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  daw2
 * Created: 4 nov. 2021
 */

create database DAW2103DBDepartamentos;
use DAW2103DBDepartamentos;

create user 'usuarioDAW2103DBDepartamentos'@'%' IDENTIFIED BY 'P@ssw0rd';
grant all privileges on DAW2103DBDepartamentos.* to 'usuarioDAW2103DBDepartamentos'@'%' with grant option;

CREATE TABLE IF NOT EXISTS Departamento(
    CodDepartamento varchar(3) PRIMARY KEY,
    DescDepartamento varchar(255) NOT NULL,
    FechaBaja date NULL,
    VolumenNegocio float NULL
)engine=innodb;


