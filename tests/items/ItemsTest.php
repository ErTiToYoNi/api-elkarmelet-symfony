<?php

namespace App\Tests\items;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Item;
use ApiPlatform\Symfony\Bundle\Test\Client;
use App\Repository\ItemRepository;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

class ItemsTest extends ApiTestCase
{
    private string $token;
    private Client $client;
    protected function setUp(): void
    {
        parent::setUp();
        $this->token = $this->createToken("user", "user");
        $this->client = static::createClient();
        $encoder = $this->client->getContainer()->get(JWTEncoderInterface::class);
        $this->client = static::createClient([], ["auth_bearer"=>$encoder->encode(["username"=>"user", "role"=>["ROLE_USER"]])]);
        //$this->client = $this->createAuthenticatedClient("user", "user");
    }


    public function testGetCollectionReturnsValidData(): void
    {
        $response = static::createClient()->request('GET', '/api/items',
            [ "headers" => ["Accept: application/json","Authorization: Bearer ".$this->token]]
        );

        $this->assertResponseIsSuccessful();
        $this->assertMatchesResourceCollectionJsonSchema(Item::class);

        $this->assertCount(30, $response->toArray());

    }

    public function testPostValidData(): void
    {
        $response = static::createClient()->request('POST', '/api/items',
            [
                'headers' => ["Accept: application/json","Authorization: Bearer ".$this->token],
                'json' => [
                    'name' => 'Lomo',
                    "description"=> "Lomo embuchado",
                    "price"=> 1,
                    'category' => '/api/categories/1'
                ]
            ]
        );

        $this->assertResponseStatusCodeSame(201);
        $this->assertMatchesResourceItemJsonSchema(Item::class);

        $this->assertJsonContains([
            'name' => 'Lomo',
            'description' => "Lomo embuchado",
            "price"=> 1,
            'category' => '/api/categories/1'
        ]);
    }
    public function testDeleteItem():void{
        $response = static::createClient()->request('DELETE', '/api/items/5',
            [
                'headers' => ["Accept: application/json","Authorization: Bearer ".$this->token]
            ]
        );

        $this->assertResponseStatusCodeSame(204);
        $itemRepository = static::getContainer()->get(ItemRepository::class);
        $this->assertNull($itemRepository->find(5));
    }
    protected function createToken($username = 'user', $password = 'user'): string
    {
        $client = static::createClient();
        $response = $client->request('POST', '/login', [
            'headers' => ['Content-Type: application/json'],
            'json' => [
                'username' => $username,
                'password' => $password,
            ],
        ]);

        $data = $response->toArray();
        //sprintf('Bearer %s', $data['token']));
        return $data['token'];
    }
    protected function createAuthenticatedClient($username = 'user', $password = 'user'): Client
    {
        $client = static::createClient();
        $response = $client->request('POST', '/login', [
            'headers' => ['Content-Type: application/json'],
            'json' => [
                'username' => $username,
                'password' => $password,
            ],
        ]);

        $data = $response->toArray();
        //sprintf('Bearer %s', $data['token']));

        return static::createClient([],['auth_bearer'=> $data['token']]);
    }
}
