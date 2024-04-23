<?php

declare(strict_types=1);

namespace App\Groups\Site;

use Illuminate\Routing\Router;

/** @var Router $router */
$router->view('/', 'site.home')->name('home');
$router->view('/about', 'site.about')->name('about');
$router->view('/contact', 'site.contact')->name('contact');
$router->fallback(Fallback::class);
