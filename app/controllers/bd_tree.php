<?php

	public function get_node($id, $options = array()) {
		$node = $this->db->one("
			SELECT
				s.".implode(", s.", $this->options['structure']).",
				d.".implode(", d.", $this->options['data'])."
			FROM
				".$this->options['structure_table']." s,
				".$this->options['data_table']." d
			WHERE
				s.".$this->options['structure']['id']." = d.".$this->options['data2structure']." AND
				s.".$this->options['structure']['id']." = ".(int)$id
				
				/*
					SELECT s.id, s.lft, s.rgt, s.lvl, s.pid, s.pos, d.nm 
					FROM inven_struct s, inven_data d 
					WHERE s.id = d.id AND s.id = 4
				*/

		);

		if(!$node) {
			throw new Exception('Node does not exist');
		}
		if(isset($options['with_children'])) {
			$node['children'] = $this->get_children($id, isset($options['deep_children']));
		}
		if(isset($options['with_path'])) {
			$node['path'] = $this->get_path($id);
		}
		
		return $node;
	}

	public function get_children($id, $recursive = false) {
		$sql = false;
		if($recursive) {
			$node = $this->get_node($id);
			$sql = "
				SELECT
					s.".implode(", s.", $this->options['structure']).",
					d.".implode(", d.", $this->options['data'])."
				FROM
					".$this->options['structure_table']." s,
					".$this->options['data_table']." d
				WHERE
					s.".$this->options['structure']['id']." = d.".$this->options['data2structure']." AND
					s.".$this->options['structure']['left']." > ".(int)$node[$this->options['structure']['left']]." AND
					s.".$this->options['structure']['right']." < ".(int)$node[$this->options['structure']['right']]."
				ORDER BY
					s.".$this->options['structure']['left']."
			";
		}
		else {
			$sql = "
				SELECT
					s.".implode(", s.", $this->options['structure']).",
					d.".implode(", d.", $this->options['data'])."
				FROM
					".$this->options['structure_table']." s,
					".$this->options['data_table']." d
				WHERE
					s.".$this->options['structure']['id']." = d.".$this->options['data2structure']." AND
					s.".$this->options['structure']['parent_id']." = ".(int)$id."
				ORDER BY
					s.".$this->options['structure']['position']."
			";
				/*
				SELECT s.id, s.lft, s.rgt, s.lvl, s.pid, s.pos, d.nm 
				FROM inven_struct s, inven_data d 
				WHERE s.id = d.id AND s.pid = 0 
				ORDER BY s.pos
				*/
		}


		/*return ($sql);
		return json_decode($sql);*/
		return $this->db->all($sql);
	}

	public function get_path($id) {
		$node = $this->get_node($id);
		$sql = false;
		if($node) {
			$sql = "
				SELECT
					s.".implode(", s.", $this->options['structure']).",
					d.".implode(", d.", $this->options['data'])."
				FROM
					".$this->options['structure_table']." s,
					".$this->options['data_table']." d
				WHERE
					s.".$this->options['structure']['id']." = d.".$this->options['data2structure']." AND
					s.".$this->options['structure']['left']." < ".(int)$node[$this->options['structure']['left']]." AND
					s.".$this->options['structure']['right']." > ".(int)$node[$this->options['structure']['right']]."
				ORDER BY
					s.".$this->options['structure']['left']."
			";
			/*
				SELECT s.id, s.lft, s.rgt, s.lvl, s.pid, s.pos, d.nm 
				FROM inven_struct s, inven_data d 
				WHERE s.id = d.id AND s.lft < 2 AND s.rgt > 3 
				ORDER BY s.lft
			*/

		}

		
		return $sql ? $this->db->all($sql) : false;
	}








protected $db = null;
	protected $options = null;
	protected $default = array(
		'structure_table'	=> 'structure',		// the structure table (containing the id, left, right, level, parent_id and position fields)
		'data_table'		=> 'structure',		// table for additional fields (apart from structure ones, can be the same as structure_table)
		'data2structure'	=> 'id',			// which field from the data table maps to the structure table
		'structure'			=> array(			// which field (value) maps to what in the structure (key)
			'id'			=> 'id',
			'left'			=> 'lft',
			'right'			=> 'rgt',
			'level'			=> 'lvl',
			'parent_id'		=> 'pid',
			'position'		=> 'pos'
		),
		'data'				=> array()			// array of additional fields from the data table
	);

	



//$node = $this->get_node($id);
//Array ( [id] => 1 [lft] => 4 [rgt] => 4 [lvl] => 0 [pid] => 0 [pos] => 0 [nm] => Proyectosaaa )



// $node = json_decode(json_encode($node), true);






  
    /*
    'structure'     => array(     // which field (value) maps to what in the structure (key)
      'id'      => 'id',
      'left'      => 'lft',
      'right'     => 'rgt',
      'level'     => 'lvl',
      'parent_id'   => 'pid',
      'position'    => 'pos'
    ),

    $lft = (int)$data[$this->options['structure']["left"]];
    $rgt = (int)$data[$this->options['structure']["right"]];
    $pid = (int)$data[$this->options['structure']["parent_id"]];
    $pos = (int)$data[$this->options['structure']["position"]];

    */







public function get_node() {


require_once(dirname(__FILE__) . '/class.db.php');
require_once(dirname(__FILE__) . '/class.tree.php');

if(isset($_GET['operation'])) {
	$fs = new tree(db::get('mysqli://root@127.0.0.1/inventarios'), array('structure_table' => 'inven_struct', 'data_table' => 'inven_data', 'data' => array('nm')));

	//print_r(($fs));
	//echo json_encode($fs);

/*
object(tree)#23 (3) { ["db":protected]=> object(vakata\database\DBC)#24 (2) { ["drv":protected]=> object(vakata\database\mysqli_driver)#26 (5) { ["iid":protected]=> int(0) ["aff":protected]=> int(0) ["mnd":protected]=> bool(false) ["lnk":protected]=> NULL ["settings":protected]=> object(vakata\database\Settings)#25 (9) { ["type"]=> string(6) "mysqli" ["username"]=> string(4) "root" ["password"]=> string(4) "root" ["database"]=> string(11) "inventarios" ["servername"]=> string(9) "127.0.0.1" ["serverport"]=> int(3306) ["persist"]=> bool(false) ["timezone"]=> NULL ["charset"]=> string(4) "UTF8" } } ["que":protected]=> NULL } ["options":protected]=> array(5) { ["structure_table"]=> string(12) "inven_struct" ["data_table"]=> string(10) "inven_data" ["data2structure"]=> string(2) "id" ["structure"]=> array(6) { ["id"]=> string(2) "id" ["left"]=> string(3) "lft" ["right"]=> string(3) "rgt" ["level"]=> string(3) "lvl" ["parent_id"]=> string(3) "pid" ["position"]=> string(3) "pos" } ["data"]=> array(1) { [0]=> string(2) "nm" } } ["default":protected]=> array(5) { ["structure_table"]=> string(9) "structure" ["data_table"]=> string(9) "structure" ["data2structure"]=> string(2) "id" ["structure"]=> array(6) { ["id"]=> string(2) "id" ["left"]=> string(3) "lft" ["right"]=> string(3) "rgt" ["level"]=> string(3) "lvl" ["parent_id"]=> string(3) "pid" ["position"]=> string(3) "pos" } ["data"]=> array(0) { } } }

*/



//die;
	try {
		$rslt = null;
		switch($_GET['operation']) {
			case 'analyze':
				var_dump($fs->analyze(true));
				die();
				break;
			case 'get_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
				//$temp = $fs->get_children($node);
				
				$node = $fs->get_path(4); 
				


				/*
					//$node = $fs->get_node(1); 
					Array ( [id] => 1 [lft] => 4 [rgt] => 4 [lvl] => 0 [pid] => 0 [pos] => 0 [nm] => Proyectosaaa )

				
					//$node = $fs->get_node(1,array('with_children'=> true)); 
					Array ( 
						[id] => 1 [lft] => 4 [rgt] => 4 [lvl] => 0 [pid] => 0 [pos] => 0 [nm] => Proyectosaaa 
						[children] => Array ( 
								[0] => Array ( [id] => 5 [lft] => 0 [rgt] => 1 [lvl] => 1 [pid] => 1 [pos] => 0 [nm] => aaa ) 
								[1] => Array ( [id] => 4 [lft] => 2 [rgt] => 3 [lvl] => 1 [pid] => 1 [pos] => 1 [nm] => osmel ) 
					    ) 
					)
				*/	


				print_r($node);
				die;
				$rslt = array();
				foreach($temp as $v) {
					$rslt[] = array('id' => $v['id'], 'text' => $v['nm'], 'children' => ($v['rgt'] - $v['lft'] > 1));
				}
				break;