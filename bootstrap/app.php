<?php

use App\Http\Middleware\SetGroupFromDomainMiddleware;
use App\Http\Middleware\ShareNextMeetupMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\TrustProxies;
use Monicahq\Cloudflare\Http\Middleware\TrustProxies as TrustCloudflareProxies;

return Application::configure(basePath: dirname(__DIR__))
	->withRouting(
		web: __DIR__.'/../routes/web.php',
		commands: __DIR__.'/../routes/console.php',
		health: '/up',
	)
	->withMiddleware(function(Middleware $middleware) {
		$middleware->web(prepend: [SetGroupFromDomainMiddleware::class, ShareNextMeetupMiddleware::class]);
		$middleware->replace(TrustProxies::class, TrustCloudflareProxies::class);
	})
	->withExceptions(function(Exceptions $exceptions) {
		//
	})->create();
