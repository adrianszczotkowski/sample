<?php

use App\Exceptions\LighthouseExceptionHandler;
use GraphQL\Error\DebugFlag;
use GraphQL\Validator\Rules\QuerySecurityRule;
use Nuwave\Lighthouse\Execution\AuthenticationErrorHandler;
use Nuwave\Lighthouse\Execution\AuthorizationErrorHandler;
use Nuwave\Lighthouse\Execution\ReportingErrorHandler;
use Nuwave\Lighthouse\Execution\ValidationErrorHandler;
use Nuwave\Lighthouse\Http\Middleware\AcceptJson;
use Nuwave\Lighthouse\Http\Middleware\AttemptAuthentication;
use Nuwave\Lighthouse\Schema\Directives\RenameArgsDirective;
use Nuwave\Lighthouse\Schema\Directives\SanitizeDirective;
use Nuwave\Lighthouse\Schema\Directives\SpreadDirective;
use Nuwave\Lighthouse\Schema\Directives\TransformArgsDirective;
use Nuwave\Lighthouse\Schema\Directives\TrimDirective;
use Nuwave\Lighthouse\Subscriptions\SubscriptionRouter;
use Nuwave\Lighthouse\Validation\ValidateDirective;

return [

    'route' => [
        'uri' => '/graphql',
        'name' => 'graphql',
        'middleware' => [
            AcceptJson::class,
            AttemptAuthentication::class,
            'guest',
        ],
    ],

    'guards' => [
        'api',
        'sanctum'
    ],

    'schema_path' => base_path('graphql/schema.graphql'),

    'schema_cache' => [
        'enable' => env('LIGHTHOUSE_CACHE_ENABLE', env('APP_ENV') !== 'local'),
        'path' => env('LIGHTHOUSE_CACHE_PATH', base_path('bootstrap/cache/lighthouse-schema.php')),
        'key' => env('LIGHTHOUSE_CACHE_KEY', 'lighthouse-schema'),
    ],

    'query_cache' => [
        'enable' => env('LIGHTHOUSE_CACHE_ENABLE', env('APP_ENV') !== 'local'),
        'store' => env('LIGHTHOUSE_CACHE_STORE'),
        'ttl' => env('LIGHTHOUSE_CACHE_TTL'),
    ],

    'cache_directive_tags' => false,

    'namespaces' => [
        'models' => [
            'App',
            'App\\Models',
        ],
        'queries' => 'App\\GraphQL\\Queries',
        'mutations' => 'App\\GraphQL\\Mutations',
        'subscriptions' => 'App\\GraphQL\\Subscriptions',
        'interfaces' => 'App\\GraphQL\\Interfaces',
        'unions' => 'App\\GraphQL\\Unions',
        'scalars' => 'App\\GraphQL\\Scalars',
        'directives' => ['App\\GraphQL\\Directives'],
        'validators' => ['App\\GraphQL\\Validators'],
    ],

    'security' => [
        'max_query_complexity' => QuerySecurityRule::DISABLED,
        'max_query_depth' => QuerySecurityRule::DISABLED,
        'disable_introspection' => QuerySecurityRule::DISABLED,
    ],

    'pagination' => [
        'default_count' => null,
        'max_count' => null,
    ],

    'debug' => env('LIGHTHOUSE_DEBUG', DebugFlag::INCLUDE_DEBUG_MESSAGE | DebugFlag::INCLUDE_TRACE),

    'error_handlers' => [
        AuthenticationErrorHandler::class,
        AuthorizationErrorHandler::class,
        LighthouseExceptionHandler::class,
        ValidationErrorHandler::class,
        ReportingErrorHandler::class,
    ],

    'field_middleware' => [
        TrimDirective::class,
        SanitizeDirective::class,
        ValidateDirective::class,
        TransformArgsDirective::class,
        SpreadDirective::class,
        RenameArgsDirective::class,
    ],

    'global_id_field' => 'id',

    'persisted_queries' => true,

    'batched_queries' => true,

    'transactional_mutations' => true,

    'force_fill' => true,

    'batchload_relations' => true,

    'shortcut_foreign_key_selection' => false,

    'non_null_pagination_results' => false,

    'subscriptions' => [
        'queue_broadcasts' => env('LIGHTHOUSE_QUEUE_BROADCASTS', true),
        'broadcasts_queue_name' => env('LIGHTHOUSE_BROADCASTS_QUEUE_NAME'),
        'storage' => env('LIGHTHOUSE_SUBSCRIPTION_STORAGE', 'redis'),
        'storage_ttl' => env('LIGHTHOUSE_SUBSCRIPTION_STORAGE_TTL'),
        'broadcaster' => env('LIGHTHOUSE_BROADCASTER', 'pusher'),
        'broadcasters' => [
            'log' => [
                'driver' => 'log',
            ],
            'pusher' => [
                'driver' => 'pusher',
                'routes' => SubscriptionRouter::class . '@pusher',
                'connection' => 'pusher',
            ],
            'echo' => [
                'driver' => 'echo',
                'connection' => env('LIGHTHOUSE_SUBSCRIPTION_REDIS_CONNECTION', 'default'),
                'routes' => SubscriptionRouter::class . '@echoRoutes',
            ],
        ],
        'version' => env('LIGHTHOUSE_SUBSCRIPTION_VERSION', 2),
        'exclude_empty' => env('LIGHTHOUSE_SUBSCRIPTION_EXCLUDE_EMPTY', false),
    ],

    'defer' => [
        'max_nested_fields' => 0,
        'max_execution_ms' => 0,
    ],

    'federation' => [
        'entities_resolver_namespace' => 'App\\GraphQL\\Entities',
    ],
];
