<!-- Modal Structure -->
<a class="waves-effect waves-light btn" href="#modal-mensagem">Modal</a>

<div id="modal-mensagem" class="modal">
    <div class="modal-content">
        <h4>Mensagem</h4>

        <ul>
            @foreach(['sucesso', 'info', 'aviso', 'erro' ] as $msg_type)
                @if(Session::has('mensagem-' . $msg_type))
                    <li class="mensagem-{{ $msg_type }}">{{ Session::get('mensagem-' . $msg_type) }}</li>
                @endif
            @endforeach
        </ul>

    </div>

    <div class="modal-footer">
        <a href="#" class="modal-action modal-close waves-effect waves-green btn-flat red">Fechar</a>
    </div>

</div>


<script>
    $('#modal-mensagem').modal();
    $('#modal-mensagem').modal('open');
</script>



