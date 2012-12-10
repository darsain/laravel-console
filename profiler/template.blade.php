@if (count($queries) > 0)
[    Time ]   [ Query ]
@foreach ($queries as $query)
{{ sprintf("%9sms   %s\n", $query[1], $query[0] ) }}
@endforeach
@endif
