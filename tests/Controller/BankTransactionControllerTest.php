<?php

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class BankTransactionControllerTest extends WebTestCase
{
    public static function setUpBeforeClass()
    {
        exec('../../bin/console doctrine:database:drop --force');
        exec('../../bin/console doctrine:database:create');
        exec('../../bin/console doctrine:schema:create');
    }

    public function testAddBankTransactionWithoutBodyContent()
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/bank/transaction/add', [
            "body" => "{}"
        ]);

        $response = $client->getResponse();

        $this->assertSame(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertContains('form_validation', $response->getContent());
        $this->assertContains('message', $response->getContent());
        $this->assertContains('amount', $response->getContent());
        $this->assertContains('uuid', $response->getContent());
    }

    public function testAddBankTransactionWithAmountOnly()
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/bank/transaction/add', [], [], [], '{"amount": "123.123"}');

        $response = $client->getResponse();

        $arrayContent = (array) json_decode($response->getContent(), true);
        $this->assertSame(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertArrayHasKey("form_validation", $arrayContent);
        $this->assertNotContains("amount", $response->getContent());
        $this->assertContains("uuid", $response->getContent());
    }

    public function testAddBankTransactionWithoutPartAmount()
    {
        $client = static::createClient();
        $client->request('POST', '/bank/transaction/add', [], [], [],
            '{"amount": "123.123", "uuid": "123123123", "bankTransactionParts":[{"reason": "test"}]}');
        $response = $client->getResponse();

        $this->assertContains("bankTransactionParts", $response->getContent());
        $this->assertContains("amount", $response->getContent());
    }

    public function testAddBankTransactionWithPartAmountNotDouble()
    {
        $client = static::createClient();
        $client->request('POST', '/bank/transaction/add', [], [], [],
            '{"amount": "123.123", "uuid": "123123123", "bankTransactionParts":[{"reason": "test", "amount": "1233"}]}');
        $response = $client->getResponse();

        $this->assertContains("bankTransactionParts", $response->getContent());
        $this->assertContains("amount", $response->getContent());
        $this->assertContains("should be a decimal number", $response->getContent());
    }

    public function testAddBankTransactionSuccess()
    {
        $client = static::createClient();
        $client->request('POST', '/bank/transaction/add', [], [], [],
            '{"amount": "123.123", "uuid": "123123123", "bankTransactionParts":[{"amount": "123.123", "reason": "test"}]}');
        $response = $client->getResponse();

        $this->assertSame(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertContains("success", $response->getContent());
    }

    public function testGetBankTransactionsByUuid()
    {
        $client = static::createClient();
        $client->request('GET', '/bank/transaction/123123123');
        $response = $client->getResponse();

        $this->assertContains("123123123", $response->getContent());
    }
}