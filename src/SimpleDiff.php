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
		$padLength = strlen((string) max(count($from), count($to)));
		$changedLines = [];

		for ($i = 0; isset($from[$i]); $i++) {
			$original = $from[$i] ?? '';
			$target = $to[$i] ?? '';
			$lineNumber = str_pad((string) ($i + 1), $padLength, ' ', STR_PAD_LEFT) . '| ';
			if ($original === $target) {
				$return[] = '  ' . $lineNumber . $original;
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
