<?php
ini_set('max_execution_time','300');

//*******Rutas Audinfor***********************************************************************************************//
$AudinforEnergyF1 = "//192.168.0.3/XML_Audinfor/Energy/F1/";
$AudinforEnergyQ1 = "//192.168.0.3/XML_Audinfor/Energy/Q1/";

$AudinforHomeF1 = "//192.168.0.3/XML_Audinfor/Home/F1/";
$AudinforHomeQ1 = "//192.168.0.3/XML_Audinfor/Home/Q1/";
//********************************************************************************************************************//

//*******Rutas Peajes Control*****************************************************************************************//
$PeajesControl = "//192.168.0.3/Datos/JUAN/Peajes_Control/descargasxml/";
//********************************************************************************************************************//

//*******Rutas Pirámide***********************************************************************************************//
$PiramideEnergy = "c:/Grupo Castilla/XML/";
$PiramideHome = "c:/Grupo Castilla/XML-HOME/";
//********************************************************************************************************************//

//*******Rutas ATOS***************************************************************************************************//
$ATOS = "temp/";
//********************************************************************************************************************//



if ($gestor = opendir('xml/')) {
    while (false !== ($entrada = readdir($gestor))) {
        if (substr($entrada, -4) == ".xml" or substr($entrada, -4) == ".XML") {
            $array[] = $entrada;
        }
    }
}
closedir($gestor);



ATOS();
//PEAJES();
//PIRAMIDE();
//AUDINFOR();
//if(ARCHIVAR($array) === 1) {
//    BORRAR($array);
//}



function ATOS() {
    global $array;
    global $ATOS;
    global $logs;

    $a = 1;
    $b = 1;
    

    for($i=0;$i<sizeof($array);$i++) {
        //echo ($i+1)." - Nombre fichero: ".$array[$i]."<br>";
        $fichero = simplexml_load_file("xml/".$array[$i]);
        echo ($i+1)." - ". $array[$i]." ----- ".$fichero->Cabecera->CodigoREEEmpresaDestino." ---- ".$fichero->Cabecera->CodigoDelProceso."<br>";
        $fecha = $fichero->Cabecera->FechaSolicitud;
        //echo $fecha."<br>";
        $ano = substr($fecha,0,4);
        //echo $ano."<br>";
        $mes = substr($fecha,5,2);
        //echo $mes."<br>";
        $dia = substr($fecha,8,2);
        //echo $dia."<br>";
        $carpeta = $ano."_".$mes."_".$dia."/";
        echo $carpeta."<br>";
        if(!file_exists("temp/Home/".$carpeta)){
            mkdir("temp/Home/".$carpeta, 0777, true);
            echo "temp/Home/".$carpeta;
        }
        copy ("xml/".$array[Si], "temp/Home/".$carpeta."/".$array[$i]);


        if ($fichero->Cabecera->CodigoREEEmpresaDestino == "0980") {
            copy ("xml/".$array[$i], "temp/Home/".$carpeta.$array[$i]);
            //$logs = "El fichero ".$array[$i]." ha sido copiado a ATOS HOME \n";
            //LOGS($logs);
            $a++;
        }
        /**
         * else if ($fichero->Cabecera->CodigoREEEmpresaDestino == "0815") {
            copy ("xml/".$array[$i], $ATOS."temp/Energy/".$carpeta.$array[$i]);
            //$logs = "El fichero ".$array[$i]." ha sido copiado a ATOS ENERGY \n";
            //LOGS($logs);
            $b++;
        }
         * */
    }

    echo "Se han copiado ".$a." archivos a la carpeta ATOS HOME <br>";
    echo "Se han copiado ".$b." archivos a la carpeta ATOS ENERGY<br>";

}

function PEAJES() {

    global $array;
    global $PeajesControl;
    global $logs;

    for($i=0; $i<sizeof($array); $i++) {
        copy ("xml/".$array[$i], $PeajesControl.$array[$i]);
        $logs = "El fichero ".$array[$i]." ha sido copiado a PEAJES \n";
        LOGS($logs);
    }
    echo "Se han copiado $i archivos a la carpeta PEAJES <br>";
}

function PIRAMIDE() {

    global $array;
    global $PiramideHome;
    global $PiramideEnergy;
    global $logs;

    $a = 0;
    $b = 0;

    for($i=0;$i<sizeof($array);$i++) {
        //echo ($i+1)." - Nombre fichero: ".$array[$i]."<br>";
        $fichero = simplexml_load_file("xml/".$array[$i]);

        if (($fichero->Cabecera->CodigoREEEmpresaDestino == "0980") && ($fichero->Cabecera->CodigoDelProceso == "F1")) {
            copy ("xml/".$array[$i], $PiramideHome.$array[$i]);
            $logs = "El fichero ".$array[$i]." ha sido copiado a PIRAMIDE HOME \n";
            LOGS($logs);
            $a = $a++;


        } else if (($fichero->Cabecera->CodigoREEEmpresaDestino == "0815") && ($fichero->Cabecera->CodigoDelProceso == "F1")) {
            copy ("xml/".$array[$i], $PiramideEnergy.$array[$i]);
            $logs = "El fichero ".$array[$i]." ha sido copiado a PIRAMIDE ENERGY \n";
            LOGS($logs);
            $b = $b++;
        }
    }
    echo "Se han copiado $a archivos a la carpeta PIRAMIDE HOME <br>";
    echo "Se han copiado $b archivos a la carpeta PIRAMIDE ENERGY<br>";
}

function AUDINFOR() {

    global $array;
    global $AudinforEnergyF1;
    global $AudinforEnergyQ1;
    global $AudinforHomeF1;
    global $AudinforHomeQ1;
    global $logs;
    $a = 0;
    $b = 0;
    $c = 0;
    $d = 0;

    for($i=0;$i<sizeof($array);$i++) {
        //echo ($i+1)." - Nombre fichero: ".$array[$i]."<br>";
        $fichero = simplexml_load_file("xml/".$array[$i]);

        if (($fichero->Cabecera->CodigoREEEmpresaDestino == "0980") && ($fichero->Cabecera->CodigoDelProceso == "F1")) {
            copy ("xml/".$array[$i], $AudinforHomeF1.$array[$i]);
            $logs = "El fichero ".$array[$i]." ha sido copiado a AUDINFOR HOME F1 \n";
            LOGS($logs);
            $a = $a++;

        } else if (($fichero->Cabecera->CodigoREEEmpresaDestino == "0980") && ($fichero->Cabecera->CodigoDelProceso == "Q1")) {
            copy ("xml/".$array[$i], $AudinforHomeQ1.$array[$i]);
            $logs = "El fichero ".$array[$i]." ha sido copiado a AUDINFOR HOME Q1\n";
            LOGS($logs);
            $b = $b++;
        } else if (($fichero->Cabecera->CodigoREEEmpresaDestino == "0815") && ($fichero->Cabecera->CodigoDelProceso == "F1")) {
            copy ("xml/".$array[$i], $AudinforEnergyF1.$array[$i]);
            $logs = "El fichero ".$array[$i]." ha sido copiado a AUDINFOR ENERGY F1 \n";
            LOGS($logs);
            $c = $c++;
        } else if (($fichero->Cabecera->CodigoREEEmpresaDestino == "0815") && ($fichero->Cabecera->CodigoDelProceso == "Q1")) {
            copy ("xml/".$array[$i], $AudinforEnergyQ1.$array[$i]);
            $logs = "El fichero ".$array[$i]." ha sido copiado a AUDINFOR ENERGY Q1\n";
            LOGS($logs);
            $d = $d++;
        }
    }
    echo "Se han copiado $a archivos a la carpeta AUDINFOR HOME F1<br>";
    echo "Se han copiado $b archivos a la carpeta AUDINFOR HOME Q1<br>";
    echo "Se han copiado $c archivos a la carpeta AUDINFOR ENERGY F1<br>";
    echo "Se han copiado $d archivos a la carpeta AUDINFOR ENERGY Q1<br>";
}

function LOGS($logs) {
    global $logs;
    global $historico;


    $FicheroLog = fopen("log/log-".date('Ymd-Hi').".txt", "a") or die("No se ha podido abrir el archivo");
    $historico = date("Ymd-Hi")." \n".$logs;
    fwrite($FicheroLog, $historico);
    fclose($FicheroLog);

}

function ARCHIVAR() {

    global $array;
    global $logs;
    global $creado;

    $zip = new ZipArchive();
    $filename = date('Ymd-Hi').".zip";

    if($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
        exit ("No se puede abrir el fichero ".$filename);
    }

    for($i=0;$i<sizeof($array);$i++) {
        $zip->addFile("xml/".$array[$i]);
        //echo ($i+1)." - Nombre fichero: ".$array[$i]."<br>";
    }

    if($zip->status != 0) {
        echo "Error en la creación del fichero";
    } else {
        echo "Fichero creado: ".date("Y-m-d_h-i-sa")."-".$filename;
        return $creado = 1;
    };
    $zip->close();

}

function BORRAR() {
    global $array;
    global $logs;

    for($i=0;$i<sizeof($array);$i++) {
        if(unlink("xml/".$array[$i])) {
            $logs = "El fichero ".$array[$i]." ha sido eliminado \n";
            LOGS($logs);
        };
    }
}

/*
function crearCarpeta($fecha) {
    GLOBAL $fecha;

    if(!file_exists($fecha)){
        mkdir($carpeta, 0777, true);
    }
}*/