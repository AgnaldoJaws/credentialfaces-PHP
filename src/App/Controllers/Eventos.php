<?php

namespace App\Controllers;

use App\Di\Container;



include("../vendor/mpdf/mpdf/mpdf.php");



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

    public function listaParticipantesPdf ()
{
	if (!isset($_SESSION)) session_start();    	 
    	if (!isset($_SESSION['id'])) {    		 
    		session_destroy();		 
    	 
    	}

    	$model = Container::getClass($this->model);        
    	$participantes = $model->fetchAllParticipante($_POST);
        
        $mpdf=new \mPDF(); 
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->AddPage('L','A4');

                
       $html .= '
        <h3> Lista de participantes do evento Sintec 2016 </h3>
        <table border="1" style="width:100%">
       <tr>
        <th>Nome</th>
        <th>RA</th>
        <th>Valor</th>
        <th>Data</th>
        <th>Combo</th>
        <th>Pagamento</th>
        </tr>';
         foreach($participantes as $participante):


             $html .= '
         <tr>
         
                <td>'.$participante['nome_aluno'].'</td>
                <td>'.$participante['ra'].'</td>
                <td>'.$participante['valor'].'</td>
                 <td>'.$participante['data'].'</td>
                   <td>'.$participante['data'].'</td>
               
                <td></td>

            </tr>';
        endforeach;
        $html .= '</table>';   
                    
         
       

 
    	$mpdf->WriteHTML($html);
    	
    	
    	$mpdf->Output(); 	
    	
    	
    }
    
    public function listaParticipantes (){
    	if (!isset($_SESSION)) session_start();
    	
    	if (!isset($_SESSION['id'])) {
    	
    		session_destroy();
    	
    	
    	}
    	
    	$this->render('listaParticipantes');
    }

    public function index()
 {    	
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
