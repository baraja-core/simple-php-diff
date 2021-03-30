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
		$captureBuffer = [];

		for ($i = 0; isset($from[$i]); $i++) {
			$original = $from[$i] ?? '';
			$target = $to[$i] ?? '';
			$lineNumber = str_pad((string) ($i + 1), $padLength, ' ', STR_PAD_LEFT) . '| ';
			if ($original === $target) {
				if ($captureBuffer !== []) {
					foreach ($captureBuffer as $captureType => $captureLines) {
						foreach ($captureLines as $captureLine) {
							$return[] = $captureLine;
						}
					}
					$captureBuffer = [];
				}
				$return[] = '  ' . $lineNumber . $original;
			} else {
				$captureBuffer['-'][] = '- ' . $lineNumber . $this->prettyRender($original);
				$captureBuffer['+'][] = '+ ' . $lineNumber . $this->prettyRender($target);
				$changedLines[] = $i + 1;
			}
		}

		return new Diff($left, $right, implode("\n", $return), $changedLines);
	}


	public function renderDiff(Diff|string $diff): string
	{
		$return = [];
		foreach (explode("\n", is_string($diff) ? $diff : $diff->getDiff()) as $line) {
			if (($line[0] ?? '') === '+') {
				$return[] = '<div style="background:#a2f19c">' . htmlspecialchars($line) . '</div>';
			} elseif (($line[0] ?? '') === '-') {
				$return[] = '<div style="background:#e7acac">' . htmlspecialchars($line) . '</div>';
			} else {
				$return[] = '<div>' . htmlspecialchars($line) . '</div>';
			}
		}

		return '<pre class="code">' . implode("\n", $return) . '</pre>';
	}


	private function prettyRender(string $haystack): string
	{
		return str_replace(["\t", ' '], ['→→→→', '·'], $haystack);
	}
}
