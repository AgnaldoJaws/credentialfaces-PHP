<?php 

namespace App\Controllers;




use App\Di\Container;

use App\Controllers\Action;
include("../vendor/mpdf/mpdf/mpdf.php");
require("../vendor/wideimage/WideImage.php");

    
class Index extends Action

 {
 	/**
 	 * @var string
 	 */
 	protected $model = "usuarios";
 	
 	/**
 	 * @var string
 	 */
 	protected $modelEvento = "eventos";
 	
 	
 	
 	
    /**
     * Método / Action de pdf
     */
    public function listaEvento (){
    	if (!isset($_SESSION)) session_start();
    
        if (!isset($_SESSION['id'])) {
    
            session_destroy();
    
            header("Location:/"); exit;
        }
    	$model = Container::getClass($this->modelEvento);
    	$id = $_GET['id'];    	
    	
    	$this->view->objetos = $model->a($id);
    	$this->render('listaEvento');
    }
    
    
    public function pdf()
     { 
        //Recebemos o id do alunoEvento
        $id = $_GET['cod_aln_evt'];
        //Pegamos o model eventos
        $modelMo = Container::getClass($this->modelEvento);
        //Fazemos uma consulta para retonar apenas o alunoEvento referente ao id passado
        $dadosCertificado = $this->view->objetos = $modelMo->fetchAllalunoEvento($id);

        //Montamos o bloco da consulta
        foreach ($dadosCertificado as $dadoCertificado)
         {
            $nome       = $dadoCertificado['nome_aluno'];    
            $ra         = $dadoCertificado['ra'];        
            $evento     = $dadoCertificado['nome_evento'];        
            $data       = $dadoCertificado['data'];        
            $hora       = $dadoCertificado['carga_horaria'];        
            $curso      = $dadoCertificado['curso'];        
            $tema       = $dadoCertificado['assunto'];        
            $convidado  = $dadoCertificado['palestrante'];        
        }    
    
        
     
   //Criamos o corpo do certificado em html        
    $html .=     "<style>


fieldset{
    width: 100%;
    height:820px;
    margin: 10px auto;
    color: #444;
    border: 5px solid #ccc;
    font-family: Helvetica;
    padding: 15px;
    text-align: justify;
}
 
h1{
    text-align: center;
}
 
p.sub-titulo{
    font-size: 20px;
}
 
.direita{
    text-align: right;
}
 
.center{
    text-align: center;
}
.conteudo {
    margin-top:-40px;
}


.img2 {
         width:200px;
        height:200px;
        margin-left:795px;
        
}
.Coordenador {
    margin-left:700px;
    margin-top:150px;
}

     </style><fieldset>

        

        <div class='img2'>
        
        <img class = 'logo1' src='http://www.onthebass.com.br/cf/logocf.png'/>
        </div>

        <div class='conteudo'>
         
        <h1>Certificado</h1>
        <h3> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Certificamos que o aluno (a) " .$nome. " portador do RA ".$ra. "
        paticipou do evento ".$evento.", com o (s) tema (s) ".$tema. ", ministrado pelo (s) convidado (s) ".$convidado. ", promovido pelo curso de ".$curso. " com carga horária de " .$hora. " horas, na Faculdade Unisepe na
        data de " .$data.".<h3>
        
        <h3 class='Coordenador'>Coordenador</h3>
        </div>    
     </fieldset>";


    //Criamos o objetos MPDF que faz a conversão html to pdf
    $mpdf=new \mPDF(); 
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->AddPage('L','A4');  
    // realizamos a conversão
    $mpdf->WriteHTML($html);   
    $mpdf->Output();	
    	
    }
 	/**
 	 * Método / Action de Login
 	 */
 	public function index()
 	{
 		$model = Container::getClass($this->model);
 		$this->view->erro = false;
 	
 		
 		if(count($_POST)) {
 			$senha = (base64_encode($_POST['senha']));
 	
 			$confirmaLogin = $model->_login($_POST['email'], $senha);
 	
 			if ($confirmaLogin['rows'] == 1){
 	
 				if (!isset($_SESSION)) session_start();
 	
 				$_SESSION['email'] = $confirmaLogin['fetch']['email'];
 				$_SESSION['id'] = $confirmaLogin['fetch']['id'];
 				$_SESSION['nome'] = $confirmaLogin['fetch']['nome'];
 	
 				$nome = 'agnaldobernardojunior@yahoo.com.br';
 				if ($_POST['email'] == $nome){
 				header('location:/dashboard-Admin');
 				} else {
 					header('location:/dashboard');
 					
 				}
 			} else {
 	
 				$this->view->erro = true;
 	
 			}
 	
 		}
 		
 		$this->render("index");
 	}
 	
 	public function dashboard()
 	{
 			
 		if (!isset($_SESSION)) session_start();
 	
 		if (!isset($_SESSION['id'])) {
 	
 			session_destroy();
 	
 			header("Location:/"); exit;
 		}
 		$modelMo = Container::getClass($this->modelEvento);
 		//$this->view->objetos = $modelMo->fetchAEvento();
 		$this->view->objetos = $modelMo->fetchAllEvento();
 		$this->render("dashboard");
 	}

     /**
     * Método / Action de Logout
     */
    public function logout()
    {
        session_start();
        session_destroy();
        header("Location:/"); exit;

    }
 	
}