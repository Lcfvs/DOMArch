# PHPDOM
[PHPDOM](../../../../readme.md#summary) >
[Tutorials](../../../readme.md#summary) >
[HTML](../../readme.md#summary) >
[Element](../readme.md#summary) >
[Dataset](./readme.md#summary)

## <a name="summary">Summary</a>
* [Get the element dataset](#Get-the-element-dataset)
* [Create a data-* attribute](#Create-a-data-attribute)
* [Create a data-* attribute value](#Create-a-data-attribute-value)
* [Remove a data-* attribute](#Remove-a-data-attribute)
* [Get all data-* attributes](#Get-all-data-attributes)

## <a name="Get-the-element-dataset">Get the element dataset</a>
```PHP
$dataset = $element->dataset;
```
[^](#summary)

## <a name="Create-a-data-attribute">Create a data-* attribute</a>
```PHP
$element->dataset->attributeName = 'value';
```
[^](#summary)

## <a name="Create-a-data-attribute-value">Create a data-* attribute value</a>
```PHP
$value = $element->dataset->attributeName;
```
[^](#summary)

## <a name="Remove-a-data-attribute">Remove a data-* attribute</a>
```PHP
$element->dataset->attributeName = null;
```
[^](#summary)

## <a name="Get-all-data-attributes">Get all data-* attributes</a>
```PHP
$data_values = $element->dataset->getAll();
```
[^](#summary)

[PHPDOM](../../../../readme.md#summary) >
[Tutorials](../../../readme.md#summary) >
[HTML](../../readme.md#summary) >
[Element](../readme.md#summary) >
[Dataset](./readme.md#summary)