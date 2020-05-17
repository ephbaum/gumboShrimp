<?php

namespace App\Http\Controllers\Api;

use App\Item;
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
     * Display a listing of the resource.
     *
     * @return ItemResource
     */
    public function index()
    {
        return ItemResource::collection(Item::orderBy('created_at', 'asc')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemRequest $request)
    {
        Log::debug("INSIDE [STORE] METHOD ---------->");
        Log::debug($request);
        $validated = $request->validated();
        if($validated)
        {
            $item = new Item();

            $item->name = request('itemName');
            $item->description = request('itemDescription');
            $item->price = request('itemPrice');
            $item->image = request('itemImage');
            $item->number_available = request('numberAvailable');    
            $item->size = request('itemSize');
        }

        if($request->hasFile('image'))
        {
            $path = Storage::putFile('public/images', $request->file('image'), 'public');

            // $path includes 'public/', and we don't want that in our URL, but we want 'storage' - so we chop it off and add it:
            $path = "/storage" . substr($path, 6);

            $item->image = $path;
        }

        if ($item->save()) 
        {
            return response()->json(['message' => 'Item successfully created and persisted'], Response::HTTP_CREATED);
        };

        // Care Package did not save, return 417
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }
}
