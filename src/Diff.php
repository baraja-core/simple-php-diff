<?php

declare(strict_types=1);

namespace Baraja\DiffGenerator;


final class Diff
{
	/**
	 * @param int[] $changedLines
	 */
	public function __construct(
		private string $original,
		private string $target,
		private string $diff,
		private array $changedLines,
	) {
	}


	public function __toString(): string
	{
		return $this->diff;
	}


	public function getOriginal(): string
	{
		return $this->original;
	}


	public function getTarget(): string
	{
		return $this->target;
	}


	public function getDiff(): string
	{
		return $this->diff;
	}


	/**
	 * @return int[]
	 */
	public function getChangedLines(): array
	{
		return $this->changedLines;
	}
}
