<?php
require_once('conexao.php');
include(HEADER_TEMPLATE);
?>
    <main class="container">
        <div class='box-mensagem-crud'>
            <?php
            // Atribui uma conexão PDO
            $conexao = Conexao::getInstance();

            // Recebe os dados enviados pela submissão
            $acao = (isset($_POST['acao'])) ? $_POST['acao'] : '';
            $id = (isset($_POST['id'])) ? $_POST['id'] : '';
            $nome = (isset($_POST['nome'])) ? $_POST['nome'] : '';
            $crm = (isset($_POST['crm'])) ? str_replace(array('.', '-'), '', $_POST['crm']) : '';
            $celular = (isset($_POST['celular'])) ? str_replace(array('-', ' '), '', $_POST['celular']) : '';
            $especialidades = (isset($_POST['especialidades'])) ? $_POST['especialidades'] : '';


            // Valida os dados recebidos
            $mensagem = '';
            if ($acao == 'editar' && $id == '') {
                $mensagem .= '<li>ID do registro desconhecido.</li>';
            }

            // Se for ação diferente de excluir valida os dados obrigatórios
            if ($acao != 'excluir') {
                if ($nome == '' || strlen($nome) < 3) {
                    $mensagem .= '<li>Favor preencher o nome.</li>';
                }

                if ($crm == '') {
                    $mensagem .= '<li>Favor preencher o CRM.</li>';
                }

                if ($celular == '') {
                    $mensagem .= '<li>Favor preencher o celular.</li>';
                } elseif (strlen($celular) < 11) {
                    $mensagem .= '<li>Formato do celular inválido.</li>';
                }

                if ($mensagem != '') {
                    $mensagem = '<ul>' . $mensagem . '</ul>';
                    echo "<div class='alert alert-danger' role='alert'>" . $mensagem . "</div>
                     <a onClick='history.go(-1)' class='btn btn-default btn-md'><i class='fa fa-times fa-fw'></i> Fechar</a>
                     ";
                    exit();
                }
            }

            // Verifica se foi solicitada a inclusão de dados
            if ($acao == 'incluir') {
                $sql = 'INSERT INTO medicos (nome, crm, celular)
							   VALUES(:nome, :crm, :celular)';
                $stm = $conexao->prepare($sql);
                $stm->bindValue(':nome', $nome);
                $stm->bindValue(':crm', $crm);
                $stm->bindValue(':celular', $celular);
                $registro = $stm->execute();
                $last_id = $conexao->lastInsertId();

                if ($especialidades) {
                    foreach ($especialidades as $key => $value) {
                        $sql = 'INSERT INTO especialidade_medico_assoc (medico_id, especialidade_id)
							   VALUES(:medico_id, :especialidade_id)';
                        $stm = $conexao->prepare($sql);
                        $stm->bindValue(':medico_id', $last_id);
                        $stm->bindValue(':especialidade_id', $value);
                        $retorno = $stm->execute();
                    }
                }

                if ($registro) {
                    echo "<div class='alert alert-success' role='alert'>Registro efetuado com sucesso!<br>
                      Você será redirecionado em alguns segundos...<br>
                      Por favor, aguarde...</div> 
                      <i class='fa fa-spinner fa-pulse fa-3x fa-fw'></i>";
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Erro ao tentar inserir registro!</div> ";
                }

                //echo "<a href='painel.php' class='btn btn-primary'>OK</a>";
                echo "<meta http-equiv=refresh content='3;URL=painel.php'>";
            }


            // Verifica se foi solicitada a edição de dados
            if ($acao == 'editar') {
                if ($especialidades) {
                    // Exclui todas as especialidades referentes ao medico
                    $sql = 'DELETE FROM especialidade_medico_assoc WHERE medico_id = :id';
                    $stm = $conexao->prepare($sql);
                    $stm->bindValue(':id', $id);
                    $stm->execute();
                    // Recria todas as novas especialidades referentes ao medico enviadas pelo form
                    foreach ($especialidades as $key => $value) {
                        $sql = 'INSERT INTO especialidade_medico_assoc (medico_id, especialidade_id)
							   VALUES(:medico_id, :especialidade_id)';
                        $stm = $conexao->prepare($sql);
                        $stm->bindValue(':medico_id', $id);
                        $stm->bindValue(':especialidade_id', $value);
                        $stm->execute();
                    }
                }

                $sql = 'UPDATE medicos SET nome=:nome, crm=:crm, celular=:celular ';
                $sql .= ' WHERE id = :id';
                $stm = $conexao->prepare($sql);
                $stm->bindValue(':nome', $nome);
                $stm->bindValue(':crm', $crm);
                $stm->bindValue(':celular', $celular);
                $stm->bindValue(':id', $id);
                $retorno = $stm->execute();

                if ($retorno) {
                    echo "<div class='alert alert-success' role='alert'>Registro alterado com sucesso!<br>
                      Você será redirecionado em alguns segundos...<br>
                      Por favor, aguarde...</div> 
                      <i class='fa fa-spinner fa-pulse fa-3x fa-fw'></i>";
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Erro ao tentar editar registro!</div> ";
                }

                echo "<meta http-equiv=refresh content='3;URL=painel.php'>";
                //echo "<a href='painel.php' class='btn btn-primary'>OK</a>";
            }

            // Verifica se foi solicitada a exclusão dos dados
            if ($acao == 'excluir') {
                // Exclui o registro do banco de dados
                $sql = 'DELETE FROM medicos WHERE id = :id';
                $stm = $conexao->prepare($sql);
                $stm->bindValue(':id', $id);
                $retorno = $stm->execute();

                if ($retorno) {
                    echo "<div class='alert alert-success' role='alert'>Registro excluído com sucesso!<br>
                      Você será redirecionado em alguns segundos...<br>
                      Por favor, aguarde...</div> 
                      <i class='fa fa-spinner fa-pulse fa-3x fa-fw'></i>";
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Erro ao excluir registro!</div> ";
                }

                echo "<meta http-equiv=refresh content='3;URL=painel.php'>";
            }
            ?>
        </div>
    </main>
<?php include(FOOTER_TEMPLATE); ?>