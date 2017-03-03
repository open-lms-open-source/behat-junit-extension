<?php

namespace Moodlerooms\BehatJUnitExtension;

use Behat\Testwork\Output\Exception\BadOutputPathException;
use Behat\Testwork\Output\Printer\OutputPrinter;

class Printer implements OutputPrinter
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $fileName;

    /**
     * @param string $path Path to write JUnit XML files
     */
    public function __construct($path)
    {
        $this->setOutputPath($path);
    }

    /**
     * Sets file name.
     *
     * @param string $fileName
     * @param string $extension The file extension, defaults to "xml"
     */
    public function setFileName($fileName, $extension = 'xml')
    {
        if ('.'.$extension !== substr($fileName, strlen($extension) + 1)) {
            $fileName .= '.'.$extension;
        }

        $this->fileName = $fileName;
    }

    /**
     * {@inheritdoc}
     */
    public function setOutputPath($path)
    {
        $realPath = realpath($path);

        if ($realPath === false) {
            throw new BadOutputPathException(sprintf('The argument to `output` is expected to the a directory, but got %s!', $path), $path);
        }
        if (!is_dir($realPath)) {
            throw new BadOutputPathException(sprintf('The argument to `output` is expected to the a directory, but got %s!', $path), $path);
        }
        $this->path = $realPath;
    }

    /**
     * {@inheritdoc}
     */
    public function getOutputPath()
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function setOutputStyles(array $styles)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getOutputStyles()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function setOutputDecorated($decorated)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function isOutputDecorated()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function setOutputVerbosity($level)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getOutputVerbosity()
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function write($messages)
    {
        $file = $this->getOutputPath().DIRECTORY_SEPARATOR.$this->fileName;
        file_put_contents($file, $messages);
    }

    /**
     * {@inheritdoc}
     */
    public function writeln($messages = '')
    {
    }

    /**
     * {@inheritdoc}
     */
    public function flush()
    {
    }
}
