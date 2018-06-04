<?php
namespace woojos\kontomierz\Tests\Integration;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use woojos\kontomierz\KontomierzClient;

/**
 * Class TestCaseBase
 * @package woojos\Kontomierz\Tests\Integration
 */
class TestCaseBase extends TestCase
{

    const URL = 'https://secure.kontomierz.pl/k4/';

    /** @var string  */
    protected $apiKey = '';
    /** @var KontomierzClient */
    protected $kontomierzClient;
    /** @var Client */
    protected $httpClient;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $config = parse_ini_file(__DIR__ . '/../config.ini');
        $this->apiKey = $config['api_key'];

        $this->kontomierzClient = new KontomierzClient(new Client(), $this->apiKey);
        $this->httpClient = new Client();
    }

}