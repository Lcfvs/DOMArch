<?php
namespace Repositories\Translations;

use Lib\Translator;
use Translations;

class Bundle
    extends Translator
{
    public function __construct()
    {
        parent::__construct(Translations::class);
    }

    public function translate(
        string $format,
        string $locale,
        callable $listener,
        ...$params
    )
    {
        $bundle = $this;

        $bundle->on('fetched', function()
        use ($bundle, $format, $locale, $params, $listener) {
            $translations = &$bundle->_results;

            if (array_key_exists($format, $translations)) {
                $translation = $translations[$format];
            } else {
                $translation = $bundle->_onDefault($format);
                $translations[$format] = $translation;
            }

            $str = sprintf($translation->toArray()[$locale], ...$params);
            $id = $translation->getId();
            $is_translated = $translation->getIsTranslated();

            $listener($str, $id, $is_translated);
        });

        return $this->_search($format);
    }
}