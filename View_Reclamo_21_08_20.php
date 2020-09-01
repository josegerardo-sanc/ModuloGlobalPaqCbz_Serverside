
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


<!--DataTable !-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap.min.css">



<style>
 
 .selected_row_globalpaq{
     background-color: #eff7f6;
     color: #3a506b;
 }

</style>

</head>
<body>
    
<?php

if(!session_start()){
    session_start();
}

//print_r($_SESSION['DATA_TIPO_FILTRADO']);
$data_session_filtrado=isset($_SESSION['DATA_TIPO_FILTRADO'])?$_SESSION['DATA_TIPO_FILTRADO'][0]:null;

?>

  <div class="container">
      <ul class="nav nav-tabs" style="margin-top:150px;">
        <li class="active"><a data-toggle="tab" href="#home">Nuevo reclamo</a></li>
        <li><a data-toggle="tab" href="#menu1">Reclamos enviados</a></li>
      </ul>
     <div class="tab-content">
         <div id="home" class="tab-pane fade in active">
              <div class="row">
                    <div class="form-group col-sm-3">
                        <label for="" class="col-form-label">Paqueterías</label>
                        <select name="" id="PAQUETERIA" class="form-control">
                            <option value="10" selected disabled>Selecciona una opción</option>
                            <option value="0" selected>FEDEX</option>
                            <option value="1">DHL</option>
                        </select>
                        <small id="PAQUETERIA_TEXT"></small>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="" class="col-form-label">Método de búsqueda</label>
                        <select name="" id="METODO_SEARCH" class="form-control">
                            <option value="fecha" selected>Fecha</option>
                            <option value="tracking" >Tracking</option>
                        </select>
                    </div>

                    <!--
                        section de fechas
                    -!-->

                    <div class="form-group col-sm-3" id="CONTE_DIAS_CONSULTAR">
                        <label for="" class="col-form-label">Días a consultar</label>
                        <select name="" id="BUSQUEDA_ENTRE_FECHAS" class="form-control">
                            <option value="5" selected>5</option>
                            <option value="15" >15</option>
                            <option value="30" >30</option>
                            <option value="60" >60</option>
                            <option value="120" >120</option>
                            <option value="fecha_personalizada">Fecha Personalizada</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-4 row" id="CONTE_FECHAS_PERSONALIZADAS" style="display:none">
                            <div class="col-sm-6">
                            <label for=""  class="col-form-label">Fecha Desde</label>
                            <input type="date" class="form-control" id="FECHA_DESDE" value="<?php echo date("Y-m-d");?>" >
                            </div>
                            <div class="col-sm-6">
                            <label for=""  class="col-form-label">Hasta</label>
                            <input type="date" class="form-control" id="FECHA_HASTA">
                            </div>
                    </div>
                    <!--
                        section de fechas
                    -!-->
                    <div class="form-group col-sm-3" style="display:none" id="COONTE_VALOR_METODO_BUSQUEDA">
                        <label for="" class="col-form-label">Ingresa el valor</label>
                        <input type="text" class="form-control" id="VALOR_METODO_BUSQUEDA">
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="" class="col-form-label" style="display:block; opacity:0;">"Buscar"</label>
                        <button class="btn btn-sm btn-primary" id="BTN_REQUEST_DATA_PAQUETERIA">
                            Buscar
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
            </div>
            <div class="row">
                
                <!--col!-->
                    <div class="col-sm-12" style="display:none" id="conte_mensaje">
                        <div class="alert alert-success alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Agradecemos su preferencía</strong> Daremos solución a lo ocurrido
                    </div>
                    </div>
                <!--col!-->
                    <div class="col-sm-12">
                    
                        <table id="PAQUETERIA_TABLE" class="table table-striped table-bordered " style="width:100%">
                            <thead class="text-center">
                                <tr>
                                    <th></th>
                                    <th>Folio</th>
                                    <th>Fecha</th>       
                                    <th>Servicio</th>  
                                    <th>Peso Generada</th>
                                    <th>Peso Real</th>
                                    <th>Tracking</th>
                                    <th>Peso</th>  
                                    <th>Largo</th>
                                    <th>Alto</th>
                                    <th>Ancho</th>
                                </tr>
                            </thead>
                        </table>   
                    </div>
                    <!--col!-->

                    <!--col!-->
                    

                    <!--conte reclamo!-->
                    <div class="row col-sm-12" style="margin-top:30px;">
                                <fieldset>
                                    <legend>Queja:</legend>
                                    <div>
                                        <textarea name=""  cols="10" rows="10" class="form-control mb-3" id="TEXT_INCONFORMIDAD" placeholder=""></textarea>
                                        <span id="text_error_queja" class="help-block" style="color:red; display:none">Debes escribir tu queja</span>
                                    </div>
                                    
                                </fieldset>
                                <button class="btn btn-primary" id="BNT_PROCESAR_RECLAMO" style="margin-top:30px;">Procesar Reclamos</button>
                            </div>

                            <!--fin del conte!-->
                    <!--col!-->
            </div> 

            <!--fin del conte!-->
                </div>
            <div id="menu1" class="tab-pane fade">
                    <table id="reclamosEnviados" class="table table-bordered table-responsive" style="width:100%">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Fecha</th>
                                <th>Paquetería</th>
                                <th>Guías enviadas</th>
                                <th>Ver comentario</th>
                                <th>status</th>
                            </tr>
                        </thead>
                        <tbody id="reclamosEnviados_tbody">

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Folio</th>
                                <th>Fecha</th>
                                <th>Paquetería</th>
                                <th>Guías enviadas</th>
                                <th>Ver comentario</th>
                                <th>status</th>
                            </tr>
                        </tfoot>
                    </table>
            </div>
     </div>

     <!--col!--->
     <div class="col-sm-12">
                <!-- Modal -->
                <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Guías envíadas</h4>
                            </div>
                            <div class="modal-body">
                            
                            <table id="reclamos_ver_table" class="table table-bordered table-responsive" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Tracking</th>
                                            <th>Peso</th>
                                            <th>Largo</th>
                                            <th>Ancho</th>
                                            <th>Alto</th>
                                        </tr>
                                    </thead>
                                    <tbody id="reclamos_ver_table_Tbody">

                                    </tbody>
                                </table>

                            </div>
                            
                        </div>

                    </div>
                </div>
        </div>
     <!--col!--->
      <div class="col-sm-12">
                    <!-- Modal -->
                    <div id="Ver_comentario_modal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Comentaríos</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group" id="add_comentario" style="height:300px; overflow-y: auto;">
                                        <!--agregar comentarios-!-->
                                    </div>
                                 </div>
                            </div>

                        </div>
                    </div>
     </div>



 </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!--boostrap !-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js" integrity="sha512-hQeArtKSBTJ1segRjyRoDh409td70Loy62usBB3+Ox5Z1akisBzCoZWpU9+Q/N5GBbgUJ6Xo1fcdFgDDIRzLxA==" crossorigin="anonymous"></script>
    
    
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap.min.js"></script>


<script>
        $(document).ready(function(){

            var text_inconformidad_placeholder="Escriba: protesta, censura, descontento e inconformidad por la insatisfacción que le causó la prestación del servicio";
            $('#TEXT_INCONFORMIDAD').attr('placeholder',text_inconformidad_placeholder);

            var filtro_php=<?php echo json_encode($data_session_filtrado) ?>;
            if(filtro_php!=null){

                //console.log(filtro_php);
                
                var name_paqueteria="";
                if(filtro_php.NAME_PAQUETERIA=='FEDEX'){
                    name_paqueteria=0;
                }
                
                if(filtro_php.NAME_PAQUETERIA=='DHL'){
                    name_paqueteria=1;
                }
                
                $('#PAQUETERIA').val(name_paqueteria);
                $('#METODO_SEARCH').val(filtro_php.METODO_BUSQUEDA)
                $('#BUSQUEDA_ENTRE_FECHAS').val(filtro_php.DIAS_CONSULTAR);

                if(filtro_php.DIAS_CONSULTAR=="fecha_personalizada"){
                    $('#CONTE_FECHAS_PERSONALIZADAS').show();
                }else{
                    $('#CONTE_FECHAS_PERSONALIZADAS').hide();
                }
            }

            //FILTRADOS
            $(document).on('change','#METODO_SEARCH',function(){
                /*CONTENEDORES DE FECHAS*/
                $('#CONTE_FECHAS_PERSONALIZADAS').hide();
                $('#CONTE_DIAS_CONSULTAR').hide();
                /*Metodos de busqueda*/
                $('#COONTE_VALOR_METODO_BUSQUEDA').hide();


                var metodo_search=$(this).val();
                if(metodo_search=="tracking"){
                    $('#COONTE_VALOR_METODO_BUSQUEDA').show();
                }
                if(metodo_search=="fecha"){
                    $('#CONTE_DIAS_CONSULTAR').show();
                    //inicializar en el primer select
                    $('#BUSQUEDA_ENTRE_FECHAS').prop("selectedIndex", 0);
                }
            });

            $(document).on('change','#BUSQUEDA_ENTRE_FECHAS',function(){
                var data_select_BUSQUEDA_ENTRE_FECHAS=$(this).val();
                if(data_select_BUSQUEDA_ENTRE_FECHAS=="fecha_personalizada"){
                    $('#CONTE_FECHAS_PERSONALIZADAS').show();
                }else{
                    $('#CONTE_FECHAS_PERSONALIZADAS').hide();
                }
            });

    
          $("#PAQUETERIA_TABLE").DataTable();
          $("#TABLE_GUIAS_SELECCIONADAS").DataTable();
    
            function CargaPaqueteria_seleccionada() {

                $('#PAQUETERIA_TABLE').DataTable().clear().destroy();

                    PAQUETERIA_TABLE=$("#PAQUETERIA_TABLE").DataTable({
                        "destroy":true,
                        "processing": true,
                        "serverSide": true,
                        "sAjaxSource": "./ServerSide_paqueterias.php",
                        "columnDefs":[{
                            "data":null
                        }],
                            "language": {
                            "processing": '<div style="color:#E96616;">Cargando............  <i class="fa fa-spinner fa-spin fa-2x fa-fw"></i></div>'
                        },  
                    });
            }


        /*$.ajax({
                    url :'ServerSide/ServerSide_paqueterias.php',
                    type: 'POST',
                    data:{},
                success: function(data){
                        var json=JSON.parse(data);
                        console.log(json);
                    },
                    error: function (request, status, error) {

                        //$('#BTN_REQUEST_DATA_PAQUETERIA').css('opacity','1');
                        console.log(request.responseText);
                    }
            });*/
           



        COUNT_ROW_SELECTED_USER=0;
        FILAS_SELECCIONDAS=[];



        $(document).on('click','.input_checked_selected_row_reclamo',function(){
                ID_HISTORIAL=$(this).data('id');
            
                paqueteria=$(this).data('paqueteria');
                //console.log(ID_HISTORIAL)

                
                var row_input_peso=$(this).parents('tr').find('input.row_input_peso');
                var row_input_ancho=$(this).parents('tr').find('input.row_input_ancho');
                var row_input_largo=$(this).parents('tr').find('input.row_input_largo');
                var row_input_alto=$(this).parents('tr').find('input.row_input_alto');

                var fecha=$(this).parents('tr').find('td:eq(2)').text();
                var servicio=$(this).parents('tr').find('td:eq(3)').text();
                var pesoguia_Generada=$(this).parents('tr').find('td:eq(4)').text();
                var pesoReal=$(this).parents('tr').find('td:eq(5)').text();
                var tracking=$(this).parents('tr').find('td:eq(6)').text();

                    
                var OBJECTO_=
                {
                    'id':ID_HISTORIAL,
                    'fecha':fecha,
                    'servicio':servicio,
                    'pesoguia_Generada': pesoguia_Generada,
                    'pesoReal':pesoReal,
                    'tracking':tracking,
                    'peso_new':row_input_peso.val(),
                    'alto_new':row_input_alto.val(),
                    'ancho_new':row_input_ancho.val(),
                    'largo_new':row_input_largo.val(),
                    'paqueteria':paqueteria,
                    'action_row':''

                };

                if($(this).is(':checked')){
                    if(COUNT_ROW_SELECTED_USER>=5){
                            alert("solo se permiten seleccionar maximo :20");
                            return false;
                        }

                        row_input_peso.attr('disabled','disabled');
                        row_input_ancho.attr('disabled','disabled');
                        row_input_largo.attr('disabled','disabled');
                        row_input_alto.attr('disabled','disabled');

                        OBJECTO_.action_row='add';
                        $(this).parents('tr').addClass('success');
                        Create_update_Object(OBJECTO_);
                    }
                else{
                    
                    $(this).parents('tr').removeClass('success');
                    //console.log(OBJECTO_);
                    //return false;
                    row_input_peso.removeAttr('disabled');
                    row_input_ancho.removeAttr('disabled');
                    row_input_largo.removeAttr('disabled');
                    row_input_alto.removeAttr('disabled');
                    OBJECTO_.action_row='remove';
                    Create_update_Object(OBJECTO_);
                }
                    
        });

        function Create_update_Object(OBJECTO_){

            FILAS_SELECCIONDAS=[];
            $.ajax({
                    url :'./Query_Reclamo_21_08_20.php',
                    type: 'POST',
                    data:OBJECTO_,
                success: function(data){
                        var json=JSON.parse(data);
                        //console.log(json);
                        COUNT_ROW_SELECTED_USER=json.rows;
                        FILAS_SELECCIONDAS.push(json.seleccionadas);

                       // console.log(FILAS_SELECCIONDAS);
                    },
                    error: function (request, status, error) {

                        //$('#BTN_REQUEST_DATA_PAQUETERIA').css('opacity','1');
                        console.log(request.responseText);
                    }
            });

        }


        $('#BNT_PROCESAR_RECLAMO').click( function () {

            //console.log(NEW_OBJECT_ROW.data);
            if(FILAS_SELECCIONDAS.length==0||COUNT_ROW_SELECTED_USER==0){
                alert("Aun no has seleccionado ninguna fila");
                return false;
            }

            var reclamo=$('#TEXT_INCONFORMIDAD').val();
            $('#text_error_queja').html('').hide();


            if(reclamo==""){
                $('#TEXT_INCONFORMIDAD').focus();
                $('#text_error_queja').html('<p class="" style="color:red">'+text_inconformidad_placeholder+'</p>').show();
                return false;
            }
            if(reclamo.length<10){
                $('#TEXT_INCONFORMIDAD').focus();
                $('#text_error_queja').html('<p class="" style="color:red">Mínimo son 30 caracteres</p>').show();
                
                alert("modificar esta linea, colocar el minimos de caracteres");
                return false;

            }

            var NEW_OBJECT_ROW={
                'reclamo_text':reclamo,
                'action':'save'
            };
            
            //console.log(NEW_OBJECT_ROW);
            

            $.ajax({
                //url :'sections/Query_Reclamo_21_08_20.php',
                url :'./Query_Reclamo_21_08_20.php',
                type: 'POST',
                data:NEW_OBJECT_ROW,
                beforeSend: function(){
                
                    
                    $('#BNT_PROCESAR_RECLAMO').attr('disabled','disabled');
                    $('#BNT_PROCESAR_RECLAMO').html('Cargando.......  <i class="fas fa-spinner fa-spin "></i>')
                    .removeClass('btn-primary')
                    .addClass('btn-info')
                    
                },
            success: function(data){
            
                    setTimeout(() => {
                        $('#BNT_PROCESAR_RECLAMO').removeAttr('disabled');
                        $('#BNT_PROCESAR_RECLAMO').html(' Procesar Reclamos ')
                        .removeClass('btn-info')
                        .addClass('btn-primary');
                    },1000);

                    var json=JSON.parse(data);
                    //console.log(json);
                
                    if(json.status==200){
                        $('#conte_mensaje').show();
                        $('#TEXT_INCONFORMIDAD').val('');
                       //console.log(`info: ${json.info} action: ${json.action}`);   
                        COUNT_ROW_SELECTED_USER=0;
                        FILAS_SELECCIONDAS=[];
                        //PAQUETERIA_TABLE.ajax.reload(null, false);
                        Get_All_Reclamos();
                        CargaPaqueteria_seleccionada();
                    }
                    if(json.status==400){
                        console.log(`info: ${json.info} action: ${json.action}`);
                    }
                        
                },
                error: function (request, status, error) {
                    COUNT_ROW_SELECTED_USER=0;
                    $('.input_checked_selected_row_reclamo').each(function(index) {
                        if($(this).is(':checked')){
                            $(this).parents('tr').removeClass('success');
                            $(this).prop('checked', false);
                        }
                    });
                    console.log(request.responseText);
                
                }
            });

            
        } );


        /*Buscar x paqueteria*/

        $(document).on('click','#BTN_REQUEST_DATA_PAQUETERIA',function(){
                
                /*inicializar*/
                FILAS_SELECCIONDAS=[];
                var PAQUETERIA=$('#PAQUETERIA').val();

                $('#PAQUETERIA_TEXT').hide();
                if(PAQUETERIA==null){
                    $('#PAQUETERIA_TEXT').html('Seleccione una paquetería').addClass('text-danger').show();
                    return false;
                }
            
                var BUSQUEDA_ENTRE_FECHAS=$('#BUSQUEDA_ENTRE_FECHAS').val();
                var FECHA_DESDE=$('#FECHA_DESDE').val();
                var FECHA_HASTA=$('#FECHA_HASTA').val();
                var METODO_SEARCH=$('#METODO_SEARCH').val();
                var VALOR_METODO_BUSQUEDA=$('#VALOR_METODO_BUSQUEDA').val();

                
                var OBJ_DATA={
                    'paqueteria':PAQUETERIA,
                    'metodo_busqueda':METODO_SEARCH,
                    'dias_consultar':BUSQUEDA_ENTRE_FECHAS,
                    'fecha_desde':FECHA_DESDE,
                    'fecha_hasta':FECHA_HASTA,
                    'valor_metodo_busqueda':VALOR_METODO_BUSQUEDA,
                    'action':'read_guias_generadas'
                };
                //console.log(OBJ_DATA);
                
                $.ajax({

                    //url :'sections/Query_Reclamo_21_08_20.php',

                    url :'./Query_Reclamo_21_08_20.php',
                    type: 'POST',
                    data:OBJ_DATA,
                    beforeSend: function(){
                        
                        $('#BTN_REQUEST_DATA_PAQUETERIA').attr('disabled','disabled');
                        $('#BTN_REQUEST_DATA_PAQUETERIA').html('Cargando.......  <i class="fas fa-spinner fa-spin "></i>')
                        .removeClass('btn-primary')
                        .addClass('btn-danger')
                        
                    },
                success: function(data){
                    var json=JSON.parse(data);
                    //console.log(json);
                    COUNT_ROW_SELECTED_USER=json.count_rows;
                        FILAS_SELECCIONDAS.push(json.rows_seleccionadas);

                    //PAQUETERIA_TABLE.ajax.reload(null, false);
                    CargaPaqueteria_seleccionada();

                    setTimeout(() => {
                        
                        $('#BTN_REQUEST_DATA_PAQUETERIA').removeAttr('disabled');

                        $('#BTN_REQUEST_DATA_PAQUETERIA').html('Buscar  <i class="fas fa-search"></i>')
                        .removeClass('btn-info')
                        .addClass('btn-primary');

                        },1000);
                    },
                    error: function (request, status, error) {

                        $('#BTN_REQUEST_DATA_PAQUETERIA').css('opacity','1');
                        console.log(request.responseText);
                    
                    }
                });


        });

        
        /*carga de filas selecionadas para pintar la tabla*/

        function Load_select_row_user(){
            FILAS_SELECCIONDAS=[];
            $.ajax({
            url :'./Query_Reclamo_21_08_20.php',
            type: 'POST',
            data:{'action':'load'},
            success: function(data){
                    var json=JSON.parse(data);
                    //console.log(json);
                    COUNT_ROW_SELECTED_USER=json.data.length;
                    FILAS_SELECCIONDAS.push(json.data);
                },
                error: function (request, status, error) {
                    console.log(request.responseText);
                
                }
            });
        }
        Load_select_row_user();




    /*Modulo de ver reclamos*/
    /*Modulo de ver reclamos*/
    /*Modulo de ver reclamos*/
    $('#reclamosEnviados').DataTable();

    let arregloReclamos=[];

    $(document).on('click','.ver_mas_guias_enviadas',function(){

         $('#myModal').modal('show');

         var id=$(this).parents('tr').data('id');

         var tr="";
        for (const item of arregloReclamos) {
          
          if(id==item.id){
             var rows=JSON.parse(item.data);
              //console.log(rows);
              for (const item2 of rows) {

                  tr+=`
                  <tr>
                      <td>${item2.tracking}</td>
                      <td><span class="label label-primary"> ${item2.row.peso_new}</span></td>
                      <td><span class="label label-primary">${item2.row.largo__new}</span></td>
                      <td><span class="label label-primary">${item2.row.ancho_new}</span></td>
                      <td><span class="label label-primary">${item2.row.alto_new} </span</td>
                  </tr>`;    
              }
          }
      }

        //console.log(arregloReclamos);
        $('#reclamos_ver_table').DataTable().clear().destroy();
        $('#reclamos_ver_table_Tbody').html(tr);
        $('#reclamos_ver_table').DataTable();



    });

    $(document).on('click','.VER_COMENTARIO',function(){
        $('#BTN_SEND_COMENT_CBZ').show();
        $('#COMENT_CBZ_TEXTAREA').show();

        var id=$(this).parents('tr').data('id');
        var status=$(this).parents('tr').data('status');
        

        $('#id_row_table').val(id);
        $('#id_row_table_new_status').val(status);

        SHOW_COMENT(id);
        var contador_tr_mensajes=$(this).parents('tr').data('contador');
        var this_fila=this;
    
        if(contador_tr_mensajes>0){         
           Update_status_mensaje(id,this_fila);
        }

        $('#Ver_comentario_modal').modal('show');
        

    });


    function SHOW_COMENT(id){
        var comentarios="";
        for (const item of arregloReclamos) {
        if(id==item.id){


            if(item.status=="recibido"){
                    color_background="label-danger";
            }
            if(item.status=="proceso"){
                color_background="label-warning";
            }
            if(item.status=="finalizado"){
                color_background="label-success";
            }

            comentarios=`<div class="form-group">
                <strong style="display:block">Fecha ${item.fecha} <small class="label ${color_background}">${item.status}</small></strong>
                    <p>
                        <strong style="color:#19A74D">Asociado: ${item.idasociado}</strong>
                        ${item.comentario}
                    </p>
                </div>`;


            if(item.comentario_cbz!=null&&item.comentario_cbz!=""){
                //console.log(JSON.parse(item.comentario_cbz));
                datos=JSON.parse(item.comentario_cbz);

                //generar comentarios
                for (const iterator of datos) {

                    if(iterator.status=="recibido"){
                    color_background="label-danger";
                    }
                    if(iterator.status=="proceso"){
                        color_background="label-warning";
                    }
                    if(iterator.status=="finalizado"){
                        color_background="label-success";
                    }

                    comentarios+=`<div class="form-group">
                    <strong style="display:block">Fecha ${iterator.fecha} <small class="label ${color_background}">${iterator.status}</small></strong>
                            <p>
                                <strong>${iterator.nombre}</strong>
                                ${iterator.comentario}
                            </p>
                        </div>`;
                }
                //generar comentarios
            }else{
                comentarios+=`<div class="form-group">
                                <strong>Ningún comentarío</strong>
                        </div>`;
            }
        }
        }

        $('#add_comentario').html(comentarios);

    }


    function Get_All_Reclamos(){
        $.ajax({
                //url :'sections/Query_Reclamo_21_08_20.php',

                url :'./Query_Reclamo_21_08_20.php',
                type: 'POST',
                data:{'action':'all_reclamos'},
                beforeSend: function(){
                    /*
                    $('#BNT_PROCESAR_RECLAMO').attr('disabled','disabled');
                    $('#BNT_PROCESAR_RECLAMO').html('Cargando.......  <i class="fas fa-spinner fa-spin "></i>')
                    .removeClass('btn-primary')
                    .addClass('btn-info');
                    */  
                },
            success: function(data){
                    arregloReclamos=[];

                    var json=JSON.parse(data);
                    //console.log(json);
                
                    var tr="";

                    if(json.status==200){
                        for (const item of json.data) {

                            arregloReclamos.push(item);
                            var disabled="";
                            if(item.checked_row=="checked"){
                                disabled="disabled";
                            }

                            //console.log(JSON.parse(item.data));

                            Numero_guias_enviadas=JSON.parse(item.data);
                            Numero_guias_enviadas=Object.keys(Numero_guias_enviadas).length;
                            
                            
                            var color_background="";
                           


                            
                            comentario=`<a href="#" class="VER_COMENTARIO">${item.comentario.substr(0,30)}</a>`;
                            

                            if(item.status=="recibido"){
                                color_background="label-danger";
                            }
                            if(item.status=="proceso"){
                                color_background="label-warning";
                            }
                            if(item.status=="finalizado"){
                                color_background="label-success";
                            }

                            var html_status_mensaje="";
                            if(item.comentario_cbz!=null&&item.comentario_cbz!=""){

                                 var data_json_mensajes=JSON.parse(item.comentario_cbz);
                                 var contador_mensaje=0;
                                 
                                 for (const item_data of data_json_mensajes) {
                                       console.log(item_data);
                                       if(item_data.status_mensaje=="nuevo"){
                                          contador_mensaje=contador_mensaje+1;
                                       }
                                 }
                                 if(contador_mensaje>0){
                                    html_status_mensaje=`<i class="fas fa-bell"></i><span class="badge" style="background-color:white;color:black;margin-left:5px;">Mensaje ${contador_mensaje}</span>`;
                                 }

                            }


                            //console.log(Numero_guias_enviadas);

                            tr+=`
                            <tr data-id="${item.id}" data-contador="${contador_mensaje}">
                                <td>${item.id}</td>
                                <td>${item.fecha}</td>
                                <td>${item.paqueteria}</td>
                                <td><a href="#" class="ver_mas_guias_enviadas">ver más ${Numero_guias_enviadas}</a></td>
                                <td>                           
                                    <button class="btn btn-sm VER_COMENTARIO" type="button" style="background-color:#F9A73F;color:black;">
                                        Ver comentaríos ${html_status_mensaje}
                                    </button>
                                </td>
                                <td><span class="label ${color_background}">${item.status}</span></td>
                            </tr>`;

                      }


                      //console.log(arregloReclamos);
                    }

                    $('#reclamosEnviados').DataTable().clear().destroy();
                    $('#reclamosEnviados_tbody').html(tr);
                    $('#reclamosEnviados').DataTable({
                        "order": [[ 0, 'desc' ], [ 1, 'desc' ]]
                    });
                
                },
                error: function (request, status, error) {
        
                    //console.log(request.responseText);
                }
            });
    }

    Get_All_Reclamos();

    function Update_status_mensaje(ID,this_fila){


        //console.log("entramos al update");
        
        var THIS_NODE=this_fila;
        
        $.ajax({
                //url :'sections/Query_Reclamo_21_08_20.php',

                url :'./Query_Reclamo_21_08_20.php',
                type: 'POST',
                data:{'id_row':ID,'action':'Update_status_mensaje'},
                beforeSend: function(){
                    /*
                    $('#BNT_PROCESAR_RECLAMO').attr('disabled','disabled');
                    $('#BNT_PROCESAR_RECLAMO').html('Cargando.......  <i class="fas fa-spinner fa-spin "></i>')
                    .removeClass('btn-primary')
                    .addClass('btn-info');
                    */  
                },
            success: function(data){
                    var json=JSON.parse(data);
                    console.log(json);
                    if(json.info=="select"&&json.status==400){

                        console.log('Error: No se pudo hacer el select para consultar la lista de mensajes');
                        return false;   
                    }
                    if(json.info=="update"){
                        if(json.status==200){
                            $(THIS_NODE).parents('tr').data('contador',0);
                            $(THIS_NODE).html('Ver comentaríos');

                        }else{
                            
                        }
                    }
                
                },
                error: function (request, status, error) {
        
                    console.log(request.responseText);
                }
            });
    }
    

} );
</script>

</body>
</html>