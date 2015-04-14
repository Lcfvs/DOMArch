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
* [Set attribute at once on an element](#set-attributes-at-once-on-an-element)

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

## <a name="set-attributes-at-once-on-an-element">Set attribute at once on an element</a>
````PHP
$body = $document->body->setAttributes([
    'id' => 'body_id',
    'class' => '.body_class'
]);
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)