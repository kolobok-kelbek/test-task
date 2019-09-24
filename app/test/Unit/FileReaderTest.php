<?php

namespace kelbek\Test\Unit;

use kelbek\Exception\FileNotFoundException;
use kelbek\Exception\InvalidFileSizeException;
use kelbek\Exception\MimeTypeNotSupportedException;
use kelbek\FileReader;
use kelbek\Helper\ClassHelper;
use phpmock\phpunit\PHPMock;
use PHPUnit\Framework\TestCase;

class FileReaderTest extends TestCase
{
    use PHPMock;

    private const PATH_TO_RESOURCES = __DIR__ . '/../Resources/FileFixtures';

    /**
     * @runInSeparateProcess
     */
    public function testReadWithFileNotFoundException()
    {
        $maxFileSizeConstructArgument = 32;
        $testFilename = 'file.txt';
        $namespace = ClassHelper::getOnlyNamespace(FileReader::class);

        self::expectException(FileNotFoundException::class);
        self::expectExceptionMessage("File {$testFilename} not found.");

        $fileExists = $this->getFunctionMock($namespace, 'file_exists');
        $fileExists->expects($this->once())->willReturn(false);

        $reader = new FileReader($maxFileSizeConstructArgument);

        $reader->open($testFilename);
    }

    /**
     * @runInSeparateProcess
     */
    public function testReadWithInvalidFileSizeException()
    {
        $maxFileSizeConstructArgument = 32;
        $testFilename = 'file.txt';
        $namespace = ClassHelper::getOnlyNamespace(FileReader::class);
        $fileSize = 40;

        self::expectException(InvalidFileSizeException::class);
        self::expectExceptionMessage("A file with a size of no more than {$maxFileSizeConstructArgument} "
            . "bytes is allowed, {$fileSize} bytes were received");

        $fileExistsFunction = $this->getFunctionMock($namespace, 'file_exists');
        $fileExistsFunction->expects($this->once())->willReturn(true);

        $fileSizeFunction = $this->getFunctionMock($namespace, 'filesize');
        $fileSizeFunction->expects($this->once())->willReturn($fileSize);

        $reader = new FileReader($maxFileSizeConstructArgument);

        $reader->open($testFilename);
    }

    /**
     * @runInSeparateProcess
     */
    public function testReadWithMimeTypeNotSupportedException()
    {
        $maxFileSizeConstructArgument = 32;
        $permissibleFileExtensionsConstructArgument = ['text/plain'];
        $testFilename = 'file.txt';
        $namespace = ClassHelper::getOnlyNamespace(FileReader::class);
        $mimeTypeGet = 'png/binary';
        $fileSize = 16;

        self::expectException(MimeTypeNotSupportedException::class);
        self::expectExceptionMessage("File with {$mimeTypeGet} mime types not supported.");

        $fileExistsFunction = $this->getFunctionMock($namespace, 'file_exists');
        $fileExistsFunction->expects($this->once())->willReturn(true);

        $fileSizeFunction = $this->getFunctionMock($namespace, 'filesize');
        $fileSizeFunction->expects($this->once())->willReturn($fileSize);

        $mimeContentTypeFunction = $this->getFunctionMock($namespace, "mime_content_type");
        $mimeContentTypeFunction->expects($this->once())->willReturn($mimeTypeGet);

        $reader = new FileReader($maxFileSizeConstructArgument, $permissibleFileExtensionsConstructArgument);

        $reader->open($testFilename);
    }
}
