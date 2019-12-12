<?php


namespace Resource;


class Request
{

    public $request;

    public $query;

    public $server;

    public $cookie;

    public $session;

    private $path;

    private $uri;

    private $method;

    private static $instance = null;

    public function __construct(array $query = [], array $request = [], array $server = [], array $cookie = [], array $session = [])
    {
        $this->init($query, $request, $server, $cookie, $session);
    }

    /**
     * @param array $query
     * @param array $request
     * @param array $server
     * @param array $cookie
     * @param array $session
     */
    private function init(array $query = [], array $request = [], array $server = [], array $cookie = [], array $session = []): void
    {
        $this->request = $this->formatRequestParams($request, $_POST);
        $this->query = $this->formatRequestParams($query, $_GET);
        $this->server = $this->formatRequestParams($server, $_SERVER);
        $this->cookie = $this->formatRequestParams($cookie, $_COOKIE);
        $this->session = $this->formatRequestParams($session, $_SESSION);

        $this->setUri();
        $this->setPath();
        $this->setMethod();
    }

    /**
     * @return mixed
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param array $params
     * @param array $default_params
     * @return array
     */
    private function formatRequestParams(array $params, array $default_params): array
    {
        if (empty($params)) {
            return $default_params;
        }

        return $params;
    }

    public static function createRequestFromGlobals()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return Request
     */
    private function setUri(): Request
    {
        if (isset($this->server['REQUEST_URI'])) {
            $this->uri = $this->server['REQUEST_URI'];
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return Request
     */
    private function setPath(): Request
    {
        $uri = $this->getUri();

        $this->path = explode('?', $uri)[0];

        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return Request
     */
    private function setMethod(): Request
    {
        $this->method = $this->getServer()['REQUEST_METHOD'];

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getRequestParams(): array
    {
        return $this->request;
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        return $this->query;
    }

    /**
     * @return array
     */
    public function getServer(): array
    {
        return $this->server;
    }
}