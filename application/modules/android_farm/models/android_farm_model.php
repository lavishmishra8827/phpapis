<?php 
class android_farm_model extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	function fetch_cluster_farms($data){
		$array=array('farm.cluster_id'=>$data['cluster_id'],'farm.comp_id'=>$data['comp_id'],'farm.is_active'=>'Y','farmer.is_active'=>'Y');
		$this->db->select('farm.farm_id,farm.lot_no,farm.farmer_id,farm.cluster_id,farm.comp_id,farm.addL1,farm.addL2,farm.village_or_city,farm.district,farm.mandal_or_tehsil,farm.state,farm.country,farm.exp_area,farm.actual_area,farm.irrigation_source,farm.previous_crop,farm.irrigation_type,farm.soil_type,farm.sowing_date,farm.exp_flowering_date,farm.actual_flowering_date,farm.exp_harvest_date,farm.actual_harvest_date,farm.seed_provided_on,farm.qty_seed_provided,farm.seed_unit_id,farm.germination,farm.population,farm.spacing_rtr,farm.spacing_ptp,farm.doa,farm.is_active,farmer.name,farmer.father_name');
		$this->db->from('farm')->join('farmer','farm.farmer_id=farmer.farmer_id');
		$this->db->where($array);
		return $this->db->get()->result();

	}
	function update_farm($data_input,$data){
		$array=array('farm_id'=>$data['farm_id'],'comp_id'=>$data['comp_id'],'is_active'=>'Y');
		$this->db->set($data_input)->where($array);
		$this->db->update('farm');
		return $this->db->affected_rows();

	}
	function fetch_all_farms($comp_id){
		$array=array('farm.comp_id'=>$comp_id,'farm.is_active'=>'Y');
		$this->db->select('farm.sowing_date,farm.exp_flowering_date,farm.exp_harvest_date,farmer.name,farmer.father_name,farm.farm_id,farm.farmer_id,farm.cluster_id,farm.comp_id,farm.addL1,farm.addL2,farm.village_or_city,farm.district,farm.mandal_or_tehsil,farm.state,farm.country')->from('farm')->join('farmer','farm.farmer_id=farmer.farmer_id')->where($array);
		return $this->db->get()->result();

	}
	function insert_farm_gps($data){
		$this->db->insert_batch('gps',$data);
		return $this->db->insert_id();
	}
	function update_farm_area($area,$farm_id){
		$array=array('farm_id'=>$farm_id,'is_active'=>'Y');
		$this->db->set("actual_area",$area)->where($array);
		$this->db->update('farm');
		return $this->db->trans_complete();
	}
	function fetch_all_farm_gps($comp_id,$farm_id)
	{
		$array=array('comp_id'=>$comp_id,'farm_id'=>$farm_id,'is_active'=>'Y');
		$this->db->select('latitude as lat,longitude as lng')->from("gps")->where($array);
		// $this->db->order_by('');
		return $this->db->get()->result();
	}
	
	function insert($table,$result){ 
       /* $this->db->save_queries=TRUE;
        $array_keys=array_keys($result);
        $array_values=array_values($result);
        $store_keys="";
        $store_values="";
        foreach( $array_keys as $key){
        	$store_keys=$store_keys." ".$key;
        }
        foreach( $array_values as $value){
        	$store_values=$store_values." ".$value;
        }
        $store_final['kiys']=$store_keys;
        $store_final['valuis']=$store_values;
        $this->db->insert("queries",$store_final);
        */$this->db->insert($table,$result);
        
        $insert_id=$this->db->insert_id();
        //$str=$this->db->last_query();
        //$array1['text']=$str;
       // $this->db->insert("queries",$array1);
        
        return $insert_id;
    }

    public function update($table,$data,$array){
    	$this->db->set($data)->where($array)->update($table);
    	return $this->db->trans_complete();
    }
}
?>