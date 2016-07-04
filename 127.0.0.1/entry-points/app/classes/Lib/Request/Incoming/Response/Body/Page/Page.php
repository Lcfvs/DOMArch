<?php
namespace Lib\Request\Incoming\Response\Body;

use DOMArch\Assembler;
use DOMArch\Request;
use Lib\Translator;
use DOMArch\View\HTML;

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

    public function __toString()
    {
        $html = parent::__toString();
        $memory = memory_get_peak_usage(true) / (1024 * 1024);

        return $html . '<!-- ' . $memory . ' -->' . PHP_EOL;
    }
}