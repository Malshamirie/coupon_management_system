
                        <form class="row g-3">
                            @csrf
                            <div class="col-md-12">
                                <div class="mb-2">
                                    <label for="phoneNumber" class="mb-1">رقم الجوال</label>
                                    <div class="w-100">
                                        <input id="phone" type="tel" class="form-control w-100" name="phone" autocomplete="tel" required dir="ltr" style="direction: ltr">
                                    </div>
                                        {{-- <input id="phone" type="tel" class="form-control" name="phone" placeholder="500 000 000" autocomplete="tel" style="direction: ltr"> --}}
                                    @error('phone') <div class="text-danger">{{$message}}</div> @enderror
                                </div>
                                <div id="result"></div>

                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-primary w-100" id="phone-btn"> تحقق </button>
                            </div>
                        </form>
