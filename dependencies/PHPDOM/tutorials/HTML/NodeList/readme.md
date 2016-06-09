# PHPDOM
[PHPDOM](../../../readme.md#summary) >
[Tutorials](../../readme.md#summary) >
[HTML](../readme.md#summary) >
[NodeList](./readme.md#summary)

## <a name="summary">Summary</a>
* [Get the nodeList length](#Get-the-nodeList-length)
* [Apply a callback on each node list elements](#Apply-a-callback-on-each-nodelist-elements)
* [Apply a callback on every node list elements](#Apply-a-callback-on-every-nodelist-elements)
* [Remove all nodes in a nodeList](#remove-all-nodes-in-a-nodeList)
* [Stringify a nodeList](#Stringify-a-nodeList)

## <a name="Get-the-nodeList-length">Get the nodeList length</a>
````PHP
$html = $document->body->select('*')->length;
````
[^](#summary)

## <a name="Apply-a-callback-on-each-nodelist-elements">Apply a callback on each node list elements</a>
````PHP
$result = $document->selectAll('*')->each(function ($element, $index, $node_list) {
    $element->setAttribute('id', 'element_' . $index);
});
````
[^](#summary)

## <a name="Apply-a-callback-on-every-nodelist-elements">Apply a callback on every node list elements</a>
<b>Note :</b> Unlike `$fragment->each()`, this method stops to iterate as soon as the callback returns a falsy value.
````PHP
$result = $document->selectAll('*')->each(function ($element, $index, $node_list) {
    $element->setAttribute('id', 'element_' . $index);

    return $index < 3;
});
````
[^](#summary)

## <a name="Remove-anodes-in-a-nodeList">Remove all nodes in a nodeList</a>
````PHP
$child_nodes = $document->body->childNodes->remove();
````
[^](#summary)

## <a name="Stringify-a-nodeList">Stringify a nodeList</a>
````PHP
$html = $document->body->select('*')->__toString();
````
[^](#summary)

[PHPDOM](../../../readme.md#summary) >
[Tutorials](../../readme.md#summary) >
[HTML](../readme.md#summary) >
[NodeList](./readme.md#summary)