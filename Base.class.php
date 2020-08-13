<?php

    // namespace
    namespace TurtlePHP\Plugin;

    /**
     * Base
     * 
     * @author  Oliver Nassar <onassar@gmail.com>
     * @abstract
     */
    abstract class Base
    {
        /**
         * _checkConfigPluginDependency
         * 
         * @throws  \Exception
         * @access  protected
         * @static
         * @return  bool
         */
        protected static function _checkConfigPluginDependency(): bool
        {
            if (class_exists('\\TurtlePHP\\Plugin\\Config') === true) {
                return true;
            }
            $link = 'https://github.com/onassar/TurtlePHP-ConfigPlugin';
            $msg = '*\TurtlePHP\Plugin\Config* class required. Please see ' . ($link);
            throw new \Exception($msg);
        }

        /**
         * _checkDirectoryWritePermissions
         * 
         * @throws  \Exception
         * @access  protected
         * @static
         * @param   string $directoryPath
         * @return  bool
         */
        protected static function _checkDirectoryWritePermissions(string $directoryPath): bool
        {
            if (posix_access($directoryPath, POSIX_W_OK) === true) {
                return true;
            }
            $msg = '*' . ($directoryPath) . '* needs to be writable.';
            throw new \Exception($msg);
        }

        /**
         * _checkJSShrinkDependency
         * 
         * @throws  \Exception
         * @access  protected
         * @static
         * @return  bool
         */
        protected static function _checkJSShrinkDependency(): bool
        {
            if (function_exists('jsShrink') === true) {
                return true;
            }
            $link = 'https://github.com/vrana/JsShrink/';
            $msg = '*jsShrink* function required. Please see ' . ($link);
            throw new \Exception($msg);
        }

        /**
         * _checkMemcachedCacheDependency
         * 
         * @throws  \Exception
         * @access  protected
         * @static
         * @return  bool
         */
        protected static function _checkMemcachedCacheDependency(): bool
        {
            if (class_exists('\\MemcachedCache') === true) {
                return true;
            }
            $link = 'https://github.com/onassar/PHP-MemcachedCache';
            $msg = '*\MemcachedCache* class required. Please see ' . ($link);
            throw new \Exception($msg);
        }

        /**
         * _checkMySQLConnectionDependency
         * 
         * @throws  \Exception
         * @access  protected
         * @static
         * @return  bool
         */
        protected static function _checkMySQLConnectionDependency(): bool
        {
            if (class_exists('\\MySQLConnection') === true) {
                return true;
            }
            $link = 'https://github.com/onassar/PHP-MySQL';
            $msg = '*\MySQLConnection* class required. Please see ' . ($link);
            throw new \Exception($msg);
        }

        /**
         * _checkMySQLQueryDependency
         * 
         * @throws  \Exception
         * @access  protected
         * @static
         * @return  bool
         */
        protected static function _checkMySQLQueryDependency(): bool
        {
            if (class_exists('\\MySQLQuery') === true) {
                return true;
            }
            $link = 'https://github.com/onassar/PHP-MySQL';
            $msg = '*\MySQLQuery* class required. Please see ' . ($link);
            throw new \Exception($msg);
        }

        /**
         * _checkSMSessionDependency
         * 
         * @throws  \Exception
         * @access  protected
         * @static
         * @return  bool
         */
        protected static function _checkSMSessionDependency(): bool
        {
            if (class_exists('\\SMSession') === true) {
                return true;
            }
            $link = 'https://github.com/onassar/PHP-SecureSessions';
            $msg = '*\SMSession* class required. Please see ' . ($link);
            throw new \Exception($msg);
        }

        /**
         * _encode
         * 
         * @access  protected
         * @static
         * @param   mixed $mixed
         * @return  mixed
         */
        protected static function _encode($mixed)
        {
            if (is_array($mixed) === true) {
                foreach ($mixed as $key => $value) {
                    $mixed[$key] = static::_encode($value);
                }
                return $mixed;
            }
            $encoded = htmlentities($mixed, ENT_QUOTES, 'UTF-8');
            return $encoded;
        }

        /**
         * _getConfigData
         * 
         * @see     https://www.php.net/manual/en/function.get-called-class.php
         * @access  protected
         * @static
         * @param   array $keys,...
         * @return  mixed
         */
        protected static function _getConfigData(... $keys)
        {
            $className = get_called_class();
            $className = str_replace('TurtlePHP\\Plugin\\', '', $className);
            $key = 'TurtlePHP-' . ($className) . 'Plugin';
            array_unshift($keys, $key);
            $configData = \TurtlePHP\Plugin\Config::get(... $keys);
            return $configData;
        }

        /**
         * _loadConfigPath
         * 
         * @access  protected
         * @static
         * @return  void
         */
        protected static function _loadConfigPath(): void
        {
            $path = static::$_configPath;
            require_once $path;
        }

        /**
         * _renderPath
         * 
         * @access  protected
         * @static
         * @param   string $path
         * @param   array $vars (default: array())
         * @return  string
         */
        protected static function _renderPath(string $path, array $vars = array()): string
        {
            $response = \TurtlePHP\Application::renderPath($path, $vars);
            return $response;
        }

        /**
         * _setHeader
         * 
         * @access  protected
         * @static
         * @param   string $value
         * @return  void
         */
        protected static function _setHeader(string $value): void
        {
            header($value);
        }

        /**
         * _setInitiated
         * 
         * @access  protected
         * @static
         * @return  void
         */
        protected static function _setInitiated(): void
        {
            static::$_initiated = true;
        }

        /**
         * init
         * 
         * @access  public
         * @static
         * @return  bool
         */
        public static function init(): bool
        {
            if (static::$_initiated === true) {
                return false;
            }
            static::_setInitiated();
            static::_checkDependencies();
            static::_loadConfigPath();
            return true;
        }

        /**
         * setConfigPath
         * 
         * @access  public
         * @param   string $configPath
         * @return  bool
         */
        public static function setConfigPath(string $configPath): bool
        {
            if (is_file($configPath) === false) {
                return false;
            }
            static::$_configPath = $configPath;
            return true;
        }
    }
