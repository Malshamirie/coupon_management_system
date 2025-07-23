<!-- Links of JS files -->
<script src="{{asset('frontend/ar/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('frontend/ar/assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('frontend/ar/assets/js/magnific-popup.min.js')}}"></script>
<script src="{{asset('frontend/ar/assets/js/appear.min.js')}}"></script>
<script src="{{asset('frontend/ar/assets/js/odometer.min.js')}}"></script>
<script src="{{asset('frontend/ar/assets/js/parallax.min.js')}}"></script>
<script src="{{asset('frontend/ar/assets/js/smooth-scroll.js')}}"></script>
<script src="{{asset('frontend/ar/assets/js/rangeSlider.min.js')}}"></script>
<script src="{{asset('frontend/ar/assets/js/showMoreItems.min.js')}}"></script>
<script src="{{asset('frontend/ar/assets/js/mixitup.min.js')}}"></script>
<script src="{{asset('frontend/ar/assets/js/meanmenu.min.js')}}"></script>
<script src="{{asset('frontend/ar/assets/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('frontend/ar/assets/js/form-validator.min.js')}}"></script>
<script src="{{asset('frontend/ar/assets/js/contact-form-script.js')}}"></script>
<script src="{{asset('frontend/ar/assets/js/ajaxchimp.min.js')}}"></script>
<script src="{{asset('frontend/ar/assets/js/main.js')}}"></script>

{{--كود تغيير اللغة--}}
<script>
    function changeLanguage(selectElement) {
        window.location.href = selectElement.value;
    }
    document.querySelectorAll('input, textarea').forEach(item => {
        item.addEventListener('focus', function() {
            document.body.style.zoom = '1';  // إيقاف التكبير
        });
        item.addEventListener('blur', function() {
            document.body.style.zoom = '';  // إعادة الوضع الطبيعي عند الخروج من الحقل
        });
    });
</script>

{{--loader--}}
<script>
    // جافا سكريبت لإخفاء اللودر بعد تحميل الصفحة
    $(window).on('load', function() {
        $('.loader-wrapper').fadeOut('slow');
    });
</script>
@include('sweetalert::alert')
@livewireScripts
@yield('js')
