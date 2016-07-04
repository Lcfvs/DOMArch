<?php
namespace Lib\Request;

use Lib\Config;
use Lib\Request\Incoming\Response\Body\Page;
use Lib\Url;
use Lib\Util;
use Lib\View\HTML;
use Repositories\Routes;
use Repositories\Translations;

class Incoming extends \DOMArch\Request\Incoming
{
    public static function parse(
        string $url,
        string $method = 'get'
    )
    {
        return static::fromUrl(Url::parse($url), $method);
    }
    
    public static function requested()
    {
        if (self::$_requested) {
            return self::$_requested;
        }

        $requested = parent::requested();
        $method = $requested->getMethod();
        $url = $requested->getUrl();

        $resolved_url = Routes::parse($url, $method);

        if (!$resolved_url) {
            return $requested->notFound();
        }

        return $requested->forward($resolved_url, $method);
    }

    public function respond(
        ...$params
    )
    {
        $url = $this->getUrl();
        $class_name = $url->getClassName();
        $module_name = $url->getModuleName();
        $method = $url->getMethod();

        $View = Util::toClassName('Modules', $module_name, 'Views', $class_name);
        $Controller = Util::toClassName('Modules', $module_name, 'Controllers', $class_name);

        $is_valid_request = Util::isInstanciable($View)
        && Util::isInstanciable($Controller)
        && Util::isCallableMethod($Controller, $method);

        if (!$is_valid_request) {
            return $this->notFound();
        }

        if ($module_name === 'Dev' || $module_name === 'Error') {
            $this->_url = $this->getPrevious()->getUrl();
        }

        $document = new Page($this, Translations::bundle(), Routes::bundle());
        $response = new Incoming\Response();

        $this->_response = $response->setBody($document);

        $view = new $View();
        $controller = new $Controller($view);

        $controller->{$method}(...$params);
        
        return $response->getBody()->print();
    }

    public function notFound()
    {
        http_response_code(static::STATUS_NOT_FOUND);

        return $this->forward($this->getUrl()->rewrite([
            'moduleName' => 'Error',
            'className' => 'NotFound'
        ]));
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

        $requested_url = static::requested()->getUrl();

        $locale = $requested_url->getLocale();

        $url = $requested_url->rewrite([
            'moduleName' => 'Error',
            'className' => 'InternalError',
            'locale' => $locale
        ]);

        return $this->forward($url)
            ->respond($message, $file, $line, $context, $traces);
    }

    public static function serviceUnavailable()
    {
        require_once 'maintenance.php';
    }

    public function forceAuthentication()
    {
        $requested_url = static::requested()->getUrl();
        $locale = $requested_url->getLocale();

        $url = $requested_url->rewrite([
            'className' => 'Index',
            'method' => 'get',
            'moduleName' => 'Login',
            'locale' => $locale
        ]);

        $key = Config::global()
            ->get('common')
            ->get('encryptionKey');

        $this->redirect(static::STATUS_UNAUTHORIZED, $url->encrypt($key));
    }

    public function home()
    {
        $requested_url = static::requested()->getUrl();

        $locale = $requested_url->getLocale();

        $url = $requested_url->rewrite([
            'className' => 'Index',
            'method' => 'get',
            'moduleName' => 'FileReader',
            'locale' => $locale
        ]);

        $key = Config::global()
            ->get('common')
            ->get('encryptionKey');

        return $this->redirect(static::STATUS_OK, $url->encrypt($key));
    }

    public function dump($value = null)
    {
        http_response_code(static::STATUS_OK);

        if (!Config::global()->get('context')->get('isDevMode')) {
            return $this;
        }

        $url = $this->getUrl()->rewrite([
            'moduleName' => 'Dev',
            'method' => 'dump',
            'className' => 'Dump'
        ]);

        return $this->forward($url, 'dump')
            ->respond($value);
    }
}