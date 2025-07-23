<!-- Start Blog Area -->
<div class="blog-area ptb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 m-auto">
                <div class="card">
                    <div class="card-body">
                        <form class="row g-3">
                            {{-- <div class="col-md-12">
                                <label for="name" class="form-label">الاسم الرباعي</label>
                                <input type="text" class="form-control" id="name" placeholder="ادخل اسمك الرباعي">
                            </div> --}}
                            <div class="col-md-12">

                                <div class="mb-2">
                                    <label for="phoneNumber" class="mb-1">رقم الجوال</label>
                                    <div class="mc-field-group input-group">
                                        <input type="tel" id="phone" name="phone" class="required email form-control"   placeholder="500 000 000" autocomplete="tel" style="direction: ltr;border-radius: 0px">
                                        <span class="input-group-text" id="basic-addon1" style="border-radius: 0px">966+</span>
                                    </div>
                                    @error('phone') <div class="text-danger">{{$message}}</div> @enderror
                                </div>
                                <div id="result"></div>

                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-primary w-100" id="submit"> تحقق </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-loading" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="loading-spinner mb-2"></div>
                <div>Loading</div>
            </div>
        </div>
    </div>
</div>
