
<!-- Footer -->
<footer class="footer-area business-footer pt-5" >
    <!-- footer bottom part -->
    <div class="copyright-area bg-light">
        <div class="container">
            <p><span class="copyright-text">{{ trans('back.All_rights') }} © {{ date('Y') }} {{app()->getLocale() == 'ar' ? App\Models\Setting::first()->company_name_ar : App\Models\Setting::first()->company_name_en}}</span>    </p>
        </div>
    </div>
</div>
</footer>

<!-- Footer End -->
