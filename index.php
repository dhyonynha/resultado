<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('memory_limit', '-1');




class Update {
    public $score1;
    public $score2;
    public $scoreprimeiro1;
    public $scoreprimeiro2;
    public $scoresegundo1;
    public $scoresegundo2;
    public $idapostajogo;
    public $nome;
    public $eventid;
    public $escanteiocasa;
    public $escanteiofora;
    public $escanteiototal;
    public $golsdezminutos;
   //ID do jogo
    public $iddojogo;
    
    
    //BUSCA sis_apostas_jogos
    public $ajogospalpite;
    public $ajogosid;
    public $ajogosvalor;
    public $averificado2;
    public $aidaposta;
    
    // ATUALIZA ID RETORNO do verifica
    
    public $atidaposta;
    public $atcotacaovalor;
    public $atcotacaotitle;
    public $atidjogoaposta;
    
    public function Atualizar ($id,$palpite,$idaposta,$tempo){
        echo "id : $id Palpite : $palpite : id aposta $idaposta  <br>";
     
        
     

include('conexao.php');

           $update2 = "UPDATE sis_apostas_jogos  SET  acertou=1, verificado2=1,verificado=1 WHERE id=:idjogo AND tempo='$tempo' and cotacaotitle='$palpite' and verificado=0 ";    
                                    try{
$result2 = $conexao->prepare($update2);
$result2->bindParam(':idjogo', $id);
$result2->execute();
$contUp = $result2->rowCount();
}catch(PDOException $e){
echo $e;
}
if($contUp>0){
         
         
$update3 = "UPDATE sis_apostas  SET  jogosverificados=jogosverificados+1,acertos=acertos+1,verificado=1 WHERE id=:idjogos  ";    
                                    try{
$result3 = $conexao->prepare($update3);
$result3->bindParam(':idjogos', $idaposta);
$result3->execute();
$contUp = $result3->rowCount();
}catch(PDOException $e){
echo $e;
}

      
}
        
    $update4 = "UPDATE sis_apostas  SET  ganhou=1,verificado=1 WHERE id=:idjogos AND jogosverificados=acertos AND erros=0 ";    
                                    try{
$result4 = $conexao->prepare($update4);
$result4->bindParam(':idjogos', $idaposta);
$result4->execute();
$contUp4 = $result4->rowCount();
}catch(PDOException $e){
echo $e;
}    
$update4 = "UPDATE sis_apostas  SET  ganhou=0,verificado=1 WHERE id=:idjogos AND erros>0 ";    
                                    try{
$result4 = $conexao->prepare($update4);
$result4->bindParam(':idjogos', $idaposta);
$result4->execute();
$contUp4 = $result4->rowCount();
}catch(PDOException $e){
echo $e;
}    
    }
    public function Erros ($id,$palpite,$idaposta,$tempo){
        
     

include('conexao.php');

           $update2 = "UPDATE sis_apostas_jogos  SET  acertou=0, verificado2=1,verificado=1 WHERE id=:idjogo AND tempo='$tempo' and cotacaotitle='$palpite' ";    
                                    try{
$result2 = $conexao->prepare($update2);
$result2->bindParam(':idjogo', $id);
$result2->execute();
$contUp = $result2->rowCount();
}catch(PDOException $e){
echo $e;
}
if($contUp>0){
         
         
$update3 = "UPDATE sis_apostas  SET  jogosverificados=jogosverificados+1,erros=erros+1,verificado=1 WHERE id=:idjogos  ";    
                                    try{
$result3 = $conexao->prepare($update3);
$result3->bindParam(':idjogos', $idaposta);
$result3->execute();
$contUp = $result3->rowCount();
}catch(PDOException $e){
echo $e;
}

$update4 = "UPDATE sis_apostas  SET  ganhou=0 WHERE id=:idjogos AND erros>0  ";    
                                    try{
$result4 = $conexao->prepare($update4);
$result4->bindParam(':idjogos', $idaposta);
$result4->execute();
$contUp4 = $result4->rowCount();
}catch(PDOException $e){
echo $e;
}          
}
        
       
    }
    
    
    public function AnularAposta ($id,$palpite,$idaposta,$tempo){
        echo "id : $id Palpite : $palpite : id aposta $idaposta  <br>";
     $valortaxa = $this->ajogosvalor;
        
     

include('conexao.php');

           $update2 = "UPDATE sis_apostas_jogos  SET  cotacaotitle='Empate anula aposta casa esse jogo foi anulado',status=0,anularaposta=1,cotacaovalor=0.00,verificado=1,acertou=1 WHERE id=:idjogo AND tempo='$tempo' and cotacaotitle='$palpite' ";    
                                    try{
$result2 = $conexao->prepare($update2);
$result2->bindParam(':idjogo', $id);
$result2->execute();
$contUp = $result2->rowCount();
}catch(PDOException $e){
echo $e;
}
if($contUp>0){
         
         
$update3 = "UPDATE sis_apostas  SET  acertos=acertos+1,retorno=retorno/'$valortaxa',retornovalido=retornovalido/'$valortaxa',cotacao=cotacao/'$valortaxa',jogosverificados=jogosverificados+1 WHERE id=:idjogos  ";    
                                    try{
$result3 = $conexao->prepare($update3);
$result3->bindParam(':idjogos', $idaposta);
$result3->execute();
$contUp = $result3->rowCount();
}catch(PDOException $e){
echo $e;
}

$update4 = "UPDATE sis_apostas  SET  ganhou=1,verificado=1 WHERE id=:idjogos AND jogosverificados=acertos AND erros=0 ";    
                                    try{
$result4 = $conexao->prepare($update4);
$result4->bindParam(':idjogos', $idaposta);
$result4->execute();
$contUp4 = $result4->rowCount();
}catch(PDOException $e){
echo $e;
}          
}
        
       
    }
    public function Verificar (){
        $this->PegarId($this->eventid);
        $this->SisApostasJogo($this->iddojogo);
        
    }
    
    
    public function UpdateAgora($id,$palpite,$idaposta){
        $resultcasa = $this->score1;
        $resultfora = $this->score2;
        $totaldegols = $this->score1+$this->score2;
        $totalescateio = $this->escanteiototal;
        $tempocompleto = 90;
        $primeirotempo = "pt";
        $segundotempo = "st";
        
        
        if($this->scoreprimeiro1>$this->scoreprimeiro2){
            $ganhador1t = 'casa';
        }else if ($this->scoreprimeiro1<$this->scoreprimeiro2){
            $ganhador1t = 'fora';
        }else if ($this->scoreprimeiro1==$this->scoreprimeiro2){
             $ganhador1t = 'empate';
        }
        if($this->scoresegundo1>$this->scoresegundo2){
            $ganhador2t = 'casa';
        }else if ($this->scoresegundo1<$this->scoresegundo2){
            $ganhador2t = 'fora';
        }else if ($this->scoresegundo1==$this->scoresegundo2){
              $ganhador2t = 'empate';
        }
       
       
    if($palpite == "Casa"){
    if($resultcasa > $resultfora){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Empate"){
    if($resultcasa == $resultfora){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Fora"){
    if($resultcasa < $resultfora){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}


if($palpite == "Fora ou Empate"){
    if($resultcasa <= $resultfora){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Casa Vence e Fora Marca"){
    if(($resultcasa > $resultfora)&&($resultfora > 0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}


if($palpite == "Ambas Sim"){
    if(($resultcasa > 0)&&($resultfora > 0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Fora Vence e Casa Marca"){
    if(($resultcasa < $resultfora)&&($resultcasa > 0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "HANDICAP CASA (0:1)"){
    if($resultcasa-$resultfora >=2){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "HANDICAP FORA (1:0)"){
    if($resultfora-$resultcasa >=2){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "HANDICAP CASA (0:2)"){
    if($resultcasa-$resultfora >=3){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "HANDICAP FORA (2:0)"){
    if($resultfora-$resultcasa >=3){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Ambas Sim, Sem Empate"){
    if(($resultcasa > 0 && $resultfora > 0) && ($resultcasa != $resultfora)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Ambas Sim, Com Empate"){
    if(($resultcasa > 0 && $resultfora > 0) && ($resultcasa == $resultfora)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Empate 1x1"){
    if(($resultcasa == 1)&&($resultfora == 1)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Casa Vence de Zero"){
    if(($resultcasa > $resultfora)&&($resultfora == 0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Casa ou Fora"){
    if($resultcasa != $resultfora){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Fora Vence de Zero"){
    if(($resultcasa < $resultfora)&&($resultcasa == 0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Empate Sem Gol"){
    if($totaldegols == 0){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Empate Com Gol"){
    if(($totaldegols > 0 )&&($resultcasa == $resultfora)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "3 Gols e Meio Fora)"){
    if($resultfora-$resultcasa >=4){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "4 Gols e Meio Fora)"){
    if($resultfora-$resultcasa >=5){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Ambas Não"){
    if(($resultcasa == 0 OR $resultfora == 0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Casa Marca"){
    if($resultcasa > 0){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}


if($palpite == "Empate 2x2"){
    if(($resultcasa == 2)&&($resultfora == 2)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "1 ou mais gols (+0,5)"){
    if($totaldegols > 0){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}



if($palpite == "Placar Ímpar"){
    if($totaldegols > 0&& $totaldegols%2==1){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Placar Par"){
    if($totaldegols > 0 && $totaldegols%2==0){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "3 Gols e Meio Casa)"){
    if($resultcasa-$resultfora >=4){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "4 Gols e Meio Casa)"){
    if($resultcasa-$resultfora >=5){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}



if($palpite == "2 ou mais gols (+1,5)"){
    if($totaldegols > 1){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "3 ou mais gols (+2,5)"){
    if($totaldegols > 2){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "4 ou mais gols (+3,5)"){
    if($totaldegols > 3){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "5 ou mais gols (+4,5)"){
    if($totaldegols > 4){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "4 ou menos gols (-4,5)"){
    if($totaldegols < 5){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "3 ou menos gols (-3,5)"){
    if($totaldegols < 4){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "2 ou menos gols (-2,5)"){
    if($totaldegols < 3){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "1 ou menos gols (-1,5)"){
    if($totaldegols < 2){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Casa Ímpar"){
    if($resultcasa%2==1){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa Par"){
    if($resultcasa%2==0){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Fora Ímpar"){
    if($resultfora%2==1){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora Par"){
    if($resultfora%2==0){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Fora Par"){
    if($resultfora%2==0){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Fora Marca"){
    if($resultfora>0){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Casa 2x0"){
    if(($resultcasa == 2)&&($resultfora == 0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}


if($palpite == "Casa/Casa"){
    if(($ganhador1t == 'casa')&&($ganhador2t == 'casa')){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Casa/Empate"){
    if(($ganhador1t == 'casa')&&($ganhador2t == 'empate')){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa/Fora"){
    if(($ganhador1t == 'casa')&&($ganhador2t == 'fora')){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate/Casa"){
    if(($ganhador1t == 'empate')&&($ganhador2t == 'casa')){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate/Empate"){
    if(($ganhador1t == 'empate')&&($ganhador2t == 'empate')){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate/Fora"){
    if(($ganhador1t == 'empate')&&($ganhador2t == 'fora')){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora/Casa"){
    if(($ganhador1t == 'fora')&&($ganhador2t == 'casa')){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora/Empate"){
    if(($ganhador1t == 'fora')&&($ganhador2t == 'empate')){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora/Fora"){
    if(($ganhador1t == 'fora')&&($ganhador2t == 'fora')){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}


if($palpite == "Casa Marca, Fora Não "){
    if(($resultcasa > 0)&&($resultfora == 0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Fora Marca, Casa Não"){
    if(($resultfora > 0)&&($resultcasa == 0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa Não Marca"){
    if(($resultcasa == 0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora Não Marca"){
    if(($resultfora == 0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}


//placar exato
if($palpite == "Empate 4x4"){
    if(($resultcasa == 4)&&($resultfora == 4)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate 3x3"){
    if(($resultcasa == 3)&&($resultfora == 3)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate 0x0"){
    if(($resultcasa == 0)&&($resultfora == 0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa 3x04"){
    if(($resultcasa == 3)&&($resultfora == 0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa 1x0"){
    if(($resultcasa == 1)&&($resultfora == 0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa 4x0"){
    if(($resultcasa == 4)&&($resultfora == 0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa 5x0"){
    if(($resultcasa == 5)&&($resultfora == 0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora 0x1"){
    if(($resultcasa == 0)&&($resultfora == 1)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora 0x2"){
    if(($resultcasa == 0)&&($resultfora == 2)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora 0x3"){
    if(($resultcasa == 0)&&($resultfora == 3)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora 0x4"){
    if(($resultcasa == 0)&&($resultfora == 4)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora 0x5"){
    if(($resultcasa == 0)&&($resultfora == 5)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa 2x1"){
    if(($resultcasa == 2)&&($resultfora ==1)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa 3x1"){
    if(($resultcasa == 3)&&($resultfora == 1)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa 4x1"){
    if(($resultcasa == 4)&&($resultfora == 1)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa 5x1"){
    if(($resultcasa == 5)&&($resultfora == 1)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa 3x2"){
    if(($resultcasa == 3)&&($resultfora == 2)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa 4x2"){
    if(($resultcasa == 4)&&($resultfora == 2)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa 5x2"){
    if(($resultcasa == 5)&&($resultfora == 2)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa 5x3"){
    if(($resultcasa == 5)&&($resultfora == 3)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa 5x4"){
    if(($resultcasa == 5)&&($resultfora == 4)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate 5x5"){
    if(($resultcasa == 5)&&($resultfora == 5)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora 1x2"){
    if(($resultcasa == 1)&&($resultfora == 2)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora 1x3"){
    if(($resultcasa == 1)&&($resultfora == 3)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora 2x3"){
    if(($resultcasa == 2)&&($resultfora == 3)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora 1x4"){
    if(($resultcasa == 1)&&($resultfora == 4)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora 2x4"){
    if(($resultcasa == 2)&&($resultfora == 4)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora 3x4"){
    if(($resultcasa == 3)&&($resultfora == 4)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora 1x5"){
    if(($resultcasa == 1)&&($resultfora == 5)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora 2x5"){
    if(($resultcasa == 2)&&($resultfora == 5)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora 3x5"){
    if(($resultcasa == 3)&&($resultfora == 5)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora 4x5"){
    if(($resultcasa == 4)&&($resultfora == 5)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate 1x1"){
    if(($resultcasa == 1)&&($resultfora == 1)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Menos de 1 gol (-0,5)"){
    if(($totaldegols == 0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}


if($palpite == "Casa e Sim"){
    if(($resultcasa > $resultfora )&&($resultcasa > 0 && $resultfora >0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate e Sim"){
    if(($resultcasa == $resultfora )&&($resultcasa > 0 && $resultfora >0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora e Sim"){
    if(($resultcasa < $resultfora )&&($resultcasa > 0 && $resultfora >0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}


if($palpite == "Casa e Nao"){
    if(($resultcasa > $resultfora )&&($resultcasa > 0 XOR $resultfora > 0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate e Nao"){
    if(($resultcasa == $resultfora )&&($resultcasa > 0 XOR $resultfora > 0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora e Nao"){
    if(($resultcasa < $resultfora )&&($resultcasa > 0 XOR $resultfora > 0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}


if($palpite == "Casa/Casa e +1.5"){
    if(($ganhador1t == 'casa')&&($ganhador2t == 'casa')&&($totaldegols > 1)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa/Casa e +2.5"){
    if(($ganhador1t == 'casa')&&($ganhador2t == 'casa')&&($totaldegols > 2)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa/Casa e +3.5"){
    if(($ganhador1t == 'casa')&&($ganhador2t == 'casa')&&($totaldegols > 3)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa/Casa e -1.5"){
    if(($ganhador1t == 'casa')&&($ganhador2t == 'casa')&&($totaldegols < 2)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa/Casa e -2.5"){
    if(($ganhador1t == 'casa')&&($ganhador2t == 'casa')&&($totaldegols < 3)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa/Casa e -3.5"){
    if(($ganhador1t == 'casa')&&($ganhador2t == 'casa')&&($totaldegols < 4)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa/Casa e -4.5"){
    if(($ganhador1t == 'casa')&&($ganhador2t == 'casa')&&($totaldegols < 5)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Casa/Fora e +1.5"){
    if(($ganhador1t == 'casa')&&($ganhador2t == 'fora')&&($totaldegols > 1)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa/Fora e +2.5"){
    if(($ganhador1t == 'casa')&&($ganhador2t == 'fora')&&($totaldegols > 2)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa/Fora e +3.5"){
    if(($ganhador1t == 'casa')&&($ganhador2t == 'fora')&&($totaldegols > 3)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa/Fora e +4.5"){
    if(($ganhador1t == 'casa')&&($ganhador2t == 'fora')&&($totaldegols > 4)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Casa/Fora e -3.5"){
    if(($ganhador1t == 'casa')&&($ganhador2t == 'fora')&&($totaldegols < 4)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa/Fora e -4.5"){
    if(($ganhador1t == 'casa')&&($ganhador2t == 'fora')&&($totaldegols < 5)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Casa/Empate e +1.5"){
    if(($ganhador1t == 'casa')&&($ganhador2t == 'empate')&&($totaldegols >2)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa/Empate e +2.5"){
    if(($ganhador1t == 'casa')&&($ganhador2t == 'empate')&&($totaldegols >3)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa/Empate e +3.5"){
    if(($ganhador1t == 'casa')&&($ganhador2t == 'empate')&&($totaldegols >4)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa/Empate e +4.5"){
    if(($ganhador1t == 'casa')&&($ganhador2t == 'empate')&&($totaldegols >5)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Casa/Empate e -1.5"){
    if(($ganhador1t == 'casa')&&($ganhador2t == 'empate')&&($totaldegols < 2)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa/Empate e -2.5"){
    if(($ganhador1t == 'casa')&&($ganhador2t == 'empate')&&($totaldegols < 3)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa/Empate e -3.5"){
    if(($ganhador1t == 'casa')&&($ganhador2t == 'empate')&&($totaldegols < 4)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Casa/Empate e -4.5"){
    if(($ganhador1t == 'casa')&&($ganhador2t == 'empate')&&($totaldegols < 5)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Fora/Casa e +1.5"){
    if(($ganhador1t == 'fora')&&($ganhador2t == 'casa')&&($totaldegols >2)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora/Casa e +2.5"){
    if(($ganhador1t == 'fora')&&($ganhador2t == 'casa')&&($totaldegols >3)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora/Casa e +3.5"){
    if(($ganhador1t == 'fora')&&($ganhador2t == 'casa')&&($totaldegols >4)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora/Casa e +4.5"){
    if(($ganhador1t == 'fora')&&($ganhador2t == 'casa')&&($totaldegols >5)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Fora/Casa e -3.5"){
    if(($ganhador1t == 'fora')&&($ganhador2t == 'casa')&&($totaldegols <4)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora/Casa e -4.5"){
    if(($ganhador1t == 'fora')&&($ganhador2t == 'casa')&&($totaldegols <5)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}


if($palpite == "Fora/Fora e +1.5"){
    if(($ganhador1t == 'fora')&&($ganhador2t == 'fora')&&($totaldegols >2)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora/Fora e +2.5"){
    if(($ganhador1t == 'fora')&&($ganhador2t == 'fora')&&($totaldegols >3)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora/Fora e +3.5"){
    if(($ganhador1t == 'fora')&&($ganhador2t == 'fora')&&($totaldegols >4)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora/Fora e +4.5"){
    if(($ganhador1t == 'fora')&&($ganhador2t == 'fora')&&($totaldegols >5)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Fora/Fora e -1.5"){
    if(($ganhador1t == 'fora')&&($ganhador2t == 'fora')&&($totaldegols < 2)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora/Fora e -2.5"){
    if(($ganhador1t == 'fora')&&($ganhador2t == 'fora')&&($totaldegols < 3)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora/Fora e -3.5"){
    if(($ganhador1t == 'fora')&&($ganhador2t == 'fora')&&($totaldegols < 4)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora/Fora e -4.5"){
    if(($ganhador1t == 'fora')&&($ganhador2t == 'fora')&&($totaldegols < 5)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}


if($palpite == "Fora/Empate e +1.5"){
    if(($ganhador1t == 'fora')&&($ganhador2t == 'empate')&&($totaldegols > 2)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora/Empate e +2.5"){
    if(($ganhador1t == 'fora')&&($ganhador2t == 'empate')&&($totaldegols > 3)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora/Empate e +3.5"){
    if(($ganhador1t == 'fora')&&($ganhador2t == 'empate')&&($totaldegols > 4)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora/Empate e +4.5"){
    if(($ganhador1t == 'fora')&&($ganhador2t == 'empate')&&($totaldegols > 5)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}


if($palpite == "Fora/Empate e -2.5"){
    if(($ganhador1t == 'fora')&&($ganhador2t == 'empate')&&($totaldegols < 3)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora/Empate e -3.5"){
    if(($ganhador1t == 'fora')&&($ganhador2t == 'empate')&&($totaldegols < 4)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Fora/Empate e -4.5"){
    if(($ganhador1t == 'fora')&&($ganhador2t == 'empate')&&($totaldegols < 5)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Empate/Casa e +1.5"){
    if(($ganhador1t == 'empate')&&($ganhador2t == 'casa')&&($totaldegols > 2)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate/Casa e +2.5"){
    if(($ganhador1t == 'empate')&&($ganhador2t == 'casa')&&($totaldegols > 3)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate/Casa e +3.5"){
    if(($ganhador1t == 'empate')&&($ganhador2t == 'casa')&&($totaldegols > 4)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate/Casa e +4.5"){
    if(($ganhador1t == 'empate')&&($ganhador2t == 'casa')&&($totaldegols > 5)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Empate/Casa e -1.5"){
    if(($ganhador1t == 'empate')&&($ganhador2t == 'casa')&&($totaldegols < 2)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate/Casa e -2.5"){
    if(($ganhador1t == 'empate')&&($ganhador2t == 'casa')&&($totaldegols < 3)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate/Casa e -3.5"){
    if(($ganhador1t == 'empate')&&($ganhador2t == 'casa')&&($totaldegols < 4)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate/Casa e -4.5"){
    if(($ganhador1t == 'empate')&&($ganhador2t == 'casa')&&($totaldegols < 5)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Empate/Fora e +1.5"){
    if(($ganhador1t == 'empate')&&($ganhador2t == 'fora')&&($totaldegols > 2)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate/Fora e +2.5"){
    if(($ganhador1t == 'empate')&&($ganhador2t == 'fora')&&($totaldegols > 3)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate/Fora e +3.5"){
    if(($ganhador1t == 'empate')&&($ganhador2t == 'fora')&&($totaldegols > 4)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate/Fora e +4.5"){
    if(($ganhador1t == 'empate')&&($ganhador2t == 'fora')&&($totaldegols > 5)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Empate/Fora e -1.5"){
    if(($ganhador1t == 'empate')&&($ganhador2t == 'fora')&&($totaldegols < 2)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate/Fora e -2.5"){
    if(($ganhador1t == 'empate')&&($ganhador2t == 'fora')&&($totaldegols < 3)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate/Fora e -3.5"){
    if(($ganhador1t == 'empate' && $ganhador2t == 'fora') && ($totaldegols < 4)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate/Fora e -4.5"){
    if(($ganhador1t == 'empate')&&($ganhador2t == 'fora')&&($totaldegols < 5)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Empate/Empate e +1.5"){
    if(($ganhador1t == 'empate')&&($ganhador2t == 'empate')&&($totaldegols > 2)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate/Empate e +2.5"){
    if(($ganhador1t == 'empate')&&($ganhador2t == 'empate')&&($totaldegols > 3)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate/Empate e +3.5"){
    if(($ganhador1t == 'empate')&&($ganhador2t == 'empate')&&($totaldegols > 4)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate/Empate e +4.5"){
    if(($ganhador1t == 'empate')&&($ganhador2t == 'empate')&&($totaldegols > 5)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Empate/Empate e -1.5"){
if(($ganhador1t == 'empate')&&($ganhador2t == 'empate')&&($totaldegols < 2)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate/Empate e -2.5"){
if(($ganhador1t == 'empate')&&($ganhador2t == 'empate')&&($totaldegols < 3)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate/Empate e -3.5"){
if(($ganhador1t == 'empate')&&($ganhador2t == 'empate')&&($totaldegols < 4)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
if($palpite == "Empate/Empate e -4.5"){
if(($ganhador1t == 'empate')&&($ganhador2t == 'empate')&&($totaldegols < 5)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}





//PRIMEIRO TEMPO 

 if($palpite == "Casa"){
    if($this->scoreprimeiro1 > $this->scoreprimeiro2){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}

if($palpite == "Empate"){
    if($this->scoreprimeiro1 == $this->scoreprimeiro2){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}

if($palpite == "Fora"){
    if($this->scoreprimeiro1 < $this->scoreprimeiro2){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}


if($palpite == "Empate 4x4"){
    if(($this->scoreprimeiro1 == 4)&&($this->scoreprimeiro2 == 4)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Empate 3x3"){
    if(($this->scoreprimeiro1 == 3)&&($this->scoreprimeiro2 == 3)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Empate 0x0"){
    if(($this->scoreprimeiro1 == 0)&&($this->scoreprimeiro2 == 0)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Casa 3x04"){
    if(($this->scoreprimeiro1 == 3)&&($this->scoreprimeiro2 == 0)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Casa 1x0"){
    if(($this->scoreprimeiro1 == 1)&&($this->scoreprimeiro2 == 0)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Casa 4x0"){
    if(($this->scoreprimeiro1 == 4)&&($this->scoreprimeiro2 == 0)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Casa 5x0"){
    if(($this->scoreprimeiro1 == 5)&&($this->scoreprimeiro2 == 0)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Fora 0x1"){
    if(($this->scoreprimeiro1 == 0)&&($this->scoreprimeiro2 == 1)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Fora 0x2"){
    if(($this->scoreprimeiro1 == 0)&&($this->scoreprimeiro2 == 2)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Fora 0x3"){
    if(($this->scoreprimeiro1 == 0)&&($this->scoreprimeiro2 == 3)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Fora 0x4"){
    if(($this->scoreprimeiro1 == 0)&&($this->scoreprimeiro2 == 4)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Fora 0x5"){
    if(($this->scoreprimeiro1 == 0)&&($this->scoreprimeiro2 == 5)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Casa 2x1"){
    if(($this->scoreprimeiro1 == 2)&&($this->scoreprimeiro2 ==1)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Casa 3x1"){
    if(($this->scoreprimeiro1 == 3)&&($this->scoreprimeiro2 == 1)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Casa 4x1"){
    if(($this->scoreprimeiro1 == 4)&&($this->scoreprimeiro2 == 1)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Casa 5x1"){
    if(($this->scoreprimeiro1 == 5)&&($this->scoreprimeiro2 == 1)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Casa 3x2"){
    if(($this->scoreprimeiro1 == 3)&&($this->scoreprimeiro2 == 2)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Casa 4x2"){
    if(($this->scoreprimeiro1 == 4)&&($this->scoreprimeiro2 == 2)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Casa 5x2"){
    if(($this->scoreprimeiro1 == 5)&&($this->scoreprimeiro2 == 2)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Casa 5x3"){
    if(($this->scoreprimeiro1 == 5)&&($this->scoreprimeiro2 == 3)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Casa 5x4"){
    if(($this->scoreprimeiro1 == 5)&&($this->scoreprimeiro2 == 4)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Empate 5x5"){
    if(($this->scoreprimeiro1 == 5)&&($this->scoreprimeiro2 == 5)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Fora 1x2"){
    if(($this->scoreprimeiro1 == 1)&&($this->scoreprimeiro2 == 2)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Fora 1x3"){
    if(($this->scoreprimeiro1 == 1)&&($this->scoreprimeiro2 == 3)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Fora 2x3"){
    if(($this->scoreprimeiro1 == 2)&&($this->scoreprimeiro2 == 3)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Fora 1x4"){
    if(($this->scoreprimeiro1 == 1)&&($this->scoreprimeiro2 == 4)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Fora 2x4"){
    if(($this->scoreprimeiro1 == 2)&&($this->scoreprimeiro2 == 4)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Fora 3x4"){
    if(($this->scoreprimeiro1 == 3)&&($this->scoreprimeiro2 == 4)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Fora 1x5"){
    if(($this->scoreprimeiro1 == 1)&&($this->scoreprimeiro2 == 5)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Fora 2x5"){
    if(($this->scoreprimeiro1 == 2)&&($this->scoreprimeiro2 == 5)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Fora 3x5"){
    if(($this->scoreprimeiro1 == 3)&&($this->scoreprimeiro2 == 5)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Fora 4x5"){
    if(($this->scoreprimeiro1 == 4)&&($this->scoreprimeiro2 == 5)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "Empate 1x1"){
    if(($this->scoreprimeiro1 == 1)&&($this->scoreprimeiro2 == 1)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}


if($palpite == "Placar Ímpar"){
    if($totaldegols > 0 && $totaldegols%2==1){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}

if($palpite == "Placar Par"){
    if($totaldegols > 0 && $totaldegols%2==0){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}

if($palpite == "Casa ou Fora"){
    if($this->scoreprimeiro1 != $this->scoreprimeiro2){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}

if($palpite == "Fora ou Empate"){
    if($this->scoreprimeiro1 <= $this->scoreprimeiro2){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}

if($palpite == "Casa ou Empate"){
    if($this->scoreprimeiro1 >= $this->scoreprimeiro2){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}


if($palpite == "Menos de 1 gol (-0,5)"){
    if(($this->scoreprimeiro1+$this->scoreprimeiro2 == 0)){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}

if($palpite == "2 ou mais gols (+1,5)"){
    if($this->scoreprimeiro1+$this->scoreprimeiro2 > 1){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "3 ou mais gols (+2,5)"){
    if($this->scoreprimeiro1+$this->scoreprimeiro2 > 2){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "4 ou mais gols (+3,5)"){
    if($this->scoreprimeiro1+$this->scoreprimeiro2 > 3){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "5 ou mais gols (+4,5)"){
    if($this->scoreprimeiro1+$this->scoreprimeiro2 > 4){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}

if($palpite == "4 ou menos gols (-4,5)"){
    if($this->scoreprimeiro1+$this->scoreprimeiro2 < 5){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "3 ou menos gols (-3,5)"){
    if($this->scoreprimeiro1+$this->scoreprimeiro2 < 4){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "2 ou menos gols (-2,5)"){
    if($this->scoreprimeiro1+$this->scoreprimeiro2 < 3){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
if($palpite == "1 ou menos gols (-1,5)"){
    if($this->scoreprimeiro1+$this->scoreprimeiro2 < 2){
$this->Atualizar($id,$palpite,$idaposta,$primeirotempo);}else{$this->Erros($id,$palpite,$idaposta,$primeirotempo);}}
//FIM DO PRIMEIRO TEMPO


//SEGUNDO TEMPO


 if($palpite == "Casa"){
    if($this->scoresegundo1 > $this->scoresegundo2){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}

if($palpite == "Empate"){
    if($this->scoresegundo1 == $this->scoresegundo2){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}

if($palpite == "Fora"){
    if($this->scoresegundo1 < $this->scoresegundo2){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}


if($palpite == "Empate 4x4"){
    if(($this->scoresegundo1 == 4)&&($this->scoresegundo2 == 4)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Empate 3x3"){
    if(($this->scoresegundo1 == 3)&&($this->scoresegundo2 == 3)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Empate 0x0"){
    if(($this->scoresegundo1 == 0)&&($this->scoresegundo2 == 0)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Casa 3x04"){
    if(($this->scoresegundo1 == 3)&&($this->scoresegundo2 == 0)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Casa 1x0"){
    if(($this->scoresegundo1 == 1)&&($this->scoresegundo2 == 0)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Casa 4x0"){
    if(($this->scoresegundo1 == 4)&&($this->scoresegundo2 == 0)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Casa 5x0"){
    if(($this->scoresegundo1 == 5)&&($this->scoresegundo2 == 0)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Fora 0x1"){
    if(($this->scoresegundo1 == 0)&&($this->scoresegundo2 == 1)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Fora 0x2"){
    if(($this->scoresegundo1 == 0)&&($this->scoresegundo2 == 2)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Fora 0x3"){
    if(($this->scoresegundo1 == 0)&&($this->scoresegundo2 == 3)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Fora 0x4"){
    if(($this->scoresegundo1 == 0)&&($this->scoresegundo2 == 4)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Fora 0x5"){
    if(($this->scoresegundo1 == 0)&&($this->scoresegundo2 == 5)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Casa 2x1"){
    if(($this->scoresegundo1 == 2)&&($this->scoresegundo2 ==1)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Casa 3x1"){
    if(($this->scoresegundo1 == 3)&&($this->scoresegundo2 == 1)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Casa 4x1"){
    if(($this->scoresegundo1 == 4)&&($this->scoresegundo2 == 1)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Casa 5x1"){
    if(($this->scoresegundo1 == 5)&&($this->scoresegundo2 == 1)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Casa 3x2"){
    if(($this->scoresegundo1 == 3)&&($this->scoresegundo2 == 2)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Casa 4x2"){
    if(($this->scoresegundo1 == 4)&&($this->scoresegundo2 == 2)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Casa 5x2"){
    if(($this->scoresegundo1 == 5)&&($this->scoresegundo2 == 2)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Casa 5x3"){
    if(($this->scoresegundo1 == 5)&&($this->scoresegundo2 == 3)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Casa 5x4"){
    if(($this->scoresegundo1 == 5)&&($this->scoresegundo2 == 4)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Empate 5x5"){
    if(($this->scoresegundo1 == 5)&&($this->scoresegundo2 == 5)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Fora 1x2"){
    if(($this->scoresegundo1 == 1)&&($this->scoresegundo2 == 2)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Fora 1x3"){
    if(($this->scoresegundo1 == 1)&&($this->scoresegundo2 == 3)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Fora 2x3"){
    if(($this->scoresegundo1 == 2)&&($this->scoresegundo2 == 3)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Fora 1x4"){
    if(($this->scoresegundo1 == 1)&&($this->scoresegundo2 == 4)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Fora 2x4"){
    if(($this->scoresegundo1 == 2)&&($this->scoresegundo2 == 4)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Fora 3x4"){
    if(($this->scoresegundo1 == 3)&&($this->scoresegundo2 == 4)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Fora 1x5"){
    if(($this->scoresegundo1 == 1)&&($this->scoresegundo2 == 5)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Fora 2x5"){
    if(($this->scoresegundo1 == 2)&&($this->scoresegundo2 == 5)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Fora 3x5"){
    if(($this->scoresegundo1 == 3)&&($this->scoresegundo2 == 5)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Fora 4x5"){
    if(($this->scoresegundo1 == 4)&&($this->scoresegundo2 == 5)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "Empate 1x1"){
    if(($this->scoresegundo1 == 1)&&($this->scoresegundo2 == 1)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}


if($palpite == "Placar Ímpar"){
    if($totaldegols > 0 && $totaldegols%2==1){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}

if($palpite == "Placar Par"){
    if($totaldegols > 0 && $totaldegols%2==0){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}

if($palpite == "Casa ou Fora"){
    if($this->scoresegundo1 != $this->scoresegundo2){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}

if($palpite == "Fora ou Empate"){
    if($this->scoresegundo1 <= $this->scoresegundo2){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}

if($palpite == "Casa ou Empate"){
    if($this->scoresegundo1 >= $this->scoresegundo2){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}


if($palpite == "Menos de 1 gol (-0,5)"){
    if(($this->scoresegundo1+$this->scoresegundo2 == 0)){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}

if($palpite == "2 ou mais gols (+1,5)"){
    if($this->scoresegundo1+$this->scoresegundo2 > 1){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "3 ou mais gols (+2,5)"){
    if($this->scoresegundo1+$this->scoresegundo2 > 2){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "4 ou mais gols (+3,5)"){
    if($this->scoresegundo1+$this->scoresegundo2 > 3){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "5 ou mais gols (+4,5)"){
    if($this->scoresegundo1+$this->scoresegundo2 > 4){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}

if($palpite == "4 ou menos gols (-4,5)"){
    if($this->scoresegundo1+$this->scoresegundo2 < 5){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "3 ou menos gols (-3,5)"){
    if($this->scoresegundo1+$this->scoresegundo2 < 4){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "2 ou menos gols (-2,5)"){
    if($this->scoresegundo1+$this->scoresegundo2 < 3){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
if($palpite == "1 ou menos gols (-1,5)"){
    if($this->scoresegundo1+$this->scoresegundo2 < 2){
$this->Atualizar($id,$palpite,$idaposta,$segundotempo);}else{$this->Erros($id,$palpite,$idaposta,$segundotempo);}}
//fim do segundo tempo



 

       //Escanteios  
  if($palpite == "Escanteios +10"){
    if($totalescateio > 10){
        $this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
 
  if($palpite == "Escanteio = 10"){
    if($totalescateio == 10){
        $this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
 
  if($palpite == "Escanteios -10"){
    if($totalescateio < 10){
        $this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
 
 if($palpite == "Escanteios -6"){
    if($totalescateio < 6){
        $this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
         
         if($palpite == "Escanteios 6-8"){
    if($totalescateio >= 6 && $totalescateio <= 8){
        $this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
 
  if($palpite == "Escanteios 9-11"){
      
    if($totalescateio >= 9 && $totalescateio <= 11){
        $this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
         
           if($palpite == "Escanteios 12-14"){
    if($totalescateio >= 12 && $totalescateio <= 14){
        $this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
         
         
           if($palpite == "Escanteios +14"){
    if($totalescateio >= 14){
        $this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
        
        
        
         if($palpite == "Gols 00:00 - 09:59 +0.5"){
    if($this->golsdezminutos == 1){
        $this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
        
         if($palpite == "Gols 00:00 - 09:59 -0.5"){
    if($this->golsdezminutos == 0){
        $this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
        
        
        
        
        if($palpite == "Empate anula aposta casa"){
    if($resultcasa > $resultfora){
        $this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else if(($resultcasa == $resultfora)){
             $this->AnularAposta($id,$palpite,$idaposta,$tempocompleto);
            }else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
        
        if($palpite == "Empate anula aposta fora"){
    if($resultfora > $resultcasa){
        $this->Atualizar($id,$palpite,$idaposta,$tempocompleto);
        
    }else if(($resultcasa == $resultfora)){
             $this->AnularAposta($id,$palpite,$idaposta,$tempocompleto);
            }else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}
        
         
        if($palpite == "Casa/Empate e Nao"){
    if(($resultcasa >= $resultfora)&&($resultcasa == 0 OR $resultfora == 0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Casa/Empate e Sim"){
    if(($resultcasa >= $resultfora)&&($resultcasa > 0 && $resultfora > 0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Casa/Fora e Nao"){
    if(($resultcasa != $resultfora)&&($resultcasa == 0 OR $resultfora == 0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Casa/Fora e Sim"){
    if(($resultcasa != $resultfora)&&($resultcasa > 0 && $resultfora > 0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Empate/Fora e nao"){
    if(($resultfora >= $resultcasa)&&($resultcasa == 0 OR $resultfora == 0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

if($palpite == "Empate/Fora e Sim"){
    if(($resultcasa <= $resultfora)&&($resultcasa > 0 && $resultfora > 0)){
$this->Atualizar($id,$palpite,$idaposta,$tempocompleto);}else{$this->Erros($id,$palpite,$idaposta,$tempocompleto);}}

        
    }
    
    public function PegarId($idevent){
include('conexao.php');
$selectOdd = 'SELECT id FROM sis_jogos  WHERE token='.$idevent.'';
    $result = $conexao->prepare($selectOdd);     
    $result->execute();
         while($oddsRes = $result->FETCH(PDO::FETCH_OBJ)){ 
              $this->iddojogo = $oddsRes->id;
             
    }
    
    }//fechar fuction pegarid
   
   
    public function SisApostasJogo ($jogo){
        include('conexao.php');
$selectOdd = 'SELECT id,cotacaotitle,cotacaovalor,verificado2,aposta FROM sis_apostas_jogos  WHERE jogo='.$jogo.'  ' ;
    $result = $conexao->prepare($selectOdd);     
    $result->execute();
    
         while($oddsRes = $result->FETCH(PDO::FETCH_OBJ)){ 
              $id =$oddsRes->id;
              $palpite = $oddsRes->cotacaotitle;
              $valor = $oddsRes->cotacaovalor;
              $verificado2r = $oddsRes->verificado2;
              $idaposta = $oddsRes->aposta;
              $this->ajogosid = $id;
              $this->ajogospalpite = $palpite;
              $this->ajogosvalor = $valor;
              $this->averificado2 = $verificado2r;
              
              $this->UpdateAgora($id,$palpite,$idaposta);
             
    }
    
    }
    
    
    
    
    
}



$update = new Update();




$url = "http://93.190.139.116/~bets300/resultados/index.php";


    $page_content = file_get_contents($url);
    $response = json_decode($page_content);
    
     foreach ($response as $placar) {
         $minut = $placar->golsdezminutos;
$update->eventid = $placar->getRefImport;
$update->score1 = $placar->score1;
$update->score2 = $placar->score2;
$update->scoreprimeiro1 = $placar->timecasaplacarprimeiro;
$update->scoreprimeiro2 = $placar->timeforaplacarprimeiro;
$update->scoresegundo1 = $placar->timecasaplacarsegundo;
$update->scoresegundo2 = $placar->timeforaplacarsegundo;
$update->escanteiocasa = $placar->escanteiocasa;
$update->escanteiofora = $placar->escanteiofora;
$update->escanteiototal = $placar->escanteiocasa+$placar->escanteiofora;
$update->golsdezminutos = $minut;
$update->Verificar();

     }
     
     
     
     
     
     
     
     
     
     
     
     
     
