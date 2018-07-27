<?php 
class Farm_model extends CI_Model{
	function __construct(){
		parent::__construct();
		 $this->load->database();
	}

	function insert_farmer($data){
		$this->db->insert('farmer',$data);
		return $this->db->insert_id();
	}
	function insert_farm($data){
		$this->db->insert('farm',$data);
		return $this->db->insert_id();
	}
	function fetch_cluster_farms($data){
		$array=array('farm.cluster_id'=>$data['cluster_id'],'farm.comp_id'=>$data['comp_id'],'farm.is_active'=>'Y','farmer.is_active'=>'Y');
		$this->db->select('farm.farm_id,farm.lot_no,farm.farmer_id,farm.cluster_id,farm.comp_id,farm.addL1,farm.addL2,farm.village_or_city as,farm.district,farm.mandal_or_tehsil,farm.state,farm.country,farm.exp_area,farm.actual_area,farm.irrigation_source,farm.previous_crop,farm.irrigation_type,farm.soil_type,farm.sowing_date,farm.exp_flowering_date,farm.actual_flowering_date,farm.exp_harvest_date,farm.actual_harvest_date,farm.seed_provided_on,farm.qty_seed_provided,farm.seed_unit_id,farm.germination,farm.population,farm.spacing_rtr,farm.spacing_ptp,farm.doa,farm.is_active,farmer.name,farmer.father_name');
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
		$this->db->select('farm.lot_no,farm.sowing_date,farm.exp_flowering_date,farm.exp_harvest_date,farmer.name,farmer.father_name,farm.farm_id,farm.farmer_id,farm.cluster_id,farm.comp_id,farm.addL1,farm.addL2,farm.village_or_city,farm.district,farm.mandal_or_tehsil,farm.state,farm.country,cluster.cluster_name')->from('farm')->join('farmer','farm.farmer_id=farmer.farmer_id');
		$this->db->join('cluster','cluster.cluster_id=farm.cluster_id','left')->where($array);
		return $this->db->get()->result();
	}

	function fetch_farm_initial_details($comp_id,$farm_id){
		$array=array('farm.comp_id'=>$comp_id,'farm.is_active'=>'Y','farm.farm_id'=>$farm_id);
		$this->db->select('farm.farm_id,farm.lot_no,farm.farmer_id,farm.cluster_id,farm.comp_id,farm.addL1,farm.addL2,farm.village_or_city ,farm.district,farm.mandal_or_tehsil,farm.state,farm.country,farm.exp_area,farm.actual_area,farm.area_harvested,farm.irrigation_source,farm.previous_crop,farm.irrigation_type,farm.soil_type,farm.sowing_date,farm.exp_flowering_date,farm.actual_flowering_date,farm.exp_harvest_date,farm.actual_harvest_date,farm.seed_provided_on,farm.qty_seed_provided,farm.germination,farm.population,farm.spacing_rtr,farm.spacing_ptp,farm.doa,farm.is_active,farmer.name,farmer.father_name,farmer.addL1 as f_addL1,farmer.addL2 as f_addL2,farmer.village_or_city as f_village_or_city, ,farmer.district as f_district,farm.mandal_or_tehsil as f_mandal_or_tehsil,farmer.state as f_state ,farmer.country as f_country,farmer.mob as f_mob,farmer.gender as f_gender,farmer.img_link as f_img_link,farmer.aadhaar_no as f_aadhaar_no,farmer.aadhaar_img_link as f_aadhaar_img_link,farmer.PAN,farmer.bank_name,farmer.bank_account_no,farmer.bank_account_holder,farmer.bank_branch,farmer.bank_ifsc,farmer.agreed_rate,farmer.payment_mode,cluster.cluster_name,organiser.name as o_name, organiser.mob as o_mob,unit.unit');
		$this->db->from('farm')->join('farmer','farm.farmer_id=farmer.farmer_id');
		$this->db->join('cluster','cluster.cluster_id=farm.cluster_id','left');
		$this->db->join('organiser','cluster.organiser_id=organiser.organiser_id','left')->where($array);
		$this->db->join('unit','unit.unit_id=farm.seed_unit_id','left');
		return $this->db->get()->row();
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
		return $this->db->get()->result();
	}

	function insert_hist($table1,$array,$table2,$data)
	{
		$data_input=$this->db->select("*")->from($table1)->where($array)->get()->row_array();
		//return $data_input;
		if($data_input)
		{
		$data_input=array_merge($data_input,$data);
		 $this->db->insert($table2,$data_input);
		 return $this->db->insert_id();
		}
		else
		{
			return -1;
		}

	}
	function delete($table,$array)
	{
		return $this->db->where($array)->delete($table);
	}
	function update($table,$data,$array)
	{
		 $this->db->set($data)->where($array)->update($table);
		 return $this->db->trans_complete();
	}
	function fetch_farmer($data){
		return $this->db->select("name,father_name,mob,PAN,bank_name,bank_account_no,bank_account_holder,bank_branch ,bank_ifsc,agreed_rate,payment_mode,aadhaar_no")->from("farmer")->where($data)->get()->row();
	}
	function fetch_farm($data){
		return $this->db->select("lot_no,addL2,addL1,mandal_or_tehsil,district,village_or_city,state,country,cluster_id,exp_area,seed_provided_on,qty_seed_provided,seed_unit_id")->from("farm")->where($data)->get()->row();
	}
}