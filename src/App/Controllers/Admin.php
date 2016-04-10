<?php

namespace App\Controllers;



/**
 * Class Usuario
 * @package App\Controllers
 */
class Admin extends Action
{

		public function Admin(){
			
			
			$this->render("index");
		}
		
		public function dashboard()
		{
			if (!isset($_SESSION)) session_start();
		
			if (!isset($_SESSION['id'])) {
		
				session_destroy();
		
				header("Location:/"); exit;
			}
		
			$this->render("dashboard");
		}
}