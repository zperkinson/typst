<?php

namespace ZPerkinson\Typst;

use RuntimeException;

class Typst
{
	private string $binaryPath;
	private ?string $filePath;
	private ?string $outputPath;
	private bool $test;

	public function __construct(Options $options)
	{
		$this->binaryPath = $options->binaryPath;
		$this->filePath = $options->filePath;
		$this->outputPath = $options->outputPath;
		$this->test = $options->test;

		if (!file_exists($this->binaryPath)) {
			throw new RuntimeException("Typst Binary path '$this->binaryPath' does not exist");
		}

		if (!empty($this->filePath) && !file_exists($this->filePath)) {
			throw new RuntimeException("File path '$this->filePath' does not exist");
		}

		if ($this->test) {
			$this->outputPath = '-';
		}
	}

	public function getFilePath(): ?string
	{
		return $this->filePath;
	}

	public function setFilePath(string $filePath): void
	{
		$this->filePath = $filePath;
	}

	public function compileAndReturn(): null|string
	{
		if (empty($this->filePath)) {
			$this->filePath = __DIR__;
		}

		@exec("$this->binaryPath compile $this->filePath - 2>&1", $output, $code);
		return $code === 0  ? implode("\n", $output) : null;
	}

	public function compile(): bool
	{
		if (empty($this->filePath)) {
			$this->filePath = __DIR__;
		}

		$extra = null;

		if ($this->test) {
			if (PHP_OS_FAMILY === 'Windows') {
				$extra = '> NUL';
			} else {
				$extra = '> /dev/null';
			}

		}

		@exec("$this->binaryPath compile $this->filePath $this->outputPath $extra 2>&1", $output, $code);

		return $code === 0;
	}
}