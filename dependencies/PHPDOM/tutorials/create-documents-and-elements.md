# <a name="title">PHPDOM</a>

Create documents and elements

## <a name="summary">Summary</a>
* [Create a document](#create-a-document)
* [Load a template](#load-a-template)
* [Load a fragment template](#load-a-fragment-template)
* [Create a text node](#create-a-text-node)
* [Create an element](#create-an-element)
* [Create element and children at once](#create-element-and-children-at-once)

[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)


## <a name="create-a-document">Create a document</a>
````PHP
// empty document
$document = new \PHPDOM\HTML\Document();
// or with the minimal code (HTML5)
$document = new \PHPDOM\HTML\Document(true);
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="load-a-template">Load a template</a>
````PHP
// from data
$document->loadSource($source);
// or from a local file
$document->loadSourceFile($filename);
// or from a remote file
$document->loadSourceFile($filename, $libxml_options, $use_include_path, $context);
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="load-a-fragment-template">Load a fragment template</a>
````PHP
$fragment = $document->loadFragment($source);
// or from a local file
$document->loadFragmentFile($filename);
// or from a remote file
$document->loadFragmentFile($filename, $use_include_path, $context);
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="create-a-text-node">Create a text node</a>
````PHP
$text_node = $document->create('Hello world');
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="create-an-element">Create an element</a>
````PHP
$paragraph = $document->create([
    'tag' => 'p'
]);
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="create-element-and-children-at-once">Create element and children at once</a>
````PHP
$paragraph = $document->create([
    'tag' => 'p',
    'children' => [[
        'tag' => 'a',
        'attributes' => [
            'href' => 'https://github.com/Lcfvs/DOMArch',
        ],
        'data' => 'DOMArch'
    ]]
]);

// or
$paragraph = $document->create([
    'tag' => 'p',
    'children' => ['DOMArch']
]);

// or
$text_node = $document->create('DOMArch');

$paragraph = $document->create([
    'tag' => 'p',
    'children' => [$text_node]
]);
````

[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)