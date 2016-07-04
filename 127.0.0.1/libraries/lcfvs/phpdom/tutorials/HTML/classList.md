# <a name="title">PHPDOM</a>

The classLists

## <a name="summary">Summary</a>
* [Add some classes on an element](#add-some-classes-on-an-element)
* [Remove some classes from an element](#remove-some-classes-from-an-element)
* [Remove all classes from an element](#remove-all-classes-from-an-element)
* [Get all classes from an element](#get-all-classes-from-an-element)
* [Check if an element has a classes](#check-if-an-element-has-a-classes)

[Tutorials summary](./readme.md#summary)<br />
[Summary](../readme.md#summary)

## <a name="add-some-classes-on-an-element">Add some classes on an element [<i>chainable</i>]</a>
````PHP
$element->classList
    ->add('class1')
    ->add('class2', 'class3')
    ->add([
        'class4',
        'class5'
    ]);
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="remove-some-classes-from-an-element">Remove some classes from an element [<i>chainable</i>]</a>
````PHP
$element->classList
    ->remove('class1')
    ->remove('class2', 'class3')
    ->remove([
        'class4',
        'class5'
    ]);
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="remove-all-classes-from-an-element">Remove all classes from an element [<i>chainable</i>]</a>
````PHP
$element->classList->remove();
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="get-all-classes-from-an-element">Get all classes from an element</a>
````PHP
$element->classList->getAll();
````
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)

## <a name="check-if-an-element-has-some-classes">Check if an element has some classes</a>
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
[Summary](#summary)<br />
[Tutorials summary](./readme.md#summary)<br />
[Main summary](../readme.md#summary)