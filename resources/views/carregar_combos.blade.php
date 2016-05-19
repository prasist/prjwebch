<!--
    dados = $instancia da tabela
    titulo = Nome da label para o combo
    id_combo = Id da combo
    complemento = informacoes adicionais, exemplo quando combo multiple enviar o codigo para gerar
    comparar = quando for edicao, enviar o id gravado no banco para ele selecionar o item correspondente quando carregar a combo
-->

 <label for={{$id_combo}} class="control-label">{{$titulo}}</label>

<!-- class="form-control selectpicker" -->
<select id="{!!$id_combo!!}" onchange="incluir_registro_combo('{!!$id_combo!!}');" placeholder="(Selecionar)" name="{!!$id_combo!!}" {!!$complemento!!} data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
<option  value=""></option>
<option  value="" data-icon="glyphicon-pencil">(+ Incluir Novo Registro)</option>
<option data-divider="true">-------------------------</option>

@foreach($dados as $item)
       <option  value="{{$item->id}}" {{$comparar==$item->id ? 'selected' : '' }}>{{$item->nome}}</option>
@endforeach
</select>