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

Comparison mode
---------------

This tool supports strict and basic comparison modes (strict mode is disabled by default).
Strict mode also allows you to compare changes in different line wrapping methods (for example, `"\n"` and so on).
