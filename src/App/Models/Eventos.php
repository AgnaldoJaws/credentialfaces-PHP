<?php

namespace App\Models;

use App\Db\Table;


/**
 * Class Artigos
 * @package App\Models
 */
class Eventos extends Table {

    /**
     * @var string
     */
    protected $table = "evento";

    /**
     * @param array $data
     * @return string
     */
    protected function _insert(array $data) {
        $stmt = $this->db->prepare(
            "INSERT INTO ".$this->getTable().
            "(curso, combo, nome_evento, palestrante, assunto,
        		local, data, ano,horario_inicio, horario_termino,
        		carga_horaria, valor) VALUES(:curso, :combo, :nome_evento, :palestrante, :assunto,
        		:local, :data, :ano, :horario_inicio, :horario_termino,
        		:carga_horaria, :valor)"
        );
       
        $stmt->bindParam(":curso", $data['curso']);
        $stmt->bindParam(":nome_evento", $data['nome_evento']);
        $stmt->bindParam(":combo", $data['combo']);
        $stmt->bindParam(":palestrante", $data['palestrante']);
        $stmt->bindParam(":assunto", $data['assunto']);
        $stmt->bindParam(":local", $data['local']);
        $stmt->bindParam(":data", $data['data']);
        $stmt->bindParam(":horario_inicio", $data['horario_inicio']);
        $stmt->bindParam(":ano", $data['ano']);
        $stmt->bindParam(":horario_termino", $data['horario_termino']);
        $stmt->bindParam(":carga_horaria", $data['carga_horaria']);
        $stmt->bindParam(":valor", $data['valor']);
        /*$stmt->bindParam(":ativo", $data['ativo']);
        $dt = new \DateTime();
        $agora =$dt->format('Y-m-d H:i:s');
        $stmt->bindParam(":data_cadastro",$agora);*/
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    /**
     * @param array $data
     * @return mixed
     */
    protected function _update(array $data) {
        $stmt = $this->db->prepare("UPDATE ".$this->getTable()."
            SET titulo=:titulo, texto=:texto, ativo=:ativo WHERE id=:id"
        );
        $stmt->bindParam(":id", $data['id']);
        $stmt->bindParam(":titulo", $data['titulo']);
        $stmt->bindParam(":texto", $data['texto']);
        $stmt->bindParam(":ativo", $data['ativo']);
        $stmt->execute();

        return $data['id'];
    }


}