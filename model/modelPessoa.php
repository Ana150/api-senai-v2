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
        $sql = "INSERT INTO tbl_pessoa1 (nome, sobrenome, email, celular) VALUES (?, ?, ?, ?)";

        $stm = $this->_conn->prepare($sql);

        $stm->bindValue(1, $this->_nome);
        $stm->bindValue(2, $this->_sobrenome);
        $stm->bindValue(3, $this->_email);
        $stm->bindValue(4, $this->_celular);

        if ($stm->execute()) {
           return "Succes";
        };
    }
}
