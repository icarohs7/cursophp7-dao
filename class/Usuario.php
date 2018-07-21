<?php

class Usuario {
	
	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

	public function loadById($id){
		
		$sql = new SQL();
		$results = $sql->select('SELECT * FROM tb_usuarios WHERE idusuario = :ID',[':ID'=>$id]);

		if (count($results) > 0){
			$row = $results[0];

			$this->setIdusuario($row['idusuario']);
			$this->setDeslogin($row['deslogin']);
			$this->setDessenha($row['dessenha']);
			$this->setDtcadastro(new DateTime($row['dtcadastro']));
		} else {
			throw new Exception('Usuário não cadastrado');
		}
	}

	public function getIdUsuario(): int{
		return $this->idusuario;
	}
	public function setIdusuario(int $idusuario){
		$this->idusuario = $idusuario;
	}

	public function getDeslogin(): string{
		return $this->deslogin;
	}
	public function setDeslogin(string $deslogin){
		$this->deslogin = $deslogin;
	}

	public function getDessenha(): string{
		return $this->dessenha;
	}
	public function setDessenha(string $dessenha){
		$this->dessenha = $dessenha;
	}

	public function getDtcadastro(): string{
		return $this->dtcadastro->format('d/m/Y H:i:s');
	}
	public function setDtcadastro(DateTime $dtcadastro){
		$this->dtcadastro = $dtcadastro;
	}

	public function __toString(): string{
		
		return json_encode([
			'idusuario'=>$this->getIdUsuario(),
			'deslogin'=>$this->getDeslogin(),
			'dessenha'=>$this->getDessenha(),
			'dtcadastro'=>$this->getDtcadastro(),
		]);
	}
}

?>