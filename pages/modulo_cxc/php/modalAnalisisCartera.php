 <!-- Modal Gestion #5 -->
 <div id="analisisSuspensiones" class="modal fade" role="dialog">
     <div class="modal-dialog modal-lg">

         <!-- Modal content-->
         <div class="modal-content">
             <div style="background-color: #d32f2f; color:white;" class="modal-header">
                 <h4 class="modal-title">Analisis de cartera de clientes</h4>
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
             </div>
             <form id="frmanalisisSuspensiones" action="php/analisisSuspensiones.php" method="POST" target="_blank">
                 <div class="modal-body">
                     <div class="row">
                         <div class="col-md-8">
                             <label for="clCobrador">Cobrador</label>
                             <select class="form-control" type="text" id="clCobrador" name="clCobrador" required>
                                 <option value="">Seleccione cobrador</option>
                                 <option value="todos" selected>Todos</option>
                                 <?php
                                    $cobradores = $mysqli->query("SELECT * FROM tbl_cobradores");
                                    while ($datos = $cobradores->fetch_array()) {
                                    ?>
                                     <option value="<?php echo $datos['codigoCobrador'] ?>"><?php echo $datos['nombreCobrador'] ?></option>
                                 <?php
                                    }
                                    ?>
                             </select>
                         </div>
                         <div class="col-md-2">
                             <label for="cldiaCobro">Dia de cobro</label>
                             <input class="form-control" type="number" name="cldiaCobro" value="1">
                         </div>
                         <div class="col-md-2">
                             <label for="clServicio">Tipo de servicio</label>
                             <select class="form-control" type="text" id="clServicio" name="clServicio" required>
                                 <option value="">Seleccione tipo de servicio</option>
                                 <option value="C" selected>Cable</option>
                                 <option value="I">Internet</option>
                                 <option value="A">Paquete</option>
                                 <option value="T" selected>TODOS</option>
                             </select>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-12">
                             <label for="clColonia">Brarrio/Colonia</label>
                             <select class="form-control buscador" id="clColonia" name="clColonia" required style="width: 100%!important;">
                                 <option value="todas" selected>Todas las zonas</option>

                             </select>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-3">
                             <label for="desde">Desde</label>
                             <input class="form-control" type="date" name="desde" value="<?php echo date('Y-m-d', strtotime(date('Y-m-d') . '- 1 month')) ?>">
                         </div>
                         <div class="col-md-3">
                             <label for="hasta">Desde</label>
                             <input class="form-control" type="date" name="hasta" value="<?php echo date('Y-m-d') ?>">
                         </div>
                         <div class="col-md-3" style="padding-top: 10px;">
                             <br>
                             <input type="checkbox" class="btn-check" name="ordenarPorColonias" id="ordenarPorColonias" autocomplete="off" value="1">
                             <label class="btn btn-outline-danger" for="ordenarPorColonias">Ordenar Por Colonias</label>
                         </div>
                         <div class="col-md-3" style="padding-top: 10px;">
                             <br>
                             <input type="checkbox" class="btn-check" name="todosLosDias" id="todosLosDias" autocomplete="off" value="1">
                             <label class="btn btn-outline-danger" for="todosLosDias">Todos los dias</label>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-4">
                             <label for="tipoAnalisis">Tipo de análisis</label>
                             <select class="form-control" type="text" id="tipoAnalisis" name="tipoAnalisis" required>
                                 <option value="in" selected>Instalaciones</option>
                                 <option value="su">Suspensiones</option>
                                 <option value="re">Renovaciones</option>
                             </select>
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <div class="row">
                         <div class="col-md-6">
                             <input type="submit" class="btn btn-danger btn-sm" name="submit" value="Analisis">
                         </div>
                         <div class="col-md-6">
                             <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                         </div>
                     </div>
             </form>
         </div>
     </div>
 </div>
 </div><!-- Fin Modal Gestion #5-->
 <script>
     $("#clCobrador").change(function() {
         $cobrador = $(this).val();
         $proceso = "cobrador";
         $.ajax({
             type: 'POST',
             url: 'php/funcionesAnalisis.php',
             data: {
                 proceso: $proceso,
                 cod: $cobrador,
             },
             dataType: 'Json',
             success: function(datax) {
                 $("#clColonia").empty();
                 var filas = datax.filas;
                 $("#clColonia").append("<option value='todas'>Todas las zonas</option>");
                 for (var i = 0; i < filas; i++) {
                     var nuevafila = "<option value=" + datax.colonias[i].idColonia + ">" + datax.colonias[i].nombreColonia + "</option>";
                     $("#clColonia").append(nuevafila);
                 }
             },
             error: function() {
                 swal('Error', 'Ha ocurrido un error al traer la informacion', 'error');
             }
         });
     });
 </script>