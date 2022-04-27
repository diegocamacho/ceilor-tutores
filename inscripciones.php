<?php
$sql="SELECT alumnos.id_alumno,alumnos.nombre as alumno,apaterno,amaterno,genero,tutores.nombre as tutor,telefono,nivel, denominacion, alumnos_academico.id_nivel FROM alumnos
JOIN alumnos_academico ON alumnos_academico.id_alumno=alumnos.id_alumno
JOIN tutores ON tutores.id_tutor=alumnos.id_tutor
JOIN denominaciones ON denominaciones.id_denominacion=alumnos.id_denominacion
JOIN niveles ON niveles.id_nivel=alumnos_academico.id_nivel
ORDER BY alumnos_academico.id_nivel,apaterno,amaterno,alumno ASC";
$q_alumnos=mysqli_query($db,$sql);
$valida=mysqli_num_rows($q_alumnos);
$alumnos = array();
while($datos=mysqli_fetch_object($q_alumnos)):
	$alumnos[] = $datos;
endwhile;
?>

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">

                <div class="portlet light portlet-fit">
                    <div class="portlet-title">
                        <div class="caption">
							<i class="icon-user-following font-blue-hoki"></i>
                            <span class="caption-subject font-blue-hoki bold uppercase">Nueva Inscripción</span>
                        </div>
                        <div class="actions btn-set">
                            <a class="btn btn-sm btn-success" href="?Modulo=NuevaInscripcion" role="button">Nueva Inscripción</a>
                        </div>
                    </div>
                    <div class="portlet-body">
                    <? if($valida){ ?>
                        <table class="table table-striped table-bordered table-hover" id="tabla_alumnos">
                            <thead>
                                <tr>
                                    <th>Nivel</th>
									<th>Denominación</th>
									<th>Alumno</th>
									<th>Genero</th>
									<th>Tutor</th>
									<th>Teléfono</th>
                                    <th width="50"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?foreach($alumnos as $alumno){ ?>
                                <tr>
                                    <td><?=$alumno->nivel?></td>
									<td><?=$alumno->denominacion?></td>
									<td><?=$alumno->apaterno?> <?=$alumno->amaterno?> <?=$alumno->alumno?></td>
									<td><?=$alumno->genero?></td>
									<td><?=$alumno->tutor?></td>
									<td><?=$alumno->telefono?></td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown">Opciones <span class="caret"></span></button>
                                            <ul class="dropdown-menu pull-right" role="menu" style="min-width: 0px;">
                                                <li><a href="javascript:;" onclick="PDFInscripcion(<?=$alumno->id_nivel?>,<?=$alumno->id_alumno?>)">Imprimir Comprobante</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <? } ?>
                            </tbody>
                        </table>
                    <? }else{ ?>
                        <div class="alert alert-dismissable alert-warning">
				  			<p>Aún no se han inscrito alumnos</p>
				  		</div>
                    <? } ?>
                    </div> <!--portlet-body-->
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        
  $('#tabla_alumnos').dataTable({
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
        

    });

    function PDFInscripcion(id_nivel, id_alumno){
    window.open(
        "reporte/PDFInscripciones.php?id_nivel="+id_nivel+"&id_alumno="+id_alumno,
        "_blank"
    );
}
</script>
