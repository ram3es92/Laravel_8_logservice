<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\DataLogger;
use App\Models\News;
use App\Events\NewsHidden;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([DataLogger::class])->group(function () {
    Route::get('/logs', function () {
        return view('logs');
    });
});

Route::get('news/create-test', function () {

    $news = new News();
    $news->title = 'Test news title';
    $news->body = 'Test news body';
    $news->save();
    return $news;
});

Route::get('/news/{id}/hide', function ($id) {

    $news = News::findOrFail($id);

    $news->hidden = true;
    NewsHidden::dispatch($news);
    $news->save();
    return 'News hidden';
});