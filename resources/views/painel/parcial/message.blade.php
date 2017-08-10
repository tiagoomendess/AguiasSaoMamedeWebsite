<?php $count = 0; ?>
<div id="modal-mensagem" class="modal">
    <div class="modal-content center">

        <br>
        <br>
        <div class="divider"></div>

        <ul class="flow-text">
            @foreach(['sucesso', 'info', 'aviso', 'erro' ] as $msg_type)
                @if(Session::has('mensagem-' . $msg_type))
                    <li class="mensagem-{{ $msg_type }}">{{ Session::get('mensagem-' . $msg_type) }}</li>
                    <?php $count++; ?>
                @endif
            @endforeach

        </ul>

        <div class="divider"></div>

        <div class="modal-footer">
            <a href="" class="modal-action modal-close waves-effect waves-green btn-flat">Ok</a>
        </div>

    </div>



</div>

@if($count != 0)
    @section('after-scripts')
        <script>
          $('#modal-mensagem').modal();
          $('#modal-mensagem').modal('open');
     </script>
    @endsection
@endif




