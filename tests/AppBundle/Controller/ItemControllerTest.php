<?php

namespace Tests\AppBundle\Controller;

use Tests\AppBundle\DataFixtures\ItemData;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class ItemControllerTest
 *
 * @package Tests\AppBundle\Controller
 */
class ItemControllerTest extends WebTestCase
{

    /**
     * Tests getting a user collection with JSON
     */
    public function testJsonCgetAction()
    {

        $client = static::createClient();

        // $this->loadFixtures([]);        

        $client->request('GET', '/orders');

		$response = $client->getResponse();
		// Test if response is OK
		$this->assertSame(200, $client->getResponse()->getStatusCode());
		// Test if Content-Type is valid application/json
	    $this->assertSame('application/json', $response->headers->get('Content-Type'));/**/
		// Test that response is not empty
		$this->assertNotEmpty($client->getResponse()->getContent());        
/*        $this->assertJsonStringEqualsJsonString(
            '[]', $client->getResponse()->getContent()
        );

        $this->loadFixtures([ItemData::class]);

        $client->request('GET', '/orders');
        $this->assertStatusCode(200, $client);
        $this->assertJsonStringEqualsJsonFile(
            __DIR__ . '/../Data/ItemCollection.json',
            $client->getResponse()->getContent()
        );*/
    }

}
