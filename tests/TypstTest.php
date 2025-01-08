<?php

use PHPUnit\Framework\TestCase;
use ZPerkinson\Typst\Options;
use ZPerkinson\Typst\Typst;

class TypstTest extends TestCase
{
	private Options $options;

	public function setUp(): void
	{
		$binaryPath = $_ENV['TYPST_BINARY_PATH'];
		$this->options = new Options($binaryPath);
		$this->options->test = true;
	}

	public function testCompilesWorkingTypst(): void
	{
		$typst = new Typst($this->options);
		$path = dirname(__DIR__) .DIRECTORY_SEPARATOR . 'examples/basic.typ';
		$typst->setFilePath($path);
		$result = $typst->compile();
		$this->assertTrue($result);
	}

	public function testCompileFailsWithBadTypstFile(): void
	{
		$typst = new Typst($this->options);
		$path = dirname(__DIR__) .DIRECTORY_SEPARATOR . 'examples/broken.typ';
		$typst->setFilePath($path);
		$result = $typst->compile();
		$this->assertFalse($result);
	}

	public function testCompilesYamlSuccessFully(): void
	{
		$typst = new Typst($this->options);
		$path = dirname(__DIR__) .DIRECTORY_SEPARATOR . 'examples/yaml.typ';
		$typst->setFilePath($path);
		$result = $typst->compile();
		$this->assertTrue($result);
	}


	public function testCompilesAndReturnsReturnsStringWhenSuccess(): void
	{
		$typst = new Typst($this->options);
		$path = dirname(__DIR__) .DIRECTORY_SEPARATOR . 'examples/yaml.typ';
		$typst->setFilePath($path);
		$result = $typst->compileAndReturn();
		$this->assertStringContainsString('PDF-1.7', $result);
	}
}