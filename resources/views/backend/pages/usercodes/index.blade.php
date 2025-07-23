@extends('backend.layouts.master')

@section('page_title')
{{ __('back.usercoupons') }}
@endsection
@section('title')
{{ __('back.usercoupons') }}
@endsection

@section('content')
    <div class="row" id="table-bordered">
            <div class="col-md-8 mb-1 ">
                <form action="{{ route('usercodes') }}" method="GET" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" name="query" value="{{ old('query', request()->input('query')) }}" placeholder="{{ trans('back.search') }}">
                         &numsp;
                        <select name="campaign_id" class="form-select">
                            <option value="0"> فلتر حسب الحملة (الكل) </option>
                            @foreach (App\Models\Campaign::all() as $campaign)
                                <option value="{{ $campaign->id }}" {{ request()->input('campaign_id') == $campaign->id ? 'selected' : '' }}>
                                    {{ $campaign->name }}
                                </option>
                            @endforeach
                        </select>

                        <button class="btn btn-purple btn-sm ml-1" type="submit" title="Search">
                            <span class="fas fa-search"></span>
                        </button>
                         &numsp;
                        <button class="btn btn-success" formaction="{{ route('usercodes.export.excel') }}" title="Search">
                            Excel
                        </button>
                         &numsp;
                        <a href="{{ route('usercodes') }}" class="btn btn-warning text-white" title="Reload">
                            <span class="fas fa-sync-alt"></span>
                        </a>
                    </div>
                </form>
            </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="" class="table table-bordered table-sm">
                            <thead>
                            <tr class="text-center">
                                <th>  # </th>
                                <th>  {{trans('back.coupon')}}  </th>
                                <th>  {{trans('back.phone')}}  </th>
                                <th>  {{trans('back.email')}}  </th>
                                <th> الحملة  </th>
                                <th>{{trans('back.Created_at')}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($usercodes as $key => $usercode)
                                <tr class="text-center">
                                    <td>{{$key + $usercodes->firstItem()}}</td>
                                    <td> {{$usercode->code}}</td>
                                    <td> {{$usercode->phone??'--'}}</td>
                                    <td> {{$usercode->email??'--'}}</td>
                                    <td> {{$usercode->campaign->name??'--'}}</td>
                                    <td>{{$usercode->created_at}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $usercodes->appends(Request::all())->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end row -->

@endsection
