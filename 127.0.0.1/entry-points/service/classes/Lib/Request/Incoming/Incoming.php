<?php
namespace Lib\Request;

use DOMArch\View\JSON;
use Lib\Config;
use Lib\Request\Incoming\Body;
use Lib\Url;
use Lib\Util;

class Incoming
    extends \DOMArch\Request\Incoming
{

    public static function parse(
        string $url,
        string $method = 'get'
    )
    {
        $url = Url::parse($url);

        return static::fromUrl($url, $method);
    }

    public function getBody()
    {
        if ($this->_body) {
            return $this->_body;
        }

        $this->_body = Body::fromRequest($this);

        return $this->_body;
    }

    public function respond(
        ...$params
    )
    {
        $url = $this->getUrl();
        $module_name = $url->getModuleName();
        $entity_id = $url->getEntityId();
        $class_name = $url->getClassName();
        $sub_entity_id = $url->getSubEntityId();
        $method = $this->getMethod();

        if ($module_name === 'Dev' || $module_name === 'Error') {
            $Controller = Util::toClassName('Modules', $module_name);
            $this->_url = $this->getPrevious()->getUrl();
        } else {
            $Controller = Util::toClassName('Modules', $module_name);
        }

        if ($class_name) {
            $Controller = Util::toClassName($Controller, $class_name);
        }

        $is_valid_request = Util::isInstanciable($Controller)
        && Util::isCallableMethod($Controller, $method);

        if (!$is_valid_request) {
            return $this->notFound();
        }

        $body = new JSON();
        $this->getResponse()->setBody($body);

        $controller = new $Controller($body, $entity_id, $sub_entity_id);

        $controller->{$method}(...$params);

        $key = Config::global()->get('clientKey');

        $body->print($key);

        return $this;
    }

    public function badRequest()
    {
        http_response_code(static::STATUS_BAD_REQUEST);

        return $this->forward($this->getUrl()->rewrite([
            'moduleName' => 'Error',
            'className' => 'BadRequest'
        ]))->respond();
    }

    public function notFound()
    {
        http_response_code(static::STATUS_NOT_FOUND);

        return $this->forward($this->getUrl()->rewrite([
            'moduleName' => 'Error',
            'className' => 'NotFound'
        ]))->respond();
    }

    public function internalError(
        string $message,
        string $file,
        int $line,
        array $context,
        array $traces = []
    )
    {
        http_response_code(static::STATUS_INTERNAL_ERROR);

        return $this->forward($this->getUrl()->rewrite([
            'moduleName' => 'Error',
            'className' => 'InternalError'
        ]))->respond($message, $file, $line, $context, $traces);
    }

    public static function serviceUnavailable()
    {
        require_once 'maintenance.php';
    }

    public function unauthorized()
    {
        http_response_code(static::STATUS_UNAUTHORIZED);

        return $this->forward($this->getUrl()->rewrite([
            'moduleName' => 'Error',
            'className' => 'Unauthorized'
        ]))->respond();
    }

    public function dump($value = null)
    {
        http_response_code(static::STATUS_OK);

        if (!Config::global()->get('context')->get('isDevMode')) {
            return;
        }

        $url = $this->getUrl()->rewrite([
            'moduleName' => 'Dev',
            'className' => 'Dump'
        ]);

        $this->forward($url, 'dump')
            ->respond($value);
    }
}