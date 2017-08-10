@if (count($infos) > 0)
    <ul>
        @foreach($infos as $info)
            <li>{{ $info }}</li>
        @endforeach
    </ul>
@endif