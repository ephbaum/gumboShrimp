<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use App\Http\Requests\ItemRequest;

class ItemController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // use auth middleware except on the index route
        $this->middleware('auth:api')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return ItemResource
     */
    public function index()
    {
        return ItemResource::collection(Item::orderBy('created_at', 'asc')->where('number_available', '>', 0)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ItemRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemRequest $request)
    {
        $validated = $request->validated();
        if($validated)
        {
            $item = new Item();

            $item->item_name = request('itemName');
            $item->description = request('itemDescription');
            $item->price = request('itemPrice');
            $item->image = request('itemImage');
            $item->number_available = request('numberAvailable');    
        }

        if($request->hasFile('itemImage'))
        {
            // $path includes 'public/', and we don't want that in our URL, but we want 'storage' - so we chop it off and add it:
            $path = "/storage" . substr(Storage::putFile('public/images', $request->file('itemImage'), 'public'), 6);

            $item->image = $path;
        }

        if ($item->save()) 
        {
            // item saved, return 201
            return response()->json(['message' => 'Item successfully created and persisted'], Response::HTTP_CREATED);
        };

        // Item did not save, return 417
        return response()->json(['message' => 'Item did not save'], Response::HTTP_EXPECTATION_FAILED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $item = Item::find($item)->first();

        $item->item_name = request('itemName');
        $item->description = request('itemDescription');
        $item->price = request('itemPrice');
        $item->number_available = request('numberAvailable');    
    

        if($request->hasFile('itemImage'))
        {

            // $path includes 'public/', and we don't want that in our URL, but we want 'storage' - so we chop it off and add it:
            $path = "/storage" . substr(Storage::putFile('public/images', $request->file('itemImage'), 'public'), 6);

            $item->image = $path;
        }

        if ($item->save()) 
        {
            // item saved, return 201
            return response()->json(['message' => 'Item successfully created and persisted'], Response::HTTP_CREATED);
        };

        // Item did not save, return 417
        return response()->json(['message' => 'Item did not save'], Response::HTTP_EXPECTATION_FAILED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item = Item::find($item)->first();
        
        if($item->delete()){
            return response()->json(null, Response::HTTP_OK);
        };

        return response()->json(['message' => 'Item did not delete'], Response::HTTP_EXPECTATION_FAILED);   
    }
}
