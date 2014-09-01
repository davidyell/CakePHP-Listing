#CakePHP-Listing
Model behaviour to append an [optgroup](http://www.w3schools.com/tags/tag_optgroup.asp) into a list for a select box. The idea for this behaviour is that if you have a list of items which belong to another model, it will include that models name. So if you are looking for a specific item by it's relation, this will make that easier.
I have created a website for the plugin, with more detailed information. [http://jedistirfry.co.uk/CakePHP-Listing/](http://jedistirfry.co.uk/CakePHP-Listing/)

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
[![Build Status](https://travis-ci.org/davidyell/CakePHP-Listing.svg?branch=master)](https://travis-ci.org/davidyell/CakePHP-Listing)


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

###Customising your listing
The easiest way to customise the display of your listing is to use the models `$virtualFields` property to create new fields which you can then pass into the find. Let's look at an example.

We want a listing of all the Users grouped by role. However our database has both `first_name` and `last_name`, but we want to display a listing of the users full name. We can create a virtual field and select that.

```php
<?php
// app/Model/User.php
public $virtualFields = [
    'full_name' => 'CONCAT(User.first_name, ' ', User.last_name)'
];

// app/Controller/UsersController.php
$users = $this->User->find('listing', ['fields' => ['id', 'full_name']]);
```

##Todo
###Alpha
* ~~Write some tests~~
* ~~Tidy up the source a little~~
* ~~Look to refactor~~
* ~~Rewrite this README file!~~

###Beta
* Remove the dependancy on Containble
* Thrown an exception if the models are not related

##License
The MIT License (MIT)

Copyright (c) 2013 David Yell

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
