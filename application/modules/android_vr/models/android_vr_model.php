<?php 
class android_vr_model extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
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
	function insert($table,$result){ 
        $this->db->save_queries=TRUE;
       // $str1=$this->db->last_query();
        //$array['text']=$str1;
        //$this->db->insert("queries",$array);
        $array_keys=array_keys($result);
        $array_values=array_values($result);
        $store_keys="";
        $store_values="";
        foreach( $array_keys as $key)
        {
        	$store_keys=$store_keys." ".$key;
        }
        foreach( $array_values as $value)
        {
        	$store_values=$store_values." ".$value;
        }
        $store_final['kiys']=$store_keys;
        $store_final['valuis']=$store_values;
        $this->db->insert("queries",$store_final);
        $this->db->insert($table,$result);
        
        $insert_id=$this->db->insert_id();
        $str=$this->db->last_query();
        $array1['text']=$str;
        $this->db->insert("queries",$array1);
        
        return $insert_id;
    }

    public function update($table,$data,$array)
    {
    	$this->db->set($data)->where($array)->update($table);
    	return $this->db->trans_complete();
    }

}
?>