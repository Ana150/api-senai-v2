<?php
class modelPessoa
{
    private $_conn;
    private $_codPessoa;
    private $_nome;
    private $_sobrenome;
    private $_email;
    private $_celular;

    public function __construct($conn)
    {
        $json = file_get_contents("php://input");
        $dadosPessoa = json_decode($json);

        $this->_codPessoa = $dadosPessoa->cod_pessoa ?? null;
        $this->_nome = $dadosPessoa->nome ?? null;
        $this->_sobrenome = $dadosPessoa->sobrenome ?? null;
        $this->_email = $dadosPessoa->email ?? null ;
        $this->_celular = $dadosPessoa->celular ?? null;
        $this->_fotografia = $dadosPessoa->fotografia ?? null;

        // $this->_codPessoa = $dadosPessoa->cod_pessoa ?? null;
        // $this->_nome = $_POST["nome"] ?? null;
        // $this->_sobrenome = $_POST["sobrenome"] ?? null;
        // $this->_email = $_POST["email"] ?? null;
        // $this->_celular = $_POST["celular"] ?? null;
        // $this->_fotografia = $_FILES["fotografia"]["name"] ?? null;

        $this->_conn = $conn;
    }

    public function findAll()
    {
        $sql = "SELECT * FROM tbl_pessoa1";

        $stm = $this->_conn->prepare($sql);

        $stm->execute();

        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findById(){
        $sql = "SELECT * FROM tbl_pessoa1 WHERE cod_pessoa = ?";

        $stm = $this->_conn->prepare($sql);
        $stm->bindValue(1, $this->_codPessoa);

        $stm->execute();

        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function create(){
        $sql = "INSERT INTO tbl_pessoa1 (nome, sobrenome, email, celular, fotografia) VALUES (?, ?, ?, ?, ?)";

        $extensao = pathinfo($this->_fotografia, PATHINFO_EXTENSION);
        $novoNomeArquivo = md5(microtime()).".$extensao";

        move_uploaded_file($_FILES["fotografia"]["tmp_name"], "../upload/$novoNomeArquivo");

        $stm = $this->_conn->prepare($sql);

        $stm->bindValue(1, $this->_nome);
        $stm->bindValue(2, $this->_sobrenome);
        $stm->bindValue(3, $this->_email);
        $stm->bindValue(4, $this->_celular);
        $stm->bindValue(5, $novoNomeArquivo);

        if ($stm->execute()) {
           return "Succes";
        };
    }

    public function delete(){

        $sql = "DELETE FROM tbl_pessoa WHERE cod_pessoa = ?";

        $stmt = $this->_conn->prepare($sql);

        $stmt->bindValue(1, $this->_codPessoa);

        if ($stmt->execute()) {
            return "Dados excluídos com sucesso!";
        }

    }

    public function update(){

        $sql = "UPDATE tbl_pessoa1 SET 
        nome = ?,
        sobrenome = ?,
        email = ?,
        celular = ?,
        fotografia = ?
        WHERE cod_pessoa = ?";

        $stmt = $this->_conn->prepare($sql);

        $stmt->bindValue(1, $this->_nome);
        $stmt->bindValue(2, $this->_sobrenome);
        $stmt->bindValue(3, $this->_email);
        $stmt->bindValue(4, $this->_celular);
        $stmt->bindValue(5, $this->_fotografia);
        $stmt->bindValue(6, $this->_codPessoa);

        if ($stmt->execute()) {
            return "Dados alterados com sucesso!";
        }

    }
}
