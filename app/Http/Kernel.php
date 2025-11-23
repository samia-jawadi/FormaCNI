protected $routeMiddleware = [
    // ... existing middleware
    'auth' => \App\Http\Middleware\Authenticate::class,
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
    'formateur' => \App\Http\Middleware\FormateurMiddleware::class,
    'participant' => \App\Http\Middleware\ParticipantMiddleware::class,
];