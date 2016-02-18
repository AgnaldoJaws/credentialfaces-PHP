<?php 

namespace App\Models;

use App\Db\Table;

/**
 * Class Usuarios
 * @package App\Models
 */
class Usuarios extends Table{
	
	/**
	 * @var string
	 */
	protected $table = "usuarios";
	
	/**
	 * @var string
	 */
	protected $senha;
	
	/**
	 * @param array $data
	 * @return string
	 */
	
	protected function _insert(array $data){
		
		$stmt = $this->db->prepare("Insert into ".$this->getTable()."
				(nome_aluno,ra ,celular, telefone, email,  senha, mailing, ativo, data_cadastro) 
				Values(:nome_aluno,:ra,:celular, :telefone, :email,:senha, :mailing,  :ativo, :data_cadastro)"
        );
		
		
		$stmt->bindParam(":nome_aluno", $data['nome_aluno']);
		$stmt->bindParam(":ra", $data['ra']);
		$stmt->bindParam(":celular", $data['celular']);
		$stmt->bindParam(":telefone", $data['telefone']);
		$stmt->bindParam(":email", $data['email']);
		
		$stmt->bindParam(":mailing", $data['mailing']);
		//Crypt Senha
		$senha = (base64_encode($data['senha']));
		
		$stmt->bindParam(":senha", $senha);
		$stmt->bindParam(":ativo", $data['ativo']);
		
		
		$stmt->bindParam(":data_cadastro",$agora);
		
		$stmt->execute();
		
		return $this->db->lastInsertId();
		
	}
	
	/**
	 * @param $email
	 * @return array
	 */
	public function findByEmail($email)
	{
		$stmt = $this->db->prepare("select * from ".$this->getTable()." where email=:email");
		$stmt->bindParam(":email", $email);
		$stmt->execute();
	
		return array(
				'fetch' => $stmt->fetch(),
				'rows'  => $stmt->rowCount()
		);
	}
	
	/**
	 * @param array $data
	 * @return mixed
	 */
	public function _activate($id) {
		$stmt = $this->db->prepare("update ".$this->getTable()."
            set ativo=:ativo where id=:id"
				);
		$ativo = 1;
		$stmt->bindParam(":id", $id);
		$stmt->bindParam(":ativo", $ativo);
		$stmt->execute();
		return $id;
	}
	
	/**
	 * @param $email
	 * @param $senha
	 * @return array
	 */
	public function _login($email, $senha)
	{
	
		$stmt = $this->db->prepare("select * from ".$this->getTable()." where email=:email and senha=:senha and ativo=:ativo");
		$ativo = 1;
		$stmt->bindParam(":senha", $senha);
		$stmt->bindParam(":email", $email);
		$stmt->bindParam(":ativo", $ativo);
		$stmt->execute();
	
		return array(
				'fetch' => $stmt->fetch(),
				'rows'  => $stmt->rowCount()
		);
	}
	
	
}
