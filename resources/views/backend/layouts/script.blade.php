<script src="{{asset('backend/assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('backend/assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('backend/assets/libs/node-waves/waves.min.js')}}"></script>
<script src="{{asset('backend/assets/libs/waypoints/lib/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('backend/assets/libs/jquery.counterup/jquery.counterup.min.js')}}"></script>
<script src="{{asset('backend/assets/libs/feather-icons/feather.min.js')}}"></script>

<!-- Toastr -->
<script src="{{asset('backend/assets/libs/toastr/toastr.js')}}"></script>

<!-- knob plugin -->
<script src="{{asset('backend/assets/libs/jquery-knob/jquery.knob.min.js')}}"></script>

<!--Morris Chart-->
<script src="{{asset('backend/assets/libs/morris.js06/morris.min.js')}}"></script>
<script src="{{asset('backend/assets/libs/raphael/raphael.min.js')}}"></script>

<!-- Dashboar init js-->
<script src="{{asset('backend/assets/js/pages/dashboard.init.js')}}"></script>

<!-- App js-->
<script src="{{asset('backend/assets/js/app.min.js')}}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // الاستماع لأحداث الإرسال لجميع النماذج
    document.querySelectorAll('form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            // تحديد الزر الذي ضغط فعلياً
            var clickedButton = form.querySelector('button[data-clicked="true"]');
            if (clickedButton) {
                clickedButton.disabled = true;
                clickedButton.innerHTML += '<span class="spinner-border spinner-border-sm mx-1" role="status" aria-hidden="true"></span>';
                clickedButton.removeAttribute('data-clicked'); // تنظيف بعد الاستخدام
            }
        });

        // تعيين data-clicked للزر الذي ضغطه المستخدم
        form.querySelectorAll('button[type="submit"]').forEach(function (button) {
            button.addEventListener('click', function () {
                // إعادة تعيين جميع الأزرار داخل النموذج
                form.querySelectorAll('button[type="submit"]').forEach(btn => btn.removeAttribute('data-clicked'));
                this.setAttribute('data-clicked', 'true');
            });
        });
    });
});
</script>



{{-- status --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-bs-toggle="modal"]').forEach(function(button) {
            button.addEventListener('click', function(event) {
                var id = button.getAttribute('data-id');
                var type = button.getAttribute('data-type');

                // الحصول على الـ modal باستخدام الـ slug (id)
                var modal = document.querySelector('#transitions_complaint_to_admin' + id);

                if (modal) {
                    // تعبئة الحقول المخفية بالقيم المناسبة
                    modal.querySelector('#modal_id').value = id;
                    modal.querySelector('#modal_type').value = type;
                }
            });
        });
    });
</script>
{{--end status --}}

<script>
    $(document).ready(function() {
        $('select[name="country_id"]').on('change', function() {
            var country_id = $(this).val();
            // console.log(country_id);
            if (country_id) {
                $.ajax({
                    url: "{{ URL::to('getstate') }}/" + country_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log(data);

                        $('select[name="state_id"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="state_id"]').append('<option value="' +
                                key + '">' + value + '</option>');
                        });
                    },
                });
            } else {
                console.log('AJAX load did not work');
            }
        });
    });
</script>

@include('sweetalert::alert')
@livewireScripts

@yield('js')
