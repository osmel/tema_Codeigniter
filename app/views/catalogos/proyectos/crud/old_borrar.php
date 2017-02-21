
                                                            texto= '<div class="form-group">';
                                                                texto+='<label>Privacidad</label>';
                                                                texto+='<div class="mt-radio-list">';
                                                                    texto+='<label class="mt-radio mt-radio-outline"> Público';

                                                                        <?php  
                                                                                $marca='checked';
                                                                                if (isset($proy_salvado ->privacidad ))      
                                                                                if ($proy_salvado->privacidad==1) {$marca='checked';} else {$marca='';}
                                                                          ?>

                                                                        texto+='<input <?php echo $marca; ?>  type="radio" value="1" name="privacidad">';
                                                                        texto+='<span></span>';
                                                                    texto+='</label>';
                                                                    texto+='<label class="mt-radio mt-radio-outline"> Privado';
                                                                        <?php  

                                                                                $marca='';
                                                                                if (isset($proy_salvado ->privacidad ))      
                                                                                if ($proy_salvado->privacidad==2) {$marca='checked';} 
                                                                          ?>

                                                                        texto+='<input <?php echo $marca; ?> type="radio" value="2" name="privacidad">';
                                                                        texto+='<span></span>';
                                                                    texto+='</label>';
                                                                texto+='</div>';
                                                            texto+='</div>';



															texto= '<div class="form-group">';
																texto+='<label for="fecha_inicial" class="col-sm-12 col-md-12">Fecha Inicial:<span class="obligatorio"> *</span></label>';
																texto+='<div class="col-sm-12 col-md-12">';
																	
																	  if(data.datos != false){
                                                                            $fecha_inicial=data.datos["fecha_inicial"];
                                                                        } else {
                                                                            $fecha_inicial='';
                                                                       }    


																	texto+='<input value="'+$fecha_inicial+'" type="text" class="fecha  input-sm form-control" ';
																	texto+='id="fecha_inicial" name="fecha_inicial" placeholder="DD-MM-YYYY">';
																		
																texto+='</div>';
															texto+='</div>';

															texto+='<div class="form-group">';
																texto+='<label for="fecha_final" class="col-sm-12 col-md-12">Fecha Final:<span class="obligatorio"> *</span></label>';
																texto+='<div class="col-sm-12 col-md-12">';
																	<?php 
																		$nomb_nom='';
																		if (isset($proy_salvado ->fecha_final )) 
																		if (strtotime($proy_salvado ->fecha_final )>0)  
																		 {	$nomb_nom = $proy_salvado ->fecha_final ;}
																		
																	?>
																	texto+='<input value="<?php echo  set_value('fecha_final',$nomb_nom); ?>" type="text" class="fecha  input-sm form-control" id="fecha_final" ';
																	texto+='name="fecha_final" placeholder="DD-MM-YYYY">';
																		
																texto+='</div>';
															texto+='</div>';

