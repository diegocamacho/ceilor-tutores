<?php

$sql = "SELECT * FROM tutores";
$q_tutores=mysqli_query($db,$sql);
$valida=mysqli_num_rows($q_tutores);
$tutores = array();
while($datos=mysqli_fetch_object($q_tutores)):
	$tutores[] = $datos;
endwhile;
?>

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">

                <div class="portlet light portlet-fit">
                    <div class="portlet-title">
                        <div class="caption">
							<i class="icon-user font-blue-hoki"></i>
                            <span class="caption-subject font-blue-hoki bold uppercase">Tutores</span>
                        </div>
                        <div class="actions btn-set">
                            <a class="btn btn-sm btn-success" href="?Modulo=NuevoTutor" role="button">Nuevo Tutor</a>
                        </div>
                    </div>
                    <div class="portlet-body" id="v_tutores">
                    <? if($valida){ ?>
                        <table class="table table-striped table-bordered table-hover" id="tabla_tutores">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>RFC</th>
                                    <th width="50"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?foreach($tutores as $tutor){ ?>
                                <tr>
                                    <td><?=$tutor->nombre?></td>
                                    <td><?=$tutor->telefono?></td>
                                    <td><?=$tutor->email?></td>  
                                    <td><?=$tutor->rfc?></td>
                                    <td><img src="assets/global/img/loading-spinner-blue.gif" border="0" id="load_<?php echo $tutor->id_tutor?>" width="19" class="oculto" />
                                    <?php if($tutor->activo==1){ ?>
                                        <div class="btn-group btn_<?php echo $tutor->id_tutor; ?>">
                                            <button type="button" class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown">Opciones <span class="caret"></span></button>
                                            <ul class="dropdown-menu pull-right" role="menu" style="min-width: 0px;">
                                                <li><a href="javascript:;" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#EditarDescuento" data-id="<?php echo $tutor->id_tutor?>">Editar</a></li>
                                                <li><a href="javascript:;" onclick="javascript:Desactiva(<?php echo $tutor->id_tutor?>)">Desactivar</a></li>
                                            </ul>
                                        </div>
                                    <?php } else { ?>
                                        <a role="button" class="btn btn-warning btn-xs btn_<?php echo $tutor->id_tutor?>" onclick="javascript:Activa(<?php echo $tutor->id_tutor?>)">Activar</a>
                                    

                                    <?php } ?>
                                       
                                    </td>
                                </tr>
                            <? } ?>
                            </tbody>
                        </table>
                    <? }else{ ?>
                        <div class="alert alert-dismissable alert-warning">
				  			<p>Aún no se han registrado tutores</p>
				  		</div>
                    <? } ?>
                    </div> <!--portlet-body-->
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){

        
  $('#tabla_tutores').dataTable({
    language: {
      url: 'assets/global/plugins/datatables/spanish.js'
    },
    "bStateSave": true,
    "lengthMenu": [
      [20, 35, 50, -1],
      [20, 35, 50, "Todos"]
    ],
    "pageLength": 20,
    "pagingType": "bootstrap_full_number",
    "columnDefs": [
      {
        'orderable': true,
        'targets': [0,1,2,3]
      },
      {
        "searchable": true,
        "targets": [0]
      },
      {
        "className": "dt-right",
        //"targets": [2]
      }
    ],
    "order": [
      [0, "asc"]
    ]
  });
        $('form').submit(function(e){
            e.preventDefault();
        });
        $(document).on('click','[data-id]',function(){
  $('.edit').val("");
  $('.btn-modal').hide();
  $('#frm_edita').hide();
  $('#load_big').show();
    var data_id = $(this).attr('data-id');
    window.open("?Modulo=NuevoTutor&id="+data_id, "_self");

});
        

});
function Desactiva(id_tutor){
  $(".btn_"+id_tutor+"").hide();
  $("#load_"+id_tutor+"").show();
  $.getJSON('ac/activa_desactiva_tutor.php',{activo: "2", id_tutor: ""+id_tutor+"" },function(data){
			console.log(data);
      if(data.respuesta==1){
        window.open("?Modulo=Tutores","_self");
      }else{
        $("#load_"+id_tutor+"").hide();
        $(".btn_"+id_tutor+"").show();
				App.unblockUI();
				App.alert({
					type: 'info',
					message: data.mensaje,
					place: 'prepent',
					container: '#v_tutores',
          close: true,
					focus: true
				});
				return false;
      }
			App.unblockUI();
    });
}
function Activa(id_tutor){
  $(".btn_"+id_tutor+"").hide();
  $("#load_"+id_tutor+"").show();
  $.getJSON('ac/activa_desactiva_tutor.php',{activo: "1", id_tutor: ""+id_tutor+"" },function(data){
			console.log(data);
      if(data.respuesta==1){
        window.open("?Modulo=Tutores","_self");
      }else{
        $("#load_"+id_tutor+"").hide();
        $(".btn_"+id_tutor+"").show();
				App.unblockUI();
				App.alert({
					type: 'info',
					message: data.mensaje,
					place: 'prepent',
					container: '#v_tutores',
          close: true,
					focus: true
				});
				return false;
      }
			App.unblockUI();
    });
}

</script>

