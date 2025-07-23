<!-- Start Navbar Area -->
<div class="navbar-area navbar-style-two bg-f9faff business-color">
    <div class="noke-responsive-nav">
        <div class="container">
            <div class="noke-responsive-menu">
                <div class="logo">
                    <a href="/"><img src="{{asset(App\Models\Setting::first()->logo)}}" width="55" alt="logo"></a>
                </div>
            </div>
        </div>
    </div>

    <div class="noke-nav">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-md navbar-light">
                <a class="navbar-brand" href="/"><img src="{{asset(App\Models\Setting::first()->logo)}}" width="55" alt="logo"></a>

                <div class="collapse navbar-collapse mean-menu">
                    <ul class="navbar-nav">

                        <li class="nav-item megamenu">
                            <a href="{{ route('home') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
                                {{ __('back.home') }}
                            </a>
                        </li>

                        <li class="nav-item megamenu">
                            <a href="{{ route('about_us') }}" class="nav-link {{ Request::is('about-us') ? 'active' : '' }}">
                                {{ __('back.about_us') }}
                            </a>
                        </li>

                        <li class="nav-item megamenu">
                            <a href="{{ route('contact_us') }}" class="nav-link {{ Request::is('contact-us') ? 'active' : '' }}">
                                {{ __('back.contact_us') }}
                            </a>
                        </li>

                        <li class="nav-item megamenu">
                            <a href="{{ route('showAllChalet') }}" class="nav-link {{ Request::is('all-chalet') || Request::is('chalet/*') ? 'active' : '' }}">
                                {{ __('back.chalets') }}
                            </a>
                        </li>

                    </ul>

                </div>
            </nav>
        </div>
    </div>
</div>
<!-- End Navbar Area -->
