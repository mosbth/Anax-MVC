<?php

namespace Anax\Content;

/**
 * A read content from filesystem.
 *
 */
class CFileContent
{

    /**
     * Properties
     *
     */
    private $path;



    /**
     * Get file as content.
     *
     * @param string $file with content
     *
     * @return string as content of the file
     *
     * @throws Exception when file does not exist
     */
    public function get($file) 
    {
        $target = $this->path . $file;

        if (!is_readable($target)) {
            throw new \Exception("No such content " . $target);
        }

        return file_get_contents($target);
    }



    /**
     * Set base path where  to find content.
     *
     * @param string $path where content reside
     *
     * @return $this
     */
    public function setBasePath($path) 
    {
        if (!is_dir($path)) {
            throw new \Exception("Base path for file content is not a directory: " . $path);
        }
        $this->path = rtrim($path, '/') . '/';

        return $this;
    }
}
