<?php

class Usuario {
	
	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

	public static function loadById($id): Usuario{
		
		$sql = new SQL();
		$results = $sql->select('SELECT * FROM tb_usuarios WHERE idusuario = :ID',[':ID'=>$id]);

		if (count($results) > 0){
			$row = $results[0];
			$usuario = new Usuario();

			$usuario->setIdusuario($row['idusuario']);
			$usuario->setDeslogin($row['deslogin']);
			$usuario->setDessenha($row['dessenha']);
			$usuario->setDtcadastro(new DateTime($row['dtcadastro']));
		} else {
			throw new Exception('Usuário não cadastrado');
		}

		return $usuario;
	}

	public static function getList(){

		$sql = new Sql();

		return $sql->select('SELECT * FROM tb_usuarios ORDER BY idusuario');
	}

	public static function search($login){

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY idusuario", [':SEARCH'=>"%$login%"]);
	}

	public static function login($login, $password): Usuario{
		$sql = new SQL();
		$results = $sql->select('SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD',[
				':LOGIN'=>$login,
				':PASSWORD'=>$password
			]);

		if (count($results) > 0){
			$row = $results[0];
			$usuario = new Usuario();

			$usuario->setIdusuario($row['idusuario']);
			$usuario->setDeslogin($row['deslogin']);
			$usuario->setDessenha($row['dessenha']);
			$usuario->setDtcadastro(new DateTime($row['dtcadastro']));
		} else {
			throw new Exception('Login e/ou senha inválidos');
		}

		return $usuario;
	}

	private function __construct(){
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