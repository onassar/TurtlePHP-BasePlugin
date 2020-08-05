<?php

    // namespace
    namespace Plugin;

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
            if (class_exists('\\Plugin\\Config') === true) {
                return true;
            }
            $link = 'https://github.com/onassar/TurtlePHP-ConfigPlugin';
            $msg = '*\Plugin\Config* class required. Please see ' . ($link);
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
         * _getConfigData
         * 
         * @see     https://www.php.net/manual/en/function.get-called-class.php
         * @access  protected
         * @static
         * @return  array
         */
        protected static function _getConfigData(): array
        {
            $className = get_called_class();
            $className = str_replace('Plugin\\', '', $className);
            $key = 'TurtlePHP-' . ($className) . 'Plugin';
            $configData = \Plugin\Config::retrieve($key);
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
