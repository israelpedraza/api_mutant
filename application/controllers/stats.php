<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stats extends CI_Controller {

   public function index(){
   	$this->db->select('sum(mutant) as count_mutant_dna , sum(human) as count_human_dna, ROUND((sum(mutant)/sum(human)),1) as ratio', FALSE);
   	$query = $this->db->get('stats');
   	if ($query->row()){
   		$array_response=$query->first_row();
   		print json_encode($array_response);
	      return;
	   }
	   print json_encode(array('count_mutant_dna'=>'0', 'count_human_dna' => '0', 'ratio' => '0' ));
	   return;

   }

}
