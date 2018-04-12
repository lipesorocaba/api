<?php
class Inscricao extends model{

	public function total_inscricao($codigo_igreja){
		$dados = array();

		$sql = "SELECT COUNT(*) AS total FROM tblencontroinscricao WHERE SituacaoPagto= '0' AND codigo_igreja = :codigo_igreja";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':codigo_igreja',$codigo_igreja);
		$sql->execute();
		$resultado = $sql->fetch();

		
		return $resultado;
	}
	public function total_inscrito($codigo_igreja){
		$dados = array();

		$sql = "SELECT COUNT(*) AS total FROM tblencontroinscricao WHERE SituacaoPagto= '1' AND codigo_igreja = :codigo_igreja";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':codigo_igreja',$codigo_igreja);
		$sql->execute();
		$resultado = $sql->fetch();

		
		return $resultado;
	}
	public function total_equipe($codigo_igreja){
		$dados = array();

		$sql = "SELECT COUNT(*) AS total FROM tblencontroequipe WHERE codigo_igreja = :codigo_igreja";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':codigo_igreja',$codigo_igreja);
		$sql->execute();
		$resultado = $sql->fetch();

		
		return $resultado;
	}

	public function total_vagas($codigo_igreja){
		$dados = array();

		$sql = "SELECT COUNT(Abrangencia) AS total FROM tblencontros WHERE codigo_igreja = :codigo_igreja";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':codigo_igreja',$codigo_igreja);
		$sql->execute();
		$total = $sql->fetch();

		$sql = "SELECT COUNT(MemInscritos) AS total FROM tblencontros WHERE codigo_igreja = :codigo_igreja";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':codigo_igreja',$codigo_igreja);
		$sql->execute();
		$total_inscrito = $sql->fetch();

		$resultado['total'] = ($total['total'] - ($total_inscrito['total']));
		
		return $resultado;
	}
	public function info_inscricao($codigo_igreja){
		$dados = array();

		$sql = "SELECT * FROM tblencontroinscricao WHERE codigo_igreja = :codigo_igreja";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':codigo_igreja',$codigo_igreja);
		$sql->execute();
		$resultado = $sql->fetchAll();

		
		return $resultado;
	}
	public function info_encontreiro($codigo_igreja){
		$dados = array();

		$sql = "SELECT * FROM tblencontroequipe INNER JOIN tblmembros ON tblencontroequipe.Membroequipe = tblmembros.CodMembro  WHERE codigo_igreja = :codigo_igreja";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':codigo_igreja',$codigo_igreja);
		$sql->execute();
		$resultado = $sql->fetchAll();

		
		return $resultado;
	}
}
?>