<?php

header('Pragma: no-cache');
header('Cache-Control: no-store, no-cache, must-revalidate');

ini_set('max_execution_time',0);
ini_set('memory_limit', '811M');

require_once 'config/coneccion.php';

if(!session_start()){
    session_start();
}


$id_asociado=28398;


$columns=['id', 'fecha', 'idasociado', 'servicio', 'pesoguia_Generada', 'pesoReal', 'tracking'];
$sLimit = "LIMIT 0, 100";

if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ) {
    $sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".intval( $_GET['iDisplayLength'] );
}

/*-----------------------------------*/
/*-----------------------------------*/
/*validacion de filtrado por paqueteria*/



$numero_filas_post=0;
$data_session_DATA_TIPO_FILTRADO=[];
$name_table="vista_facturas_macro";
$name_paqueteria_session="FEDEX";


/*NOTA CUANDO CAMBIE DE PAQUETERIA SE ELIMINARA LAS FILAS SELECCIONADAS */



if( isset($_SESSION['DATA_TIPO_FILTRADO'])&& count($_SESSION['DATA_TIPO_FILTRADO'])>0 ){
    $numero_filas_post=count($_SESSION['DATA_TIPO_FILTRADO']);
    $data_session_DATA_TIPO_FILTRADO=$_SESSION['DATA_TIPO_FILTRADO'];



    $fecha_ini_POST=$_SESSION['DATA_TIPO_FILTRADO'][0]['FECHAS']['fecha_ini'];
    $fecha_fin_POST=$_SESSION['DATA_TIPO_FILTRADO'][0]['FECHAS']['fecha_fin'];
    $metodo_bsuqueda_POST=$_SESSION['DATA_TIPO_FILTRADO'][0]['METODO_BUSQUEDA'];
    $dias_consultar_POST=$_SESSION['DATA_TIPO_FILTRADO'][0]['DIAS_CONSULTAR'];
    $tracking_POST=$_SESSION['DATA_TIPO_FILTRADO'][0]['TRACKING'];

    if($_SESSION['DATA_TIPO_FILTRADO'][0]['NAME_PAQUETERIA']=='FEDEX'){
        $name_table="vista_facturas_macro";
        $name_paqueteria_session="FEDEX";
    }
    if($_SESSION['DATA_TIPO_FILTRADO'][0]['NAME_PAQUETERIA']=='DHL'){
        $name_table="vista_facturas_dhl";
        $name_paqueteria_session="DHL";
    }
    
    if($metodo_bsuqueda_POST=="fecha"){

        $CONSULTA =$conexion_BD_PDO->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM $name_table WHERE idasociado='$id_asociado' AND fecha BETWEEN '$fecha_ini_POST 00:00:00' AND '$fecha_fin_POST 23:59:59' ORDER BY id DESC  $sLimit");
    }

    if($metodo_bsuqueda_POST=="tracking"){
        //SELECT * FROM `historial` WHERE `idasociado`=33770 and tracking=780806382450
        $CONSULTA =  $conexion_BD_PDO->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM $name_table where idasociado='$id_asociado' AND tracking='$tracking_POST'");
    }

}
else{
    $CONSULTA = $conexion_BD_PDO->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM $name_table WHERE idasociado='$id_asociado' $sLimit");   
}

/*
echo  json_encode(['count'=>$numero_filas_post,'session'=>$data_session_DATA_TIPO_FILTRADO,'sql'=>$CONSULTA]); 
die();*/

/**----------------------- */
/**----------------------- */
/**fin da la validacion */


$CONSULTA->execute();
$data_HTML_ROW=[];
$contador=0;

while($output = $CONSULTA->fetch(PDO::FETCH_ASSOC)){

    $id=$output['id'];
    $data_HTML_ROW[$contador][0]="<input type='checkbox' value='0' class='form-control input_checked_selected_row_reclamo' data-id=".$id." data-paqueteria=".$name_paqueteria_session.">";
    $data_HTML_ROW[$contador][1]=$id;
    $data_HTML_ROW[$contador][2]=$output['fecha'];
    
    if($name_paqueteria_session=="DHL"){
        $data_HTML_ROW[$contador][3]='Servicio electronico';
    }else {
        # code...
        $data_HTML_ROW[$contador][3]=$output['servicio'];
    }
    $data_HTML_ROW[$contador][4]=$output['pesoguia_Generada'];
    $data_HTML_ROW[$contador][5]=$output['pesoReal'];
    $data_HTML_ROW[$contador][6]=$output['tracking'];
    //Dimensiones del producto;
    $data_HTML_ROW[$contador][7]="<input type='text' value='0' class='form-control row_input_peso'>";
    $data_HTML_ROW[$contador][8]="<input type='text' value='0' class='form-control row_input_ancho'>";
    $data_HTML_ROW[$contador][9]="<input type='text' value='0' class='form-control row_input_largo'>";
    $data_HTML_ROW[$contador][10]="<input type='text' value='0' class='form-control row_input_alto'>";

    $contador=$contador+1;
}

$iFilteredTotal = current($conexion_BD_PDO->query('SELECT FOUND_ROWS()')->fetch());


//checkear las seleccionadas X EL FRONT

$DATA2=[];
$DATA_SESSION=[];


if(isset($_SESSION['FILAS_SELECCIONADAS_RECLAMO_CBZ'])){

    $DATA_SESSION=$_SESSION['FILAS_SELECCIONADAS_RECLAMO_CBZ'];

    if(count($DATA_SESSION)>0){    
        foreach ($data_HTML_ROW as $index => $item) {
            # code...
            $id_primary_key=$item[1];
            foreach ($DATA_SESSION as $key => $item_session) {
                # code...
                if($id_primary_key==$item_session['id']){               
                
                $data_HTML_ROW[$index][0]="<input type='checkbox' class='form-control input_checked_selected_row_reclamo' data-id=".$id_primary_key." checked data-paqueteria=".$name_paqueteria_session.">";
                
                //Dimensiones del producto;
                $data_HTML_ROW[$index][7]= "<input type='text' value='".$item_session['row']['peso_new']."' class='form-control row_input_peso' disabled>";
                $data_HTML_ROW[$index][8]= "<input type='text' value='".$item_session['row']['largo__new']."' class='form-control row_input_largo' disabled>";
                $data_HTML_ROW[$index][9]=" <input type='text' value='".$item_session['row']['alto_new']."' class='form-control row_input_alto' disabled>";
                $data_HTML_ROW[$index][10]="<input type='text' value='".$item_session['row']['ancho_new']."' class='form-control row_input_ancho' disabled>";


                //guardo las filas que se estan chekeando
                $DATA2[]=$data_HTML_ROW[$index][0];
                break;
                }

            }
        }
    }

}


/*---------------desactivar filas--------------------*/
    $DATA_TABLE_reclamos_cbz_21_09_20=[];
    $data_claves=[];

    $CONSULTA_CBZ=$conexion_BD_PDO->prepare("SELECT * FROM `reclamos_cbz_21_09_20` where idasociado='$id_asociado' and paqueteria='$name_paqueteria_session'");
    

    if($CONSULTA_CBZ->execute()){
        while ($fila = $CONSULTA_CBZ->fetch()) {
        
            $rows_decode=json_decode($fila['data'],true);
            $DATA_TABLE_reclamos_cbz_21_09_20[]=$rows_decode;
            
            foreach ($rows_decode as $key => $item) {
                # code...
                $data_claves[]=['id'=>$item['id'],'tracking'=>$item['tracking']];
            }
        }    
    }
    
    
    if(count($data_claves)>0){
        foreach ($data_HTML_ROW as $index => $item) {
            # code...
            $id=$item[1];//id
            $tracking=$item[6];//tracking

            foreach ($data_claves as $key => $item_data) {
                # code...
                if($id==$item_data['id']){                         
                    //$data_row[$index]['checked_row']='checked';
                    $data_HTML_ROW[$index][0]="<input type='checkbox' class='form-control input_checked_selected_row_reclamo' data-id=".$id." data-paqueteria=".$name_paqueteria_session." checked disabled > ";

                    //Dimensiones del producto;
                    $data_HTML_ROW[$index][7]= "<input type='text' value='0' class='form-control row_input_peso' disabled>";
                    $data_HTML_ROW[$index][8]= "<input type='text' value='0' class='form-control row_input_ancho' disabled>";
                    $data_HTML_ROW[$index][9]=" <input type='text' value='0' class='form-control row_input_largo' disabled>";
                    $data_HTML_ROW[$index][10]="<input type='text' value='0' class='form-control row_input_alto' disabled>";
                    break;
                }
            }
        }
    }
    //echo  json_encode(['data'=>$DATA_TABLE_reclamos_cbz_21_09_20,'claves'=>$data_claves,'info'=>'obtener guias que ya estan seleccionadas tabla de cbz']); 
    //die();


/*---------------FIN desactivar filas--------------------*/





//Get total number of rows in table
$sQuery = "SELECT COUNT(`id`) FROM `vista_facturas_macro` WHERE idasociado='$id_asociado'";
$iTotal = current($conexion_BD_PDO->query($sQuery)->fetch());


$sEcho=0;
if(isset($_GET['sEcho'])){
    $sEcho=intval($_GET['sEcho']);
}
        
$output = array(
    "sEcho" =>$sEcho,
    "iTotalRecords" => $iTotal,
    "iTotalDisplayRecords" =>$iFilteredTotal,
    "data" => $data_HTML_ROW
    //',filas_selecionadas'=>$DATA2
);

echo  json_encode($output); 
die();


?>