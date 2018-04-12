<?php
class Cadastros extends model{

	public function getCadastroMembro($codigo_igreja){
		
		$dados =  array();

		$sql = "SELECT tblmembros.CodMembro, tblmembros.NomeMembro,tblmembros.LastName ,tblmembros.SituacaoMembro, tblgrupos.DescricaoGrupo, tblmembros.LastUpdateDate 
			FROM tblmembros INNER JOIN tblgrupos ON tblmembros.Celula = tblgrupos.CodigoGrupo WHERE codigo_igreja =:codigo_igreja";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":codigo_igreja",$codigo_igreja);
		$sql->execute();
		$sql = $sql->fetchAll(PDO::FETCH_ASSOC); 

		foreach ($sql as $lista) {

			$dados[] = $lista;		
			# code...
		}
		return $dados;
	}

	public function getmembros(){
		$dados = array();

		$sql = "SELECT*FROM tblmembros";
		$sql = $this->db->prepare($sql);
		$sql->execute();
		$result = $sql->rowCount();

		return $result;
	}

	public function getCadastroFrequentadores(){
		
		$dados =  array();

		$sql = "SELECT tblfrequentadores.Codigo,tblfrequentadores.Status,tblfrequentadores.Batizado,tblfrequentadores.FrequentaIgr,tblfrequentadores.Nome,tblfrequentadores.update_data, tblgrupos.DescricaoGrupo FROM tblfrequentadores 
			INNER JOIN tblcelreuniao ON tblfrequentadores.Codigo = tblcelreuniao.Frequentador
			INNER JOIN tblgrupos ON tblcelreuniao.Celula = tblgrupos.CodigoGrupo";
		$sql = $this->db->prepare($sql);
		$sql->execute();
		$sql = $sql->fetchAll(PDO::FETCH_ASSOC); 

		foreach ($sql as $lista) {

			$dados[] = $lista;		
			# code...
		}
		return $dados;
	}

	public function getFrequentadores(){
		$dados = array();

		$sql = "SELECT*FROM tblfrequentadores";
		$sql = $this->db->prepare($sql);
		$sql->execute();
		$result = $sql->rowCount();

		return $result;
	}

	public function getCadastroVisitantes(){
		
		$dados =  array();

		$sql = "SELECT * FROM tblvisitante INNER JOIN tblgrupos
		WHERE tblvisitante.Celula = tblgrupos.CodigoGrupo";
		$sql = $this->db->prepare($sql);
		$sql->execute();
		$sql = $sql->fetchAll(PDO::FETCH_ASSOC); 

		foreach ($sql as $lista) {

			$dados[] = $lista;		
			# code...
		}
		return $dados;
	}



	public function getDadosMembros($id){

		$dados = array();

		$sql = "SELECT*FROM tblmembros
		INNER JOIN tblestadocivil ON tblmembros.EstadoCivilMembro = tblestadocivil.Codigo
		INNER JOIN tblsituacoes ON tblmembros.SituacaoMembro = tblsituacoes.CodigoSituacao
		INNER JOIN tblfuncoes ON tblmembros.FuncaoMembro = tblfuncoes.CodigoFuncao
		INNER JOIN tbldepartamentos ON tblmembros.DepMembro = tbldepartamentos.CodigoDep
		INNER JOIN tblcargos ON tblmembros.CargoMembro = tblcargos.CodigoCargo
		INNER JOIN tblescolaridade ON tblmembros.NivelEscolar = tblescolaridade.CodigoEsc
		INNER JOIN tblprofissoes ON tblmembros.Profissao = tblprofissoes.CodigoProf
		INNER JOIN tblformacao ON tblmembros.FormacaoAcademica = tblformacao.CodigoFor
		INNER JOIN tblredes ON tblmembros.Rede = tblredes.Codigorede
		INNER JOIN tblgrupos ON tblmembros.Celula = tblgrupos.CodigoGrupo
		WHERE CodMembro = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();
		$result= $sql->fetchAll(PDO::FETCH_ASSOC);
		return $result;
		
	}
	public function getDiscipulador($id){
		$dados = array();

		$sql = "SELECT MembroDesignado FROM tblmembros WHERE CodMembro = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();
		

		foreach ($sql as $value) {

				$id = $value['MembroDesignado'];

				echo $id;exit;

				if($id == 0){

					$result = 0;

				}else{

					$sql = "SELECT NomeMembro FROM tblmembros WHERE CodMembro = :id";
					$sql = $this->db->prepare($sql);
					$sql->bindValue(':id', $id);
					$sql->execute();
					$result= $sql->fetchAll(PDO::FETCH_ASSOC);

				}				
			
		}	
		
		return $result;


	}
	public function getDadosFrequentadores($id){

		$dados = array();

		$sql = "SELECT*FROM tblfrequentadores
		INNER JOIN tblestadocivil ON tblfrequentadores.EstadoCivil = tblestadocivil.Codigo
		INNER JOIN tblsituacoes ON tblfrequentadores.status = tblsituacoes.CodigoSituacao
		INNER JOIN tblfuncoes ON tblfrequentadores.funcao = tblfuncoes.CodigoFuncao
		INNER JOIN tblredes ON tblfrequentadores.Rede = tblredes.Codigorede
		INNER JOIN tblgrupos ON tblfrequentadores.Celula = tblgrupos.CodigoGrupo
		INNER JOIN tbldepartamentos ON tblfrequentadores.Departamento = tbldepartamentos.CodigoDep
		INNER JOIN tblescolaridade ON tblfrequentadores.NivelEscolar = tblescolaridade.CodigoEsc
		INNER JOIN tblprofissoes ON tblfrequentadores.Profissao = tblprofissoes.CodigoProf
		WHERE tblfrequentadores.Codigo = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();
		$result= $sql->fetchAll(PDO::FETCH_ASSOC);
		return $result;



	}
	public function getDadosVisitantes($id){

		$dados = array();

		$sql = "SELECT * FROM tblvisitante INNER JOIN tblgrupos
		WHERE tblvisitante.Celula = tblgrupos.CodigoGrupo AND Codigo = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();
		$result= $sql->fetchAll(PDO::FETCH_ASSOC);
		return $result;

	}
	public function buscarMembros(){
		//Recuperar o valor da palavra
			$nome = $_POST['palavra'];
			echo $nome;exit;
			
			//Pesquisar no banco de dados nome do curso referente a palavra digitada pelo usuário
			$sql = "SELECT * FROM tblmembros WHERE NomeMembro LIKE '%$nome%'";
			$sql = $this->db->prepare($sql);
			$sql->execute();
			
			if($sql->rowCount()>0){


			}
		

	}
	public function updateCadastro($array = array (),$id){
        
        if(count($array)>0){
            
            $sql ="UPDATE tblmembros SET ";
            
            $campos = array ();
            foreach ($array as $campo =>$valor){
                
                $campos[]=$campo." = '".$valor."'";                
            }
            $sql.= implode(', ', $campos);
            $sql.= " WHERE CodMembro = '".($id)."'";
            $this->db->query($sql);
            
            if($sql==TRUE){
                return "Dados foram atualizados com sucesso.";
            }
        }
    }

    public function updateCadastroFreq($array = array (),$id){
        
        if(count($array)>0){
            
            $sql ="UPDATE tblfrequentadores SET ";
            
            $campos = array ();
            foreach ($array as $campo =>$valor){
                
                $campos[]=$campo." = '".$valor."'";                
            }
            $sql.= implode(', ', $campos);
            $sql.= " WHERE Codigo = '".($id)."'";
            $this->db->query($sql);
            
            if($sql==TRUE){
                return "Dados foram atualizados com sucesso.";
            }
        }
    }
    public function pesquisaFrequentadores($id){
    	$dados =array();

    	$sql ="SELECT * FROM tblfrequentadores WHERE Codigo = :id";
    	$sql =$this->db->prepare($sql);
    	$sql->bindValue(":id",$id);
    	$sql->execute();
    	$result = $sql->fetchAll(PDO::FETCH_ASSOC); 

		foreach ($result as $lista) {

			$batismo = $lista['Batizado'];
			$nome = $lista['Nome'];
			
			if($batismo == 'N'){				
				return 'false';
				exit;
			}else{

				$sql = "SELECT*FROM tblmembros WHERE NomeMembro= :nome";
				$sql = $this->db->prepare($sql);
				$sql->bindValue(":nome",$nome);
				$sql->execute();

				if($sql->rowCount()>0){
					return 'false';
					exit;
				}else{
					return 'true';
					exit;
				}
			}	
	
		}

    }
    public function getFrequentador($id){
    	$dados =array();

    	$sql ="SELECT * FROM tblfrequentadores WHERE Codigo = :id";
    	$sql =$this->db->prepare($sql);
    	$sql->bindValue(":id",$id);
    	$sql->execute();
    	$result = $sql->fetchAll(PDO::FETCH_ASSOC); 

		return $result;
    }
    public function insert($table,$data,$id){
    	$dados = array();
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
    			$dados = "<div class='alert alert-success text-center' role='alert'><strong>Sucesso!</strong> Promoção realizada com sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";

	    		$sql ="DELETE FROM tblfrequentadores WHERE Codigo = $id";
	    		$sql= $this->db->prepare($sql);
	    		$sql->execute();

 					
			
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
                     
                     $sql= $this->db->prepare($sql);
	    		 	 $sql->execute();    					
			
				
                if($sql->rowCount()>0){
    			$dados = "<div class='alert alert-success text-center' role='alert'><strong>Sucesso!</strong> dados atualizados com sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>"; 					
			
				return $dados;
	    		}	 
                    
        }
	}
	public function query($sql){
        $query = $this->db->query($sql);
        $this->numRows = $query->rowCount();
        $this->array = $query->fetchAll();
        
    }
    public function result(){
        return $this->array;
    
    }
    public function numRows(){
        return $this->numRows;
    }	
	public function insert_crud($table,$data){
        if(!empty($table)&&( is_array($data)&& count($data)>0)){
                $sql = "INSERT INTO ".$table." SET ";
                $dados = array();
                foreach ($data as $key => $value) {
                    $dados[] = $key."='".addslashes($value)."'";
                 }
                 $sql= $sql.implode(", ", $dados);
                 $sql= $this->db->prepare($sql);
	    		 $sql->execute();    					
					
				
                if($sql->rowCount()>0){
    			$dados = "<div class='alert alert-success text-center' role='alert'><strong>Sucesso!</strong> dados inseridos com sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>"; 					
			
				return $dados;

    		}else{
    			return false;
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
    			$dados = "<div class='alert alert-success text-center' role='alert'><strong>Sucesso!</strong> dados deletados com sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>"; 					
			
				return $dados;
			}	
		}

	}
	public function inscricao($nome,$DataNasc){

		$sql = "SELECT * FROM tblencontristas WHERE Nome = :nome AND DataNasc = :DataNasc";
		$sql =$this->db->prepare($sql);
		$sql->bindValue(":nome",$nome);
    	$sql->bindValue(":DataNasc",$DataNasc);
    	$sql->execute();
    	$result = $sql->rowCount();

		if($result>0){

			return true;
		}else{
			
			return false;
		}
	}
	public function getinscricao($nome,$DataNasc){
    	$dados =array();
    	$sql = "SELECT * FROM tblencontristas WHERE Nome = :nome AND DataNasc = :DataNasc";
		$sql =$this->db->prepare($sql);
		$sql->bindValue(":nome",$nome);
    	$sql->bindValue(":DataNasc",$DataNasc);
    	$sql->execute();
    	$result = $sql->fetch(); 

		return $result;

	}
}
?>