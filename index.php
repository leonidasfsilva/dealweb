<?php require_once('conexao.php'); ?>

<?php include(HEADER_TEMPLATE); ?>
    <main class="container">
        <h2>
            <i class="fa fa-user-md fa-fw"></i> Cadastro de Médicos
        </h2>
        <hr>
        <div class="row">
            <div class="col-xs-6 col-sm-3 col-md-2">
                <a href="cadastro" class="btn btn-primary">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <i class="fa fa-plus fa-5x"></i>
                        </div>
                        <div class="col-xs-12 btn-md text-center">
                            <p>Novo Cadastro</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xs-6 col-sm-3 col-md-2">
                <a href="painel" class="btn btn-default">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <i class="fa fa-id-card-o fa-5x"></i>
                        </div>
                        <div class="col-xs-12 btn-md text-center">
                            <p>Lista de Registros</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </main> <!-- /container -->
<?php include(FOOTER_TEMPLATE); ?>