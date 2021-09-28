<?php 
	class colli{ 
		public $id; 
		public $codice_collo;
		public $data;
		public $dt_abilitato;
		public $associato;
		public $num_bolla;
		public $dt_bolla;
		public $abilitato;
		public $altezza;
		public $larghezza;
		public $profondita;
		public $peso;
		public $info1;
		public $info2;
		public $info3;
		public $info4;
		public $info5;
		public $id_utente;
		public $id_azienda; 
		 
		//Costruttore
        public function __construct(
			$id, 
			$codice_collo,
			$data,
			$dt_abilitato,
			$associato,
			$num_bolla,
			$dt_bolla,
			$abilitato,
			$altezza,
			$larghezza,
			$profondita,
			$peso,
			$info1,
			$info2,
			$info3,
			$info4,
			$info5,
			$id_utente,
			$id_azienda){
			 
		$this->id = $id; 
		$this->codice_collo = $codice_collo;
		$this->data = $data;
		$this->dt_abilitato = $dt_abilitato;
		$this->associato = $associato;
		$this->num_bolla = $num_bolla;
		$this->dt_bolla = $dt_bolla;
		$this->abilitato = $abilitato;
		$this->altezza = $altezza;
		$this->larghezza = $larghezza;
		$this->profondita = $profondita;
		$this->peso = $peso;
		$this->info1 = $info1;
		$this->info2 = $info2;
		$this->info3 = $info3;
		$this->info4 = $info4;
		$this->info5 = $info5;
		$this->id_utente = $id_utente;
		$this->id_azienda = $id_azienda; 
		 
		}
		
		//Setters
		function setId($id){
			$this->id = $id;
		} 
		function setCodiceCollo($codice_collo){
			$this->codice_collo = $codice_collo;
		}	
		function setData($data){
			$this->data = $data;
		}	
		function setDtAbilitato($dt_abilitato){
			$this->dt_abilitato = $dt_abilitato;
		}	
		function setAssociato($associato){
			$this->associato = $associato;
		}	
		function setNumBolla($num_bolla){
			$this->num_bolla = $num_bolla;
		}	
		function setDtBolla($dt_bolla){
			$this->dt_bolla = $dt_bolla;
		}	
		function setAbilitato($abilitato){
			$this->abilitato = $abilitato;
		}
		function setAltezza($altezza){
			$this->altezza = $altezza;
		}	
		function setLarghezza($larghezza){
			$this->larghezza = $larghezza;
		}
		function setProfondita($profondita){
			$this->profondita = $profondita;
		}	
		function setPeso($peso){
			$this->peso = $peso;
		}
		function setInfo1($info1){
			$this->info1 = $info1;
		}	
		function setInfo2($info2){
			$this->info2 = $info2;
		}	
		function setInfo3($info3){
			$this->info3 = $info3;
		}	
		function setInfo4($info4){
			$this->info4 = $info4;
		}	
		function setInfo5($info5){
			$this->info5 = $info5;
		}	
		function setIdUtente($id_utente){
			$this->id_utente = $id_utente;
		}
		function setIdAzienda( $id_azienda){
			$this->id_azienda = $id_azienda;
		}
			   
		//Getters
		function getId(){
			return $this->id;
		} 
		function getCodiceCollo(){
			return $this->codice_collo;
		}	
		function getData(){
			return $this->data;
		}	
		function getDtAbilitato(){
			return $this->dt_abilitato;
		}	
		function getAssociato(){
			return $this->associato;
		}	
		function getNumBolla(){
			return $this->num_bolla;
		}	
		function getDtBolla(){
			return $this->dt_bolla;
		}	
		function getAbilitato(){
			return $this->abilitato;
		}
		function getAltezza(){
			return $this->altezza;
		}	
		function getLarghezza(){
			return $this->larghezza;
		}
		function getProfondita(){
			return $this->profondita;
		}	
		function getPeso(){
			return $this->peso;
		}
		function getInfo1(){
			return $this->info1;
		}	
		function getInfo2(){
			return $this->info2;
		}	
		function getInfo3(){
			return $this->info3;
		}	
		function getInfo4(){
			return $this->info4;
		}	
		function getInfo5(){
			return $this->info5;
		}	
		function getIdUtente(){
			return $this->id_utente;
		}
		function getIdAzienda(){
			return $this->id_azienda;
		}
	}
?>