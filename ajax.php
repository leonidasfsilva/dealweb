<?php
require('conexao.php');

// Atribui uma conexão PDO
$conexao = conexao::getInstance();

// Carrega as especialidades via ajax request
if (isset($_POST['acao']) && $_POST['acao'] == 'carregaEspecialidades') {
    $sql = 'SELECT * FROM especialidades ORDER BY id';
    $stm = $conexao->prepare($sql);
    $stm->execute();
    $especialidades = $stm->fetchAll(PDO::FETCH_OBJ);

    if ($especialidades) {
        $data = array(
            'result' => true,
            'especialidades' => $especialidades
        );
        echo json_encode($data);
    } else {
        $data = array(
            'result' => false,
            'especialidades' => null
        );
        echo json_encode($data);
    }
}

if (isset($_POST['acao']) && $_POST['acao'] == 'carregaEspecialidadesMedico') {
    $id = $_POST['medico_id'];
    $sql = 'SELECT * FROM especialidade_medico_assoc WHERE medico_id = ' . $id . ' ORDER BY especialidade_id';
    $stm = $conexao->prepare($sql);
    $stm->execute();
    $especialidades = $stm->fetchAll(PDO::FETCH_OBJ);

    if ($especialidades) {
        $data = array(
            'result' => true,
            'especialidades' => $especialidades
        );
        echo json_encode($data);
    } else {
        $data = array(
            'result' => false,
            'especialidades' => null
        );
        echo json_encode($data);
    }
}

if (isset($_POST['acao']) && $_POST['acao'] == 'nomeEspecialidade') {
    $id = $_POST['id'];
    $sql = 'SELECT nome FROM especialidades WHERE id = ' . $id;
    $stm = $conexao->prepare($sql);
    $stm->execute();
    $nome = $stm->fetch(PDO::FETCH_OBJ);

    if ($nome) {
        echo json_encode($nome->nome);
    } else {
        $data = array(
            'result' => false,
            'especialidade' => null
        );
        echo json_encode($data);
    }
}
