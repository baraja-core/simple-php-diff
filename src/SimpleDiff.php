<?php

declare(strict_types=1);

namespace Baraja\DiffGenerator;


final class SimpleDiff
{
	public function compare(string $left, string $right, bool $strict = false): Diff
	{
		if ($strict === false) {
			$left = str_replace(["\r\n", "\r"], "\n", trim($left));
			$right = str_replace(["\r\n", "\r"], "\n", trim($right));
		}

		$return = [];
		$from = explode("\n", $left);
		$to = explode("\n", $right);
		$changedLines = [];

		for ($i = 0; isset($from[$i]); $i++) {
			$original = $from[$i] ?? '';
			$target = $to[$i] ?? '';
			$lineNumber = str_pad(($i + 1) . ':', 6, ' ') . ' ';
			if ($original === $target) {
				$return[] = $lineNumber . '  ' . $original;
			} else {
				$return[] = '- ' . $lineNumber . $this->prettyRender($original);
				$return[] = '+ ' . $lineNumber . $this->prettyRender($target);
				$changedLines[] = $i + 1;
			}
		}

		return new Diff($left, $right, implode("\n", $return), $changedLines);
	}


	private function prettyRender(string $haystack): string
	{
		return str_replace(["\t", ' '], ['→→→→', '·'], $haystack);
	}
}
