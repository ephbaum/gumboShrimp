<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Cartalyst\Stripe\Exception\CardErrorException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function purchase(Request $request)
    {
        // validate the request
        $validated = $request->validated();

        // find or create the user
        $user = User::where('email', $request->email)->first();
                
        // if user doens't exist, make a user with the role 'user'
        if (!$user)
        {
            $user = User::create([
                'name' => $request->name_on_card,
                'email' => $request->email,
                'password' => bcrypt('password'),
                'role' => 'user',
            ]);
        }

        if($validated) 
        {
            // use try/catch for the Stripe call
            try {
                // create the charge with Stripe
                $charge = Stripe::charges()->create([
                    'amount' => $request->amount,
                    'currency' => 'USD', 
                    'source' => $request->stripeToken,
                    'description' => 'Order from Chango Brothers',
                    'receipt_email' => $request->email,
                    'metadata' => [
                        'name_on_card' => $request->name_on_card,
                        'data2' => 'metadata 2',
                        'data3' => 'metadata 3',
                    ],
                ]);

            } catch (CardErrorException $e) {
                // handle exception 
                return back()->withErrors('There was an error with Stripe: ' . $e->getMessage());
            }

            // Stripe call successful, carry on
            
            // instantiate a new Order
            $order = New Order();
            $order->name = request('name_on_card');
            $order->email = request('email');
            $order->address = request('address');
            $order->city = request('city');
            $order->state = request('state');
            $order->zip = request('zip');
            $order->amount = request('amount');
            
            
            // make sure new Order is saved
            if ($order->save())
            {
                // everything went well, return 201
                return response()->json(null, Response::HTTP_CREATED);
            }
        
            // Order did not save, return 417
            Log::debug(('[ORDER CONTROLLER] --> ORDER did not save -- return 417'));
            return response()->json(null, Response::HTTP_EXPECTATION_FAILED);
        }

        // The resource is not validated, return 400
        Log::debug(('[ORDER CONTROLLER] --> Resource not validated -- return 400'));
        return response()->json(null, Response::HTTP_BAD_REQUEST);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
