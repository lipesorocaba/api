<?php

class Usuarios extends model{

    private $UsuarioInfo;
    private $Permissao;
    private $cadastros; 
    
    public function verificarLogin(){
        
        if(isset($_SESSION['loguser']) && !empty($_SESSION['loguser'])) {
                
			return true;
		} else {
			return false;
		}

   }
   
    public function logar($email, $senha) {
        $dados = array();
        $sql   = "SELECT * FROM tblusuario WHERE email = :email AND ususenha = :senha";
        $sql   = $this->db->prepare($sql);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":senha", $senha);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $dados = $sql->fetch();
            $_SESSION['loguser'] = $dados['usucod'];
            $_SESSION['logMembro'] = $dados['membro'];
            $_SESSION['usulogin'] = $dados['usulogin'];

            
            $tempolimite = 600;
            $_SESSION['registro'] = time();
            $_SESSION['limite'] = $tempolimite;

            date_default_timezone_set("Brazil/East");
            $data = date ("Y-m-d");
            $usucod = $_SESSION['loguser'];
            $sql="UPDATE tblusuario SET ultimoacesso =:data WHERE usucod = :usucod";
            $sql =$this->db->prepare($sql);
            $sql->bindValue(":data", $data);
            $sql->bindValue(":usucod", $usucod);
            $sql->execute();
            
            return true;
        }else{
            return false;
        }
    }
    public function UsuarioLogado(){
        $dados = array();

        if(isset($_SESSION['loguser']) && !empty($_SESSION['loguser'])){
            $id = $_SESSION['loguser'];

            $sql ="SELECT * FROM tblusuario INNER JOIN tblpermissaogroup 
            ON tblusuario.grupo_permissao = tblpermissaogroup.Codigo WHERE usucod=:id";
            $sql =$this->db->prepare($sql);
            $sql->bindValue(":id", $id);
            $sql->execute();
            
            if($sql->rowCount()>0){
                $this->UsuarioInfo = $sql->fetch();
                $this->Permissao = new Permissao();
                $this->Permissao->setGrupo($this->UsuarioInfo['grupo_permissao'], $this->UsuarioInfo['codigo_igreja']);
               
            }
        }

    }
    public function getInfoUsuario(){
        $dados = array();

        $dados = $this->UsuarioInfo;
        return $dados;

    }
    public function getIgreja(){
        if(isset($this->UsuarioInfo['codigo_igreja'])){
           return $this->UsuarioInfo['codigo_igreja']; 
       }else{
        return 0;
       }
        
    }
    
    public function getNome(){
        if(isset($this->UsuarioInfo['usulogin'])){
           return $this->UsuarioInfo['usulogin']; 
       }else{
        return 0;
       }
    }

    public function getPermissao($nome){
       return $this->Permissao->getPermissao($nome);        
        
    }
    public function UsuarioinGrupo($id){

        $sql = "SELECT COUNT(*) AS C FROM tblusuario WHERE grupo_permissao = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id',$id);
        $sql->execute();
        $row = $sql->fetch();
        if($row['C']=='0'){
            return false;
        }else{
            return true;
        }
    }
    public function cadastrarUsuario($usunome,$usulogin,$email,$grupo_permissao,$CodMembro,$LastUser,$update_time,$update_data,$codigo_igreja){
        $dados = array();

        $sql = "SELECT COUNT(*) AS C FROM tblusuario WHERE email = :email AND codigo_igreja = :codigo_igreja";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':email',$email);
        $sql->bindValue(':codigo_igreja',$codigo_igreja);
        $sql->execute();
        $row = $sql->fetch();
        if($row['C']=='0'){
            
            $this->cadastros = new Cadastros();
            $dados = $this->cadastros->insert_crud("tblusuario",array(
                    "usunome" => $usunome,
                    "usulogin"=> $usulogin,
                    "email" => $email,
                    "grupo_permissao" => $grupo_permissao,
                    "codigo_igreja" => $codigo_igreja,
                    "ususenha" => md5("123"),
                    "LastUser" =>$LastUser,
                    "LastUpdateDate" =>$update_data,
                    "LastUpdateTime" =>$update_time
                ));

            $sql = "SELECT usucod FROM tblusuario WHERE email = :email AND codigo_igreja = :codigo_igreja";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(':email',$email);
            $sql->bindValue(':codigo_igreja',$codigo_igreja);
            $sql->execute();

            $dados = $sql->fetch();
            $usucod = $dados['usucod'];

            $dados = $this->cadastros->update("tblmembros",array(
            "CodUsuario" => $usucod,
            "LastUser" =>$LastUser,
            "LastUpdateDate" =>$update_data,
            "LastUpdateTime" =>$update_time

            ),array("CodMembro" => $CodMembro, "codigo_igreja" =>$codigo_igreja));
        
            

        }else{
            
            $dados = "<div class='alert alert-danger text-center' role='alert'><strong>Ops!</strong> E-mail já cadastrado<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }

            return $dados;
    }
    public function editarUsuario($usunome,$usulogin,$usucod,$grupo_permissao,$CodMembro,$LastUser,$update_time,$update_data,$codigo_igreja){
        $dados = array();

          
        $this->cadastros = new Cadastros();
        $dados = $this->cadastros->update("tblusuario",array(
            "usunome" => $usunome,
            "usulogin"=> $usulogin,
            "grupo_permissao" => $grupo_permissao,
            "LastUser" =>$LastUser,
            "LastUpdateDate" =>$update_data,
            "LastUpdateTime" =>$update_time

        ),array("usucod" => $usucod, "codigo_igreja" =>$codigo_igreja));

        $dados = $this->cadastros->update("tblmembros",array(
            "CodUsuario" => $usucod,
            "LastUser" =>$LastUser,
            "LastUpdateDate" =>$update_data,
            "LastUpdateTime" =>$update_time

        ),array("CodMembro" => $CodMembro, "codigo_igreja" =>$codigo_igreja));
        
        return $dados;
    }
    public function deletarUsuario($usucod,$codigo_igreja){
        $dados = array();
        $this->cadastros = new Cadastros();
        $dados = $this->cadastros->delete("tblusuario",array("usucod" => $usucod, "codigo_igreja" =>$codigo_igreja));
        
        return $dados;
    }
    public function getcadastroMembro($codigo_igreja){
        $dados = array();
        $this->cadastros = new Cadastros();
        $dados = $this->cadastros->getCadastroMembro($codigo_igreja);
        
        return $dados;

    }
    public function adicionarFotos($fotousu,$codigo_igreja){

        if(count($fotousu)>0){

            $tipo = $fotousu['type'];
            $tmpname = md5(time().rand(0,9999)).'.jpg';
            move_uploaded_file($fotousu['tmp_name'],FOTO.$tmpname);

            list($width_orig, $height_orig) = getimagesize(FOTO.$tmpname);

            $ratio = $width_orig/$height_orig;
            $width = 140;
            $height = 140;



            if($width/$height >$ratio){
               $width = $height*$ratio;
           }else{
               $height = $width/$ratio;
           }

           $img = imagecreatetruecolor($width, $height);

           if($tipo =='image/jpeg'){
               $origi = imagecreatefromjpeg(FOTO.$tmpname); 
           }elseif($tipo =='image/png'){

               $origi = imagecreatefrompng(FOTO.$tmpname);
           }
           imagecopyresampled($img, $origi, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
           imagejpeg($img,FOTO.$tmpname,80);



           $usucod = $this->UsuarioInfo['usucod'];           
           $sql = "UPDATE tblusuario SET fotousu = :url WHERE usucod = :usucod AND codigo_igreja = :codigo_igreja";
           $sql = $this->db->prepare($sql);
           $sql->bindValue(':url',$tmpname);
           $sql->bindValue(':usucod',$usucod);
           $sql->bindValue(':codigo_igreja',$codigo_igreja);
           $sql->execute();

           if($sql->rowCount()>0){
            return true;
           } 

            

        }

    }
}?>            
        
    

