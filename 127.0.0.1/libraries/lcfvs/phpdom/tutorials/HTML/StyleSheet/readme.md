# PHPDOM
[PHPDOM](../../../readme.md#summary) >
[Tutorials](../../readme.md#summary) >
[HTML](../readme.md#summary) >
[StyleSheet](./readme.md#summary)

## <a name="summary">Summary</a>
* [Add a stylesheet](#Add-a-stylesheet)

## <a name="add-a-stylesheet">Add a stylesheet</a>
````PHP
// /css/style.css
$link = $document->addStyleSheet('style.css');

// /directory/style.css
$link = $document->addStyleSheet('style.css', '/directory/');

// /css/style.css
$link = $document->addStyleSheet('style.css', null, [/* extra attributes */]);
````
[^](#summary)

[PHPDOM](../../../readme.md#summary) >
[Tutorials](../../readme.md#summary) >
[HTML](../readme.md#summary) >
[StyleSheet](./readme.md#summary)