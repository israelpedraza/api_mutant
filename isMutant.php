<?php
//php isMutant.php 'ATGCGA,CAGTGC,TTATGT,AGAAGG,CCCCTA,TCACTG' -- true
//php isMutant.php 'ATGCGA,CAGTGC,TTATTT,AGACGG,GCGTCA,TCACTG' -- false
$dna=trim($argv[1]);
//$dna='ATGCGA,CAGTGC,TTATGT,AGAAGG,CCCCTA,TCACTG';
if( (!preg_match('/^[ATCG\,]*$/', $dna)) || ($dna=='') ){
  print "String no válido = $dna \n";
  return false;
}
$one=explode(",",$dna);
$matrix = array();
foreach ($one as $item){
    $matrix[] = str_split($item);
}
$dna_mutant_sequences=array("0"=>"AAAA","1"=>"TTTT","2"=>"CCCC","3"=>"GGGG");
for ($i = 0; $i < count($dna_mutant_sequences); $i++) {
  if(Check_horizontally($dna_mutant_sequences[$i],$matrix)){return true;};
  if(Check_vertically($dna_mutant_sequences[$i],$matrix)){return true;};
  if(Check_diagonally_LR($dna_mutant_sequences[$i],$matrix)){return true;};
  if(Check_diagonally_RL($dna_mutant_sequences[$i],$matrix)){return true;};
}
return false;

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
	            print "Match H = ".$sequence."\n";
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
	            print "Match V = ".$sequence."\n";
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
	        	  print "Match LR = ".$sequence."\n";
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
				      print "Match RL = ".$sequence."\n";
				      return true;
	        }
	    }
	}

}

?>