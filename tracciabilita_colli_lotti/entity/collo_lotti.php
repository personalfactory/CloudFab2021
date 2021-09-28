<?php 
	class collo_lotti{ 
		public $id; 
		public $id_collo;
		public $cod_lotto;
		public $abilitato;
		public $dt_abilitato;
		 
		//Costruttore
        public function __construct(
			$id, 
			$id_collo,
			$cod_lotto,
			$abilitato,
			$dt_abilitato){
			 
				$this->id = $id; 
				$this->id_collo = $id_collo;
				$this->cod_lotto = $cod_lotto;
				$this->abilitato = $abilitato;
				$this->dt_abilitato = $dt_abilitato; 
		 
		}
		
		//Setters
		function setId($id){
			$this->id = $id;
		} 
		function setCollo($id_collo){
			$this->id_collo = $id_collo;
		}  
		function setCodLotto($cod_lotto){
			$this->cod_lotto = $cod_lotto;
		}
		function setAbilitato($abilitato){
			$this->abilitato = $abilitato;
		}
		function setDtAbilitato($dt_abilitato){
			$this->dt_abilitato = $dt_abilitato;
		}
		
		 
		//Getters
		function getId(){
			return $this->id;
		} 
		function getCollo(){
			return $this->id_collo;
		}	
		function getCodLotto(){
			return $this->cod_lotto;
		}
		function getAbilitato(){
			return $this->abilitato;
		}	
		function getDtAbilitato(){
			return $this->dt_abilitato;
		}	 
	}
?>