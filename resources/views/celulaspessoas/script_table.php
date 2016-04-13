<script type="text/javascript">
    (function($) {
      AddTableRow = function() {

        /*Não deixa adicionar sem conteudo*/
        if (document.getElementById("pessoas").value=="")
        {
            return false;
        }

        var newRow = $("<tr>");
        var cols = "";
        var strCampos="";

        var ind_celula = document.getElementById("celulas").selectedIndex;
        var texto_celula = document.getElementById("celulas").options;

        var str_celula = texto_celula[ind_celula].text;
        var bEncontrou=false;


        /*Verifica se a pessoa já não foi adicionada*/
        $('input').each(function (index, value)
        {
               var nomecampo = $(this).attr('id');
               if (nomecampo=="hidden_pessoas[]")
               {

                  var valor =  parseInt(document.getElementById("pessoas").value.substr(0,9));

                   if ($(this).attr('value').substr(0,9)==valor)
                   {
                        alert('Pessoa já adicionada a esta célula');
                        bEncontrou=true;
                   }
               }

        });

        /*Se encontrou pessoa na listagem sai da rotina sem adicionar novamente*/
        if (bEncontrou==true)
        {
            return false;
        }

        strCampos = '<input id="hidden_celulas[]"  name = "hidden_celulas[]" type="hidden" value="' + document.getElementById("celulas").value + '">';
        strCampos += '<input id="hidden_pessoas[]"  name = "hidden_pessoas[]" type="hidden" value="' + document.getElementById("pessoas").value + '">';
        strCampos += '<input id="hidden_lider_celulas[]"  name = "hidden_lider_celulas[]" type="hidden" value="' + str_celula + '">';

        cols += '<td>' + str_celula + '</td>';
        cols += '<td>' + document.getElementById("pessoas").value + '</td>';
        cols += '<td>';
        cols += '<button data-toggle="tooltip" data-placement="top" title="Remover" type="submit" class="btn btn-danger btn-sm" onclick="RemoveTableRow(this)"><spam class="glyphicon glyphicon-trash"></spam></button>' + strCampos;
        cols += '</td>';

        newRow.append(cols);
        $("#example").append(newRow);
        document.getElementById("pessoas").value="";
        return false;
      };
    })(jQuery);

    (function($) {

      RemoveTableRow = function(handler) {
        var tr = $(handler).closest('tr');

        tr.fadeOut(400, function(){
          tr.remove();
        });

        return false;
      };
    })(jQuery);

</script>