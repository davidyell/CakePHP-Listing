#CakePHP-Listing
Model behaviour to append an [optgroup](http://www.w3schools.com/tags/tag_optgroup.asp) into a list for a select box. The idea for this behaviour is that if you have a list of items which belong to another model, it will include that models name. So if you are looking for a specific item by it's relation, this will make that easier.

So we change,

```php
array(
    1 => 'First',
    2 => 'Second'
);
```
..into this..

```php
array(
    'Cats' => array(
        1 => 'First',
    ),
    'Dogs' => array(
        2 => 'Second'
    )
);
```

..and you should end up with nice option groups in your selects.  
![Select box with optgroup](http://i.imgur.com/QP7BhMl.png)

It works with multiselect too!  
![Multi select box with optgroup](http://i.imgur.com/1t1sRvI.png)

##Version
This is something I'd consider `beta`.  
I've created tests for this code and it achieves 96.88%.  
[![Build Status](https://travis-ci.org/davidyell/CakePHP-Listing.png?branch=master)](https://travis-ci.org/davidyell/CakePHP-Listing)


##Installation
This is a standard CakePHP plugin, so it will need to extracted or submoduled into your `app/Plugin` folder. I call it `Listing`, so it should live in `app/Plugin/Listing`.

You will need to activate the plugin in your `app/Config/bootstrap.php` using `CakePlugin::load('Listing')`, unless you are already using `CakePlugin::loadAll()`

##Requirements
* Cake 2
* Containable

The models you are using with this behaviour must have Containable enabled.
`public $actsAs = array('Containable', 'Listing.Listable');`
I tend to add Containable to my `AppModel` as it's handy to have everywhere!

##Usage
You can attach to the model using the `$actsAs` array. As you would normally.
You **must** include the name of the related model that you want to join to when you configure the behaviour.

This is usually the parent model in the relationship, as the behaviour will attach to the child. So if you want to list `Broadband` by `Provider` you would attach the behaviour to the `Broadband` model, and configure the `relatedModelName` as `Provider`.

###Configuration

You can also specify the fields that you want to use using, `primaryKey` and `displayField`.

```php
public $actsAs = array(
    'Listing.Listable' => array(
       'relatedModelName' => 'Provider', // Example - this should be the parent model, the one you want to group by
       'relatedModelPrimaryKey' => 'id', // optional - default shown
       'relatedModelDisplayField' => 'name', // optional - default shown
    )
);
```

[More on Behaviours in the Book](http://book.cakephp.org/2.0/en/models/behaviors.html).

###Getting a listing
Then in order to attach the extra model, I have implemented a custom find called `listing` which will return the formatted list.

For example,
`$broadbands = $this->Broadband->find('listing');`

##Todo
###Alpha
* ~~Write some tests~~
* ~~Tidy up the source a little~~
* ~~Look to refactor~~
* ~~Rewrite this README file!~~

###Beta
* Remove the dependancy on Containble
* Thrown an exception if the models are not related
