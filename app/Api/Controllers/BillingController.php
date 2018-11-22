<?php

namespace App\Api\Controllers;

use App\Api\Events\Billing\BillingAdded;
use App\Api\Events\Billing\BillingDeleted;
use App\Api\Events\Billing\BillingUpdated;
use App\Api\Models\Billing;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index()
    {
        return Billing::with(['customer', 'project'])->get();
    }

    public function create(Request $request)
    {
        $billing = Billing::create($request->only(['project_id', 'customer_id', 'description', 'note', 'hourly_rate', 'estimate_hours', 'worked_hours', 'total_amount']));

//        $billing = new Billing();
//        if ($request->has(''))

        if(!$billing){
            return new JsonResponse(['errors' => ['message' => 'Unable to save the billing' ]], 500);
        }

        event(new BillingAdded($billing->load(['customer', 'project'])));

        return $billing;

    }

    public function destroy(Request $request)
    {
        $request->validate([
            'billing_id' => 'required|integer',
        ]);

        $billing = Billing::find($request->billing_id);

        if(!$billing) {
            return new JsonResponse(['errors' => ['message' => 'Billing not found' ]], 404);
        }

        $billing->delete();

        event(new BillingDeleted($request->billing_id));

        return new JsonResponse(['success' => ['message' => 'Project deleted' ]], 201);
    }

    public function update(Billing $billing, Request $request)
    {
        $billing->update($request->only(['project_id', 'customer_id', 'description', 'note', 'hourly_rate', 'estimate_hours', 'worked_hours', 'total_amount']));
        $billing->save();

        event(new BillingUpdated($billing->load(['customer', 'project'])));

        return $billing;
    }
}
