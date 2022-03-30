<?php

class CEP {
    private $con;

    function __construct() {
        $conexao = new Conexao();
        $this->con = $conexao->conectar();
    }

    public function getCep($cep) {
        try{
            $sql = "SELECT * FROM cep WHERE cep = :cep;";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':cep', $cep);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function insertCep($cep) {
        try{
            $id = rand(0, 100000);
            $sql = "INSERT INTO cep (
                cep,
                rua,
                bairro,
                cidade,
                uf, 
                complemento,
                id
            ) VALUES (
                :cep,
                :logradouro,
                :bairro,
                :localidade,
                :uf,
                :complemento,
                :id
            );";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':cep', $cep['cep']);
            $stmt->bindParam(':logradouro', $cep['rua']);
            $stmt->bindParam(':bairro', $cep['bairro']);
            $stmt->bindParam(':localidade', $cep['cidade']);
            $stmt->bindParam(':uf', $cep['uf']);
            $stmt->bindParam(':complemento', $cep['complemento']);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function requestHttp($url) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_FAILONERROR,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $retorno = curl_exec($ch);          
        curl_close($ch);

        return $retorno;
    }
}

