
  


      $dias = 20;
       $horas = 8;

       //gasto administrativo general por mes
       $dato_gas['id'] = 4;
       $gastos_admin = self::coger_configuracion($dato_gas)->precio; 

     
       //cantidad de personas activos laborando
       $this->db->from($this->usuarios);
       $where = '(
                    ( activo = 1 ) 
              )';   
       $this->db->where($where); 
       $cant = $this->db->count_all_results();   //6personas

       //gasto por persona
       $gastos_unitario =  $gastos_admin/$cant;  //3333.333

       //print_r($gastos_unitario); die;
       //////////////////




                            foreach ($arreglo_fechas as $key1 => $value1) {
                                  
                                  if ($data['horas_pesos']=='Horas') {
                                    $sql .=" ,SUM(IF(DATE_FORMAT((fecha),'%d-%m-%Y') = '".$value1."', horas, 0)) AS 'a".strtotime($value1)."'";
                                  } else {
                                    $sql .=" ,sum((((salario+".$gastos_unitario.")/".$dias.")/".$horas.")*(IF(DATE_FORMAT((fecha),'%d-%m-%Y') = '".$value1."', horas, 0))) AS 'a".strtotime($value1)."'";
                                  }
                            }

        //////////////////                            
    foreach ($arreglo_fechas as $key1 => $value1) {


          if ($data['horas_pesos']=='Horas' ){
              if ($row->{ "a".strtotime($arreglo_fechas[$key1]) }!=0 ){
                $dato[count($dato)-1][9+$key1] = $row->{ "a".strtotime($arreglo_fechas[$key1]) }.'hrs';
              } else {
              $dato[count($dato)-1][9+$key1] = '<span style="color:#bfbfbf">'.number_format($row->{ "a".strtotime($arreglo_fechas[$key1]) }, 0, '.', ',').'</span>';
              }

          } else {
            if ($row->{ "a".strtotime($arreglo_fechas[$key1]) }!=0 ){
              $dato[count($dato)-1][9+$key1] = '$'.number_format($row->{ "a".strtotime($arreglo_fechas[$key1]) }, 2, '.', ',');
            } else {
              $dato[count($dato)-1][9+$key1] = '<span style="color:#bfbfbf">'.number_format($row->{ "a".strtotime($arreglo_fechas[$key1]) }, 0, '.', ',').'</span>';
            }
          } 

              

        }   


---------------------------
              if ($data['horas_pesos']=='Horas' ){
                  if ($row->{ "a".strtotime($arreglo_fechas[$key1]) }!=0 ){
                    $dato[count($dato)-1][9+$key1] = $row->{ "a".strtotime($arreglo_fechas[$key1]) }.'hrs';
                  } else {
                  $dato[count($dato)-1][9+$key1] = '<span style="color:#bfbfbf">0</span>';
                  }

              } else {
                if ($row->{ "a".strtotime($arreglo_fechas[$key1]) }!=0 ){
                  $dato[count($dato)-1][9+$key1] = '$'.number_format($row->{ "a".strtotime($arreglo_fechas[$key1]) }, 2, '.', ',');
                } else {
                  //$dato[count($dato)-1][9+$key1] = '<span style="color:#bfbfbf">'.number_format($row->{ "a".strtotime($arreglo_fechas[$key1]) }, 0, '.', ',').'</span>';
                  $dato[count($dato)-1][9+$key1] = '<span style="color:#bfbfbf">0</span>';
                }
              }        
