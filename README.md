CakePHP-Listing
===============

Model behaviour to append a field into a list for a select box. The idea for this behaviour is that if you have a list of items which belong to another model, it will include that models name.

So we change,
```
array(
  1 => 'First',
  2 => 'Second'
);
```
Into this using string mode
```
array(
  1 => '(Cats) First',
  2 => '(Dogs) Second'
);
```
or, using array mode
```
array(
  'Cats' => array(
    1 => 'First',
  ),
  'Dogs' => array(
    2 => 'Second'
  )
);
```