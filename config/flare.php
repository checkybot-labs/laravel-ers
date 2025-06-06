<?php

use CheckybotLabs\LaravelErsClient\FlareMiddleware\AddGitInformation;
use CheckybotLabs\LaravelErsClient\FlareMiddleware\RemoveRequestIp;
use CheckybotLabs\LaravelErsClient\FlareMiddleware\CensorRequestBodyFields;
use CheckybotLabs\LaravelErsClient\FlareMiddleware\CensorRequestHeaders;
use Spatie\ErrorSolutions\SolutionProviders\BadMethodCallSolutionProvider;
use Spatie\ErrorSolutions\SolutionProviders\MergeConflictSolutionProvider;
use Spatie\ErrorSolutions\SolutionProviders\UndefinedPropertySolutionProvider;
use CheckybotLabs\LaravelErs\FlareMiddleware\AddDumps;
use CheckybotLabs\LaravelErs\FlareMiddleware\AddEnvironmentInformation;
use CheckybotLabs\LaravelErs\FlareMiddleware\AddExceptionHandledStatus;
use CheckybotLabs\LaravelErs\FlareMiddleware\AddExceptionInformation;
use CheckybotLabs\LaravelErs\FlareMiddleware\AddJobs;
use CheckybotLabs\LaravelErs\FlareMiddleware\AddLogs;
use CheckybotLabs\LaravelErs\FlareMiddleware\AddQueries;
use CheckybotLabs\LaravelErs\FlareMiddleware\AddContext;
use CheckybotLabs\LaravelErs\FlareMiddleware\AddNotifierName;
use CheckybotLabs\LaravelErs\Recorders\DumpRecorder\DumpRecorder;
use CheckybotLabs\LaravelErs\Recorders\JobRecorder\JobRecorder;
use CheckybotLabs\LaravelErs\Recorders\LogRecorder\LogRecorder;
use CheckybotLabs\LaravelErs\Recorders\QueryRecorder\QueryRecorder;
use Spatie\ErrorSolutions\SolutionProviders\Laravel\DefaultDbNameSolutionProvider;
use Spatie\ErrorSolutions\SolutionProviders\Laravel\GenericLaravelExceptionSolutionProvider;
use Spatie\ErrorSolutions\SolutionProviders\Laravel\IncorrectValetDbCredentialsSolutionProvider;
use Spatie\ErrorSolutions\SolutionProviders\Laravel\InvalidRouteActionSolutionProvider;
use Spatie\ErrorSolutions\SolutionProviders\Laravel\MissingAppKeySolutionProvider;
use Spatie\ErrorSolutions\SolutionProviders\Laravel\MissingColumnSolutionProvider;
use Spatie\ErrorSolutions\SolutionProviders\Laravel\MissingImportSolutionProvider;
use Spatie\ErrorSolutions\SolutionProviders\Laravel\MissingLivewireComponentSolutionProvider;
use Spatie\ErrorSolutions\SolutionProviders\Laravel\MissingMixManifestSolutionProvider;
use Spatie\ErrorSolutions\SolutionProviders\Laravel\MissingViteManifestSolutionProvider;
use Spatie\ErrorSolutions\SolutionProviders\Laravel\OpenAiSolutionProvider;
use Spatie\ErrorSolutions\SolutionProviders\Laravel\RunningLaravelDuskInProductionProvider;
use Spatie\ErrorSolutions\SolutionProviders\Laravel\SailNetworkSolutionProvider;
use Spatie\ErrorSolutions\SolutionProviders\Laravel\TableNotFoundSolutionProvider;
use Spatie\ErrorSolutions\SolutionProviders\Laravel\UndefinedViewVariableSolutionProvider;
use Spatie\ErrorSolutions\SolutionProviders\Laravel\UnknownMariadbCollationSolutionProvider;
use Spatie\ErrorSolutions\SolutionProviders\Laravel\UnknownMysql8CollationSolutionProvider;
use Spatie\ErrorSolutions\SolutionProviders\Laravel\UnknownValidationSolutionProvider;
use Spatie\ErrorSolutions\SolutionProviders\Laravel\ViewNotFoundSolutionProvider;

return [
    /*
    |
    |--------------------------------------------------------------------------
    | Flare Base URL
    |--------------------------------------------------------------------------
    |
    | Specify Flare's Base URL below to enable error reporting to the desired endpoint.
    |
    | More info: https://flareapp.io/docs/flare/general/getting-started
    |
    */

    'base_url' => env('CHECKYBOT_BASE_URL', 'https://checkybot.com/api/v1'),

    /*
    |
    |--------------------------------------------------------------------------
    | Flare API key
    |--------------------------------------------------------------------------
    |
    | Specify Flare's API key below to enable error reporting to the service.
    |
    | More info: https://flareapp.io/docs/flare/general/getting-started
    |
    */

    'key' => env('CHECKYBOT_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | These middleware will modify the contents of the report sent to Flare.
    |
    */

    'flare_middleware' => [
        RemoveRequestIp::class,
        AddGitInformation::class,
        AddNotifierName::class,
        AddEnvironmentInformation::class,
        AddExceptionInformation::class,
        AddDumps::class,
        AddLogs::class => [
            'maximum_number_of_collected_logs' => 200,
        ],
        AddQueries::class => [
            'maximum_number_of_collected_queries' => 200,
            'report_query_bindings' => true,
        ],
        AddJobs::class => [
            'max_chained_job_reporting_depth' => 5,
        ],
        AddContext::class,
        AddExceptionHandledStatus::class,
        CensorRequestBodyFields::class => [
            'censor_fields' => [
                'password',
                'password_confirmation',
            ],
        ],
        CensorRequestHeaders::class => [
            'headers' => [
                'API-KEY',
                'Authorization',
                'Cookie',
                'Set-Cookie',
                'X-CSRF-TOKEN',
                'X-XSRF-TOKEN',
            ]
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Reporting log statements
    |--------------------------------------------------------------------------
    |
    | If this setting is `false` log statements won't be sent as events to Flare,
    | no matter which error level you specified in the Flare log channel.
    |
    */

    'send_logs_as_events' => true,


    /*
    |--------------------------------------------------------------------------
    | Solution Providers
    |--------------------------------------------------------------------------
    |
    | List of solution providers that should be loaded. You may specify additional
    | providers as fully qualified class names.
    |
    */

    'solution_providers' => [
        // from spatie/ignition
        BadMethodCallSolutionProvider::class,
        MergeConflictSolutionProvider::class,
        UndefinedPropertySolutionProvider::class,

        // from spatie/laravel-flare
        IncorrectValetDbCredentialsSolutionProvider::class,
        MissingAppKeySolutionProvider::class,
        DefaultDbNameSolutionProvider::class,
        TableNotFoundSolutionProvider::class,
        MissingImportSolutionProvider::class,
        InvalidRouteActionSolutionProvider::class,
        ViewNotFoundSolutionProvider::class,
        RunningLaravelDuskInProductionProvider::class,
        MissingColumnSolutionProvider::class,
        UnknownValidationSolutionProvider::class,
        MissingMixManifestSolutionProvider::class,
        MissingViteManifestSolutionProvider::class,
        MissingLivewireComponentSolutionProvider::class,
        UndefinedViewVariableSolutionProvider::class,
        GenericLaravelExceptionSolutionProvider::class,
        OpenAiSolutionProvider::class,
        SailNetworkSolutionProvider::class,
        UnknownMysql8CollationSolutionProvider::class,
        UnknownMariadbCollationSolutionProvider::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Ignored Solution Providers
    |--------------------------------------------------------------------------
    |
    | You may specify a list of solution providers (as fully qualified class
    | names) that shouldn't be loaded. Flare will ignore these classes
    | and possible solutions provided by them will never be displayed.
    |
    */

    'ignored_solution_providers' => [

    ],

    /*
    |--------------------------------------------------------------------------
    | Recorders
    |--------------------------------------------------------------------------
    |
    | Flare registers a couple of recorders when it is enabled. Below you may
    | specify a recorders will be used to record specific events.
    |
    */

    'recorders' => [
        DumpRecorder::class,
        JobRecorder::class,
        LogRecorder::class,
        QueryRecorder::class,
    ],

    /*
     * When a key is set, we'll send your exceptions to Open AI to generate a solution
     */

    'open_ai_key' => env('CHECKYBOT_OPEN_AI_KEY'),

    /*
   |--------------------------------------------------------------------------
   | Include arguments
   |--------------------------------------------------------------------------
   |
   | Flare show you stack traces of exceptions with the arguments that were
   | passed to each method. This feature can be disabled here.
   |
   */

    'with_stack_frame_arguments' => true,

    /*
    |--------------------------------------------------------------------------
    | Force stack frame arguments ini setting
    |--------------------------------------------------------------------------
    |
    | On some machines, the `zend.exception_ignore_args` ini setting is
    | enabled by default making it impossible to get the arguments of stack
    | frames. You can force this setting to be disabled here.
    |
    */

    'force_stack_frame_arguments_ini_setting' => true,

    /*
   |--------------------------------------------------------------------------
   | Argument reducers
   |--------------------------------------------------------------------------
   |
   | Flare show you stack traces of exceptions with the arguments that were
   | passed to each method. To make these variables more readable, you can
   | specify a list of classes here which summarize the variables.
   |
   */

    'argument_reducers' => [
        \Spatie\Backtrace\Arguments\Reducers\BaseTypeArgumentReducer::class,
        \Spatie\Backtrace\Arguments\Reducers\ArrayArgumentReducer::class,
        \Spatie\Backtrace\Arguments\Reducers\StdClassArgumentReducer::class,
        \Spatie\Backtrace\Arguments\Reducers\EnumArgumentReducer::class,
        \Spatie\Backtrace\Arguments\Reducers\ClosureArgumentReducer::class,
        \Spatie\Backtrace\Arguments\Reducers\DateTimeArgumentReducer::class,
        \Spatie\Backtrace\Arguments\Reducers\DateTimeZoneArgumentReducer::class,
        \Spatie\Backtrace\Arguments\Reducers\SymphonyRequestArgumentReducer::class,
        \CheckybotLabs\LaravelErs\ArgumentReducers\ModelArgumentReducer::class,
        \CheckybotLabs\LaravelErs\ArgumentReducers\CollectionArgumentReducer::class,
        \Spatie\Backtrace\Arguments\Reducers\StringableArgumentReducer::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Share button
    |--------------------------------------------------------------------------
    |
    | Flare automatically adds a Share button to the laravel error page. This
    | button allows you to easily share errors with colleagues or friends. It
    | is enabled by default, but you can disable it here.
    |
    */

    'enable_share_button' => true,

    /*
    |--------------------------------------------------------------------------
    | Override grouping
    |--------------------------------------------------------------------------
    |
    | Flare will try to group errors and exceptions as best as possible, that
    | being said, sometimes you might want to override the grouping. You can
    | do this by adding exception classes to this array which should always
    | be grouped by exception class, exception message or exception class
    | and message.
    |
    */

    'overridden_groupings' => [
//        Illuminate\Http\Client\ConnectionException::class => CheckybotLabs\LaravelErsClient\Enums\OverriddenGrouping::ExceptionMessageAndClass,
    ],

    /*
    |--------------------------------------------------------------------------
    | cURL Timeout
    |--------------------------------------------------------------------------
    |
    | Sets the maximum number of seconds the request is allowed to take.
    | This prevents the application from waiting indefinitely if the
    | remote server is slow or unresponsive.
    |
    | More info: https://www.php.net/manual/en/function.curl-setopt.php
    |
    */

    'curl_timeout' => env('CHECKYBOT_CURL_TIMEOUT', 60),

    /*
    |--------------------------------------------------------------------------
    | SSL Certificate Verification
    |--------------------------------------------------------------------------
    |
    | Determines whether to verify the authenticity of the SSL certificate
    | when making HTTPS requests. Setting this to true ensures that the
    | remote server is trusted and prevents man-in-the-middle attacks.
    |
    | More info: https://www.php.net/manual/en/function.curl-setopt.php
    |
    */

    'curl_ssl_verify_peer' => env('CHECKYBOT_CURL_SSL_VERIFY_PEER', true),

];
