<?php
namespace Lib;

use DOMArch\Util\DateTime;

use DOMArch;
use DOMArch\Request\Incoming;

class Session extends DOMArch\Session
{
    protected function __construct()
    {
        parent::__construct();

        $expire_at = new DateTime(DateTime::NEXT_HOUR);
        $ping_at = new DateTime(DateTime::NEXT_QUART_HOUR);

        $this->init('SESSION_EXPIRE_AT', $expire_at->getTimestamp());
        $this->set('SESSION_PING_AT', $ping_at->getTimestamp());
    }

    public function onExpired()
    {
        parent::onExpired();

        $this->destroy();

        return $this;
    }

    public function onLatePing()
    {
        parent::onLatePing();

        $this->destroy();

        return $this;
    }

    public function destroy()
    {
        parent::destroy();

        Incoming::requested()->forceAuthentication();
    }
}