<!-- Modal de Delete-->
<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content alert-danger">
            <form action="action.php" method="post" id='form-contato' enctype='multipart/form-data'>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalLabel"><i class="fa fa-exclamation-triangle fa-lg"></i> Confirmar exclusão?</h4>
                </div>
                <div class="modal-body alert-danger">
                    <p>Deseja realmente excluir este registro?</p>
                    <p>Cuidado! Esta ação não poderá ser desfeita!</p>
                </div>
                <div class="modal-footer">
                    <a id="cancel" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times fa-fw"></i> N&atilde;o, cancelar</a>
                    <button id="confirm" class="btn btn-danger" type="submit"><i class="fa fa-check fa-fw"></i> Sim, excluir</button>
                </div>
                <input type="hidden" name="acao" value="excluir">
                <input type="hidden" name="id" id="id-modal">
            </form>
        </div>
    </div>
</div> <!-- /.modal -->