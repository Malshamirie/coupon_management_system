<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyCardRequest;
use App\Models\LoyaltyCampaign;
use App\Models\Branch;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoyaltyCardRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = LoyaltyCardRequest::with(['loyaltyCampaign', 'branch']);

        // Filter by campaign
        if ($request->filled('campaign_id')) {
            $query->byCampaign($request->campaign_id);
        }

        // Filter by branch
        if ($request->filled('branch_id')) {
            $query->byBranch($request->branch_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $requests = $query->latest()->paginate(15);

        // Get filter data
        $campaigns = LoyaltyCampaign::all();
        $branches = Branch::all();

        return view('backend.pages.loyalty_card_requests.index', compact('requests', 'campaigns', 'branches'));
    }

    public function show(LoyaltyCardRequest $loyaltyCardRequest)
    {
        $loyaltyCardRequest->load(['loyaltyCampaign', 'branch']);
        return view('backend.pages.loyalty_card_requests.show', compact('loyaltyCardRequest'));
    }

    public function edit(LoyaltyCardRequest $loyaltyCardRequest)
    {
        $campaigns = LoyaltyCampaign::all();
        $branches = Branch::all();
        return view('backend.pages.loyalty_card_requests.edit', compact('loyaltyCardRequest', 'campaigns', 'branches'));
    }

    public function update(Request $request, LoyaltyCardRequest $loyaltyCardRequest)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'nullable|string',
            'branch_id' => 'required|exists:branches,id',
            'status' => 'required|in:pending,approved,rejected,delivered',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        // Update processed_at if status changed
        if ($loyaltyCardRequest->status !== $data['status']) {
            $data['processed_at'] = now();
        }

        $loyaltyCardRequest->update($data);

        return response()->json(['message' => trans('back.loyalty_card_request_updated')]);
    }

    public function destroy(LoyaltyCardRequest $loyaltyCardRequest)
    {
        $loyaltyCardRequest->delete();
        return response()->json(['message' => trans('back.loyalty_card_request_deleted')]);
    }

    public function approve(LoyaltyCardRequest $loyaltyCardRequest)
    {
        $loyaltyCardRequest->approve();
        return response()->json(['message' => trans('back.loyalty_card_request_approved')]);
    }

    public function reject(Request $request, LoyaltyCardRequest $loyaltyCardRequest)
    {
        $loyaltyCardRequest->reject($request->notes);
        return response()->json(['message' => trans('back.loyalty_card_request_rejected')]);
    }

    public function deliver(LoyaltyCardRequest $loyaltyCardRequest)
    {
        $loyaltyCardRequest->deliver();
        return response()->json(['message' => trans('back.loyalty_card_request_delivered')]);
    }

    // API Methods for frontend
    public function getCities()
    {
        $cities = City::all();
        return response()->json($cities);
    }

    public function getBranchesByCity(Request $request)
    {
        $branches = Branch::where('city_id', $request->city_id)->get();
        return response()->json($branches);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loyalty_campaign_id' => 'required|exists:loyalty_campaigns,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'nullable|string',
            'branch_id' => 'required|exists:branches,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $data['status'] = 'pending';
        $data['requested_at'] = now();

        LoyaltyCardRequest::create($data);

        return response()->json(['message' => trans('back.loyalty_card_request_submitted')]);
    }

    public function export(Request $request)
    {
        $query = LoyaltyCardRequest::with(['loyaltyCampaign', 'branch']);

        // Apply filters
        if ($request->filled('campaign_id')) {
            $query->byCampaign($request->campaign_id);
        }
        if ($request->filled('branch_id')) {
            $query->byBranch($request->branch_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $requests = $query->get();

        // Export logic here
        return response()->json(['message' => trans('back.loyalty_card_requests_exported')]);
    }
}
