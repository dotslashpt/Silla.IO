<?php
/**
 * FileSystem Cache Adapter.
 *
 * @package    Silla.IO
 * @subpackage Core\Modules\Cache\Adapters
 * @author     Plamen Nikolov <plamen@athlonsofia.com>
 * @copyright  Copyright (c) 2015, Silla.io
 * @license    http://opensource.org/licenses/GPL-3.0 GNU General Public License, version 3.0 (GPLv3)
 */

namespace Core\Modules\Cache\Adapters;

use Core;
use Core\Helpers\File;

/**
 * Class FileSystem Adapter for caching data.
 */
class FileSystem implements Core\Modules\Cache\Interfaces\Adapter
{
    /**
     * Storage path.
     *
     * @var string
     */
    private $storagePath;

    /**
     * Filesystem adapter constructor.
     *
     * @param array $settings Configuration settings.
     */
    public function __construct(array $settings)
    {
        $this->storagePath = '';
    }

    /**
     * Stores value by key.
     *
     * @param string  $key    Cache key.
     * @param mixed   $value  Cache value.
     * @param integer $expire Expiration time, in seconds(optional).
     *
     * @uses   Core\Helpers\File
     *
     * @return boolean
     */
    public function store($key, $value, $expire = 0)
    {
        if ($expire) {
            $expire = time() + $expire;
        }

        $content = array($expire, $value);

        return File::putContents($this->storagePath() . self::generateName($key), json_encode($content));
    }

    /**
     * Fetches stored value by key.
     *
     * @param string $key Cache key.
     *
     * @return mixed
     */
    public function fetch($key)
    {
        $file   = self::storagePath() . self::generateName($key);
        $expire = null;
        $value  = null;

        try {
            $content = File::getContents($file);
            if ($content) {
                list($expire, $value) = json_decode($content, true);
            }
        } catch (\Exception $e) {
            return null;
        }

        if ($expire && $expire < time()) {
            try {
                File::delete($file);
            } catch (\Exception $e) {
                // Do nothing.
            }

            return null;
        }

        return $value;
    }

    /**
     * Checks if a key-value pair exists.
     *
     * @param string $key Cache key.
     *
     * @return boolean
     */
    public function exists($key)
    {
        $file = $this->storagePath() . self::generateName($key);
        $file = File::getFullPath($file);

        return is_file($file);
    }

    /**
     * Removes a key-value pair.
     *
     * @param string $key Cache key.
     *
     * @return boolean
     */
    public function remove($key)
    {
        $file = $this->storagePath() . self::generateName($key);

        try {
            return File::delete($file);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Generates cache name.
     *
     * @param string $key Cache key.
     *
     * @static
     *
     * @return string
     */
    private static function generateName($key)
    {
        return md5($key) . '.tmp';
    }

    /**
     * Generates storage path.
     *
     * @return string
     */
    private function storagePath()
    {
        return $this->storagePath . 'cache' . DIRECTORY_SEPARATOR;
    }
}
