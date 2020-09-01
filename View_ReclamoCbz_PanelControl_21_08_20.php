<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reclamos</title>
 
<!--DataTable !-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap.min.css">


</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="mt-4">Filtrar Por</h4>
                <div class="row">
                        <div class="form-group col-sm-3">
                            <label for="" class="col-form-label">Paqueterías</label>
                            <select name="" id="PAQUETERIA" class="form-control">
                                <option value="all" selected>Todas (*)</option>
                                <option value="0">FEDEX</option>
                                <option value="1">DHL</option>
                                <option value="2">ESTAFETA</option>
                                <option value="3">REDPACK</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="" class="col-form-label">Estatus</label>
                            <select name="" id="ESTATUS" class="form-control">
                                <option value="all" selected>Todos</option>
                                <option value="recibido">Recibidos</option>
                                <option value="proceso">Proceso</option>
                                <option value="finalizado">Finalizado</option>
                            </select>
                        </div>

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
                        
                        <div class="form-group col-sm-2">
                            <label for="" class="col-form-label" style="display:block; opacity:0;">"Buscar"</label>
                            <button class="btn btn-sm btn-primary" id="BTN_REQUEST_DATA_PAQUETERIA">
                                Buscar
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                </div>
            <hr/>

        </div>
        <!--col!-->
        <div class="col-sm-12" id="conte_mensaje" style="display:none;">
            
        </div>
        <!--col!-->
        <div class="col-sm-12">
        <table id="reclamosRecibidos" class="table table-bordered table-responsive" style="width:100%">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Fecha</th>
                                <th>Asociado</th>
                                <th>Paquetería</th>
                                <th>Guías enviadas</th>
                                <th>Comentario</th>
                                <th>Estatus</th>
                                <th>Cambiar Estatus</th>
                            </tr>
                        </thead>
                        <tbody id="reclamosRecibidos_tbody">

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Folio</th>
                                <th>Fecha</th>
                                <th>Asociado</th>
                                <th>Paquetería</th>
                                <th>Guías enviadas</th>
                                <th>Comentario</th>
                                <th>Estatus</th>
                                <th>Cambiar Estatus</th>
                            </tr>
                        </tfoot>
                    </table>

        </div>
        <!--col!-->
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

        <!--col!-->
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

                                <div class="form-group">
                                    <textarea class="form-control" style="display:none;" name="" id="COMENT_CBZ_TEXTAREA" cols="10" rows="4"></textarea>
                                </div>
                                <div class="form-group">
                                     <input type="hidden" style="opacity:0;" id="id_row_table">
                                     <input type="hidden" style="opacity:0;" id="id_row_table_new_status">
                                    <button type="button" class="btn btn-info" style="display:none;" id="BTN_SEND_COMENT_CBZ">Enviar comentarío</button>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
        </div>

        <!--col!-->
    </div>
    <!--fin del row-!-->
</div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!--boostrap !-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js" integrity="sha512-hQeArtKSBTJ1segRjyRoDh409td70Loy62usBB3+Ox5Z1akisBzCoZWpU9+Q/N5GBbgUJ6Xo1fcdFgDDIRzLxA==" crossorigin="anonymous"></script>
    
    
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap.min.js"></script>

    <script>
 $(document).ready(function() {   
     

    $('#reclamosRecibidos').DataTable()
    let arregloReclamos=[];


    let status_new="";
    $(document).on('change','.ESTATUS_CHANGE',function(){

        //initial
        $('#COMENT_CBZ_TEXTAREA').val('');


        $('#BTN_SEND_COMENT_CBZ').show();
        $('#COMENT_CBZ_TEXTAREA').show();
       
        status_new=$(this).val();
        console.log(status_new);

    
        var id=$(this).parents('tr').data('id');
        var status=$(this).parents('tr').data('status');

        

        $('#id_row_table').val(id);
        $('#id_row_table_new_status').val(status_new);

        SHOW_COMENT(id);
    
        $('#Ver_comentario_modal').modal('show');
    });


    
    $(document).on('click','#BTN_SEND_COMENT_CBZ',function(){

        var coment=$('#COMENT_CBZ_TEXTAREA').val();


       var id=$('#id_row_table').val();
        var status=$('#id_row_table_new_status').val();
        
        var OBJ_DATA={
            'id_row':id,
            'comentario':coment,
            'status':status,
            'action':'save_comentario_cbz'
        };

        //console.log(OBJ_DATA);

        $.ajax({

            //url :'sections/View_ReclamoCbz_PanelControl_21_08_20.php',
            url :'./Query_Reclamo_Cbz_21_08_20.php',
            type: 'POST',
            data:OBJ_DATA,
            beforeSend: function(){
                $('#BTN_SEND_COMENT_CBZ').attr('disabled','disabled');
                $('#BTN_SEND_COMENT_CBZ').html('Cargando.......  <i class="fas fa-spinner fa-spin "></i>')
                .removeClass('btn-primary')
                .addClass('btn-danger')
            },
            success: function(data){
                //initial
                $('#COMENT_CBZ_TEXTAREA').val('');
                $('#Ver_comentario_modal').modal('hide');

                setTimeout(() => {

                    $('#BTN_SEND_COMENT_CBZ').removeAttr('disabled');
                    $('#BTN_SEND_COMENT_CBZ').html('Enviar comentarío')
                    .removeClass('btn-danger')
                    .addClass('btn-info');
                    
                },1000);

                var json=JSON.parse(data);
                //console.log(json);
                    
                if(json.status==200){
               
                var alert_html=
                `<div class="alert alert-success alert-dismissible" >
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Datos actualizados con exíto</strong>
                </div>`;

                $('#conte_mensaje').html(alert_html).show();
                $('#BTN_REQUEST_DATA_PAQUETERIA').css('opacity','0');
                $('#BTN_REQUEST_DATA_PAQUETERIA').click();    
                
                }
                if(json.status==400){
                    alert("Error: Intentelo de nuevo");
                    return false;
                }

            },
            error: function (request, status, error) {
                $('#BTN_SEND_COMENT_CBZ').removeAttr('disabled');
                $('#BTN_SEND_COMENT_CBZ').html('Enviar comentarío').removeClass('btn-danger').addClass('btn-info');

                alert("Error: Intentelo de nuevo");
                console.log(request.responseText);
            
            }
            });


    });
    

    $(document).on('click','.VER_COMENTARIO',function(){


       $('#BTN_SEND_COMENT_CBZ').show();
       $('#COMENT_CBZ_TEXTAREA').show();

        var id=$(this).parents('tr').data('id');
        var status=$(this).parents('tr').data('status');

        $('#id_row_table').val(id);
        $('#id_row_table_new_status').val(status);

        SHOW_COMENT(id);
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
                                <strong>Aún no has hecho ningun comentarío</strong>
                        </div>`;
              }
          }
       }

      $('#add_comentario').html(comentarios);

    }

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


    $(document).on('change','#BUSQUEDA_ENTRE_FECHAS',function(){
        var data_select_BUSQUEDA_ENTRE_FECHAS=$(this).val();
        if(data_select_BUSQUEDA_ENTRE_FECHAS=="fecha_personalizada"){
            $('#CONTE_FECHAS_PERSONALIZADAS').show();
        }else{
            $('#CONTE_FECHAS_PERSONALIZADAS').hide();
        }
    });

        
    $(document).on('click','#BTN_REQUEST_DATA_PAQUETERIA',function(){
            
            /*inicializar*/
            //console.log(NEW_OBJECT_ROW.data);
            
        
            var PAQUETERIA=$('#PAQUETERIA').val();
            var BUSQUEDA_ENTRE_FECHAS=$('#BUSQUEDA_ENTRE_FECHAS').val();
            var FECHA_DESDE=$('#FECHA_DESDE').val();
            var FECHA_HASTA=$('#FECHA_HASTA').val();
            var ESTATUS=$('#ESTATUS').val();
            
            var OBJ_DATA={
                'paqueteria':PAQUETERIA,
                'dias_consultar':BUSQUEDA_ENTRE_FECHAS,
                'fecha_desde':FECHA_DESDE,
                'fecha_hasta':FECHA_HASTA,
                'estatus':ESTATUS,
                'action':'read_guias_generadas'
            };
            //console.log(OBJ_DATA);
        
            $.ajax({

                //url :'sections/View_ReclamoCbz_PanelControl_21_08_20.php',
                url :'./Query_Reclamo_Cbz_21_08_20.php',
                type: 'POST',
                data:OBJ_DATA,
                beforeSend: function(){
                   
                 
                    $('#BTN_REQUEST_DATA_PAQUETERIA').attr('disabled','disabled');
                    $('#BTN_REQUEST_DATA_PAQUETERIA').html('Cargando.......  <i class="fas fa-spinner fa-spin "></i>')
                    .removeClass('btn-primary')
                    .addClass('btn-danger')
                    
                },
                success: function(data){
                     //initial
                    arregloReclamos=[];
                    var json=JSON.parse(data);
                    //console.log(json);


                    setTimeout(() => {
                    
                    $('#BTN_REQUEST_DATA_PAQUETERIA').css('opacity','1');
                    $('#BTN_REQUEST_DATA_PAQUETERIA').removeAttr('disabled');

                    $('#BTN_REQUEST_DATA_PAQUETERIA').html(' Buscar <i class="fas fa-search"></i>')
                    .removeClass('btn-danger')
                    .addClass('btn-primary');
                    },1000);

                if(json.status==400){
                    
                    return false;
                }
                
                var tr="";
                if(json.status==200){
                   
                      for (const item of json.data) {

                         arregloReclamos.push(item);
                         Numero_guias_enviadas=JSON.parse(item.data).length;
                            
                         if(item.status=="recibido"){
                                color_background="label-danger";
                          }
                          if(item.status=="proceso"){
                                color_background="label-warning";
                            }
                         if(item.status=="finalizado"){
                                color_background="label-success";
                            }

                         var html_new='';
                         if(item.comentario_cbz==null||item.comentario_cbz==""){
                            html_new=`&nbsp;<i class="fas fa-bell"></i>&nbsp;&nbsp;<span class="badge" style="background-color:#FF5171; color:white;">Nuevo</span>`;
                         }
                           
                            
                           tr+=`
                            <tr data-id="${item.id}" data-status="${item.status}">
                                <td>${item.id}</td>
                                <td>${item.fecha}</td>
                                <td>${item.idasociado}</td>
                                <td>${item.paqueteria}</td>
                               <td>
                                    <button class="btn btn-sm btn-xs btn-primary ver_mas_guias_enviadas" type="button">
                                        Guías enviadas <span class="badge">${Numero_guias_enviadas}</span>
                                    </button>
                               </td>
                                <td>
                                  <button type="button" class="btn btn-sm btn-xs   btn-default  VER_COMENTARIO">Ver comentaríos 
                                     ${html_new}
                                  </button>
                                </td>
                                <td><span class="label ${color_background}">${item.status}</span></td>
                                <td>
                                  <select name=""  class="form-control ESTATUS_CHANGE">
                                     <option value="recibido">Recibidos</option>
                                     <option value="proceso">Proceso</option>
                                     <option value="finalizado">Finalizado</option>
                                  </select>
                                </td>
                            </tr>`
                      }
                    
                    
                }  
                $('#reclamosRecibidos').DataTable().clear().destroy();
                $('#reclamosRecibidos_tbody').html(tr);
                $('#reclamosRecibidos').DataTable({
                    "order": [[ 0, 'desc' ], [ 1, 'desc' ]]
                });
                
                },
                error: function (request, status, error) {
                    $('#BTN_REQUEST_DATA_PAQUETERIA').css('opacity','1');
                    console.log(request.responseText);
                
                }
            });


    });


    //$('#BTN_REQUEST_DATA_PAQUETERIA').click();

    });
    </script>

</body>
</html>
