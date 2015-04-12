# <a name="title"></a>PHPDOM

Get the elements

## <a name="summary"></a>Summary
* [Get the document body](#get-the-document-body)
* [Get the document forms](#get-the-document-forms)
* [Get the document form elements](#get-the-document-form-elements)
* [Get the element children](#get-the-element-children)
* [Select an element](#select-an-element)
* [Select all elements](#select-all-elements)

[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="get-the-document-body">Get the document body</a>
````PHP
$body = $document->body;
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="get-the-document-forms">Get the document forms</a>
````PHP
$node_list = $document->forms;
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="get-the-document-form-elements">Get the document form elements</a>
````PHP
$node_list = $document->forms->item(0)->elements;
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="get-the-element-children">Get the element children</a>
````PHP
$node_list = $document->children();
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="select-an-element">Select an element</a>
````PHP
$element = $document->select('selectors');
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="select-all-elements">Select all elements</a>
````PHP
$node_list = $document->selectAll('selectors');
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)