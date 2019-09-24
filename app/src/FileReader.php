<?php

declare(strict_types=1);

namespace kelbek;

use Exception;
use kelbek\Exception\{FileNotFoundException, InvalidFileSizeException, MimeTypeNotSupportedException, ReadException};

final class FileReader implements Reader
{
    private $handle;

    private $maxFileSize;

    private $permissibleFileExtensions;

    public function __construct(int $maxFileSize, array $permissibleFileExtensions = [])
    {
        $this->maxFileSize = $maxFileSize;
        $this->permissibleFileExtensions = $permissibleFileExtensions;
    }

    /**
     * @param string $filename
     * @throws FileNotFoundException
     * @throws ReadException
     * @throws MimeTypeNotSupportedException
     * @throws InvalidFileSizeException
     */
    public function open(string $filename): void
    {
        if (!file_exists($filename)) {
            throw new FileNotFoundException("File {$filename} not found.");
        }

        $fileSize = filesize($filename);

        if ($fileSize > $this->maxFileSize) {
            throw new InvalidFileSizeException(
                "A file with a size of no more than {$this->maxFileSize} "
                . "bytes is allowed, {$fileSize} bytes were received"
            );
        }

        if (!empty($this->permissibleFileExtensions)) {
            $mimeType = mime_content_type($filename);

            if (!in_array($mimeType, $this->permissibleFileExtensions)) {
                throw new MimeTypeNotSupportedException("File with {$mimeType} mime types not supported.");
            }
        }

        try {
            $this->handle = @fopen($filename, "r");
        } catch (Exception $e) {
            throw new ReadException("Error opening file '{$filename}'.", 0, $e);
        }
    }

    /**
     * @return string|null
     */
    public function readLine(): ?string
    {
        if (!$this->handle) {
            return null;
        }

        $buffer = fgets($this->handle);

        if (!$buffer || feof($this->handle)) {
            return null;
        }

        return $buffer;
    }

    public function close(): void
    {
        fclose($this->handle);
        $this->handle = null;
    }


}