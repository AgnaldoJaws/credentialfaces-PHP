<?php 

namespace App\Controllers;




use App\Di\Container;

use App\Controllers\Action;
use App\Fpdf\FPDF;



require 'fpdf.php';



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
    	
    	$model = Container::getClass($this->modelEvento);
    	$id = $_GET['id'];    	
    	
    	$this->view->objetos = $model->a($id);
    	$this->render('listaEvento');
    }
    
    /**
     * Método / Action de pdf
     */
    public function pdf() {
    
    	$id = $_GET['cod_aln_evt'];
    	$modelMo = Container::getClass($this->modelEvento);
    	$r = $this->view->objetos = $modelMo->ab($id);
    	$b = 'img/icon.jpg';
    	


    	$pdf = new FPDF();    	
    	$pdf->AddPage('L','A4');
    	$pdf->Ln(50);
    	$pdf->SetFont('Arial','B',25);
    	$pdf->Cell(100,6);
    	$pdf->Cell(30,6,'CERTIFICADO');
         $pdf->Image('http://www.onthebass.com.br/belavista/oquefazemos/comercialzacao-dos-produtos-min.png',15,8,45);
         //$pdf->Image('http://www.onthebass.com.br/belavista/oquefazemos/comercialzacao-dos-produtos-min.png',100,8,45);

    	foreach ($r as $r){
    		$pdf->SetFont('Arial','',15);
    		
    		$pdf->Ln(20);
    		$pdf->Cell(70, 6, 'Certificamos que o aluno (a)');
    		$pdf->Cell(100, 6, $r['nome_aluno']);
    		$pdf->Cell(40, 6, 'portador do R.A');
    		$pdf->Cell(30, 6, $r['ra']);
    		$pdf->Cell(60, 6, 'participou do');
    		$pdf->Ln(10);
    		$pdf->Cell(20, 6, 'evento');
    		$pdf->Cell(95, 6, $r['nome_evento']);
    		$pdf->Cell(52, 6, 'promovido pelo curso');
    		$pdf->Cell(94, 6, $r['curso']);
    		$pdf->Cell(52, 6, 'com');
    		$pdf->Ln(10);
    		$pdf->Cell(20, 6, 'o tema');
    		$pdf->Cell(112, 6, $r['assunto']);
    		$pdf->Cell(60, 6, 'com carga horária de');
    		$pdf->Cell(46, 6,  $r['carga_horaria']);
    		$pdf->Cell(60, 6, ', na faculdade');
    		$pdf->Ln(10);
    		$pdf->Cell(60, 6, 'UNISEPE');
    		$pdf->Cell(60, 6, 'no dia');
    		$pdf->Cell(27, 6, $r['data']);
    		$pdf->Cell(60, 6, '.');
    		$pdf->Ln(60);
    		$pdf->Cell(200, 6,'');
    		$pdf->Cell(100, 6, $r['nome_aluno']);
    		$pdf->Ln(5);
    		$pdf->Cell(215, 6, '');    		
    		$pdf->Cell(90, 6, 'Coordenador');
    		//$pdf->Cell(30, 6, $r['nome_aluno']);
    		
    		
    		
    		
    	}
    	
         


    	    	 
$pdf->Output();
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
 	
}