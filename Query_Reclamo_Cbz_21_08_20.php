<?php



require_once('config/coneccion_mysqli.php');

$id_asociado=28398;
$nombre_cbz="armando";

if(isset($_POST['action']) &&$_POST['action']=="save_comentario_cbz"){

    //id de la fila abuscar
    $id_row=trim($_POST['id_row']);
    //comentario
    $comentario=trim($_POST['comentario']);
    $comentario_filtrado = preg_replace('([^A-Za-z0-9 ])', '', $comentario);
    $comentario_filtrado=ucwords($comentario_filtrado);
    //status
    $status=strtolower(trim($_POST['status']));


    $consulta = "SELECT * FROM reclamos_cbz_21_09_20 where id='$id_row' ORDER BY id DESC LIMIT 1";

    $data_row=[];
    $comentarios_db=[];

    if ($resultado = $mysqli->query($consulta)) {
             $fila = $resultado->fetch_assoc();

            //$fila['checked_row']='';
            if($fila['comentario_cbz']!=""){
                $comentarios_db=json_decode($fila['comentario_cbz'],true);
            }
            $data_row[]=$fila;
        
        $resultado->free();

        $fecha_actual=date('Y-m-d');

        $new_data=[
            "fecha"=>$fecha_actual,
            "id_usuario"=>$id_asociado,
            "nombre"=>$nombre_cbz,
            "comentario"=>$comentario_filtrado,
            "status"=>$status,
            'status_mensaje'=>'nuevo'
        ];

        //$comentarios_db[]=$new_data;
        array_push($comentarios_db,$new_data);
        $comentarios_db=json_encode($comentarios_db);

        //echo json_encode(['info'=>'select','data'=>$data_row,'status'=>200,'comentario_cbz'=>$comentarios_db]);
        //die();


    
        $query="UPDATE `reclamos_cbz_21_09_20` SET `comentario_cbz`='$comentarios_db',`status`='$status' WHERE id='$id_row'";
        if($mysqli->query($query)){    
            echo json_encode(['info'=>'update','status'=>200]);
        }else{
            echo json_encode(['info'=>'update','status'=>400]);
        }
        die();

       // echo json_encode(['info'=>'select','data'=>$data_row,'status'=>200,'comentario_cbz'=>$comentarios_db]);
    }else{
        echo json_encode(['info'=>'select','data'=>$data_row,'status'=>400]);
    }   

    
    die();
}


if(isset($_POST['action']) &&$_POST['action']=="read_guias_generadas"){
    

    /*echo json_encode(['info'=>$_POST]);
    die();
    */
    $ini= isset($_POST['fecha_desde'])?$_POST['fecha_desde']:"";
    $fin= isset($_POST['fecha_hasta'])?$_POST['fecha_hasta']:"";
    
    $paqueteria=$_POST['paqueteria'];
    $dias_consultar=trim($_POST['dias_consultar']);
    $status=trim($_POST['estatus']);



    $fecha_actual=date('Y-m-d');

    if($ini==""&&$fin!=""){
        $ini=$fin;$fin="";
    }

    if($fin==""&&$ini!=""){
        $fin=$fecha_actual;
    }

    if($ini>$fin){
        $temporal=$fin;
        $fin=$ini;
        $ini=$temporal;
    }

    if($ini==""&& $fin==""){
        $ini=$fecha_actual;
        $fin=$fecha_actual;

        /*
        $_POST['fecha_desde']=$fecha_actual;
        $_POST['fecha_hasta']=$fecha_actual;
        */
    }



    $consulta="";

        $tablas_AS_NAME=['FEDEX','DHL','ESTAFETA','REDPACK'];
    

        if($paqueteria=="all"){
           $TABLA_SELECCIONADA="";
            $Paqueterias_seleccionada="todas";
        }else{
            $Paqueterias_seleccionada=$tablas_AS_NAME[$paqueteria];
            $TABLA_SELECCIONADA='paqueteria="'.$tablas_AS_NAME[$paqueteria].'" AND';
        }
        
        $ESTATUS='';
        if($status!="all"){
           $ESTATUS='status="'.$status.'" AND';
        }

        if($dias_consultar!="fecha_personalizada")
        { 
            $dias_a_consultar=$dias_consultar;
            $ini = strtotime ( '-'.$dias_a_consultar.' day' , strtotime ( $fecha_actual ) ) ;
            $ini = date ( 'Y-m-j' , $ini );
            $fin=$fecha_actual;

            //echo json_encode(['fecha ini'=>$ini,'fecha hasta'=>$fin,'status'=>400]);
            //die();
        }
        
        $consulta = "SELECT * FROM reclamos_cbz_21_09_20 where $TABLA_SELECCIONADA  $ESTATUS fecha BETWEEN '$ini 00:00:00' AND '$fin 23:59:59' ORDER BY fecha DESC ";
              
        //$data_row=[];
        $data_row=[];

    if($consulta!=""){
        if ($resultado = $mysqli->query($consulta)) {
            while ($fila = $resultado->fetch_assoc()) {

                //$fila['checked_row']='';
                $data_row[]=$fila;
            }
            $resultado->free();


            echo json_encode([
                              'data'=>$data_row,
                              'status'=>200,
                              'paqueteria_selected'=>$Paqueterias_seleccionada,
                              //'data_reclamo'=>$DATA_TABLE_reclamos_cbz_21_09_20,
                              //'data_claves'=>$data_claves
                            ]);

            die();
        }   
    }else{
        echo json_encode(['data'=>$data_row,'status'=>400]);
        die();
    }

}


die();