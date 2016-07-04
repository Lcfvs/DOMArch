<?php
namespace Repositories\Routes;

use Lib\Config;
use Lib\Translator;
use Lib\Url;
use Routes;

class Bundle
    extends Translator
{
    const
    SYSTEM_FIELDS = [
        'className',
        'method',
        'moduleName',
        'locale'
    ];

    public function __construct()
    {
        parent::__construct(Routes::class);
    }

    public function translate(
        Url $url,
        string $locale,
        callable $listener
    )
    {
        $bundle = $this;
        $counter = 0;

        $params = $url->getParams()
            ->init('className', $url->getClassName())
            ->init('method', $url->getMethod())
            ->init('moduleName', $url->getModuleName())
            ->toArray();

        ksort($params);

        unset($params['locale']);

        $sprintf_params = [];

        foreach ($params as $name => $value) {
            if (!in_array($name, self::SYSTEM_FIELDS)) {
                $counter += 1;
                $sprintf_params[] = $value;
                
                $params[$name] = '%' . $counter . 's';
            }
        }

        $format = urldecode($url->rewrite($params, $url->getFragment()));

        $bundle->on('fetched', function()
        use ($bundle, $url, $locale, $format, $sprintf_params, $listener) {
            $routes = &$bundle->_results;

            if (array_key_exists($format, $routes)) {
                $route = $routes[$format];
            } else {
                $route = $bundle->_onDefault($format);
            }

            $translation = $route->toArray()[$locale];
            $translation = sprintf($translation, ...$sprintf_params);
            $id = $route->getId();

            $key = Config::global()
                ->get('common')
                ->get('encryptionKey');

            $encrypted = Url::parse($translation)
                ->setLocale($locale)
                ->encrypt($key);

            $listener($encrypted, $id, true);
        });

        return $this->_search($format);
    }

    protected function _onDefault(
        string $format
    )
    {
        $fields = [
            'format' => $format
        ];

        foreach ($this->_locales as $locale) {
            $fields[$locale] = $format . '&locale=' . $locale;
        }

        $entity_class = $this->_entityClass;

        return $entity_class::fromArray($fields)
            ->save();
    }
}