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
       if ($('#valor_pago').val()!="")  var_pago = $('#valor_pago').val().replace( '.', '' ).replace( ',', '.' );

       var_pago = parseFloat(var_pago)*100;

       //Calculo do valor pago
       var_resultado = ((var_pago + var_acrescimo) - var_desconto)/100;

      if (parseFloat(var_resultado)>0)
      {
            $('#valor_pago').val(var_resultado.toFixed(2).replace('.', ',')); //Mesmo valor do titulo
      }
      else if (parseFloat(var_resultado)<0)//Provavelmente negativo
      {
        /*
         alert("Valor calculado incorreto : " + var_resultado + "\nVerifique o valor do Acréscimo/Desconto");
         $('#desconto').val('');
         $('#acrescimo').val('');
         */
      }


    }

       $(function () {


            /*Inicializa check como botoes sim e nao*/
            $('.ckpago').checkboxpicker({
                offLabel : 'Não',
                onLabel : 'Sim',
            });

            /*Se clicar check pago, exibi informacoes do pagamento*/
            if ($('.ckpago').prop('checked'))
            {
                $("#esconder").show();
            }

            //Se houver pagamentos parciais, exibir campos
            if ($('#saldo').val()>0 && $('#saldo').val() != $('#valor').val())
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
                      $('#valor_pago').val($('#saldo').val()); //Mesmo valor do titulo
                      $('.ckpago').val('true'); //Mesmo valor do titulo
                  }
                  else
                  {

                    if (confirm('Deseja estornar o pagamento ? O valor acumulado de pagamentos será zerado e o saldo devedor retornará integralmente.'))
                    {
                        $("#data_pagamento").val('');
                        $('#valor_pago').val(''); //zera
                        $('#total_pago').val('0'); //zerar
                        $('#saldo').val($('#valor').val()); //Mesmo valor do titulo
                        $('#acrescimo').val('');
                        $('#desconto').val('');
                        $("#esconder").hide();
                        $('.ckpago').val('');
                    }
                    else
                    {
                        location.reload(); //Reflesh na pagina para recarregar valores atualizados apos update
                    }

                  }
            });


      });

</script>