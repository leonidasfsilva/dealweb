<?php
require 'conexao.php';

// Recebe o termo de pesquisa se existir
$termo = (isset($_GET['termo'])) ? $_GET['termo'] : '';

// Verifica se o termo de pesquisa está vazio, se estiver executa uma consulta completa
if (empty($termo)) {
    $conexao = conexao::getInstance();
    $sql = 'SELECT * FROM medicos ORDER BY id';
    $stm = $conexao->prepare($sql);
    $stm->execute();
    $medicos = $stm->fetchAll(PDO::FETCH_OBJ);

} else {
    // Executa uma consulta baseada no termo de pesquisa passado como parâmetro
    $conexao = conexao::getInstance();
    $sql = 'SELECT * FROM medicos WHERE nome LIKE :nome OR crm LIKE :crm';
    $stm = $conexao->prepare($sql);
    $stm->bindValue(':nome', $termo . '%');
    $stm->bindValue(':crm', $termo . '%');
    $stm->execute();
    $medicos = $stm->fetchAll(PDO::FETCH_OBJ);
}
?>
<?php include(HEADER_TEMPLATE); ?>

<main class="container">
    <header>
        <div class="row">
            <div class="col-sm-6">
                <h2>Registros de Médicos</h2>
            </div>
            <div class="col-sm-6 text-right h2">
                <a class="btn btn-success btn-md" href="cadastro"><i class="fa fa-plus fa-fw"></i> Novo cadastro</a>
                <a class="btn btn-default btn-md" onClick="history.go(0)"><i class="fa fa-refresh fa-fw"></i> Atualizar</a>
            </div>
        </div>
    </header>
    <hr>

    <!-- Formulário de Pesquisa -->
    <div>
        <form action="" method="get" id='form-contato' class="form-horizontal">
            <div class="row">
                <div class="col-md-8 col-sm-4">
                    <input type="text" class="form-control" id="termo" name="termo" placeholder="Pesquise pelo nome do médico ou CRM">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-block btn-md text-right"><i class="fa fa-search fa-fw"></i> Pesquisar</button>
                </div>
                <div class="col-md-2">
                    <a href='painel' class="btn btn-primary btn-md btn-block text-right"><i class="fa fa-list fa-fw"></i> Listar todos</a>
                </div>
            </div>
        </form>
    </div>
    <hr>

    <?php if (!empty($medicos)) { ?>
        <div class="panel panel-primary">
            <div class="panel-heading">Lista de Registros</div>
            <div class="panel-body">
                <!-- Tabela de Clientes -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr class='active'>
                            <th>Médico</th>
                            <th>CRM</th>
                            <th>Celular</th>
                            <th></th>
                        </tr>
                        <?php foreach ($medicos as $medico) { ?>
                            <tr>
                                <td><?= $medico->nome ?></td>
                                <td><?= $medico->crm ?></td>
                                <td><?= $medico->celular ?></td>
                                <td class="text-right">
                                    <a href="detalhes.php?id=<?= $medico->id ?>" class="btn btn-primary">
                                        <i class="fa fa-eye"></i> Detalhes
                                    </a>
                                    <a href="editar.php?id=<?= $medico->id ?>" class="btn btn-warning">
                                        <i class="fa fa-pencil"></i> Editar
                                    </a>
                                    <a href="#" class="btn btn-danger btn-md" data-toggle="modal" data-target="#delete-modal" data-customer="<?= $medico->id ?>">
                                        <i class="fa fa-trash"></i> Excluir
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>

    <?php } else { ?>
        <!-- Mensagem caso não exista clientes ou não encontrado  -->
        <div class="alert alert-danger text-center">
            Nenhum registro encontrado
            <br>

        </div>
    <?php } ?>
</main>
<?php include(FOOTER_TEMPLATE); ?>
