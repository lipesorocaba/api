<?php

class Igreja extends model{

	private $igrejaInfo;

	public function __construct($id) {
    parent::__construct();

    	$sql =  "SELECT * FROM tbligreja WHERE Codigo=:id";
        $sql =  $this->db->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();
            
        if($sql->rowCount()>0){
             $this->igrejaInfo = $sql->fetch();
        }       

    }
    public function getNome(){
    	if(isset($this->igrejaInfo['NomeOrganizacao'])){
    		return $this->igrejaInfo['NomeOrganizacao'];
    	}else{
    		return '';
    	}
    }

}
?>