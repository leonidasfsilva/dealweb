<?php require 'conexao.php'; ?>
<?php include(HEADER_TEMPLATE); ?>

<main class="container">
    <h2>Novo Cadastro</h2>
    <hr>
    <form action="action.php" method="post" id='form-contato' enctype='multipart/form-data'>
        <div class="row">
            <div class="form-group col-md-7">
                <label for="nome">Nome do médico</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Infome o nome do médico" required autofocus>
                <span class='msg-erro msg-nome'></span>
            </div>
            <div class="form-group col-md-3">
                <label for="cpf">CRM</label>
                <input type="number" class="form-control" id="crm" maxlength="14" name="crm" placeholder="Informe o CRM" required>
                <span class='msg-erro msg-cpf'></span>
            </div>
            <div class="form-group col-md-2">
                <label for="celular">Celular</label>
                <input type="text" class="form-control" id="celular" maxlength="13" name="celular" placeholder="Informe o celular" required>
                <span class='msg-erro msg-celular'></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <label for="especialidades">Especialidades</label>
                <div id="lista-especialidades"></div>
            </div>
        </div>

        <div id="actions" class="row">
            <div class="col-md-12">
                <input type="hidden" name="acao" value="incluir">
                <button type="submit" class="btn btn-primary btn-md" id='botao'><i class="fa fa-check fa-fw"></i> Cadastrar</button>
                <a class="btn btn-default btn-md" onClick="history.go(-1)"><i class="fa fa-times fa-fw"></i> Cancelar</a>
            </div>
        </div>
    </form>
</main>

<?php include(FOOTER_TEMPLATE); ?>

<script>
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
                    $('#lista-especialidades').append(
                        '<div class="checkbox">\n' +
                        '    <label>\n' +
                        '        <input type="checkbox" name="especialidades[]" value="' + value.id + '">\n' +
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

