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
			$original = $from[$i];
			$target = $to[$i] ?? '';
			$lineNumber = sprintf('%s| ', str_pad((string) ($i + 1), $padLength, ' ', STR_PAD_LEFT));
			if ($original === $target) {
				if ($captureBuffer !== []) {
					foreach ($captureBuffer as $captureLines) {
						foreach ($captureLines as $captureLine) {
							$return[] = $captureLine;
						}
					}
					$captureBuffer = [];
				}
				$return[] = sprintf('  %d%s', $lineNumber, $original);
			} else {
				$captureBuffer['-'][] = sprintf('- %d%s', $lineNumber, $this->prettyRender($original));
				$captureBuffer['+'][] = sprintf('+ %d%s', $lineNumber, $this->prettyRender($target));
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
				$return[] = sprintf('<div style="background:#a2f19c">%s</div>', htmlspecialchars($line));
			} elseif (($line[0] ?? '') === '-') {
				$return[] = sprintf('<div style="background:#e7acac">%s</div>', htmlspecialchars($line));
			} else {
				$return[] = sprintf('<div>%s</div>', htmlspecialchars($line));
			}
		}

		return sprintf('<pre class="code">%s</pre>', implode("\n", $return));
	}


	private function prettyRender(string $haystack): string
	{
		return str_replace(["\t", ' '], ['→→→→', '·'], $haystack);
	}
}
