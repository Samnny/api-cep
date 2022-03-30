<?php

class Conexao
{	
	public function conectar()
	{
		try {
			$conexao = new PDO("sqlite:cep.db");
		} catch (PDOException $e) {
			echo "Erro: " . $e->getMessage();
		}
		return $conexao;
	}
}