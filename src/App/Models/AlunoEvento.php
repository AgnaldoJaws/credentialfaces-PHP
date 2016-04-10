<?php

namespace App\Models;


use App\Db\Table;


/**
 * Class Artigos
 * @package App\Models
 */
class AlunoEvento extends Table {

    /**
     * @var string
     */
    protected $table = "alunoEvento";

    /**
     * @param array $data
     * @return string
     */
    protected function _insert(array $data) {
        $stmt = $this->db->prepare(
            "INSERT INTO ".$this->getTable().
            "(id, cod_evento) VALUES (:id, :cod_evento)"
        );
       
        $stmt->bindParam(":id", $data['id']);
        $stmt->bindParam(":cod_evento", $data['cod_evento']);
        /*$stmt->bindParam(":ativo", $data['ativo']);
        $dt = new \DateTime();
        $agora =$dt->format('Y-m-d H:i:s');
        $stmt->bindParam(":data_cadastro",$agora);*/
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    

}