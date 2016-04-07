<script type="text/javascript">

    $(document).ready(function()
    {

       /*Quando selecionar item no combo nivel5, carrega combo nivel4 com dados relacionados*/
        $("#nivel5").change(function()
        {
            //route para chamada funcao passando ID do nivel 4
            var urlRoute = "{!! url('/nivel5/" + $("#nivel5").val() + "') !!}";

            $.getJSON(urlRoute, function(data)
            {
                var $stations = $("#nivel4"); //Instancia o objeto combo nivel3
                $stations.empty();

                var html='';

                $.each(data, function(index, value)
                {
                    html += '<option value="' + index +'">' + value + '</option>';
                });

                $stations.append(html);
                $("#nivel4").trigger("change");
            });
        });


        /*Quando selecionar item no combo nivel4, carrega combo nivel3 com dados relacionados*/
        $("#nivel4").change(function()
        {
            //route para chamada funcao passando ID do nivel 4
            var urlRoute = "{!! url('/nivel4/" + $("#nivel4").val() + "') !!}";

            $.getJSON(urlRoute, function(data)
            {

                var $stations = $("#nivel3"); //Instancia o objeto combo nivel3
                $stations.empty();

                var html='';

                $.each(data, function(index, value)
                {
                    html += '<option value="' + index +'">' + value + '</option>';
                });

                $stations.append(html);
                $("#nivel3").trigger("change");
            });
        });

        /*Quando selecionar item no combo nivel3, carrega combo nivel2 com dados relacionados*/
        $("#nivel3").change(function()
        {
            //route para chamada funcao passando ID do nivel 4
            var urlRoute = "{!! url('/nivel3/" + $("#nivel3").val() + "') !!}";

            $.getJSON(urlRoute, function(data)
            {

                var $stations = $("#nivel2"); //Instancia o objeto combo nivel2
                $stations.empty();

                var html='';

                $.each(data, function(index, value)
                {
                    html += '<option value="' + index +'">' + value + '</option>';
                });

                $stations.append(html);
                $("#nivel2").trigger("change");
            });
        });

        /*Quando selecionar item no combo nivel3, carrega combo nivel2 com dados relacionados*/
        $("#nivel2").change(function()
        {
            //route para chamada funcao passando ID do nivel 3
            var urlRoute = "{!! url('/nivel2/" + $("#nivel2").val() + "') !!}";

            $.getJSON(urlRoute, function(data)
            {

                var $stations = $("#nivel1"); //Instancia o objeto combo nivel2
                $stations.empty();

                var html='';

                $.each(data, function(index, value)
                {
                    html += '<option value="' + index +'">' + value + '</option>';
                });

                $stations.append(html);
            });
        });

    });
</script>