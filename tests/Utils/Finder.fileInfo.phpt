<?php

/**
 * Test: Nette\Utils\Finder result test.
 */

declare(strict_types=1);

use Nette\Utils\FileInfo;
use Nette\Utils\Finder;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';


test('absolute path', function () {
	$files = Finder::findFiles(basename(__FILE__))
		->in(__DIR__)
		->collect();

	Assert::equal(
		[__FILE__ => new FileInfo(__FILE__)],
		$files,
	);

	$file = reset($files);
	Assert::same(__FILE__, (string) $file);
	Assert::same('', $file->getRelativePath());
	Assert::same('Finder.fileInfo.phpt', $file->getRelativePathname());
});


test('relative path', function () {
	$files = Finder::findFiles('file.txt')
		->from('fixtures.finder')
		->collect();

	$files = array_values($files);
	Assert::same('', $files[0]->getRelativePath());
	Assert::same('file.txt', $files[0]->getRelativePathname());

	$ds = DIRECTORY_SEPARATOR;
	Assert::same('subdir', $files[1]->getRelativePath());
	Assert::same("subdir{$ds}file.txt", $files[1]->getRelativePathname());
});
