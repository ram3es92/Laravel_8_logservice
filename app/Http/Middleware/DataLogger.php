<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Log;
use Illuminate\Support\Facades\File;

class DataLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->start_time = microtime(true);
        return $next($request);
    }

    /**
     * Handle tasks after the response is sent to the browser.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     * @return void
     */
    public function terminate(Request $request, Response $response): void
    {
        if (config('datalogger.enabled')) {
            $endTime = microtime(true);
            $duration = number_format($endTime - LARAVEL_START, 3);

            if (config('datalogger.use_db')) {
                // Логирование в базу данных
                $log = new Log();
                $log->time = gmdate("Y-m-d H:i:s");
                $log->duration = $duration;
                $log->ip = $request->ip();
                $log->url = $request->fullUrl();
                $log->method = $request->method();
                $log->input = $request->getContent();
                $log->save();
            } else {
                // Логирование в файл
                $filename = 'api_datalogger_' . date('d-m-y') . '.log';
                $dataToLog = "Time: " . gmdate("F j, Y, g:i a") . "\n";
                $dataToLog .= "Duration: " . $duration . "\n";
                $dataToLog .= "IP Address: " . $request->ip() . "\n";
                $dataToLog .= "URL: " . $request->fullUrl() . "\n";
                $dataToLog .= "Method: " . $request->method() . "\n";
                $dataToLog .= "Input: " . $request->getContent() . "\n";

                // Убедимся, что директория logs существует
                if (!file_exists(storage_path('logs'))) {
                    mkdir(storage_path('logs'), 0777, true);
                }

                File::append(storage_path('logs' . DIRECTORY_SEPARATOR . $filename), $dataToLog . "\n" . str_repeat("=", 20) . "\n\n");
            }
        }
    }
}