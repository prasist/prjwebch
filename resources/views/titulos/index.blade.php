@extends('principal.master')

@section('content')

<!--
<div style="margin: 150px">

<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>

    <table id="users" class="table table-bordered table-condensed">
        <tr><th>#</th><th>nome</th></tr>
        <tr>
            <td>46</td>
            <td>
            <a href="#" class="testEdit"  data-type="text" data-column="nome" data-url="{{ url('/grupos/46/update_inline')}}" data-pk="46" data-title="change" data-name="nome">Grupos</a>
            </td>

        </tr>
    </table>

</div>
-->

<script type="text/javascript">


$.fn.editable.defaults.mode = 'inline';

$(document).ready(function() {

    $('.testEdit').editable({
        params: function(params) {
            // add additional params from data-attributes of trigger element
            params.name = $(this).editable().data('nome');
            params._token = $("#_token").data("token");
            return params;
        },
        error: function(response, newValue) {
            if(response.status === 500) {
                return 'Server error. Check entered data.';
            } else {
                return response.responseText;
                // return "Error.";
            }
        }
    });
});

</script>

@endsection