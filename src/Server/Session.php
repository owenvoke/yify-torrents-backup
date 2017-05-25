<?php

namespace pxgamer\YifyTorrents\Server;

/**
 * Class Session
 */
class Session
{
    /**
     * Session timeout (default is 24 hours (86400 seconds)
     * @var int
     */
    private static $m_sSessionTimeout = 86400;

    /**
     * Safely initialise a session instance
     * @return bool
     */
    public static function start()
    {
        if (!self::started()) {
            session_start();
        }
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > self::$m_sSessionTimeout)) {
            self::destroy();
        }
        $_SESSION['LAST_ACTIVITY'] = time();
        return true;
    }

    /**
     * Return the session ID
     * @return string
     */
    public static function id()
    {
        if (!self::started()) {
            session_start();
        }

        return session_id();
    }

    /**
     * Return the $_SESSION contents
     * @return string
     */
    public static function all()
    {
        if (!self::started()) {
            session_start();
        }

        return $_SESSION;
    }

    /**
     * Check if a session has already been started or not
     * @return bool
     */
    public static function started()
    {
        return (session_status() === PHP_SESSION_ACTIVE);
    }

    /**
     * Destroy a session, if one is active
     * @return bool
     */
    public static function destroy()
    {
        $_SESSION = array();
        if (session_id() != "" || isset($_COOKIE[session_name()])) {
            $cookie_name = session_name();
            setcookie($cookie_name, '', time() - self::timeout(), '/');
            setcookie($cookie_name, false);
            unset($_COOKIE[$cookie_name]);
        }
        if (session_destroy()) {
            return true;
        }
        return false;
    }

    /**
     * Get or set the session timeout
     * @param mixed|null $p_sSessionTimeout
     * @return int|null
     */
    public static function timeout($p_sSessionTimeout = null)
    {
        if ($p_sSessionTimeout) {
            return self::$m_sSessionTimeout = $p_sSessionTimeout;
        }
        return self::$m_sSessionTimeout;
    }

    /**
     * Regenerate the session ID
     * @param bool $delete (optionally delete the old session)
     * @return bool
     */
    public static function regenerate($delete = false)
    {
        if (!self::started()) {
            self::start();
        }
        return session_regenerate_id($delete);
    }

    /**
     * Set a session variable
     * @param string $p_sKey
     * @param mixed $p_sValue
     */
    public static function set($p_sKey, $p_sValue)
    {
        $_SESSION[$p_sKey] = $p_sValue;
    }

    /**
     * Get a session variable
     * @param string $p_sKey
     * @return mixed|null
     */
    public static function get($p_sKey)
    {
        if (isset($_SESSION[$p_sKey])) {
            return $_SESSION[$p_sKey];
        }
        return null;
    }

    /**
     * Unset a session variable
     * @param string $p_sKey
     * @return bool
     */
    public static function unset($p_sKey)
    {
        if (isset($_SESSION[$p_sKey])) {
            unset($_SESSION[$p_sKey]);
        }
        return true;
    }

    /**
     * Check if a session variable is set
     * @param string $p_sKey
     * @return bool
     */
    public static function isset($p_sKey)
    {
        return isset($_SESSION[$p_sKey]);
    }
}