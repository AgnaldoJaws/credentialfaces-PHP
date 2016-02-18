<?php

namespace App\Controllers;

use App\Di\Container;

use App\Fpdf\FPDF;



require 'fpdf.php';

/**
 * Class Artigos
 * @package App\Controllers
 */
class Eventos extends Action
{
    /**
     * @var string
     */
    protected $model = "eventos";
    
    
    
    use Crud;
    
    public function listaParticipantesPdf (){
    	
    	
    	
    	if (!isset($_SESSION)) session_start();
    	 
    	if (!isset($_SESSION['id'])) {
    		 
    		session_destroy();
    		 
    		 
    	}
    	$model = Container::getClass($this->model);
    	$a = $this->view->objetos = $model->fetchAllParticipante($_POST);
    	
    	$pdf = new FPDF();
    	$pdf->AddPage('L','A4');
    	$pdf->SetFont('Arial','',15);
    
    	$pdf->Ln(10);
    	$pdf->Cell(70, 6, 'Nome',1);
    	$pdf->Cell(30, 6, 'RA',1);
    	$pdf->Cell(30, 6, 'Valor',1);
    	$pdf->Cell(30, 6, 'Data',1);
    	$pdf->Cell(30, 6, 'Pagamento',1);
    	$pdf->Cell(30, 6, 'Celo',1);
    	$pdf->Cell(30, 6, 'Carimbo',1);
		foreach ($a as $ab) {
			
			
			$pdf->Ln(6);
			
			$pdf->Cell(70, 6, $ab['nome_aluno'],1);
			$pdf->Cell(30, 6, $ab['ra'],1);		
			$pdf->Cell(30, 6, $ab['valor'],1);
			$pdf->Cell(30, 6, $ab['data'],1);
			$pdf->Cell(30, 6, '',1);
			$pdf->Cell(30, 6, '',1);
			$pdf->Cell(30, 6, '',1);
		
			
		}
    	 
    	
		$pdf->Output();
    	
    }
    
    public function listaParticipantes (){
    	if (!isset($_SESSION)) session_start();
    	
    	if (!isset($_SESSION['id'])) {
    	
    		session_destroy();
    	
    	
    	}
    	
    	$this->render('listaParticipantes');
    }
    public function index (){
    	
    if (!isset($_SESSION)) session_start();
		
			if (!isset($_SESSION['id'])) {
		
				session_destroy();
		
				
			}
			$model = Container::getClass($this->model);
			$this->view->objetos = $model->fetchAll();
			$this->render("index");
		
    }

    public function novo()
    {
        if (!isset($_SESSION)) session_start();
        if (!isset($_SESSION['id'])) {
            session_destroy();
            header("Location:/"); exit;
        }

        if(count($_POST)) {
            $model = Container::getClass($this->model);
            $model->save($_POST);
            $this->view->sucesso = true;
        }
        $this->render("novo", false);
    }

    public function edit() {

        if (!isset($_SESSION)) session_start();
        if (!isset($_SESSION['id'])) {
            session_destroy();
            header("Location:/"); exit;
        }

        $model = Container::getClass($this->model);

        if(count($_POST)) {
            $model->save($_POST);
            $this->view->sucesso = true;
        }

        if(isset($_GET['id'])) {
            $this->view->dados = $model->find($_GET['id']);
        }

        $this->render("edit", false);

    }

}