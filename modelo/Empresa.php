<?php
include_once("conexion.php");

class Empresa{

     function listar(){
         $sql = "SELECT * FROM emisor  WHERE estado=1";
        global $cnx;
        $resultado = $cnx->query($sql);
        return $resultado;
    }

    function consultarEmpresa($idemisor){
        $sql = "SELECT * FROM emisor WHERE id=? ";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($idemisor));
        return $pre;
    }

    function actualizar($id, $tipo_doc,$numero_doc, $razon_social,$nombre_comercial,$correo,$telefono, $direccion, $otro){
        $sql = "UPDATE emisor 
                SET tipodoc=:tipo_doc, 
                    ruc=:numero_doc,
                    razon_social=:razon_social,
                    nombre_comercial=:nombre_comercial,
                    correo=:correo,
                    telefono=:telefono,
                    direccion=:direccion,
                    lema=:otro 
                WHERE id=:id";
        global $cnx;
        $parametros = array(
                        ":id"=>$id, 
                        ":tipo_doc"=>$tipo_doc,
                        ":numero_doc"=>$numero_doc,
                        ":razon_social"=>$razon_social,
                        ":nombre_comercial"=>$nombre_comercial,
                        ":correo"=>$correo, 
                        ":telefono"=>$telefono, 
                        ":direccion"=>$direccion, 
                        ":otro"=>$otro
                    );
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

}

?>