<?php
namespace Lib\Request\Incoming\Response\Body;

use DOMArch\Assembler;
use DOMArch\Request;
use Lib\Config;
use Lib\Translator;
use DOMArch\View\HTML;
use Lib\Url;

class Page
    extends HTML
{
    protected $_fetcher;
    protected $_translator;
    protected $_urlTranslator;
    protected $_url;

    public function __construct(
        Request $request,
        Translator $translator,
        Translator $url_translator
    )
    {
        $this->_translator = $translator;
        $this->_urlTranslator = $url_translator;
        $this->_url = $request->getUrl();

        parent::__construct();

        $assembler = new Assembler\HTML($this);
        $this->_fetcher = $assembler->getFetcher();
    }

    /**
     * @return mixed
     */
    public function getFetcher()
    {
        return $this->_fetcher;
    }

    public function getTranslator()
    {
        return $this->_translator;
    }

    public function getUrlTranslator()
    {
        return $this->_urlTranslator;
    }

    public function url(
        array $params = [],
        string $fragment = ''
    )
    {
        return $this->_url
            ->rewrite($params, $fragment);
    }

    public function appUrl(
        array $params = [],
        string $fragment = ''
    )
    {
        return (string) $this->_url
            ->rewrite($params, $fragment)
            ->setSubDomain('app');
    }

    public function translateUrl(
        \DOMAttr $translatable,
        string $locale
    )
    {
        $translator = $this->getUrlTranslator();
        $Url = get_class(Request\Incoming::current()->getUrl());
        $url = $Url::parse($translatable->nodeValue);
        $name = $translatable->name;
        $element = $translatable->ownerElement;
        $method = 'get';

        if ($name === 'action') {
            $method = $element->getAttribute('method');
        }

        $url->setMethod(strtolower($method));

        $translator->translate($url, $locale, function(
            $translation,
            $id,
            $is_translated
        ) use ($element, $name) {
            if (!$is_translated) {
                $element->classList->add('untranslated');
                $element->dataset->translationId = $id;
            }

            $key = Config::global()
                ->get('common')
                ->get('encryptionKey');

            $url = Url::parse($translation)->encrypt($key);

            $element->setAttribute($name, $url);
        });

        return $element;
    }

    public function __toString()
    {
        $html = parent::__toString();
        $memory = memory_get_peak_usage(true) / (1024 * 1024);

        return $html . '<!-- ' . $memory . ' -->' . PHP_EOL;
    }
}