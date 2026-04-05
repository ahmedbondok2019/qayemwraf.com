<div class="popup-trans">
    <h2>{{ trans_db('website.Translation Settings') }}</h2>
    <i class="close fa-solid fa-xmark"></i>

    <div class="content">
        <h3>{{ trans_db('website.Choose Country') }}</h3>
        <form action="https://souqelmlabes.com/ar/change_lang" method="POST">
            <input type="hidden" name="_token" value="Y6NhYvsaGxYq3ZedNV4u5V98pRx04B4gWVAlHW0B" autocomplete="off">
                                                <div class="box">
                        <div class="lang">
                            <input type="radio" name="country"
                                id="1msr" />
                            <label
                                for="1msr">
                                <img src="https://souqelmlabes.com/website/images/flags/j72xcfco-2024-08-1100-00-00.png" alt=""
                                    srcset="" />
                                <span>{{ trans_db('website.Egypt') }}</span>
                            </label>
                        </div>
                        <div class="fav-lang">
                            <p>حدد لغتك {{ trans_db('website.Favorite') }}</p>
                            <div class="switch-lang">
                                                                    
                                    
                                    <a rel="alternate" hreflang="ar"
                                        href="https://souqelmlabes.com/ar">
                                        العربية
                                    </a>
                                                                    
                                    
                                    <a rel="alternate" hreflang="en"
                                        href="https://souqelmlabes.com/en">
                                        English
                                    </a>
                                                            </div>
                        </div>
                    </div>
                                                                <div class="box">
                        <div class="lang">
                            <input type="radio" name="country"
                                id="2alkoyt" />
                            <label
                                for="2alkoyt">
                                <img src="https://souqelmlabes.com/website/images/flags/qqahnzkp-2024-08-1100-00-00.png" alt=""
                                    srcset="" />
                                <span>{{ trans_db('website.Kuwait') }}</span>
                            </label>
                        </div>
                        <div class="fav-lang">
                            <p>حدد لغتك {{ trans_db('website.Favorite') }}</p>
                            <div class="switch-lang">
                                                                    
                                    
                                    <a rel="alternate" hreflang="ar"
                                        href="https://souqelmlabes.com/ar">
                                        العربية
                                    </a>
                                                                    
                                    
                                    <a rel="alternate" hreflang="en"
                                        href="https://souqelmlabes.com/en">
                                        English
                                    </a>
                                                            </div>
                        </div>
                    </div>
                                                                <div class="box">
                        <div class="lang">
                            <input type="radio" name="country"
                                id="3morytanya" />
                            <label
                                for="3morytanya">
                                <img src="https://souqelmlabes.com/website/images/flags/dlniwrjg-2024-08-1100-00-00.png" alt=""
                                    srcset="" />
                                <span>{{ trans_db('website.Mauritania') }}</span>
                            </label>
                        </div>
                        <div class="fav-lang">
                            <p>حدد لغتك {{ trans_db('website.Favorite') }}</p>
                            <div class="switch-lang">
                                                                    
                                    
                                    <a rel="alternate" hreflang="ar"
                                        href="https://souqelmlabes.com/ar">
                                        العربية
                                    </a>
                                                                    
                                    
                                    <a rel="alternate" hreflang="en"
                                        href="https://souqelmlabes.com/en">
                                        English
                                    </a>
                                                            </div>
                        </div>
                    </div>
                                                                <div class="box">
                        <div class="lang">
                            <input type="radio" name="country"
                                id="4alsaaody" />
                            <label
                                for="4alsaaody">
                                <img src="https://souqelmlabes.com/website/images/flags/9suzwsq4-2024-08-1100-00-00.png" alt=""
                                    srcset="" />
                                <span>{{ trans_db('website.Saudi Arabia') }}</span>
                            </label>
                        </div>
                        <div class="fav-lang">
                            <p>حدد لغتك {{ trans_db('website.Favorite') }}</p>
                            <div class="switch-lang">
                                                                    
                                    
                                    <a rel="alternate" hreflang="ar"
                                        href="https://souqelmlabes.com/ar">
                                        العربية
                                    </a>
                                                                    
                                    
                                    <a rel="alternate" hreflang="en"
                                        href="https://souqelmlabes.com/en">
                                        English
                                    </a>
                                                            </div>
                        </div>
                    </div>
                                                                <div class="box">
                        <div class="lang">
                            <input type="radio" name="country"
                                id="5ktr" />
                            <label
                                for="5ktr">
                                <img src="https://souqelmlabes.com/website/images/flags/djalctdh-2024-08-1100-00-00.png" alt=""
                                    srcset="" />
                                <span>{{ trans_db('website.Qatar') }}</span>
                            </label>
                        </div>
                        <div class="fav-lang">
                            <p>حدد لغتك {{ trans_db('website.Favorite') }}</p>
                            <div class="switch-lang">
                                                                    
                                    
                                    <a rel="alternate" hreflang="ar"
                                        href="https://souqelmlabes.com/ar">
                                        العربية
                                    </a>
                                                                    
                                    
                                    <a rel="alternate" hreflang="en"
                                        href="https://souqelmlabes.com/en">
                                        English
                                    </a>
                                                            </div>
                        </div>
                    </div>
                            
            <div class="buttons-trans">
                <span class="close">{{ trans_db('website.Cancel') }}</span>
                <button>{{ trans_db('website.Confirm') }}</button>
            </div>
        </form>
    </div>
</div>

<div class="popup-location">
    <h2>{{ trans_db('website.Add Delivery Address') }}</h2>
    <i class="close fa-solid fa-xmark"></i>
    <div class="form">
        <input type="hidden" name="url" id="url"
            value="https://souqelmlabes.com/ar/user/addAddress">
        <div>
            <input type="text" class="input" name="address_title" required id="address_title2" />
            <label for="address_title">{{ trans_db('website.Address *') }}</label>
            <span class="text-danger">
                            </span>
        </div>
        <div>
            <input type="number" class="input" name="phone" id="address_phone2" required />
            <label for="phone">{{ trans_db('website.Phone *') }}</label>
            <span class="text-danger">
                            </span>
        </div>
        <div>
            <input type="text" class="input" name="name" id="address_name2" required />
            <label for="name">{{ trans_db('website.Name *') }}</label>
            <span class="text-danger">
                            </span>
        </div>
        <div>
            <select name="user_area2" id="select_area2" class="area input">
                <option>{{ trans_db('website.Choose') }}</option>
                                                    <option value="1">الاسكندريه</option>
                                    <option value="2">اسيوط</option>
                                    <option value="3">اسوان</option>
                                    <option value="4">بني سويف</option>
                                    <option value="5">البحيره</option>
                                    <option value="6">القاهره</option>
                                    <option value="7">الدقهليه</option>
                                    <option value="8">دمياط</option>
                                    <option value="9">القليوبيه</option>
                                    <option value="10">الفيوم</option>
                                    <option value="11">الغربيه</option>
                                    <option value="12">الجيزه</option>
                                    <option value="13">الاسماعيليه</option>
                                    <option value="14">كفر الشيخ</option>
                                    <option value="15">الاقصر</option>
                                    <option value="16">مرسي مطروح</option>
                                    <option value="17">ال{{ trans_db('website.From') }}يا</option>
                                    <option value="18">ال{{ trans_db('website.From') }}وفيه</option>
                                    <option value="19">الوادي الجديد</option>
                                    <option value="20">الساحل الشمالي</option>
                                    <option value="21">شمال سيناء</option>
                                    <option value="22">بور سعيد</option>
                                    <option value="23">قنا</option>
                                    <option value="24">البحر الاحمر</option>
                                    <option value="25">الشرقيه</option>
                                    <option value="26">سوهاج</option>
                                    <option value="27">جنوب سيناء</option>
                                    <option value="28">السويس</option>
                            </select>
            <label for="">المحافظة*</label>
        </div>
        <div>
            <select name="user_city2" id="select_city2" class="city input">
                <option value="">{{ trans_db('website.Choose') }}</option>
            </select>
            <label for="">المدينة*</label>
        </div>
        <div class="row error_save"><span class="error_add"></span></div>
        <input type="submit" class="send_form2 close" value="حفظ" />
    </div>

</div>

<div class="popup-cart">
    <h2>عربة التسوق</h2>
    <i class="close fa-solid fa-xmark"></i>
    <div class="content">
        <div class="all-boxes">
                    </div>
        <div class="buttons-trans">
            <a href="https://souqelmlabes.com/ar/user/Cart">
                trans_db('website.View Cart') <br />
                الإجمالى: {{ format_price(0) }}
            </a>
        </div>
    </div>
</div>

<div class="modal fade" id="addToCartModal" tabindex="-1" aria-hidden="true" style="z-index: 9999;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-body p-5 text-center">
                <div class="mb-4 text-center">
                    <div class="mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: rgba(28, 188, 236, 0.1); border-radius: 50%;">
                        <i class="fas fa-check-circle" style="font-size: 40px; color: var(--main-color, #1cbcec);"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-2 text-dark text-center" style="font-size: 24px;">{{ trans_db('website.Added Successfully!') }}</h3>
                <p class="text-muted mb-4 text-center">{{ trans_db('website.The product has been added to your shopping cart.') }}</p>
                
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center mt-4">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2" data-bs-dismiss="modal" style="border-radius: 12px; font-weight: 600; border: 2px solid #eee; transition: 0.3s; width: 100%;">
                        {{ trans_db('website.Continue Shopping') }}
                    </button>
                    <a href="{{ route('frontend.user.checkout.index') }}" class="btn btn-primary px-4 py-2" style="background: var(--main-color, #1cbcec); border: none; border-radius: 12px; font-weight: 600; color: #fff; box-shadow: 0 4px 15px rgba(28, 188, 236, 0.3); transition: 0.3s; width: 100%;">
                        {{ trans_db('website.Complete Order') }}
                    </a>
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('frontend.cart.index') }}" class="text-secondary text-decoration-underline" style="font-size: 14px; font-weight: 500;">
                        {{ trans_db('website.Go to Cart') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

