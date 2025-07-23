<form id="email-form" class="row g-3" method="POST" action="{{ route('campaign.email.verify', $campaign->slug) }}">
    @csrf
    <div class="col-md-12">
        <div class="mb-2">
            <label for="email" class="mb-1"> البريد الإلكتروني </label>
            <div class="input-group mb-3">
                @if ($campaign->email_domain)
                    <span class="input-group-text" dir="ltr">{{ '@'. $campaign->email_domain  }}</span>
                    <input id="email" name="email" type="text" class="form-control" placeholder="example">

                @else
                    <input id="email" name="email" type="email" class="form-control" placeholder="example@example.com">
                @endif
            </div>
            <div id="email-error" class="text-danger"></div>
        </div>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary w-100" id="submit-btn">تحقق</button>
    </div>
</form>
