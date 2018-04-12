<?php

class Celula extends model{
    
    public function getMembro($id){
    
        $sql =         "SELECT tblmembros.NomeMembro,tblcelreuniao.Codigo
                        FROM tblmembros INNER JOIN tblcelreuniao
                        ON tblmembros.CodMembro = tblcelreuniao.Membro
                        WHERE tblcelreuniao.Lider = :id";
        
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id",$id);
        $sql-> execute();
        
        if($sql->rowCount()>0){
            $sql_membro = $sql->fetchAll();
            return $sql_membro;
    }else{
        return '';
    }
    }
    
    public function getFrequentador($id){
       
        $sql_freq ="SELECT tblfrequentadores.Nome,tblcelreuniao.Codigo
                    FROM tblfrequentadores INNER JOIN tblcelreuniao
                    ON tblfrequentadores.Codigo = tblcelreuniao.Frequentador
                    WHERE tblcelreuniao.Lider = :id AND tblcelreuniao.Membro ='0'";
        
        $sql_freq = $this->db->prepare($sql_freq);
        $sql_freq->bindValue(":id",$id);
        $sql_freq ->execute();
        
        if($sql_freq->rowCount()>0){
            $sql_freq = $sql_freq->fetchAll();
            
            return $sql_freq;
      
        }else{
            return '';
        }
        
    }
    
    public function getDadosCelula($id){
        
        $sql = "SELECT * FROM tblgrupos WHERE Lider=:id OR LiderAuxiliar=:id OR LiderAuxiliar2 =:id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id",$id);
        $sql-> execute();
        
        if($sql->rowCount()>0){
            $dados = $sql->fetch();
            
            $lider = $dados['Lider'];
            $sql = "SELECT tblmembros.NomeMembro FROM tblmembros INNER JOIN tblgrupos 
                ON tblmembros.Codmembro = tblgrupos.lider 
                WHERE tblmembros.Codmembro = '$lider'"; 
            
            $sql = $this->db->prepare($sql);
            $sql-> execute();
            if($sql->rowCount()>0){
            foreach ($sql as $key => $value) {
                $lider =$value['NomeMembro'];
            }
            }else{
                $lider = '';
            }
            
            $liderAux1 = $dados['LiderAuxiliar'];
            $sql = "SELECT tblmembros.NomeMembro FROM tblmembros INNER JOIN tblgrupos 
                ON tblmembros.Codmembro = tblgrupos.LiderAuxiliar 
                WHERE tblmembros.Codmembro = '$liderAux1'"; 
            
            $sql = $this->db->prepare($sql);
            $sql-> execute();
            if($sql->rowCount()>0){
                foreach ($sql as $key => $value) {
                $liderAux1 =$value['NomeMembro'];
            }
            }else{
                $liderAux1 = '';
            }
            
            $liderAux2 = $dados['LiderAuxiliar2'];
            $sql = "SELECT tblmembros.NomeMembro FROM tblmembros INNER JOIN tblgrupos 
                ON tblmembros.Codmembro = tblgrupos.LiderAuxiliar2 
                WHERE tblmembros.Codmembro = '$liderAux2'"; 
            
            $sql = $this->db->prepare($sql);
            $sql-> execute();
            if($sql->rowCount()>0){
            foreach ($sql as $key => $value) {
                $liderAux2 =$value['NomeMembro'];
            }
            }else{
                $liderAux2 = '';
            }
            
             $dados['lider']=$lider;
             $dados['liderAux']=$liderAux1;
             $dados['liderAux2']=$liderAux2;
            
            
            return $dados;
            
    }else{
        echo '';
    }
      
    
    
    
}

   

}
