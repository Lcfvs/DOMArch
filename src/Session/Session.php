<?php
namespace DOMArch;

class Session
{
    private static $_session;

    public static function getInstance()
    {
        if (self::$_session) {
            return self::$_session;
        }

        return new static();
    }

    protected function __construct()
    {
        session_start();
        session_regenerate_id(true);

        if ($this->isExpired()) {
            $this->onExpired();
        }

        if ($this->isLatePing()) {
            $this->onLatePing();
        }

        static::$_session = $this;
    }

    public function onExpired()
    {}

    public function onLatePing()
    {}

    public function isExpired()
    {
        $expire_at = $this->get('SESSION_EXPIRE_AT');

        if (!$expire_at) {
            return false;
        }

        $request_time = Config::global()->get('REQUEST_TIME');

        return $expire_at <= $request_time->getTimestamp();
    }

    public function isLatePing()
    {
        $ping_at = $this->get('SESSION_PING_AT');

        if (!$ping_at) {
            return false;
        }

        $request_time = Config::global()->get('REQUEST_TIME');

        return $ping_at <= $request_time->getTimestamp();
    }

    public function init($name, $default)
    {
        if (array_key_exists($name, $_SESSION)) {
            return $this;
        }

        if (is_callable($default)) {
            $_SESSION[$name] = $default();

            return $this;
        }

        $_SESSION[$name] = $default;

        return $this;
    }

    public function set($name, $value)
    {
        $_SESSION[$name] = $value;

        return $this;
    }

    public function get($name, $default = null)
    {
        if (array_key_exists($name, $_SESSION)) {
            return $_SESSION[$name];
        }

        if (is_callable($default)) {
            return $default();
        }

        return $default;
    }

    public function clear($name = null)
    {
        if (is_null($name)) {
            $_SESSION = [];
        } else {
            unset($_SESSION[$name]);
        }

        return $this;
    }

    public function destroy()
    {
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            
            setcookie(
                session_name(), '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }

        $this->clear();
        
        session_destroy();
    }
}