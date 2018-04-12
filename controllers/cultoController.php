<?php
class cultoController extends controller {

	public function __construct() {
        parent::__construct();
              
    }
    public function index() {    }
    public function listarReuniao(){
    	$array = array();

    	$lista = new Tabelas();
    	$array = $lista->getCultos();

    	header("Content-Type: application/json");
    	echo json_encode($array);
    }
    public function addReuniao(){


        if($_SERVER['REQUEST_METHOD'] =='GET'){

            echo 'HELLO WORD';
        }else if($_SERVER['REQUEST_METHOD'] =='POST'){
            echo 'POST';
        }
        exit;
    	               
        $json = file_get_contents('php://input');
        $data = json_decode($json);

            
            $nomeculto    = $data->nomeculto;
            $diassemanas  = $data->diassemanas;
            $Inicio       = $data->Inicio;
            $Termino      = $data->Termino;
            
            echo $nomeculto."<br/>";
            echo $diassemanas."<br/>";
            echo $Inicio."<br/>";
            echo $Termino."<br/>";
            
        
        $cultos = new Cadastros();
        $dados['info'] = $cultos->insert_crud("tblcultos", array(
          "nomeculto"=> $nomeculto, 
          "diassemanas"=>$diassemanas,
          "Inicio"=>$Inicio,
          "Termino"=>$Termino));
        
    }
    public function editReuniao(){}
	public function deleteReuniao(){}

	public function listarVisitante(){}
	public function addVisitante(){}
	public function editVisitante(){}
	public function deleteVisitante(){}




    

}