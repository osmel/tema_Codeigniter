<?php

   //-----------entornos------------------

        public function total_entornos(){
           $this->db->from($this->catalogo_entornos);
           $entornos = $this->db->get();            
           return $entornos->num_rows();
        }


        public function listado_entornos($limit=-1, $offset=-1){

          $this->db->select('c.id, c.entorno, c.tabla');
          $this->db->from($this->catalogo_entornos.' as c');
          $this->db->order_by('c.entorno', 'asc'); 
          
          if ($limit!=-1) {
              $this->db->limit($limit, $offset); 
          } 
          $result = $this->db->get();


            if ( $result->num_rows() > 0 ) {
                foreach ($result->result() as $row)  {
                         $row->uso = self::entornos_en_uso($row->id);
                 }                 
               return $result->result();
            }    else
               return False;
            $result->free_result();
        }        



      public function buscador_entornos($data){
            $this->db->distinct();
            $this->db->select("c.tabla");
            $this->db->select("c.entorno", FALSE);  
            $this->db->select("p.descripcion", FALSE);  
            $this->db->from($this->productos.' as p');
            $this->db->join($this->catalogo_entornos.' As c', 'p.id_entorno = c.id','LEFT');
            $this->db->like("p.descripcion" ,$data['dependiente']);
            $this->db->like("c.entorno" ,$data['key']);

            $this->db->order_by('c.entorno', 'asc'); 
            //$this->db->or_like("c.entorno" ,$data['key'],FALSE);

              $result = $this->db->get();
              if ( $result->num_rows() > 0 ) {
                  foreach ($result->result() as $row) {
                            $dato[]= array(
                                      "descripcion"=>$row->descripcion,
                                      "entorno"=>$row->entorno,
                                      "tabla"=>$row->tabla
                                    );
                      }
                      return json_encode($dato);
                      //return '[ {"nombre":"Jhon", "apellido":"calderón"}, {"nombre":"jean", "apellido":"calderón"}]';
              }   
              else 
                 return False;
              $result->free_result();
      }   

 
   





        //eliminar entorno
        public function eliminar_entorno( $data ){
            $this->db->delete( $this->catalogo_entornos, array( 'id' => $data['id'] ) );
            if ( $this->db->affected_rows() > 0 ) return TRUE;
            else return FALSE;
        }     