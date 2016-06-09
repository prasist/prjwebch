<script type="text/javascript">
 /*Prepara checkbox bootstrap*/
       $(function () {

            /*Monetarios - class*/
            $('.formata_valor').autoNumeric("init",{
                aSep: '.',
                aDec: ','
            });

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