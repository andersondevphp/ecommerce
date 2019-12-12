<?php
namespace Hcode;
class Model {
	private $values = [];
	// Saber o método que foi chamado.
	public function __call($name, $args) {
		$method = substr($name, 0, 3); //Pega as três posições podendo ser: get ou set.
		$fieldName = substr($name, 3, strlen($name)); // Pega o restante.
		// Verifica se o métod é get ou set.
		switch ($method) {
			case 'get':
				return $this->values[$fieldName];
				break;
			case 'set':
				$this->values[$fieldName] = $args[0];
				break;
		}
	}
	// Pega todos os campos do banco de dados dinamicamente, criando um atributo para cada um. De forma dinâmica!
	public function setData($data = array()) {
		foreach ($data as $key => $value) {
			// Junção do nome set com o nome do campo vindo na variável.
			$this->{"set" . $key}($value);
		}
	}
	public function getValues() {
		return $this->values;
	}
}