<?php

use Illuminate\Http\Request;
use Sites\granitecms_dev\theme\controllers\TagController;

$tagController = new TagController();

Route::get('/search/{tags}', function (Request $request, $tags) use ($tagController) {
    return $tagController->search($tags);
});
