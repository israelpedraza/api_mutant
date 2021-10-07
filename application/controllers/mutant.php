<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mutant extends CI_Controller {

   public function index(){
	    
		  $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $dna=trim($input_data['dna']);
        $dna=str_replace(['\'', '\"', '[', ']'], '', $dna);
 
	    //$dna='ATGCGA,CAGTGC,TTATGT,AGAAGG,CCCCTA,TCACTG';
		 if( (!preg_match('/^[ATCG\,]*$/', $dna)) || ($dna=='') ){
		   http_response_code(403);
	      die('Forbidden');
		 }

		$one=explode(",",$dna);
		$matrix = array();
		foreach ($one as $item){
		    $matrix[] = str_split($item);
		}
		$dna_mutant_sequences=array("0"=>"AAAA","1"=>"TTTT","2"=>"CCCC","3"=>"GGGG");
		for ($i = 0; $i < count($dna_mutant_sequences); $i++) {
		  if($this->Check_horizontally($dna_mutant_sequences[$i],$matrix)){$this->save_stat(1,0,$dna);http_response_code(200);die('OK');};
		  if($this->Check_vertically($dna_mutant_sequences[$i],$matrix)){$this->save_stat(1,0,$dna);http_response_code(200);die('OK');};
		  if($this->Check_diagonally_LR($dna_mutant_sequences[$i],$matrix)){$this->save_stat(1,0,$dna);http_response_code(200);die('OK');};
		  if($this->Check_diagonally_RL($dna_mutant_sequences[$i],$matrix)){$this->save_stat(1,0,$dna);http_response_code(200);die('OK');};
		}
	   $this->save_stat(0,1,$dna);
		http_response_code(403);
	   die('Forbidden');

   }
   function Check_horizontally($sequence,$matrix){
		  $tmpSeq = '';
		  $len_matrix= count($matrix);
		  $len_sequence= strlen($sequence);
			for ($i = 0; $i < $len_matrix; $i++) {
			   for ($j = 0; $j <= ($len_matrix - $len_sequence); $j++) {
			       $tmpSeq = '';
			       for ($k = 0; $k < $len_sequence; $k++) {
			            $tmpSeq.= $matrix[$i][$j + $k];
			        }
			        if ($tmpSeq == $sequence) {
			            //print "Match H = ".$sequence."\n";
			            return true;
			        }
			   }
			}
   }
   function Check_vertically($sequence,$matrix){
		$tmpSeq = '';
		$len_matrix= count($matrix);
	   $len_sequence= strlen($sequence);
		for ($i = 0; $i < $len_matrix; $i++) {
		    for ($j = 0; $j <= ($len_matrix - $len_sequence); $j++) {
		         $tmpSeq = '';
		        for ($k = 0; $k < $len_sequence; $k++) {
		            $tmpSeq.= $matrix[$j + $k][$i];
		        }
		        if ($tmpSeq == $sequence) {
		            //print "Match V = ".$sequence."\n";
		            return true;
		        }
		    }
		}
   }
   function Check_diagonally_LR($sequence,$matrix){
		$tmpSeq = '';
		$len_matrix= count($matrix);
	   $len_sequence= strlen($sequence);
		for ($i = 0; $i <= ($len_matrix - $len_sequence); $i++) {
		    for ($j = 0; $j <= (count($matrix[$i]) - $len_sequence); $j++) {
		        $tmpSeq = '';
		        for ($k = 0; $k < $len_sequence; $k++) {
		        	$tmpSeq.= $matrix[$i + $k][$j + $k];
		        }
		        if ($tmpSeq == $sequence) {
		        	  //print "Match LR = ".$sequence."\n";
		        	  return true;
		        }
		    }
		}
   }
   function Check_diagonally_RL($sequence,$matrix){
		$tmpSeq = '';
		$len_matrix= count($matrix);
	   $len_sequence= strlen($sequence);
		for ($i = 0; $i <= ($len_matrix - $len_sequence); $i++) { // line i = 0
		    for ($j = (count($matrix[$i])-1) ; $j >= (0 + $len_sequence-1); $j--) { // column j = 1
		        $tmpSeq = '';
		        for ($k = 0; $k < $len_sequence; $k++) {
		            $tmpSeq.= $matrix[$i + $k][$j - $k];
		        }
		        if ($tmpSeq == $sequence) {
					      //print "Match RL = ".$sequence."\n";
					      return true;
		        }
		    }
      }
   }
   function save_stat($mutant,$human,$dna){
		$this->db->trans_start();
		$this->db->trans_strict(FALSE);
      $data = array(
					'mutant' => $mutant,
					'human' 	=> $human,
					'dna' 	=> $dna,
		);
		$this->db->insert('stats', $data);
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
		    # Something went wrong.
		    $this->db->trans_rollback();
		    return FALSE;
		}else {
		    # Everything is Perfect. 
		    # Committing data to the database.
		    $this->db->trans_commit();
		    return TRUE;
		}
   }

}
