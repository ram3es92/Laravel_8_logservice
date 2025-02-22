<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Логи</title>
    <style>
        td:nth-child(5),
        td:nth-child(6) {
            text-align: center;
        }
        table {
            position: absolute;
            border-spacing: 0;
            border-collapse: collapse;
            width: 70%;
            box-shadow: 8px 4px 10px rgb(255 255 255 / 25%);
        }
        td, th {
            padding: 10px;
            border: 1px solid #282828;
        }
        tr:nth-child(odd) {
            background-color: #C18787;
        }
    </style>
</head>
<body>

@php
    use Illuminate\Support\Facades\DB;

    try {
        // Запрос к MySQL
        $logs = DB::select("SELECT id, time, duration, ip, url, method, input FROM logs");
    } catch (Exception $e) {
        echo 'Ошибка подключения к базе данных: ' . $e->getMessage();
        $logs = [];
    }
@endphp

<div class="table">
    <table>
        <tr>
            <th>id</th>
            <th>time</th>
            <th>duration</th>
            <th>ip</th>
            <th>url</th>
            <th>method</th>
            <th>input</th>
        </tr>
        @foreach($logs as $log)
            <tr>
                <td align="center">{{ $log->id }}</td>
                <td align="center">{{ $log->time }}</td>
                <td align="center">{{ $log->duration }}</td>
                <td align="center">{{ $log->ip }}</td>
                <td align="center">{{ $log->url }}</td>
                <td align="center">{{ $log->method }}</td>
                <td align="center">{{ $log->input }}</td>
            </tr>
        @endforeach
    </table>
</div>

</body>
</html>
