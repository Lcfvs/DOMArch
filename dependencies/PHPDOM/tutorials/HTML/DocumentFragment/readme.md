# PHPDOM
[PHPDOM](../../../readme.md#summary) >
[Tutorials](../../readme.md#summary) >
[HTML](../readme.md#summary) >
[DocumentFragment](./readme.md#summary)

## <a name="summary">Summary</a>
* [Create a document fragment from a file](#Create-a-document-fragment-from-a-file)
* [Create a document fragment from a string](#Create-a-document-fragment-from-a-string)

## <a name="Create-a-document-fragment-from-a-file">Create a document fragment from a file</a>
<b>Note :</b> This method has the same options as [file_get_contents()](http://php.net/manual/function.file-get-contents.php), then, you can load a remote fragment.
````PHP
$document_fragment = $document->loadFragmentFile('/path-or-url');
````
[^](#summary)

## <a name="Create-a-document-fragment-from-a-string">Create a document fragment from a string</a>
````PHP
$document_fragment = $document->loadFragment('<p>Content</p>');
````
[^](#summary)

[PHPDOM](../../../readme.md#summary) >
[Tutorials](../../readme.md#summary) >
[HTML](../readme.md#summary) >
[DocumentFragment](./readme.md#summary)