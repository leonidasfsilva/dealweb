<?php
require 'conexao.php';

// Recebe o id do cliente do cliente via GET
$medico_id = (isset($_GET['id'])) ? $_GET['id'] : '';

// Valida se existe um id e se ele é numérico
if (!empty($medico_id) && is_numeric($medico_id)) {

    // Captura os dados do medico solicitado
    $conexao = Conexao::getInstance();
    $sql = 'SELECT * FROM medicos WHERE id = :id';
    $stm = $conexao->prepare($sql);
    $stm->bindValue(':id', $medico_id);
    $stm->execute();
    $medico = $stm->fetch(PDO::FETCH_OBJ);
}
?>

<?php include(HEADER_TEMPLATE); ?>
<main class="container">
    <h2>Editar Registro</h2>
    <hr>
    <?php if (empty($medico)) { ?>
        <h4 class="alert alert-danger text-center text-danger">Registro não encontrado!</h4>
        <a onClick="history.go(-1)" class="btn btn-default btn-md"><i class="fa fa-arrow-left fa-fw"></i> Voltar</a>

    <?php } else { ?>
        <form action="action.php" method="post" id='form-contato' enctype='multipart/form-data'>
            <div class="row">
                <div class="form-group col-md-7">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Informe o nome"
                           value="<?= $medico->nome ?>">
                    <span class='msg-erro msg-nome'></span>
                </div>
                <div class="form-group col-md-3">
                    <label for="crm">CPF</label>
                    <input type="number" class="form-control" id="crm" maxlength="14" name="crm" placeholder="Informe o CRM" value="<?= $medico->crm ?>" required>
                    <span class='msg-erro msg-cpf'></span>
                </div>
                <div class="form-group col-md-2">
                    <label for="celular">Celular</label>
                    <input type="text" class="form-control" id="celular" maxlength="13" name="celular" placeholder="Informe o celular" value="<?= $medico->celular ?>" required>
                    <span class='msg-erro msg-celular'></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="especialidades">Especialidades</label>
                    <div id="lista-especialidades"></div>
                </div>
            </div>


            <input type="hidden" name="acao" value="editar">
            <input type="hidden" name="id" id="medico-id" value="<?= $medico->id ?>">

            <button type="submit" class="btn btn-primary btn-md" id='botao'><i class="fa fa-check"></i>
                Modificar
            </button>
            <a onClick="history.go(-1)" class="btn btn-default btn-md"><i class="fa fa-times"></i> Cancelar</a>
        </form>
    <?php } ?>
</main>
<?php include(FOOTER_TEMPLATE); ?>
<script>
    var checkbox = null;
    var array_especialidades = [];
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: {
            medico_id: $("#medico-id").val(),
            acao: 'carregaEspecialidadesMedico'
        },
        dataType: 'json',
        success: function (data) {
            if (data.result === true) {
                $.each(data.especialidades, function (key, value) {
                    array_especialidades[key] = value.especialidade_id
                })
            }
        },
        error: function (data) {
            alert('Erro na função carregarEspecialidadesMedico')
        }
    });

    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: {
            acao: 'carregaEspecialidades'
        },
        dataType: 'json',
        beforeSend: function () {
            $("#lista-especialidades").html("Consultando...");
        },
        success: function (data) {
            if (data.result === true) {
                $("#lista-especialidades").html("");
                $.each(data.especialidades, function (key, value) {
                    if ($.inArray(value.id, array_especialidades) !== -1) {
                        checkbox = 'checked'
                    } else {
                        checkbox = ''
                    }
                    $('#lista-especialidades').append(
                        '<div class="checkbox">\n' +
                        '    <label>\n' +
                        '        <input type="checkbox" name="especialidades[]" value="' + value.id + '" ' + checkbox + '>\n' +
                        '            ' + value.nome + '\n' +
                        '    </label>\n' +
                        '</div>\n'
                    );
                });
            } else {
                $("#lista-especialidades").html("Nenhuma especialidade registrada.");
            }
        },
        error: function (data) {
            alert('Erro na função carregarEspecialidades')
        }
    });
</script>
