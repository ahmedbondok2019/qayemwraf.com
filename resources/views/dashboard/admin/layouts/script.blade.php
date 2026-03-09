
    <!-- BEGIN: Vendor JS-->
    {!! Html::script('admin/app-assets/vendors/js/vendors.min.js') !!}


    <!-- BEGIN: Theme JS-->
    {!! Html::script('admin/app-assets/js/core/app-menu.js') !!}
    {!! Html::script('admin/app-assets/js/core/app.js') !!}
    {!! Html::script('admin/app-assets/js/dark-mode.js') !!}
    
       <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- END: Theme JS-->

    <script>
        // let _darkBtn = $('.header-navbar .feather-moon').parent();
        // let _lightBtn = $('.header-navbar .feather-sun').parent();
        // _darkBtn.on('click', function() {
        //   localStorage.setItem('dark', true);
        // });
        // _lightBtn.on('click', function() {
        //   localStorage.setItem('dark', false);
        // });
        // console.log(localStorage.getItem('light-layout-current-skin'));
        if (localStorage.getItem('light-layout-current-skin') == 'dark-layout') {
            $('html').addClass('dark-layout');
        } else {
            $('html').removeClass('dark-layout');
        }
    </script>

{!! Html::script('admin/app-assets/js/scripts/ui/ui-feather.js') !!}

<!-- TinyMCE Editor -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea.tinymce-editor', // Target specific class
        height: 300,
        menubar: false,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount', 'directionality'
        ],
        toolbar: 'undo redo | blocks | ' +
            'bold italic underline strikethrough | ltr rtl | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | link image media | code help',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
        directionality: "{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}",
        language: "{{ app()->getLocale() == 'ar' ? 'ar' : 'en' }}",
        // Additional free options
        branding: false,
        promotion: false
    });
</script>

<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 32,
                height: 32
            });
        }
    })
</script>
