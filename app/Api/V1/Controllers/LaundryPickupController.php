<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use JWTAuth;
use App\LaundryPickup;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;

use App\Http\Requests;

class LaundryPickupController extends Controller
{
    use Helpers;

    public function index()
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        return $currentUser
            ->pickups()
            ->orderBy('created_at', 'DESC')
            ->get()
            ->toArray();
    }

    public function store(Request $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $pickup = new LaundryPickup;
        $pickup->pickup_datetime = $request->get('pickup_datetime');
        $pickup->address = $request->get('address');
        $pickup->location = $request->get('location');

        if($currentUser->pickups()->save($pickup))
            return $this->response->created();
        else
            return $this->response->error('could_not_create_pickup', 500);
    }

    public function show($id)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $pickup = $currentUser->pickups()->find($id);

        if(!$pickup)
            throw new NotFoundHttpException;

        return $pickup;
    }

    public function update(Request $request, $id)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $pickup = $currentUser->pickups()->find($id);
        if(!$pickup)
            throw new NotFoundHttpException;

        $pickup->fill($request->all());

        if($pickup->save())
            return $this->response->noContent();
        else
            return $this->response->error('could_not_update_book', 500);
    }

    public function destroy($id)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $pickup = $currentUser->pickups()->find($id);

        if(!$pickup)
            throw new NotFoundHttpException;

        if($pickup->delete())
            return $this->response->noContent();
        else
            return $this->response->error('could_not_delete_book', 500);
    }
}
