<?php

require_once('config/coneccion.php');

/*status=['recibido','proceso','finalizado']*/

$idasociado=28398;


if(!session_start()){
    session_start();
}


if(isset($_POST['action']) &&$_POST['action']=="Update_status_mensaje"){

        //id de la fila abuscar
        $id_row=trim($_POST['id_row']);


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


            //$comentarios_db[]=$new_data;
            foreach ($comentarios_db as $key => $item) {
                # code...
                $comentarios_db[$key]['status_mensaje']='visto';
            }

            $comentarios_db=json_encode($comentarios_db);

            //echo json_encode(['info'=>'select','data'=>$data_row,'status'=>200,'comentario_cbz'=>$comentarios_db]);
            //die();

            $query="UPDATE `reclamos_cbz_21_09_20` SET `comentario_cbz`='$comentarios_db' WHERE id='$id_row'";
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


if(isset($_POST['action']) &&$_POST['action']=="all_reclamos"){


    $DATA_TABLE_reclamos_cbz_21_09_20=[];
    $QUERY_RECLAMOS_CBZ=$conexion_BD_PDO->prepare("SELECT * FROM `reclamos_cbz_21_09_20` where idasociado='$idasociado' ORDER BY id DESC");
    $QUERY_RECLAMOS_CBZ->execute();
    
    while($row = $QUERY_RECLAMOS_CBZ->fetch(PDO::FETCH_ASSOC)){

        $DATA_TABLE_reclamos_cbz_21_09_20[]=$row;
    }
    echo json_encode(['data'=>$DATA_TABLE_reclamos_cbz_21_09_20,'status'=>200]);
    die();
}


/* -----------------------READ SESSION----------Para pintar la tabla en el front de guias seleccionadas--------------------*/
if(isset($_POST['action'])&& $_POST['action']=='load'){
    $data=isset($_SESSION['FILAS_SELECCIONADAS_RECLAMO_CBZ'])?$_SESSION['FILAS_SELECCIONADAS_RECLAMO_CBZ']:[];
    echo json_encode(['data'=>$data,'status'=>200,'action'=>'load']);
    die();
}   

/* -----------------------SAVE DATA------------------------------*/

if(isset($_POST['action'])&& $_POST['action']=='save'){

   $data=isset($_SESSION['FILAS_SELECCIONADAS_RECLAMO_CBZ'])?$_SESSION['FILAS_SELECCIONADAS_RECLAMO_CBZ']:0;
   if($data>0){

       $DATA_JSON=json_encode($data);
   
       $name_paqueteria=isset($_SESSION['DATA_TIPO_FILTRADO'])?$_SESSION['DATA_TIPO_FILTRADO'][0]['NAME_PAQUETERIA']:'FEDEX';
       $comentario=trim($_POST['reclamo_text']);
       $comentario_filtrado = preg_replace('([^A-Za-z0-9 ])', '', $comentario);
       $status="recibido";
      

       $sentencia = $conexion_BD_PDO->prepare("INSERT INTO `reclamos_cbz_21_09_20`(`paqueteria`,`data`, `comentario`,`status`,`idasociado`) VALUES (?,?,?,?,?)");
       $sentencia->bindParam(1, $name_paqueteria, PDO::PARAM_STR); 
       $sentencia->bindParam(2, $DATA_JSON, PDO::PARAM_STR); 
       $sentencia->bindParam(3, $comentario_filtrado, PDO::PARAM_STR); 
       $sentencia->bindParam(4, $status, PDO::PARAM_STR); 
       $sentencia->bindParam(5, $idasociado, PDO::PARAM_STR); 
       $sentencia->execute();

       unset($_SESSION['FILAS_SELECCIONADAS_RECLAMO_CBZ']);
       echo json_encode(['data'=>$data,'status'=>200,'action'=>'save','info'=>'datos almacenados con exito']);
   }else{
       echo json_encode(['data'=>$data,'status'=>400,'action'=>'save','info'=>'no hay filas seleccionadas']);
   }
   
   die();

}


if(isset($_POST['action']) &&$_POST['action']=="read_guias_generadas"){
   

   $ini= isset($_POST['fecha_desde'])?$_POST['fecha_desde']:"";
   $fin= isset($_POST['fecha_hasta'])?$_POST['fecha_hasta']:"";


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

   }


   $paqueteria=$_POST['paqueteria'];
   $metodo_search=$_POST['metodo_busqueda'];
   $tracking=trim($_POST['valor_metodo_busqueda']);
   $dias_consultar=trim($_POST['dias_consultar']);

   $tablas_AS_NAME=['FEDEX','DHL'];
   


   if($dias_consultar!="fecha_personalizada"){
       $dias_a_consultar=$dias_consultar;
       $nuevafecha = strtotime ( '-'.$dias_a_consultar.' day' , strtotime ( $fecha_actual ) ) ;
       $ini = date ( 'Y-m-j' , $nuevafecha );
       $fin=$fecha_actual;
   }
   
   $data=[
       'METODO_BUSQUEDA'=>$metodo_search,
       'NAME_PAQUETERIA'=>$tablas_AS_NAME[$paqueteria],
       'FECHAS'=>array('fecha_ini'=>$ini,'fecha_fin'=>$fin),
       'TRACKING'=>$tracking,
       'DIAS_CONSULTAR'=>$dias_consultar
   ];


   $DATA_SESSION=[];
   $rows_count=0;
   if(isset($_SESSION['FILAS_SELECCIONADAS_RECLAMO_CBZ'])){

       $DATA_SESSION=$_SESSION['FILAS_SELECCIONADAS_RECLAMO_CBZ'];
       $name_paqueteria_session=$tablas_AS_NAME[$paqueteria];

       foreach ($DATA_SESSION as $key => $item) {
           # code...
           if($item['paqueteria']!=$name_paqueteria_session){
                unset($_SESSION['FILAS_SELECCIONADAS_RECLAMO_CBZ']);
                break;
           }
       }

       $rows_count=isset($_SESSION['FILAS_SELECCIONADAS_RECLAMO_CBZ'])?count($_SESSION['FILAS_SELECCIONADAS_RECLAMO_CBZ']):0;
       $DATA_SESSION=isset($_SESSION['FILAS_SELECCIONADAS_RECLAMO_CBZ'])?$_SESSION['FILAS_SELECCIONADAS_RECLAMO_CBZ']:[];
   }
   
   $_SESSION['DATA_TIPO_FILTRADO'][0]=$data;

   echo json_encode(['session_data_filtrado'=>$_SESSION['DATA_TIPO_FILTRADO'],'status'=>200,'count_rows'=>$rows_count,'rows_seleccionadas'=>$DATA_SESSION]);
   die();
}


/* -----------------------AGREGAR O ELIMINAR FILA------------------------------*/

$status_create=false;
$contador_filas=0;

$action=$_POST['action_row'];
if(isset($_SESSION['FILAS_SELECCIONADAS_RECLAMO_CBZ'])){
   
   if($action=="add"){    
       if(count($_SESSION['FILAS_SELECCIONADAS_RECLAMO_CBZ'])==5){
           echo json_encode(['new'=>$status_create,'rows'=>$contador_filas,'limit'=>true,'max'=>'20']);
           die();
       }
   }
}

$SEARCH_ROW=false;
$INDEX_ROW=NULL;


$ID_POST=      intval($_POST['id']);
$fecha=        trim($_POST['fecha']);
$servicio=     trim($_POST['servicio']);
$pesoguia_Generada=trim($_POST['pesoguia_Generada']);
$pesoReal=     trim($_POST['pesoReal']);
$tracking=     trim($_POST['tracking']);
//dimensiones
$peso_new=   floatval($_POST['peso_new']);
$alto_new=   floatval($_POST['alto_new']);
$ancho_new=  floatval($_POST['ancho_new']);
$largo_new= floatval($_POST['largo_new']);
$paqueteria_selected= trim($_POST['paqueteria']);

if(isset($_SESSION['FILAS_SELECCIONADAS_RECLAMO_CBZ'])){
   if($action=="remove"){
       foreach ($_SESSION['FILAS_SELECCIONADAS_RECLAMO_CBZ'] as $key => $item) {
           # code...
           if($item['id']==$ID_POST){
               unset($_SESSION['FILAS_SELECCIONADAS_RECLAMO_CBZ'][$key]);
               $SEARCH_ROW=true;
           }
       }
   }
}

if($SEARCH_ROW==false){
   $_SESSION['FILAS_SELECCIONADAS_RECLAMO_CBZ'][]=[
                                                   'id'=>$ID_POST,'fecha'=>$fecha,'servicio'=>$servicio,
                                                   'pesoguia_Generada'=>$pesoguia_Generada,'pesoReal'=>$pesoReal,'tracking'=>$tracking
                                                   ,'row'=>array('peso_new'=>$peso_new,'alto_new'=>$alto_new,'ancho_new'=>$ancho_new,'largo__new'=>$largo_new)
                                                   ,'paqueteria'=>$paqueteria_selected
                                                   ];

   $status_create=true;
}

$new_numero_rows=count($_SESSION['FILAS_SELECCIONADAS_RECLAMO_CBZ']);
echo json_encode(['new'=>$status_create,'rows'=>$new_numero_rows,'seleccionadas'=>$_SESSION['FILAS_SELECCIONADAS_RECLAMO_CBZ'],'action'=>$action ]);

die();




?>