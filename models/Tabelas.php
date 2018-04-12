<?php
class Tabelas extends model{

	public function getUsuarios($codigo_igreja){
			$dados = array();

			$sql = "SELECT * FROM tblusuario INNER JOIN tblpermissaogroup ON tblusuario.grupo_permissao = tblpermissaogroup.Codigo WHERE codigo_igreja = :codigo_igreja  ";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(':codigo_igreja',$codigo_igreja);
			$sql->execute();
			$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);


			return $resultado;

	}
	public function getEstadoCivil(){
			$dados = array();

			$sql = "SELECT * FROM tblestadocivil";
			$sql = $this->db->prepare($sql);
			$sql->execute();
			$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

			return $resultado;

	}
	public function getestados(){
			$dados = array();

			$sql = "SELECT * FROM tblestados";
			$sql = $this->db->prepare($sql);
			$sql->execute();
			$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

			return $resultado;

	}
	public function getsituacoes(){
			$dados = array();

			$sql = "SELECT * FROM tblsituacoes";
			$sql = $this->db->prepare($sql);
			$sql->execute();
			$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

			return $resultado;

	}
	public function getfuncoes(){
			$dados = array();

			$sql = "SELECT * FROM tblfuncoes";
			$sql = $this->db->prepare($sql);
			$sql->execute();
			$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

			return $resultado;

	}
	public function getdepartamentos(){
			$dados = array();

			$sql = "SELECT * FROM tbldepartamentos";
			$sql = $this->db->prepare($sql);
			$sql->execute();
			$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

			return $resultado;

	}
	public function getcargos(){
			$dados = array();

			$sql = "SELECT * FROM tblcargos";
			$sql = $this->db->prepare($sql);
			$sql->execute();
			$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

			return $resultado;

	}
	public function getescolaridade(){
			$dados = array();

			$sql = "SELECT * FROM tblescolaridade";
			$sql = $this->db->prepare($sql);
			$sql->execute();
			$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

			return $resultado;

	}
	public function getprofissao(){
			$dados = array();

			$sql = "SELECT * FROM tblprofissoes";
			$sql = $this->db->prepare($sql);
			$sql->execute();
			$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

			return $resultado;

	}
	public function getformacao(){
			$dados = array();

			$sql = "SELECT * FROM tblformacao";
			$sql = $this->db->prepare($sql);
			$sql->execute();
			$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

			return $resultado;

	}
	public function getRedes(){
			$dados = array();

			$sql = "SELECT * FROM tblredes";
			$sql = $this->db->prepare($sql);
			$sql->execute();
			$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

			return $resultado;

	}
	public function getGrupos($id_pesquisa){
			$dados = array();

			$sql = "SELECT * FROM tblgrupos WHERE Rede = :id_pesquisa";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(":id_pesquisa", $id_pesquisa);
			$sql->execute();

			if($sql->rowCount()>0){
				$dados = $sql->fetchAll(PDO::FETCH_ASSOC);
			}
			
			return $dados;

	}
	public function getCelula(){
			$dados = array();

			$sql = "SELECT * FROM tblgrupos ORDER BY DescricaoGrupo ASC";
			$sql = $this->db->prepare($sql);
			$sql->execute();

			if($sql->rowCount()>0){
				$dados = $sql->fetchAll(PDO::FETCH_ASSOC);
			}
			
			return $dados;

	}

	public function getCultos(){
			$dados = array();

			$sql = "SELECT*FROM tblcultos INNER JOIN tbldiassemanas 
			WHERE tblcultos.diassemanas = tbldiassemanas.CodigoSemana ORDER BY diassemanas ASC";
			$sql = $this->db->prepare($sql);
			$sql->execute();

			if($sql->rowCount()>0){
				$dados = $sql->fetch(PDO::FETCH_ASSOC);
			}
			
			return $dados;

	}
	public function getPresenca(){
			$dados = array();

			$sql = "SELECT * FROM tblpresenca INNER JOIN tblcultos
			WHERE tblpresenca.idculto = tblcultos.Codigo ORDER BY data_culto DESC";
			$sql = $this->db->prepare($sql);
			$sql->execute();
				
			if($sql->rowCount()>0){
				$dados = $sql->fetchAll(PDO::FETCH_ASSOC);
			}
			
			return $dados;

	}
	public function getfrequencia(){
			$dados = array();

			$sql = "SELECT * FROM tblpresenca INNER JOIN tblcultos
			WHERE tblpresenca.idculto = tblcultos.Codigo ORDER BY data_culto DESC LIMIT 16";
			$sql = $this->db->prepare($sql);
			$sql->execute();
				
			foreach ($sql as $row) {
			$dados[] = date('d/m', strtotime($row['data_culto']));
			}

			$total_inverse = array_reverse($dados);
			$descricao = '"'.implode('","', $total_inverse).'"';
			return $descricao;
	}
	public function getfrequenciaAdultos(){
			$dados = array();

			$sql = "SELECT * FROM tblpresenca INNER JOIN tblcultos
			WHERE tblpresenca.idculto = tblcultos.Codigo ORDER BY data_culto DESC LIMIT 16";
			$sql = $this->db->prepare($sql);
			$sql->execute();
				
			foreach ($sql as $row) {
			$dados[] = $row['adultos'];
			}
			$total_inverse = array_reverse($dados);
			$descricao = '"'.implode('","', $total_inverse).'"';
			return $descricao;
	}

	public function getfrequenciaJovens(){
			$dados = array();

			$sql = "SELECT * FROM tblpresenca INNER JOIN tblcultos
			WHERE tblpresenca.idculto = tblcultos.Codigo ORDER BY data_culto DESC LIMIT 16";
			$sql = $this->db->prepare($sql);
			$sql->execute();
				
			foreach ($sql as $row) {
			$dados[] = $row['jovens'];
			}

			$total_inverse = array_reverse($dados);
			$descricao = '"'.implode('","', $total_inverse).'"';
			return $descricao;
	}

	public function getfrequenciaCriancas(){
			$dados = array();

			$sql = "SELECT * FROM tblpresenca INNER JOIN tblcultos
			WHERE tblpresenca.idculto = tblcultos.Codigo ORDER BY data_culto DESC LIMIT 16";
			$sql = $this->db->prepare($sql);
			$sql->execute();
				
			foreach ($sql as $row) {
			$dados[] = $row['criancas'];
			}

			$total_inverse = array_reverse($dados);
			$descricao = '"'.implode('","', $total_inverse).'"';
			return $descricao;
	}
	public function getGrupoPermissao($codigo_igreja){
			$dados = array();

			$sql = "SELECT * FROM tblpermissaogroup WHERE IgrejaGrupo = :codigo_igreja";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(':codigo_igreja',$codigo_igreja);
			$sql->execute();
			$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

			return $resultado;

	}



}
?>