<?php
namespace Lib\Form;

use DOMElement;

class Validator
{
    public static function validate(
        DOMElement $form,
        array $errors
    )
    {
        if (!empty($errors)) {
            static::emptyPasswords($form);

            return $form;
        }

        $elements = $form->elements->toArray();

        foreach ($elements as $element) {
            $name = $element->attrset->name;

            if (!$name) {
                continue;
            }

            if (!array_key_exists($name, $errors)) {
                continue;
            }

            $element->classList->add('invalid');
        }

        return $form;
    }

    public static function emptyPasswords(
        DOMElement $form
    )
    {
        $inputs = $form->selectAll('input[type="password"]')->toArray();

        foreach ($inputs as $input) {
            $input->value = '';
        }
    }
}