<?php if ( ! defined('BASEPATH')) exit('Access Denied...');

class City_model extends CI_Model {
	protected $table='cities';
	protected $key = 'id';
    function __construct()
    {
        parent::__construct();
    }
	
	public function get($key,$filter=null){
		if(isset($filter))extract($filter);
		$filter = array(
			'fields'=>'*',
			'key_by'=>$this->key,
			'filter_by'=>null
		);
		extract($filter,EXTR_SKIP);
		$this->db->select($fields);
		$this->db->where($key_by,$key);
		if(isset($filter_by)){
			$pcs=explode("=>", $filter_by);
			$filter_by = $pcs[0];
			$filter_by_value = $pcs[1];
			$this->db->where($filter_by,$filter_by_value);
		}
		
		$dataset=$this->db->get($this->table);
		
		if($dataset->num_rows()){
			return $dataset->row();
		}else{
			return FALSE;
		}
	}
	
	public function get_all($filter=null){
		if(isset($filter))extract($filter);
		$filter = array(
			'limit'=>9999,
			'start'=>0,
			'order_by'=>'id ASC',//add comma for multiple order by..
			'fields'=>'*',
			'show_query'=>FALSE,
			'state'=>null,
			'field_key'=>null,
			'field_value'=>null,
			'exclude_fields'=>null
		);
		
		extract($filter,EXTR_SKIP);
		
		//excludes fields if isset
		if(isset($exclude_fields)){
			$meta_data = $this->db->field_data($this->table);
			$fields = "";
			$exclude_fields = explode(",", $exclude_fields);
			foreach($meta_data as $key=>$field){
				if(!in_array($field->name, $exclude_fields)){
					$fields[] = $field->name;
				}
			}
			$fields = implode(',',$fields);
		}
		
		//sort by defined key and value
		if(isset($field_key)&&isset($field_value)){
			$this->db->where($field_key,$field_value);
		}
		
		$this->db->select($fields);
		if(isset($state)){
			$states = explode(",",$state);
			$this->db->where_in('state',$states);
		}
		$order_by = explode(',',$order_by);
		
		foreach($order_by as $ob){
			$obs = explode(" ",$ob);
			$this->db->order_by($obs[0],$obs[1]);
		}
		
		$dataset=$this->db->get($this->table,$limit,$start);
		
		if($show_query){d($this->db->last_query());}
		
		
		if($dataset->num_rows()){
			return $dataset->result();
		}else{
			return FALSE;
		}
	}
	public function get_by_area_code($area_code,$filter=null){
		if(isset($filter))extract($filter);
		$filter = array(
			'limit'=>9999,
			'start'=>0,
			'order_by'=>'id ASC',//add comma for multiple order by..
			'fields'=>'*',
			'show_query'=>FALSE
		);
		
		extract($filter,EXTR_SKIP);
		
		$this->db->select($fields);
		$this->db->where('area_code',$area_code);
		$order_by = explode(',',$order_by);
		
		foreach($order_by as $ob){
			$obs = explode(" ",$ob);
			$this->db->order_by($obs[0],$obs[1]);
		}
		
		$dataset=$this->db->get($this->table,$limit,$start);
		
		if($show_query){d($this->db->last_query());}
		
		
		if($dataset->num_rows()){
			return $dataset->result();
		}else{
			return FALSE;
		}
	}
	
	public function get_zip($state,$city){
		$this->db->select('zip_code');
		$this->db->where('state',$state);
		$this->db->where('name',$city);
		$dataset = $this->db->get('cities');
		return $dataset->result();
	}
	
	public function get_by_zip_code($zip_code,$filter=null){
		if(isset($filter))extract($filter);
		$filter = array(
			'limit'=>9999,
			'start'=>0,
			'order_by'=>'id ASC',//add comma for multiple order by..
			'fields'=>'*',
			'exclude_fields'=>null,
			'show_query'=>FALSE
		);
		
		extract($filter,EXTR_SKIP);
		
		if(isset($exclude_fields)){
			$meta_data = $this->db->field_data($this->table);
			$fields = "";
			$exclude_fields = explode(",", $exclude_fields);
			foreach($meta_data as $key=>$field){
				if(!in_array($field->name, $exclude_fields)){
					$fields[] = $field->name;
				}
			}
			$fields = implode(',',$fields);
		}
		
		$this->db->select($fields);
		$this->db->like('zip_code',$zip_code);
		
		$order_by = explode(',',$order_by);
		foreach($order_by as $ob){
			$obs = explode(" ",$ob);
			$this->db->order_by($obs[0],$obs[1]);
		}
		
		$this->db->group_by('id');
		$dataset=$this->db->get($this->table,$limit,$start);
		
		if($show_query){d($this->db->last_query());}
		
		
		if($dataset->num_rows()){
			return $dataset->result();
		}else{
			return FALSE;
		}
	}
	public function get_by_state($state_abbr,$filter=null){
		if(isset($filter))extract($filter);
		$filter = array(
			'limit'=>9999,
			'start'=>0,
			'order_by'=>'id ASC',//add comma for multiple order by..
			'fields'=>'*',
			'exclude_fields'=>null,
			'show_query'=>FALSE
		);
		extract($filter,EXTR_SKIP);
		
		$this->db->select($fields);
		$this->db->where('state',$state_abbr);
		$order_by = explode(',',$order_by);
		foreach($order_by as $ob){
			$obs = explode(" ",$ob);
			$this->db->order_by($obs[0],$obs[1]);
		}
		
		$dataset=$this->db->get($this->table,$limit,$start);
		
		if($show_query){d($this->db->last_query());}
		
		
		if($dataset->num_rows()){
			return $dataset->result();
		}else{
			return FALSE;
		}
	}
	public function count(){
		return $this->db->count_all_results($this->table);
	}
	
	public function insert($data){
			
		$data['state'] = strtolower($data['state']);
        
        return $this->db->insert($this->table, $data);
	}
	
	public function update($key,$data){
		$this->db->where($this->key,$key);
        if($this->db->update($this->table,$data)){
            return true;
        }else{
            return false;
        }
	}
	public function update_area_phone($area_code,$phone_number){
		$this->db->where('area_code',$area_code);
        if($this->db->update($this->table,array('phone'=>$phone_number))){
            return true;
        }else{
            return false;
        }
	}
	public function is_exists($key,$option=null){
		$this->db->select($this->key);
		$this->db->where(isset($option)?$option:$this->key,$key);
		$dataset=$this->db->get($this->table);
		if($dataset->num_rows()){
			return TRUE;//yes it exists
		}else{
			return FALSE;//no it doesnt exists
		}
	}

	public function trash($key){
		$return_flag=1;
		if($this->is_exists($key)){
			$return_flag = $this->db->delete($this->table, array($this->key => $key));
		}else{
			$return_flag = -1;
		}
		return $return_flag;
	}
	
	public function clean(){
		$this->db->where('name', "");
		$this->db->or_where('name', "city");
		return $this->db->delete($this->table);
	}
	
	public function truncate(){
		return $this->db->truncate($this->table); 
	}
	
	public function has_duplicate_slug($slug){
		$this->db->select('id, slug, state');
		$this->db->where('slug',$slug);
		$dataset = $this->db->get($this->table);
		if($dataset->num_rows()>1){
			return $dataset->result();
		}
	}
	
	public function get_duplicated_slug(){
		$dataset = $this->db->query('SELECT `slug` FROM `cities` GROUP BY `slug` HAVING COUNT(`slug`) > 1');
		if($dataset->num_rows()){
			return $dataset->result();
		}
	}
	
	public function fix(){
		$this->db->query("UPDATE cities SET zip_code = CONCAT('0', zip_code) WHERE zip_code LIKE '____'");
	}
}