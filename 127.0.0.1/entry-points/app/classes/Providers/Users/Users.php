<?php
namespace Providers;

use Lib\Request\Outcoming;
use Lib\Provider\JSON;

class Users
    extends JSON
{
    public function __construct(
        Outcoming\JSON $request,
        string $key
    )
    {
        parent::__construct($request, $key);

        $this->setModule('users');
    }

    public static function login(
        string $account,
        string $password
    )
    {
        return static::service()
            ->query([
                'account' => $account,
                'password' => $password
            ])
            ->fetch();
    }
}