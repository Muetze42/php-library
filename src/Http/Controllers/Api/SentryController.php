<?php

namespace NormanHuth\Library\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use NormanHuth\Library\Exceptions\Frontend\AggregateErrorException;
use NormanHuth\Library\Exceptions\Frontend\DOMException;
use NormanHuth\Library\Exceptions\Frontend\EvalErrorException;
use NormanHuth\Library\Exceptions\Frontend\FrontendException;
use NormanHuth\Library\Exceptions\Frontend\LinkErrorException;
use NormanHuth\Library\Exceptions\Frontend\RangeErrorException;
use NormanHuth\Library\Exceptions\Frontend\ReferenceErrorException;
use NormanHuth\Library\Exceptions\Frontend\RuntimeErrorException;
use NormanHuth\Library\Exceptions\Frontend\SyntaxErrorException;
use NormanHuth\Library\Exceptions\Frontend\TypeErrorException;
use NormanHuth\Library\Exceptions\Frontend\URIErrorException;

class SentryController
{
    /**
     * @var string[]
     */
    protected array $errorLevels = [
        'emergency',
        'alert',
        'critical',
        'error',
        'warning',
        'notice',
        'info',
        'debug',
    ];

    /**
     * The Log Driver for frontend log.
     */
    protected ?string $logDriver = 'frontend';

    /**
     * Handle the incoming Sentry error report request.
     *
     * @throws \NormanHuth\Library\Exceptions\Frontend\FrontendException
     */
    public function __invoke(Request $request): void
    {
        $data = array_map(
            fn ($line) => json_decode($line, true),
            preg_split('/\r\n|\r|\n/', $request->getContent())
        )[2];

        $level = data_get($data, 'level');
        if (! in_array($level, $this->errorLevels)) {
            $level = 'error';
        }
        $url = data_get($data, 'request.url');
        $type = data_get($data, 'exception.values.0.type');
        $message = $url . ' ' . $type . ': ' . data_get($data, 'exception.values.0.value');

        if ($this->logDriver && config('logging.channels.' . $this->logDriver)) {
            $frames = data_get($data, 'exception.values.0.stacktrace.frames', []);
            Log::driver($this->logDriver)
                ->{$level}($this->formatStacktraceFrames('Frontend ' . $message, $frames));
        }

        $this->throwException($type, $message);
    }

    /**
     * Throw a frontend exception.
     *
     * @throws \NormanHuth\Library\Exceptions\Frontend\FrontendException
     */
    protected function throwException(string $type, string $message): void
    {
        match ($type) {
            'AggregateError' => throw new AggregateErrorException($message),
            'DOMException' => throw new DOMException($message),
            'EvalError' => throw new EvalErrorException($message),
            'LinkError' => throw new LinkErrorException($message),
            'RangeError' => throw new RangeErrorException($message),
            'ReferenceError' => throw new ReferenceErrorException($message),
            'RuntimeError' => throw new RuntimeErrorException($message),
            'SyntaxError' => throw new SyntaxErrorException($message),
            'TypeError' => throw new TypeErrorException($message),
            'URIError' => throw new URIErrorException($message),
            default => throw new FrontendException($message)
        };
    }

    /**
     * @param array{array-key, array{
     *     filename: string,
     *     function: string,
     *     in_app: bool,
     *     lineno: int,
     *     colno: int
     * }} $stacktrace
     */
    protected function formatStacktraceFrames(string $message, array $stacktrace): string
    {
        $contents = [$message];

        foreach ($stacktrace as $key => $frame) {
            $contents[] = '#' . $key . ' ' . $frame['filename'] .
                '(' . $frame['lineno'] . ':' . $frame['colno'] . '): ' . $frame['function'];
        }

        return implode("\n", $contents);
    }
}
