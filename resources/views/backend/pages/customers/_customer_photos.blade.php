<!-- Modal -->
<div class="modal fade" id="customer_photos{{$customer->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('back.customer_photos')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action=" {{ route('customers.update', $customer->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" class="form-control" name="name" placeholder="{{trans('back.Customer_Name')}}" value="{{ $customer->name }}">
                    <input type="hidden" class="form-control" name="Company_name" placeholder="{{trans('back.company_name')}}" value="{{ $customer->Company_name }}">
                    <input type="hidden" class="form-control" name="id_no" placeholder="{{trans('back.Customer_ID')}}" value="{{ $customer->id_no }}">
                    <input type="hidden" class="form-control" name="phone" placeholder="{{trans('back.phone')}}" value="{{ $customer->phone }}" required>
                    <input type="hidden" class="form-control" name="nationality" placeholder="{{trans('back.nationality')}}" value="{{ $customer->nationality }}">
                    <input type="hidden" class="form-control" name="license_number" placeholder="{{trans('back.license_number')}}" value="{{ $customer->license_number }}">
                    <input type="hidden" class="form-control" name="place_of_issue" placeholder="{{trans('back.place_of_issue')}}" value="{{ $customer->place_of_issue }}">
                    <input type="hidden" class="form-control" name="date_of_issue" placeholder="{{trans('back.date_of_issue')}}" value="{{ $customer->date_of_issue }}">
                    <input type="hidden" class="form-control" name="expiry_date" placeholder="{{trans('back.expiry_date')}}" value="{{ $customer->expiry_date }}">

                    <div class="row">

                        {{--صورة الرخصة من الأمام--}}
                        <div class="form-group col-md-6">
                            <label for="license_front">{{trans('back.license_front')}} </label>
                            <input type="file" class="form-control form-control-file" name="license_front">
                        </div>

                        <div class="form-group col-md-6 mt-3">
                            @if ($customer->license_front)
                                <a href="{{asset($customer->license_front)}}"  target="_blank">
                                    <img src="{{asset($customer->license_front)}}" width="65" height="65" alt="">
                                </a>
                            @else
                                {{trans('back.none')}}
                            @endif
                        </div>

                        {{--صورة الرخصة من الخلف--}}
                        <div class="form-group col-md-6">
                            <label for="license_back">{{trans('back.license_back')}} </label>
                            <input type="file" class="form-control form-control-file" name="license_back">
                        </div>

                        <div class="form-group col-md-6 mt-3">
                            @if ($customer->license_back)
                                <a href="{{asset($customer->license_back)}}"  target="_blank">
                                    <img src="{{asset($customer->license_back)}}" width="65" height="65" alt="">
                                </a>
                            @else
                                {{trans('back.none')}}
                            @endif
                        </div>


                        {{--صورة البطاقة من الأمام--}}
                        <div class="form-group col-md-6">
                            <label for="id_front">{{trans('back.id_front')}} </label>
                            <input type="file" class="form-control form-control-file" name="id_front">
                        </div>

                        <div class="form-group col-md-6 mt-3">
                            @if ($customer->id_front)
                                <a href="{{asset($customer->id_front)}}"  target="_blank">
                                    <img src="{{asset($customer->id_front)}}" width="65" height="65" alt="">
                                </a>
                            @else
                                {{trans('back.none')}}
                            @endif
                        </div>

                        {{--صورة البطاقة من الخلف--}}
                        <div class="form-group col-md-6">
                            <label for="id_back">{{trans('back.id_back')}} </label>
                            <input type="file" class="form-control form-control-file" name="id_back">
                        </div>

                        <div class="form-group col-md-6 mt-3">
                            @if ($customer->id_back)
                                <a href="{{asset($customer->id_back)}}"  target="_blank">
                                    <img src="{{asset($customer->id_back)}}" width="65" height="65" alt="">
                                </a>
                            @else
                                {{trans('back.none')}}
                            @endif
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('back.Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{trans('back.Save')}}</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
