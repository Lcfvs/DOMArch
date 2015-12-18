# <a name="title">PHPDOM</a>

Cheatsheet

## <a name="summary">Summary</a>
* [Manipulate the title](#manipulate-the-title)
* [Add a stylesheet](#add-a-stylesheet)
* [Add a script on an element](#add-a-script-on-an-element)
* [Add a script on the head](#add-a-script-on-the-head)
* [Add a script on the body](#add-a-script-on-the-body)
* [Add a class on an element](#add-a-class-on-an-element)
* [Remove a class on an element](#remove-a-class-on-an-element)
* [Remove all classes on an element](#remove-all-classes-on-an-element)
* [Get the document source](#get-the-document-source)
* [Get the element source](#get-the-element-source)
* [Get the node list source](#get-the-nodelist-source)
* [Set attributes at once on an element](#set-attributes-at-once-on-an-element)
* [Remove attributes at once on an element](#remove-attributes-at-once-on-an-element)
* [Get attributes at once on an element](#get-attributes-at-once-on-an-element)
* [Check if an element matches a selector](#check-if-an-element-matches-a-selector)
* [Apply a callback on each node list elements](#apply-a-callback-on-each-nodelist-elements)
* [Apply a callback on every node list elements](#apply-a-callback-on-every-nodelist-elements)
* [Save a document](#save-a-document)
* [Save an element](#save-an-element)
* [Remove a node list](#remove-a-nodelist)

[Tutorials summary](./readme.md#summary)<br />
[Summary](../readme.md#summary)

## <a name="manipulate-the-title">Manipulate the title</a>
````PHP
// get the title text
$title = $document->title;

// set the title
$document->title = 'title';

// add some data to the title
$document->title .= ' !!!';
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="add-a-stylesheet">Add a stylesheet</a>
````PHP
// /css/style.css
$link = $document->addStyleSheet('style.css');

// /directory/style.css
$link = $document->addStyleSheet('style.css', '/directory/');

// /css/style.css
$link = $document->addStyleSheet('style.css', null, [/* extra attributes */]);
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="add-a-script-on-an-element">Add a script on an element</a>
````PHP
// /js/script.js
$script = $document->body->addScript('script.js');

// /directory/script.js
$script = $document->body->addScript('script.js', '/directory/');

// /js/script.js
$script = $document->body->addScript('script.js', null, [/* extra attributes */]);
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="add-a-script-on-the-head">Add a script on the head</a>
````PHP
// /js/script.js
$script = $document->addHeadScript('script.js');

// /directory/script.js
$script = $document->addHeadScript('script.js', '/directory/');

// /js/script.js
$script = $document->addHeadScript('script.js', null, [/* extra attributes */]);
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="add-a-script-on-the-body">Add a script on the body</a>
<strong>It really appends the body scripts when the document is stringified, to avoid this behavior, use the addScript method on the body, like any element.</strong>
````PHP
// /js/script.js
$script = $document->addBodyScript('script.js');

// /directory/script.js
$script = $document->addBodyScript('script.js', '/directory/');

// /js/script.js
$script = $document->addBodyScript('script.js', null, [/* extra attributes */]);
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="add-a-class-on-an-element">Add a class on element</a>
````PHP
$body = $document->body->addClass('class-name');
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="remove-a-class-on-an-element">Remove a class on an element</a>
````PHP
$body = $document->body->removeClass('class-name');
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="remove-all-classes-on-an-element">Remove all classes on an element</a>
````PHP
$body = $document->body->removeClass();
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="get-the-document-source">Get the document source</a>
````PHP
$source = $document->__toString();

// then you can make an echo on the document
echo $document;
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="get-the-element-source">Get the element source</a>
````PHP
$source = $document->body->__toString();

// then you can make an echo on the element
echo $document->body;
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="get-the-nodelist-source">Get the node list source</a>
````PHP
$source = $document->body->selectAll('*')->__toString();

// then you can make an echo on the node list
echo $document->body->selectAll('*');
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="set-attributes-at-once-on-an-element">Set attributes at once on an element</a>
````PHP
$body = $document->body->setAttr([
    'id' => 'body_id',
    'class' => '.body_class'
]);
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="remove-attributes-at-once-on-an-element">Remove attributes at once on an element</a>
````PHP
$body = $document->body->removeAttr([
    'id' => 'body_id',
    'class' => '.body_class'
]);

// or 
$body = $document->body->setAttr([
    'id' => null,
    'class' => null
]);

// or to remove all attributes
$body = $document->body->removeAttr();
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="get-attributes-at-once-on-an-element">Get attributes at once on an element</a>
````PHP
$pairs = $document->body->getAttributes();
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="check-if-an-element-matches-a-selector">Check if an element matches a selector</a>
````PHP
$boolean = $document->select('title')->matches('head > title');
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="apply-a-callback-on-each-nodelist-elements">Apply a callback on each node list elements</a>
````PHP
$result = $document->selectAll('*')->each(function ($element, $index, $node_list) {
    $element->setAttribute('id', 'element_' . $index);
});
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="apply-a-callback-on-every-nodelist-elements">Apply a callback on every node list elements</a>
````PHP
$result = $document->selectAll('*')->each(function ($element, $index, $node_list) {
    $element->setAttribute('id', 'element_' . $index);

    return $index < 3;
});
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="save-a-document">Save a document</a>
````PHP
$document = $document->save('path');
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="save-an-element">Save an element</a>
````PHP
$body = $document->body->save('path');
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="save-a-document">Save a document</a>
````PHP
$document = $document->save('path');
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="remove-a-nodelist">Remove a node list</a>
````PHP
$child_nodes = $document->body->childNodes->remove();
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)