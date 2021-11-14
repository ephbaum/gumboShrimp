<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use Laravel\Passport\Passport;
use Mockery\Generator\StringManipulation\Pass\Pass;
use App\Models\User;

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
        
        // create an item
        $item = factory(Item::class)->make();
        $data = [
            'itemName' => $item->item_name,
            'itemDescription' => $item->description,
            'itemPrice' => $item->price,
            'numberAvailable' => $item->number_available,
            'itemImage' => $item->image
        ];

        Passport::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        $response = $this->json('POST', '/api/items', $data);
        $response->assertStatus(201);
        $this->assertStringContainsString('Item successfully created and persisted', $response->content());

        // get the item ID so we can delete it
        $itemId = Item::latest('created_at')->first()->id;

        // delete the newly created item
        $this->json('delete', '/api/items/' . $itemId)->assertStatus(200);

        // check the count after deleting, compare
        $countAfter = Item::count();
        $this->assertSame($countBefore, $countAfter, "Item NOT deleted from DB");
    }
}
