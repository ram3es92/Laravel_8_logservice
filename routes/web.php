<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\DataLogger;
use App\Models\News;
use App\Events\NewsHidden;
use App\Events\UserRegistered;

Route::get('/test-event', function () {
    event(new NewsHidden('Иван', 'ivan@example.com'));
    return 'Событие отправлено!';
});

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([DataLogger::class])->group(function () {
    Route::get('/logs', function () {
        return view('logs');
    });
});

Route::get('news/create-test', function () {
    event(new NewsHidden('Иван', 'ivan@example.com'));
    $news = News::create([
        'title' => 'Тестовая новость',
        'content' => 'Это контент тестовой новости.'
    ]);

    return "Новость '{$news->title}' успешно создана!";
});

Route::get('/news/{id}/hide', function ($id) {

    $news = News::findOrFail($id);

    $news->hidden = true;
    NewsHidden::dispatch($news);
    $news->save();
    return 'News hidden';
});