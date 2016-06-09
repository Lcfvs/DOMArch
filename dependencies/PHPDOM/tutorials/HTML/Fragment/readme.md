# PHPDOM
[PHPDOM](../../../readme.md#summary) >
[Tutorials](../../readme.md#summary) >
[HTML](../readme.md#summary) >
[Fragment](./readme.md#summary)

## <a name="summary">Summary</a>
* [Create a fragment from a file](#Create-a-fragment-from-a-file)
* [Create a fragment from a string](#Create-a-fragment-from-a-string)

## <a name="Create-a-fragment-from-a-file">Create a fragment from a file</a>
<b>Note :</b> This method as the same options as [file_get_contents()](http://php.net/manual/function.file-get-contents.php)
````PHP
$document_fragment = $document->loadFragmentFile('/path-or-url');
````
[^](#summary)

## <a name="Create-a-fragment-from-a-string">Create a fragment from a string</a>
````PHP
$document_fragment = $document->loadFragment('<p>Content</p>');
````
[^](#summary)

[PHPDOM](../../../readme.md#summary) >
[Tutorials](../../readme.md#summary) >
[HTML](../readme.md#summary) >
[Fragment](./readme.md#summary)