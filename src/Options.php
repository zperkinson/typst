<?php

namespace ZPerkinson\Typst;

class Options
{
	/**
	 * If enabled, all data is routed to appropriate null location
	 * @var bool
	 */
	public bool $test = false;
	/**
	 * The path to the Typst binary
	 * @var string
	 */
	public string $binaryPath = '/usr/bin/typst';

	/**
	 * The path to the Typst file
	 * @var ?string
	 */
	public ?string $filePath;

	/**
	 * The desired path for output.
	 * If not present, will use stdout.
	 * @var string|null
	 */
	public ?string $outputPath;

	public function __construct(string $binaryPath, ?string $filePath = null, ?string $outputPath = null, bool $test = false)
	{
		$this->binaryPath = $binaryPath;
		$this->filePath = $filePath;
		$this->outputPath = $outputPath;
		$this->test = false;
	}

}