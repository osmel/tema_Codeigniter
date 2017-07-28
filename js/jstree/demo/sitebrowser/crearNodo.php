<script type="text/javascript">
    
    .on('create_node.jstree', function (e, data) {
							$.get('?operation=create_node', { 'id' : data.node.parent, 'position' : data.position, 'text' : data.node.text })
								.done(function (d) {
									data.instance.set_id(data.node, d.id);
								})
								.fail(function () {
									data.instance.refresh();
								});
						})

</script>



<?php
case 'create_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
				$temp = $fs->mk(

						 $node, //padre
						 isset($_GET['position']) ? (int)$_GET['position'] : 0, //posicion
				         array('nm' => isset($_GET['text']) ? $_GET['text'] : 'New node') //data

				         );


				$rslt = array('id' => $temp);
				
				break;






public function mk($parent, $position = 0, $data = array()) {
		$parent = (int)$parent;
		if($parent == 0) { throw new Exception('Parent is 0'); }
		$parent = $this->get_node($parent, array('with_children'=> true));
		if(!$parent['children']) { $position = 0; }
		if($parent['children'] && $position >= count($parent['children'])) { $position = count($parent['children']); }

		$sql = array();
		$par = array();

		// PREPARE NEW PARENT
		// update positions of all next elements
		$sql[] = "
			UPDATE ".$this->options['structure_table']."
				SET ".$this->options['structure']["position"]." = ".$this->options['structure']["position"]." + 1
			WHERE
				".$this->options['structure']["parent_id"]." = ".(int)$parent[$this->options['structure']['id']]." AND
				".$this->options['structure']["position"]." >= ".$position."
			";
		$par[] = false;

		// update left indexes
		$ref_lft = false;
		if(!$parent['children']) {
			$ref_lft = $parent[$this->options['structure']["right"]];
		}
		else if(!isset($parent['children'][$position])) {
			$ref_lft = $parent[$this->options['structure']["right"]];
		}
		else {
			$ref_lft = $parent['children'][(int)$position][$this->options['structure']["left"]];
		}
		$sql[] = "
			UPDATE ".$this->options['structure_table']."
				SET ".$this->options['structure']["left"]." = ".$this->options['structure']["left"]." + 2
			WHERE
				".$this->options['structure']["left"]." >= ".(int)$ref_lft."
			";
		$par[] = false;

		// update right indexes
		$ref_rgt = false;
		if(!$parent['children']) {
			$ref_rgt = $parent[$this->options['structure']["right"]];
		}
		else if(!isset($parent['children'][$position])) {
			$ref_rgt = $parent[$this->options['structure']["right"]];
		}
		else {
			$ref_rgt = $parent['children'][(int)$position][$this->options['structure']["left"]] + 1;
		}
		$sql[] = "
			UPDATE ".$this->options['structure_table']."
				SET ".$this->options['structure']["right"]." = ".$this->options['structure']["right"]." + 2
			WHERE
				".$this->options['structure']["right"]." >= ".(int)$ref_rgt."
			";
		$par[] = false;

		// INSERT NEW NODE IN STRUCTURE
		$sql[] = "INSERT INTO ".$this->options['structure_table']." (".implode(",", $this->options['structure']).") VALUES (?".str_repeat(',?', count($this->options['structure']) - 1).")";
		$tmp = array();
		foreach($this->options['structure'] as $k => $v) {
			switch($k) {
				case 'id':
					$tmp[] = null;
					break;
				case 'left':
					$tmp[] = (int)$ref_lft;
					break;
				case 'right':
					$tmp[] = (int)$ref_lft + 1;
					break;
				case 'level':
					$tmp[] = (int)$parent[$v] + 1;
					break;
				case 'parent_id':
					$tmp[] = $parent[$this->options['structure']['id']];
					break;
				case 'position':
					$tmp[] = $position;
					break;
				default:
					$tmp[] = null;
			}
		}
		$par[] = $tmp;

		foreach($sql as $k => $v) {
			try {
				$this->db->query($v, $par[$k]);
			} catch(Exception $e) {
				$this->reconstruct();
				throw new Exception('Could not create');
			}
		}
		if($data && count($data)) {
			$node = $this->db->insert_id();
			if(!$this->rn($node,$data)) {
				$this->rm($node);
				throw new Exception('Could not rename after create');
			}
		}
		return $node;
	}
				