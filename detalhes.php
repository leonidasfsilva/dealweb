<?php
require 'conexao.php';

// Recebe o id do cliente do cliente via GET
$id_cliente = (isset($_GET['id'])) ? $_GET['id'] : '';

// Valida se existe um id e se ele é numérico
if (!empty($id_cliente) && is_numeric($id_cliente)):

    // Captura os dados do cliente solicitado
    $conexao = conexao::getInstance();
    $sql = 'SELECT * FROM medicos WHERE id = :id';
    $stm = $conexao->prepare($sql);
    $stm->bindValue(':id', $id_cliente);
    $stm->execute();
    $medico = $stm->fetch(PDO::FETCH_OBJ);


endif;
?>

<?php include(HEADER_TEMPLATE); ?>

<main class="container">

    <h2>Detalhes do Registro</h2>
    <hr>

    <?php if (!empty($_SESSION['message'])) : ?>
        <div class="alert alert-<?php echo $_SESSION['type']; ?>"><?php echo $_SESSION['message']; ?></div>
    <?php endif; ?>

    <dl class="dl-horizontal">
        <input type="hidden" id="medico-id" value="<?= $medico->id ?>">
        <dt>Médico:</dt>
        <dd><?= $medico->nome ?></dd>

        <dt>CRM:</dt>
        <dd><?= $medico->crm ?></dd>

        <dt>Celular:</dt>
        <dd><?= $medico->celular ?></dd>
    </dl>
    <dl class="dl-horizontal">
        <dt>Especialidades:</dt>
        <dd>
            <ul id="lista-especialidades">
            </ul>
        </dd>
    </dl>

    <div id="actions" class="row">
        <div class="col-md-12">
            <a class="btn btn-default btn-md" onClick="history.go(-1)"><i class="fa fa-arrow-left fa-fw"></i> Voltar</a>
            <a class="btn btn-primary btn-md" onClick="window.print()"><i class="fa fa-print"></i> Imprimir</a>
            <a href="editar.php?id=<?= $medico->id; ?>" class="btn btn-warning btn-md"><i class="fa fa-pencil"></i> Editar</a>
        </div>
    </div>
</main>

<?php include(FOOTER_TEMPLATE); ?>

<script>
    function nomeEspecialidade(id) {
        return $.ajax({
            type: "POST",
            url: "ajax.php",
            data: {
                id: id,
                acao: 'nomeEspecialidade'
            },
            dataType: 'json'
        });
    }

    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: {
            medico_id: $("#medico-id").val(),
            acao: 'carregaEspecialidadesMedico'
        },
        dataType: 'json',
        beforeSend: function(){
            $('#lista-especialidades').html('CARREGANDO...')
        },
        success: function (data) {
            if (data.result === true) {
                setTimeout(function () {
                    $('#lista-especialidades').html('')
                },100)
                $.each(data.especialidades, function (key, value) {
                    var nome = nomeEspecialidade(value.especialidade_id)
                    setTimeout(function () {
                        $('#lista-especialidades').append(
                            '<li> \n' +
                            '      ' + nome.responseJSON + '\n' +
                            '</li>\n'
                        );
                        console.log(nome.responseJSON)
                    }, 100)
                })
            }
        },
        error: function (data) {
            alert('Erro na função carregarEspecialidadesMedico')
        }
    });

</script>