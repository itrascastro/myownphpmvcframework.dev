<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 11/12/13
 * Time: 10:28
 */

namespace xen;

/*
 * TODO
 * Performance Modification
 * makes $_basePath an array of path's
 * faster if there is only one function in spl_autoload stack (var_dump(spl_autoload_functions()))
 */
class Autoloader
{
    private $_basePath;

    public function __construct($_basePath = '')
    {
        $this->_basePath = $_basePath;
    }

    public function register()
    {
        spl_autoload_register(array($this,'_autoload'));
    }

    /*
     * It is mandatory to put the require_once sentence into an if statement
     * Otherwise php autoload will use this function even if the file does not exist
     *
     * We use require instead of require_once because of better performance
     * require_once looks into a log every time we try to require a file
     * info: http://gazehawk.com/blog/php-require-performance/
     *
     * TODO
     * file_exists is not good for performance (a file system access every time we instantiate an object)
     * read: http://stackoverflow.com/questions/1713820/spl-autoloading-best-practices
     */
    private function _autoload($className)
    {
        $file = str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
        if ($this->_basePath != '') {
            $file = $this->_basePath . '/' . $file;
        }
        if (file_exists($file)) {
            require $file;
            return true;
        }
        return false;
    }
}
