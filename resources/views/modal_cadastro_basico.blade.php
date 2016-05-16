<div class="modal fade" id="{!!$modal!!}" tabindex="-1" role="dialog" aria-labelledby="id_modal_base">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="id_modal_base">Cadastro</h4>
          </div>
          <div class="modal-body">

           <div class="row">
               <div class="col-xs-4">
                   <input type="text" id="novo_valor[]" name="novo_valor[]" class="typeahead tt-query"  autocomplete="off" spellcheck="false" placeholder="Preencha a Descrição / Nome">
               </div>
         </div>

       </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="confirmar_cadastro('{!!$qual_campo!!}');" data-dismiss="modal">Confirmar</button>
      </div>
    </div>
  </div>
</div>