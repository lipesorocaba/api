<?php
class Agenda extends model{

	public function getAgenda(){

		$sql = "SELECT id, title, color, start, end FROM events";
		$sql = $this->db->prepare($sql);
		$sql->execute();

		$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

		return $resultado;
	}
	public function agendaCadastrar($title,$color,$start,$end){
		$dados= array();
//Converter a data e hora do formato brasileiro para o formato do Banco de Dados
		$data = explode(" ", $start);
        list($date, $hora) = $data;
        $data_sem_barra = array_reverse(explode("/", $date));
        $data_sem_barra = implode("-", $data_sem_barra);
        $start_sem_barra = $data_sem_barra . " " . $hora;
        
        $data = explode(" ", $end);
        list($date, $hora) = $data;
        $data_sem_barra = array_reverse(explode("/", $date));
        $data_sem_barra = implode("-", $data_sem_barra);
        $end_sem_barra = $data_sem_barra . " " . $hora;

        $result_events = "INSERT INTO events (title, color, start, end) VALUES ('$title', '$color', '$start_sem_barra', '$end_sem_barra')";
		$result_events = $this->db->prepare($result_events);
		$result_events->execute();

		if($result_events->rowCount()>0){
			  $dados = "<div class='alert alert-success text-center' role='alert'><strong>Sucesso!</strong> Evento foi Cadastrado<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		
		}
		return $dados;
		
	}
	public function agendaEditar($id,$title,$color,$start,$end){
		$dados= array();

		$data = explode(" ", $start);
		list($date, $hora) = $data;
		$data_sem_barra = array_reverse(explode("/", $date));
		$data_sem_barra = implode("-", $data_sem_barra);
		$start_sem_barra = $data_sem_barra . " " . $hora;
		
		$data = explode(" ", $end);
		list($date, $hora) = $data;
		$data_sem_barra = array_reverse(explode("/", $date));
		$data_sem_barra = implode("-", $data_sem_barra);
		$end_sem_barra = $data_sem_barra . " " . $hora;
		
		$result_events = "UPDATE events SET title='$title', color='$color', start='$start_sem_barra', end='$end_sem_barra' WHERE id='$id'"; 
		$result_events = $this->db->prepare($result_events);
		$result_events->execute();

		if($result_events->rowCount()){
			  $dados = "<div class='alert alert-success text-center' role='alert'><strong>Sucesso!</strong>  O Evento foi editado e salvo.<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		
		}else{
			$dados = "<div class='alert alert-danger text-center' role='alert'><strong>Ops! </strong> não foi possível atualizar, verifique os dados <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
			
		}
		
		return $dados;

	}


	
}