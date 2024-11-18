<?php
include_once("conexion.php");

class Producto{

    function listar($nombre, $estado,$problemaInventario=""){
        $sql = "SELECT * FROM producto WHERE estado<2 AND nombre LIKE :nombre ";
        $parametros = array(':nombre'=>$nombre);
        if($estado!=""){
            $sql.=" AND estado=:estado ";
            $parametros[':estado']=$estado;
        }
        if($problemaInventario==1){
            $sql.=" AND stock<stockseguridad ";
        }
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function consultarProducto($idproducto){
        $sql = "SELECT * FROM producto WHERE idproducto=? ";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($idproducto));
        return $pre;
    }

    function consultarProductoNombre($nombre,$codigbarra, $idproducto=0){
        $sql = "SELECT * FROM producto WHERE (nombre=? OR codigobarra=?) AND idproducto<>?";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($nombre,$codigbarra,$idproducto));
        return $pre;
    } 

    function insertar($producto){
        $sql = "INSERT INTO producto(idproducto, nombre, codigobarra, pventa, pcompra, stock, idunidad, idcategoria, idafectacion, afectoicbper, estado, stockseguridad) 
                VALUES (NULL,:nombre, :codigobarra, :pventa, :pcompra, :stock, :idunidad, :idcategoria, :idafectacion,:afectoicbper, :estado, :stockseguridad)";
        global $cnx;
        $parametros = array(
            ":nombre"        =>$producto['nombre'], 
            ":codigobarra"   =>$producto['codigobarra'], 
            ":pventa"        =>$producto['pventa'], 
            ":pcompra"       =>$producto['pcompra'],  
            ":stock"         =>$producto['stock'], 
            ":idunidad"      =>$producto['idunidad'], 
            ":idcategoria"   =>$producto['idcategoria'], 
            ":idafectacion"  =>$producto['idafectacion'], 
            ":afectoicbper"  =>$producto['afectoicbper'],
            ":estado"        =>$producto['estado'],
            ":stockseguridad"=>$producto['stockseguridad']
        );
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function actualizar($producto){
        $sql = "UPDATE producto 
                SET nombre=:nombre, 
                    codigobarra=:codigobarra, 
                    pventa=:pventa, 
                    pcompra=:pcompra, 
                    stock=:stock, 
                    idunidad=:idunidad, 
                    idcategoria=:idcategoria, 
                    idafectacion=:idafectacion, 
                    afectoicbper=:afectoicbper,
                    estado=:estado,
                    stockseguridad=:stockseguridad 
                WHERE idproducto=:idproducto";
        global $cnx;
        $parametros = array(
            ":idproducto"   =>$producto['idproducto'],
            ":nombre"        =>$producto['nombre'], 
            ":codigobarra"   =>$producto['codigobarra'], 
            ":pventa"        =>$producto['pventa'], 
            ":pcompra"       =>$producto['pcompra'],  
            ":stock"         =>$producto['stock'], 
            ":idunidad"      =>$producto['idunidad'], 
            ":idcategoria"   =>$producto['idcategoria'], 
            ":idafectacion"  =>$producto['idafectacion'], 
            ":afectoicbper"  =>$producto['afectoicbper'], 
            ":estado"        =>$producto['estado'],
            ":stockseguridad"=>$producto['stockseguridad']
        );
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function actualizarEstado($idproducto, $estado){
        $sql = "UPDATE producto SET estado=:estado WHERE idproducto=:idproducto";
        global $cnx;
        $parametros = array(":idproducto"=>$idproducto, ":estado"=>$estado);
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function actualizarUrlimagen($idproducto, $urlimagen){
        $sql = "UPDATE producto SET urlimagen=:urlimagen WHERE idproducto=:idproducto";
        global $cnx;
        $parametros = array(":idproducto"=>$idproducto, ":urlimagen"=>$urlimagen);
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function actualizarStock($idproducto, $cantidad){
        $sql = "UPDATE producto SET stock=stock+:cantidad WHERE idproducto=:idproducto";
        global $cnx;
        $parametros = array(":idproducto"=>$idproducto,":cantidad"=>$cantidad);
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;        
    }

    function actualizarStock_precio($idproducto, $pcompra, $cantidad){
        $sql = "UPDATE producto SET stock=stock+:cantidad, pcompra=:pcompra WHERE idproducto=:idproducto";
        global $cnx;
        $parametros = array(":idproducto"=>$idproducto,":pcompra"=>$pcompra,":cantidad"=>$cantidad);
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;        
    }

    function consultarById($idproducto)
    {
        $sql = "SELECT idproducto,nombre,pcompra,pventa,stockminimo,categoriaproducto_id,estado FROM producto WHERE idproducto = :idproducto";
        global $cnx;
        $parametros = array(":ididproducto"=>$idproducto);
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        //echo var_dump($datos);
        return $pre;
    }

    function consultarStockProductoById($idproducto)
    {
        $sql = "SELECT producto_id,fecha,tipo,cantidad,stockanterior,stockactual,estado FROM kardex WHERE producto_id = :idproducto ORDER BY producto_id DESC LIMIT 1";
        global $cnx;
        $parametros = array(":idproducto"=>$idproducto);
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        //echo var_dump($datos);
        return $pre;
    }
}

?>