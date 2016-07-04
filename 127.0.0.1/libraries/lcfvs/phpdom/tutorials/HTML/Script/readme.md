# PHPDOM
[PHPDOM](../../../readme.md#summary) >
[Tutorials](../../readme.md#summary) >
[HTML](../readme.md#summary) >
[Stript](./readme.md#summary)

## <a name="summary">Summary</a>
* [Add a script on an element](#Add-a-script-on-an-element)
* [Add a script on the head](#Add-a-script-on-the-head)
* [Add a script on the body](#Add-a-script-on-the-body)

## <a name="Add-a-script-on-an-element">Add a script on an element</a>
````PHP
// /js/script.js
$script = $document->body->addScript('script.js');

// /directory/script.js
$script = $document->body->addScript('script.js', '/directory/');

// /js/script.js
$script = $document->body->addScript('script.js', null, [/* extra attributes */]);
````
[^](#summary)

## <a name="Add-a-script-on-the-head">Add a script on the head</a>
````PHP
// /js/script.js
$script = $document->addHeadScript('script.js');

// /directory/script.js
$script = $document->addHeadScript('script.js', '/directory/');

// /js/script.js
$script = $document->addHeadScript('script.js', null, [/* extra attributes */]);
````
[^](#summary)

## <a name="Add-a-script-on-the-body">Add a script on the body</a>
<strong>It really appends the body scripts when the document is stringified, to avoid this behavior, use the addScript method on the body, like any element.</strong>
````PHP
// /js/script.js
$script = $document->addBodyScript('script.js');

// /directory/script.js
$script = $document->addBodyScript('script.js', '/directory/');

// /js/script.js
$script = $document->addBodyScript('script.js', null, [/* extra attributes */]);
````
[^](#summary)

[PHPDOM](../../../readme.md#summary) >
[Tutorials](../../readme.md#summary) >
[HTML](../readme.md#summary) >
[Script](./readme.md#summary)