@if (count($infos) > 0)

    @foreach($infos as $info)
        {{ $infoLines .= $info . '<br>' }}
    @endforeach

    <script type="text/javascript">

        window.onload = run;

        function run() {
            <?php
            echo 'Materialize.toast(' . $infoLines . ', 4000);';
            ?>
        }

    </script>

@endif