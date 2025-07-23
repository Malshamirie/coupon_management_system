<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampaignRequest;
use App\Models\Campaign;
use App\Models\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $campaigns = Campaign::query();

        // فلترة حسب النص في حقل الكود إذا وُجد
        if ($request->filled('query')) {
            $search = $request->input('query');
            $campaigns->where('name', 'LIKE', "%{$search}%");
        }

        $campaigns = $campaigns->orderBy('id', 'desc')->paginate(10);

        return view('backend.pages.campaigns.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $containers = Container::all();
        return view('backend.pages.campaigns.create',compact('containers'));
    }

/**
 * @param \App\Http\Requests\CampaignRequest $request
 */
public function store(CampaignRequest $request)
{
    $data = $request->validated();

    if ($request->logo) {
        $data['logo'] = $request->file('logo')->store('campaigns', 'public');
    }

    // معالجة الـotp_required
    $data['otp_required'] = $request->has('otp_required');
    $data['slug'] = Str::slug($request->input('name'));

    Campaign::create($data);
    toast('تم الإضافة بنجاح','success');
    return redirect()->route('admin.campaigns.index');
}


    public function edit(Campaign $campaign)
    {
        $containers = Container::all();
        return view('backend.pages.campaigns.edit', compact('campaign','containers'));
    }
public function update(CampaignRequest $request, Campaign $campaign)
{
    $data = $request->validated();

    if ($image = $request->file('logo')){
            $path = 'images/campaign_logos/';
            $filename = time().$image->getClientOriginalName();
            $image->move($path, $filename);
            $data['logo'] = $path.$filename;
    }



    $data['otp_required'] = $request->has('otp_required');

    $campaign->update($data);
    toast('تم التعديل بنجاح','success');
    return redirect()->route('admin.campaigns.index');
}


    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign)
    {
        return view('backend.pages.campaigns.show', compact('campaign'));
    }

    public function form($slug)
    {
        $campaign = Campaign::where('slug', $slug)->firstOrFail();
        return view('frontend.pages.campaign-form', compact('campaign'));
    }
    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        toast('تم الحذف بنجاح','success');
        return redirect()->back();
    }
}