<?php
namespace woojos\Kontomierz\Tests\Integration;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use woojos\Kontomierz\KontomierzClient;
use woojos\Kontomierz\UserAccount;

/**
 * Class TestCaseBase
 * @package woojos\Kontomierz\Tests\Integration
 */
class TestCaseBase extends TestCase
{

    const URL = 'https://kontomierz.pl/k4/';

    /** @var string  */
    protected $apiKey = 'RC7p1N8vU7JLxVV72l3hdcMP3hj7pgR90qRfG4sGV8HEZdPvrnyvb5sTBJWt0HQH';
    /** @var KontomierzClient */
    protected $kontomierzClient;
    /** @var Client */
    protected $httpClient;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->kontomierzClient = new KontomierzClient(new Client(), $this->apiKey);
        $this->httpClient = new Client();
    }

}