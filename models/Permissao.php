<?php
class Permissao extends model{

	private $grupo;
	private $permissao;

	public function setGrupo($id, $codigo_igreja){
		$this->grupo = $id;
		$this->permissao = array();

		$sql ="SELECT paramGrupo FROM tblpermissaogroup WHERE Codigo = :id AND igrejaGrupo = :codigo_igreja";
		$sql =$this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->bindValue(':codigo_igreja', $codigo_igreja);
        $sql->execute();

        if($sql->rowCount()>0){
        	$row = $sql->fetch();

        	if(empty($row['paramGrupo'])){
        		$row['paramGrupo'] = '0';
        	}

        	$parametros = $row['paramGrupo'];
        	
        	$sql ="SELECT nomeParam FROM tblpermissaoparam WHERE IdParam IN ($parametros) AND codigo_igreja = :codigo_igreja";
        	$sql =$this->db->prepare($sql);
        	$sql->bindValue(':codigo_igreja', $codigo_igreja);
        	$sql->execute();

        	if($sql->rowCount()>0){
        		foreach ($sql->fetchAll() as $item) {
        		 	$this->permissao[] = $item['nomeParam'];
        		 }
        	}
        }
	}

	public function getPermissao($nome){
		if(in_array($nome, $this->permissao)){
			return true;
		}else{
			return false;
		}
	}

	public function getLista($codigo_igreja){
		$array = array();

		$sql = "SELECT*FROM tblpermissaoparam WHERE codigo_igreja = :codigo_igreja";
		$sql =$this->db->prepare($sql);
        $sql->bindValue(':codigo_igreja', $codigo_igreja);
        $sql->execute();

        if($sql->rowCount()>0){
        	$array = $sql->fetchAll();
        }
        return $array;
	}
    public function getGrupo($codigo_igreja){
        $array = array();

        $sql = "SELECT*FROM tblpermissaogroup WHERE igrejaGrupo = :codigo_igreja";
        $sql =$this->db->prepare($sql);
        $sql->bindValue(':codigo_igreja', $codigo_igreja);
        $sql->execute();

        if($sql->rowCount()>0){
            $array = $sql->fetchAll();
        }
        return $array;
    }
    public function editGrupo($id,$codigo_igreja){
        $array = array();

        $sql = "SELECT*FROM tblpermissaogroup WHERE Codigo = :id AND igrejaGrupo = :codigo_igreja";
        $sql =$this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->bindValue(':codigo_igreja', $codigo_igreja);
        $sql->execute();

        if($sql->rowCount()>0){
            $array = $sql->fetch();
            $array['paramGrupo'] = explode(',',$array['paramGrupo']);
        }
        
        return $array;
    }

    public function add($table,$data){
                if(!empty($table)&&( is_array($data)&& count($data)>0)){
                        $sql = "INSERT INTO ".$table." SET ";
                        $dados = array();
                        foreach ($data as $key => $value) {
                            $dados[] = $key."='".addslashes($value)."'";
                         }
                         $sql = $sql.implode(", ", $dados);
                         $sql= $this->db->prepare($sql);                         
                         $sql->execute();                                       
                                
                                        
                        if($sql->rowCount()>0){
                                 $dados = "<div class='alert alert-success text-center' role='alert'><strong>Sucesso!</strong> dados inseridos com sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";                                   
                                
                                        return $dados;

                         }
                }
        }
        public function delete($table, $where, $where_cond = "AND") {
                if(!empty($table) && ( is_array($where) && count($where) > 0 )) {
                        $sql = "DELETE FROM ".$table;

                        if(count($where) > 0) {
                                $dados = array();
                                foreach ($where as $key => $value) {
                                        $dados[] = $key." = '".addslashes($value)."'";
                                }
                                $sql = $sql." WHERE ".implode(" ".$where_cond." ", $dados);
                        }
 
                        $sql= $this->db->prepare($sql);

                        $sql->execute();

                        if($sql->rowCount()>0){
                                 $dados = "<div class='alert alert-success text-center' role='alert'><strong>Sucesso!</strong> dados excluidos com sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";                                   
                                
                                        return $dados;

                         }

                }
        }
        public function update($table,$data,$where = array(),$where_cond = "AND"){
            if(!empty($table)&&( is_array($data)&& count($data)>0)&& is_array($where)){
                    $sql = "UPDATE ".$table." SET ";
                    $dados = array();
                    foreach ($data as $key => $value) {
                        $dados[] = $key." = '".addslashes($value)."'";
                     }
                     $sql = $sql.implode(", ", $dados);
                                      
                     if(count($where)>0){
                         $dados = array();
                         foreach ($where as $key => $value) {
                            $dados[] = $key." = '".addslashes($value)."'";
                         }
                         $sql = $sql." WHERE ".implode(" ".$where_cond." ", $dados);
                         }
                         //echo $sql;
                         $sql= $this->db->prepare($sql);
                         $sql->execute();                       
                
                    
                    if($sql->rowCount()>0){
                    $dados = "<div class='alert alert-success text-center' role='alert'><strong>Sucesso!</strong> dados atualizados com sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";                     
                
                    return $dados;
                    }    
                        
            }
        }
    

}
?>