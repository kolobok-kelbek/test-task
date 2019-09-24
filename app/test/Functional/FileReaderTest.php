<?php

namespace kelbek\Test\Functional;

use kelbek\Exception\MimeTypeNotSupportedException;
use kelbek\FileReader;
use PHPUnit\Framework\TestCase;

class FileReaderTest extends TestCase
{
    private const PATH_TO_RESOURCES = __DIR__ . '/../Resources/FileFixtures';

    /**
     * @runInSeparateProcess
     */
    public function testReadTextFile()
    {
        $maxFileSizeConstructArgument = 2048;
        $pathToFile = static::PATH_TO_RESOURCES . '/test.txt';

        $reader = new FileReader($maxFileSizeConstructArgument);

        $reader->open($pathToFile);

        $text = '';

        while (true) {
            $line = $reader->readLine();

            if (null === $line) {
                break;
            }

            $text .= $line;
        }

        self::assertEquals($text, file_get_contents($pathToFile));
    }

    /**
     * @runInSeparateProcess
     */
    public function testReadJpegFile()
    {
        $maxFileSizeConstructArgument = 24000;
        $permissibleFileExtensionsConstructArgument = ['text/plain'];
        $pathToFile = static::PATH_TO_RESOURCES . '/test.jpeg';

        $reader = new FileReader($maxFileSizeConstructArgument, $permissibleFileExtensionsConstructArgument);
        $mimeTypeGet = 'image/jpeg';

        self::expectException(MimeTypeNotSupportedException::class);
        self::expectExceptionMessage("File with {$mimeTypeGet} mime types not supported.");

        $reader->open($pathToFile);
    }
}
