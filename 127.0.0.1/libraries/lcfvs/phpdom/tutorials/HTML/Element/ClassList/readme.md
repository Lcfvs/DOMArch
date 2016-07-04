# PHPDOM
[PHPDOM](../../../../readme.md#summary) >
[Tutorials](../../../readme.md#summary) >
[HTML](../../readme.md#summary) >
[Element](../readme.md#summary) >
[ClassList](./readme.md#summary)

## <a name="summary">Summary</a>
* [Add some classes on an element](#Add-some-classes-on-an-element)
* [Remove some classes from an element](#Remove-some-classes-from-an-element)
* [Remove all classes from an element](#Remove-all-classes-from-an-element)
* [Toggle some classes on an element](#Toggle-some-classes-on-an-element)
* [Get all classes from an element](#Get-all-classes-from-an-element)
* [Check if an element has some classes](#Check-if-an-element-has-some-classes)

## <a name="Add-some-classes-on-an-element">Add some classes on an element</a>
````PHP
$element->classList
    ->add('class1')
    ->add('class2', 'class3')
    ->add([
        'class4',
        'class5'
    ]);
````
[^](#summary)

## <a name="Remove-some-classes-from-an-element">Remove some classes from an element</a>
````PHP
$element->classList
    ->remove('class1')
    ->remove('class2', 'class3')
    ->remove([
        'class4',
        'class5'
    ]);
````
[^](#summary)

## <a name="Remove-all-classes-from-an-element">Remove all classes from an element</a>
````PHP
$element->classList->remove();
````
[^](#summary)

## <a name="Toggle-some-classes-on-an-element">Toggle some classes on an element</a>
````PHP
$element->classList
    ->toggle('class1')
    ->toggle('class2', 'class3')
    ->toggle([
        'class4',
        'class5'
    ]);
````
[^](#summary)

## <a name="Get-all-classes-from-an-element">Get all classes from an element</a>
````PHP
$element->classList->getAll();
````
[^](#summary)

## <a name="Check-if-an-element-has-some-classes">Check if an element has some classes</a>
````PHP
$has_class = $element->classList->contains('class1');
// or
$has_classes = $element->classList->contains('class1', 'class2');
// or
$has_classes = $element->classList->contains([
    'class1',
    'class2'
]);
````
[^](#summary)

[PHPDOM](../../../../readme.md#summary) >
[Tutorials](../../../readme.md#summary) >
[HTML](../../readme.md#summary) >
[Element](../readme.md#summary) >
[ClassList](./readme.md#summary)