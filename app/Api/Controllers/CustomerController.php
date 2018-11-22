<?php

namespace App\Api\Controllers;

use App\Api\Events\Customer\CustomerAdded;
use App\Api\Events\Customer\CustomerDeleted;
use App\Api\Events\Customer\CustomerUpdated;
use App\Api\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class CustomerController extends Controller
{
    public function index()
    {
        return Customer::with('projects')->get();
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2'
        ]);

        $customer = Customer::create(['name' => $request->name]);

        if(!$customer){
            return new JsonResponse(['errors' => ['message' => 'Unable to save the customer' ]], 500);
        }

        event(new CustomerAdded($customer));

        return $customer;

    }

    public function destroy(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|integer',
        ]);

        $customer = Customer::find($request->customer_id);

        if(!$customer) {
            return new JsonResponse(['errors' => ['message' => 'Customer not found' ]], 404);
        }

        $customer->delete();
        event(new CustomerDeleted($request->customer_id));
        return new JsonResponse(['success' => ['message' => 'Customer deleted' ]], 201);
    }

    public function update(Customer $customer, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $customer->name = $request->name;
        $customer->save();

        event(new CustomerUpdated($customer->load('projects')));

        return $customer;
    }
    public function search(Request $request)
    {
        if ($request->search_query){
            $customers = Customer::where('name', 'like' ,'%' . $request->search_query . '%')->get();
        }
        return $customers;
    }
}
