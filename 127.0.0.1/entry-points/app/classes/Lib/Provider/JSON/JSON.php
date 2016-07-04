<?php
namespace Lib\Provider;

use Exception;

use Lib\Config;
use Lib\Request\Incoming;
use Lib\Request\Outcoming;
use DOMArch\Url;
use DOMArch\Provider;

abstract class JSON
    extends Provider\JSON
{
    protected function __construct(
        Outcoming\JSON $request,
        string $key
    )
    {
        $this->_key = $key;

        parent::__construct($request);
    }

    public static function service()
    {
        $config = Config::global()->get('context')->get('service');
        $service_url = $config->get('url');
        $key = $config->get('key');
        $token = $config->get('token');
        $url = Url::parse($service_url);
        $request = Outcoming\JSON::parse($url);

        $provider = new static($request, $key);
        $provider->addHeader($token->get('name'), $token->get('value'));

        return $provider;
    }

    public function select(
        array $query = []
    )
    {
        return $this->query($query)
            ->get()
            ->limit(1);
    }

    public function selectAll(
        array $query = []
    )
    {
        return $this->query($query)
            ->get();
    }

    public function insert(
        array $fields = []
    )
    {
        return $this->post($fields);
    }

    public function update(
        array $record = [],
        array $query = []
    )
    {
        return $this->query($query)
            ->put($record);
    }

    public function archive(
        array $query = []
    )
    {
        return $this->query($query)
            ->delete();
    }

    public function validate()
    {
        $status_code = $this->getRequest()
            ->getResponse()
                ->getStatusCode();

        switch ($status_code) {
            case Outcoming\JSON::STATUS_OK: {
                return true;
            }

            case Outcoming\JSON::STATUS_NOT_FOUND: {
                return false;
            }

            case Outcoming\JSON::STATUS_BAD_REQUEST: {
                Incoming::serviceUnavailable();

                break;
            }

            case Outcoming\JSON::STATUS_CONTINUE: {
                throw new Exception('Service is not responding, invalid token/key?');
            }

            case Outcoming\JSON::STATUS_SERVICE_UNAVAILABLE: {
                Incoming::serviceUnavailable();

                break;
            }

            default: {
                Incoming::serviceUnavailable();

                break;
            }
        }
    }

    public function fetch()
    {
        $body = parent::fetch();

        if ($this->validate()) {
            return $body;
        }
    }
}