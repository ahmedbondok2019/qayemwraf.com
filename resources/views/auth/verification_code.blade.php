

<style>
    #wrapper {
        font-family: Lato;
        font-size: 1.5rem;
        text-align: center;
        box-sizing: border-box;
        color: #333;
    }
    #wrapper #dialog {
        border: solid 1px #ccc;
        margin: 10px auto;
        padding: 20px 30px;
        display: inline-block;
        box-shadow: 0 0 4px #ccc;
        background-color: #FAF8F8;
        overflow: hidden;
        position: relative;
        max-width: 450px;
    }
    #wrapper #dialog h3 {
        margin: 0 0 10px;
        padding: 0;
        line-height: 1.25;
    }
    #wrapper #dialog span {
        font-size: 90%;
    }
    #wrapper #dialog #form {
        max-width: 240px;
        margin: 25px auto 0;
    }
    #wrapper #dialog #form input {
        margin: 0 5px;
        text-align: center;
        line-height: 80px;
        font-size: 50px;
        border: solid 1px #ccc;
        box-shadow: 0 0 5px #ccc inset;
        outline: none;
        width: 20%;
        transition: all .2s ease-in-out;
        border-radius: 3px;
    }
    #wrapper #dialog #form input:focus {
        border-color: purple;
        box-shadow: 0 0 5px purple inset;
    }
    #wrapper #dialog #form input::selection {
        background: transparent;
    }
    #wrapper #dialog #form button {
        margin: 30px 0 50px;
        width: 100%;
        padding: 6px;
        background-color: #B85FC6;
        border: none;
        text-transform: uppercase;
        font-size: 26px;
    }
    #wrapper #dialog button.close {
        border: solid 2px;
        border-radius: 30px;
        line-height: 19px;
        font-size: 120%;
        width: 22px;
        position: absolute;
        right: 5px;
        top: 5px;
    }
    #wrapper #dialog div {
        position: relative;
        z-index: 1;
    }
    #wrapper #dialog img {
        position: absolute;
        bottom: -70px;
        right: -63px;
    }
    
</style>

<div id="wrapper">
    <div id="dialog">
        {{-- <button class="close">×</button> --}}
        <h3 style="direction: rtl">الرجاء إدخال رمز التحقق المكون من 4 أرقام الذي أرسلناه عبر الرسائل القصيرة:</h3>
        <span style="direction: rtl">(نحن نريد أن نتأكد من انها لك قبل أن تقوم بالدخول)</span>

        <div id="result"></div>

        <div id="form">
            <input type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" data-id="1" class="validate_input"/><input type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" data-id="2" class="validate_input"/><input type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" data-id="3" class="validate_input"/><input type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" data-id="4" class="validate_input"/>
            <button class="btn btn-primary btn-embossed">تحقق</button>
        </div>
      
        <!-- Image loader -->
        <div id='loader' style='display: none;'>
            <img src='{{ asset("website/loader.gif") }}' width='32px' height='32px'>
        </div>

        <div style="direction: rtl">
            لم تتلق الرمز ؟<br />
            <a href="{{ route('user.verification.resend') }}" style="direction: rtl">إرسال الرمز مرة أخرى</a><br />
        </div>
    </div>
  </div>

  <script src="{{ asset('website/js/' . app()->getLocale() . '/jquery-3.6.0.js') }}"></script>
    <script>
        $(function() {
        'use strict';

        var body = $('body');

        function goToNextInput(e) {
            var uri = '{!!URL::to('user/chechVerificationCode')!!}';
            if ($(this).data('id') == 4) {

                var code = [];
                $(".validate_input").each(function() {
                   code.push($(this).val());
                   console.log($(this).val());
                   console.log(code);
                });
                code = code.toString();
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });
                
                $.ajax({
                    url: uri,
                    cache: false,
                    data:{code:code},
                    method:"post",
                    beforeSend: function(){
                        // Show image container
                        $("#loader").show();
                    },
                    success: function(html){
                        $('#loader').hide();
                        $('.result').append(html);
                        if (html.status === true) {
                            window.location = "{!!URL::to('user/home')!!}";
                        }
                    },
                    complete: function(){
                        $('#loader').hide();
                    }
                });
            }

            var key = e.which,
            t = $(e.target),
            sib = t.next('input');

            var allowed = [
                48,49,50,51,52,53,54,55,56,57,9,96,97,98,99,100,101,102,103,104,105
            ];
            
            // if (key != 9 && (key < 48 || key > 57 || key > 105 || key > 96)) {
            // e.preventDefault();
            // // console.log("f" + key);
            // return false;
            // }
            if (!allowed.includes(key)) {
            e.preventDefault();
            console.log("f" + key);
            return false;
            }

            if (key === 9) {
            return true;
            }

            if (!sib || !sib.length) {
            sib = body.find('input').eq(0);
            }
            sib.select().focus();
            
        }

        function onKeyDown(e) {
            var key = e.which;

            // if (key === 9 || (key >= 48 && key <= 57)) {
            // return true;
            // }

            var allowed = [
                48,49,50,51,52,53,54,55,56,57,9,96,97,98,99,100,101,102,103,104,105
            ];

            if (allowed.includes(key)) {
                return true;
            }

            e.preventDefault();
            return false;
        }
        
        function onFocus(e) {
            $(e.target).select();
        }

        body.on('keyup', 'input', goToNextInput);
        body.on('keydown', 'input', onKeyDown);
        body.on('click', 'input', onFocus);

        })
    </script>