<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Carbon; // Добавляем Carbon

class DataLogger
{
    private $start_time;

    public function handle(Request $request, Closure $next): Response
    {
        $this->start_time = microtime(true);
        return $next($request);
    }

    public function terminate($request, $response)
    {
        if (env('API_DATALOGGER', true)) {
            if (env('API_DATALOGGER_USE_DB', true)) {

                $endTime = microtime(true);

                $log = new Log();

                // ✅ Исправлено: Правильный формат даты
                $log->time = Carbon::now()->format('Y-m-d H:i:s');

                $log->duration = number_format($endTime - LARAVEL_START, 3); // Исправлена ошибка `=` вместо `-`

                $log->ip = $request->ip();
                $log->url = $request->fullUrl();
                $log->method = $request->method();
                $log->input = $request->getContent();

                $log->save(); // Сохраняем запись в базу данных

            } else {
                // Запись в файл, если БД недоступна
                $endTime = microtime(true);

                $filename = 'api_datalogger_' . date('d-m-y') . '.log';

                $dataToLog = "Time: " . Carbon::now()->format('Y-m-d H:i:s') . "\n";
                $dataToLog .= "Duration: " . number_format($endTime - LARAVEL_START, 3) . "\n";
                $dataToLog .= "IP Address: " . $request->ip() . "\n";
                $dataToLog .= "URL: " . $request->fullUrl() . "\n";
                $dataToLog .= "Method: " . $request->method() . "\n";
                $dataToLog .= "Input: " . $request->getContent() . "\n";

                \File::append(storage_path('logs' . DIRECTORY_SEPARATOR . $filename), $dataToLog . "\n" . str_repeat("[]", 20) . "\n\n");
            }
        }
    }
}