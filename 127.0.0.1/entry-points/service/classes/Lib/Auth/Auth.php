<?php
namespace Lib;

use Lib\Request\Incoming;

final class Auth
{
    const
        PATTERN = '/^\/([a-z][a-zA-Z\d]*)(?:\/([1-9]\d*)(?:\/([a-z][a-zA-Z\d]*)(?:\/([1-9]\d*))?)?)?$/';

    private function __construct()
    {}

    public static function detect()
    {
        $requested = Incoming::requested();
        $common_config = Config::global()->get('common');
        $headers = $requested->getHeaders();
        $token = $headers->get('X-SERVER-TOKEN');
        $tokens = $common_config->get('tokens');
        
        if (!$token) {
            http_response_code(Incoming::STATUS_CONTINUE);
            exit;
        }

        $caller = $tokens->get($token);

        if (!$caller) {
            http_response_code(Incoming::STATUS_CONTINUE);
            exit;
        }

        $key = $caller->get('key');
        Config::global()->set('clientKey', $key);
        $namespace = ucfirst($caller->get('namespace'));
        $url = $requested->getUrl()->decrypt($key);

        if (!preg_match(static::PATTERN, $url->getPath(), $matches)) {
            http_response_code(Incoming::STATUS_CONTINUE);
            exit;
        }

        $length = count($matches);
        $module_name = Util::toClassName($namespace, ucfirst($matches[1]));

        $url->setModuleName($module_name);

        if ($length > 2) {
            $url->setEntityId($matches[2]);
        }

        if ($length > 3) {
            $url->setClassName(ucfirst($matches[3]));

            if ($length > 4) {
                $url->setSubEntityId($matches[4]);
            }
        }

        return $requested->forward($url, $requested->getMethod());
    }
}