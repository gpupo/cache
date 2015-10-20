<?php

/*
 * This file is part of gpupo\cache
 *
 * (c) Gilmar Pupo <g@g1mr.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gpupo\Cache\Driver;

/**
 * Driver utilizing the filesystem.
 */
class FilesystemDriver extends DriverAbstract implements DriverInterface
{
    /**
     * Path to directory to cache contents in.
     *
     * @type string
     */
    protected $path = '';

    /**
     * FilesystemDriver constructor.
     *
     * @param null|string $path The path to set
     *
     * @author Benjamin Carl <opensource@clickalicious.de>
     */
    public function __construct($path = null)
    {
        // Use systems temp directory as default
        if (null === $path) {
            $path = sys_get_temp_dir();
        }

        $this
            ->path($path);
    }

    /**
     * Stores content in cache.
     *
     * @param string $id        Contents identifier
     * @param mixed  $obj       Content itself
     * @param int    $ttl       Time to live (Lifetime of content)
     * @param bool   $serialize Whether the content must be serialized, or not
     *
     * @return bool TRUE on success, otherwise FALSE
     */
    public function save($id, $obj, $ttl, $serialize = true)
    {
        // Check if driver supported by system
        if (false === $this->isSupported()) {
            throw new \RuntimeException(
                'Driver not supported!'
            );
        }

        // Check key
        if (false === $this->isValidKey($id)) {
            throw new \RuntimeException(
                sprintf('The key: "%s" is invalid!', var_export($id, true))
            );
        }

        // Get filename
        $filename = $this->getFilenameById($id);

        // If the file exists, check if writable ...
        if (true === file_exists($filename)) {
            if (false === is_writable($filename)) {
                throw new \RuntimeException(
                    sprintf('File: "%s" exists and isn\'t writable!', $filename)
                );
            }
        }

        $obj = $this->serialize($obj, $serialize);

        return file_put_contents($filename, $obj);
    }

    /**
     * Returns cached content by its Id.
     *
     * @param string $id          Id of the cached content
     * @param bool   $unserialize Controls whether unserialization is required or not
     *
     * @author Benjamin Carl <opensource@clickalicious.de>
     *
     * @return null|mixed The cached content if exist, otherwise NULL
     */
    public function get($id, $unserialize = true)
    {
        // Check if driver supported by system
        if (false === $this->isSupported()) {
            throw new \RuntimeException(
                'Driver not supported!'
            );
        }

        // Check key
        if (false === $this->isValidKey($id)) {
            throw new \RuntimeException(
                sprintf('The key: "%s" is invalid!', var_export($id, true))
            );
        }

        // Get filename
        $filename = $this->getFilenameById($id);
        $content  = null;

        if (true === file_exists($filename)) {
            if (false === is_readable($filename)) {
                throw new \RuntimeException(
                    sprintf('File: "%s" isn\'t readable!', $filename)
                );
            }

            $content = file_get_contents($filename);
            $content = $this->unserialize($content, $unserialize);
        }

        return $content;
    }

    /**
     * Removes content from cache.
     *
     * @param string $id The Id of the content to delete from cache
     *
     * @author Benjamin Carl <opensource@clickalicious.de>
     *
     * @return bool TRUE on success, otherwise FALSE
     */
    public function delete($id)
    {
        // Check if driver supported by system
        if (false === $this->isSupported()) {
            throw new \RuntimeException(
                'Driver not supported!'
            );
        }

        // Check key
        if (false === $this->isValidKey($id)) {
            throw new \RuntimeException(
                sprintf('The key: "%s" is invalid!', var_export($id, true))
            );
        }

        // Get filename
        $filename = $this->getFilenameById($id);
        $result   = false;

        if (true === file_exists($filename)) {
            if (false === is_writable($filename)) {
                throw new \RuntimeException(
                    sprintf('File: "%s" isn\'t writable and cannot be deleted!', $filename)
                );
            }

            if (true === is_dir($filename)) {
                throw new \RuntimeException(
                    sprintf('Filesystem protection: Delete failed - file: "%s" seems to be a directory!', $filename)
                );
            }

            $result = unlink($filename);
        }

        return $result;
    }

    /**
     * Setter for path.
     *
     * @param string $path The path to set
     *
     * @author Benjamin Carl <opensource@clickalicious.de>
     */
    public function setPath($path)
    {
        if (false === file_exists($path)) {
            throw new \RuntimeException(
                sprintf('Path "%s" does not exist!', $path)
            );
        }

        if (false === is_writable($path)) {
            throw new \RuntimeException(
                sprintf('Path "%s" isn\'t writable!', $path)
            );
        }

        if (DIRECTORY_SEPARATOR !== $path[strlen($path) - 1]) {
            $path .= DIRECTORY_SEPARATOR;
        }

        $this->path = $path;
    }

    /**
     * Fluent: Setter for path.
     *
     * @param string $path The path to set
     *
     * @author Benjamin Carl <opensource@clickalicious.de>
     *
     * @return $this Instance for chaining
     */
    protected function path($path)
    {
        $this->setPath($path);

        return $this;
    }

    /**
     * Getter for path.
     *
     * @author Benjamin Carl <opensource@clickalicious.de>
     *
     * @return string|null The path if set, otherwise NULL
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Returns the filename to cached content by its Id.
     *
     * @param string $id The Id to return filename for
     *
     * @author Benjamin Carl <opensource@clickalicious.de>
     *
     * @return string The filename
     */
    protected function getFilenameById($id)
    {
        return $this->getPath().$id;
    }

    /**
     * Check for supported.
     *
     * @author Benjamin Carl <opensource@clickalicious.de>
     *
     * @return bool TRUE if supported, otherwise FALSE
     */
    public function isSupported()
    {
        return file_exists($this->getPath());
    }
}
