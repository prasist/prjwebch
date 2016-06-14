<script type="text/javascript">
 /*Prepara checkbox bootstrap*/


    function recalcula() {

       var_acrescimo=0;
       var_desconto=0;
       var_pago=0;

       //Pega valor de acrescimo se houver, troca ponto por virgula (milhar) e virgula por ponto (decimal)
       if ($('#acrescimo').val()!="")   var_acrescimo = $('#acrescimo').val().replace( '.', '' ).replace( ',', '.' );

       var_acrescimo = parseFloat(var_acrescimo)*100;

       //Pega valor de desconto se houver, troca ponto por virgula (milhar) e virgula por ponto (decimal)
       if ($('#desconto').val()!="")   var_desconto = $('#desconto').val().replace( '.', '' ).replace( ',', '.' );

       var_desconto = parseFloat(var_desconto)*100;

       //Pega valor de desconto se houver, troca ponto por virgula (milhar) e virgula por ponto (decimal)
       if ($('#valor').val()!="")  var_pago = $('#valor').val().replace( '.', '' ).replace( ',', '.' );

       var_pago = parseFloat(var_pago)*100;

       //Calculo do valor pago
       var_resultado = ((var_pago + var_acrescimo) - var_desconto)/100;

      if (parseFloat(var_resultado)>0)
      {
            $('#valor_pago').val(var_resultado.toFixed(2).replace('.', ',')); //Mesmo valor do titulo
      }
      else //Provavelmente negativo
      {
         alert("Valor calculado incorreto : " + var_resultado + "\nVerifique o valor do Acréscimo/Desconto");
         $('#desconto').val('');
         $('#acrescimo').val('');
      }


    }

       $(function () {


            $('.ckpago').checkboxpicker({
                offLabel : 'Não',
                onLabel : 'Sim',
            });

            if ($('.ckpago').prop('checked'))
            {
                $("#esconder").show();
            }

            /*Quando clicar no check pago*/
            $('.ckpago').change(function()
            {
                  if ($(this).prop('checked'))
                  {
                      $("#esconder").show();
                      $("#data_pagamento").val(moment().format('DD/MM/YYYY')); //Data de pagamento dia
                      $('#valor_pago').val($('#valor').val()); //Mesmo valor do titulo
                      $('.ckpago').val('true'); //Mesmo valor do titulo
                  }
                  else
                  {
                    $("#data_pagamento").val(''); //Data de pagamento dia
                    $('#valor_pago').val(''); //Mesmo valor do titulo
                    $("#esconder").hide();
                    $('.ckpago').val(''); //Mesmo valor do titulo
                  }
            });


      });

</script>