<?php
namespace Hcode;
use Rain\Tpl;
class Page {
	private $tpl;
	private $options = []; 
	private $defaults = [ // Opções, padrão.
		"data"=>[]
	];
	public function __construct($opts = array(), $tpl_dir = "/views/") {
		$this->options = array_merge($this->defaults, $opts); // Mescla os arrays. Sobrescre o defaults.
		// config
		$config = array(
			"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"] . $tpl_dir,
			"cache_dir"     => $_SERVER["DOCUMENT_ROOT"] . "/views-cache/",
			"debug"         => false // set to false to improve the speed
		);
		Tpl::configure( $config );
		$this->tpl = new Tpl;
		$this->setData($this->options["data"]);
		// Desenhando o template na tela.
		$this->tpl->draw("header"); // Nome do arquivo a ser chamado. Header porque repete em todos.
	}
	private function setData($data = array()) {
		// Percorrendo os dados na chave "data".
		foreach ($data as $key => $value) {
			$this->tpl->assign($key, $value); // Atribuição de variáveis que vão aparecer no template.
		}
	}
	// Conteúdo ou corpo da página. Mais trabalhado.
	// Epera: Nome do tamplete, Dados ou variáves a serem passadas e se retorna HTML ou se exibe na tela caso precise usar este recurso. 
	public function setTpl($name, $data = array(), $returnHTML = false) {
		$this->setData($data);
		return $this->tpl->draw($name, $returnHTML); // Desenha o conteúdo.
	}
	public function __destruct() {
		$this->tpl->draw("footer"); // chama o rodapé. Também repete em todas as páginas.
	}
}