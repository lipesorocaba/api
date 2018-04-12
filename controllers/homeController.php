<?php
class homeController extends controller {

	public function __construct() {
        parent::__construct();
        
       $u = new Usuarios();
       $u->verificarLogin();
       
       if($u->verificarLogin() == false) {
       	header("Location: ".BASE."login");
       	exit;
       }else{
           $dados = array('erro'=>''); 

           if($_SESSION['registro']){
                   $segundos = time() - $_SESSION['registro'];
               }

               if($segundos > $_SESSION['limite']){
                       unset($_SESSION['loguser'],$_SESSION['logMembro'],$_SESSION['usulogin']);
                       $dados['erro'] = "Sessão expirada faça login novamente";
                       
                       $this->loadView('login',$dados);
                       $dados['erro'] = '';
                       exit;
               }else{

                   $_SESSION['registro'] = time();

               }
       }
       
    }
    
    public function index() {
        $dados = array(
            'usuario_nome' => ''
        );
        
        $u= new Usuarios();
        $u->UsuarioLogado();
        $igreja= new Igreja($u->getIgreja());
        $dados['igreja_nome']=$igreja->getNome();
        $dados['usuario_nome']=$u->getNome();

        //visualização das páginas
        $dados['acesso_permissao']=$u->getPermissao('pagina_permissao');
        $dados['acesso_usuario']=$u->getPermissao('pagina_usuarios');
        $dados['acesso_conf']=$u->getPermissao('pagina_configurações');
        $dados['acesso_celula']=$u->getPermissao('pagina_celulas');
        $dados['acesso_grupo']=$u->getPermissao('pagina_grupos');
        $dados['acesso_secretaria']=$u->getPermissao('pagina_secretaria');
        $dados['acesso_encontro']=$u->getPermissao('pagina_ecd');

        
        
        $this->loadTemplate('home', $dados);
               
        
    }

    

}