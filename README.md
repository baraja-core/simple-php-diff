Simple PHP diff
===============

Find the quick difference between two text files in PHP.

Example
-------

![Default theme](doc/simple-diff.png)

Diff can be rendered to HTML (with native method `SimpleDiff::renderDiff($diff)`:

![Default theme](doc/diff-to-html.png)

Idea
----

The library compares two text files very quickly and returns the object with the differences.

The difference has numbered lines for easy display of changes to the user. You can also read an array of changed rows as an integer array from the `Diff` object as you browse for changes.

How to use
----------

Simply create a SimpleDiff instance and compare the two files:

```php
$left = 'First text';
$right = 'Second text';

$diff = (new \Baraja\DiffGenerator\SimpleDiff)->compare($left, $right);

// simple render diff
echo '<code><pre>'
     . htmlspecialchars((string) $diff)
     . '</pre></code>';
```

The `compare()` method returns a complete object `Diff` with the results of the comparison, from which you can get much more.

For example, to get a list of changed rows:

```php
echo 'Changed lines: ';
echo implode(', ', $diff->getChangedLines());
```

Display the Diff in HTML
------------------------

Very often we need to display the differences directly in the browser, for this the native method `renderDiff()` is suitable.

```php
$left = 'First text';
$right = 'Second text';

$simpleDiff = new \Baraja\DiffGenerator\SimpleDiff;
$diff = $![image](https://user-images.githubusercontent.com/4738758/113039971-8eb1b700-9198-11eb-9960-544be342d9ff.png)
![image](https://user-images.githubusercontent.com/4738758/113039973-8eb1b700-9198-11eb-895f-805ea0ec470e.png)
![image](https://user-images.githubusercontent.com/4738758/113039976-8f4a4d80-9198-11eb-928a-4b5d2b4f4533.png)
![image](https://user-images.githubusercontent.com/4738758/113039981-8fe2e400-9198-11eb-8d95-9bcd258fc81b.png)
![image](https://user-images.githubusercontent.com/4738758/113039978-8f4a4d80-9198-11eb-96e7-695ade2fd592.png)
![image](https://user-images.githubusercontent.com/4738758/113039983-8fe2e400-9198-11eb-8bcd-821aae346cb0.png)
![image](https://user-images.githubusercontent.com/4738758/113039982-8fe2e400-9198-11eb-8c32-0fd1c57d97d8.png)
![image](https://user-images.githubusercontent.com/4738758/113039987-92453e00-9198-11eb-8da0-3208d0fd6816.png)
simpleDiff->compare($left, $right);

echo $simpleDiff->renderDiff($diff);
```

The method accepts Diff and returns valid treated HTML that can be displayed directly to the user.

Comparison mode
---------------

This tool supports strict and basic comparison modes (strict mode is disabled by default).
Strict mode also allows you to compare changes in different line wrapping methods (for example, `"\n"` and so on).
