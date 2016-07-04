<?php
namespace DOMArch;

use Error;
use Exception;

use DOMArch\Request\Incoming;

class ErrorHandler
{
    public static function handle(
        callable $runner = null
    )
    {
        set_error_handler([static::class, 'onError']);
        set_exception_handler([static::class, 'onException']);

        if (!$runner) {
            return;
        }
        //*/
        $runner();
        /*/
        try {
            $runner();
        } catch (Exception $exception) {
            static::onException($exception);
        } catch (Error $error) {
            $number = $error->getCode();
            $message = $error->getMessage();
            $file = $error->getFile();
            $line = $error->getLine();

            static::onError($number, $message, $file, $line);
        }
        //*/
    }

    public static function onError(
        int $number,
        string $message,
        string $file,
        int $line,
        array $context = []
    ) {
        if ($number) {
            return;
        }

        static::toInternalError($message, $file, $line, $context);
    }

    public static function onException(
        $exception
    ) {
        $message = $exception->getMessage();
        $file = $exception->getFile();
        $line = $exception->getLine();

        static::toInternalError($message, $file, $line);
    }

    protected static function toInternalError(
        string $message,
        string $file,
        int $line,
        array $context = []
    ) {
        $traces = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        array_splice($traces, 0, 2);

        Incoming::current()
            ->internalError($message, $file, $line, $context, $traces)
            ->respond();

        exit(1);
    }
}