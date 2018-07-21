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
			$usuario = new Usuario();
			$usuario->setData($results[0]);
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
			$usuario = new Usuario();
			$usuario->setData($results[0]);
		} else {
			throw new Exception('Login e/ou senha inválidos');
		}

		return $usuario;
	}

	public function setData($data){
		$this->setIdusuario($data['idusuario']);
		$this->setDeslogin($data['deslogin']);
		$this->setDessenha($data['dessenha']);
		$this->setDtcadastro(new DateTime($data['dtcadastro']));
	}

	public static function newInstance($login, $senha): Usuario{
		$usuario = new Usuario();
		$usuario->setDeslogin($login);
		$usuario->setDessenha($senha);
		return $usuario;
	}

	private function __construct(){
	}

	public function insert(){

		$sql = new Sql();

		$results = $sql->select('CALL sp_usuarios_insert(:LOGIN, :PASSWORD)',[
			':LOGIN'=>$this->getDeslogin(),
			':PASSWORD'=>$this->getDessenha()
		]);

		if (count($results) > 0){
			$this->setData($results[0]);
		}
	}

	public function update($login, $password){

		$this->setDeslogin($login);
		$this->setDessenha($password);

		$sql = new Sql();

		$sql->query('UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID',[
			':LOGIN'=>$this->getDeslogin(),
			':PASSWORD'=>$this->getDessenha(),
			':ID'=>$this->getIdUsuario()
		]);
	}

	public function getIdUsuario(): int{
		return $this->idusuario;
	}
	private function setIdusuario(int $idusuario){
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
	private function setDtcadastro(DateTime $dtcadastro){
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