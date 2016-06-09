# PHPDOM
[PHPDOM](../../../readme.md#summary) >
[Tutorials](../../readme.md#summary) >
[HTML](../readme.md#summary) >
[Element](./readme.md#summary)

## <a name="summary">Summary</a>
* [ClassList](./ClassList/readme.md#summary)
* [Dataset](./Dataset/readme.md#summary)


* [Create an element](#Create-an-element)
* [Create elements recursively](#Create-elements-recursively)
* [Append an element](#Append-an-element)
* [Insert an element before another](#Insert-an-element-before-another)
* [Decorate an with another](#Decorate-an-element-with-another)
* [Prepend an element](#Prepend-an-element)
* [Replace an element](#Replace-an-element)
* [Remove an element](#Remove-an-element)
* [Stringify an element](#Stringify-an-element)


## <a name="Create-an-element">Create an element</a>
````PHP
$paragraph = $document->create([
    'tag' => 'p'
]);

````
[^](#summary)

## <a name="Create-elements-recursively">Create elements recursively</a>
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
[^](#summary)

## <a name="Append-an-element">Append an element</a>
````PHP
$hgroup = $document->body->append([
    'tag' => 'hgroup',
    'children' => [[
        'tag' => 'h2',
        'data' => 'Second body title'
    ]]
]);
````
[^](#summary)

## <a name="Insert-an-element-before-another">Insert an element before another</a>
````PHP
$h2 = $hgroup->select('h2');

$h1 = $hgroup->insert([
    'tag' => 'h1',
    'data' => 'Body title'
], $h2);

// or with a selector
$h1 = $hgroup->insert([
    'tag' => 'h1',
    'data' => 'Body title'
], 'h2');
````
[^](#summary)

## <a name="Decorate-an-element-with-another">Decorate an element with another</a>
````PHP
$header = $hgroup->decorate([
    'tag' => 'header'
]);
// or
$h1 = $document->create([
    'tag' => 'h1'
]);
$h1->decorate($hgroup);
````
[^](#summary)

## <a name="Prepend-an-element">Prepend an element</a>
````PHP
$section = $document->body->append([
    'tag' => 'section'
]);

$header = $section->prepend($header);

// or
$section = $document->prepend([
    'tag' => 'hr'
]);
````
[^](#summary)

## <a name="Replace-an-element">Replace an element</a>
````PHP
$section = $document->body->append([
    'tag' => 'section'
]);

$section = $header->replace($section);
````
[^](#summary)

## <a name="Remove-an-element">Remove an element</a>
````PHP
$section = $document->body->select('section')->remove();
````
[^](#summary)

## <a name="Stringify-an-element">Stringify an element</a>
````PHP
$html = $document->body->select('section')->__toString();
````
[^](#summary)

[PHPDOM](../../../readme.md#summary) >
[Tutorials](../../readme.md#summary) >
[HTML](../readme.md#summary) >
[Element](./readme.md#summary)