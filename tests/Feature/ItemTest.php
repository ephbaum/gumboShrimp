<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;

class ItemTest extends TestCase
{
    public function testIndexRoute()
    {
        $response = $this->get('/api/items');
        $response->assertStatus(200);
    }

    public function testCreateItem()
    {
        // count records in db before adding
        $countBefore = Item::count();
        
        // this allows us past the auth on items POST route
        $this->loginRandomAdmin();

        $item = factory(Item::class)->make();

        $data = [
            'itemName' => $item->item_name,
            'itemDescription' => $item->description,
            'itemPrice' => $item->price,
            'numberAvailable' => $item->number_available,
            'itemImage' => $item->image
        ];

        $headers = [];
        $headers['Accept'] = 'application/json';
        $headers['Authorization'] = 'Bearer ' . $this->token;

        $response = $this->json('POST', '/api/items', $data, $headers);
        $response->assertStatus(201);
        $this->assertStringContainsString('Item successfully created and persisted', $response->content());

        // get the item ID so we can delete it
        $itemId = Item::latest('created_at')->first()->id;

        $this->json('delete', '/api/items/' . $itemId, $headers)->assertStatus(200);

        $countAfter = Item::count();
        
        $this->assertSame($countBefore, $countAfter, "Item NOT deleted from DB");
    }
}
