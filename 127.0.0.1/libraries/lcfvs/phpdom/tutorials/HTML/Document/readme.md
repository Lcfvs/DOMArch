# PHPDOM
[PHPDOM](../../../readme.md#summary) >
[Tutorials](../../readme.md#summary) >
[HTML](../readme.md#summary) >
[Document](./readme.md#summary)

## <a name="Summary">Summary</a>
* [Create a document](#Create-a-document)
* [Manipulate the title](#Manipulate-the-title)
* [Save a document](#Save-a-document)

## <a name="Create-a-document">Create a document</a>
````PHP
// empty document
$document = new \PHPDOM\HTML\Document();
// or with the minimal code (HTML5)
$document = new \PHPDOM\HTML\Document(true);
````
[^](#summary)

## <a name="Manipulate-the-title">Manipulate the title</a>
````PHP
// get the title text
$title = $document->title;

// set the title
$document->title = 'This is the title';

// add some data to the title
$document->title .= ' !!!';
````
[^](#summary)

## <a name="Get-the-document-body">Get the document body</a>
````PHP
$body = $document->body;
````
[^](#summary)

## <a name="Save-a-document">Save a document</a>
````PHP
$document = $document->save('path');
````
[^](#summary)

[PHPDOM](../../../readme.md#summary) >
[Tutorials](../../readme.md#summary) >
[HTML](../readme.md#summary) >
[Document](./readme.md#summary)