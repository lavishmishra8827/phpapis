<?php 
class Visitreport_model extends CI_Model{
	function __construct(){
		parent::__construct();
		 $this->load->database();
	}
	function insert_vr_activity_template($data){
		$this->db->insert('vr_activity_template',$data);
		return $this->db->insert_id();
	}
	function fetch_activity_template_data($comp_id){
		$this->db->select('*')->from('vr_activity_template')->where('comp_id',$comp_id);
		return $this->db->get()->result();
	}
	function insert_activity_template_material($data){
		$this->db->insert('vr_material_dd',$data);
		return $this->db->insert_id();
	}
	function fetch_visit_report_id($data){
		$array=array('comp_id'=>$data['comp_id'],'farm_id'=>$data['farm_id']);
		$this->db->select('*')->from('visit_report')->where($array);
		$this->db->order_by('visit_number');
		return $this->db->get()->result();	
	}
	function fetch_visit_report_details($vr_id){
		$array=array('visit_activity.visit_report_id'=>$vr_id);
		$this->db->select('visit_activity.done_date,visit_activity.comment,visit_activity.qty,visit_activity.is_prescribed,visit_report.visit_date,visit_report.visit_number,visit_report.effective_area,vr_activity_template.name as activity_name, vr_material_dd.name as material_name, vr_activity_template.seq_num , unit.unit,person.name as person_name')->from('visit_activity')->join('vr_activity_template','visit_activity.activity_template_id=vr_activity_template.activity_template_id','left');
		$this->db->join('vr_material_dd','vr_material_dd.material_id=visit_activity.material_id','left');
		$this->db->join('unit','visit_activity.unit_id=unit.unit_id','left');
		$this->db->join('visit_report','visit_report.visit_report_id=visit_activity.visit_report_id','left');
		$this->db->join('person','person.person_id=visit_report.added_by','left');
		$this->db->where($array);
		$this->db->order_by('seq_num');
		return $this->db->get()->result();
	}
}
?>