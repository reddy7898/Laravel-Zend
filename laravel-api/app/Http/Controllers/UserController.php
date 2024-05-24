<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        return response()->json($customer->users);
    }

    public function store(Request $request, $customerId)
    {
        $customer = Customer::findOrFail($customerId);
        $user = new User($request->all());
        $user->password = bcrypt($request->password);
        $customer->users()->save($user);
        return response()->json($user, 201);
    }
}
