<!--
    dados = $instancia da tabela
    titulo = Nome da label para o combo
    id_combo = Id da combo
    complemento = informacoes adicionais, exemplo quando combo multiple enviar o codigo para gerar
    comparar = quando for edicao, enviar o id gravado no banco para ele selecionar o item correspondente quando carregar a combo
-->

 <label for={{$id_combo}} class="control-label">{{$titulo}}</label>

<select name="{{$id_combo}}" {{$complemento}} class="form-control select2" style="width: 100%;">
<option  value="">(Selecionar)</option>
@foreach($dados as $item)
    <option  value="{{$item->id}}" {{$comparar == $item->id ? 'selected' : '' }}>{{$item->nome}}</option>
@endforeach
</select>