<!-- Start Top Header Area -->
{{-- <div class="top-header-area business-color">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-4 col-4">
                <ul class="top-header-social-links">
                    <li><a href="https://www.facebook.com/login/" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="https://twitter.com/" target="_blank"><i class="fab fa-twitter"></i></a></li>
                </ul>
            </div>

            <div class="col-lg-7 col-md-8 col-8">
                <div class="top-header-contact-info text-end">
                    <a href="tel:+44-45789-5789" class="number">
                        <i class="fab fa-whatsapp"></i>
                        {{App\Models\Setting::first()->phone}}
                    </a>
                    <div class="lang-switcher">
                        <label><i class="fas fa-globe"></i></label>
                        <select onchange="changeLanguage(this)">
                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <option value="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                                    {{ App::getLocale() == $localeCode ? 'selected' : '' }}>
                                    {{ $properties['native'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- End Top Header Area -->

