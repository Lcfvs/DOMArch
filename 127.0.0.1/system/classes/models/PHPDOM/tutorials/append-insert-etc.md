# <a name="title">PHPDOM</a>

Append, insert, etc.

## <a name="summary">Summary</a>
* [Append an element](#append-an-element)
* [Insert an element before another](#insert-an-element-before-another)
* [Decorate an element](#decorate-an-element)
* [Prepend an element](#prepend-an-element)
* [Replace an element](#replace-an-element)
* [Remove an element](#remove-an-element)

[Tutorials summary](./readme.md#summary)<br />
[Summary](../readme.md#summary)

## <a name="append-an-element">Append an element</a>
````PHP
$hgroup = $document->body->append([
    'tag' => 'hgroup',
    'children' => [[
        'tag' => 'h2',
        'data' => 'Second body title'
    ]]
]);
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="insert-an-element-before-another">Insert an element before another</a>
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
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="decorate-an-element">Decorate an element</a>
````PHP
$header = $hgroup->decorate([
    'tag' => 'header'
]);
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="prepend-an-element">Prepend an element</a>
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
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="replace-an-element">Replace an element</a>
````PHP
$section = $document->body->append([
    'tag' => 'section'
]);

$section = $header->replace($section);
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="remove-an-element">Remove an element</a>
````PHP
$section = $document->body->select('section')->remove();
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)