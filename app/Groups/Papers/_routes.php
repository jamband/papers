<?php

declare(strict_types=1);

namespace App\Groups\Papers;

use Illuminate\Routing\RouteRegistrar;
use Illuminate\Routing\Router;

/** @var RouteRegistrar $router */
$router->prefix('papers')->group(function (Router $router) {
    $router->pattern('id', '[\d]+');

    $router->get('', GetPapers::class)->name('paper.home');
    $router->get('{id}', GetPaper::class)->name('paper.view');
    $router->get('create', CreatePaperView::class)->name('paper.create');
    $router->post('create', CreatePaper::class);
    $router->get('{id}/update', UpdatePaperView::class)->name('paper.update');
    $router->post('{id}/update', UpdatePaper::class);
    $router->post('{id}/delete', DeletePaper::class)->name('paper.delete');
});
