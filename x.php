<?php
/**
 * Created by PhpStorm.
 * User: informatica
 * Date: 03/04/2018
 * Time: 10:45
 */
$carpeta = "prueba/";

if(!file_exists("temp/Home/".$carpeta)){
    mkdir("temp/Home/".$carpeta, 0777, true);
    echo "temp/Home/".$carpeta;
}