<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Laravel API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://127.0.0.1:8000";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.6.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.6.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authentication" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authentication">
                    <a href="#authentication">Authentication</a>
                </li>
                                    <ul id="tocify-subheader-authentication" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="authentication-POSTapi-v1-registerUser">
                                <a href="#authentication-POSTapi-v1-registerUser">Register</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentication-POSTapi-v1-login">
                                <a href="#authentication-POSTapi-v1-login">Login</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentication-POSTapi-v1-social-login">
                                <a href="#authentication-POSTapi-v1-social-login">Social Login</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentication-POSTapi-v1-forget-password">
                                <a href="#authentication-POSTapi-v1-forget-password">Forget Password</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentication-POSTapi-v1-reset-password">
                                <a href="#authentication-POSTapi-v1-reset-password">Reset Password</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentication-POSTapi-v1-fcm-subscribe">
                                <a href="#authentication-POSTapi-v1-fcm-subscribe">Subscribe to Topic</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentication-POSTapi-v1-logout">
                                <a href="#authentication-POSTapi-v1-logout">Logout</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentication-POSTapi-v1-delete_account">
                                <a href="#authentication-POSTapi-v1-delete_account">Delete Account</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-blogs" class="tocify-header">
                <li class="tocify-item level-1" data-unique="blogs">
                    <a href="#blogs">Blogs</a>
                </li>
                                    <ul id="tocify-subheader-blogs" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="blogs-GETapi-v1-blog-categories">
                                <a href="#blogs-GETapi-v1-blog-categories">Get Blog Categories</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="blogs-GETapi-v1-blogs">
                                <a href="#blogs-GETapi-v1-blogs">Get Blogs</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="blogs-GETapi-v1-blogs--id-">
                                <a href="#blogs-GETapi-v1-blogs--id-">Get Blog Details</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-brands-partners" class="tocify-header">
                <li class="tocify-item level-1" data-unique="brands-partners">
                    <a href="#brands-partners">Brands / Partners</a>
                </li>
                                    <ul id="tocify-subheader-brands-partners" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="brands-partners-GETapi-v1-brands">
                                <a href="#brands-partners-GETapi-v1-brands">Get All Brands</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-cart" class="tocify-header">
                <li class="tocify-item level-1" data-unique="cart">
                    <a href="#cart">Cart</a>
                </li>
                                    <ul id="tocify-subheader-cart" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="cart-GETapi-v1-cart">
                                <a href="#cart-GETapi-v1-cart">Get Cart Items</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="cart-POSTapi-v1-add-to-cart">
                                <a href="#cart-POSTapi-v1-add-to-cart">Add to Cart</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="cart-POSTapi-v1-cart--id-">
                                <a href="#cart-POSTapi-v1-cart--id-">Update Cart Item</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="cart-DELETEapi-v1-cart--id-">
                                <a href="#cart-DELETEapi-v1-cart--id-">Delete Cart Item</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-categories" class="tocify-header">
                <li class="tocify-item level-1" data-unique="categories">
                    <a href="#categories">Categories</a>
                </li>
                                    <ul id="tocify-subheader-categories" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="categories-GETapi-v1-categories">
                                <a href="#categories-GETapi-v1-categories">Get Main Categories</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="categories-GETapi-v1-sub-categories">
                                <a href="#categories-GETapi-v1-sub-categories">Get Sub Categories</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-checkout" class="tocify-header">
                <li class="tocify-item level-1" data-unique="checkout">
                    <a href="#checkout">Checkout</a>
                </li>
                                    <ul id="tocify-subheader-checkout" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="checkout-POSTapi-v1-checkout-summary">
                                <a href="#checkout-POSTapi-v1-checkout-summary">Get Checkout Summary</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="checkout-POSTapi-v1-checkout-apply-coupon">
                                <a href="#checkout-POSTapi-v1-checkout-apply-coupon">Apply Coupon (Validation only)</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="checkout-POSTapi-v1-checkout-store">
                                <a href="#checkout-POSTapi-v1-checkout-store">Place Order</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-endpoints" class="tocify-header">
                <li class="tocify-item level-1" data-unique="endpoints">
                    <a href="#endpoints">Endpoints</a>
                </li>
                                    <ul id="tocify-subheader-endpoints" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-home">
                                <a href="#endpoints-GETapi-v1-home">Get Integrated Home Data</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-flash-sales">
                                <a href="#endpoints-GETapi-v1-flash-sales">Get Flash Sales</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-pages">
                                <a href="#endpoints-GETapi-v1-pages">GET api/v1/pages</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-pages--slug-">
                                <a href="#endpoints-GETapi-v1-pages--slug-">GET api/v1/pages/{slug}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-products">
                                <a href="#endpoints-GETapi-v1-products">Get Products with Filters</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-products--id-">
                                <a href="#endpoints-GETapi-v1-products--id-">Get Product Details</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-best-sellers">
                                <a href="#endpoints-GETapi-v1-best-sellers">Get Best Selling Products</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-latest-products">
                                <a href="#endpoints-GETapi-v1-latest-products">Get Latest Products</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-rate-product">
                                <a href="#endpoints-POSTapi-v1-rate-product">POST api/v1/rate-product</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-general" class="tocify-header">
                <li class="tocify-item level-1" data-unique="general">
                    <a href="#general">General</a>
                </li>
                                    <ul id="tocify-subheader-general" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="general-GETapi-v1-configuration">
                                <a href="#general-GETapi-v1-configuration">Get Configuration (Legacy)</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="general-GETapi-v1-settings">
                                <a href="#general-GETapi-v1-settings">Get Settings</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="general-GETapi-v1-advertisements">
                                <a href="#general-GETapi-v1-advertisements">Get Advertisements</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="general-GETapi-v1-offers">
                                <a href="#general-GETapi-v1-offers">Get Offers</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="general-POSTapi-v1-contact-us">
                                <a href="#general-POSTapi-v1-contact-us">Contact Us</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-gifts" class="tocify-header">
                <li class="tocify-item level-1" data-unique="gifts">
                    <a href="#gifts">Gifts</a>
                </li>
                                    <ul id="tocify-subheader-gifts" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="gifts-GETapi-v1-gifts">
                                <a href="#gifts-GETapi-v1-gifts">Get Available Gifts</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="gifts-POSTapi-v1-gifts-claim">
                                <a href="#gifts-POSTapi-v1-gifts-claim">Claim Gifts</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-home" class="tocify-header">
                <li class="tocify-item level-1" data-unique="home">
                    <a href="#home">Home</a>
                </li>
                                    <ul id="tocify-subheader-home" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="home-GETapi-v1-sliders">
                                <a href="#home-GETapi-v1-sliders">Get Sliders</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-locations" class="tocify-header">
                <li class="tocify-item level-1" data-unique="locations">
                    <a href="#locations">Locations</a>
                </li>
                                    <ul id="tocify-subheader-locations" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="locations-GETapi-v1-countries">
                                <a href="#locations-GETapi-v1-countries">Get All Countries</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="locations-GETapi-v1-governorates--country_id-">
                                <a href="#locations-GETapi-v1-governorates--country_id-">Get Governorates by Country</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="locations-GETapi-v1-cities--governorate_id-">
                                <a href="#locations-GETapi-v1-cities--governorate_id-">Get Cities by Governorate</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-options" class="tocify-header">
                <li class="tocify-item level-1" data-unique="options">
                    <a href="#options">Options</a>
                </li>
                                    <ul id="tocify-subheader-options" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="options-GETapi-v1-products--id--options">
                                <a href="#options-GETapi-v1-products--id--options">Get Product Options</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="options-GETapi-v1-options">
                                <a href="#options-GETapi-v1-options">Get All Options</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-order-services" class="tocify-header">
                <li class="tocify-item level-1" data-unique="order-services">
                    <a href="#order-services">Order Services</a>
                </li>
                                    <ul id="tocify-subheader-order-services" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="order-services-GETapi-v1-order-services">
                                <a href="#order-services-GETapi-v1-order-services">Get All Order Services</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-payment-methods" class="tocify-header">
                <li class="tocify-item level-1" data-unique="payment-methods">
                    <a href="#payment-methods">Payment Methods</a>
                </li>
                                    <ul id="tocify-subheader-payment-methods" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="payment-methods-GETapi-v1-payment-methods">
                                <a href="#payment-methods-GETapi-v1-payment-methods">Get All Payment Methods</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-user-addresses" class="tocify-header">
                <li class="tocify-item level-1" data-unique="user-addresses">
                    <a href="#user-addresses">User Addresses</a>
                </li>
                                    <ul id="tocify-subheader-user-addresses" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="user-addresses-GETapi-v1-addresses">
                                <a href="#user-addresses-GETapi-v1-addresses">Get Addresses</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="user-addresses-POSTapi-v1-addresses">
                                <a href="#user-addresses-POSTapi-v1-addresses">Add Address</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="user-addresses-POSTapi-v1-addresses--id-">
                                <a href="#user-addresses-POSTapi-v1-addresses--id-">Update Address</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="user-addresses-DELETEapi-v1-addresses--id-">
                                <a href="#user-addresses-DELETEapi-v1-addresses--id-">Delete Address</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="user-addresses-POSTapi-v1-addresses--id--set-main">
                                <a href="#user-addresses-POSTapi-v1-addresses--id--set-main">Set Main Address</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-user-orders" class="tocify-header">
                <li class="tocify-item level-1" data-unique="user-orders">
                    <a href="#user-orders">User Orders</a>
                </li>
                                    <ul id="tocify-subheader-user-orders" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="user-orders-GETapi-v1-orders">
                                <a href="#user-orders-GETapi-v1-orders">Get User Orders</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="user-orders-GETapi-v1-orders--id-">
                                <a href="#user-orders-GETapi-v1-orders--id-">Get Order Details</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="user-orders-POSTapi-v1-cancel-order">
                                <a href="#user-orders-POSTapi-v1-cancel-order">Cancel Order</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-user-profile" class="tocify-header">
                <li class="tocify-item level-1" data-unique="user-profile">
                    <a href="#user-profile">User Profile</a>
                </li>
                                    <ul id="tocify-subheader-user-profile" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="user-profile-GETapi-v1-profile">
                                <a href="#user-profile-GETapi-v1-profile">Get Profile</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="user-profile-POSTapi-v1-profile">
                                <a href="#user-profile-POSTapi-v1-profile">Update Profile</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="user-profile-POSTapi-v1-update-fcm-token">
                                <a href="#user-profile-POSTapi-v1-update-fcm-token">Update FCM Token</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-wishlist" class="tocify-header">
                <li class="tocify-item level-1" data-unique="wishlist">
                    <a href="#wishlist">Wishlist</a>
                </li>
                                    <ul id="tocify-subheader-wishlist" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="wishlist-GETapi-v1-wishlist">
                                <a href="#wishlist-GETapi-v1-wishlist">Get Wishlist Items</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="wishlist-POSTapi-v1-wishlist-toggle">
                                <a href="#wishlist-POSTapi-v1-wishlist-toggle">Toggle Wishlist</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: February 19, 2026</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<aside>
    <strong>Base URL</strong>: <code>http://127.0.0.1:8000</code>
</aside>
<pre><code>This documentation aims to provide all the information you need to work with our API.

&lt;aside&gt;As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).&lt;/aside&gt;</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>This API is not authenticated.</p>

        <h1 id="authentication">Authentication</h1>

    

                                <h2 id="authentication-POSTapi-v1-registerUser">Register</h2>

<p>
</p>

<p>Register a new user and return a token.</p>

<span id="example-requests-POSTapi-v1-registerUser">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/registerUser" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"John Doe\",
    \"email\": \"john@example.com\",
    \"phone\": \"01021456325\",
    \"country_id\": 1,
    \"password\": \"password123\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/registerUser"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "01021456325",
    "country_id": 1,
    "password": "password123"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-registerUser">
</span>
<span id="execution-results-POSTapi-v1-registerUser" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-registerUser"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-registerUser"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-registerUser" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-registerUser">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-registerUser" data-method="POST"
      data-path="api/v1/registerUser"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-registerUser', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-registerUser"
                    onclick="tryItOut('POSTapi-v1-registerUser');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-registerUser"
                    onclick="cancelTryOut('POSTapi-v1-registerUser');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-registerUser"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/registerUser</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-registerUser"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-registerUser"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-v1-registerUser"
               value="John Doe"
               data-component="body">
    <br>
<p>The name of the user. Example: <code>John Doe</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v1-registerUser"
               value="john@example.com"
               data-component="body">
    <br>
<p>The email of the user. Example: <code>john@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="POSTapi-v1-registerUser"
               value="01021456325"
               data-component="body">
    <br>
<p>The phone number. Example: <code>01021456325</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>country_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="country_id"                data-endpoint="POSTapi-v1-registerUser"
               value="1"
               data-component="body">
    <br>
<p>ID of the country. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-v1-registerUser"
               value="password123"
               data-component="body">
    <br>
<p>The password. Example: <code>password123</code></p>
        </div>
        </form>

                    <h2 id="authentication-POSTapi-v1-login">Login</h2>

<p>
</p>

<p>Authenticate user and return a token.</p>

<span id="example-requests-POSTapi-v1-login">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/login" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"login\": \"john@example.com or 01021456325\",
    \"password\": \"password123\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/login"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "login": "john@example.com or 01021456325",
    "password": "password123"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-login">
</span>
<span id="execution-results-POSTapi-v1-login" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-login"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-login"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-login">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-login" data-method="POST"
      data-path="api/v1/login"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-login', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-login"
                    onclick="tryItOut('POSTapi-v1-login');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-login"
                    onclick="cancelTryOut('POSTapi-v1-login');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-login"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/login</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>login</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="login"                data-endpoint="POSTapi-v1-login"
               value="john@example.com or 01021456325"
               data-component="body">
    <br>
<p>Email or Phone of the user. Example: <code>john@example.com or 01021456325</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-v1-login"
               value="password123"
               data-component="body">
    <br>
<p>The password. Example: <code>password123</code></p>
        </div>
        </form>

                    <h2 id="authentication-POSTapi-v1-social-login">Social Login</h2>

<p>
</p>

<p>Login or Register via social media (Google, Facebook, Apple).</p>

<span id="example-requests-POSTapi-v1-social-login">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/social-login" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"provider\": \"google\",
    \"provider_id\": \"consequatur\",
    \"email\": \"qkunze@example.com\",
    \"name\": \"consequatur\",
    \"image\": \"consequatur\",
    \"temp_user_id\": \"consequatur\",
    \"country_id\": 17
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/social-login"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "provider": "google",
    "provider_id": "consequatur",
    "email": "qkunze@example.com",
    "name": "consequatur",
    "image": "consequatur",
    "temp_user_id": "consequatur",
    "country_id": 17
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-social-login">
</span>
<span id="execution-results-POSTapi-v1-social-login" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-social-login"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-social-login"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-social-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-social-login">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-social-login" data-method="POST"
      data-path="api/v1/social-login"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-social-login', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-social-login"
                    onclick="tryItOut('POSTapi-v1-social-login');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-social-login"
                    onclick="cancelTryOut('POSTapi-v1-social-login');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-social-login"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/social-login</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-social-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-social-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>provider</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="provider"                data-endpoint="POSTapi-v1-social-login"
               value="google"
               data-component="body">
    <br>
<p>The provider name (google, facebook, apple). Example: <code>google</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>provider_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="provider_id"                data-endpoint="POSTapi-v1-social-login"
               value="consequatur"
               data-component="body">
    <br>
<p>The unique ID from the provider. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v1-social-login"
               value="qkunze@example.com"
               data-component="body">
    <br>
<p>nullable The email of the user. Example: <code>qkunze@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-v1-social-login"
               value="consequatur"
               data-component="body">
    <br>
<p>nullable The name of the user. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>image</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="image"                data-endpoint="POSTapi-v1-social-login"
               value="consequatur"
               data-component="body">
    <br>
<p>nullable The image URL of the user. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>temp_user_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="temp_user_id"                data-endpoint="POSTapi-v1-social-login"
               value="consequatur"
               data-component="body">
    <br>
<p>Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>country_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="country_id"                data-endpoint="POSTapi-v1-social-login"
               value="17"
               data-component="body">
    <br>
<p>Example: <code>17</code></p>
        </div>
        </form>

                    <h2 id="authentication-POSTapi-v1-forget-password">Forget Password</h2>

<p>
</p>

<p>Send an OTP to the user's email for password reset.</p>

<span id="example-requests-POSTapi-v1-forget-password">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/forget-password" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"john@example.com\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/forget-password"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "john@example.com"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-forget-password">
</span>
<span id="execution-results-POSTapi-v1-forget-password" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-forget-password"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-forget-password"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-forget-password" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-forget-password">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-forget-password" data-method="POST"
      data-path="api/v1/forget-password"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-forget-password', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-forget-password"
                    onclick="tryItOut('POSTapi-v1-forget-password');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-forget-password"
                    onclick="cancelTryOut('POSTapi-v1-forget-password');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-forget-password"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/forget-password</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-forget-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-forget-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v1-forget-password"
               value="john@example.com"
               data-component="body">
    <br>
<p>The email of the user. Example: <code>john@example.com</code></p>
        </div>
        </form>

                    <h2 id="authentication-POSTapi-v1-reset-password">Reset Password</h2>

<p>
</p>

<p>Reset user password using OTP.</p>

<span id="example-requests-POSTapi-v1-reset-password">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/reset-password" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"john@example.com\",
    \"otp\": \"1234\",
    \"password\": \"newpassword123\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/reset-password"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "john@example.com",
    "otp": "1234",
    "password": "newpassword123"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-reset-password">
</span>
<span id="execution-results-POSTapi-v1-reset-password" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-reset-password"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-reset-password"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-reset-password" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-reset-password">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-reset-password" data-method="POST"
      data-path="api/v1/reset-password"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-reset-password', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-reset-password"
                    onclick="tryItOut('POSTapi-v1-reset-password');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-reset-password"
                    onclick="cancelTryOut('POSTapi-v1-reset-password');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-reset-password"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/reset-password</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-reset-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-reset-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v1-reset-password"
               value="john@example.com"
               data-component="body">
    <br>
<p>The email address. Example: <code>john@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>otp</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="otp"                data-endpoint="POSTapi-v1-reset-password"
               value="1234"
               data-component="body">
    <br>
<p>The OTP received. Example: <code>1234</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-v1-reset-password"
               value="newpassword123"
               data-component="body">
    <br>
<p>New password. Example: <code>newpassword123</code></p>
        </div>
        </form>

                    <h2 id="authentication-POSTapi-v1-fcm-subscribe">Subscribe to Topic</h2>

<p>
</p>

<p>Subscribe a device to a specific Firebase topic (e.g., 'offers').</p>

<span id="example-requests-POSTapi-v1-fcm-subscribe">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/fcm-subscribe" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"fcm_token\": \"consequatur\",
    \"topic\": \"consequatur\",
    \"device_id\": \"consequatur\",
    \"device_type\": \"consequatur\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/fcm-subscribe"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "fcm_token": "consequatur",
    "topic": "consequatur",
    "device_id": "consequatur",
    "device_type": "consequatur"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-fcm-subscribe">
</span>
<span id="execution-results-POSTapi-v1-fcm-subscribe" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-fcm-subscribe"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-fcm-subscribe"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-fcm-subscribe" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-fcm-subscribe">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-fcm-subscribe" data-method="POST"
      data-path="api/v1/fcm-subscribe"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-fcm-subscribe', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-fcm-subscribe"
                    onclick="tryItOut('POSTapi-v1-fcm-subscribe');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-fcm-subscribe"
                    onclick="cancelTryOut('POSTapi-v1-fcm-subscribe');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-fcm-subscribe"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/fcm-subscribe</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-fcm-subscribe"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-fcm-subscribe"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>fcm_token</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="fcm_token"                data-endpoint="POSTapi-v1-fcm-subscribe"
               value="consequatur"
               data-component="body">
    <br>
<p>The Firebase Cloud Messaging token. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>topic</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="topic"                data-endpoint="POSTapi-v1-fcm-subscribe"
               value="consequatur"
               data-component="body">
    <br>
<p>The topic to subscribe to. Default: offers Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>device_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="device_id"                data-endpoint="POSTapi-v1-fcm-subscribe"
               value="consequatur"
               data-component="body">
    <br>
<p>Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>device_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="device_type"                data-endpoint="POSTapi-v1-fcm-subscribe"
               value="consequatur"
               data-component="body">
    <br>
<p>Example: <code>consequatur</code></p>
        </div>
        </form>

                    <h2 id="authentication-POSTapi-v1-logout">Logout</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Log the user out (Invalidate the token).</p>

<span id="example-requests-POSTapi-v1-logout">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/logout" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/logout"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-logout">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Successfully logged out&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-logout" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-logout"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-logout"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-logout" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-logout">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-logout" data-method="POST"
      data-path="api/v1/logout"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-logout', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-logout"
                    onclick="tryItOut('POSTapi-v1-logout');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-logout"
                    onclick="cancelTryOut('POSTapi-v1-logout');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-logout"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/logout</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="authentication-POSTapi-v1-delete_account">Delete Account</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Delete the authenticated user's account.</p>

<span id="example-requests-POSTapi-v1-delete_account">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/delete_account" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/delete_account"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-delete_account">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Account deleted successfully&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-delete_account" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-delete_account"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-delete_account"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-delete_account" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-delete_account">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-delete_account" data-method="POST"
      data-path="api/v1/delete_account"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-delete_account', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-delete_account"
                    onclick="tryItOut('POSTapi-v1-delete_account');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-delete_account"
                    onclick="cancelTryOut('POSTapi-v1-delete_account');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-delete_account"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/delete_account</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-delete_account"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-delete_account"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                <h1 id="blogs">Blogs</h1>

    <p>APIs for managing blogs and blog categories.</p>

                                <h2 id="blogs-GETapi-v1-blog-categories">Get Blog Categories</h2>

<p>
</p>

<p>Returns a list of blog categories with their blogs count.</p>

<span id="example-requests-GETapi-v1-blog-categories">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/blog-categories" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/blog-categories"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-blog-categories">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 50
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;تمت العملية بنجاح&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;title&quot;: &quot;أخبار المصاحف&quot;,
            &quot;image&quot;: null,
            &quot;blogs_count&quot;: 3
        },
        {
            &quot;id&quot;: 2,
            &quot;title&quot;: &quot;مقالات دينية&quot;,
            &quot;image&quot;: null,
            &quot;blogs_count&quot;: 3
        },
        {
            &quot;id&quot;: 3,
            &quot;title&quot;: &quot;نصائح القراءة&quot;,
            &quot;image&quot;: null,
            &quot;blogs_count&quot;: 3
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-blog-categories" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-blog-categories"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-blog-categories"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-blog-categories" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-blog-categories">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-blog-categories" data-method="GET"
      data-path="api/v1/blog-categories"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-blog-categories', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-blog-categories"
                    onclick="tryItOut('GETapi-v1-blog-categories');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-blog-categories"
                    onclick="cancelTryOut('GETapi-v1-blog-categories');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-blog-categories"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/blog-categories</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-blog-categories"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-blog-categories"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="blogs-GETapi-v1-blogs">Get Blogs</h2>

<p>
</p>

<p>Returns a list of active blogs, can be filtered by category.</p>

<span id="example-requests-GETapi-v1-blogs">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/blogs?category_id=1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/blogs"
);

const params = {
    "category_id": "1",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-blogs">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 49
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;تمت العملية بنجاح&quot;,
    &quot;data&quot;: {
        &quot;data&quot;: [
            {
                &quot;id&quot;: 1,
                &quot;title&quot;: &quot;أخبار المصاحف - مقال رقم 1&quot;,
                &quot;description&quot;: &quot;&lt;p&gt;هذا نص تجريبي لمحتوى المقال. TnysJqZuWtV6LiekWRSjIXOVUw0lXrwPO6SglBnumrlefGCyueTwfEKUCkeX6jqu26ITlqsv7Dsl02e9K3Dqz2eolDWfnGcltZ5PtrAwS5FTZrL9SN8EFIyfGB3WSm2h9gN8jncgQquVZLrrLk82wiSmFUCN4VbNP1VDoLZrBt3Ixz4vd5WDBn5aUAMZhdSrgzghPSW6&lt;/p&gt;&lt;p&gt;7vfPJOYsqokNKfvP9BCibD9NoDq3jzeUSa9BkKQ2uwXMutv2ZADbQ5coYFZJQsT20zO3QxoDESa32d371cDm7P34iDStGOXUXQAZngeaYHhY5G9cldj8TcHlcJx2cbgIs7fIWQpupnsiWeWxXzqdoFbs09lnCCwJ5bFyVxUvend7CJ7BPOfz6DcdIENqny6yTacRVRNB3hWzNDnW9nfC7G9HDzixxB3mfcZI7OHTU9OOYfjaHQdUPPljTEMqHAr05xSCSQiWOdwgHce9zj71foINTv8ueFrGw9kYKTEyhQC2&lt;/p&gt;&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/news.jpg&quot;,
                &quot;slug&quot;: &quot;akhbar-almsahf-mkal-rkm-1&quot;,
                &quot;tags&quot;: &quot;islamic,quran,mushaf&quot;,
                &quot;meta_title&quot;: &quot;&quot;,
                &quot;meta_description&quot;: &quot;&quot;,
                &quot;meta_keywords&quot;: &quot;&quot;,
                &quot;Author&quot;: &quot;Admin&quot;,
                &quot;created_at&quot;: &quot;2026-02-10&quot;,
                &quot;category&quot;: {
                    &quot;id&quot;: 1,
                    &quot;title&quot;: &quot;أخبار المصاحف&quot;,
                    &quot;image&quot;: null,
                    &quot;blogs_count&quot;: null
                }
            },
            {
                &quot;id&quot;: 2,
                &quot;title&quot;: &quot;أخبار المصاحف - مقال رقم 2&quot;,
                &quot;description&quot;: &quot;&lt;p&gt;هذا نص تجريبي لمحتوى المقال. TNTp1cotQFylbzvPBxlLK2UPhcuo5QEH5d81qQZSfShh8TGgXaJckzJXMAlxELmEbdMt2PS62UvusuVb0JK6rKrWTnzzY9EhSIL60VRAdBHkcf3Aw9ECbW1ZSQ7sO6j9xzFCuHBl8Pqqah0nhywowawEWaykSpgOG5LHc2jOtrS7g4z7ewInO3nDwZ86NL2sdmS3chHZ&lt;/p&gt;&lt;p&gt;M91kArAuf7VtSKXr2K590pze4NsuJEu33AgFNOXhFphwpByboip4s9gVyLBOfqr2mjbCT4Xj1an2lU6kYRVKlipQoF2ct7LflssUb7hQXuwZ2QJVNf3tgJlz6OkcPGh38bSlh1pOmmrjikrjfwiDDt6ZCMmuEkMMcS6i2HBHZw6sj5rvfSRHEpyBlzlnsCvM3AzAIdFa3as0APWSMiC1gXPnRFrED4qTBcsIcJUU5SPesgHc2PGCYF0JGt46Y4oM9e66OQvBVM4LN71wHm2VPlzzzwsXPXIecw6zKWfr58A5&lt;/p&gt;&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/news.jpg&quot;,
                &quot;slug&quot;: &quot;akhbar-almsahf-mkal-rkm-2&quot;,
                &quot;tags&quot;: &quot;islamic,quran,mushaf&quot;,
                &quot;meta_title&quot;: &quot;&quot;,
                &quot;meta_description&quot;: &quot;&quot;,
                &quot;meta_keywords&quot;: &quot;&quot;,
                &quot;Author&quot;: &quot;Admin&quot;,
                &quot;created_at&quot;: &quot;2026-02-10&quot;,
                &quot;category&quot;: {
                    &quot;id&quot;: 1,
                    &quot;title&quot;: &quot;أخبار المصاحف&quot;,
                    &quot;image&quot;: null,
                    &quot;blogs_count&quot;: null
                }
            },
            {
                &quot;id&quot;: 3,
                &quot;title&quot;: &quot;أخبار المصاحف - مقال رقم 3&quot;,
                &quot;description&quot;: &quot;&lt;p&gt;هذا نص تجريبي لمحتوى المقال. TV0kzPuaGlFUWGV0mP1tAk7ORiEJBzv6Hp6LaAYqhjrQ3oi9htuBclcpPwTvYR4MeWz2AWYeLGI24aFy3pTFLfg0IEqKvmrAumUEcvcJILl9F2cgtny72zMxtKKyMOs80WLOtGFqLn110gdyrtfiqvBweP1qLmsevKAIz3XHNgJN8kXzTdJTt8L0XoONTRUCcqDZRo0O&lt;/p&gt;&lt;p&gt;UlLj2wHCys5ueaCmXSfUfOhveyirrV77gdkiIFFUEZz4GlTbfiNae0zIkmcdO0hBlrNPrx8C3zftJ1PEKL4NXvtOkekv8j6xqMwBgvwgAL1ZmNJ6pY9mHDJ3Ztqv6nSZdprD4dputvOcZ7F2MHWz19U5t6j4WCvRS0EjawzAhqsCBRN978XqJh1nx15V1qalaX997aAPBWb5hFIrdGuxekXpFgvD3Sgi6PvfXaVa2HilSJ1YNyqp6PEcITCC0NQuujEAiFQbMYIxnhVlPR42HUSSsX7odZ1ZACPmHwEa7qkp&lt;/p&gt;&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/news.jpg&quot;,
                &quot;slug&quot;: &quot;akhbar-almsahf-mkal-rkm-3&quot;,
                &quot;tags&quot;: &quot;islamic,quran,mushaf&quot;,
                &quot;meta_title&quot;: &quot;&quot;,
                &quot;meta_description&quot;: &quot;&quot;,
                &quot;meta_keywords&quot;: &quot;&quot;,
                &quot;Author&quot;: &quot;Admin&quot;,
                &quot;created_at&quot;: &quot;2026-02-10&quot;,
                &quot;category&quot;: {
                    &quot;id&quot;: 1,
                    &quot;title&quot;: &quot;أخبار المصاحف&quot;,
                    &quot;image&quot;: null,
                    &quot;blogs_count&quot;: null
                }
            }
        ],
        &quot;meta&quot;: {
            &quot;current_page&quot;: 1,
            &quot;per_page&quot;: 10,
            &quot;total&quot;: 3,
            &quot;last_page&quot;: 1
        }
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-blogs" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-blogs"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-blogs"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-blogs" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-blogs">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-blogs" data-method="GET"
      data-path="api/v1/blogs"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-blogs', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-blogs"
                    onclick="tryItOut('GETapi-v1-blogs');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-blogs"
                    onclick="cancelTryOut('GETapi-v1-blogs');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-blogs"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/blogs</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-blogs"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-blogs"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>category_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="category_id"                data-endpoint="GETapi-v1-blogs"
               value="1"
               data-component="query">
    <br>
<p>Filter by blog category ID. Example: <code>1</code></p>
            </div>
                </form>

                    <h2 id="blogs-GETapi-v1-blogs--id-">Get Blog Details</h2>

<p>
</p>

<p>Get a single blog details.</p>

<span id="example-requests-GETapi-v1-blogs--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/blogs/17" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/blogs/17"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-blogs--id-">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 48
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Blog not found&quot;,
    &quot;errors&quot;: null
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-blogs--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-blogs--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-blogs--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-blogs--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-blogs--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-blogs--id-" data-method="GET"
      data-path="api/v1/blogs/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-blogs--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-blogs--id-"
                    onclick="tryItOut('GETapi-v1-blogs--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-blogs--id-"
                    onclick="cancelTryOut('GETapi-v1-blogs--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-blogs--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/blogs/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-blogs--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-blogs--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-v1-blogs--id-"
               value="17"
               data-component="url">
    <br>
<p>The ID of the blog. Example: <code>17</code></p>
            </div>
                    </form>

                <h1 id="brands-partners">Brands / Partners</h1>

    <p>APIs for managing brands (partners).</p>

                                <h2 id="brands-partners-GETapi-v1-brands">Get All Brands</h2>

<p>
</p>

<p>Returns a list of brands (partners) with the count of products for each.</p>

<span id="example-requests-GETapi-v1-brands">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/brands" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/brands"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-brands">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 43
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;تمت العملية بنجاح&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;name&quot;: &quot;دار السلام&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/brands.png&quot;,
            &quot;products_count&quot;: 11,
            &quot;title&quot;: &quot;دار السلام&quot;
        },
        {
            &quot;id&quot;: 2,
            &quot;name&quot;: &quot;دار ابن حزم&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/brands.png&quot;,
            &quot;products_count&quot;: 12,
            &quot;title&quot;: &quot;دار ابن حزم&quot;
        },
        {
            &quot;id&quot;: 3,
            &quot;name&quot;: &quot;مكتبة جرير&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/brands.png&quot;,
            &quot;products_count&quot;: 21,
            &quot;title&quot;: &quot;مكتبة جرير&quot;
        },
        {
            &quot;id&quot;: 4,
            &quot;name&quot;: &quot;دار المعرفة&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/brands.png&quot;,
            &quot;products_count&quot;: 22,
            &quot;title&quot;: &quot;دار المعرفة&quot;
        },
        {
            &quot;id&quot;: 5,
            &quot;name&quot;: &quot;دار الشروق&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/brands.png&quot;,
            &quot;products_count&quot;: 18,
            &quot;title&quot;: &quot;دار الشروق&quot;
        },
        {
            &quot;id&quot;: 6,
            &quot;name&quot;: &quot;عصير الكتب&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/brands.png&quot;,
            &quot;products_count&quot;: 16,
            &quot;title&quot;: &quot;عصير الكتب&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-brands" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-brands"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-brands"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-brands" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-brands">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-brands" data-method="GET"
      data-path="api/v1/brands"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-brands', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-brands"
                    onclick="tryItOut('GETapi-v1-brands');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-brands"
                    onclick="cancelTryOut('GETapi-v1-brands');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-brands"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/brands</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-brands"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-brands"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                <h1 id="cart">Cart</h1>

    <p>APIs for managing the shopping cart</p>

                                <h2 id="cart-GETapi-v1-cart">Get Cart Items</h2>

<p>
</p>

<p>Get all items in the cart for the authenticated user or guest.</p>

<span id="example-requests-GETapi-v1-cart">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/cart" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"temp_user_id\": \"guest_123\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/cart"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "temp_user_id": "guest_123"
};

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-cart">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 33
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;تمت العملية بنجاح&quot;,
    &quot;data&quot;: {
        &quot;items&quot;: [],
        &quot;total&quot;: 0,
        &quot;formatted_total&quot;: &quot;0.00 ج.م&quot;,
        &quot;currency&quot;: {
            &quot;code&quot;: &quot;EGP&quot;,
            &quot;symbol&quot;: &quot;ج.م&quot;,
            &quot;exchange_rate&quot;: 1
        }
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-cart" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-cart"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-cart"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-cart" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-cart">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-cart" data-method="GET"
      data-path="api/v1/cart"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-cart', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-cart"
                    onclick="tryItOut('GETapi-v1-cart');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-cart"
                    onclick="cancelTryOut('GETapi-v1-cart');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-cart"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/cart</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-cart"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-cart"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>temp_user_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="temp_user_id"                data-endpoint="GETapi-v1-cart"
               value="guest_123"
               data-component="body">
    <br>
<p>Optional. Required if user is not authenticated. Example: <code>guest_123</code></p>
        </div>
        </form>

                    <h2 id="cart-POSTapi-v1-add-to-cart">Add to Cart</h2>

<p>
</p>

<p>Add a product to the cart.</p>

<span id="example-requests-POSTapi-v1-add-to-cart">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/add-to-cart" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"product_id\": 1,
    \"quantity\": 2,
    \"temp_user_id\": \"guest_123\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/add-to-cart"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "product_id": 1,
    "quantity": 2,
    "temp_user_id": "guest_123"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-add-to-cart">
</span>
<span id="execution-results-POSTapi-v1-add-to-cart" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-add-to-cart"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-add-to-cart"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-add-to-cart" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-add-to-cart">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-add-to-cart" data-method="POST"
      data-path="api/v1/add-to-cart"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-add-to-cart', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-add-to-cart"
                    onclick="tryItOut('POSTapi-v1-add-to-cart');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-add-to-cart"
                    onclick="cancelTryOut('POSTapi-v1-add-to-cart');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-add-to-cart"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/add-to-cart</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-add-to-cart"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-add-to-cart"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>product_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="product_id"                data-endpoint="POSTapi-v1-add-to-cart"
               value="1"
               data-component="body">
    <br>
<p>The ID of the product. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>quantity</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="quantity"                data-endpoint="POSTapi-v1-add-to-cart"
               value="2"
               data-component="body">
    <br>
<p>Optional. Default 1. Example: <code>2</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>temp_user_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="temp_user_id"                data-endpoint="POSTapi-v1-add-to-cart"
               value="guest_123"
               data-component="body">
    <br>
<p>Optional. Required if user is not authenticated. Example: <code>guest_123</code></p>
        </div>
        </form>

                    <h2 id="cart-POSTapi-v1-cart--id-">Update Cart Item</h2>

<p>
</p>

<p>Update quantity of a cart item.</p>

<span id="example-requests-POSTapi-v1-cart--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/cart/17" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"quantity\": 3
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/cart/17"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "quantity": 3
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-cart--id-">
</span>
<span id="execution-results-POSTapi-v1-cart--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-cart--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-cart--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-cart--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-cart--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-cart--id-" data-method="POST"
      data-path="api/v1/cart/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-cart--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-cart--id-"
                    onclick="tryItOut('POSTapi-v1-cart--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-cart--id-"
                    onclick="cancelTryOut('POSTapi-v1-cart--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-cart--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/cart/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-cart--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-cart--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="POSTapi-v1-cart--id-"
               value="17"
               data-component="url">
    <br>
<p>The ID of the cart item. Example: <code>17</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>quantity</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="quantity"                data-endpoint="POSTapi-v1-cart--id-"
               value="3"
               data-component="body">
    <br>
<p>The new quantity. Example: <code>3</code></p>
        </div>
        </form>

                    <h2 id="cart-DELETEapi-v1-cart--id-">Delete Cart Item</h2>

<p>
</p>

<p>Remove an item from the cart.</p>

<span id="example-requests-DELETEapi-v1-cart--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://127.0.0.1:8000/api/v1/cart/17" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/cart/17"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-v1-cart--id-">
</span>
<span id="execution-results-DELETEapi-v1-cart--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-v1-cart--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-v1-cart--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-v1-cart--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-v1-cart--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-v1-cart--id-" data-method="DELETE"
      data-path="api/v1/cart/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-v1-cart--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-v1-cart--id-"
                    onclick="tryItOut('DELETEapi-v1-cart--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-v1-cart--id-"
                    onclick="cancelTryOut('DELETEapi-v1-cart--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-v1-cart--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/v1/cart/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-v1-cart--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-v1-cart--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-v1-cart--id-"
               value="17"
               data-component="url">
    <br>
<p>The ID of the cart item. Example: <code>17</code></p>
            </div>
                    </form>

                <h1 id="categories">Categories</h1>

    <p>APIs for managing product categories.</p>

                                <h2 id="categories-GETapi-v1-categories">Get Main Categories</h2>

<p>
</p>

<p>Returns a list of main categories (parent_id is null).</p>

<span id="example-requests-GETapi-v1-categories">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/categories" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/categories"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-categories">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 45
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;تمت العملية بنجاح&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;title&quot;: &quot;كتب إسلامية&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
            &quot;products_count&quot;: 18,
            &quot;parent_id&quot;: null,
            &quot;sub_categories&quot;: [],
            &quot;fixed&quot;: false
        },
        {
            &quot;id&quot;: 6,
            &quot;title&quot;: &quot;الأدب والروايات&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
            &quot;products_count&quot;: 13,
            &quot;parent_id&quot;: null,
            &quot;sub_categories&quot;: [],
            &quot;fixed&quot;: false
        },
        {
            &quot;id&quot;: 10,
            &quot;title&quot;: &quot;كتب الأطفال&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
            &quot;products_count&quot;: 16,
            &quot;parent_id&quot;: null,
            &quot;sub_categories&quot;: [],
            &quot;fixed&quot;: false
        },
        {
            &quot;id&quot;: 13,
            &quot;title&quot;: &quot;تطوير الذات&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
            &quot;products_count&quot;: 14,
            &quot;parent_id&quot;: null,
            &quot;sub_categories&quot;: [],
            &quot;fixed&quot;: false
        },
        {
            &quot;id&quot;: 14,
            &quot;title&quot;: &quot;العلوم والتكنولوجيا&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
            &quot;products_count&quot;: 13,
            &quot;parent_id&quot;: null,
            &quot;sub_categories&quot;: [],
            &quot;fixed&quot;: false
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-categories" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-categories"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-categories"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-categories" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-categories">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-categories" data-method="GET"
      data-path="api/v1/categories"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-categories', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-categories"
                    onclick="tryItOut('GETapi-v1-categories');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-categories"
                    onclick="cancelTryOut('GETapi-v1-categories');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-categories"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/categories</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-categories"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-categories"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="categories-GETapi-v1-sub-categories">Get Sub Categories</h2>

<p>
</p>

<p>Returns a list of sub-categories (parent_id is NOT null/0).</p>

<span id="example-requests-GETapi-v1-sub-categories">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/sub-categories" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/sub-categories"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-sub-categories">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 44
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;تمت العملية بنجاح&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 2,
            &quot;title&quot;: &quot;القرآن الكريم&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
            &quot;products_count&quot;: 13,
            &quot;parent_id&quot;: 1,
            &quot;parent&quot;: {
                &quot;id&quot;: 1,
                &quot;title&quot;: &quot;كتب إسلامية&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                &quot;parent_id&quot;: null,
                &quot;sub_categories&quot;: [],
                &quot;fixed&quot;: false
            },
            &quot;sub_categories&quot;: [],
            &quot;fixed&quot;: false
        },
        {
            &quot;id&quot;: 3,
            &quot;title&quot;: &quot;الحديث الشريف&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
            &quot;products_count&quot;: 13,
            &quot;parent_id&quot;: 1,
            &quot;parent&quot;: {
                &quot;id&quot;: 1,
                &quot;title&quot;: &quot;كتب إسلامية&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                &quot;parent_id&quot;: null,
                &quot;sub_categories&quot;: [],
                &quot;fixed&quot;: false
            },
            &quot;sub_categories&quot;: [],
            &quot;fixed&quot;: false
        },
        {
            &quot;id&quot;: 4,
            &quot;title&quot;: &quot;الفقه والشريعة&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
            &quot;products_count&quot;: 17,
            &quot;parent_id&quot;: 1,
            &quot;parent&quot;: {
                &quot;id&quot;: 1,
                &quot;title&quot;: &quot;كتب إسلامية&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                &quot;parent_id&quot;: null,
                &quot;sub_categories&quot;: [],
                &quot;fixed&quot;: false
            },
            &quot;sub_categories&quot;: [],
            &quot;fixed&quot;: false
        },
        {
            &quot;id&quot;: 5,
            &quot;title&quot;: &quot;التاريخ الإسلامي&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
            &quot;products_count&quot;: 15,
            &quot;parent_id&quot;: 1,
            &quot;parent&quot;: {
                &quot;id&quot;: 1,
                &quot;title&quot;: &quot;كتب إسلامية&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                &quot;parent_id&quot;: null,
                &quot;sub_categories&quot;: [],
                &quot;fixed&quot;: false
            },
            &quot;sub_categories&quot;: [],
            &quot;fixed&quot;: false
        },
        {
            &quot;id&quot;: 7,
            &quot;title&quot;: &quot;روايات عربية&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
            &quot;products_count&quot;: 12,
            &quot;parent_id&quot;: 6,
            &quot;parent&quot;: {
                &quot;id&quot;: 6,
                &quot;title&quot;: &quot;الأدب والروايات&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                &quot;parent_id&quot;: null,
                &quot;sub_categories&quot;: [],
                &quot;fixed&quot;: false
            },
            &quot;sub_categories&quot;: [],
            &quot;fixed&quot;: false
        },
        {
            &quot;id&quot;: 8,
            &quot;title&quot;: &quot;أدب عالمي&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
            &quot;products_count&quot;: 15,
            &quot;parent_id&quot;: 6,
            &quot;parent&quot;: {
                &quot;id&quot;: 6,
                &quot;title&quot;: &quot;الأدب والروايات&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                &quot;parent_id&quot;: null,
                &quot;sub_categories&quot;: [],
                &quot;fixed&quot;: false
            },
            &quot;sub_categories&quot;: [],
            &quot;fixed&quot;: false
        },
        {
            &quot;id&quot;: 9,
            &quot;title&quot;: &quot;الشعر&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
            &quot;products_count&quot;: 18,
            &quot;parent_id&quot;: 6,
            &quot;parent&quot;: {
                &quot;id&quot;: 6,
                &quot;title&quot;: &quot;الأدب والروايات&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                &quot;parent_id&quot;: null,
                &quot;sub_categories&quot;: [],
                &quot;fixed&quot;: false
            },
            &quot;sub_categories&quot;: [],
            &quot;fixed&quot;: false
        },
        {
            &quot;id&quot;: 11,
            &quot;title&quot;: &quot;قصص تعليمية&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
            &quot;products_count&quot;: 15,
            &quot;parent_id&quot;: 10,
            &quot;parent&quot;: {
                &quot;id&quot;: 10,
                &quot;title&quot;: &quot;كتب الأطفال&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                &quot;parent_id&quot;: null,
                &quot;sub_categories&quot;: [],
                &quot;fixed&quot;: false
            },
            &quot;sub_categories&quot;: [],
            &quot;fixed&quot;: false
        },
        {
            &quot;id&quot;: 12,
            &quot;title&quot;: &quot;كتب أنشطة&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
            &quot;products_count&quot;: 19,
            &quot;parent_id&quot;: 10,
            &quot;parent&quot;: {
                &quot;id&quot;: 10,
                &quot;title&quot;: &quot;كتب الأطفال&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                &quot;parent_id&quot;: null,
                &quot;sub_categories&quot;: [],
                &quot;fixed&quot;: false
            },
            &quot;sub_categories&quot;: [],
            &quot;fixed&quot;: false
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-sub-categories" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-sub-categories"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-sub-categories"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-sub-categories" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-sub-categories">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-sub-categories" data-method="GET"
      data-path="api/v1/sub-categories"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-sub-categories', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-sub-categories"
                    onclick="tryItOut('GETapi-v1-sub-categories');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-sub-categories"
                    onclick="cancelTryOut('GETapi-v1-sub-categories');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-sub-categories"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/sub-categories</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-sub-categories"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-sub-categories"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                <h1 id="checkout">Checkout</h1>

    <p>APIs for handling order checkout, summary calculation, and order placement.</p>

                                <h2 id="checkout-POSTapi-v1-checkout-summary">Get Checkout Summary</h2>

<p>
</p>

<p>Calculates the order breakdowns including subtotal, shipping, discounts, and total.</p>

<span id="example-requests-POSTapi-v1-checkout-summary">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/checkout/summary" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"coupon_code\": \"consequatur\",
    \"temp_user_id\": \"consequatur\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/checkout/summary"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "coupon_code": "consequatur",
    "temp_user_id": "consequatur"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-checkout-summary">
</span>
<span id="execution-results-POSTapi-v1-checkout-summary" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-checkout-summary"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-checkout-summary"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-checkout-summary" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-checkout-summary">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-checkout-summary" data-method="POST"
      data-path="api/v1/checkout/summary"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-checkout-summary', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-checkout-summary"
                    onclick="tryItOut('POSTapi-v1-checkout-summary');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-checkout-summary"
                    onclick="cancelTryOut('POSTapi-v1-checkout-summary');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-checkout-summary"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/checkout/summary</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-checkout-summary"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-checkout-summary"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>address_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="address_id"                data-endpoint="POSTapi-v1-checkout-summary"
               value=""
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the user_addresses table.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>payment_method_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="payment_method_id"                data-endpoint="POSTapi-v1-checkout-summary"
               value=""
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the payment_methods table.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>coupon_code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="coupon_code"                data-endpoint="POSTapi-v1-checkout-summary"
               value="consequatur"
               data-component="body">
    <br>
<p>Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>services</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="services[0]"                data-endpoint="POSTapi-v1-checkout-summary"
               data-component="body">
        <input type="text" style="display: none"
               name="services[1]"                data-endpoint="POSTapi-v1-checkout-summary"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the order_services table.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>temp_user_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="temp_user_id"                data-endpoint="POSTapi-v1-checkout-summary"
               value="consequatur"
               data-component="body">
    <br>
<p>Example: <code>consequatur</code></p>
        </div>
        </form>

                    <h2 id="checkout-POSTapi-v1-checkout-apply-coupon">Apply Coupon (Validation only)</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-checkout-apply-coupon">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/checkout/apply-coupon" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"code\": \"consequatur\",
    \"temp_user_id\": \"consequatur\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/checkout/apply-coupon"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "code": "consequatur",
    "temp_user_id": "consequatur"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-checkout-apply-coupon">
</span>
<span id="execution-results-POSTapi-v1-checkout-apply-coupon" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-checkout-apply-coupon"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-checkout-apply-coupon"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-checkout-apply-coupon" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-checkout-apply-coupon">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-checkout-apply-coupon" data-method="POST"
      data-path="api/v1/checkout/apply-coupon"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-checkout-apply-coupon', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-checkout-apply-coupon"
                    onclick="tryItOut('POSTapi-v1-checkout-apply-coupon');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-checkout-apply-coupon"
                    onclick="cancelTryOut('POSTapi-v1-checkout-apply-coupon');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-checkout-apply-coupon"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/checkout/apply-coupon</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-checkout-apply-coupon"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-checkout-apply-coupon"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="POSTapi-v1-checkout-apply-coupon"
               value="consequatur"
               data-component="body">
    <br>
<p>Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>payment_method_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="payment_method_id"                data-endpoint="POSTapi-v1-checkout-apply-coupon"
               value=""
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the payment_methods table.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>temp_user_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="temp_user_id"                data-endpoint="POSTapi-v1-checkout-apply-coupon"
               value="consequatur"
               data-component="body">
    <br>
<p>Example: <code>consequatur</code></p>
        </div>
        </form>

                    <h2 id="checkout-POSTapi-v1-checkout-store">Place Order</h2>

<p>
</p>

<p>Creates a new order and clears the cart.</p>

<span id="example-requests-POSTapi-v1-checkout-store">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/checkout/store" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"payment_method_id\": \"consequatur\",
    \"coupon_code\": \"consequatur\",
    \"note\": \"mqeopfuudtdsufvyvddqa\",
    \"temp_user_id\": \"consequatur\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/checkout/store"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "payment_method_id": "consequatur",
    "coupon_code": "consequatur",
    "note": "mqeopfuudtdsufvyvddqa",
    "temp_user_id": "consequatur"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-checkout-store">
</span>
<span id="execution-results-POSTapi-v1-checkout-store" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-checkout-store"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-checkout-store"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-checkout-store" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-checkout-store">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-checkout-store" data-method="POST"
      data-path="api/v1/checkout/store"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-checkout-store', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-checkout-store"
                    onclick="tryItOut('POSTapi-v1-checkout-store');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-checkout-store"
                    onclick="cancelTryOut('POSTapi-v1-checkout-store');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-checkout-store"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/checkout/store</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-checkout-store"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-checkout-store"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>address_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="address_id"                data-endpoint="POSTapi-v1-checkout-store"
               value=""
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the user_addresses table.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>payment_method_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="payment_method_id"                data-endpoint="POSTapi-v1-checkout-store"
               value="consequatur"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the payment_methods table. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>coupon_code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="coupon_code"                data-endpoint="POSTapi-v1-checkout-store"
               value="consequatur"
               data-component="body">
    <br>
<p>Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>services</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="services[0]"                data-endpoint="POSTapi-v1-checkout-store"
               data-component="body">
        <input type="text" style="display: none"
               name="services[1]"                data-endpoint="POSTapi-v1-checkout-store"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the order_services table.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="note"                data-endpoint="POSTapi-v1-checkout-store"
               value="mqeopfuudtdsufvyvddqa"
               data-component="body">
    <br>
<p>Must not be greater than 500 characters. Example: <code>mqeopfuudtdsufvyvddqa</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>temp_user_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="temp_user_id"                data-endpoint="POSTapi-v1-checkout-store"
               value="consequatur"
               data-component="body">
    <br>
<p>Example: <code>consequatur</code></p>
        </div>
        </form>

                <h1 id="endpoints">Endpoints</h1>

    

                                <h2 id="endpoints-GETapi-v1-home">Get Integrated Home Data</h2>

<p>
</p>

<p>Returns all data needed for the home page including sliders, offers, ads, categories, products, partners, and blogs.</p>

<span id="example-requests-GETapi-v1-home">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/home" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/home"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-home">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 59
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;data&quot;: {
        &quot;sliders&quot;: [
            {
                &quot;id&quot;: 1,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/sliders.jpg&quot;,
                &quot;link_type&quot;: null,
                &quot;link_id&quot;: null,
                &quot;title&quot;: &quot;مرحباً بكم في مصحف هوم&quot;,
                &quot;description&quot;: &quot;&quot;,
                &quot;category&quot;: null,
                &quot;sort_order&quot;: 0,
                &quot;link&quot;: &quot;&quot;,
                &quot;category_id&quot;: null,
                &quot;category_title&quot;: &quot;&quot;,
                &quot;type&quot;: &quot;category&quot;
            },
            {
                &quot;id&quot;: 2,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/sliders.jpg&quot;,
                &quot;link_type&quot;: null,
                &quot;link_id&quot;: null,
                &quot;title&quot;: &quot;جديد المصاحف&quot;,
                &quot;description&quot;: &quot;&quot;,
                &quot;category&quot;: null,
                &quot;sort_order&quot;: 1,
                &quot;link&quot;: &quot;&quot;,
                &quot;category_id&quot;: null,
                &quot;category_title&quot;: &quot;&quot;,
                &quot;type&quot;: &quot;category&quot;
            }
        ],
        &quot;top_offers&quot;: [],
        &quot;home_ads&quot;: [
            {
                &quot;id&quot;: 1,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/ads.webp&quot;,
                &quot;link&quot;: &quot;https://example.com/sale&quot;,
                &quot;position&quot;: &quot;home&quot;,
                &quot;sort_order&quot;: null
            }
        ],
        &quot;main_categories&quot;: [
            {
                &quot;id&quot;: 1,
                &quot;title&quot;: &quot;كتب إسلامية&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                &quot;products_count&quot;: 18,
                &quot;parent_id&quot;: null,
                &quot;sub_categories&quot;: [
                    {
                        &quot;id&quot;: 2,
                        &quot;title&quot;: &quot;القرآن الكريم&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 1,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 3,
                        &quot;title&quot;: &quot;الحديث الشريف&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 1,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 4,
                        &quot;title&quot;: &quot;الفقه والشريعة&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 1,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 5,
                        &quot;title&quot;: &quot;التاريخ الإسلامي&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 1,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;fixed&quot;: false
            },
            {
                &quot;id&quot;: 6,
                &quot;title&quot;: &quot;الأدب والروايات&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                &quot;products_count&quot;: 13,
                &quot;parent_id&quot;: null,
                &quot;sub_categories&quot;: [
                    {
                        &quot;id&quot;: 7,
                        &quot;title&quot;: &quot;روايات عربية&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 6,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 8,
                        &quot;title&quot;: &quot;أدب عالمي&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 6,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 9,
                        &quot;title&quot;: &quot;الشعر&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 6,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;fixed&quot;: false
            },
            {
                &quot;id&quot;: 10,
                &quot;title&quot;: &quot;كتب الأطفال&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                &quot;products_count&quot;: 16,
                &quot;parent_id&quot;: null,
                &quot;sub_categories&quot;: [
                    {
                        &quot;id&quot;: 11,
                        &quot;title&quot;: &quot;قصص تعليمية&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 10,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 12,
                        &quot;title&quot;: &quot;كتب أنشطة&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 10,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;fixed&quot;: false
            },
            {
                &quot;id&quot;: 13,
                &quot;title&quot;: &quot;تطوير الذات&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                &quot;products_count&quot;: 14,
                &quot;parent_id&quot;: null,
                &quot;sub_categories&quot;: [],
                &quot;fixed&quot;: false
            },
            {
                &quot;id&quot;: 14,
                &quot;title&quot;: &quot;العلوم والتكنولوجيا&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                &quot;products_count&quot;: 13,
                &quot;parent_id&quot;: null,
                &quot;sub_categories&quot;: [],
                &quot;fixed&quot;: false
            }
        ],
        &quot;sub_categories&quot;: [
            {
                &quot;id&quot;: 2,
                &quot;title&quot;: &quot;القرآن الكريم&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                &quot;products_count&quot;: 13,
                &quot;parent_id&quot;: 1,
                &quot;parent&quot;: {
                    &quot;id&quot;: 1,
                    &quot;title&quot;: &quot;كتب إسلامية&quot;,
                    &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                    &quot;parent_id&quot;: null,
                    &quot;sub_categories&quot;: [],
                    &quot;fixed&quot;: false
                },
                &quot;sub_categories&quot;: [],
                &quot;fixed&quot;: false
            },
            {
                &quot;id&quot;: 3,
                &quot;title&quot;: &quot;الحديث الشريف&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                &quot;products_count&quot;: 13,
                &quot;parent_id&quot;: 1,
                &quot;parent&quot;: {
                    &quot;id&quot;: 1,
                    &quot;title&quot;: &quot;كتب إسلامية&quot;,
                    &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                    &quot;parent_id&quot;: null,
                    &quot;sub_categories&quot;: [],
                    &quot;fixed&quot;: false
                },
                &quot;sub_categories&quot;: [],
                &quot;fixed&quot;: false
            },
            {
                &quot;id&quot;: 4,
                &quot;title&quot;: &quot;الفقه والشريعة&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                &quot;products_count&quot;: 17,
                &quot;parent_id&quot;: 1,
                &quot;parent&quot;: {
                    &quot;id&quot;: 1,
                    &quot;title&quot;: &quot;كتب إسلامية&quot;,
                    &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                    &quot;parent_id&quot;: null,
                    &quot;sub_categories&quot;: [],
                    &quot;fixed&quot;: false
                },
                &quot;sub_categories&quot;: [],
                &quot;fixed&quot;: false
            },
            {
                &quot;id&quot;: 5,
                &quot;title&quot;: &quot;التاريخ الإسلامي&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                &quot;products_count&quot;: 15,
                &quot;parent_id&quot;: 1,
                &quot;parent&quot;: {
                    &quot;id&quot;: 1,
                    &quot;title&quot;: &quot;كتب إسلامية&quot;,
                    &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                    &quot;parent_id&quot;: null,
                    &quot;sub_categories&quot;: [],
                    &quot;fixed&quot;: false
                },
                &quot;sub_categories&quot;: [],
                &quot;fixed&quot;: false
            },
            {
                &quot;id&quot;: 7,
                &quot;title&quot;: &quot;روايات عربية&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                &quot;products_count&quot;: 12,
                &quot;parent_id&quot;: 6,
                &quot;parent&quot;: {
                    &quot;id&quot;: 6,
                    &quot;title&quot;: &quot;الأدب والروايات&quot;,
                    &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                    &quot;parent_id&quot;: null,
                    &quot;sub_categories&quot;: [],
                    &quot;fixed&quot;: false
                },
                &quot;sub_categories&quot;: [],
                &quot;fixed&quot;: false
            },
            {
                &quot;id&quot;: 8,
                &quot;title&quot;: &quot;أدب عالمي&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                &quot;products_count&quot;: 15,
                &quot;parent_id&quot;: 6,
                &quot;parent&quot;: {
                    &quot;id&quot;: 6,
                    &quot;title&quot;: &quot;الأدب والروايات&quot;,
                    &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                    &quot;parent_id&quot;: null,
                    &quot;sub_categories&quot;: [],
                    &quot;fixed&quot;: false
                },
                &quot;sub_categories&quot;: [],
                &quot;fixed&quot;: false
            },
            {
                &quot;id&quot;: 9,
                &quot;title&quot;: &quot;الشعر&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                &quot;products_count&quot;: 18,
                &quot;parent_id&quot;: 6,
                &quot;parent&quot;: {
                    &quot;id&quot;: 6,
                    &quot;title&quot;: &quot;الأدب والروايات&quot;,
                    &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                    &quot;parent_id&quot;: null,
                    &quot;sub_categories&quot;: [],
                    &quot;fixed&quot;: false
                },
                &quot;sub_categories&quot;: [],
                &quot;fixed&quot;: false
            },
            {
                &quot;id&quot;: 11,
                &quot;title&quot;: &quot;قصص تعليمية&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                &quot;products_count&quot;: 15,
                &quot;parent_id&quot;: 10,
                &quot;parent&quot;: {
                    &quot;id&quot;: 10,
                    &quot;title&quot;: &quot;كتب الأطفال&quot;,
                    &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                    &quot;parent_id&quot;: null,
                    &quot;sub_categories&quot;: [],
                    &quot;fixed&quot;: false
                },
                &quot;sub_categories&quot;: [],
                &quot;fixed&quot;: false
            },
            {
                &quot;id&quot;: 12,
                &quot;title&quot;: &quot;كتب أنشطة&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                &quot;products_count&quot;: 19,
                &quot;parent_id&quot;: 10,
                &quot;parent&quot;: {
                    &quot;id&quot;: 10,
                    &quot;title&quot;: &quot;كتب الأطفال&quot;,
                    &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                    &quot;parent_id&quot;: null,
                    &quot;sub_categories&quot;: [],
                    &quot;fixed&quot;: false
                },
                &quot;sub_categories&quot;: [],
                &quot;fixed&quot;: false
            }
        ],
        &quot;best_sellers&quot;: [
            {
                &quot;id&quot;: 1,
                &quot;name&quot;: &quot;شرح التجويد الجامع&quot;,
                &quot;description&quot;: &quot;Beatae necessitatibus beatae esse maiores suscipit cupiditate possimus. Nam minima ut sit aspernatur. Aut animi vitae corrupti exercitationem quibusdam. شرح التجويد الجامع&quot;,
                &quot;slug&quot;: &quot;shrh-altgoyd-algamaa-1&quot;,
                &quot;meta_title&quot;: &quot;شرح التجويد الجامع&quot;,
                &quot;meta_description&quot;: &quot;Praesentium magni maxime dolorem aliquam.&quot;,
                &quot;sku&quot;: &quot;GDGLP7MS&quot;,
                &quot;price&quot;: 64,
                &quot;formatted_price&quot;: &quot;64.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 64,
                &quot;formatted_final_price&quot;: &quot;64.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 102,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: true,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.57,
                &quot;viewed&quot;: 208,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 6,
                &quot;brand&quot;: {
                    &quot;id&quot;: 6,
                    &quot;name&quot;: &quot;عصير الكتب&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
                &quot;title&quot;: &quot;شرح التجويد الجامع&quot;,
                &quot;category_id&quot;: 3,
                &quot;category&quot;: &quot;الحديث الشريف&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 64,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;GDGLP7MS&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/1&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 7,
                &quot;name&quot;: &quot;تهذيب العقيدة الصغير&quot;,
                &quot;description&quot;: &quot;Ab itaque non at quidem. Ducimus sed qui ullam laboriosam modi doloribus. Veniam quaerat rerum recusandae eos. تهذيب العقيدة الصغير&quot;,
                &quot;slug&quot;: &quot;ththyb-alaakyd-alsghyr-7&quot;,
                &quot;meta_title&quot;: &quot;تهذيب العقيدة الصغير&quot;,
                &quot;meta_description&quot;: &quot;Temporibus quae non inventore doloribus labore et sint.&quot;,
                &quot;sku&quot;: &quot;PQBPEXBI&quot;,
                &quot;price&quot;: 228,
                &quot;formatted_price&quot;: &quot;228.00 ج.م&quot;,
                &quot;special_price&quot;: 182.4,
                &quot;formatted_special_price&quot;: &quot;182.40 ج.م&quot;,
                &quot;special_price_start&quot;: &quot;2026-02-09&quot;,
                &quot;special_price_end&quot;: &quot;2026-02-25&quot;,
                &quot;final_price&quot;: 182.4,
                &quot;formatted_final_price&quot;: &quot;182.40 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book2.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 191,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: true,
                &quot;best_seller_start&quot;: &quot;2026-02-10&quot;,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.02,
                &quot;viewed&quot;: 1571,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 6,
                &quot;brand&quot;: {
                    &quot;id&quot;: 6,
                    &quot;name&quot;: &quot;عصير الكتب&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book2.png&quot;,
                &quot;title&quot;: &quot;تهذيب العقيدة الصغير&quot;,
                &quot;category_id&quot;: 4,
                &quot;category&quot;: &quot;الفقه والشريعة&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 182.4,
                &quot;discount_percentage&quot;: 20,
                &quot;item_code&quot;: &quot;PQBPEXBI&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/7&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 9,
                &quot;name&quot;: &quot;مختصر التجويد الوجيز&quot;,
                &quot;description&quot;: &quot;Quam temporibus dolores ipsum. Quas rerum aperiam maiores sunt fugit. مختصر التجويد الوجيز&quot;,
                &quot;slug&quot;: &quot;mkhtsr-altgoyd-alogyz-9&quot;,
                &quot;meta_title&quot;: &quot;مختصر التجويد الوجيز&quot;,
                &quot;meta_description&quot;: &quot;Odio quo est sed est eius.&quot;,
                &quot;sku&quot;: &quot;P3A8QWON&quot;,
                &quot;price&quot;: 238,
                &quot;formatted_price&quot;: &quot;238.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 238,
                &quot;formatted_final_price&quot;: &quot;238.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 169,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: true,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.37,
                &quot;viewed&quot;: 4543,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 3,
                &quot;brand&quot;: {
                    &quot;id&quot;: 3,
                    &quot;name&quot;: &quot;مكتبة جرير&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;title&quot;: &quot;مختصر التجويد الوجيز&quot;,
                &quot;category_id&quot;: 1,
                &quot;category&quot;: &quot;كتب إسلامية&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 238,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;P3A8QWON&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/9&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 14,
                &quot;name&quot;: &quot;تاريخ الحديث الصغير&quot;,
                &quot;description&quot;: &quot;Ducimus dolore sunt soluta vero. Temporibus eveniet aut est sint iure. Nihil sunt cumque tempore doloribus rerum et iusto eius. تاريخ الحديث الصغير&quot;,
                &quot;slug&quot;: &quot;tarykh-alhdyth-alsghyr-14&quot;,
                &quot;meta_title&quot;: &quot;تاريخ الحديث الصغير&quot;,
                &quot;meta_description&quot;: &quot;Nulla dolorum qui qui est.&quot;,
                &quot;sku&quot;: &quot;GBD8XHBG&quot;,
                &quot;price&quot;: 309,
                &quot;formatted_price&quot;: &quot;309.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 309,
                &quot;formatted_final_price&quot;: &quot;309.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 90,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: true,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 0.62,
                &quot;viewed&quot;: 98,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 1,
                &quot;brand&quot;: {
                    &quot;id&quot;: 1,
                    &quot;name&quot;: &quot;دار السلام&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;title&quot;: &quot;تاريخ الحديث الصغير&quot;,
                &quot;category_id&quot;: 14,
                &quot;category&quot;: &quot;العلوم والتكنولوجيا&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 309,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;GBD8XHBG&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/14&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 28,
                &quot;name&quot;: &quot;شرح التجويد الكبير&quot;,
                &quot;description&quot;: &quot;Et delectus et iste maiores ut. Est dolor aspernatur rerum rem asperiores. Velit eius qui eligendi dicta et voluptatem. Deleniti dignissimos dignissimos sit dolore non id. شرح التجويد الكبير&quot;,
                &quot;slug&quot;: &quot;shrh-altgoyd-alkbyr-28&quot;,
                &quot;meta_title&quot;: &quot;شرح التجويد الكبير&quot;,
                &quot;meta_description&quot;: &quot;Dicta et fugiat eum velit totam quia et.&quot;,
                &quot;sku&quot;: &quot;YOO3UOP2&quot;,
                &quot;price&quot;: 341,
                &quot;formatted_price&quot;: &quot;341.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 341,
                &quot;formatted_final_price&quot;: &quot;341.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 87,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: true,
                &quot;best_seller_start&quot;: &quot;2026-02-10&quot;,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.83,
                &quot;viewed&quot;: 2850,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 2,
                &quot;brand&quot;: {
                    &quot;id&quot;: 2,
                    &quot;name&quot;: &quot;دار ابن حزم&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;title&quot;: &quot;شرح التجويد الكبير&quot;,
                &quot;category_id&quot;: 11,
                &quot;category&quot;: &quot;قصص تعليمية&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 341,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;YOO3UOP2&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/28&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 30,
                &quot;name&quot;: &quot;تهذيب الحديث الكبير&quot;,
                &quot;description&quot;: &quot;Voluptatem vel labore qui facere praesentium sapiente. Id id pariatur eveniet reiciendis sed odit. Illo doloribus accusantium perspiciatis quaerat veniam facilis. تهذيب الحديث الكبير&quot;,
                &quot;slug&quot;: &quot;ththyb-alhdyth-alkbyr-30&quot;,
                &quot;meta_title&quot;: &quot;تهذيب الحديث الكبير&quot;,
                &quot;meta_description&quot;: &quot;Omnis modi rerum voluptatem suscipit ad nihil.&quot;,
                &quot;sku&quot;: &quot;B7KMIBXN&quot;,
                &quot;price&quot;: 172,
                &quot;formatted_price&quot;: &quot;172.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 172,
                &quot;formatted_final_price&quot;: &quot;172.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 173,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: true,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.97,
                &quot;viewed&quot;: 2037,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 5,
                &quot;brand&quot;: {
                    &quot;id&quot;: 5,
                    &quot;name&quot;: &quot;دار الشروق&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
                &quot;title&quot;: &quot;تهذيب الحديث الكبير&quot;,
                &quot;category_id&quot;: 8,
                &quot;category&quot;: &quot;أدب عالمي&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 172,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;B7KMIBXN&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/30&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 43,
                &quot;name&quot;: &quot;حاشية الفقه الوافي&quot;,
                &quot;description&quot;: &quot;Porro velit tempora beatae facere. Velit quos qui facilis aut. Voluptas quo eveniet inventore incidunt. Nulla magni laborum sunt. حاشية الفقه الوافي&quot;,
                &quot;slug&quot;: &quot;hashy-alfkh-aloafy-43&quot;,
                &quot;meta_title&quot;: &quot;حاشية الفقه الوافي&quot;,
                &quot;meta_description&quot;: &quot;Quos et et ut suscipit iste.&quot;,
                &quot;sku&quot;: &quot;Y3KECNJJ&quot;,
                &quot;price&quot;: 58,
                &quot;formatted_price&quot;: &quot;58.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 58,
                &quot;formatted_final_price&quot;: &quot;58.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 72,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: true,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.99,
                &quot;viewed&quot;: 3241,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 3,
                &quot;brand&quot;: {
                    &quot;id&quot;: 3,
                    &quot;name&quot;: &quot;مكتبة جرير&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;title&quot;: &quot;حاشية الفقه الوافي&quot;,
                &quot;category_id&quot;: 4,
                &quot;category&quot;: &quot;الفقه والشريعة&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 58,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;Y3KECNJJ&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/43&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 47,
                &quot;name&quot;: &quot;شرح الأذكار الميسر&quot;,
                &quot;description&quot;: &quot;Dolor odit accusamus omnis minus minima rerum consequuntur velit. Commodi veritatis quis maiores quo. Aut ut aut ut eum quod. Iste omnis eos eaque optio. شرح الأذكار الميسر&quot;,
                &quot;slug&quot;: &quot;shrh-alathkar-almysr-47&quot;,
                &quot;meta_title&quot;: &quot;شرح الأذكار الميسر&quot;,
                &quot;meta_description&quot;: &quot;Dicta ab et excepturi voluptate.&quot;,
                &quot;sku&quot;: &quot;Y0CQYJUU&quot;,
                &quot;price&quot;: 416,
                &quot;formatted_price&quot;: &quot;416.00 ج.م&quot;,
                &quot;special_price&quot;: 332.8,
                &quot;formatted_special_price&quot;: &quot;332.80 ج.م&quot;,
                &quot;special_price_start&quot;: &quot;2026-02-09&quot;,
                &quot;special_price_end&quot;: &quot;2026-02-25&quot;,
                &quot;final_price&quot;: 332.8,
                &quot;formatted_final_price&quot;: &quot;332.80 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book3.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 48,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: true,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 0.9,
                &quot;viewed&quot;: 2872,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 3,
                &quot;brand&quot;: {
                    &quot;id&quot;: 3,
                    &quot;name&quot;: &quot;مكتبة جرير&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book3.png&quot;,
                &quot;title&quot;: &quot;شرح الأذكار الميسر&quot;,
                &quot;category_id&quot;: 7,
                &quot;category&quot;: &quot;روايات عربية&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 332.8,
                &quot;discount_percentage&quot;: 20,
                &quot;item_code&quot;: &quot;Y0CQYJUU&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/47&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            }
        ],
        &quot;latest_products&quot;: [
            {
                &quot;id&quot;: 88,
                &quot;name&quot;: &quot;تفسير مسلم الصغير&quot;,
                &quot;description&quot;: &quot;Nam possimus distinctio modi ab eum. Illum fugiat aperiam et deserunt. Culpa quia officiis dolor libero ut enim. تفسير مسلم الصغير&quot;,
                &quot;slug&quot;: &quot;tfsyr-mslm-alsghyr-88&quot;,
                &quot;meta_title&quot;: &quot;تفسير مسلم الصغير&quot;,
                &quot;meta_description&quot;: &quot;Nihil officia quia provident molestiae sit.&quot;,
                &quot;sku&quot;: &quot;6AQJWWVQ&quot;,
                &quot;price&quot;: 205,
                &quot;formatted_price&quot;: &quot;205.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 205,
                &quot;formatted_final_price&quot;: &quot;205.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 181,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: false,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 0.95,
                &quot;viewed&quot;: 1451,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 5,
                &quot;brand&quot;: {
                    &quot;id&quot;: 5,
                    &quot;name&quot;: &quot;دار الشروق&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;title&quot;: &quot;تفسير مسلم الصغير&quot;,
                &quot;category_id&quot;: 5,
                &quot;category&quot;: &quot;التاريخ الإسلامي&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 205,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;6AQJWWVQ&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/88&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 89,
                &quot;name&quot;: &quot;شرح العقيدة الشامل&quot;,
                &quot;description&quot;: &quot;Totam possimus cumque tempora aliquid ut consequatur. Dolor sint iure cupiditate omnis adipisci repellat. Et facilis et asperiores ad sequi. شرح العقيدة الشامل&quot;,
                &quot;slug&quot;: &quot;shrh-alaakyd-alshaml-89&quot;,
                &quot;meta_title&quot;: &quot;شرح العقيدة الشامل&quot;,
                &quot;meta_description&quot;: &quot;Sequi totam tenetur accusamus cum.&quot;,
                &quot;sku&quot;: &quot;S00NWVM0&quot;,
                &quot;price&quot;: 419,
                &quot;formatted_price&quot;: &quot;419.00 ج.م&quot;,
                &quot;special_price&quot;: 335.2,
                &quot;formatted_special_price&quot;: &quot;335.20 ج.م&quot;,
                &quot;special_price_start&quot;: &quot;2026-02-09&quot;,
                &quot;special_price_end&quot;: &quot;2026-02-25&quot;,
                &quot;final_price&quot;: 335.2,
                &quot;formatted_final_price&quot;: &quot;335.20 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 143,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: false,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.11,
                &quot;viewed&quot;: 751,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 4,
                &quot;brand&quot;: {
                    &quot;id&quot;: 4,
                    &quot;name&quot;: &quot;دار المعرفة&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
                &quot;title&quot;: &quot;شرح العقيدة الشامل&quot;,
                &quot;category_id&quot;: 12,
                &quot;category&quot;: &quot;كتب أنشطة&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 335.2,
                &quot;discount_percentage&quot;: 20,
                &quot;item_code&quot;: &quot;S00NWVM0&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/89&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 90,
                &quot;name&quot;: &quot;شرح الفقه الصغير&quot;,
                &quot;description&quot;: &quot;Rerum ullam beatae dicta nemo repellat. Impedit quos sed porro vero. Rerum non officia veritatis exercitationem. Repellendus non repellat nihil voluptate laboriosam mollitia fugiat. Numquam quaerat qui et praesentium culpa. شرح الفقه الصغير&quot;,
                &quot;slug&quot;: &quot;shrh-alfkh-alsghyr-90&quot;,
                &quot;meta_title&quot;: &quot;شرح الفقه الصغير&quot;,
                &quot;meta_description&quot;: &quot;Dolorem est doloremque cumque cumque dolorum nihil nulla.&quot;,
                &quot;sku&quot;: &quot;ZGQP0VXB&quot;,
                &quot;price&quot;: 57,
                &quot;formatted_price&quot;: &quot;57.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 57,
                &quot;formatted_final_price&quot;: &quot;57.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book3.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 125,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: true,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 0.7,
                &quot;viewed&quot;: 1616,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 1,
                &quot;brand&quot;: {
                    &quot;id&quot;: 1,
                    &quot;name&quot;: &quot;دار السلام&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book3.png&quot;,
                &quot;title&quot;: &quot;شرح الفقه الصغير&quot;,
                &quot;category_id&quot;: 5,
                &quot;category&quot;: &quot;التاريخ الإسلامي&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 57,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;ZGQP0VXB&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/90&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 91,
                &quot;name&quot;: &quot;مسند الميراث الكبير&quot;,
                &quot;description&quot;: &quot;Soluta tempora mollitia sint quia sunt quos corrupti. Odio aut iste dolor id quis quaerat quidem corrupti. Aut neque magnam quia necessitatibus nisi magnam. مسند الميراث الكبير&quot;,
                &quot;slug&quot;: &quot;msnd-almyrath-alkbyr-91&quot;,
                &quot;meta_title&quot;: &quot;مسند الميراث الكبير&quot;,
                &quot;meta_description&quot;: &quot;Nam sequi cum distinctio est voluptatem deserunt.&quot;,
                &quot;sku&quot;: &quot;VMXYLCGT&quot;,
                &quot;price&quot;: 458,
                &quot;formatted_price&quot;: &quot;458.00 ج.م&quot;,
                &quot;special_price&quot;: 366.4,
                &quot;formatted_special_price&quot;: &quot;366.40 ج.م&quot;,
                &quot;special_price_start&quot;: &quot;2026-02-09&quot;,
                &quot;special_price_end&quot;: &quot;2026-02-25&quot;,
                &quot;final_price&quot;: 366.4,
                &quot;formatted_final_price&quot;: &quot;366.40 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 91,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: false,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.77,
                &quot;viewed&quot;: 955,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 4,
                &quot;brand&quot;: {
                    &quot;id&quot;: 4,
                    &quot;name&quot;: &quot;دار المعرفة&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
                &quot;title&quot;: &quot;مسند الميراث الكبير&quot;,
                &quot;category_id&quot;: 2,
                &quot;category&quot;: &quot;القرآن الكريم&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 366.4,
                &quot;discount_percentage&quot;: 20,
                &quot;item_code&quot;: &quot;VMXYLCGT&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/91&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 92,
                &quot;name&quot;: &quot;صحيح الميراث الوافي&quot;,
                &quot;description&quot;: &quot;Quo porro vitae repellat optio. Voluptates labore est nihil in. Tempore aliquam libero dicta quasi. Et quidem repellat minima velit mollitia modi. صحيح الميراث الوافي&quot;,
                &quot;slug&quot;: &quot;shyh-almyrath-aloafy-92&quot;,
                &quot;meta_title&quot;: &quot;صحيح الميراث الوافي&quot;,
                &quot;meta_description&quot;: &quot;Et ipsa atque nisi esse natus et nemo.&quot;,
                &quot;sku&quot;: &quot;OEB92MF0&quot;,
                &quot;price&quot;: 171,
                &quot;formatted_price&quot;: &quot;171.00 ج.م&quot;,
                &quot;special_price&quot;: 136.8,
                &quot;formatted_special_price&quot;: &quot;136.80 ج.م&quot;,
                &quot;special_price_start&quot;: &quot;2026-02-09&quot;,
                &quot;special_price_end&quot;: &quot;2026-02-25&quot;,
                &quot;final_price&quot;: 136.8,
                &quot;formatted_final_price&quot;: &quot;136.80 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book1.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 70,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: false,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.91,
                &quot;viewed&quot;: 114,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 1,
                &quot;brand&quot;: {
                    &quot;id&quot;: 1,
                    &quot;name&quot;: &quot;دار السلام&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book1.png&quot;,
                &quot;title&quot;: &quot;صحيح الميراث الوافي&quot;,
                &quot;category_id&quot;: 3,
                &quot;category&quot;: &quot;الحديث الشريف&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 136.8,
                &quot;discount_percentage&quot;: 20,
                &quot;item_code&quot;: &quot;OEB92MF0&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/92&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 93,
                &quot;name&quot;: &quot;شرح الأذكار الشامل&quot;,
                &quot;description&quot;: &quot;Voluptatem ut veniam harum laborum modi possimus. Aspernatur debitis saepe nam rem animi non. Odit ratione sint amet voluptate doloribus. شرح الأذكار الشامل&quot;,
                &quot;slug&quot;: &quot;shrh-alathkar-alshaml-93&quot;,
                &quot;meta_title&quot;: &quot;شرح الأذكار الشامل&quot;,
                &quot;meta_description&quot;: &quot;Magni perspiciatis aut quia illo.&quot;,
                &quot;sku&quot;: &quot;QPZ07G5P&quot;,
                &quot;price&quot;: 116,
                &quot;formatted_price&quot;: &quot;116.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 116,
                &quot;formatted_final_price&quot;: &quot;116.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 61,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: false,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.4,
                &quot;viewed&quot;: 2605,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 6,
                &quot;brand&quot;: {
                    &quot;id&quot;: 6,
                    &quot;name&quot;: &quot;عصير الكتب&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;title&quot;: &quot;شرح الأذكار الشامل&quot;,
                &quot;category_id&quot;: 1,
                &quot;category&quot;: &quot;كتب إسلامية&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 116,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;QPZ07G5P&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/93&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 94,
                &quot;name&quot;: &quot;تهذيب مسلم الجامع&quot;,
                &quot;description&quot;: &quot;Dignissimos autem velit et sint velit. Error quis molestiae doloribus quisquam similique modi non. Aperiam ut sunt aut amet aperiam qui. تهذيب مسلم الجامع&quot;,
                &quot;slug&quot;: &quot;ththyb-mslm-algamaa-94&quot;,
                &quot;meta_title&quot;: &quot;تهذيب مسلم الجامع&quot;,
                &quot;meta_description&quot;: &quot;Sint delectus iure placeat provident beatae sint cum enim.&quot;,
                &quot;sku&quot;: &quot;CBWFGZ5O&quot;,
                &quot;price&quot;: 204,
                &quot;formatted_price&quot;: &quot;204.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 204,
                &quot;formatted_final_price&quot;: &quot;204.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book1.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 56,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: false,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.99,
                &quot;viewed&quot;: 2831,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 4,
                &quot;brand&quot;: {
                    &quot;id&quot;: 4,
                    &quot;name&quot;: &quot;دار المعرفة&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book1.png&quot;,
                &quot;title&quot;: &quot;تهذيب مسلم الجامع&quot;,
                &quot;category_id&quot;: 3,
                &quot;category&quot;: &quot;الحديث الشريف&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 204,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;CBWFGZ5O&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/94&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 95,
                &quot;name&quot;: &quot;متن السيرة النبوية الشامل&quot;,
                &quot;description&quot;: &quot;Ut perferendis eos hic. Officia cum quaerat possimus. متن السيرة النبوية الشامل&quot;,
                &quot;slug&quot;: &quot;mtn-alsyr-alnboy-alshaml-95&quot;,
                &quot;meta_title&quot;: &quot;متن السيرة النبوية الشامل&quot;,
                &quot;meta_description&quot;: &quot;Ipsam autem quae et velit et autem quia.&quot;,
                &quot;sku&quot;: &quot;J6NUBYTA&quot;,
                &quot;price&quot;: 455,
                &quot;formatted_price&quot;: &quot;455.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 455,
                &quot;formatted_final_price&quot;: &quot;455.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 167,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: false,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.65,
                &quot;viewed&quot;: 1731,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 1,
                &quot;brand&quot;: {
                    &quot;id&quot;: 1,
                    &quot;name&quot;: &quot;دار السلام&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;title&quot;: &quot;متن السيرة النبوية الشامل&quot;,
                &quot;category_id&quot;: 7,
                &quot;category&quot;: &quot;روايات عربية&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 455,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;J6NUBYTA&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/95&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            }
        ],
        &quot;partners&quot;: [
            {
                &quot;id&quot;: 1,
                &quot;name&quot;: &quot;دار السلام&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/brands.png&quot;,
                &quot;products_count&quot;: 11,
                &quot;title&quot;: &quot;دار السلام&quot;
            },
            {
                &quot;id&quot;: 2,
                &quot;name&quot;: &quot;دار ابن حزم&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/brands.png&quot;,
                &quot;products_count&quot;: 12,
                &quot;title&quot;: &quot;دار ابن حزم&quot;
            },
            {
                &quot;id&quot;: 3,
                &quot;name&quot;: &quot;مكتبة جرير&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/brands.png&quot;,
                &quot;products_count&quot;: 21,
                &quot;title&quot;: &quot;مكتبة جرير&quot;
            },
            {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;دار المعرفة&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/brands.png&quot;,
                &quot;products_count&quot;: 22,
                &quot;title&quot;: &quot;دار المعرفة&quot;
            },
            {
                &quot;id&quot;: 5,
                &quot;name&quot;: &quot;دار الشروق&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/brands.png&quot;,
                &quot;products_count&quot;: 18,
                &quot;title&quot;: &quot;دار الشروق&quot;
            },
            {
                &quot;id&quot;: 6,
                &quot;name&quot;: &quot;عصير الكتب&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/brands.png&quot;,
                &quot;products_count&quot;: 16,
                &quot;title&quot;: &quot;عصير الكتب&quot;
            }
        ],
        &quot;flash_sales&quot;: [],
        &quot;blogs&quot;: [
            {
                &quot;id&quot;: 7,
                &quot;title&quot;: &quot;نصائح القراءة - مقال رقم 1&quot;,
                &quot;description&quot;: &quot;&lt;p&gt;هذا نص تجريبي لمحتوى المقال. xAtfObqVwE1wfs9VrDBifXyMOqB0LjuwYLbBqXrYpeicnD5VSRs3oLfSNgTNYmncrLOeSikuVJsRk2Cu3m7RRz1OU0aQbC8xAMKW1lwW1b3dASBOussltBLWILKf2ur5kmkb31BGSvdzbbO6ZttpMxSV5SSRiQRE7X12RvdsAc1RZqRSLLANcbvWapxiF5VvivAD159p&lt;/p&gt;&lt;p&gt;ZAONhjWN4Uagmun0S0aP0BkSOHr6yIIcGdZldGfd5cJfihG7gZfCpcYyhy8mJGRfUQu69AP0bF6N8sXrnSi0ZFeaZjk3gsGXdcht10vDhmBkHOChARFYYxYkkoMXS5PcQJqzNsWv63lRbphD6AlaRT0sxS6S0pCrun1yksZ5ZRAzKq3CD2UvJ6Lm19jQeXcdRYxIy0vtWZAsUwwJYCXOxwv5N1sytQkic63VARbskmvmMsgQi0En384xKa1vtnCFfKvGX0TZhE6uVy9srEfVrgCyz8crKQA1JIF8eetm3EHH&lt;/p&gt;&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/news.jpg&quot;,
                &quot;slug&quot;: &quot;nsayh-alkraaa-mkal-rkm-1&quot;,
                &quot;tags&quot;: &quot;islamic,quran,mushaf&quot;,
                &quot;meta_title&quot;: &quot;&quot;,
                &quot;meta_description&quot;: &quot;&quot;,
                &quot;meta_keywords&quot;: &quot;&quot;,
                &quot;Author&quot;: &quot;Admin&quot;,
                &quot;created_at&quot;: &quot;2026-02-10&quot;
            },
            {
                &quot;id&quot;: 4,
                &quot;title&quot;: &quot;مقالات دينية - مقال رقم 1&quot;,
                &quot;description&quot;: &quot;&lt;p&gt;هذا نص تجريبي لمحتوى المقال. bMxDp04EXWHz3Qt7t9Kr9rholgeeFCqdyeYu7YoGKipmyIKIYOevJVAYEmndKscd4W83jgAIWEPipTT5EPK9OThP5Nf0qWZMaEs8N29kZav6dhuGFG1zcolHN2WkrkFd0ofMz279dtgNvV81zwTVOMyMFMQOwIP20DSkYG7gUDnuQzhiL6PL23kQUT0cjKrAcBC3mbOA&lt;/p&gt;&lt;p&gt;NOOBvou2JRvrWycGvyUQIKrtZxrP94NgUYNrUXtbjrAFkX5HcwAvQ6RyBnGwnoonqncMVeef1iUFsOYQniplDqCtslenKpQMwdR7qX7lF9SfNoKtIjybvDT1A3rb6PLskVbs8gSmfOmgnUOLzaO8TUvIQeClcVKSJMTI4jdT8TcXKVm58xzirGBYqvohRugyMNsfl7GPhnqXwghVZUVwwkLEAQkE4YmfFXRO4IhPvcVmuUBWP3CplpJYfyMLFHPzkANbRAm2qFHB4wVNpdzCFojmHzaeg4VnKYXk8c1GcAXF&lt;/p&gt;&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/news.jpg&quot;,
                &quot;slug&quot;: &quot;mkalat-dyny-mkal-rkm-1&quot;,
                &quot;tags&quot;: &quot;islamic,quran,mushaf&quot;,
                &quot;meta_title&quot;: &quot;&quot;,
                &quot;meta_description&quot;: &quot;&quot;,
                &quot;meta_keywords&quot;: &quot;&quot;,
                &quot;Author&quot;: &quot;Admin&quot;,
                &quot;created_at&quot;: &quot;2026-02-10&quot;
            },
            {
                &quot;id&quot;: 1,
                &quot;title&quot;: &quot;أخبار المصاحف - مقال رقم 1&quot;,
                &quot;description&quot;: &quot;&lt;p&gt;هذا نص تجريبي لمحتوى المقال. TnysJqZuWtV6LiekWRSjIXOVUw0lXrwPO6SglBnumrlefGCyueTwfEKUCkeX6jqu26ITlqsv7Dsl02e9K3Dqz2eolDWfnGcltZ5PtrAwS5FTZrL9SN8EFIyfGB3WSm2h9gN8jncgQquVZLrrLk82wiSmFUCN4VbNP1VDoLZrBt3Ixz4vd5WDBn5aUAMZhdSrgzghPSW6&lt;/p&gt;&lt;p&gt;7vfPJOYsqokNKfvP9BCibD9NoDq3jzeUSa9BkKQ2uwXMutv2ZADbQ5coYFZJQsT20zO3QxoDESa32d371cDm7P34iDStGOXUXQAZngeaYHhY5G9cldj8TcHlcJx2cbgIs7fIWQpupnsiWeWxXzqdoFbs09lnCCwJ5bFyVxUvend7CJ7BPOfz6DcdIENqny6yTacRVRNB3hWzNDnW9nfC7G9HDzixxB3mfcZI7OHTU9OOYfjaHQdUPPljTEMqHAr05xSCSQiWOdwgHce9zj71foINTv8ueFrGw9kYKTEyhQC2&lt;/p&gt;&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/news.jpg&quot;,
                &quot;slug&quot;: &quot;akhbar-almsahf-mkal-rkm-1&quot;,
                &quot;tags&quot;: &quot;islamic,quran,mushaf&quot;,
                &quot;meta_title&quot;: &quot;&quot;,
                &quot;meta_description&quot;: &quot;&quot;,
                &quot;meta_keywords&quot;: &quot;&quot;,
                &quot;Author&quot;: &quot;Admin&quot;,
                &quot;created_at&quot;: &quot;2026-02-10&quot;
            }
        ],
        &quot;slider&quot;: [
            {
                &quot;id&quot;: 1,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/sliders.jpg&quot;,
                &quot;link_type&quot;: null,
                &quot;link_id&quot;: null,
                &quot;title&quot;: &quot;مرحباً بكم في مصحف هوم&quot;,
                &quot;description&quot;: &quot;&quot;,
                &quot;category&quot;: null,
                &quot;sort_order&quot;: 0,
                &quot;link&quot;: &quot;&quot;,
                &quot;category_id&quot;: null,
                &quot;category_title&quot;: &quot;&quot;,
                &quot;type&quot;: &quot;category&quot;
            },
            {
                &quot;id&quot;: 2,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/sliders.jpg&quot;,
                &quot;link_type&quot;: null,
                &quot;link_id&quot;: null,
                &quot;title&quot;: &quot;جديد المصاحف&quot;,
                &quot;description&quot;: &quot;&quot;,
                &quot;category&quot;: null,
                &quot;sort_order&quot;: 1,
                &quot;link&quot;: &quot;&quot;,
                &quot;category_id&quot;: null,
                &quot;category_title&quot;: &quot;&quot;,
                &quot;type&quot;: &quot;category&quot;
            }
        ],
        &quot;offers&quot;: [],
        &quot;categories&quot;: [
            {
                &quot;id&quot;: 1,
                &quot;title&quot;: &quot;كتب إسلامية&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                &quot;products_count&quot;: 18,
                &quot;parent_id&quot;: null,
                &quot;sub_categories&quot;: [
                    {
                        &quot;id&quot;: 2,
                        &quot;title&quot;: &quot;القرآن الكريم&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 1,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 3,
                        &quot;title&quot;: &quot;الحديث الشريف&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 1,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 4,
                        &quot;title&quot;: &quot;الفقه والشريعة&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 1,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 5,
                        &quot;title&quot;: &quot;التاريخ الإسلامي&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 1,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;fixed&quot;: false
            },
            {
                &quot;id&quot;: 6,
                &quot;title&quot;: &quot;الأدب والروايات&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                &quot;products_count&quot;: 13,
                &quot;parent_id&quot;: null,
                &quot;sub_categories&quot;: [
                    {
                        &quot;id&quot;: 7,
                        &quot;title&quot;: &quot;روايات عربية&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 6,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 8,
                        &quot;title&quot;: &quot;أدب عالمي&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 6,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 9,
                        &quot;title&quot;: &quot;الشعر&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 6,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;fixed&quot;: false
            },
            {
                &quot;id&quot;: 10,
                &quot;title&quot;: &quot;كتب الأطفال&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                &quot;products_count&quot;: 16,
                &quot;parent_id&quot;: null,
                &quot;sub_categories&quot;: [
                    {
                        &quot;id&quot;: 11,
                        &quot;title&quot;: &quot;قصص تعليمية&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 10,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 12,
                        &quot;title&quot;: &quot;كتب أنشطة&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 10,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;fixed&quot;: false
            },
            {
                &quot;id&quot;: 13,
                &quot;title&quot;: &quot;تطوير الذات&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                &quot;products_count&quot;: 14,
                &quot;parent_id&quot;: null,
                &quot;sub_categories&quot;: [],
                &quot;fixed&quot;: false
            },
            {
                &quot;id&quot;: 14,
                &quot;title&quot;: &quot;العلوم والتكنولوجيا&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                &quot;products_count&quot;: 13,
                &quot;parent_id&quot;: null,
                &quot;sub_categories&quot;: [],
                &quot;fixed&quot;: false
            }
        ],
        &quot;brands&quot;: [
            {
                &quot;id&quot;: 1,
                &quot;name&quot;: &quot;دار السلام&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/brands.png&quot;,
                &quot;products_count&quot;: 11,
                &quot;title&quot;: &quot;دار السلام&quot;
            },
            {
                &quot;id&quot;: 2,
                &quot;name&quot;: &quot;دار ابن حزم&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/brands.png&quot;,
                &quot;products_count&quot;: 12,
                &quot;title&quot;: &quot;دار ابن حزم&quot;
            },
            {
                &quot;id&quot;: 3,
                &quot;name&quot;: &quot;مكتبة جرير&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/brands.png&quot;,
                &quot;products_count&quot;: 21,
                &quot;title&quot;: &quot;مكتبة جرير&quot;
            },
            {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;دار المعرفة&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/brands.png&quot;,
                &quot;products_count&quot;: 22,
                &quot;title&quot;: &quot;دار المعرفة&quot;
            },
            {
                &quot;id&quot;: 5,
                &quot;name&quot;: &quot;دار الشروق&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/brands.png&quot;,
                &quot;products_count&quot;: 18,
                &quot;title&quot;: &quot;دار الشروق&quot;
            },
            {
                &quot;id&quot;: 6,
                &quot;name&quot;: &quot;عصير الكتب&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/brands.png&quot;,
                &quot;products_count&quot;: 16,
                &quot;title&quot;: &quot;عصير الكتب&quot;
            }
        ],
        &quot;latestProducts&quot;: [
            {
                &quot;id&quot;: 88,
                &quot;name&quot;: &quot;تفسير مسلم الصغير&quot;,
                &quot;description&quot;: &quot;Nam possimus distinctio modi ab eum. Illum fugiat aperiam et deserunt. Culpa quia officiis dolor libero ut enim. تفسير مسلم الصغير&quot;,
                &quot;slug&quot;: &quot;tfsyr-mslm-alsghyr-88&quot;,
                &quot;meta_title&quot;: &quot;تفسير مسلم الصغير&quot;,
                &quot;meta_description&quot;: &quot;Nihil officia quia provident molestiae sit.&quot;,
                &quot;sku&quot;: &quot;6AQJWWVQ&quot;,
                &quot;price&quot;: 205,
                &quot;formatted_price&quot;: &quot;205.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 205,
                &quot;formatted_final_price&quot;: &quot;205.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 5,
                        &quot;title&quot;: &quot;التاريخ الإسلامي&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 1,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 6,
                        &quot;title&quot;: &quot;الأدب والروايات&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                        &quot;parent_id&quot;: null,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 9,
                        &quot;title&quot;: &quot;الشعر&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 6,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 181,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: false,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 0.95,
                &quot;viewed&quot;: 1451,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 5,
                &quot;brand&quot;: {
                    &quot;id&quot;: 5,
                    &quot;name&quot;: &quot;دار الشروق&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;title&quot;: &quot;تفسير مسلم الصغير&quot;,
                &quot;category_id&quot;: 5,
                &quot;category&quot;: &quot;التاريخ الإسلامي&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 205,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;6AQJWWVQ&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/88&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 89,
                &quot;name&quot;: &quot;شرح العقيدة الشامل&quot;,
                &quot;description&quot;: &quot;Totam possimus cumque tempora aliquid ut consequatur. Dolor sint iure cupiditate omnis adipisci repellat. Et facilis et asperiores ad sequi. شرح العقيدة الشامل&quot;,
                &quot;slug&quot;: &quot;shrh-alaakyd-alshaml-89&quot;,
                &quot;meta_title&quot;: &quot;شرح العقيدة الشامل&quot;,
                &quot;meta_description&quot;: &quot;Sequi totam tenetur accusamus cum.&quot;,
                &quot;sku&quot;: &quot;S00NWVM0&quot;,
                &quot;price&quot;: 419,
                &quot;formatted_price&quot;: &quot;419.00 ج.م&quot;,
                &quot;special_price&quot;: 335.2,
                &quot;formatted_special_price&quot;: &quot;335.20 ج.م&quot;,
                &quot;special_price_start&quot;: &quot;2026-02-09&quot;,
                &quot;special_price_end&quot;: &quot;2026-02-25&quot;,
                &quot;final_price&quot;: 335.2,
                &quot;formatted_final_price&quot;: &quot;335.20 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 12,
                        &quot;title&quot;: &quot;كتب أنشطة&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 10,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 143,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: false,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.11,
                &quot;viewed&quot;: 751,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 4,
                &quot;brand&quot;: {
                    &quot;id&quot;: 4,
                    &quot;name&quot;: &quot;دار المعرفة&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
                &quot;title&quot;: &quot;شرح العقيدة الشامل&quot;,
                &quot;category_id&quot;: 12,
                &quot;category&quot;: &quot;كتب أنشطة&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 335.2,
                &quot;discount_percentage&quot;: 20,
                &quot;item_code&quot;: &quot;S00NWVM0&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/89&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 90,
                &quot;name&quot;: &quot;شرح الفقه الصغير&quot;,
                &quot;description&quot;: &quot;Rerum ullam beatae dicta nemo repellat. Impedit quos sed porro vero. Rerum non officia veritatis exercitationem. Repellendus non repellat nihil voluptate laboriosam mollitia fugiat. Numquam quaerat qui et praesentium culpa. شرح الفقه الصغير&quot;,
                &quot;slug&quot;: &quot;shrh-alfkh-alsghyr-90&quot;,
                &quot;meta_title&quot;: &quot;شرح الفقه الصغير&quot;,
                &quot;meta_description&quot;: &quot;Dolorem est doloremque cumque cumque dolorum nihil nulla.&quot;,
                &quot;sku&quot;: &quot;ZGQP0VXB&quot;,
                &quot;price&quot;: 57,
                &quot;formatted_price&quot;: &quot;57.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 57,
                &quot;formatted_final_price&quot;: &quot;57.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book3.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 5,
                        &quot;title&quot;: &quot;التاريخ الإسلامي&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 1,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 11,
                        &quot;title&quot;: &quot;قصص تعليمية&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 10,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 12,
                        &quot;title&quot;: &quot;كتب أنشطة&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 10,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 125,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: true,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 0.7,
                &quot;viewed&quot;: 1616,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 1,
                &quot;brand&quot;: {
                    &quot;id&quot;: 1,
                    &quot;name&quot;: &quot;دار السلام&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book3.png&quot;,
                &quot;title&quot;: &quot;شرح الفقه الصغير&quot;,
                &quot;category_id&quot;: 5,
                &quot;category&quot;: &quot;التاريخ الإسلامي&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 57,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;ZGQP0VXB&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/90&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 91,
                &quot;name&quot;: &quot;مسند الميراث الكبير&quot;,
                &quot;description&quot;: &quot;Soluta tempora mollitia sint quia sunt quos corrupti. Odio aut iste dolor id quis quaerat quidem corrupti. Aut neque magnam quia necessitatibus nisi magnam. مسند الميراث الكبير&quot;,
                &quot;slug&quot;: &quot;msnd-almyrath-alkbyr-91&quot;,
                &quot;meta_title&quot;: &quot;مسند الميراث الكبير&quot;,
                &quot;meta_description&quot;: &quot;Nam sequi cum distinctio est voluptatem deserunt.&quot;,
                &quot;sku&quot;: &quot;VMXYLCGT&quot;,
                &quot;price&quot;: 458,
                &quot;formatted_price&quot;: &quot;458.00 ج.م&quot;,
                &quot;special_price&quot;: 366.4,
                &quot;formatted_special_price&quot;: &quot;366.40 ج.م&quot;,
                &quot;special_price_start&quot;: &quot;2026-02-09&quot;,
                &quot;special_price_end&quot;: &quot;2026-02-25&quot;,
                &quot;final_price&quot;: 366.4,
                &quot;formatted_final_price&quot;: &quot;366.40 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 2,
                        &quot;title&quot;: &quot;القرآن الكريم&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 1,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 9,
                        &quot;title&quot;: &quot;الشعر&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 6,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 91,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: false,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.77,
                &quot;viewed&quot;: 955,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 4,
                &quot;brand&quot;: {
                    &quot;id&quot;: 4,
                    &quot;name&quot;: &quot;دار المعرفة&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
                &quot;title&quot;: &quot;مسند الميراث الكبير&quot;,
                &quot;category_id&quot;: 2,
                &quot;category&quot;: &quot;القرآن الكريم&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 366.4,
                &quot;discount_percentage&quot;: 20,
                &quot;item_code&quot;: &quot;VMXYLCGT&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/91&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 92,
                &quot;name&quot;: &quot;صحيح الميراث الوافي&quot;,
                &quot;description&quot;: &quot;Quo porro vitae repellat optio. Voluptates labore est nihil in. Tempore aliquam libero dicta quasi. Et quidem repellat minima velit mollitia modi. صحيح الميراث الوافي&quot;,
                &quot;slug&quot;: &quot;shyh-almyrath-aloafy-92&quot;,
                &quot;meta_title&quot;: &quot;صحيح الميراث الوافي&quot;,
                &quot;meta_description&quot;: &quot;Et ipsa atque nisi esse natus et nemo.&quot;,
                &quot;sku&quot;: &quot;OEB92MF0&quot;,
                &quot;price&quot;: 171,
                &quot;formatted_price&quot;: &quot;171.00 ج.م&quot;,
                &quot;special_price&quot;: 136.8,
                &quot;formatted_special_price&quot;: &quot;136.80 ج.م&quot;,
                &quot;special_price_start&quot;: &quot;2026-02-09&quot;,
                &quot;special_price_end&quot;: &quot;2026-02-25&quot;,
                &quot;final_price&quot;: 136.8,
                &quot;formatted_final_price&quot;: &quot;136.80 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book1.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 3,
                        &quot;title&quot;: &quot;الحديث الشريف&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 1,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 4,
                        &quot;title&quot;: &quot;الفقه والشريعة&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 1,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 70,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: false,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.91,
                &quot;viewed&quot;: 114,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 1,
                &quot;brand&quot;: {
                    &quot;id&quot;: 1,
                    &quot;name&quot;: &quot;دار السلام&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book1.png&quot;,
                &quot;title&quot;: &quot;صحيح الميراث الوافي&quot;,
                &quot;category_id&quot;: 3,
                &quot;category&quot;: &quot;الحديث الشريف&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 136.8,
                &quot;discount_percentage&quot;: 20,
                &quot;item_code&quot;: &quot;OEB92MF0&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/92&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 93,
                &quot;name&quot;: &quot;شرح الأذكار الشامل&quot;,
                &quot;description&quot;: &quot;Voluptatem ut veniam harum laborum modi possimus. Aspernatur debitis saepe nam rem animi non. Odit ratione sint amet voluptate doloribus. شرح الأذكار الشامل&quot;,
                &quot;slug&quot;: &quot;shrh-alathkar-alshaml-93&quot;,
                &quot;meta_title&quot;: &quot;شرح الأذكار الشامل&quot;,
                &quot;meta_description&quot;: &quot;Magni perspiciatis aut quia illo.&quot;,
                &quot;sku&quot;: &quot;QPZ07G5P&quot;,
                &quot;price&quot;: 116,
                &quot;formatted_price&quot;: &quot;116.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 116,
                &quot;formatted_final_price&quot;: &quot;116.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;title&quot;: &quot;كتب إسلامية&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                        &quot;parent_id&quot;: null,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 10,
                        &quot;title&quot;: &quot;كتب الأطفال&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                        &quot;parent_id&quot;: null,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 61,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: false,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.4,
                &quot;viewed&quot;: 2605,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 6,
                &quot;brand&quot;: {
                    &quot;id&quot;: 6,
                    &quot;name&quot;: &quot;عصير الكتب&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;title&quot;: &quot;شرح الأذكار الشامل&quot;,
                &quot;category_id&quot;: 1,
                &quot;category&quot;: &quot;كتب إسلامية&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 116,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;QPZ07G5P&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/93&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 94,
                &quot;name&quot;: &quot;تهذيب مسلم الجامع&quot;,
                &quot;description&quot;: &quot;Dignissimos autem velit et sint velit. Error quis molestiae doloribus quisquam similique modi non. Aperiam ut sunt aut amet aperiam qui. تهذيب مسلم الجامع&quot;,
                &quot;slug&quot;: &quot;ththyb-mslm-algamaa-94&quot;,
                &quot;meta_title&quot;: &quot;تهذيب مسلم الجامع&quot;,
                &quot;meta_description&quot;: &quot;Sint delectus iure placeat provident beatae sint cum enim.&quot;,
                &quot;sku&quot;: &quot;CBWFGZ5O&quot;,
                &quot;price&quot;: 204,
                &quot;formatted_price&quot;: &quot;204.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 204,
                &quot;formatted_final_price&quot;: &quot;204.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book1.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 3,
                        &quot;title&quot;: &quot;الحديث الشريف&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 1,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 9,
                        &quot;title&quot;: &quot;الشعر&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 6,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 10,
                        &quot;title&quot;: &quot;كتب الأطفال&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                        &quot;parent_id&quot;: null,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 56,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: false,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.99,
                &quot;viewed&quot;: 2831,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 4,
                &quot;brand&quot;: {
                    &quot;id&quot;: 4,
                    &quot;name&quot;: &quot;دار المعرفة&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book1.png&quot;,
                &quot;title&quot;: &quot;تهذيب مسلم الجامع&quot;,
                &quot;category_id&quot;: 3,
                &quot;category&quot;: &quot;الحديث الشريف&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 204,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;CBWFGZ5O&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/94&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 95,
                &quot;name&quot;: &quot;متن السيرة النبوية الشامل&quot;,
                &quot;description&quot;: &quot;Ut perferendis eos hic. Officia cum quaerat possimus. متن السيرة النبوية الشامل&quot;,
                &quot;slug&quot;: &quot;mtn-alsyr-alnboy-alshaml-95&quot;,
                &quot;meta_title&quot;: &quot;متن السيرة النبوية الشامل&quot;,
                &quot;meta_description&quot;: &quot;Ipsam autem quae et velit et autem quia.&quot;,
                &quot;sku&quot;: &quot;J6NUBYTA&quot;,
                &quot;price&quot;: 455,
                &quot;formatted_price&quot;: &quot;455.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 455,
                &quot;formatted_final_price&quot;: &quot;455.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 7,
                        &quot;title&quot;: &quot;روايات عربية&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 6,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 167,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: false,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.65,
                &quot;viewed&quot;: 1731,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 1,
                &quot;brand&quot;: {
                    &quot;id&quot;: 1,
                    &quot;name&quot;: &quot;دار السلام&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;title&quot;: &quot;متن السيرة النبوية الشامل&quot;,
                &quot;category_id&quot;: 7,
                &quot;category&quot;: &quot;روايات عربية&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 455,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;J6NUBYTA&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/95&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            }
        ],
        &quot;topSeller&quot;: [
            {
                &quot;id&quot;: 1,
                &quot;name&quot;: &quot;شرح التجويد الجامع&quot;,
                &quot;description&quot;: &quot;Beatae necessitatibus beatae esse maiores suscipit cupiditate possimus. Nam minima ut sit aspernatur. Aut animi vitae corrupti exercitationem quibusdam. شرح التجويد الجامع&quot;,
                &quot;slug&quot;: &quot;shrh-altgoyd-algamaa-1&quot;,
                &quot;meta_title&quot;: &quot;شرح التجويد الجامع&quot;,
                &quot;meta_description&quot;: &quot;Praesentium magni maxime dolorem aliquam.&quot;,
                &quot;sku&quot;: &quot;GDGLP7MS&quot;,
                &quot;price&quot;: 64,
                &quot;formatted_price&quot;: &quot;64.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 64,
                &quot;formatted_final_price&quot;: &quot;64.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 3,
                        &quot;title&quot;: &quot;الحديث الشريف&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 1,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 7,
                        &quot;title&quot;: &quot;روايات عربية&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 6,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 9,
                        &quot;title&quot;: &quot;الشعر&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 6,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 102,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: true,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.57,
                &quot;viewed&quot;: 208,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 6,
                &quot;brand&quot;: {
                    &quot;id&quot;: 6,
                    &quot;name&quot;: &quot;عصير الكتب&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
                &quot;title&quot;: &quot;شرح التجويد الجامع&quot;,
                &quot;category_id&quot;: 3,
                &quot;category&quot;: &quot;الحديث الشريف&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 64,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;GDGLP7MS&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/1&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 7,
                &quot;name&quot;: &quot;تهذيب العقيدة الصغير&quot;,
                &quot;description&quot;: &quot;Ab itaque non at quidem. Ducimus sed qui ullam laboriosam modi doloribus. Veniam quaerat rerum recusandae eos. تهذيب العقيدة الصغير&quot;,
                &quot;slug&quot;: &quot;ththyb-alaakyd-alsghyr-7&quot;,
                &quot;meta_title&quot;: &quot;تهذيب العقيدة الصغير&quot;,
                &quot;meta_description&quot;: &quot;Temporibus quae non inventore doloribus labore et sint.&quot;,
                &quot;sku&quot;: &quot;PQBPEXBI&quot;,
                &quot;price&quot;: 228,
                &quot;formatted_price&quot;: &quot;228.00 ج.م&quot;,
                &quot;special_price&quot;: 182.4,
                &quot;formatted_special_price&quot;: &quot;182.40 ج.م&quot;,
                &quot;special_price_start&quot;: &quot;2026-02-09&quot;,
                &quot;special_price_end&quot;: &quot;2026-02-25&quot;,
                &quot;final_price&quot;: 182.4,
                &quot;formatted_final_price&quot;: &quot;182.40 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book2.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 4,
                        &quot;title&quot;: &quot;الفقه والشريعة&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 1,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 8,
                        &quot;title&quot;: &quot;أدب عالمي&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 6,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 191,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: true,
                &quot;best_seller_start&quot;: &quot;2026-02-10&quot;,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.02,
                &quot;viewed&quot;: 1571,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 6,
                &quot;brand&quot;: {
                    &quot;id&quot;: 6,
                    &quot;name&quot;: &quot;عصير الكتب&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book2.png&quot;,
                &quot;title&quot;: &quot;تهذيب العقيدة الصغير&quot;,
                &quot;category_id&quot;: 4,
                &quot;category&quot;: &quot;الفقه والشريعة&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 182.4,
                &quot;discount_percentage&quot;: 20,
                &quot;item_code&quot;: &quot;PQBPEXBI&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/7&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 9,
                &quot;name&quot;: &quot;مختصر التجويد الوجيز&quot;,
                &quot;description&quot;: &quot;Quam temporibus dolores ipsum. Quas rerum aperiam maiores sunt fugit. مختصر التجويد الوجيز&quot;,
                &quot;slug&quot;: &quot;mkhtsr-altgoyd-alogyz-9&quot;,
                &quot;meta_title&quot;: &quot;مختصر التجويد الوجيز&quot;,
                &quot;meta_description&quot;: &quot;Odio quo est sed est eius.&quot;,
                &quot;sku&quot;: &quot;P3A8QWON&quot;,
                &quot;price&quot;: 238,
                &quot;formatted_price&quot;: &quot;238.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 238,
                &quot;formatted_final_price&quot;: &quot;238.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;title&quot;: &quot;كتب إسلامية&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                        &quot;parent_id&quot;: null,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 3,
                        &quot;title&quot;: &quot;الحديث الشريف&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 1,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 6,
                        &quot;title&quot;: &quot;الأدب والروايات&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                        &quot;parent_id&quot;: null,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 169,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: true,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.37,
                &quot;viewed&quot;: 4543,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 3,
                &quot;brand&quot;: {
                    &quot;id&quot;: 3,
                    &quot;name&quot;: &quot;مكتبة جرير&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;title&quot;: &quot;مختصر التجويد الوجيز&quot;,
                &quot;category_id&quot;: 1,
                &quot;category&quot;: &quot;كتب إسلامية&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 238,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;P3A8QWON&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/9&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 14,
                &quot;name&quot;: &quot;تاريخ الحديث الصغير&quot;,
                &quot;description&quot;: &quot;Ducimus dolore sunt soluta vero. Temporibus eveniet aut est sint iure. Nihil sunt cumque tempore doloribus rerum et iusto eius. تاريخ الحديث الصغير&quot;,
                &quot;slug&quot;: &quot;tarykh-alhdyth-alsghyr-14&quot;,
                &quot;meta_title&quot;: &quot;تاريخ الحديث الصغير&quot;,
                &quot;meta_description&quot;: &quot;Nulla dolorum qui qui est.&quot;,
                &quot;sku&quot;: &quot;GBD8XHBG&quot;,
                &quot;price&quot;: 309,
                &quot;formatted_price&quot;: &quot;309.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 309,
                &quot;formatted_final_price&quot;: &quot;309.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 14,
                        &quot;title&quot;: &quot;العلوم والتكنولوجيا&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                        &quot;parent_id&quot;: null,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 90,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: true,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 0.62,
                &quot;viewed&quot;: 98,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 1,
                &quot;brand&quot;: {
                    &quot;id&quot;: 1,
                    &quot;name&quot;: &quot;دار السلام&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;title&quot;: &quot;تاريخ الحديث الصغير&quot;,
                &quot;category_id&quot;: 14,
                &quot;category&quot;: &quot;العلوم والتكنولوجيا&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 309,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;GBD8XHBG&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/14&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 28,
                &quot;name&quot;: &quot;شرح التجويد الكبير&quot;,
                &quot;description&quot;: &quot;Et delectus et iste maiores ut. Est dolor aspernatur rerum rem asperiores. Velit eius qui eligendi dicta et voluptatem. Deleniti dignissimos dignissimos sit dolore non id. شرح التجويد الكبير&quot;,
                &quot;slug&quot;: &quot;shrh-altgoyd-alkbyr-28&quot;,
                &quot;meta_title&quot;: &quot;شرح التجويد الكبير&quot;,
                &quot;meta_description&quot;: &quot;Dicta et fugiat eum velit totam quia et.&quot;,
                &quot;sku&quot;: &quot;YOO3UOP2&quot;,
                &quot;price&quot;: 341,
                &quot;formatted_price&quot;: &quot;341.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 341,
                &quot;formatted_final_price&quot;: &quot;341.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 11,
                        &quot;title&quot;: &quot;قصص تعليمية&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 10,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 12,
                        &quot;title&quot;: &quot;كتب أنشطة&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 10,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 87,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: true,
                &quot;best_seller_start&quot;: &quot;2026-02-10&quot;,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.83,
                &quot;viewed&quot;: 2850,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 2,
                &quot;brand&quot;: {
                    &quot;id&quot;: 2,
                    &quot;name&quot;: &quot;دار ابن حزم&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;title&quot;: &quot;شرح التجويد الكبير&quot;,
                &quot;category_id&quot;: 11,
                &quot;category&quot;: &quot;قصص تعليمية&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 341,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;YOO3UOP2&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/28&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 30,
                &quot;name&quot;: &quot;تهذيب الحديث الكبير&quot;,
                &quot;description&quot;: &quot;Voluptatem vel labore qui facere praesentium sapiente. Id id pariatur eveniet reiciendis sed odit. Illo doloribus accusantium perspiciatis quaerat veniam facilis. تهذيب الحديث الكبير&quot;,
                &quot;slug&quot;: &quot;ththyb-alhdyth-alkbyr-30&quot;,
                &quot;meta_title&quot;: &quot;تهذيب الحديث الكبير&quot;,
                &quot;meta_description&quot;: &quot;Omnis modi rerum voluptatem suscipit ad nihil.&quot;,
                &quot;sku&quot;: &quot;B7KMIBXN&quot;,
                &quot;price&quot;: 172,
                &quot;formatted_price&quot;: &quot;172.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 172,
                &quot;formatted_final_price&quot;: &quot;172.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 8,
                        &quot;title&quot;: &quot;أدب عالمي&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 6,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 12,
                        &quot;title&quot;: &quot;كتب أنشطة&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 10,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 173,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: true,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.97,
                &quot;viewed&quot;: 2037,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 5,
                &quot;brand&quot;: {
                    &quot;id&quot;: 5,
                    &quot;name&quot;: &quot;دار الشروق&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
                &quot;title&quot;: &quot;تهذيب الحديث الكبير&quot;,
                &quot;category_id&quot;: 8,
                &quot;category&quot;: &quot;أدب عالمي&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 172,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;B7KMIBXN&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/30&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 43,
                &quot;name&quot;: &quot;حاشية الفقه الوافي&quot;,
                &quot;description&quot;: &quot;Porro velit tempora beatae facere. Velit quos qui facilis aut. Voluptas quo eveniet inventore incidunt. Nulla magni laborum sunt. حاشية الفقه الوافي&quot;,
                &quot;slug&quot;: &quot;hashy-alfkh-aloafy-43&quot;,
                &quot;meta_title&quot;: &quot;حاشية الفقه الوافي&quot;,
                &quot;meta_description&quot;: &quot;Quos et et ut suscipit iste.&quot;,
                &quot;sku&quot;: &quot;Y3KECNJJ&quot;,
                &quot;price&quot;: 58,
                &quot;formatted_price&quot;: &quot;58.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 58,
                &quot;formatted_final_price&quot;: &quot;58.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 4,
                        &quot;title&quot;: &quot;الفقه والشريعة&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 1,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 10,
                        &quot;title&quot;: &quot;كتب الأطفال&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                        &quot;parent_id&quot;: null,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 13,
                        &quot;title&quot;: &quot;تطوير الذات&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                        &quot;parent_id&quot;: null,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 72,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: true,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.99,
                &quot;viewed&quot;: 3241,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 3,
                &quot;brand&quot;: {
                    &quot;id&quot;: 3,
                    &quot;name&quot;: &quot;مكتبة جرير&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;title&quot;: &quot;حاشية الفقه الوافي&quot;,
                &quot;category_id&quot;: 4,
                &quot;category&quot;: &quot;الفقه والشريعة&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 58,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;Y3KECNJJ&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/43&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 47,
                &quot;name&quot;: &quot;شرح الأذكار الميسر&quot;,
                &quot;description&quot;: &quot;Dolor odit accusamus omnis minus minima rerum consequuntur velit. Commodi veritatis quis maiores quo. Aut ut aut ut eum quod. Iste omnis eos eaque optio. شرح الأذكار الميسر&quot;,
                &quot;slug&quot;: &quot;shrh-alathkar-almysr-47&quot;,
                &quot;meta_title&quot;: &quot;شرح الأذكار الميسر&quot;,
                &quot;meta_description&quot;: &quot;Dicta ab et excepturi voluptate.&quot;,
                &quot;sku&quot;: &quot;Y0CQYJUU&quot;,
                &quot;price&quot;: 416,
                &quot;formatted_price&quot;: &quot;416.00 ج.م&quot;,
                &quot;special_price&quot;: 332.8,
                &quot;formatted_special_price&quot;: &quot;332.80 ج.م&quot;,
                &quot;special_price_start&quot;: &quot;2026-02-09&quot;,
                &quot;special_price_end&quot;: &quot;2026-02-25&quot;,
                &quot;final_price&quot;: 332.8,
                &quot;formatted_final_price&quot;: &quot;332.80 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book3.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 7,
                        &quot;title&quot;: &quot;روايات عربية&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 6,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 13,
                        &quot;title&quot;: &quot;تطوير الذات&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                        &quot;parent_id&quot;: null,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 48,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: true,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 0.9,
                &quot;viewed&quot;: 2872,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 3,
                &quot;brand&quot;: {
                    &quot;id&quot;: 3,
                    &quot;name&quot;: &quot;مكتبة جرير&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book3.png&quot;,
                &quot;title&quot;: &quot;شرح الأذكار الميسر&quot;,
                &quot;category_id&quot;: 7,
                &quot;category&quot;: &quot;روايات عربية&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 332.8,
                &quot;discount_percentage&quot;: 20,
                &quot;item_code&quot;: &quot;Y0CQYJUU&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/47&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            }
        ],
        &quot;flashdeals&quot;: [],
        &quot;mostviewedProducts&quot;: [
            {
                &quot;id&quot;: 1,
                &quot;name&quot;: &quot;شرح التجويد الجامع&quot;,
                &quot;description&quot;: &quot;Beatae necessitatibus beatae esse maiores suscipit cupiditate possimus. Nam minima ut sit aspernatur. Aut animi vitae corrupti exercitationem quibusdam. شرح التجويد الجامع&quot;,
                &quot;slug&quot;: &quot;shrh-altgoyd-algamaa-1&quot;,
                &quot;meta_title&quot;: &quot;شرح التجويد الجامع&quot;,
                &quot;meta_description&quot;: &quot;Praesentium magni maxime dolorem aliquam.&quot;,
                &quot;sku&quot;: &quot;GDGLP7MS&quot;,
                &quot;price&quot;: 64,
                &quot;formatted_price&quot;: &quot;64.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 64,
                &quot;formatted_final_price&quot;: &quot;64.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 3,
                        &quot;title&quot;: &quot;الحديث الشريف&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 1,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 7,
                        &quot;title&quot;: &quot;روايات عربية&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 6,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 9,
                        &quot;title&quot;: &quot;الشعر&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 6,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 102,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: true,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.57,
                &quot;viewed&quot;: 208,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 6,
                &quot;brand&quot;: {
                    &quot;id&quot;: 6,
                    &quot;name&quot;: &quot;عصير الكتب&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
                &quot;title&quot;: &quot;شرح التجويد الجامع&quot;,
                &quot;category_id&quot;: 3,
                &quot;category&quot;: &quot;الحديث الشريف&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 64,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;GDGLP7MS&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/1&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 7,
                &quot;name&quot;: &quot;تهذيب العقيدة الصغير&quot;,
                &quot;description&quot;: &quot;Ab itaque non at quidem. Ducimus sed qui ullam laboriosam modi doloribus. Veniam quaerat rerum recusandae eos. تهذيب العقيدة الصغير&quot;,
                &quot;slug&quot;: &quot;ththyb-alaakyd-alsghyr-7&quot;,
                &quot;meta_title&quot;: &quot;تهذيب العقيدة الصغير&quot;,
                &quot;meta_description&quot;: &quot;Temporibus quae non inventore doloribus labore et sint.&quot;,
                &quot;sku&quot;: &quot;PQBPEXBI&quot;,
                &quot;price&quot;: 228,
                &quot;formatted_price&quot;: &quot;228.00 ج.م&quot;,
                &quot;special_price&quot;: 182.4,
                &quot;formatted_special_price&quot;: &quot;182.40 ج.م&quot;,
                &quot;special_price_start&quot;: &quot;2026-02-09&quot;,
                &quot;special_price_end&quot;: &quot;2026-02-25&quot;,
                &quot;final_price&quot;: 182.4,
                &quot;formatted_final_price&quot;: &quot;182.40 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book2.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 4,
                        &quot;title&quot;: &quot;الفقه والشريعة&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 1,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 8,
                        &quot;title&quot;: &quot;أدب عالمي&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 6,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 191,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: true,
                &quot;best_seller_start&quot;: &quot;2026-02-10&quot;,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.02,
                &quot;viewed&quot;: 1571,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 6,
                &quot;brand&quot;: {
                    &quot;id&quot;: 6,
                    &quot;name&quot;: &quot;عصير الكتب&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book2.png&quot;,
                &quot;title&quot;: &quot;تهذيب العقيدة الصغير&quot;,
                &quot;category_id&quot;: 4,
                &quot;category&quot;: &quot;الفقه والشريعة&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 182.4,
                &quot;discount_percentage&quot;: 20,
                &quot;item_code&quot;: &quot;PQBPEXBI&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/7&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 9,
                &quot;name&quot;: &quot;مختصر التجويد الوجيز&quot;,
                &quot;description&quot;: &quot;Quam temporibus dolores ipsum. Quas rerum aperiam maiores sunt fugit. مختصر التجويد الوجيز&quot;,
                &quot;slug&quot;: &quot;mkhtsr-altgoyd-alogyz-9&quot;,
                &quot;meta_title&quot;: &quot;مختصر التجويد الوجيز&quot;,
                &quot;meta_description&quot;: &quot;Odio quo est sed est eius.&quot;,
                &quot;sku&quot;: &quot;P3A8QWON&quot;,
                &quot;price&quot;: 238,
                &quot;formatted_price&quot;: &quot;238.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 238,
                &quot;formatted_final_price&quot;: &quot;238.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;title&quot;: &quot;كتب إسلامية&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                        &quot;parent_id&quot;: null,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 3,
                        &quot;title&quot;: &quot;الحديث الشريف&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 1,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 6,
                        &quot;title&quot;: &quot;الأدب والروايات&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                        &quot;parent_id&quot;: null,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 169,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: true,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.37,
                &quot;viewed&quot;: 4543,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 3,
                &quot;brand&quot;: {
                    &quot;id&quot;: 3,
                    &quot;name&quot;: &quot;مكتبة جرير&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;title&quot;: &quot;مختصر التجويد الوجيز&quot;,
                &quot;category_id&quot;: 1,
                &quot;category&quot;: &quot;كتب إسلامية&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 238,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;P3A8QWON&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/9&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 14,
                &quot;name&quot;: &quot;تاريخ الحديث الصغير&quot;,
                &quot;description&quot;: &quot;Ducimus dolore sunt soluta vero. Temporibus eveniet aut est sint iure. Nihil sunt cumque tempore doloribus rerum et iusto eius. تاريخ الحديث الصغير&quot;,
                &quot;slug&quot;: &quot;tarykh-alhdyth-alsghyr-14&quot;,
                &quot;meta_title&quot;: &quot;تاريخ الحديث الصغير&quot;,
                &quot;meta_description&quot;: &quot;Nulla dolorum qui qui est.&quot;,
                &quot;sku&quot;: &quot;GBD8XHBG&quot;,
                &quot;price&quot;: 309,
                &quot;formatted_price&quot;: &quot;309.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 309,
                &quot;formatted_final_price&quot;: &quot;309.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 14,
                        &quot;title&quot;: &quot;العلوم والتكنولوجيا&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                        &quot;parent_id&quot;: null,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 90,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: true,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 0.62,
                &quot;viewed&quot;: 98,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 1,
                &quot;brand&quot;: {
                    &quot;id&quot;: 1,
                    &quot;name&quot;: &quot;دار السلام&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;title&quot;: &quot;تاريخ الحديث الصغير&quot;,
                &quot;category_id&quot;: 14,
                &quot;category&quot;: &quot;العلوم والتكنولوجيا&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 309,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;GBD8XHBG&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/14&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 28,
                &quot;name&quot;: &quot;شرح التجويد الكبير&quot;,
                &quot;description&quot;: &quot;Et delectus et iste maiores ut. Est dolor aspernatur rerum rem asperiores. Velit eius qui eligendi dicta et voluptatem. Deleniti dignissimos dignissimos sit dolore non id. شرح التجويد الكبير&quot;,
                &quot;slug&quot;: &quot;shrh-altgoyd-alkbyr-28&quot;,
                &quot;meta_title&quot;: &quot;شرح التجويد الكبير&quot;,
                &quot;meta_description&quot;: &quot;Dicta et fugiat eum velit totam quia et.&quot;,
                &quot;sku&quot;: &quot;YOO3UOP2&quot;,
                &quot;price&quot;: 341,
                &quot;formatted_price&quot;: &quot;341.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 341,
                &quot;formatted_final_price&quot;: &quot;341.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 11,
                        &quot;title&quot;: &quot;قصص تعليمية&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 10,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 12,
                        &quot;title&quot;: &quot;كتب أنشطة&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 10,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 87,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: true,
                &quot;best_seller_start&quot;: &quot;2026-02-10&quot;,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.83,
                &quot;viewed&quot;: 2850,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 2,
                &quot;brand&quot;: {
                    &quot;id&quot;: 2,
                    &quot;name&quot;: &quot;دار ابن حزم&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;title&quot;: &quot;شرح التجويد الكبير&quot;,
                &quot;category_id&quot;: 11,
                &quot;category&quot;: &quot;قصص تعليمية&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 341,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;YOO3UOP2&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/28&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 30,
                &quot;name&quot;: &quot;تهذيب الحديث الكبير&quot;,
                &quot;description&quot;: &quot;Voluptatem vel labore qui facere praesentium sapiente. Id id pariatur eveniet reiciendis sed odit. Illo doloribus accusantium perspiciatis quaerat veniam facilis. تهذيب الحديث الكبير&quot;,
                &quot;slug&quot;: &quot;ththyb-alhdyth-alkbyr-30&quot;,
                &quot;meta_title&quot;: &quot;تهذيب الحديث الكبير&quot;,
                &quot;meta_description&quot;: &quot;Omnis modi rerum voluptatem suscipit ad nihil.&quot;,
                &quot;sku&quot;: &quot;B7KMIBXN&quot;,
                &quot;price&quot;: 172,
                &quot;formatted_price&quot;: &quot;172.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 172,
                &quot;formatted_final_price&quot;: &quot;172.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 8,
                        &quot;title&quot;: &quot;أدب عالمي&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 6,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 12,
                        &quot;title&quot;: &quot;كتب أنشطة&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 10,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 173,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: true,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.97,
                &quot;viewed&quot;: 2037,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 5,
                &quot;brand&quot;: {
                    &quot;id&quot;: 5,
                    &quot;name&quot;: &quot;دار الشروق&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
                &quot;title&quot;: &quot;تهذيب الحديث الكبير&quot;,
                &quot;category_id&quot;: 8,
                &quot;category&quot;: &quot;أدب عالمي&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 172,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;B7KMIBXN&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/30&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 43,
                &quot;name&quot;: &quot;حاشية الفقه الوافي&quot;,
                &quot;description&quot;: &quot;Porro velit tempora beatae facere. Velit quos qui facilis aut. Voluptas quo eveniet inventore incidunt. Nulla magni laborum sunt. حاشية الفقه الوافي&quot;,
                &quot;slug&quot;: &quot;hashy-alfkh-aloafy-43&quot;,
                &quot;meta_title&quot;: &quot;حاشية الفقه الوافي&quot;,
                &quot;meta_description&quot;: &quot;Quos et et ut suscipit iste.&quot;,
                &quot;sku&quot;: &quot;Y3KECNJJ&quot;,
                &quot;price&quot;: 58,
                &quot;formatted_price&quot;: &quot;58.00 ج.م&quot;,
                &quot;special_price&quot;: 0,
                &quot;formatted_special_price&quot;: null,
                &quot;special_price_start&quot;: null,
                &quot;special_price_end&quot;: null,
                &quot;final_price&quot;: 58,
                &quot;formatted_final_price&quot;: &quot;58.00 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 4,
                        &quot;title&quot;: &quot;الفقه والشريعة&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 1,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 10,
                        &quot;title&quot;: &quot;كتب الأطفال&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                        &quot;parent_id&quot;: null,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 13,
                        &quot;title&quot;: &quot;تطوير الذات&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                        &quot;parent_id&quot;: null,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 72,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: true,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 1.99,
                &quot;viewed&quot;: 3241,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 3,
                &quot;brand&quot;: {
                    &quot;id&quot;: 3,
                    &quot;name&quot;: &quot;مكتبة جرير&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
                &quot;title&quot;: &quot;حاشية الفقه الوافي&quot;,
                &quot;category_id&quot;: 4,
                &quot;category&quot;: &quot;الفقه والشريعة&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 58,
                &quot;discount_percentage&quot;: 0,
                &quot;item_code&quot;: &quot;Y3KECNJJ&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/43&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            },
            {
                &quot;id&quot;: 47,
                &quot;name&quot;: &quot;شرح الأذكار الميسر&quot;,
                &quot;description&quot;: &quot;Dolor odit accusamus omnis minus minima rerum consequuntur velit. Commodi veritatis quis maiores quo. Aut ut aut ut eum quod. Iste omnis eos eaque optio. شرح الأذكار الميسر&quot;,
                &quot;slug&quot;: &quot;shrh-alathkar-almysr-47&quot;,
                &quot;meta_title&quot;: &quot;شرح الأذكار الميسر&quot;,
                &quot;meta_description&quot;: &quot;Dicta ab et excepturi voluptate.&quot;,
                &quot;sku&quot;: &quot;Y0CQYJUU&quot;,
                &quot;price&quot;: 416,
                &quot;formatted_price&quot;: &quot;416.00 ج.م&quot;,
                &quot;special_price&quot;: 332.8,
                &quot;formatted_special_price&quot;: &quot;332.80 ج.م&quot;,
                &quot;special_price_start&quot;: &quot;2026-02-09&quot;,
                &quot;special_price_end&quot;: &quot;2026-02-25&quot;,
                &quot;final_price&quot;: 332.8,
                &quot;formatted_final_price&quot;: &quot;332.80 ج.م&quot;,
                &quot;currency&quot;: {
                    &quot;code&quot;: &quot;EGP&quot;,
                    &quot;symbol&quot;: &quot;ج.م&quot;,
                    &quot;exchange_rate&quot;: 1
                },
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book3.png&quot;,
                &quot;gallery&quot;: [],
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 7,
                        &quot;title&quot;: &quot;روايات عربية&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                        &quot;parent_id&quot;: 6,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    },
                    {
                        &quot;id&quot;: 13,
                        &quot;title&quot;: &quot;تطوير الذات&quot;,
                        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                        &quot;parent_id&quot;: null,
                        &quot;sub_categories&quot;: [],
                        &quot;fixed&quot;: false
                    }
                ],
                &quot;options&quot;: [],
                &quot;quantity&quot;: 48,
                &quot;max_order_qty&quot;: 10,
                &quot;ignore_quantity&quot;: false,
                &quot;is_best_seller&quot;: true,
                &quot;best_seller_start&quot;: null,
                &quot;best_seller_end&quot;: null,
                &quot;weight&quot;: 0.9,
                &quot;viewed&quot;: 2872,
                &quot;shipping_rule_id&quot;: 1,
                &quot;product_brand_id&quot;: 3,
                &quot;brand&quot;: {
                    &quot;id&quot;: 3,
                    &quot;name&quot;: &quot;مكتبة جرير&quot;
                },
                &quot;has_flash_sale&quot;: false,
                &quot;flash_sale_price&quot;: null,
                &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book3.png&quot;,
                &quot;title&quot;: &quot;شرح الأذكار الميسر&quot;,
                &quot;category_id&quot;: 7,
                &quot;category&quot;: &quot;روايات عربية&quot;,
                &quot;store_name&quot;: &quot;Mushaf Home&quot;,
                &quot;rating&quot;: 0,
                &quot;rate_count&quot;: 0,
                &quot;sale_price&quot;: 332.8,
                &quot;discount_percentage&quot;: 20,
                &quot;item_code&quot;: &quot;Y0CQYJUU&quot;,
                &quot;images&quot;: [],
                &quot;isFavorite&quot;: false,
                &quot;countFavorite&quot;: 0,
                &quot;countOrder&quot;: 0,
                &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/47&quot;,
                &quot;product_rates&quot;: [],
                &quot;deal_of_day_end&quot;: null
            }
        ]
    },
    &quot;error&quot;: null,
    &quot;code&quot;: &quot;200&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-home" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-home"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-home"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-home" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-home">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-home" data-method="GET"
      data-path="api/v1/home"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-home', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-home"
                    onclick="tryItOut('GETapi-v1-home');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-home"
                    onclick="cancelTryOut('GETapi-v1-home');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-home"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/home</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-home"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-home"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-v1-flash-sales">Get Flash Sales</h2>

<p>
</p>

<p>Returns a list of current and upcoming flash sales.</p>

<span id="example-requests-GETapi-v1-flash-sales">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/flash-sales" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/flash-sales"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-flash-sales">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 58
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;تمت العملية بنجاح&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 2,
            &quot;name&quot;: &quot;عروض عيد الفطر&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/flash2.jpg&quot;,
            &quot;start_at&quot;: &quot;2026-02-20T11:00:09.000000Z&quot;,
            &quot;end_at&quot;: &quot;2026-02-25T11:00:09.000000Z&quot;,
            &quot;is_active&quot;: true,
            &quot;products_count&quot;: 0,
            &quot;products&quot;: [],
            &quot;title&quot;: &quot;عروض عيد الفطر&quot;,
            &quot;start_date&quot;: &quot;2026-02-20T11:00:09.000000Z&quot;,
            &quot;end_date&quot;: &quot;2026-02-25T11:00:09.000000Z&quot;,
            &quot;status&quot;: 1,
            &quot;featured&quot;: 1
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-flash-sales" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-flash-sales"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-flash-sales"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-flash-sales" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-flash-sales">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-flash-sales" data-method="GET"
      data-path="api/v1/flash-sales"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-flash-sales', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-flash-sales"
                    onclick="tryItOut('GETapi-v1-flash-sales');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-flash-sales"
                    onclick="cancelTryOut('GETapi-v1-flash-sales');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-flash-sales"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/flash-sales</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-flash-sales"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-flash-sales"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-v1-pages">GET api/v1/pages</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-pages">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/pages" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/pages"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-pages">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 47
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;slug&quot;: null,
            &quot;title&quot;: &quot;من نحن&quot;,
            &quot;content&quot;: &quot;&lt;p&gt;مرحبًا بكم في مكتبتنا. نحن نقدم مجموعة واسعة من الكتب لجميع الأعمار.&lt;/p&gt;&quot;,
            &quot;translations&quot;: [
                {
                    &quot;locale&quot;: &quot;ar&quot;,
                    &quot;title&quot;: &quot;من نحن&quot;,
                    &quot;content&quot;: &quot;&lt;p&gt;مرحبًا بكم في مكتبتنا. نحن نقدم مجموعة واسعة من الكتب لجميع الأعمار.&lt;/p&gt;&quot;,
                    &quot;meta_title&quot;: &quot;من نحن - المكتبة&quot;,
                    &quot;meta_description&quot;: &quot;تعرف على المزيد حول رسالتنا وقيمنا.&quot;
                },
                {
                    &quot;locale&quot;: &quot;en&quot;,
                    &quot;title&quot;: &quot;About Us&quot;,
                    &quot;content&quot;: &quot;&lt;p&gt;Welcome to our bookstore. We offer a wide range of books for all ages.&lt;/p&gt;&quot;,
                    &quot;meta_title&quot;: &quot;About Us - Bookstore&quot;,
                    &quot;meta_description&quot;: &quot;Learn more about our mission and values.&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 2,
            &quot;slug&quot;: null,
            &quot;title&quot;: &quot;سياسة الخصوصية&quot;,
            &quot;content&quot;: &quot;&lt;p&gt;خصوصيتك مهمة بالنسبة لنا. تشرح هذه السياسة كيفية تعاملنا مع بياناتك.&lt;/p&gt;&quot;,
            &quot;translations&quot;: [
                {
                    &quot;locale&quot;: &quot;ar&quot;,
                    &quot;title&quot;: &quot;سياسة الخصوصية&quot;,
                    &quot;content&quot;: &quot;&lt;p&gt;خصوصيتك مهمة بالنسبة لنا. تشرح هذه السياسة كيفية تعاملنا مع بياناتك.&lt;/p&gt;&quot;,
                    &quot;meta_title&quot;: &quot;سياسة الخصوصية&quot;,
                    &quot;meta_description&quot;: &quot;اقرأ سياسة الخصوصية الخاصة بنا.&quot;
                },
                {
                    &quot;locale&quot;: &quot;en&quot;,
                    &quot;title&quot;: &quot;Privacy Policy&quot;,
                    &quot;content&quot;: &quot;&lt;p&gt;Your privacy is important to us. This policy explains how we handle your data.&lt;/p&gt;&quot;,
                    &quot;meta_title&quot;: &quot;Privacy Policy&quot;,
                    &quot;meta_description&quot;: &quot;Read our privacy policy.&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 3,
            &quot;slug&quot;: null,
            &quot;title&quot;: &quot;الشروط والأحكام&quot;,
            &quot;content&quot;: &quot;&lt;p&gt;يرجى قراءة هذه الشروط والأحكام بعناية قبل استخدام خدمتنا.&lt;/p&gt;&quot;,
            &quot;translations&quot;: [
                {
                    &quot;locale&quot;: &quot;ar&quot;,
                    &quot;title&quot;: &quot;الشروط والأحكام&quot;,
                    &quot;content&quot;: &quot;&lt;p&gt;يرجى قراءة هذه الشروط والأحكام بعناية قبل استخدام خدمتنا.&lt;/p&gt;&quot;,
                    &quot;meta_title&quot;: &quot;الشروط والأحكام&quot;,
                    &quot;meta_description&quot;: &quot;شروط الخدمة الخاصة بنا.&quot;
                },
                {
                    &quot;locale&quot;: &quot;en&quot;,
                    &quot;title&quot;: &quot;Terms and Conditions&quot;,
                    &quot;content&quot;: &quot;&lt;p&gt;Please read these terms and conditions carefully before using our service.&lt;/p&gt;&quot;,
                    &quot;meta_title&quot;: &quot;Terms and Conditions&quot;,
                    &quot;meta_description&quot;: &quot;Our terms of service.&quot;
                }
            ]
        }
    ],
    &quot;error&quot;: &quot;&quot;,
    &quot;status&quot;: true,
    &quot;code&quot;: 200
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-pages" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-pages"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-pages"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-pages" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-pages">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-pages" data-method="GET"
      data-path="api/v1/pages"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-pages', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-pages"
                    onclick="tryItOut('GETapi-v1-pages');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-pages"
                    onclick="cancelTryOut('GETapi-v1-pages');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-pages"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/pages</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-pages"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-pages"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-v1-pages--slug-">GET api/v1/pages/{slug}</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-pages--slug-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/pages/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/pages/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-pages--slug-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 46
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;slug&quot;: null,
        &quot;title&quot;: &quot;من نحن&quot;,
        &quot;content&quot;: &quot;&lt;p&gt;مرحبًا بكم في مكتبتنا. نحن نقدم مجموعة واسعة من الكتب لجميع الأعمار.&lt;/p&gt;&quot;,
        &quot;translations&quot;: [
            {
                &quot;locale&quot;: &quot;ar&quot;,
                &quot;title&quot;: &quot;من نحن&quot;,
                &quot;content&quot;: &quot;&lt;p&gt;مرحبًا بكم في مكتبتنا. نحن نقدم مجموعة واسعة من الكتب لجميع الأعمار.&lt;/p&gt;&quot;,
                &quot;meta_title&quot;: &quot;من نحن - المكتبة&quot;,
                &quot;meta_description&quot;: &quot;تعرف على المزيد حول رسالتنا وقيمنا.&quot;
            },
            {
                &quot;locale&quot;: &quot;en&quot;,
                &quot;title&quot;: &quot;About Us&quot;,
                &quot;content&quot;: &quot;&lt;p&gt;Welcome to our bookstore. We offer a wide range of books for all ages.&lt;/p&gt;&quot;,
                &quot;meta_title&quot;: &quot;About Us - Bookstore&quot;,
                &quot;meta_description&quot;: &quot;Learn more about our mission and values.&quot;
            }
        ]
    },
    &quot;error&quot;: &quot;&quot;,
    &quot;status&quot;: true,
    &quot;code&quot;: 200
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-pages--slug-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-pages--slug-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-pages--slug-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-pages--slug-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-pages--slug-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-pages--slug-" data-method="GET"
      data-path="api/v1/pages/{slug}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-pages--slug-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-pages--slug-"
                    onclick="tryItOut('GETapi-v1-pages--slug-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-pages--slug-"
                    onclick="cancelTryOut('GETapi-v1-pages--slug-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-pages--slug-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/pages/{slug}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-pages--slug-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-pages--slug-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>slug</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="slug"                data-endpoint="GETapi-v1-pages--slug-"
               value="1"
               data-component="url">
    <br>
<p>The slug of the page. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-v1-products">Get Products with Filters</h2>

<p>
</p>

<p>Returns a paginated list of products with various filters.</p>

<span id="example-requests-GETapi-v1-products">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/products?category_id=17&amp;search=consequatur&amp;min_price=11613.31890586&amp;max_price=11613.31890586&amp;brands[]=consequatur&amp;options[]=consequatur&amp;best_seller=&amp;flash_sale=&amp;sort=consequatur" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/products"
);

const params = {
    "category_id": "17",
    "search": "consequatur",
    "min_price": "11613.31890586",
    "max_price": "11613.31890586",
    "brands[0]": "consequatur",
    "options[0]": "consequatur",
    "best_seller": "0",
    "flash_sale": "0",
    "sort": "consequatur",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-products">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 42
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;تمت العملية بنجاح&quot;,
    &quot;data&quot;: {
        &quot;data&quot;: [],
        &quot;meta&quot;: {
            &quot;current_page&quot;: 1,
            &quot;per_page&quot;: 12,
            &quot;total&quot;: 0,
            &quot;last_page&quot;: 1
        }
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-products" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-products"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-products"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-products" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-products">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-products" data-method="GET"
      data-path="api/v1/products"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-products', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-products"
                    onclick="tryItOut('GETapi-v1-products');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-products"
                    onclick="cancelTryOut('GETapi-v1-products');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-products"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/products</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-products"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-products"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>category_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="category_id"                data-endpoint="GETapi-v1-products"
               value="17"
               data-component="query">
    <br>
<p>Filter by category ID. Example: <code>17</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-v1-products"
               value="consequatur"
               data-component="query">
    <br>
<p>Search by product name or brand. Example: <code>consequatur</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>min_price</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="min_price"                data-endpoint="GETapi-v1-products"
               value="11613.31890586"
               data-component="query">
    <br>
<p>Minimum price. Example: <code>11613.31890586</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>max_price</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="max_price"                data-endpoint="GETapi-v1-products"
               value="11613.31890586"
               data-component="query">
    <br>
<p>Maximum price. Example: <code>11613.31890586</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>brands</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="brands[0]"                data-endpoint="GETapi-v1-products"
               data-component="query">
        <input type="text" style="display: none"
               name="brands[1]"                data-endpoint="GETapi-v1-products"
               data-component="query">
    <br>
<p>Filter by brand IDs.</p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>options</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="options[0]"                data-endpoint="GETapi-v1-products"
               data-component="query">
        <input type="text" style="display: none"
               name="options[1]"                data-endpoint="GETapi-v1-products"
               data-component="query">
    <br>
<p>Filter by option values. Format: {option_id: [value_id, ...]}</p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>best_seller</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="GETapi-v1-products" style="display: none">
            <input type="radio" name="best_seller"
                   value="1"
                   data-endpoint="GETapi-v1-products"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-v1-products" style="display: none">
            <input type="radio" name="best_seller"
                   value="0"
                   data-endpoint="GETapi-v1-products"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Filter for best sellers. Example: <code>false</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>flash_sale</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="GETapi-v1-products" style="display: none">
            <input type="radio" name="flash_sale"
                   value="1"
                   data-endpoint="GETapi-v1-products"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-v1-products" style="display: none">
            <input type="radio" name="flash_sale"
                   value="0"
                   data-endpoint="GETapi-v1-products"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Filter for products in active flash sales. Example: <code>false</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort"                data-endpoint="GETapi-v1-products"
               value="consequatur"
               data-component="query">
    <br>
<p>Sort by: latest, price_asc, price_desc, best_seller. Example: <code>consequatur</code></p>
            </div>
                </form>

                    <h2 id="endpoints-GETapi-v1-products--id-">Get Product Details</h2>

<p>
</p>

<p>Returns detailed information for a specific product.</p>

<span id="example-requests-GETapi-v1-products--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/products/17" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/products/17"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-products--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 41
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;تمت العملية بنجاح&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: 17,
        &quot;name&quot;: &quot;متن العقيدة الصغير&quot;,
        &quot;description&quot;: &quot;Delectus quod est rerum eos molestias dolorum. Quia praesentium itaque quia architecto repudiandae nam qui. Aspernatur qui sed et ea sequi illum ea. Expedita voluptas nesciunt pariatur. متن العقيدة الصغير&quot;,
        &quot;slug&quot;: &quot;mtn-alaakyd-alsghyr-17&quot;,
        &quot;meta_title&quot;: &quot;متن العقيدة الصغير&quot;,
        &quot;meta_description&quot;: &quot;Quis ducimus aliquid veritatis rem perspiciatis et voluptate.&quot;,
        &quot;sku&quot;: &quot;AG3HJ2F8&quot;,
        &quot;price&quot;: 392,
        &quot;formatted_price&quot;: &quot;392.00 ج.م&quot;,
        &quot;special_price&quot;: 313.6,
        &quot;formatted_special_price&quot;: &quot;313.60 ج.م&quot;,
        &quot;special_price_start&quot;: &quot;2026-02-09&quot;,
        &quot;special_price_end&quot;: &quot;2026-02-25&quot;,
        &quot;final_price&quot;: 313.6,
        &quot;formatted_final_price&quot;: &quot;313.60 ج.م&quot;,
        &quot;currency&quot;: {
            &quot;code&quot;: &quot;EGP&quot;,
            &quot;symbol&quot;: &quot;ج.م&quot;,
            &quot;exchange_rate&quot;: 1
        },
        &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book2.png&quot;,
        &quot;gallery&quot;: [],
        &quot;categories&quot;: [
            {
                &quot;id&quot;: 5,
                &quot;title&quot;: &quot;التاريخ الإسلامي&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                &quot;parent_id&quot;: 1,
                &quot;sub_categories&quot;: [],
                &quot;fixed&quot;: false
            },
            {
                &quot;id&quot;: 6,
                &quot;title&quot;: &quot;الأدب والروايات&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/categories.jpg&quot;,
                &quot;parent_id&quot;: null,
                &quot;sub_categories&quot;: [],
                &quot;fixed&quot;: false
            }
        ],
        &quot;options&quot;: [
            {
                &quot;id&quot;: 39,
                &quot;option_id&quot;: 1,
                &quot;name&quot;: &quot;الحجم&quot;,
                &quot;type&quot;: &quot;single&quot;,
                &quot;required&quot;: false,
                &quot;values&quot;: [
                    {
                        &quot;id&quot;: 79,
                        &quot;option_value_id&quot;: 2,
                        &quot;value_name&quot;: &quot;ربع (14x20)&quot;,
                        &quot;quantity&quot;: 47,
                        &quot;subtract_stock&quot;: true,
                        &quot;price&quot;: 0,
                        &quot;price_increment&quot;: true,
                        &quot;weight&quot;: 0,
                        &quot;weight_increment&quot;: true,
                        &quot;title&quot;: &quot;ربع (14x20)&quot;,
                        &quot;difference_in_price&quot;: 0,
                        &quot;difference_in_weight&quot;: 0,
                        &quot;ignore_quantity&quot;: false,
                        &quot;isPluse&quot;: true,
                        &quot;isMinus&quot;: false
                    }
                ],
                &quot;title&quot;: &quot;الحجم&quot;,
                &quot;isRequired&quot;: false,
                &quot;items&quot;: [
                    {
                        &quot;id&quot;: 79,
                        &quot;option_value_id&quot;: 2,
                        &quot;value_name&quot;: &quot;ربع (14x20)&quot;,
                        &quot;quantity&quot;: 47,
                        &quot;subtract_stock&quot;: true,
                        &quot;price&quot;: 0,
                        &quot;price_increment&quot;: true,
                        &quot;weight&quot;: 0,
                        &quot;weight_increment&quot;: true,
                        &quot;title&quot;: &quot;ربع (14x20)&quot;,
                        &quot;difference_in_price&quot;: 0,
                        &quot;difference_in_weight&quot;: 0,
                        &quot;ignore_quantity&quot;: false,
                        &quot;isPluse&quot;: true,
                        &quot;isMinus&quot;: false
                    }
                ]
            },
            {
                &quot;id&quot;: 40,
                &quot;option_id&quot;: 4,
                &quot;name&quot;: &quot;نوع الورق&quot;,
                &quot;type&quot;: &quot;single&quot;,
                &quot;required&quot;: true,
                &quot;values&quot;: [
                    {
                        &quot;id&quot;: 80,
                        &quot;option_value_id&quot;: 18,
                        &quot;value_name&quot;: &quot;مقصع (Art)&quot;,
                        &quot;quantity&quot;: 44,
                        &quot;subtract_stock&quot;: true,
                        &quot;price&quot;: 10,
                        &quot;price_increment&quot;: true,
                        &quot;weight&quot;: 0,
                        &quot;weight_increment&quot;: true,
                        &quot;title&quot;: &quot;مقصع (Art)&quot;,
                        &quot;difference_in_price&quot;: 10,
                        &quot;difference_in_weight&quot;: 0,
                        &quot;ignore_quantity&quot;: false,
                        &quot;isPluse&quot;: true,
                        &quot;isMinus&quot;: false
                    }
                ],
                &quot;title&quot;: &quot;نوع الورق&quot;,
                &quot;isRequired&quot;: true,
                &quot;items&quot;: [
                    {
                        &quot;id&quot;: 80,
                        &quot;option_value_id&quot;: 18,
                        &quot;value_name&quot;: &quot;مقصع (Art)&quot;,
                        &quot;quantity&quot;: 44,
                        &quot;subtract_stock&quot;: true,
                        &quot;price&quot;: 10,
                        &quot;price_increment&quot;: true,
                        &quot;weight&quot;: 0,
                        &quot;weight_increment&quot;: true,
                        &quot;title&quot;: &quot;مقصع (Art)&quot;,
                        &quot;difference_in_price&quot;: 10,
                        &quot;difference_in_weight&quot;: 0,
                        &quot;ignore_quantity&quot;: false,
                        &quot;isPluse&quot;: true,
                        &quot;isMinus&quot;: false
                    }
                ]
            },
            {
                &quot;id&quot;: 41,
                &quot;option_id&quot;: 5,
                &quot;name&quot;: &quot;لون الغلاف&quot;,
                &quot;type&quot;: &quot;single&quot;,
                &quot;required&quot;: false,
                &quot;values&quot;: [
                    {
                        &quot;id&quot;: 81,
                        &quot;option_value_id&quot;: 19,
                        &quot;value_name&quot;: &quot;أخضر&quot;,
                        &quot;quantity&quot;: 17,
                        &quot;subtract_stock&quot;: true,
                        &quot;price&quot;: 50,
                        &quot;price_increment&quot;: true,
                        &quot;weight&quot;: 0,
                        &quot;weight_increment&quot;: true,
                        &quot;title&quot;: &quot;أخضر&quot;,
                        &quot;difference_in_price&quot;: 50,
                        &quot;difference_in_weight&quot;: 0,
                        &quot;ignore_quantity&quot;: false,
                        &quot;isPluse&quot;: true,
                        &quot;isMinus&quot;: false
                    },
                    {
                        &quot;id&quot;: 82,
                        &quot;option_value_id&quot;: 22,
                        &quot;value_name&quot;: &quot;أسود&quot;,
                        &quot;quantity&quot;: 33,
                        &quot;subtract_stock&quot;: true,
                        &quot;price&quot;: 0,
                        &quot;price_increment&quot;: true,
                        &quot;weight&quot;: 0,
                        &quot;weight_increment&quot;: true,
                        &quot;title&quot;: &quot;أسود&quot;,
                        &quot;difference_in_price&quot;: 0,
                        &quot;difference_in_weight&quot;: 0,
                        &quot;ignore_quantity&quot;: false,
                        &quot;isPluse&quot;: true,
                        &quot;isMinus&quot;: false
                    },
                    {
                        &quot;id&quot;: 83,
                        &quot;option_value_id&quot;: 23,
                        &quot;value_name&quot;: &quot;بني&quot;,
                        &quot;quantity&quot;: 38,
                        &quot;subtract_stock&quot;: true,
                        &quot;price&quot;: 0,
                        &quot;price_increment&quot;: true,
                        &quot;weight&quot;: 0,
                        &quot;weight_increment&quot;: true,
                        &quot;title&quot;: &quot;بني&quot;,
                        &quot;difference_in_price&quot;: 0,
                        &quot;difference_in_weight&quot;: 0,
                        &quot;ignore_quantity&quot;: false,
                        &quot;isPluse&quot;: true,
                        &quot;isMinus&quot;: false
                    }
                ],
                &quot;title&quot;: &quot;لون الغلاف&quot;,
                &quot;isRequired&quot;: false,
                &quot;items&quot;: [
                    {
                        &quot;id&quot;: 81,
                        &quot;option_value_id&quot;: 19,
                        &quot;value_name&quot;: &quot;أخضر&quot;,
                        &quot;quantity&quot;: 17,
                        &quot;subtract_stock&quot;: true,
                        &quot;price&quot;: 50,
                        &quot;price_increment&quot;: true,
                        &quot;weight&quot;: 0,
                        &quot;weight_increment&quot;: true,
                        &quot;title&quot;: &quot;أخضر&quot;,
                        &quot;difference_in_price&quot;: 50,
                        &quot;difference_in_weight&quot;: 0,
                        &quot;ignore_quantity&quot;: false,
                        &quot;isPluse&quot;: true,
                        &quot;isMinus&quot;: false
                    },
                    {
                        &quot;id&quot;: 82,
                        &quot;option_value_id&quot;: 22,
                        &quot;value_name&quot;: &quot;أسود&quot;,
                        &quot;quantity&quot;: 33,
                        &quot;subtract_stock&quot;: true,
                        &quot;price&quot;: 0,
                        &quot;price_increment&quot;: true,
                        &quot;weight&quot;: 0,
                        &quot;weight_increment&quot;: true,
                        &quot;title&quot;: &quot;أسود&quot;,
                        &quot;difference_in_price&quot;: 0,
                        &quot;difference_in_weight&quot;: 0,
                        &quot;ignore_quantity&quot;: false,
                        &quot;isPluse&quot;: true,
                        &quot;isMinus&quot;: false
                    },
                    {
                        &quot;id&quot;: 83,
                        &quot;option_value_id&quot;: 23,
                        &quot;value_name&quot;: &quot;بني&quot;,
                        &quot;quantity&quot;: 38,
                        &quot;subtract_stock&quot;: true,
                        &quot;price&quot;: 0,
                        &quot;price_increment&quot;: true,
                        &quot;weight&quot;: 0,
                        &quot;weight_increment&quot;: true,
                        &quot;title&quot;: &quot;بني&quot;,
                        &quot;difference_in_price&quot;: 0,
                        &quot;difference_in_weight&quot;: 0,
                        &quot;ignore_quantity&quot;: false,
                        &quot;isPluse&quot;: true,
                        &quot;isMinus&quot;: false
                    }
                ]
            }
        ],
        &quot;quantity&quot;: 35,
        &quot;max_order_qty&quot;: 10,
        &quot;ignore_quantity&quot;: false,
        &quot;is_best_seller&quot;: false,
        &quot;best_seller_start&quot;: null,
        &quot;best_seller_end&quot;: null,
        &quot;weight&quot;: 1.1,
        &quot;viewed&quot;: 1173,
        &quot;shipping_rule_id&quot;: 1,
        &quot;product_brand_id&quot;: 6,
        &quot;brand&quot;: {
            &quot;id&quot;: 6,
            &quot;name&quot;: &quot;عصير الكتب&quot;
        },
        &quot;has_flash_sale&quot;: false,
        &quot;flash_sale_price&quot;: null,
        &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book2.png&quot;,
        &quot;title&quot;: &quot;متن العقيدة الصغير&quot;,
        &quot;category_id&quot;: 5,
        &quot;category&quot;: &quot;التاريخ الإسلامي&quot;,
        &quot;store_name&quot;: &quot;Mushaf Home&quot;,
        &quot;rating&quot;: 0,
        &quot;rate_count&quot;: 0,
        &quot;sale_price&quot;: 313.6,
        &quot;discount_percentage&quot;: 20,
        &quot;item_code&quot;: &quot;AG3HJ2F8&quot;,
        &quot;images&quot;: [],
        &quot;isFavorite&quot;: false,
        &quot;countFavorite&quot;: 0,
        &quot;countOrder&quot;: 0,
        &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/17&quot;,
        &quot;product_rates&quot;: [],
        &quot;deal_of_day_end&quot;: null
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-products--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-products--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-products--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-products--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-products--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-products--id-" data-method="GET"
      data-path="api/v1/products/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-products--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-products--id-"
                    onclick="tryItOut('GETapi-v1-products--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-products--id-"
                    onclick="cancelTryOut('GETapi-v1-products--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-products--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/products/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-products--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-products--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-v1-products--id-"
               value="17"
               data-component="url">
    <br>
<p>The ID of the product. Example: <code>17</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-v1-best-sellers">Get Best Selling Products</h2>

<p>
</p>

<p>Returns a list of best selling products based on is_best_seller flag and date range.</p>

<span id="example-requests-GETapi-v1-best-sellers">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/best-sellers" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/best-sellers"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-best-sellers">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 40
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;تمت العملية بنجاح&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;name&quot;: &quot;شرح التجويد الجامع&quot;,
            &quot;description&quot;: &quot;Beatae necessitatibus beatae esse maiores suscipit cupiditate possimus. Nam minima ut sit aspernatur. Aut animi vitae corrupti exercitationem quibusdam. شرح التجويد الجامع&quot;,
            &quot;slug&quot;: &quot;shrh-altgoyd-algamaa-1&quot;,
            &quot;meta_title&quot;: &quot;شرح التجويد الجامع&quot;,
            &quot;meta_description&quot;: &quot;Praesentium magni maxime dolorem aliquam.&quot;,
            &quot;sku&quot;: &quot;GDGLP7MS&quot;,
            &quot;price&quot;: 64,
            &quot;formatted_price&quot;: &quot;64.00 ج.م&quot;,
            &quot;special_price&quot;: 0,
            &quot;formatted_special_price&quot;: null,
            &quot;special_price_start&quot;: null,
            &quot;special_price_end&quot;: null,
            &quot;final_price&quot;: 64,
            &quot;formatted_final_price&quot;: &quot;64.00 ج.م&quot;,
            &quot;currency&quot;: {
                &quot;code&quot;: &quot;EGP&quot;,
                &quot;symbol&quot;: &quot;ج.م&quot;,
                &quot;exchange_rate&quot;: 1
            },
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
            &quot;gallery&quot;: [],
            &quot;categories&quot;: [],
            &quot;options&quot;: [],
            &quot;quantity&quot;: 102,
            &quot;max_order_qty&quot;: 10,
            &quot;ignore_quantity&quot;: false,
            &quot;is_best_seller&quot;: true,
            &quot;best_seller_start&quot;: null,
            &quot;best_seller_end&quot;: null,
            &quot;weight&quot;: 1.57,
            &quot;viewed&quot;: 208,
            &quot;shipping_rule_id&quot;: 1,
            &quot;product_brand_id&quot;: 6,
            &quot;brand&quot;: {
                &quot;id&quot;: 6,
                &quot;name&quot;: &quot;عصير الكتب&quot;
            },
            &quot;has_flash_sale&quot;: false,
            &quot;flash_sale_price&quot;: null,
            &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
            &quot;title&quot;: &quot;شرح التجويد الجامع&quot;,
            &quot;category_id&quot;: 3,
            &quot;category&quot;: &quot;الحديث الشريف&quot;,
            &quot;store_name&quot;: &quot;Mushaf Home&quot;,
            &quot;rating&quot;: 0,
            &quot;rate_count&quot;: 0,
            &quot;sale_price&quot;: 64,
            &quot;discount_percentage&quot;: 0,
            &quot;item_code&quot;: &quot;GDGLP7MS&quot;,
            &quot;images&quot;: [],
            &quot;isFavorite&quot;: false,
            &quot;countFavorite&quot;: 0,
            &quot;countOrder&quot;: 0,
            &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/1&quot;,
            &quot;product_rates&quot;: [],
            &quot;deal_of_day_end&quot;: null
        },
        {
            &quot;id&quot;: 7,
            &quot;name&quot;: &quot;تهذيب العقيدة الصغير&quot;,
            &quot;description&quot;: &quot;Ab itaque non at quidem. Ducimus sed qui ullam laboriosam modi doloribus. Veniam quaerat rerum recusandae eos. تهذيب العقيدة الصغير&quot;,
            &quot;slug&quot;: &quot;ththyb-alaakyd-alsghyr-7&quot;,
            &quot;meta_title&quot;: &quot;تهذيب العقيدة الصغير&quot;,
            &quot;meta_description&quot;: &quot;Temporibus quae non inventore doloribus labore et sint.&quot;,
            &quot;sku&quot;: &quot;PQBPEXBI&quot;,
            &quot;price&quot;: 228,
            &quot;formatted_price&quot;: &quot;228.00 ج.م&quot;,
            &quot;special_price&quot;: 182.4,
            &quot;formatted_special_price&quot;: &quot;182.40 ج.م&quot;,
            &quot;special_price_start&quot;: &quot;2026-02-09&quot;,
            &quot;special_price_end&quot;: &quot;2026-02-25&quot;,
            &quot;final_price&quot;: 182.4,
            &quot;formatted_final_price&quot;: &quot;182.40 ج.م&quot;,
            &quot;currency&quot;: {
                &quot;code&quot;: &quot;EGP&quot;,
                &quot;symbol&quot;: &quot;ج.م&quot;,
                &quot;exchange_rate&quot;: 1
            },
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book2.png&quot;,
            &quot;gallery&quot;: [],
            &quot;categories&quot;: [],
            &quot;options&quot;: [
                {
                    &quot;id&quot;: 18,
                    &quot;option_id&quot;: 2,
                    &quot;name&quot;: &quot;الرواية&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 36,
                            &quot;option_value_id&quot;: 6,
                            &quot;value_name&quot;: &quot;حفص عن عاصم&quot;,
                            &quot;quantity&quot;: 15,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;حفص عن عاصم&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 37,
                            &quot;option_value_id&quot;: 8,
                            &quot;value_name&quot;: &quot;قالون عن نافع&quot;,
                            &quot;quantity&quot;: 37,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;قالون عن نافع&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 38,
                            &quot;option_value_id&quot;: 10,
                            &quot;value_name&quot;: &quot;شعبة عن عاصم&quot;,
                            &quot;quantity&quot;: 14,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 50,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;شعبة عن عاصم&quot;,
                            &quot;difference_in_price&quot;: 50,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;الرواية&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 36,
                            &quot;option_value_id&quot;: 6,
                            &quot;value_name&quot;: &quot;حفص عن عاصم&quot;,
                            &quot;quantity&quot;: 15,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;حفص عن عاصم&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 37,
                            &quot;option_value_id&quot;: 8,
                            &quot;value_name&quot;: &quot;قالون عن نافع&quot;,
                            &quot;quantity&quot;: 37,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;قالون عن نافع&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 38,
                            &quot;option_value_id&quot;: 10,
                            &quot;value_name&quot;: &quot;شعبة عن عاصم&quot;,
                            &quot;quantity&quot;: 14,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 50,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;شعبة عن عاصم&quot;,
                            &quot;difference_in_price&quot;: 50,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                },
                {
                    &quot;id&quot;: 19,
                    &quot;option_id&quot;: 3,
                    &quot;name&quot;: &quot;نوع الغلاف&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 39,
                            &quot;option_value_id&quot;: 11,
                            &quot;value_name&quot;: &quot;مجلد كرتون&quot;,
                            &quot;quantity&quot;: 22,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 25,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;مجلد كرتون&quot;,
                            &quot;difference_in_price&quot;: 25,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;نوع الغلاف&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 39,
                            &quot;option_value_id&quot;: 11,
                            &quot;value_name&quot;: &quot;مجلد كرتون&quot;,
                            &quot;quantity&quot;: 22,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 25,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;مجلد كرتون&quot;,
                            &quot;difference_in_price&quot;: 25,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                }
            ],
            &quot;quantity&quot;: 191,
            &quot;max_order_qty&quot;: 10,
            &quot;ignore_quantity&quot;: false,
            &quot;is_best_seller&quot;: true,
            &quot;best_seller_start&quot;: &quot;2026-02-10&quot;,
            &quot;best_seller_end&quot;: null,
            &quot;weight&quot;: 1.02,
            &quot;viewed&quot;: 1571,
            &quot;shipping_rule_id&quot;: 1,
            &quot;product_brand_id&quot;: 6,
            &quot;brand&quot;: {
                &quot;id&quot;: 6,
                &quot;name&quot;: &quot;عصير الكتب&quot;
            },
            &quot;has_flash_sale&quot;: false,
            &quot;flash_sale_price&quot;: null,
            &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book2.png&quot;,
            &quot;title&quot;: &quot;تهذيب العقيدة الصغير&quot;,
            &quot;category_id&quot;: 4,
            &quot;category&quot;: &quot;الفقه والشريعة&quot;,
            &quot;store_name&quot;: &quot;Mushaf Home&quot;,
            &quot;rating&quot;: 0,
            &quot;rate_count&quot;: 0,
            &quot;sale_price&quot;: 182.4,
            &quot;discount_percentage&quot;: 20,
            &quot;item_code&quot;: &quot;PQBPEXBI&quot;,
            &quot;images&quot;: [],
            &quot;isFavorite&quot;: false,
            &quot;countFavorite&quot;: 0,
            &quot;countOrder&quot;: 0,
            &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/7&quot;,
            &quot;product_rates&quot;: [],
            &quot;deal_of_day_end&quot;: null
        },
        {
            &quot;id&quot;: 9,
            &quot;name&quot;: &quot;مختصر التجويد الوجيز&quot;,
            &quot;description&quot;: &quot;Quam temporibus dolores ipsum. Quas rerum aperiam maiores sunt fugit. مختصر التجويد الوجيز&quot;,
            &quot;slug&quot;: &quot;mkhtsr-altgoyd-alogyz-9&quot;,
            &quot;meta_title&quot;: &quot;مختصر التجويد الوجيز&quot;,
            &quot;meta_description&quot;: &quot;Odio quo est sed est eius.&quot;,
            &quot;sku&quot;: &quot;P3A8QWON&quot;,
            &quot;price&quot;: 238,
            &quot;formatted_price&quot;: &quot;238.00 ج.م&quot;,
            &quot;special_price&quot;: 0,
            &quot;formatted_special_price&quot;: null,
            &quot;special_price_start&quot;: null,
            &quot;special_price_end&quot;: null,
            &quot;final_price&quot;: 238,
            &quot;formatted_final_price&quot;: &quot;238.00 ج.م&quot;,
            &quot;currency&quot;: {
                &quot;code&quot;: &quot;EGP&quot;,
                &quot;symbol&quot;: &quot;ج.م&quot;,
                &quot;exchange_rate&quot;: 1
            },
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
            &quot;gallery&quot;: [],
            &quot;categories&quot;: [],
            &quot;options&quot;: [
                {
                    &quot;id&quot;: 22,
                    &quot;option_id&quot;: 1,
                    &quot;name&quot;: &quot;الحجم&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 44,
                            &quot;option_value_id&quot;: 1,
                            &quot;value_name&quot;: &quot;الجيب (10x14)&quot;,
                            &quot;quantity&quot;: 20,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 50,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;الجيب (10x14)&quot;,
                            &quot;difference_in_price&quot;: 50,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 45,
                            &quot;option_value_id&quot;: 4,
                            &quot;value_name&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;quantity&quot;: 32,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 25,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;difference_in_price&quot;: 25,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;الحجم&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 44,
                            &quot;option_value_id&quot;: 1,
                            &quot;value_name&quot;: &quot;الجيب (10x14)&quot;,
                            &quot;quantity&quot;: 20,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 50,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;الجيب (10x14)&quot;,
                            &quot;difference_in_price&quot;: 50,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 45,
                            &quot;option_value_id&quot;: 4,
                            &quot;value_name&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;quantity&quot;: 32,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 25,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;difference_in_price&quot;: 25,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                },
                {
                    &quot;id&quot;: 23,
                    &quot;option_id&quot;: 3,
                    &quot;name&quot;: &quot;نوع الغلاف&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 46,
                            &quot;option_value_id&quot;: 12,
                            &quot;value_name&quot;: &quot;غلاف ورقي&quot;,
                            &quot;quantity&quot;: 6,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 10,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;غلاف ورقي&quot;,
                            &quot;difference_in_price&quot;: 10,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;نوع الغلاف&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 46,
                            &quot;option_value_id&quot;: 12,
                            &quot;value_name&quot;: &quot;غلاف ورقي&quot;,
                            &quot;quantity&quot;: 6,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 10,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;غلاف ورقي&quot;,
                            &quot;difference_in_price&quot;: 10,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                },
                {
                    &quot;id&quot;: 24,
                    &quot;option_id&quot;: 5,
                    &quot;name&quot;: &quot;لون الغلاف&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 47,
                            &quot;option_value_id&quot;: 19,
                            &quot;value_name&quot;: &quot;أخضر&quot;,
                            &quot;quantity&quot;: 5,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;أخضر&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 48,
                            &quot;option_value_id&quot;: 21,
                            &quot;value_name&quot;: &quot;أحمر/نبيتي&quot;,
                            &quot;quantity&quot;: 31,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 10,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;أحمر/نبيتي&quot;,
                            &quot;difference_in_price&quot;: 10,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 49,
                            &quot;option_value_id&quot;: 23,
                            &quot;value_name&quot;: &quot;بني&quot;,
                            &quot;quantity&quot;: 19,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 10,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;بني&quot;,
                            &quot;difference_in_price&quot;: 10,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;لون الغلاف&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 47,
                            &quot;option_value_id&quot;: 19,
                            &quot;value_name&quot;: &quot;أخضر&quot;,
                            &quot;quantity&quot;: 5,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;أخضر&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 48,
                            &quot;option_value_id&quot;: 21,
                            &quot;value_name&quot;: &quot;أحمر/نبيتي&quot;,
                            &quot;quantity&quot;: 31,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 10,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;أحمر/نبيتي&quot;,
                            &quot;difference_in_price&quot;: 10,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 49,
                            &quot;option_value_id&quot;: 23,
                            &quot;value_name&quot;: &quot;بني&quot;,
                            &quot;quantity&quot;: 19,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 10,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;بني&quot;,
                            &quot;difference_in_price&quot;: 10,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                }
            ],
            &quot;quantity&quot;: 169,
            &quot;max_order_qty&quot;: 10,
            &quot;ignore_quantity&quot;: false,
            &quot;is_best_seller&quot;: true,
            &quot;best_seller_start&quot;: null,
            &quot;best_seller_end&quot;: null,
            &quot;weight&quot;: 1.37,
            &quot;viewed&quot;: 4543,
            &quot;shipping_rule_id&quot;: 1,
            &quot;product_brand_id&quot;: 3,
            &quot;brand&quot;: {
                &quot;id&quot;: 3,
                &quot;name&quot;: &quot;مكتبة جرير&quot;
            },
            &quot;has_flash_sale&quot;: false,
            &quot;flash_sale_price&quot;: null,
            &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
            &quot;title&quot;: &quot;مختصر التجويد الوجيز&quot;,
            &quot;category_id&quot;: 1,
            &quot;category&quot;: &quot;كتب إسلامية&quot;,
            &quot;store_name&quot;: &quot;Mushaf Home&quot;,
            &quot;rating&quot;: 0,
            &quot;rate_count&quot;: 0,
            &quot;sale_price&quot;: 238,
            &quot;discount_percentage&quot;: 0,
            &quot;item_code&quot;: &quot;P3A8QWON&quot;,
            &quot;images&quot;: [],
            &quot;isFavorite&quot;: false,
            &quot;countFavorite&quot;: 0,
            &quot;countOrder&quot;: 0,
            &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/9&quot;,
            &quot;product_rates&quot;: [],
            &quot;deal_of_day_end&quot;: null
        },
        {
            &quot;id&quot;: 14,
            &quot;name&quot;: &quot;تاريخ الحديث الصغير&quot;,
            &quot;description&quot;: &quot;Ducimus dolore sunt soluta vero. Temporibus eveniet aut est sint iure. Nihil sunt cumque tempore doloribus rerum et iusto eius. تاريخ الحديث الصغير&quot;,
            &quot;slug&quot;: &quot;tarykh-alhdyth-alsghyr-14&quot;,
            &quot;meta_title&quot;: &quot;تاريخ الحديث الصغير&quot;,
            &quot;meta_description&quot;: &quot;Nulla dolorum qui qui est.&quot;,
            &quot;sku&quot;: &quot;GBD8XHBG&quot;,
            &quot;price&quot;: 309,
            &quot;formatted_price&quot;: &quot;309.00 ج.م&quot;,
            &quot;special_price&quot;: 0,
            &quot;formatted_special_price&quot;: null,
            &quot;special_price_start&quot;: null,
            &quot;special_price_end&quot;: null,
            &quot;final_price&quot;: 309,
            &quot;formatted_final_price&quot;: &quot;309.00 ج.م&quot;,
            &quot;currency&quot;: {
                &quot;code&quot;: &quot;EGP&quot;,
                &quot;symbol&quot;: &quot;ج.م&quot;,
                &quot;exchange_rate&quot;: 1
            },
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
            &quot;gallery&quot;: [],
            &quot;categories&quot;: [],
            &quot;options&quot;: [],
            &quot;quantity&quot;: 90,
            &quot;max_order_qty&quot;: 10,
            &quot;ignore_quantity&quot;: false,
            &quot;is_best_seller&quot;: true,
            &quot;best_seller_start&quot;: null,
            &quot;best_seller_end&quot;: null,
            &quot;weight&quot;: 0.62,
            &quot;viewed&quot;: 98,
            &quot;shipping_rule_id&quot;: 1,
            &quot;product_brand_id&quot;: 1,
            &quot;brand&quot;: {
                &quot;id&quot;: 1,
                &quot;name&quot;: &quot;دار السلام&quot;
            },
            &quot;has_flash_sale&quot;: false,
            &quot;flash_sale_price&quot;: null,
            &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
            &quot;title&quot;: &quot;تاريخ الحديث الصغير&quot;,
            &quot;category_id&quot;: 14,
            &quot;category&quot;: &quot;العلوم والتكنولوجيا&quot;,
            &quot;store_name&quot;: &quot;Mushaf Home&quot;,
            &quot;rating&quot;: 0,
            &quot;rate_count&quot;: 0,
            &quot;sale_price&quot;: 309,
            &quot;discount_percentage&quot;: 0,
            &quot;item_code&quot;: &quot;GBD8XHBG&quot;,
            &quot;images&quot;: [],
            &quot;isFavorite&quot;: false,
            &quot;countFavorite&quot;: 0,
            &quot;countOrder&quot;: 0,
            &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/14&quot;,
            &quot;product_rates&quot;: [],
            &quot;deal_of_day_end&quot;: null
        },
        {
            &quot;id&quot;: 28,
            &quot;name&quot;: &quot;شرح التجويد الكبير&quot;,
            &quot;description&quot;: &quot;Et delectus et iste maiores ut. Est dolor aspernatur rerum rem asperiores. Velit eius qui eligendi dicta et voluptatem. Deleniti dignissimos dignissimos sit dolore non id. شرح التجويد الكبير&quot;,
            &quot;slug&quot;: &quot;shrh-altgoyd-alkbyr-28&quot;,
            &quot;meta_title&quot;: &quot;شرح التجويد الكبير&quot;,
            &quot;meta_description&quot;: &quot;Dicta et fugiat eum velit totam quia et.&quot;,
            &quot;sku&quot;: &quot;YOO3UOP2&quot;,
            &quot;price&quot;: 341,
            &quot;formatted_price&quot;: &quot;341.00 ج.م&quot;,
            &quot;special_price&quot;: 0,
            &quot;formatted_special_price&quot;: null,
            &quot;special_price_start&quot;: null,
            &quot;special_price_end&quot;: null,
            &quot;final_price&quot;: 341,
            &quot;formatted_final_price&quot;: &quot;341.00 ج.م&quot;,
            &quot;currency&quot;: {
                &quot;code&quot;: &quot;EGP&quot;,
                &quot;symbol&quot;: &quot;ج.م&quot;,
                &quot;exchange_rate&quot;: 1
            },
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
            &quot;gallery&quot;: [],
            &quot;categories&quot;: [],
            &quot;options&quot;: [
                {
                    &quot;id&quot;: 65,
                    &quot;option_id&quot;: 1,
                    &quot;name&quot;: &quot;الحجم&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: true,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 132,
                            &quot;option_value_id&quot;: 2,
                            &quot;value_name&quot;: &quot;ربع (14x20)&quot;,
                            &quot;quantity&quot;: 11,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 10,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;ربع (14x20)&quot;,
                            &quot;difference_in_price&quot;: 10,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 133,
                            &quot;option_value_id&quot;: 4,
                            &quot;value_name&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;quantity&quot;: 50,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 25,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;difference_in_price&quot;: 25,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;الحجم&quot;,
                    &quot;isRequired&quot;: true,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 132,
                            &quot;option_value_id&quot;: 2,
                            &quot;value_name&quot;: &quot;ربع (14x20)&quot;,
                            &quot;quantity&quot;: 11,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 10,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;ربع (14x20)&quot;,
                            &quot;difference_in_price&quot;: 10,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 133,
                            &quot;option_value_id&quot;: 4,
                            &quot;value_name&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;quantity&quot;: 50,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 25,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;difference_in_price&quot;: 25,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                },
                {
                    &quot;id&quot;: 66,
                    &quot;option_id&quot;: 2,
                    &quot;name&quot;: &quot;الرواية&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: true,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 134,
                            &quot;option_value_id&quot;: 7,
                            &quot;value_name&quot;: &quot;ورش عن نافع&quot;,
                            &quot;quantity&quot;: 33,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;ورش عن نافع&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 135,
                            &quot;option_value_id&quot;: 9,
                            &quot;value_name&quot;: &quot;الدوري عن أبي عمرو&quot;,
                            &quot;quantity&quot;: 14,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 50,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;الدوري عن أبي عمرو&quot;,
                            &quot;difference_in_price&quot;: 50,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 136,
                            &quot;option_value_id&quot;: 10,
                            &quot;value_name&quot;: &quot;شعبة عن عاصم&quot;,
                            &quot;quantity&quot;: 34,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;شعبة عن عاصم&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;الرواية&quot;,
                    &quot;isRequired&quot;: true,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 134,
                            &quot;option_value_id&quot;: 7,
                            &quot;value_name&quot;: &quot;ورش عن نافع&quot;,
                            &quot;quantity&quot;: 33,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;ورش عن نافع&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 135,
                            &quot;option_value_id&quot;: 9,
                            &quot;value_name&quot;: &quot;الدوري عن أبي عمرو&quot;,
                            &quot;quantity&quot;: 14,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 50,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;الدوري عن أبي عمرو&quot;,
                            &quot;difference_in_price&quot;: 50,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 136,
                            &quot;option_value_id&quot;: 10,
                            &quot;value_name&quot;: &quot;شعبة عن عاصم&quot;,
                            &quot;quantity&quot;: 34,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;شعبة عن عاصم&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                },
                {
                    &quot;id&quot;: 67,
                    &quot;option_id&quot;: 3,
                    &quot;name&quot;: &quot;نوع الغلاف&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 137,
                            &quot;option_value_id&quot;: 12,
                            &quot;value_name&quot;: &quot;غلاف ورقي&quot;,
                            &quot;quantity&quot;: 27,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;غلاف ورقي&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 138,
                            &quot;option_value_id&quot;: 13,
                            &quot;value_name&quot;: &quot;جلد ترمو&quot;,
                            &quot;quantity&quot;: 28,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;جلد ترمو&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 139,
                            &quot;option_value_id&quot;: 15,
                            &quot;value_name&quot;: &quot;علبة&quot;,
                            &quot;quantity&quot;: 15,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 25,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;علبة&quot;,
                            &quot;difference_in_price&quot;: 25,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;نوع الغلاف&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 137,
                            &quot;option_value_id&quot;: 12,
                            &quot;value_name&quot;: &quot;غلاف ورقي&quot;,
                            &quot;quantity&quot;: 27,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;غلاف ورقي&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 138,
                            &quot;option_value_id&quot;: 13,
                            &quot;value_name&quot;: &quot;جلد ترمو&quot;,
                            &quot;quantity&quot;: 28,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;جلد ترمو&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 139,
                            &quot;option_value_id&quot;: 15,
                            &quot;value_name&quot;: &quot;علبة&quot;,
                            &quot;quantity&quot;: 15,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 25,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;علبة&quot;,
                            &quot;difference_in_price&quot;: 25,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                },
                {
                    &quot;id&quot;: 68,
                    &quot;option_id&quot;: 5,
                    &quot;name&quot;: &quot;لون الغلاف&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 140,
                            &quot;option_value_id&quot;: 20,
                            &quot;value_name&quot;: &quot;أزرق&quot;,
                            &quot;quantity&quot;: 16,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 10,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;أزرق&quot;,
                            &quot;difference_in_price&quot;: 10,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;لون الغلاف&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 140,
                            &quot;option_value_id&quot;: 20,
                            &quot;value_name&quot;: &quot;أزرق&quot;,
                            &quot;quantity&quot;: 16,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 10,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;أزرق&quot;,
                            &quot;difference_in_price&quot;: 10,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                }
            ],
            &quot;quantity&quot;: 87,
            &quot;max_order_qty&quot;: 10,
            &quot;ignore_quantity&quot;: false,
            &quot;is_best_seller&quot;: true,
            &quot;best_seller_start&quot;: &quot;2026-02-10&quot;,
            &quot;best_seller_end&quot;: null,
            &quot;weight&quot;: 1.83,
            &quot;viewed&quot;: 2850,
            &quot;shipping_rule_id&quot;: 1,
            &quot;product_brand_id&quot;: 2,
            &quot;brand&quot;: {
                &quot;id&quot;: 2,
                &quot;name&quot;: &quot;دار ابن حزم&quot;
            },
            &quot;has_flash_sale&quot;: false,
            &quot;flash_sale_price&quot;: null,
            &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
            &quot;title&quot;: &quot;شرح التجويد الكبير&quot;,
            &quot;category_id&quot;: 11,
            &quot;category&quot;: &quot;قصص تعليمية&quot;,
            &quot;store_name&quot;: &quot;Mushaf Home&quot;,
            &quot;rating&quot;: 0,
            &quot;rate_count&quot;: 0,
            &quot;sale_price&quot;: 341,
            &quot;discount_percentage&quot;: 0,
            &quot;item_code&quot;: &quot;YOO3UOP2&quot;,
            &quot;images&quot;: [],
            &quot;isFavorite&quot;: false,
            &quot;countFavorite&quot;: 0,
            &quot;countOrder&quot;: 0,
            &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/28&quot;,
            &quot;product_rates&quot;: [],
            &quot;deal_of_day_end&quot;: null
        },
        {
            &quot;id&quot;: 30,
            &quot;name&quot;: &quot;تهذيب الحديث الكبير&quot;,
            &quot;description&quot;: &quot;Voluptatem vel labore qui facere praesentium sapiente. Id id pariatur eveniet reiciendis sed odit. Illo doloribus accusantium perspiciatis quaerat veniam facilis. تهذيب الحديث الكبير&quot;,
            &quot;slug&quot;: &quot;ththyb-alhdyth-alkbyr-30&quot;,
            &quot;meta_title&quot;: &quot;تهذيب الحديث الكبير&quot;,
            &quot;meta_description&quot;: &quot;Omnis modi rerum voluptatem suscipit ad nihil.&quot;,
            &quot;sku&quot;: &quot;B7KMIBXN&quot;,
            &quot;price&quot;: 172,
            &quot;formatted_price&quot;: &quot;172.00 ج.م&quot;,
            &quot;special_price&quot;: 0,
            &quot;formatted_special_price&quot;: null,
            &quot;special_price_start&quot;: null,
            &quot;special_price_end&quot;: null,
            &quot;final_price&quot;: 172,
            &quot;formatted_final_price&quot;: &quot;172.00 ج.م&quot;,
            &quot;currency&quot;: {
                &quot;code&quot;: &quot;EGP&quot;,
                &quot;symbol&quot;: &quot;ج.م&quot;,
                &quot;exchange_rate&quot;: 1
            },
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
            &quot;gallery&quot;: [],
            &quot;categories&quot;: [],
            &quot;options&quot;: [],
            &quot;quantity&quot;: 173,
            &quot;max_order_qty&quot;: 10,
            &quot;ignore_quantity&quot;: false,
            &quot;is_best_seller&quot;: true,
            &quot;best_seller_start&quot;: null,
            &quot;best_seller_end&quot;: null,
            &quot;weight&quot;: 1.97,
            &quot;viewed&quot;: 2037,
            &quot;shipping_rule_id&quot;: 1,
            &quot;product_brand_id&quot;: 5,
            &quot;brand&quot;: {
                &quot;id&quot;: 5,
                &quot;name&quot;: &quot;دار الشروق&quot;
            },
            &quot;has_flash_sale&quot;: false,
            &quot;flash_sale_price&quot;: null,
            &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
            &quot;title&quot;: &quot;تهذيب الحديث الكبير&quot;,
            &quot;category_id&quot;: 8,
            &quot;category&quot;: &quot;أدب عالمي&quot;,
            &quot;store_name&quot;: &quot;Mushaf Home&quot;,
            &quot;rating&quot;: 0,
            &quot;rate_count&quot;: 0,
            &quot;sale_price&quot;: 172,
            &quot;discount_percentage&quot;: 0,
            &quot;item_code&quot;: &quot;B7KMIBXN&quot;,
            &quot;images&quot;: [],
            &quot;isFavorite&quot;: false,
            &quot;countFavorite&quot;: 0,
            &quot;countOrder&quot;: 0,
            &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/30&quot;,
            &quot;product_rates&quot;: [],
            &quot;deal_of_day_end&quot;: null
        },
        {
            &quot;id&quot;: 43,
            &quot;name&quot;: &quot;حاشية الفقه الوافي&quot;,
            &quot;description&quot;: &quot;Porro velit tempora beatae facere. Velit quos qui facilis aut. Voluptas quo eveniet inventore incidunt. Nulla magni laborum sunt. حاشية الفقه الوافي&quot;,
            &quot;slug&quot;: &quot;hashy-alfkh-aloafy-43&quot;,
            &quot;meta_title&quot;: &quot;حاشية الفقه الوافي&quot;,
            &quot;meta_description&quot;: &quot;Quos et et ut suscipit iste.&quot;,
            &quot;sku&quot;: &quot;Y3KECNJJ&quot;,
            &quot;price&quot;: 58,
            &quot;formatted_price&quot;: &quot;58.00 ج.م&quot;,
            &quot;special_price&quot;: 0,
            &quot;formatted_special_price&quot;: null,
            &quot;special_price_start&quot;: null,
            &quot;special_price_end&quot;: null,
            &quot;final_price&quot;: 58,
            &quot;formatted_final_price&quot;: &quot;58.00 ج.م&quot;,
            &quot;currency&quot;: {
                &quot;code&quot;: &quot;EGP&quot;,
                &quot;symbol&quot;: &quot;ج.م&quot;,
                &quot;exchange_rate&quot;: 1
            },
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
            &quot;gallery&quot;: [],
            &quot;categories&quot;: [],
            &quot;options&quot;: [
                {
                    &quot;id&quot;: 101,
                    &quot;option_id&quot;: 3,
                    &quot;name&quot;: &quot;نوع الغلاف&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 207,
                            &quot;option_value_id&quot;: 13,
                            &quot;value_name&quot;: &quot;جلد ترمو&quot;,
                            &quot;quantity&quot;: 37,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 50,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;جلد ترمو&quot;,
                            &quot;difference_in_price&quot;: 50,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 208,
                            &quot;option_value_id&quot;: 14,
                            &quot;value_name&quot;: &quot;قطيفة&quot;,
                            &quot;quantity&quot;: 5,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 25,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;قطيفة&quot;,
                            &quot;difference_in_price&quot;: 25,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;نوع الغلاف&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 207,
                            &quot;option_value_id&quot;: 13,
                            &quot;value_name&quot;: &quot;جلد ترمو&quot;,
                            &quot;quantity&quot;: 37,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 50,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;جلد ترمو&quot;,
                            &quot;difference_in_price&quot;: 50,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 208,
                            &quot;option_value_id&quot;: 14,
                            &quot;value_name&quot;: &quot;قطيفة&quot;,
                            &quot;quantity&quot;: 5,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 25,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;قطيفة&quot;,
                            &quot;difference_in_price&quot;: 25,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                },
                {
                    &quot;id&quot;: 102,
                    &quot;option_id&quot;: 5,
                    &quot;name&quot;: &quot;لون الغلاف&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 209,
                            &quot;option_value_id&quot;: 23,
                            &quot;value_name&quot;: &quot;بني&quot;,
                            &quot;quantity&quot;: 43,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 50,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;بني&quot;,
                            &quot;difference_in_price&quot;: 50,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;لون الغلاف&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 209,
                            &quot;option_value_id&quot;: 23,
                            &quot;value_name&quot;: &quot;بني&quot;,
                            &quot;quantity&quot;: 43,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 50,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;بني&quot;,
                            &quot;difference_in_price&quot;: 50,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                }
            ],
            &quot;quantity&quot;: 72,
            &quot;max_order_qty&quot;: 10,
            &quot;ignore_quantity&quot;: false,
            &quot;is_best_seller&quot;: true,
            &quot;best_seller_start&quot;: null,
            &quot;best_seller_end&quot;: null,
            &quot;weight&quot;: 1.99,
            &quot;viewed&quot;: 3241,
            &quot;shipping_rule_id&quot;: 1,
            &quot;product_brand_id&quot;: 3,
            &quot;brand&quot;: {
                &quot;id&quot;: 3,
                &quot;name&quot;: &quot;مكتبة جرير&quot;
            },
            &quot;has_flash_sale&quot;: false,
            &quot;flash_sale_price&quot;: null,
            &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
            &quot;title&quot;: &quot;حاشية الفقه الوافي&quot;,
            &quot;category_id&quot;: 4,
            &quot;category&quot;: &quot;الفقه والشريعة&quot;,
            &quot;store_name&quot;: &quot;Mushaf Home&quot;,
            &quot;rating&quot;: 0,
            &quot;rate_count&quot;: 0,
            &quot;sale_price&quot;: 58,
            &quot;discount_percentage&quot;: 0,
            &quot;item_code&quot;: &quot;Y3KECNJJ&quot;,
            &quot;images&quot;: [],
            &quot;isFavorite&quot;: false,
            &quot;countFavorite&quot;: 0,
            &quot;countOrder&quot;: 0,
            &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/43&quot;,
            &quot;product_rates&quot;: [],
            &quot;deal_of_day_end&quot;: null
        },
        {
            &quot;id&quot;: 47,
            &quot;name&quot;: &quot;شرح الأذكار الميسر&quot;,
            &quot;description&quot;: &quot;Dolor odit accusamus omnis minus minima rerum consequuntur velit. Commodi veritatis quis maiores quo. Aut ut aut ut eum quod. Iste omnis eos eaque optio. شرح الأذكار الميسر&quot;,
            &quot;slug&quot;: &quot;shrh-alathkar-almysr-47&quot;,
            &quot;meta_title&quot;: &quot;شرح الأذكار الميسر&quot;,
            &quot;meta_description&quot;: &quot;Dicta ab et excepturi voluptate.&quot;,
            &quot;sku&quot;: &quot;Y0CQYJUU&quot;,
            &quot;price&quot;: 416,
            &quot;formatted_price&quot;: &quot;416.00 ج.م&quot;,
            &quot;special_price&quot;: 332.8,
            &quot;formatted_special_price&quot;: &quot;332.80 ج.م&quot;,
            &quot;special_price_start&quot;: &quot;2026-02-09&quot;,
            &quot;special_price_end&quot;: &quot;2026-02-25&quot;,
            &quot;final_price&quot;: 332.8,
            &quot;formatted_final_price&quot;: &quot;332.80 ج.م&quot;,
            &quot;currency&quot;: {
                &quot;code&quot;: &quot;EGP&quot;,
                &quot;symbol&quot;: &quot;ج.م&quot;,
                &quot;exchange_rate&quot;: 1
            },
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book3.png&quot;,
            &quot;gallery&quot;: [],
            &quot;categories&quot;: [],
            &quot;options&quot;: [
                {
                    &quot;id&quot;: 110,
                    &quot;option_id&quot;: 3,
                    &quot;name&quot;: &quot;نوع الغلاف&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 221,
                            &quot;option_value_id&quot;: 11,
                            &quot;value_name&quot;: &quot;مجلد كرتون&quot;,
                            &quot;quantity&quot;: 48,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;مجلد كرتون&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;نوع الغلاف&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 221,
                            &quot;option_value_id&quot;: 11,
                            &quot;value_name&quot;: &quot;مجلد كرتون&quot;,
                            &quot;quantity&quot;: 48,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;مجلد كرتون&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                },
                {
                    &quot;id&quot;: 111,
                    &quot;option_id&quot;: 4,
                    &quot;name&quot;: &quot;نوع الورق&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: true,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 222,
                            &quot;option_value_id&quot;: 16,
                            &quot;value_name&quot;: &quot;شامواه (أصفر)&quot;,
                            &quot;quantity&quot;: 18,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 50,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;شامواه (أصفر)&quot;,
                            &quot;difference_in_price&quot;: 50,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 223,
                            &quot;option_value_id&quot;: 17,
                            &quot;value_name&quot;: &quot;أبيض&quot;,
                            &quot;quantity&quot;: 40,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 25,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;أبيض&quot;,
                            &quot;difference_in_price&quot;: 25,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;نوع الورق&quot;,
                    &quot;isRequired&quot;: true,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 222,
                            &quot;option_value_id&quot;: 16,
                            &quot;value_name&quot;: &quot;شامواه (أصفر)&quot;,
                            &quot;quantity&quot;: 18,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 50,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;شامواه (أصفر)&quot;,
                            &quot;difference_in_price&quot;: 50,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 223,
                            &quot;option_value_id&quot;: 17,
                            &quot;value_name&quot;: &quot;أبيض&quot;,
                            &quot;quantity&quot;: 40,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 25,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;أبيض&quot;,
                            &quot;difference_in_price&quot;: 25,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                }
            ],
            &quot;quantity&quot;: 48,
            &quot;max_order_qty&quot;: 10,
            &quot;ignore_quantity&quot;: false,
            &quot;is_best_seller&quot;: true,
            &quot;best_seller_start&quot;: null,
            &quot;best_seller_end&quot;: null,
            &quot;weight&quot;: 0.9,
            &quot;viewed&quot;: 2872,
            &quot;shipping_rule_id&quot;: 1,
            &quot;product_brand_id&quot;: 3,
            &quot;brand&quot;: {
                &quot;id&quot;: 3,
                &quot;name&quot;: &quot;مكتبة جرير&quot;
            },
            &quot;has_flash_sale&quot;: false,
            &quot;flash_sale_price&quot;: null,
            &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book3.png&quot;,
            &quot;title&quot;: &quot;شرح الأذكار الميسر&quot;,
            &quot;category_id&quot;: 7,
            &quot;category&quot;: &quot;روايات عربية&quot;,
            &quot;store_name&quot;: &quot;Mushaf Home&quot;,
            &quot;rating&quot;: 0,
            &quot;rate_count&quot;: 0,
            &quot;sale_price&quot;: 332.8,
            &quot;discount_percentage&quot;: 20,
            &quot;item_code&quot;: &quot;Y0CQYJUU&quot;,
            &quot;images&quot;: [],
            &quot;isFavorite&quot;: false,
            &quot;countFavorite&quot;: 0,
            &quot;countOrder&quot;: 0,
            &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/47&quot;,
            &quot;product_rates&quot;: [],
            &quot;deal_of_day_end&quot;: null
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-best-sellers" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-best-sellers"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-best-sellers"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-best-sellers" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-best-sellers">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-best-sellers" data-method="GET"
      data-path="api/v1/best-sellers"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-best-sellers', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-best-sellers"
                    onclick="tryItOut('GETapi-v1-best-sellers');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-best-sellers"
                    onclick="cancelTryOut('GETapi-v1-best-sellers');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-best-sellers"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/best-sellers</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-best-sellers"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-best-sellers"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-v1-latest-products">Get Latest Products</h2>

<p>
</p>

<p>Returns a list of the most recently added active products.</p>

<span id="example-requests-GETapi-v1-latest-products">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/latest-products" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/latest-products"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-latest-products">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 39
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;تمت العملية بنجاح&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 88,
            &quot;name&quot;: &quot;تفسير مسلم الصغير&quot;,
            &quot;description&quot;: &quot;Nam possimus distinctio modi ab eum. Illum fugiat aperiam et deserunt. Culpa quia officiis dolor libero ut enim. تفسير مسلم الصغير&quot;,
            &quot;slug&quot;: &quot;tfsyr-mslm-alsghyr-88&quot;,
            &quot;meta_title&quot;: &quot;تفسير مسلم الصغير&quot;,
            &quot;meta_description&quot;: &quot;Nihil officia quia provident molestiae sit.&quot;,
            &quot;sku&quot;: &quot;6AQJWWVQ&quot;,
            &quot;price&quot;: 205,
            &quot;formatted_price&quot;: &quot;205.00 ج.م&quot;,
            &quot;special_price&quot;: 0,
            &quot;formatted_special_price&quot;: null,
            &quot;special_price_start&quot;: null,
            &quot;special_price_end&quot;: null,
            &quot;final_price&quot;: 205,
            &quot;formatted_final_price&quot;: &quot;205.00 ج.م&quot;,
            &quot;currency&quot;: {
                &quot;code&quot;: &quot;EGP&quot;,
                &quot;symbol&quot;: &quot;ج.م&quot;,
                &quot;exchange_rate&quot;: 1
            },
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
            &quot;gallery&quot;: [],
            &quot;categories&quot;: [],
            &quot;options&quot;: [
                {
                    &quot;id&quot;: 213,
                    &quot;option_id&quot;: 1,
                    &quot;name&quot;: &quot;الحجم&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 430,
                            &quot;option_value_id&quot;: 1,
                            &quot;value_name&quot;: &quot;الجيب (10x14)&quot;,
                            &quot;quantity&quot;: 20,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;الجيب (10x14)&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 431,
                            &quot;option_value_id&quot;: 2,
                            &quot;value_name&quot;: &quot;ربع (14x20)&quot;,
                            &quot;quantity&quot;: 28,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;ربع (14x20)&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 432,
                            &quot;option_value_id&quot;: 4,
                            &quot;value_name&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;quantity&quot;: 39,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;الحجم&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 430,
                            &quot;option_value_id&quot;: 1,
                            &quot;value_name&quot;: &quot;الجيب (10x14)&quot;,
                            &quot;quantity&quot;: 20,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;الجيب (10x14)&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 431,
                            &quot;option_value_id&quot;: 2,
                            &quot;value_name&quot;: &quot;ربع (14x20)&quot;,
                            &quot;quantity&quot;: 28,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;ربع (14x20)&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 432,
                            &quot;option_value_id&quot;: 4,
                            &quot;value_name&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;quantity&quot;: 39,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                },
                {
                    &quot;id&quot;: 214,
                    &quot;option_id&quot;: 2,
                    &quot;name&quot;: &quot;الرواية&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: true,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 433,
                            &quot;option_value_id&quot;: 6,
                            &quot;value_name&quot;: &quot;حفص عن عاصم&quot;,
                            &quot;quantity&quot;: 44,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 25,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;حفص عن عاصم&quot;,
                            &quot;difference_in_price&quot;: 25,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 434,
                            &quot;option_value_id&quot;: 8,
                            &quot;value_name&quot;: &quot;قالون عن نافع&quot;,
                            &quot;quantity&quot;: 16,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 10,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;قالون عن نافع&quot;,
                            &quot;difference_in_price&quot;: 10,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;الرواية&quot;,
                    &quot;isRequired&quot;: true,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 433,
                            &quot;option_value_id&quot;: 6,
                            &quot;value_name&quot;: &quot;حفص عن عاصم&quot;,
                            &quot;quantity&quot;: 44,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 25,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;حفص عن عاصم&quot;,
                            &quot;difference_in_price&quot;: 25,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 434,
                            &quot;option_value_id&quot;: 8,
                            &quot;value_name&quot;: &quot;قالون عن نافع&quot;,
                            &quot;quantity&quot;: 16,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 10,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;قالون عن نافع&quot;,
                            &quot;difference_in_price&quot;: 10,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                },
                {
                    &quot;id&quot;: 215,
                    &quot;option_id&quot;: 3,
                    &quot;name&quot;: &quot;نوع الغلاف&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 435,
                            &quot;option_value_id&quot;: 12,
                            &quot;value_name&quot;: &quot;غلاف ورقي&quot;,
                            &quot;quantity&quot;: 22,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;غلاف ورقي&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 436,
                            &quot;option_value_id&quot;: 13,
                            &quot;value_name&quot;: &quot;جلد ترمو&quot;,
                            &quot;quantity&quot;: 30,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;جلد ترمو&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 437,
                            &quot;option_value_id&quot;: 15,
                            &quot;value_name&quot;: &quot;علبة&quot;,
                            &quot;quantity&quot;: 47,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;علبة&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;نوع الغلاف&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 435,
                            &quot;option_value_id&quot;: 12,
                            &quot;value_name&quot;: &quot;غلاف ورقي&quot;,
                            &quot;quantity&quot;: 22,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;غلاف ورقي&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 436,
                            &quot;option_value_id&quot;: 13,
                            &quot;value_name&quot;: &quot;جلد ترمو&quot;,
                            &quot;quantity&quot;: 30,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;جلد ترمو&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 437,
                            &quot;option_value_id&quot;: 15,
                            &quot;value_name&quot;: &quot;علبة&quot;,
                            &quot;quantity&quot;: 47,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;علبة&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                }
            ],
            &quot;quantity&quot;: 181,
            &quot;max_order_qty&quot;: 10,
            &quot;ignore_quantity&quot;: false,
            &quot;is_best_seller&quot;: false,
            &quot;best_seller_start&quot;: null,
            &quot;best_seller_end&quot;: null,
            &quot;weight&quot;: 0.95,
            &quot;viewed&quot;: 1451,
            &quot;shipping_rule_id&quot;: 1,
            &quot;product_brand_id&quot;: 5,
            &quot;brand&quot;: {
                &quot;id&quot;: 5,
                &quot;name&quot;: &quot;دار الشروق&quot;
            },
            &quot;has_flash_sale&quot;: false,
            &quot;flash_sale_price&quot;: null,
            &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
            &quot;title&quot;: &quot;تفسير مسلم الصغير&quot;,
            &quot;category_id&quot;: 5,
            &quot;category&quot;: &quot;التاريخ الإسلامي&quot;,
            &quot;store_name&quot;: &quot;Mushaf Home&quot;,
            &quot;rating&quot;: 0,
            &quot;rate_count&quot;: 0,
            &quot;sale_price&quot;: 205,
            &quot;discount_percentage&quot;: 0,
            &quot;item_code&quot;: &quot;6AQJWWVQ&quot;,
            &quot;images&quot;: [],
            &quot;isFavorite&quot;: false,
            &quot;countFavorite&quot;: 0,
            &quot;countOrder&quot;: 0,
            &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/88&quot;,
            &quot;product_rates&quot;: [],
            &quot;deal_of_day_end&quot;: null
        },
        {
            &quot;id&quot;: 89,
            &quot;name&quot;: &quot;شرح العقيدة الشامل&quot;,
            &quot;description&quot;: &quot;Totam possimus cumque tempora aliquid ut consequatur. Dolor sint iure cupiditate omnis adipisci repellat. Et facilis et asperiores ad sequi. شرح العقيدة الشامل&quot;,
            &quot;slug&quot;: &quot;shrh-alaakyd-alshaml-89&quot;,
            &quot;meta_title&quot;: &quot;شرح العقيدة الشامل&quot;,
            &quot;meta_description&quot;: &quot;Sequi totam tenetur accusamus cum.&quot;,
            &quot;sku&quot;: &quot;S00NWVM0&quot;,
            &quot;price&quot;: 419,
            &quot;formatted_price&quot;: &quot;419.00 ج.م&quot;,
            &quot;special_price&quot;: 335.2,
            &quot;formatted_special_price&quot;: &quot;335.20 ج.م&quot;,
            &quot;special_price_start&quot;: &quot;2026-02-09&quot;,
            &quot;special_price_end&quot;: &quot;2026-02-25&quot;,
            &quot;final_price&quot;: 335.2,
            &quot;formatted_final_price&quot;: &quot;335.20 ج.م&quot;,
            &quot;currency&quot;: {
                &quot;code&quot;: &quot;EGP&quot;,
                &quot;symbol&quot;: &quot;ج.م&quot;,
                &quot;exchange_rate&quot;: 1
            },
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
            &quot;gallery&quot;: [],
            &quot;categories&quot;: [],
            &quot;options&quot;: [
                {
                    &quot;id&quot;: 216,
                    &quot;option_id&quot;: 1,
                    &quot;name&quot;: &quot;الحجم&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 438,
                            &quot;option_value_id&quot;: 4,
                            &quot;value_name&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;quantity&quot;: 15,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 50,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;difference_in_price&quot;: 50,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 439,
                            &quot;option_value_id&quot;: 5,
                            &quot;value_name&quot;: &quot;تهجد (25x35)&quot;,
                            &quot;quantity&quot;: 30,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;تهجد (25x35)&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;الحجم&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 438,
                            &quot;option_value_id&quot;: 4,
                            &quot;value_name&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;quantity&quot;: 15,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 50,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;difference_in_price&quot;: 50,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 439,
                            &quot;option_value_id&quot;: 5,
                            &quot;value_name&quot;: &quot;تهجد (25x35)&quot;,
                            &quot;quantity&quot;: 30,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;تهجد (25x35)&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                },
                {
                    &quot;id&quot;: 217,
                    &quot;option_id&quot;: 2,
                    &quot;name&quot;: &quot;الرواية&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 440,
                            &quot;option_value_id&quot;: 9,
                            &quot;value_name&quot;: &quot;الدوري عن أبي عمرو&quot;,
                            &quot;quantity&quot;: 17,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;الدوري عن أبي عمرو&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 441,
                            &quot;option_value_id&quot;: 10,
                            &quot;value_name&quot;: &quot;شعبة عن عاصم&quot;,
                            &quot;quantity&quot;: 17,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 10,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;شعبة عن عاصم&quot;,
                            &quot;difference_in_price&quot;: 10,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;الرواية&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 440,
                            &quot;option_value_id&quot;: 9,
                            &quot;value_name&quot;: &quot;الدوري عن أبي عمرو&quot;,
                            &quot;quantity&quot;: 17,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;الدوري عن أبي عمرو&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 441,
                            &quot;option_value_id&quot;: 10,
                            &quot;value_name&quot;: &quot;شعبة عن عاصم&quot;,
                            &quot;quantity&quot;: 17,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 10,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;شعبة عن عاصم&quot;,
                            &quot;difference_in_price&quot;: 10,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                },
                {
                    &quot;id&quot;: 218,
                    &quot;option_id&quot;: 3,
                    &quot;name&quot;: &quot;نوع الغلاف&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 442,
                            &quot;option_value_id&quot;: 11,
                            &quot;value_name&quot;: &quot;مجلد كرتون&quot;,
                            &quot;quantity&quot;: 40,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;مجلد كرتون&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 443,
                            &quot;option_value_id&quot;: 15,
                            &quot;value_name&quot;: &quot;علبة&quot;,
                            &quot;quantity&quot;: 20,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 25,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;علبة&quot;,
                            &quot;difference_in_price&quot;: 25,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;نوع الغلاف&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 442,
                            &quot;option_value_id&quot;: 11,
                            &quot;value_name&quot;: &quot;مجلد كرتون&quot;,
                            &quot;quantity&quot;: 40,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;مجلد كرتون&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 443,
                            &quot;option_value_id&quot;: 15,
                            &quot;value_name&quot;: &quot;علبة&quot;,
                            &quot;quantity&quot;: 20,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 25,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;علبة&quot;,
                            &quot;difference_in_price&quot;: 25,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                },
                {
                    &quot;id&quot;: 219,
                    &quot;option_id&quot;: 4,
                    &quot;name&quot;: &quot;نوع الورق&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 444,
                            &quot;option_value_id&quot;: 16,
                            &quot;value_name&quot;: &quot;شامواه (أصفر)&quot;,
                            &quot;quantity&quot;: 24,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 50,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;شامواه (أصفر)&quot;,
                            &quot;difference_in_price&quot;: 50,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 445,
                            &quot;option_value_id&quot;: 17,
                            &quot;value_name&quot;: &quot;أبيض&quot;,
                            &quot;quantity&quot;: 17,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 25,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;أبيض&quot;,
                            &quot;difference_in_price&quot;: 25,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 446,
                            &quot;option_value_id&quot;: 18,
                            &quot;value_name&quot;: &quot;مقصع (Art)&quot;,
                            &quot;quantity&quot;: 15,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;مقصع (Art)&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;نوع الورق&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 444,
                            &quot;option_value_id&quot;: 16,
                            &quot;value_name&quot;: &quot;شامواه (أصفر)&quot;,
                            &quot;quantity&quot;: 24,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 50,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;شامواه (أصفر)&quot;,
                            &quot;difference_in_price&quot;: 50,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 445,
                            &quot;option_value_id&quot;: 17,
                            &quot;value_name&quot;: &quot;أبيض&quot;,
                            &quot;quantity&quot;: 17,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 25,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;أبيض&quot;,
                            &quot;difference_in_price&quot;: 25,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 446,
                            &quot;option_value_id&quot;: 18,
                            &quot;value_name&quot;: &quot;مقصع (Art)&quot;,
                            &quot;quantity&quot;: 15,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;مقصع (Art)&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                }
            ],
            &quot;quantity&quot;: 143,
            &quot;max_order_qty&quot;: 10,
            &quot;ignore_quantity&quot;: false,
            &quot;is_best_seller&quot;: false,
            &quot;best_seller_start&quot;: null,
            &quot;best_seller_end&quot;: null,
            &quot;weight&quot;: 1.11,
            &quot;viewed&quot;: 751,
            &quot;shipping_rule_id&quot;: 1,
            &quot;product_brand_id&quot;: 4,
            &quot;brand&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;دار المعرفة&quot;
            },
            &quot;has_flash_sale&quot;: false,
            &quot;flash_sale_price&quot;: null,
            &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
            &quot;title&quot;: &quot;شرح العقيدة الشامل&quot;,
            &quot;category_id&quot;: 12,
            &quot;category&quot;: &quot;كتب أنشطة&quot;,
            &quot;store_name&quot;: &quot;Mushaf Home&quot;,
            &quot;rating&quot;: 0,
            &quot;rate_count&quot;: 0,
            &quot;sale_price&quot;: 335.2,
            &quot;discount_percentage&quot;: 20,
            &quot;item_code&quot;: &quot;S00NWVM0&quot;,
            &quot;images&quot;: [],
            &quot;isFavorite&quot;: false,
            &quot;countFavorite&quot;: 0,
            &quot;countOrder&quot;: 0,
            &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/89&quot;,
            &quot;product_rates&quot;: [],
            &quot;deal_of_day_end&quot;: null
        },
        {
            &quot;id&quot;: 90,
            &quot;name&quot;: &quot;شرح الفقه الصغير&quot;,
            &quot;description&quot;: &quot;Rerum ullam beatae dicta nemo repellat. Impedit quos sed porro vero. Rerum non officia veritatis exercitationem. Repellendus non repellat nihil voluptate laboriosam mollitia fugiat. Numquam quaerat qui et praesentium culpa. شرح الفقه الصغير&quot;,
            &quot;slug&quot;: &quot;shrh-alfkh-alsghyr-90&quot;,
            &quot;meta_title&quot;: &quot;شرح الفقه الصغير&quot;,
            &quot;meta_description&quot;: &quot;Dolorem est doloremque cumque cumque dolorum nihil nulla.&quot;,
            &quot;sku&quot;: &quot;ZGQP0VXB&quot;,
            &quot;price&quot;: 57,
            &quot;formatted_price&quot;: &quot;57.00 ج.م&quot;,
            &quot;special_price&quot;: 0,
            &quot;formatted_special_price&quot;: null,
            &quot;special_price_start&quot;: null,
            &quot;special_price_end&quot;: null,
            &quot;final_price&quot;: 57,
            &quot;formatted_final_price&quot;: &quot;57.00 ج.م&quot;,
            &quot;currency&quot;: {
                &quot;code&quot;: &quot;EGP&quot;,
                &quot;symbol&quot;: &quot;ج.م&quot;,
                &quot;exchange_rate&quot;: 1
            },
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book3.png&quot;,
            &quot;gallery&quot;: [],
            &quot;categories&quot;: [],
            &quot;options&quot;: [
                {
                    &quot;id&quot;: 220,
                    &quot;option_id&quot;: 2,
                    &quot;name&quot;: &quot;الرواية&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 447,
                            &quot;option_value_id&quot;: 9,
                            &quot;value_name&quot;: &quot;الدوري عن أبي عمرو&quot;,
                            &quot;quantity&quot;: 5,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 50,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;الدوري عن أبي عمرو&quot;,
                            &quot;difference_in_price&quot;: 50,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;الرواية&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 447,
                            &quot;option_value_id&quot;: 9,
                            &quot;value_name&quot;: &quot;الدوري عن أبي عمرو&quot;,
                            &quot;quantity&quot;: 5,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 50,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;الدوري عن أبي عمرو&quot;,
                            &quot;difference_in_price&quot;: 50,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                },
                {
                    &quot;id&quot;: 221,
                    &quot;option_id&quot;: 4,
                    &quot;name&quot;: &quot;نوع الورق&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 448,
                            &quot;option_value_id&quot;: 16,
                            &quot;value_name&quot;: &quot;شامواه (أصفر)&quot;,
                            &quot;quantity&quot;: 23,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 25,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;شامواه (أصفر)&quot;,
                            &quot;difference_in_price&quot;: 25,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;نوع الورق&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 448,
                            &quot;option_value_id&quot;: 16,
                            &quot;value_name&quot;: &quot;شامواه (أصفر)&quot;,
                            &quot;quantity&quot;: 23,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 25,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;شامواه (أصفر)&quot;,
                            &quot;difference_in_price&quot;: 25,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                }
            ],
            &quot;quantity&quot;: 125,
            &quot;max_order_qty&quot;: 10,
            &quot;ignore_quantity&quot;: false,
            &quot;is_best_seller&quot;: true,
            &quot;best_seller_start&quot;: null,
            &quot;best_seller_end&quot;: null,
            &quot;weight&quot;: 0.7,
            &quot;viewed&quot;: 1616,
            &quot;shipping_rule_id&quot;: 1,
            &quot;product_brand_id&quot;: 1,
            &quot;brand&quot;: {
                &quot;id&quot;: 1,
                &quot;name&quot;: &quot;دار السلام&quot;
            },
            &quot;has_flash_sale&quot;: false,
            &quot;flash_sale_price&quot;: null,
            &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book3.png&quot;,
            &quot;title&quot;: &quot;شرح الفقه الصغير&quot;,
            &quot;category_id&quot;: 5,
            &quot;category&quot;: &quot;التاريخ الإسلامي&quot;,
            &quot;store_name&quot;: &quot;Mushaf Home&quot;,
            &quot;rating&quot;: 0,
            &quot;rate_count&quot;: 0,
            &quot;sale_price&quot;: 57,
            &quot;discount_percentage&quot;: 0,
            &quot;item_code&quot;: &quot;ZGQP0VXB&quot;,
            &quot;images&quot;: [],
            &quot;isFavorite&quot;: false,
            &quot;countFavorite&quot;: 0,
            &quot;countOrder&quot;: 0,
            &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/90&quot;,
            &quot;product_rates&quot;: [],
            &quot;deal_of_day_end&quot;: null
        },
        {
            &quot;id&quot;: 91,
            &quot;name&quot;: &quot;مسند الميراث الكبير&quot;,
            &quot;description&quot;: &quot;Soluta tempora mollitia sint quia sunt quos corrupti. Odio aut iste dolor id quis quaerat quidem corrupti. Aut neque magnam quia necessitatibus nisi magnam. مسند الميراث الكبير&quot;,
            &quot;slug&quot;: &quot;msnd-almyrath-alkbyr-91&quot;,
            &quot;meta_title&quot;: &quot;مسند الميراث الكبير&quot;,
            &quot;meta_description&quot;: &quot;Nam sequi cum distinctio est voluptatem deserunt.&quot;,
            &quot;sku&quot;: &quot;VMXYLCGT&quot;,
            &quot;price&quot;: 458,
            &quot;formatted_price&quot;: &quot;458.00 ج.م&quot;,
            &quot;special_price&quot;: 366.4,
            &quot;formatted_special_price&quot;: &quot;366.40 ج.م&quot;,
            &quot;special_price_start&quot;: &quot;2026-02-09&quot;,
            &quot;special_price_end&quot;: &quot;2026-02-25&quot;,
            &quot;final_price&quot;: 366.4,
            &quot;formatted_final_price&quot;: &quot;366.40 ج.م&quot;,
            &quot;currency&quot;: {
                &quot;code&quot;: &quot;EGP&quot;,
                &quot;symbol&quot;: &quot;ج.م&quot;,
                &quot;exchange_rate&quot;: 1
            },
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
            &quot;gallery&quot;: [],
            &quot;categories&quot;: [],
            &quot;options&quot;: [
                {
                    &quot;id&quot;: 222,
                    &quot;option_id&quot;: 1,
                    &quot;name&quot;: &quot;الحجم&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 449,
                            &quot;option_value_id&quot;: 1,
                            &quot;value_name&quot;: &quot;الجيب (10x14)&quot;,
                            &quot;quantity&quot;: 21,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;الجيب (10x14)&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;الحجم&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 449,
                            &quot;option_value_id&quot;: 1,
                            &quot;value_name&quot;: &quot;الجيب (10x14)&quot;,
                            &quot;quantity&quot;: 21,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;الجيب (10x14)&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                },
                {
                    &quot;id&quot;: 223,
                    &quot;option_id&quot;: 3,
                    &quot;name&quot;: &quot;نوع الغلاف&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: true,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 450,
                            &quot;option_value_id&quot;: 13,
                            &quot;value_name&quot;: &quot;جلد ترمو&quot;,
                            &quot;quantity&quot;: 33,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;جلد ترمو&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;نوع الغلاف&quot;,
                    &quot;isRequired&quot;: true,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 450,
                            &quot;option_value_id&quot;: 13,
                            &quot;value_name&quot;: &quot;جلد ترمو&quot;,
                            &quot;quantity&quot;: 33,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;جلد ترمو&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                },
                {
                    &quot;id&quot;: 224,
                    &quot;option_id&quot;: 5,
                    &quot;name&quot;: &quot;لون الغلاف&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: true,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 451,
                            &quot;option_value_id&quot;: 19,
                            &quot;value_name&quot;: &quot;أخضر&quot;,
                            &quot;quantity&quot;: 36,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;أخضر&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 452,
                            &quot;option_value_id&quot;: 21,
                            &quot;value_name&quot;: &quot;أحمر/نبيتي&quot;,
                            &quot;quantity&quot;: 37,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;أحمر/نبيتي&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 453,
                            &quot;option_value_id&quot;: 22,
                            &quot;value_name&quot;: &quot;أسود&quot;,
                            &quot;quantity&quot;: 19,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 10,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;أسود&quot;,
                            &quot;difference_in_price&quot;: 10,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;لون الغلاف&quot;,
                    &quot;isRequired&quot;: true,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 451,
                            &quot;option_value_id&quot;: 19,
                            &quot;value_name&quot;: &quot;أخضر&quot;,
                            &quot;quantity&quot;: 36,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;أخضر&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 452,
                            &quot;option_value_id&quot;: 21,
                            &quot;value_name&quot;: &quot;أحمر/نبيتي&quot;,
                            &quot;quantity&quot;: 37,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;أحمر/نبيتي&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 453,
                            &quot;option_value_id&quot;: 22,
                            &quot;value_name&quot;: &quot;أسود&quot;,
                            &quot;quantity&quot;: 19,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 10,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;أسود&quot;,
                            &quot;difference_in_price&quot;: 10,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                }
            ],
            &quot;quantity&quot;: 91,
            &quot;max_order_qty&quot;: 10,
            &quot;ignore_quantity&quot;: false,
            &quot;is_best_seller&quot;: false,
            &quot;best_seller_start&quot;: null,
            &quot;best_seller_end&quot;: null,
            &quot;weight&quot;: 1.77,
            &quot;viewed&quot;: 955,
            &quot;shipping_rule_id&quot;: 1,
            &quot;product_brand_id&quot;: 4,
            &quot;brand&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;دار المعرفة&quot;
            },
            &quot;has_flash_sale&quot;: false,
            &quot;flash_sale_price&quot;: null,
            &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book4.png&quot;,
            &quot;title&quot;: &quot;مسند الميراث الكبير&quot;,
            &quot;category_id&quot;: 2,
            &quot;category&quot;: &quot;القرآن الكريم&quot;,
            &quot;store_name&quot;: &quot;Mushaf Home&quot;,
            &quot;rating&quot;: 0,
            &quot;rate_count&quot;: 0,
            &quot;sale_price&quot;: 366.4,
            &quot;discount_percentage&quot;: 20,
            &quot;item_code&quot;: &quot;VMXYLCGT&quot;,
            &quot;images&quot;: [],
            &quot;isFavorite&quot;: false,
            &quot;countFavorite&quot;: 0,
            &quot;countOrder&quot;: 0,
            &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/91&quot;,
            &quot;product_rates&quot;: [],
            &quot;deal_of_day_end&quot;: null
        },
        {
            &quot;id&quot;: 92,
            &quot;name&quot;: &quot;صحيح الميراث الوافي&quot;,
            &quot;description&quot;: &quot;Quo porro vitae repellat optio. Voluptates labore est nihil in. Tempore aliquam libero dicta quasi. Et quidem repellat minima velit mollitia modi. صحيح الميراث الوافي&quot;,
            &quot;slug&quot;: &quot;shyh-almyrath-aloafy-92&quot;,
            &quot;meta_title&quot;: &quot;صحيح الميراث الوافي&quot;,
            &quot;meta_description&quot;: &quot;Et ipsa atque nisi esse natus et nemo.&quot;,
            &quot;sku&quot;: &quot;OEB92MF0&quot;,
            &quot;price&quot;: 171,
            &quot;formatted_price&quot;: &quot;171.00 ج.م&quot;,
            &quot;special_price&quot;: 136.8,
            &quot;formatted_special_price&quot;: &quot;136.80 ج.م&quot;,
            &quot;special_price_start&quot;: &quot;2026-02-09&quot;,
            &quot;special_price_end&quot;: &quot;2026-02-25&quot;,
            &quot;final_price&quot;: 136.8,
            &quot;formatted_final_price&quot;: &quot;136.80 ج.م&quot;,
            &quot;currency&quot;: {
                &quot;code&quot;: &quot;EGP&quot;,
                &quot;symbol&quot;: &quot;ج.م&quot;,
                &quot;exchange_rate&quot;: 1
            },
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book1.png&quot;,
            &quot;gallery&quot;: [],
            &quot;categories&quot;: [],
            &quot;options&quot;: [
                {
                    &quot;id&quot;: 225,
                    &quot;option_id&quot;: 1,
                    &quot;name&quot;: &quot;الحجم&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 454,
                            &quot;option_value_id&quot;: 4,
                            &quot;value_name&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;quantity&quot;: 31,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;الحجم&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 454,
                            &quot;option_value_id&quot;: 4,
                            &quot;value_name&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;quantity&quot;: 31,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                },
                {
                    &quot;id&quot;: 226,
                    &quot;option_id&quot;: 3,
                    &quot;name&quot;: &quot;نوع الغلاف&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 455,
                            &quot;option_value_id&quot;: 14,
                            &quot;value_name&quot;: &quot;قطيفة&quot;,
                            &quot;quantity&quot;: 20,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;قطيفة&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;نوع الغلاف&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 455,
                            &quot;option_value_id&quot;: 14,
                            &quot;value_name&quot;: &quot;قطيفة&quot;,
                            &quot;quantity&quot;: 20,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;قطيفة&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                },
                {
                    &quot;id&quot;: 227,
                    &quot;option_id&quot;: 5,
                    &quot;name&quot;: &quot;لون الغلاف&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 456,
                            &quot;option_value_id&quot;: 20,
                            &quot;value_name&quot;: &quot;أزرق&quot;,
                            &quot;quantity&quot;: 42,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;أزرق&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 457,
                            &quot;option_value_id&quot;: 22,
                            &quot;value_name&quot;: &quot;أسود&quot;,
                            &quot;quantity&quot;: 15,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 25,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;أسود&quot;,
                            &quot;difference_in_price&quot;: 25,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 458,
                            &quot;option_value_id&quot;: 23,
                            &quot;value_name&quot;: &quot;بني&quot;,
                            &quot;quantity&quot;: 14,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;بني&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;لون الغلاف&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 456,
                            &quot;option_value_id&quot;: 20,
                            &quot;value_name&quot;: &quot;أزرق&quot;,
                            &quot;quantity&quot;: 42,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;أزرق&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 457,
                            &quot;option_value_id&quot;: 22,
                            &quot;value_name&quot;: &quot;أسود&quot;,
                            &quot;quantity&quot;: 15,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 25,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;أسود&quot;,
                            &quot;difference_in_price&quot;: 25,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 458,
                            &quot;option_value_id&quot;: 23,
                            &quot;value_name&quot;: &quot;بني&quot;,
                            &quot;quantity&quot;: 14,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;بني&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                }
            ],
            &quot;quantity&quot;: 70,
            &quot;max_order_qty&quot;: 10,
            &quot;ignore_quantity&quot;: false,
            &quot;is_best_seller&quot;: false,
            &quot;best_seller_start&quot;: null,
            &quot;best_seller_end&quot;: null,
            &quot;weight&quot;: 1.91,
            &quot;viewed&quot;: 114,
            &quot;shipping_rule_id&quot;: 1,
            &quot;product_brand_id&quot;: 1,
            &quot;brand&quot;: {
                &quot;id&quot;: 1,
                &quot;name&quot;: &quot;دار السلام&quot;
            },
            &quot;has_flash_sale&quot;: false,
            &quot;flash_sale_price&quot;: null,
            &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book1.png&quot;,
            &quot;title&quot;: &quot;صحيح الميراث الوافي&quot;,
            &quot;category_id&quot;: 3,
            &quot;category&quot;: &quot;الحديث الشريف&quot;,
            &quot;store_name&quot;: &quot;Mushaf Home&quot;,
            &quot;rating&quot;: 0,
            &quot;rate_count&quot;: 0,
            &quot;sale_price&quot;: 136.8,
            &quot;discount_percentage&quot;: 20,
            &quot;item_code&quot;: &quot;OEB92MF0&quot;,
            &quot;images&quot;: [],
            &quot;isFavorite&quot;: false,
            &quot;countFavorite&quot;: 0,
            &quot;countOrder&quot;: 0,
            &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/92&quot;,
            &quot;product_rates&quot;: [],
            &quot;deal_of_day_end&quot;: null
        },
        {
            &quot;id&quot;: 93,
            &quot;name&quot;: &quot;شرح الأذكار الشامل&quot;,
            &quot;description&quot;: &quot;Voluptatem ut veniam harum laborum modi possimus. Aspernatur debitis saepe nam rem animi non. Odit ratione sint amet voluptate doloribus. شرح الأذكار الشامل&quot;,
            &quot;slug&quot;: &quot;shrh-alathkar-alshaml-93&quot;,
            &quot;meta_title&quot;: &quot;شرح الأذكار الشامل&quot;,
            &quot;meta_description&quot;: &quot;Magni perspiciatis aut quia illo.&quot;,
            &quot;sku&quot;: &quot;QPZ07G5P&quot;,
            &quot;price&quot;: 116,
            &quot;formatted_price&quot;: &quot;116.00 ج.م&quot;,
            &quot;special_price&quot;: 0,
            &quot;formatted_special_price&quot;: null,
            &quot;special_price_start&quot;: null,
            &quot;special_price_end&quot;: null,
            &quot;final_price&quot;: 116,
            &quot;formatted_final_price&quot;: &quot;116.00 ج.م&quot;,
            &quot;currency&quot;: {
                &quot;code&quot;: &quot;EGP&quot;,
                &quot;symbol&quot;: &quot;ج.م&quot;,
                &quot;exchange_rate&quot;: 1
            },
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
            &quot;gallery&quot;: [],
            &quot;categories&quot;: [],
            &quot;options&quot;: [
                {
                    &quot;id&quot;: 228,
                    &quot;option_id&quot;: 1,
                    &quot;name&quot;: &quot;الحجم&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 459,
                            &quot;option_value_id&quot;: 4,
                            &quot;value_name&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;quantity&quot;: 43,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;الحجم&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 459,
                            &quot;option_value_id&quot;: 4,
                            &quot;value_name&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;quantity&quot;: 43,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                },
                {
                    &quot;id&quot;: 229,
                    &quot;option_id&quot;: 3,
                    &quot;name&quot;: &quot;نوع الغلاف&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 460,
                            &quot;option_value_id&quot;: 12,
                            &quot;value_name&quot;: &quot;غلاف ورقي&quot;,
                            &quot;quantity&quot;: 15,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 50,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;غلاف ورقي&quot;,
                            &quot;difference_in_price&quot;: 50,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 461,
                            &quot;option_value_id&quot;: 13,
                            &quot;value_name&quot;: &quot;جلد ترمو&quot;,
                            &quot;quantity&quot;: 37,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;جلد ترمو&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;نوع الغلاف&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 460,
                            &quot;option_value_id&quot;: 12,
                            &quot;value_name&quot;: &quot;غلاف ورقي&quot;,
                            &quot;quantity&quot;: 15,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 50,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;غلاف ورقي&quot;,
                            &quot;difference_in_price&quot;: 50,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 461,
                            &quot;option_value_id&quot;: 13,
                            &quot;value_name&quot;: &quot;جلد ترمو&quot;,
                            &quot;quantity&quot;: 37,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;جلد ترمو&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                },
                {
                    &quot;id&quot;: 230,
                    &quot;option_id&quot;: 5,
                    &quot;name&quot;: &quot;لون الغلاف&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 462,
                            &quot;option_value_id&quot;: 19,
                            &quot;value_name&quot;: &quot;أخضر&quot;,
                            &quot;quantity&quot;: 18,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;أخضر&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;لون الغلاف&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 462,
                            &quot;option_value_id&quot;: 19,
                            &quot;value_name&quot;: &quot;أخضر&quot;,
                            &quot;quantity&quot;: 18,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;أخضر&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                }
            ],
            &quot;quantity&quot;: 61,
            &quot;max_order_qty&quot;: 10,
            &quot;ignore_quantity&quot;: false,
            &quot;is_best_seller&quot;: false,
            &quot;best_seller_start&quot;: null,
            &quot;best_seller_end&quot;: null,
            &quot;weight&quot;: 1.4,
            &quot;viewed&quot;: 2605,
            &quot;shipping_rule_id&quot;: 1,
            &quot;product_brand_id&quot;: 6,
            &quot;brand&quot;: {
                &quot;id&quot;: 6,
                &quot;name&quot;: &quot;عصير الكتب&quot;
            },
            &quot;has_flash_sale&quot;: false,
            &quot;flash_sale_price&quot;: null,
            &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
            &quot;title&quot;: &quot;شرح الأذكار الشامل&quot;,
            &quot;category_id&quot;: 1,
            &quot;category&quot;: &quot;كتب إسلامية&quot;,
            &quot;store_name&quot;: &quot;Mushaf Home&quot;,
            &quot;rating&quot;: 0,
            &quot;rate_count&quot;: 0,
            &quot;sale_price&quot;: 116,
            &quot;discount_percentage&quot;: 0,
            &quot;item_code&quot;: &quot;QPZ07G5P&quot;,
            &quot;images&quot;: [],
            &quot;isFavorite&quot;: false,
            &quot;countFavorite&quot;: 0,
            &quot;countOrder&quot;: 0,
            &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/93&quot;,
            &quot;product_rates&quot;: [],
            &quot;deal_of_day_end&quot;: null
        },
        {
            &quot;id&quot;: 94,
            &quot;name&quot;: &quot;تهذيب مسلم الجامع&quot;,
            &quot;description&quot;: &quot;Dignissimos autem velit et sint velit. Error quis molestiae doloribus quisquam similique modi non. Aperiam ut sunt aut amet aperiam qui. تهذيب مسلم الجامع&quot;,
            &quot;slug&quot;: &quot;ththyb-mslm-algamaa-94&quot;,
            &quot;meta_title&quot;: &quot;تهذيب مسلم الجامع&quot;,
            &quot;meta_description&quot;: &quot;Sint delectus iure placeat provident beatae sint cum enim.&quot;,
            &quot;sku&quot;: &quot;CBWFGZ5O&quot;,
            &quot;price&quot;: 204,
            &quot;formatted_price&quot;: &quot;204.00 ج.م&quot;,
            &quot;special_price&quot;: 0,
            &quot;formatted_special_price&quot;: null,
            &quot;special_price_start&quot;: null,
            &quot;special_price_end&quot;: null,
            &quot;final_price&quot;: 204,
            &quot;formatted_final_price&quot;: &quot;204.00 ج.م&quot;,
            &quot;currency&quot;: {
                &quot;code&quot;: &quot;EGP&quot;,
                &quot;symbol&quot;: &quot;ج.م&quot;,
                &quot;exchange_rate&quot;: 1
            },
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/book1.png&quot;,
            &quot;gallery&quot;: [],
            &quot;categories&quot;: [],
            &quot;options&quot;: [
                {
                    &quot;id&quot;: 231,
                    &quot;option_id&quot;: 1,
                    &quot;name&quot;: &quot;الحجم&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: true,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 463,
                            &quot;option_value_id&quot;: 4,
                            &quot;value_name&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;quantity&quot;: 38,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;الحجم&quot;,
                    &quot;isRequired&quot;: true,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 463,
                            &quot;option_value_id&quot;: 4,
                            &quot;value_name&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;quantity&quot;: 38,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;جوامعي (20x28)&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                },
                {
                    &quot;id&quot;: 232,
                    &quot;option_id&quot;: 3,
                    &quot;name&quot;: &quot;نوع الغلاف&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 464,
                            &quot;option_value_id&quot;: 15,
                            &quot;value_name&quot;: &quot;علبة&quot;,
                            &quot;quantity&quot;: 23,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 25,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;علبة&quot;,
                            &quot;difference_in_price&quot;: 25,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;نوع الغلاف&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 464,
                            &quot;option_value_id&quot;: 15,
                            &quot;value_name&quot;: &quot;علبة&quot;,
                            &quot;quantity&quot;: 23,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 25,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;علبة&quot;,
                            &quot;difference_in_price&quot;: 25,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                },
                {
                    &quot;id&quot;: 233,
                    &quot;option_id&quot;: 4,
                    &quot;name&quot;: &quot;نوع الورق&quot;,
                    &quot;type&quot;: &quot;single&quot;,
                    &quot;required&quot;: false,
                    &quot;values&quot;: [
                        {
                            &quot;id&quot;: 465,
                            &quot;option_value_id&quot;: 16,
                            &quot;value_name&quot;: &quot;شامواه (أصفر)&quot;,
                            &quot;quantity&quot;: 27,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 50,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;شامواه (أصفر)&quot;,
                            &quot;difference_in_price&quot;: 50,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 466,
                            &quot;option_value_id&quot;: 17,
                            &quot;value_name&quot;: &quot;أبيض&quot;,
                            &quot;quantity&quot;: 44,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;أبيض&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 467,
                            &quot;option_value_id&quot;: 18,
                            &quot;value_name&quot;: &quot;مقصع (Art)&quot;,
                            &quot;quantity&quot;: 19,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;مقصع (Art)&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ],
                    &quot;title&quot;: &quot;نوع الورق&quot;,
                    &quot;isRequired&quot;: false,
                    &quot;items&quot;: [
                        {
                            &quot;id&quot;: 465,
                            &quot;option_value_id&quot;: 16,
                            &quot;value_name&quot;: &quot;شامواه (أصفر)&quot;,
                            &quot;quantity&quot;: 27,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 50,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;شامواه (أصفر)&quot;,
                            &quot;difference_in_price&quot;: 50,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 466,
                            &quot;option_value_id&quot;: 17,
                            &quot;value_name&quot;: &quot;أبيض&quot;,
                            &quot;quantity&quot;: 44,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;أبيض&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        },
                        {
                            &quot;id&quot;: 467,
                            &quot;option_value_id&quot;: 18,
                            &quot;value_name&quot;: &quot;مقصع (Art)&quot;,
                            &quot;quantity&quot;: 19,
                            &quot;subtract_stock&quot;: true,
                            &quot;price&quot;: 0,
                            &quot;price_increment&quot;: true,
                            &quot;weight&quot;: 0,
                            &quot;weight_increment&quot;: true,
                            &quot;title&quot;: &quot;مقصع (Art)&quot;,
                            &quot;difference_in_price&quot;: 0,
                            &quot;difference_in_weight&quot;: 0,
                            &quot;ignore_quantity&quot;: false,
                            &quot;isPluse&quot;: true,
                            &quot;isMinus&quot;: false
                        }
                    ]
                }
            ],
            &quot;quantity&quot;: 56,
            &quot;max_order_qty&quot;: 10,
            &quot;ignore_quantity&quot;: false,
            &quot;is_best_seller&quot;: false,
            &quot;best_seller_start&quot;: null,
            &quot;best_seller_end&quot;: null,
            &quot;weight&quot;: 1.99,
            &quot;viewed&quot;: 2831,
            &quot;shipping_rule_id&quot;: 1,
            &quot;product_brand_id&quot;: 4,
            &quot;brand&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;دار المعرفة&quot;
            },
            &quot;has_flash_sale&quot;: false,
            &quot;flash_sale_price&quot;: null,
            &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/book1.png&quot;,
            &quot;title&quot;: &quot;تهذيب مسلم الجامع&quot;,
            &quot;category_id&quot;: 3,
            &quot;category&quot;: &quot;الحديث الشريف&quot;,
            &quot;store_name&quot;: &quot;Mushaf Home&quot;,
            &quot;rating&quot;: 0,
            &quot;rate_count&quot;: 0,
            &quot;sale_price&quot;: 204,
            &quot;discount_percentage&quot;: 0,
            &quot;item_code&quot;: &quot;CBWFGZ5O&quot;,
            &quot;images&quot;: [],
            &quot;isFavorite&quot;: false,
            &quot;countFavorite&quot;: 0,
            &quot;countOrder&quot;: 0,
            &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/94&quot;,
            &quot;product_rates&quot;: [],
            &quot;deal_of_day_end&quot;: null
        },
        {
            &quot;id&quot;: 95,
            &quot;name&quot;: &quot;متن السيرة النبوية الشامل&quot;,
            &quot;description&quot;: &quot;Ut perferendis eos hic. Officia cum quaerat possimus. متن السيرة النبوية الشامل&quot;,
            &quot;slug&quot;: &quot;mtn-alsyr-alnboy-alshaml-95&quot;,
            &quot;meta_title&quot;: &quot;متن السيرة النبوية الشامل&quot;,
            &quot;meta_description&quot;: &quot;Ipsam autem quae et velit et autem quia.&quot;,
            &quot;sku&quot;: &quot;J6NUBYTA&quot;,
            &quot;price&quot;: 455,
            &quot;formatted_price&quot;: &quot;455.00 ج.م&quot;,
            &quot;special_price&quot;: 0,
            &quot;formatted_special_price&quot;: null,
            &quot;special_price_start&quot;: null,
            &quot;special_price_end&quot;: null,
            &quot;final_price&quot;: 455,
            &quot;formatted_final_price&quot;: &quot;455.00 ج.م&quot;,
            &quot;currency&quot;: {
                &quot;code&quot;: &quot;EGP&quot;,
                &quot;symbol&quot;: &quot;ج.م&quot;,
                &quot;exchange_rate&quot;: 1
            },
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
            &quot;gallery&quot;: [],
            &quot;categories&quot;: [],
            &quot;options&quot;: [],
            &quot;quantity&quot;: 167,
            &quot;max_order_qty&quot;: 10,
            &quot;ignore_quantity&quot;: false,
            &quot;is_best_seller&quot;: false,
            &quot;best_seller_start&quot;: null,
            &quot;best_seller_end&quot;: null,
            &quot;weight&quot;: 1.65,
            &quot;viewed&quot;: 1731,
            &quot;shipping_rule_id&quot;: 1,
            &quot;product_brand_id&quot;: 1,
            &quot;brand&quot;: {
                &quot;id&quot;: 1,
                &quot;name&quot;: &quot;دار السلام&quot;
            },
            &quot;has_flash_sale&quot;: false,
            &quot;flash_sale_price&quot;: null,
            &quot;primary_image&quot;: &quot;http://127.0.0.1:8000/_fixed/quran1.png&quot;,
            &quot;title&quot;: &quot;متن السيرة النبوية الشامل&quot;,
            &quot;category_id&quot;: 7,
            &quot;category&quot;: &quot;روايات عربية&quot;,
            &quot;store_name&quot;: &quot;Mushaf Home&quot;,
            &quot;rating&quot;: 0,
            &quot;rate_count&quot;: 0,
            &quot;sale_price&quot;: 455,
            &quot;discount_percentage&quot;: 0,
            &quot;item_code&quot;: &quot;J6NUBYTA&quot;,
            &quot;images&quot;: [],
            &quot;isFavorite&quot;: false,
            &quot;countFavorite&quot;: 0,
            &quot;countOrder&quot;: 0,
            &quot;product_link&quot;: &quot;http://127.0.0.1:8000/products/95&quot;,
            &quot;product_rates&quot;: [],
            &quot;deal_of_day_end&quot;: null
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-latest-products" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-latest-products"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-latest-products"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-latest-products" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-latest-products">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-latest-products" data-method="GET"
      data-path="api/v1/latest-products"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-latest-products', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-latest-products"
                    onclick="tryItOut('GETapi-v1-latest-products');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-latest-products"
                    onclick="cancelTryOut('GETapi-v1-latest-products');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-latest-products"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/latest-products</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-latest-products"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-latest-products"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-v1-rate-product">POST api/v1/rate-product</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-rate-product">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/rate-product" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"product_id\": \"consequatur\",
    \"rating\": 3,
    \"comment\": \"qeopfuudtdsufvyvddqam\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/rate-product"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "product_id": "consequatur",
    "rating": 3,
    "comment": "qeopfuudtdsufvyvddqam"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-rate-product">
</span>
<span id="execution-results-POSTapi-v1-rate-product" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-rate-product"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-rate-product"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-rate-product" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-rate-product">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-rate-product" data-method="POST"
      data-path="api/v1/rate-product"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-rate-product', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-rate-product"
                    onclick="tryItOut('POSTapi-v1-rate-product');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-rate-product"
                    onclick="cancelTryOut('POSTapi-v1-rate-product');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-rate-product"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/rate-product</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-rate-product"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-rate-product"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>product_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="product_id"                data-endpoint="POSTapi-v1-rate-product"
               value="consequatur"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the products table. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>rating</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="rating"                data-endpoint="POSTapi-v1-rate-product"
               value="3"
               data-component="body">
    <br>
<p>Must be at least 1. Must not be greater than 5. Example: <code>3</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>comment</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="comment"                data-endpoint="POSTapi-v1-rate-product"
               value="qeopfuudtdsufvyvddqam"
               data-component="body">
    <br>
<p>Must not be greater than 500 characters. Example: <code>qeopfuudtdsufvyvddqam</code></p>
        </div>
        </form>

                <h1 id="general">General</h1>

    <p>APIs for general app settings and configuration.</p>

                                <h2 id="general-GETapi-v1-configuration">Get Configuration (Legacy)</h2>

<p>
</p>

<p>Specific endpoint for old Flutter app versions.</p>

<span id="example-requests-GETapi-v1-configuration">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/configuration" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/configuration"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-configuration">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 57
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;data&quot;: {
        &quot;social_login&quot;: {
            &quot;facebook&quot;: true,
            &quot;google&quot;: true
        },
        &quot;accept_sms&quot;: true,
        &quot;accept_email&quot;: true,
        &quot;maintenance&quot;: false,
        &quot;default_lang&quot;: &quot;ar&quot;,
        &quot;about&quot;: &quot;About Mushaf Home&quot;,
        &quot;privacy&quot;: &quot;Privacy Policy&quot;,
        &quot;terms&quot;: &quot;Terms &amp; Conditions&quot;,
        &quot;contact&quot;: &quot;01000000000&quot;,
        &quot;intro&quot;: [],
        &quot;splash&quot;: {
            &quot;title&quot;: &quot;Mushaf Home&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/logo.png&quot;
        },
        &quot;logo&quot;: &quot;http://127.0.0.1:8000/_fixed/logo.png&quot;,
        &quot;currencey&quot;: &quot;EGP&quot;
    },
    &quot;error&quot;: null,
    &quot;code&quot;: &quot;200&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-configuration" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-configuration"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-configuration"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-configuration" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-configuration">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-configuration" data-method="GET"
      data-path="api/v1/configuration"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-configuration', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-configuration"
                    onclick="tryItOut('GETapi-v1-configuration');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-configuration"
                    onclick="cancelTryOut('GETapi-v1-configuration');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-configuration"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/configuration</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-configuration"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-configuration"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="general-GETapi-v1-settings">Get Settings</h2>

<p>
</p>

<p>Returns the app settings and social links.</p>

<span id="example-requests-GETapi-v1-settings">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/settings" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/settings"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-settings">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 56
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;تمت العملية بنجاح&quot;,
    &quot;data&quot;: {
        &quot;app_name&quot;: &quot;Mushaf Home&quot;,
        &quot;app_meta_title&quot;: &quot;Mushaf Home - Default Title&quot;,
        &quot;app_meta_desc&quot;: &quot;Default Meta Description for Mushaf Home application.&quot;,
        &quot;logo&quot;: &quot;http://127.0.0.1:8000/_fixed/logo.png&quot;,
        &quot;logo_dark&quot;: &quot;http://127.0.0.1:8000/_fixed/logo.png&quot;,
        &quot;fav_icon&quot;: &quot;http://127.0.0.1:8000/_fixed/logo.png&quot;,
        &quot;address&quot;: &quot;Cairo, Egypt&quot;,
        &quot;phone&quot;: &quot;01000000000&quot;,
        &quot;contact_email&quot;: &quot;info@mushafhome.com&quot;,
        &quot;social_links&quot;: {
            &quot;facebook&quot;: &quot;https://facebook.com&quot;,
            &quot;instagram&quot;: &quot;https://instagram.com&quot;,
            &quot;twitter&quot;: &quot;https://twitter.com&quot;,
            &quot;youtube&quot;: &quot;https://youtube.com&quot;,
            &quot;whatsapp&quot;: &quot;01000000000&quot;,
            &quot;linkedin&quot;: &quot;https://linkedin.com&quot;
        },
        &quot;messages&quot;: {
            &quot;processing&quot;: null,
            &quot;shipped&quot;: null,
            &quot;completed&quot;: null,
            &quot;cancelled&quot;: null,
            &quot;delivered&quot;: null
        },
        &quot;gift_settings&quot;: {
            &quot;max_gift_items&quot;: 1,
            &quot;min_order_for_gift&quot;: 0
        }
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-settings" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-settings"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-settings"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-settings" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-settings">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-settings" data-method="GET"
      data-path="api/v1/settings"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-settings', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-settings"
                    onclick="tryItOut('GETapi-v1-settings');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-settings"
                    onclick="cancelTryOut('GETapi-v1-settings');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-settings"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/settings</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-settings"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-settings"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="general-GETapi-v1-advertisements">Get Advertisements</h2>

<p>
</p>

<p>Returns a list of active advertisements.</p>

<span id="example-requests-GETapi-v1-advertisements">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/advertisements?position=popup%2C+sidebar%2C+top_banner" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/advertisements"
);

const params = {
    "position": "popup, sidebar, top_banner",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-advertisements">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 52
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;تمت العملية بنجاح&quot;,
    &quot;data&quot;: []
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-advertisements" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-advertisements"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-advertisements"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-advertisements" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-advertisements">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-advertisements" data-method="GET"
      data-path="api/v1/advertisements"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-advertisements', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-advertisements"
                    onclick="tryItOut('GETapi-v1-advertisements');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-advertisements"
                    onclick="cancelTryOut('GETapi-v1-advertisements');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-advertisements"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/advertisements</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-advertisements"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-advertisements"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>position</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="position"                data-endpoint="GETapi-v1-advertisements"
               value="popup, sidebar, top_banner"
               data-component="query">
    <br>
<p>Filter by position. Example: <code>popup, sidebar, top_banner</code></p>
            </div>
                </form>

                    <h2 id="general-GETapi-v1-offers">Get Offers</h2>

<p>
</p>

<p>Returns a list of active offers.</p>

<span id="example-requests-GETapi-v1-offers">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/offers" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/offers"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-offers">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 51
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;تمت العملية بنجاح&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;name&quot;: &quot;القرآن الكريم&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/offers.jpg&quot;,
            &quot;link_type&quot;: null,
            &quot;link_id&quot;: null,
            &quot;category&quot;: null,
            &quot;filters&quot;: {
                &quot;flash_sale&quot;: 1
            },
            &quot;is_active&quot;: true,
            &quot;title&quot;: &quot;القرآن الكريم&quot;,
            &quot;slug&quot;: &quot;1&quot;
        },
        {
            &quot;id&quot;: 2,
            &quot;name&quot;: &quot;كتب إسلامية&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/offers.jpg&quot;,
            &quot;link_type&quot;: null,
            &quot;link_id&quot;: null,
            &quot;category&quot;: {
                &quot;id&quot;: 8,
                &quot;title&quot;: &quot;أدب عالمي&quot;,
                &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/subcategories.jpg&quot;,
                &quot;parent_id&quot;: 6,
                &quot;sub_categories&quot;: [],
                &quot;fixed&quot;: false
            },
            &quot;filters&quot;: {
                &quot;flash_sale&quot;: 1
            },
            &quot;is_active&quot;: true,
            &quot;title&quot;: &quot;كتب إسلامية&quot;,
            &quot;slug&quot;: &quot;2&quot;
        },
        {
            &quot;id&quot;: 3,
            &quot;name&quot;: &quot;الأدب والروايات&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/offers.jpg&quot;,
            &quot;link_type&quot;: null,
            &quot;link_id&quot;: null,
            &quot;category&quot;: null,
            &quot;filters&quot;: {
                &quot;flash_sale&quot;: 1
            },
            &quot;is_active&quot;: true,
            &quot;title&quot;: &quot;الأدب والروايات&quot;,
            &quot;slug&quot;: &quot;3&quot;
        },
        {
            &quot;id&quot;: 4,
            &quot;name&quot;: &quot;تطوير الذات&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/offers.jpg&quot;,
            &quot;link_type&quot;: null,
            &quot;link_id&quot;: null,
            &quot;category&quot;: null,
            &quot;filters&quot;: {
                &quot;flash_sale&quot;: 1
            },
            &quot;is_active&quot;: true,
            &quot;title&quot;: &quot;تطوير الذات&quot;,
            &quot;slug&quot;: &quot;4&quot;
        },
        {
            &quot;id&quot;: 5,
            &quot;name&quot;: &quot;التاريخ الإسلامي&quot;,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/offers.jpg&quot;,
            &quot;link_type&quot;: null,
            &quot;link_id&quot;: null,
            &quot;category&quot;: null,
            &quot;filters&quot;: {
                &quot;flash_sale&quot;: 1
            },
            &quot;is_active&quot;: true,
            &quot;title&quot;: &quot;التاريخ الإسلامي&quot;,
            &quot;slug&quot;: &quot;5&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-offers" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-offers"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-offers"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-offers" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-offers">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-offers" data-method="GET"
      data-path="api/v1/offers"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-offers', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-offers"
                    onclick="tryItOut('GETapi-v1-offers');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-offers"
                    onclick="cancelTryOut('GETapi-v1-offers');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-offers"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/offers</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-offers"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-offers"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="general-POSTapi-v1-contact-us">Contact Us</h2>

<p>
</p>

<p>Store a new contact message.</p>

<span id="example-requests-POSTapi-v1-contact-us">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/contact-us" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"John Doe\",
    \"email\": \"john@example.com\",
    \"phone\": \"01021456325\",
    \"subject\": \"Inquiry about products\",
    \"message\": \"I would like to know more about your services.\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/contact-us"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "01021456325",
    "subject": "Inquiry about products",
    "message": "I would like to know more about your services."
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-contact-us">
</span>
<span id="execution-results-POSTapi-v1-contact-us" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-contact-us"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-contact-us"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-contact-us" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-contact-us">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-contact-us" data-method="POST"
      data-path="api/v1/contact-us"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-contact-us', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-contact-us"
                    onclick="tryItOut('POSTapi-v1-contact-us');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-contact-us"
                    onclick="cancelTryOut('POSTapi-v1-contact-us');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-contact-us"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/contact-us</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-contact-us"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-contact-us"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-v1-contact-us"
               value="John Doe"
               data-component="body">
    <br>
<p>The name of the person. Example: <code>John Doe</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v1-contact-us"
               value="john@example.com"
               data-component="body">
    <br>
<p>The email address. Example: <code>john@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="POSTapi-v1-contact-us"
               value="01021456325"
               data-component="body">
    <br>
<p>ID of the person. Example: <code>01021456325</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>subject</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="subject"                data-endpoint="POSTapi-v1-contact-us"
               value="Inquiry about products"
               data-component="body">
    <br>
<p>The subject of the message. Example: <code>Inquiry about products</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>message</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="message"                data-endpoint="POSTapi-v1-contact-us"
               value="I would like to know more about your services."
               data-component="body">
    <br>
<p>The message content. Example: <code>I would like to know more about your services.</code></p>
        </div>
        </form>

                <h1 id="gifts">Gifts</h1>

    <p>APIs for managing and claiming gifts.</p>

                                <h2 id="gifts-GETapi-v1-gifts">Get Available Gifts</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns a list of available gifts for the authenticated user if their gift page is enabled.</p>

<span id="example-requests-GETapi-v1-gifts">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/gifts" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/gifts"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-gifts">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated&quot;,
    &quot;errors&quot;: null
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-gifts" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-gifts"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-gifts"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-gifts" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-gifts">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-gifts" data-method="GET"
      data-path="api/v1/gifts"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-gifts', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-gifts"
                    onclick="tryItOut('GETapi-v1-gifts');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-gifts"
                    onclick="cancelTryOut('GETapi-v1-gifts');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-gifts"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/gifts</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-gifts"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-gifts"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="gifts-POSTapi-v1-gifts-claim">Claim Gifts</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Allows the user to select and claim gifts.</p>

<span id="example-requests-POSTapi-v1-gifts-claim">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/gifts/claim" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"gift_ids\": [
        1,
        2
    ]
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/gifts/claim"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "gift_ids": [
        1,
        2
    ]
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-gifts-claim">
</span>
<span id="execution-results-POSTapi-v1-gifts-claim" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-gifts-claim"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-gifts-claim"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-gifts-claim" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-gifts-claim">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-gifts-claim" data-method="POST"
      data-path="api/v1/gifts/claim"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-gifts-claim', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-gifts-claim"
                    onclick="tryItOut('POSTapi-v1-gifts-claim');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-gifts-claim"
                    onclick="cancelTryOut('POSTapi-v1-gifts-claim');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-gifts-claim"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/gifts/claim</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-gifts-claim"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-gifts-claim"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>gift_ids</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="gift_ids[0]"                data-endpoint="POSTapi-v1-gifts-claim"
               data-component="body">
        <input type="text" style="display: none"
               name="gift_ids[1]"                data-endpoint="POSTapi-v1-gifts-claim"
               data-component="body">
    <br>
<p>The IDs of the selected gift products.</p>
        </div>
        </form>

                <h1 id="home">Home</h1>

    <p>APIs for home page components like sliders.</p>

                                <h2 id="home-GETapi-v1-sliders">Get Sliders</h2>

<p>
</p>

<p>Returns a list of active sliders with their translations and associated categories.</p>

<span id="example-requests-GETapi-v1-sliders">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/sliders" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/sliders"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-sliders">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 53
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;تمت العملية بنجاح&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/sliders.jpg&quot;,
            &quot;link_type&quot;: null,
            &quot;link_id&quot;: null,
            &quot;title&quot;: &quot;مرحباً بكم في مصحف هوم&quot;,
            &quot;description&quot;: &quot;&quot;,
            &quot;category&quot;: null,
            &quot;sort_order&quot;: 0,
            &quot;link&quot;: &quot;&quot;,
            &quot;category_id&quot;: null,
            &quot;category_title&quot;: &quot;&quot;,
            &quot;type&quot;: &quot;category&quot;
        },
        {
            &quot;id&quot;: 2,
            &quot;image&quot;: &quot;http://127.0.0.1:8000/_fixed/sliders.jpg&quot;,
            &quot;link_type&quot;: null,
            &quot;link_id&quot;: null,
            &quot;title&quot;: &quot;جديد المصاحف&quot;,
            &quot;description&quot;: &quot;&quot;,
            &quot;category&quot;: null,
            &quot;sort_order&quot;: 1,
            &quot;link&quot;: &quot;&quot;,
            &quot;category_id&quot;: null,
            &quot;category_title&quot;: &quot;&quot;,
            &quot;type&quot;: &quot;category&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-sliders" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-sliders"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-sliders"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-sliders" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-sliders">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-sliders" data-method="GET"
      data-path="api/v1/sliders"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-sliders', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-sliders"
                    onclick="tryItOut('GETapi-v1-sliders');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-sliders"
                    onclick="cancelTryOut('GETapi-v1-sliders');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-sliders"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/sliders</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-sliders"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-sliders"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                <h1 id="locations">Locations</h1>

    <p>APIs for retrieving countries, governorates, and cities.</p>

                                <h2 id="locations-GETapi-v1-countries">Get All Countries</h2>

<p>
</p>

<p>Returns a list of all active countries.</p>

<span id="example-requests-GETapi-v1-countries">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/countries" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/countries"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-countries">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 36
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;تمت العملية بنجاح&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;name&quot;: &quot;مصر&quot;,
            &quot;code&quot;: &quot;EG&quot;,
            &quot;phone_code&quot;: &quot;+20&quot;,
            &quot;image&quot;: null,
            &quot;is_active&quot;: true
        },
        {
            &quot;id&quot;: 2,
            &quot;name&quot;: &quot;السعودية&quot;,
            &quot;code&quot;: &quot;SA&quot;,
            &quot;phone_code&quot;: &quot;+966&quot;,
            &quot;image&quot;: null,
            &quot;is_active&quot;: true
        },
        {
            &quot;id&quot;: 3,
            &quot;name&quot;: &quot;الإمارات&quot;,
            &quot;code&quot;: &quot;AE&quot;,
            &quot;phone_code&quot;: &quot;+971&quot;,
            &quot;image&quot;: null,
            &quot;is_active&quot;: true
        },
        {
            &quot;id&quot;: 4,
            &quot;name&quot;: &quot;الكويت&quot;,
            &quot;code&quot;: &quot;KW&quot;,
            &quot;phone_code&quot;: &quot;+965&quot;,
            &quot;image&quot;: null,
            &quot;is_active&quot;: true
        },
        {
            &quot;id&quot;: 5,
            &quot;name&quot;: &quot;الولايات المتحدة&quot;,
            &quot;code&quot;: &quot;US&quot;,
            &quot;phone_code&quot;: &quot;+1&quot;,
            &quot;image&quot;: null,
            &quot;is_active&quot;: true
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-countries" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-countries"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-countries"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-countries" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-countries">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-countries" data-method="GET"
      data-path="api/v1/countries"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-countries', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-countries"
                    onclick="tryItOut('GETapi-v1-countries');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-countries"
                    onclick="cancelTryOut('GETapi-v1-countries');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-countries"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/countries</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-countries"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-countries"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="locations-GETapi-v1-governorates--country_id-">Get Governorates by Country</h2>

<p>
</p>

<p>Returns a list of governorates for a specific country.</p>

<span id="example-requests-GETapi-v1-governorates--country_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/governorates/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/governorates/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-governorates--country_id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 35
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;تمت العملية بنجاح&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;name&quot;: &quot;القاهرة&quot;
        },
        {
            &quot;id&quot;: 2,
            &quot;name&quot;: &quot;الجيزة&quot;
        },
        {
            &quot;id&quot;: 3,
            &quot;name&quot;: &quot;الإسكندرية&quot;
        },
        {
            &quot;id&quot;: 4,
            &quot;name&quot;: &quot;الدقهلية&quot;
        },
        {
            &quot;id&quot;: 5,
            &quot;name&quot;: &quot;البحر الأحمر&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-governorates--country_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-governorates--country_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-governorates--country_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-governorates--country_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-governorates--country_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-governorates--country_id-" data-method="GET"
      data-path="api/v1/governorates/{country_id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-governorates--country_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-governorates--country_id-"
                    onclick="tryItOut('GETapi-v1-governorates--country_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-governorates--country_id-"
                    onclick="cancelTryOut('GETapi-v1-governorates--country_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-governorates--country_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/governorates/{country_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-governorates--country_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-governorates--country_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>country_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="country_id"                data-endpoint="GETapi-v1-governorates--country_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the country. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="locations-GETapi-v1-cities--governorate_id-">Get Cities by Governorate</h2>

<p>
</p>

<p>Returns a list of cities for a specific governorate.</p>

<span id="example-requests-GETapi-v1-cities--governorate_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/cities/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/cities/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-cities--governorate_id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 34
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;تمت العملية بنجاح&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;name&quot;: &quot;مدينة نصر&quot;
        },
        {
            &quot;id&quot;: 2,
            &quot;name&quot;: &quot;المعادي&quot;
        },
        {
            &quot;id&quot;: 3,
            &quot;name&quot;: &quot;القاهرة الجديدة&quot;
        },
        {
            &quot;id&quot;: 4,
            &quot;name&quot;: &quot;مصر الجديدة&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-cities--governorate_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-cities--governorate_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-cities--governorate_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-cities--governorate_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-cities--governorate_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-cities--governorate_id-" data-method="GET"
      data-path="api/v1/cities/{governorate_id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-cities--governorate_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-cities--governorate_id-"
                    onclick="tryItOut('GETapi-v1-cities--governorate_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-cities--governorate_id-"
                    onclick="cancelTryOut('GETapi-v1-cities--governorate_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-cities--governorate_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/cities/{governorate_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-cities--governorate_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-cities--governorate_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>governorate_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="governorate_id"                data-endpoint="GETapi-v1-cities--governorate_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the governorate. Example: <code>1</code></p>
            </div>
                    </form>

                <h1 id="options">Options</h1>

    <p>APIs for fetching product options/attributes.</p>

                                <h2 id="options-GETapi-v1-products--id--options">Get Product Options</h2>

<p>
</p>

<p>Returns the specific options available for a product.</p>

<span id="example-requests-GETapi-v1-products--id--options">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/products/1/options" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/products/1/options"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-products--id--options">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 38
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;تمت العملية بنجاح&quot;,
    &quot;data&quot;: []
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-products--id--options" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-products--id--options"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-products--id--options"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-products--id--options" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-products--id--options">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-products--id--options" data-method="GET"
      data-path="api/v1/products/{id}/options"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-products--id--options', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-products--id--options"
                    onclick="tryItOut('GETapi-v1-products--id--options');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-products--id--options"
                    onclick="cancelTryOut('GETapi-v1-products--id--options');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-products--id--options"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/products/{id}/options</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-products--id--options"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-products--id--options"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-v1-products--id--options"
               value="1"
               data-component="url">
    <br>
<p>The ID of the product. Example: <code>1</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>product_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="product_id"                data-endpoint="GETapi-v1-products--id--options"
               value="17"
               data-component="url">
    <br>
<p>The ID of the product. Example: <code>17</code></p>
            </div>
                    </form>

                    <h2 id="options-GETapi-v1-options">Get All Options</h2>

<p>
</p>

<p>Returns a list of all available options and their values.</p>

<span id="example-requests-GETapi-v1-options">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/options" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/options"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-options">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 37
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;تمت العملية بنجاح&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;name&quot;: &quot;الحجم&quot;,
            &quot;type&quot;: &quot;single&quot;,
            &quot;values&quot;: [
                {
                    &quot;id&quot;: 1,
                    &quot;value&quot;: &quot;الجيب (10x14)&quot;
                },
                {
                    &quot;id&quot;: 2,
                    &quot;value&quot;: &quot;ربع (14x20)&quot;
                },
                {
                    &quot;id&quot;: 3,
                    &quot;value&quot;: &quot;عادي (17x24)&quot;
                },
                {
                    &quot;id&quot;: 4,
                    &quot;value&quot;: &quot;جوامعي (20x28)&quot;
                },
                {
                    &quot;id&quot;: 5,
                    &quot;value&quot;: &quot;تهجد (25x35)&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 2,
            &quot;name&quot;: &quot;الرواية&quot;,
            &quot;type&quot;: &quot;single&quot;,
            &quot;values&quot;: [
                {
                    &quot;id&quot;: 6,
                    &quot;value&quot;: &quot;حفص عن عاصم&quot;
                },
                {
                    &quot;id&quot;: 7,
                    &quot;value&quot;: &quot;ورش عن نافع&quot;
                },
                {
                    &quot;id&quot;: 8,
                    &quot;value&quot;: &quot;قالون عن نافع&quot;
                },
                {
                    &quot;id&quot;: 9,
                    &quot;value&quot;: &quot;الدوري عن أبي عمرو&quot;
                },
                {
                    &quot;id&quot;: 10,
                    &quot;value&quot;: &quot;شعبة عن عاصم&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 3,
            &quot;name&quot;: &quot;نوع الغلاف&quot;,
            &quot;type&quot;: &quot;single&quot;,
            &quot;values&quot;: [
                {
                    &quot;id&quot;: 11,
                    &quot;value&quot;: &quot;مجلد كرتون&quot;
                },
                {
                    &quot;id&quot;: 12,
                    &quot;value&quot;: &quot;غلاف ورقي&quot;
                },
                {
                    &quot;id&quot;: 13,
                    &quot;value&quot;: &quot;جلد ترمو&quot;
                },
                {
                    &quot;id&quot;: 14,
                    &quot;value&quot;: &quot;قطيفة&quot;
                },
                {
                    &quot;id&quot;: 15,
                    &quot;value&quot;: &quot;علبة&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 4,
            &quot;name&quot;: &quot;نوع الورق&quot;,
            &quot;type&quot;: &quot;single&quot;,
            &quot;values&quot;: [
                {
                    &quot;id&quot;: 16,
                    &quot;value&quot;: &quot;شامواه (أصفر)&quot;
                },
                {
                    &quot;id&quot;: 17,
                    &quot;value&quot;: &quot;أبيض&quot;
                },
                {
                    &quot;id&quot;: 18,
                    &quot;value&quot;: &quot;مقصع (Art)&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 5,
            &quot;name&quot;: &quot;لون الغلاف&quot;,
            &quot;type&quot;: &quot;single&quot;,
            &quot;values&quot;: [
                {
                    &quot;id&quot;: 19,
                    &quot;value&quot;: &quot;أخضر&quot;
                },
                {
                    &quot;id&quot;: 20,
                    &quot;value&quot;: &quot;أزرق&quot;
                },
                {
                    &quot;id&quot;: 21,
                    &quot;value&quot;: &quot;أحمر/نبيتي&quot;
                },
                {
                    &quot;id&quot;: 22,
                    &quot;value&quot;: &quot;أسود&quot;
                },
                {
                    &quot;id&quot;: 23,
                    &quot;value&quot;: &quot;بني&quot;
                }
            ]
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-options" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-options"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-options"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-options" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-options">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-options" data-method="GET"
      data-path="api/v1/options"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-options', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-options"
                    onclick="tryItOut('GETapi-v1-options');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-options"
                    onclick="cancelTryOut('GETapi-v1-options');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-options"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/options</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-options"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-options"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                <h1 id="order-services">Order Services</h1>

    <p>APIs for retrieving available order services like gift wrapping.</p>

                                <h2 id="order-services-GETapi-v1-order-services">Get All Order Services</h2>

<p>
</p>

<p>Returns a list of all active order services.</p>

<span id="example-requests-GETapi-v1-order-services">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/order-services" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/order-services"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-order-services">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 55
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;تمت العملية بنجاح&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;name&quot;: &quot;تغليف هدايا&quot;,
            &quot;price&quot;: 50,
            &quot;is_active&quot;: true
        },
        {
            &quot;id&quot;: 2,
            &quot;name&quot;: &quot;كارت إهداء&quot;,
            &quot;price&quot;: 20,
            &quot;is_active&quot;: true
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-order-services" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-order-services"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-order-services"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-order-services" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-order-services">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-order-services" data-method="GET"
      data-path="api/v1/order-services"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-order-services', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-order-services"
                    onclick="tryItOut('GETapi-v1-order-services');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-order-services"
                    onclick="cancelTryOut('GETapi-v1-order-services');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-order-services"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/order-services</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-order-services"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-order-services"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                <h1 id="payment-methods">Payment Methods</h1>

    <p>APIs for retrieving available payment methods.</p>

                                <h2 id="payment-methods-GETapi-v1-payment-methods">Get All Payment Methods</h2>

<p>
</p>

<p>Returns a list of all active payment methods.</p>

<span id="example-requests-GETapi-v1-payment-methods">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/payment-methods" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/payment-methods"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-payment-methods">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 54
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;تمت العملية بنجاح&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;name&quot;: &quot;الدفع عند الاستلام&quot;,
            &quot;description&quot;: &quot;ادفع عند استلام الطلب.&quot;,
            &quot;image&quot;: null,
            &quot;tax&quot;: 0,
            &quot;is_active&quot;: true
        },
        {
            &quot;id&quot;: 2,
            &quot;name&quot;: &quot;بطاقة ائتمان&quot;,
            &quot;description&quot;: &quot;ادفع بأمان باستخدام بطاقتك الائتمانية.&quot;,
            &quot;image&quot;: null,
            &quot;tax&quot;: 2.5,
            &quot;is_active&quot;: true
        },
        {
            &quot;id&quot;: 3,
            &quot;name&quot;: &quot;فاليو&quot;,
            &quot;description&quot;: &quot;اشترِ الآن وادفع لاحقاً مع فاليو.&quot;,
            &quot;image&quot;: null,
            &quot;tax&quot;: 1.5,
            &quot;is_active&quot;: true
        },
        {
            &quot;id&quot;: 4,
            &quot;name&quot;: &quot;فودافون كاش&quot;,
            &quot;description&quot;: &quot;ادفع عن طريق محفظة فودافون كاش.&quot;,
            &quot;image&quot;: null,
            &quot;tax&quot;: 0,
            &quot;is_active&quot;: true
        },
        {
            &quot;id&quot;: 5,
            &quot;name&quot;: &quot;انستا باي&quot;,
            &quot;description&quot;: &quot;ادفع عن طريق انستا باي.&quot;,
            &quot;image&quot;: null,
            &quot;tax&quot;: 0,
            &quot;is_active&quot;: true
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-payment-methods" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-payment-methods"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-payment-methods"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-payment-methods" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-payment-methods">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-payment-methods" data-method="GET"
      data-path="api/v1/payment-methods"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-payment-methods', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-payment-methods"
                    onclick="tryItOut('GETapi-v1-payment-methods');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-payment-methods"
                    onclick="cancelTryOut('GETapi-v1-payment-methods');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-payment-methods"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/payment-methods</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-payment-methods"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-payment-methods"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                <h1 id="user-addresses">User Addresses</h1>

    <p>APIs for managing user addresses</p>

                                <h2 id="user-addresses-GETapi-v1-addresses">Get Addresses</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Get all addresses for the authenticated user.</p>

<span id="example-requests-GETapi-v1-addresses">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/addresses" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/addresses"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-addresses">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated&quot;,
    &quot;errors&quot;: null
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-addresses" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-addresses"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-addresses"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-addresses" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-addresses">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-addresses" data-method="GET"
      data-path="api/v1/addresses"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-addresses', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-addresses"
                    onclick="tryItOut('GETapi-v1-addresses');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-addresses"
                    onclick="cancelTryOut('GETapi-v1-addresses');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-addresses"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/addresses</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-addresses"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-addresses"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="user-addresses-POSTapi-v1-addresses">Add Address</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Add a new address for the authenticated user.</p>

<span id="example-requests-POSTapi-v1-addresses">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/addresses" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Home\",
    \"country_id\": 1,
    \"governorate_id\": 1,
    \"city_id\": 1,
    \"address\": \"123 Street Name\",
    \"phone\": \"01021456325\",
    \"lat\": \"30.0444\",
    \"lng\": \"31.2357\",
    \"is_main\": true
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/addresses"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Home",
    "country_id": 1,
    "governorate_id": 1,
    "city_id": 1,
    "address": "123 Street Name",
    "phone": "01021456325",
    "lat": "30.0444",
    "lng": "31.2357",
    "is_main": true
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-addresses">
</span>
<span id="execution-results-POSTapi-v1-addresses" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-addresses"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-addresses"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-addresses" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-addresses">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-addresses" data-method="POST"
      data-path="api/v1/addresses"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-addresses', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-addresses"
                    onclick="tryItOut('POSTapi-v1-addresses');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-addresses"
                    onclick="cancelTryOut('POSTapi-v1-addresses');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-addresses"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/addresses</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-addresses"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-addresses"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-v1-addresses"
               value="Home"
               data-component="body">
    <br>
<p>The name for the address (e.g., Home, Work). Example: <code>Home</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>country_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="country_id"                data-endpoint="POSTapi-v1-addresses"
               value="1"
               data-component="body">
    <br>
<p>The country ID. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>governorate_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="governorate_id"                data-endpoint="POSTapi-v1-addresses"
               value="1"
               data-component="body">
    <br>
<p>The governorate ID. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>city_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="city_id"                data-endpoint="POSTapi-v1-addresses"
               value="1"
               data-component="body">
    <br>
<p>The city ID. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>address</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="address"                data-endpoint="POSTapi-v1-addresses"
               value="123 Street Name"
               data-component="body">
    <br>
<p>The full address details. Example: <code>123 Street Name</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="POSTapi-v1-addresses"
               value="01021456325"
               data-component="body">
    <br>
<p>Phone number for this address. Example: <code>01021456325</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>lat</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="lat"                data-endpoint="POSTapi-v1-addresses"
               value="30.0444"
               data-component="body">
    <br>
<p>Optional latitude. Example: <code>30.0444</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>lng</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="lng"                data-endpoint="POSTapi-v1-addresses"
               value="31.2357"
               data-component="body">
    <br>
<p>Optional longitude. Example: <code>31.2357</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_main</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-v1-addresses" style="display: none">
            <input type="radio" name="is_main"
                   value="true"
                   data-endpoint="POSTapi-v1-addresses"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-v1-addresses" style="display: none">
            <input type="radio" name="is_main"
                   value="false"
                   data-endpoint="POSTapi-v1-addresses"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Set as main address. Example: <code>true</code></p>
        </div>
        </form>

                    <h2 id="user-addresses-POSTapi-v1-addresses--id-">Update Address</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Update an existing address.</p>

<span id="example-requests-POSTapi-v1-addresses--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/addresses/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"vmqeopfuudtdsufvyvddq\",
    \"address\": \"consequatur\",
    \"phone\": \"consequatur\",
    \"lat\": \"consequatur\",
    \"lng\": \"consequatur\",
    \"is_main\": false
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/addresses/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "vmqeopfuudtdsufvyvddq",
    "address": "consequatur",
    "phone": "consequatur",
    "lat": "consequatur",
    "lng": "consequatur",
    "is_main": false
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-addresses--id-">
</span>
<span id="execution-results-POSTapi-v1-addresses--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-addresses--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-addresses--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-addresses--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-addresses--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-addresses--id-" data-method="POST"
      data-path="api/v1/addresses/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-addresses--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-addresses--id-"
                    onclick="tryItOut('POSTapi-v1-addresses--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-addresses--id-"
                    onclick="cancelTryOut('POSTapi-v1-addresses--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-addresses--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/addresses/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-addresses--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-addresses--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="POSTapi-v1-addresses--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the address. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-v1-addresses--id-"
               value="vmqeopfuudtdsufvyvddq"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>vmqeopfuudtdsufvyvddq</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>country_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="country_id"                data-endpoint="POSTapi-v1-addresses--id-"
               value=""
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the countries table.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>governorate_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="governorate_id"                data-endpoint="POSTapi-v1-addresses--id-"
               value=""
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the governorates table.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>city_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="city_id"                data-endpoint="POSTapi-v1-addresses--id-"
               value=""
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the cities table.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>address</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="address"                data-endpoint="POSTapi-v1-addresses--id-"
               value="consequatur"
               data-component="body">
    <br>
<p>Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="POSTapi-v1-addresses--id-"
               value="consequatur"
               data-component="body">
    <br>
<p>Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>lat</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="lat"                data-endpoint="POSTapi-v1-addresses--id-"
               value="consequatur"
               data-component="body">
    <br>
<p>Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>lng</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="lng"                data-endpoint="POSTapi-v1-addresses--id-"
               value="consequatur"
               data-component="body">
    <br>
<p>Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_main</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-v1-addresses--id-" style="display: none">
            <input type="radio" name="is_main"
                   value="true"
                   data-endpoint="POSTapi-v1-addresses--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-v1-addresses--id-" style="display: none">
            <input type="radio" name="is_main"
                   value="false"
                   data-endpoint="POSTapi-v1-addresses--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>false</code></p>
        </div>
        </form>

                    <h2 id="user-addresses-DELETEapi-v1-addresses--id-">Delete Address</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Delete an address.</p>

<span id="example-requests-DELETEapi-v1-addresses--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://127.0.0.1:8000/api/v1/addresses/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/addresses/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-v1-addresses--id-">
</span>
<span id="execution-results-DELETEapi-v1-addresses--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-v1-addresses--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-v1-addresses--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-v1-addresses--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-v1-addresses--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-v1-addresses--id-" data-method="DELETE"
      data-path="api/v1/addresses/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-v1-addresses--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-v1-addresses--id-"
                    onclick="tryItOut('DELETEapi-v1-addresses--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-v1-addresses--id-"
                    onclick="cancelTryOut('DELETEapi-v1-addresses--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-v1-addresses--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/v1/addresses/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-v1-addresses--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-v1-addresses--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-v1-addresses--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the address. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="user-addresses-POSTapi-v1-addresses--id--set-main">Set Main Address</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Set a specific address as the main address for the user.</p>

<span id="example-requests-POSTapi-v1-addresses--id--set-main">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/addresses/1/set-main" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/addresses/1/set-main"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-addresses--id--set-main">
</span>
<span id="execution-results-POSTapi-v1-addresses--id--set-main" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-addresses--id--set-main"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-addresses--id--set-main"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-addresses--id--set-main" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-addresses--id--set-main">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-addresses--id--set-main" data-method="POST"
      data-path="api/v1/addresses/{id}/set-main"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-addresses--id--set-main', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-addresses--id--set-main"
                    onclick="tryItOut('POSTapi-v1-addresses--id--set-main');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-addresses--id--set-main"
                    onclick="cancelTryOut('POSTapi-v1-addresses--id--set-main');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-addresses--id--set-main"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/addresses/{id}/set-main</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-addresses--id--set-main"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-addresses--id--set-main"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="POSTapi-v1-addresses--id--set-main"
               value="1"
               data-component="url">
    <br>
<p>The ID of the address. Example: <code>1</code></p>
            </div>
                    </form>

                <h1 id="user-orders">User Orders</h1>

    <p>APIs for managing and viewing user orders.</p>

                                <h2 id="user-orders-GETapi-v1-orders">Get User Orders</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns a paginated list of orders for the authenticated user.</p>

<span id="example-requests-GETapi-v1-orders">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/orders?status=pending&amp;type=regular" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/orders"
);

const params = {
    "status": "pending",
    "type": "regular",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-orders">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated&quot;,
    &quot;errors&quot;: null
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-orders" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-orders"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-orders"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-orders" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-orders">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-orders" data-method="GET"
      data-path="api/v1/orders"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-orders', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-orders"
                    onclick="tryItOut('GETapi-v1-orders');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-orders"
                    onclick="cancelTryOut('GETapi-v1-orders');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-orders"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/orders</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-orders"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-orders"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="status"                data-endpoint="GETapi-v1-orders"
               value="pending"
               data-component="query">
    <br>
<p>Filter by status (e.g., pending, processing, completed, all). Example: <code>pending</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="type"                data-endpoint="GETapi-v1-orders"
               value="regular"
               data-component="query">
    <br>
<p>Filter by type (regular or gift). Example: <code>regular</code></p>
            </div>
                </form>

                    <h2 id="user-orders-GETapi-v1-orders--id-">Get Order Details</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns detailed information about a specific order.</p>

<span id="example-requests-GETapi-v1-orders--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/orders/17" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/orders/17"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-orders--id-">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated&quot;,
    &quot;errors&quot;: null
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-orders--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-orders--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-orders--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-orders--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-orders--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-orders--id-" data-method="GET"
      data-path="api/v1/orders/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-orders--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-orders--id-"
                    onclick="tryItOut('GETapi-v1-orders--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-orders--id-"
                    onclick="cancelTryOut('GETapi-v1-orders--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-orders--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/orders/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-orders--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-orders--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-v1-orders--id-"
               value="17"
               data-component="url">
    <br>
<p>The ID of the order. Example: <code>17</code></p>
            </div>
                    </form>

                    <h2 id="user-orders-POSTapi-v1-cancel-order">Cancel Order</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTapi-v1-cancel-order">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/cancel-order" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/cancel-order"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-cancel-order">
</span>
<span id="execution-results-POSTapi-v1-cancel-order" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-cancel-order"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-cancel-order"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-cancel-order" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-cancel-order">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-cancel-order" data-method="POST"
      data-path="api/v1/cancel-order"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-cancel-order', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-cancel-order"
                    onclick="tryItOut('POSTapi-v1-cancel-order');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-cancel-order"
                    onclick="cancelTryOut('POSTapi-v1-cancel-order');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-cancel-order"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/cancel-order</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-cancel-order"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-cancel-order"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="POSTapi-v1-cancel-order"
               value="17"
               data-component="url">
    <br>
<p>The ID of the order. Example: <code>17</code></p>
            </div>
                    </form>

                <h1 id="user-profile">User Profile</h1>

    <p>APIs for managing the authenticated user's profile.</p>

                                <h2 id="user-profile-GETapi-v1-profile">Get Profile</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Get the authenticated user's profile information.</p>

<span id="example-requests-GETapi-v1-profile">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/profile" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/profile"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-profile">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated&quot;,
    &quot;errors&quot;: null
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-profile" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-profile"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-profile"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-profile" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-profile">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-profile" data-method="GET"
      data-path="api/v1/profile"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-profile', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-profile"
                    onclick="tryItOut('GETapi-v1-profile');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-profile"
                    onclick="cancelTryOut('GETapi-v1-profile');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-profile"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/profile</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-profile"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-profile"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="user-profile-POSTapi-v1-profile">Update Profile</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Update the authenticated user's profile information.</p>

<span id="example-requests-POSTapi-v1-profile">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/profile" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"consequatur\",
    \"email\": \"qkunze@example.com\",
    \"phone\": \"consequatur\",
    \"country_id\": 17,
    \"password\": \"O[2UZ5ij-e\\/dl4m{o,\",
    \"password_confirmation\": \"consequatur\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/profile"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "consequatur",
    "email": "qkunze@example.com",
    "phone": "consequatur",
    "country_id": 17,
    "password": "O[2UZ5ij-e\/dl4m{o,",
    "password_confirmation": "consequatur"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-profile">
</span>
<span id="execution-results-POSTapi-v1-profile" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-profile"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-profile"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-profile" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-profile">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-profile" data-method="POST"
      data-path="api/v1/profile"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-profile', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-profile"
                    onclick="tryItOut('POSTapi-v1-profile');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-profile"
                    onclick="cancelTryOut('POSTapi-v1-profile');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-profile"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/profile</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-profile"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-profile"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-v1-profile"
               value="consequatur"
               data-component="body">
    <br>
<p>Optional new name. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v1-profile"
               value="qkunze@example.com"
               data-component="body">
    <br>
<p>Optional new email. Example: <code>qkunze@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="POSTapi-v1-profile"
               value="consequatur"
               data-component="body">
    <br>
<p>Optional new phone number. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>country_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="country_id"                data-endpoint="POSTapi-v1-profile"
               value="17"
               data-component="body">
    <br>
<p>Optional new country ID. Example: <code>17</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-v1-profile"
               value="O[2UZ5ij-e/dl4m{o,"
               data-component="body">
    <br>
<p>Optional new password. Example: <code>O[2UZ5ij-e/dl4m{o,</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password_confirmation</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password_confirmation"                data-endpoint="POSTapi-v1-profile"
               value="consequatur"
               data-component="body">
    <br>
<p>Required if password is provided. Example: <code>consequatur</code></p>
        </div>
        </form>

                    <h2 id="user-profile-POSTapi-v1-update-fcm-token">Update FCM Token</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Update the authenticated user's FCM token.</p>

<span id="example-requests-POSTapi-v1-update-fcm-token">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/update-fcm-token" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"fcm_token\": \"consequatur\",
    \"device_id\": \"consequatur\",
    \"device_type\": \"consequatur\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/update-fcm-token"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "fcm_token": "consequatur",
    "device_id": "consequatur",
    "device_type": "consequatur"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-update-fcm-token">
</span>
<span id="execution-results-POSTapi-v1-update-fcm-token" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-update-fcm-token"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-update-fcm-token"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-update-fcm-token" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-update-fcm-token">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-update-fcm-token" data-method="POST"
      data-path="api/v1/update-fcm-token"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-update-fcm-token', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-update-fcm-token"
                    onclick="tryItOut('POSTapi-v1-update-fcm-token');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-update-fcm-token"
                    onclick="cancelTryOut('POSTapi-v1-update-fcm-token');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-update-fcm-token"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/update-fcm-token</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-update-fcm-token"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-update-fcm-token"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>fcm_token</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="fcm_token"                data-endpoint="POSTapi-v1-update-fcm-token"
               value="consequatur"
               data-component="body">
    <br>
<p>New FCM token. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>device_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="device_id"                data-endpoint="POSTapi-v1-update-fcm-token"
               value="consequatur"
               data-component="body">
    <br>
<p>Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>device_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="device_type"                data-endpoint="POSTapi-v1-update-fcm-token"
               value="consequatur"
               data-component="body">
    <br>
<p>Example: <code>consequatur</code></p>
        </div>
        </form>

                <h1 id="wishlist">Wishlist</h1>

    <p>APIs for managing the user wishlist</p>

                                <h2 id="wishlist-GETapi-v1-wishlist">Get Wishlist Items</h2>

<p>
</p>

<p>Get all products in the wishlist for the authenticated user or guest.</p>

<span id="example-requests-GETapi-v1-wishlist">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/wishlist" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"temp_user_id\": \"guest_123\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/wishlist"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "temp_user_id": "guest_123"
};

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-wishlist">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 32
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;تمت العملية بنجاح&quot;,
    &quot;data&quot;: []
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-wishlist" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-wishlist"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-wishlist"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-wishlist" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-wishlist">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-wishlist" data-method="GET"
      data-path="api/v1/wishlist"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-wishlist', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-wishlist"
                    onclick="tryItOut('GETapi-v1-wishlist');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-wishlist"
                    onclick="cancelTryOut('GETapi-v1-wishlist');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-wishlist"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/wishlist</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-wishlist"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-wishlist"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>temp_user_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="temp_user_id"                data-endpoint="GETapi-v1-wishlist"
               value="guest_123"
               data-component="body">
    <br>
<p>Optional. Required if user is not authenticated. Example: <code>guest_123</code></p>
        </div>
        </form>

                    <h2 id="wishlist-POSTapi-v1-wishlist-toggle">Toggle Wishlist</h2>

<p>
</p>

<p>Add or remove a product from the wishlist.</p>

<span id="example-requests-POSTapi-v1-wishlist-toggle">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/wishlist/toggle" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"product_id\": 1,
    \"temp_user_id\": \"guest_123\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/wishlist/toggle"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "product_id": 1,
    "temp_user_id": "guest_123"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-wishlist-toggle">
</span>
<span id="execution-results-POSTapi-v1-wishlist-toggle" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-wishlist-toggle"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-wishlist-toggle"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-wishlist-toggle" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-wishlist-toggle">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-wishlist-toggle" data-method="POST"
      data-path="api/v1/wishlist/toggle"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-wishlist-toggle', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-wishlist-toggle"
                    onclick="tryItOut('POSTapi-v1-wishlist-toggle');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-wishlist-toggle"
                    onclick="cancelTryOut('POSTapi-v1-wishlist-toggle');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-wishlist-toggle"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/wishlist/toggle</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-wishlist-toggle"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-wishlist-toggle"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>product_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="product_id"                data-endpoint="POSTapi-v1-wishlist-toggle"
               value="1"
               data-component="body">
    <br>
<p>The ID of the product. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>temp_user_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="temp_user_id"                data-endpoint="POSTapi-v1-wishlist-toggle"
               value="guest_123"
               data-component="body">
    <br>
<p>Optional. Required if user is not authenticated. Example: <code>guest_123</code></p>
        </div>
        </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
