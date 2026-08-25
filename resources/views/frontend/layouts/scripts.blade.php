<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" ></script>
<script src="{{ asset('website/js/ar/swiper.js') }}?v={{ $v ?? '1.0.3' }}"></script>
<script src="{{ asset('website/js/ar/main.js') }}?v={{ $v ?? '1.0.3' }}"></script>
<script>
    window.addEventListener('scroll', function() {
        const header = document.querySelector('.elegant-fixed-top');
        if (!header) return;
        
        if (window.scrollY > 150) {
            header.classList.add('is-sticky');
        } else {
            header.classList.remove('is-sticky');
        }
    });

    // --- Live Search Logic ---
    let searchTimer;
    $('#headerSearch').on('input', function() {
        clearTimeout(searchTimer);
        let query = $(this).val();
        let resultsBox = $('#liveSearchResults');

        if (query.length < 2) {
            resultsBox.removeClass('active').html('');
            return;
        }

        searchTimer = setTimeout(function() {
            $.ajax({
                url: "{{ route('frontend.products.live_search') }}",
                data: { search: query },
                method: 'GET',
                success: function(data) {
                    let html = '';
                    if (data.length > 0) {
                        data.forEach(function(product) {
                            html += `
                                <a href="${product.url}" class="result-item">
                                    <img src="${product.image}" class="result-img">
                                    <div class="result-info">
                                        <span class="result-name">${product.name}</span>
                                        <span class="result-price">${product.price}</span>
                                    </div>
                                </a>
                            `;
                        });
                        html += `<a href="{{ route('frontend.products.index') }}?search=${query}" class="view-all">{{ trans_db('website.View') }} جميع النتائج لـ "${query}"</a>`;
                    } else {
                        html = '<div class="no-results">{{ trans_db('website.No matching results') }}</div>';
                    }
                    resultsBox.addClass('active').html(html);
                }
            });
        }, 300);
    });

    // Close search on click outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.elegant-search-form').length) {
            $('#liveSearchResults').removeClass('active');
        }
    });
</script>


        
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" ></script>

<script>
    // Existing Swiper script
    window.addEventListener('load', function() {
        if (typeof Swiper !== 'undefined') {
            // ... existing swiper init ...
             new Swiper('.main-swiper', {
                loop: true,
                speed: 800,
                spaceBetween: 0,
                slidesPerView: 1,
                effect: 'slide',
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.vibe-main-slider .swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.vibe-main-slider .swiper-button-next',
                    prevEl: '.vibe-main-slider .swiper-button-prev',
                },
            });

            // Brands Swiper
            new Swiper('.brands-swiper', {
                slidesPerView: 'auto',
                spaceBetween: 10,
                loop: true,
                speed: 3000,
                autoplay: {
                    delay: 0,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                freeMode: true,
            });

            // Icon Boxes Ticker Swiper (Mobile Only)
            new Swiper('.icon-boxes-swiper', {
                slidesPerView: 'auto',
                spaceBetween: 10,
                loop: true,
                speed: 3000,
                autoplay: {
                    delay: 0,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: false, 
                },
                freeMode: true,
                allowTouchMove: false, // Make it purely a ticker if desired, or allow drag
            });
        }

        // Enhanced Drag to Scroll implementation for grids
        const scrollSliders = document.querySelectorAll('.subcat-grid, .vibe-category-grid');
        scrollSliders.forEach(slider => {
            if(slider) {
                let isDown = false;
                let startX;
                let scrollLeft;
                let moved = false;

                slider.addEventListener('mousedown', (e) => {
                    isDown = true;
                    moved = false; // Reset movement flag
                    slider.classList.add('active');
                    startX = e.pageX - slider.offsetLeft;
                    scrollLeft = slider.scrollLeft;
                    slider.style.cursor = 'grabbing';
                });

                slider.addEventListener('mouseleave', () => {
                    isDown = false;
                    slider.classList.remove('active');
                    slider.style.cursor = 'grab';
                });

                slider.addEventListener('mouseup', (e) => {
                    isDown = false;
                    slider.classList.remove('active');
                    slider.style.cursor = 'grab';
                });

                // Prevent click navigation if we actually moved the mouse during drag
                slider.addEventListener('click', (e) => {
                    if (moved) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                }, true);

                slider.addEventListener('mousemove', (e) => {
                    if(!isDown) return;
                    
                    const x = e.pageX - slider.offsetLeft;
                    const walk = (x - startX) * 2; // scroll-fast
                    
                    if (Math.abs(x - startX) > 5) {
                        moved = true; // Flag that we are intentionally dragging
                        e.preventDefault(); // Prevent default only when moving
                    }
                    
                    slider.scrollLeft = scrollLeft - walk;
                });
            }
        });
    });


    // Cart and Wishlist Logic (jQuery)
    $(document).ready(function() {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Function to update cart UI (swapping buttons)
        function updateCartUI(productId, quantity, container) {
            const card = container.closest('.v-card, .item-row');
            const indicators = card.find('.v-status-indicators');

            if (quantity > 0) {
                // Show quantity control if not already there
                if (container.find('.qty-control').length === 0) {
                    container.find('.v-add-btn').replaceWith(`
                        <div class="qty-control" data-id="${productId}">
                            <button class="qty-btn plus" data-id="${productId}">+</button>
                            <span class="qty-display">${quantity}</span>
                            <button class="qty-btn minus" data-id="${productId}">-</button>
                        </div>
                    `);
                } else {
                    container.find('.qty-display').text(quantity);
                }

                // Add status dot if not exists (for cards)
                if (indicators.length && indicators.find('.cart-dot').length === 0) {
                    indicators.append('<span class="v-status-dot cart-dot" title="{{ trans_db('website.In Cart') }}"><i class="fa-solid fa-check"></i></span>');
                }
            } else {
                // Show Add to Cart button
                if (container.hasClass('item-qty-col')) {
                    container.find('.qty-control').replaceWith(`
                        <button class="btn-shop-now v-add-btn" data-id="${productId}" style="padding: 10px 20px; width: auto; border-radius: 8px;">
                            {{ trans_db('website.Add to Cart') }}
                        </button>
                    `);
                } else {
                    container.find('.qty-control').replaceWith(`
                        <button class="v-add-btn" data-id="${productId}" title="{{ trans_db('website.Add to Cart') }}">
                            <i class="fa-solid fa-cart-plus"></i>
                        </button>
                    `);
                }
                // Remove status dot
                indicators.find('.cart-dot').remove();
            }
        }

        // Add to Cart (Delegated)
        $(document).on('click', '.v-add-btn', function(e) {
            e.preventDefault();
            const btn = $(this);
            const container = btn.closest('.v-card-actions, .item-qty-col');
            const productId = btn.data('id');
            const btnIcon = btn.find('i');
            
            // Loading state
            if(btnIcon.length) {
                btnIcon.removeClass().addClass('fa-solid fa-spinner fa-spin');
            } else {
                btn.html('<i class="fa-solid fa-spinner fa-spin"></i>');
            }
            btn.prop('disabled', true);

            $.ajax({
                url: "{{ route('frontend.cart.add') }}",
                type: "POST",
                data: {
                    product_id: productId,
                    quantity: 1,
                    _token: csrfToken
                },
                success: function(response) {
                    updateCartUI(productId, response.item_quantity, container);
                    if(response.cart_count !== undefined) {
                        $('.cart-count').text(response.cart_count);
                    }
                    if(response.cart_total !== undefined) {
                        $('.subtotal-display, .total-display').text(response.cart_total);
                    }

                    // Show confirmation modal
                    if (typeof bootstrap !== 'undefined') {
                        var myModal = new bootstrap.Modal(document.getElementById('addToCartModal'));
                        myModal.show();
                    } else {
                        $('#addToCartModal').modal('show');
                    }
                },
                error: function(xhr) {
                    console.error(xhr);
                    btnIcon.removeClass().addClass('fa-solid fa-cart-plus');
                    btn.prop('disabled', false);
                    if(typeof swal !== 'undefined') swal("{{ trans_db('website.Error') }}", "{{ trans_db('website.Something went wrong') }}", "error");
                }
            });
        });

        // Plus / Minus (Delegated)
        $(document).on('click', '.qty-btn', function(e) {
            e.preventDefault();
            const btn = $(this);
            const container = btn.closest('.v-card-actions');
            const productId = btn.data('id');
            const change = btn.hasClass('plus') ? 1 : -1;
            
            btn.prop('disabled', true);

            $.ajax({
                url: "{{ route('frontend.cart.add') }}",
                type: "POST",
                data: {
                    product_id: productId,
                    quantity: change,
                    _token: csrfToken
                },
                success: function(response) {
                    updateCartUI(productId, response.item_quantity, container);
                    if(response.cart_count !== undefined) {
                        $('.cart-count').text(response.cart_count);
                    }
                    if(response.cart_total !== undefined) {
                        $('.subtotal-display, .total-display').text(response.cart_total);
                    }
                    // Handle row removal on cart page
                    if (response.item_quantity === 0) {
                        $(`.item-row[data-id="${productId}"]`).fadeOut(300, function() { 
                            $(this).remove(); 
                            if ($('.item-row').length === 0) location.reload(); // Reload to show empty state
                        });
                    }
                    btn.prop('disabled', false);
                },
                error: function(xhr) {
                    console.error(xhr);
                    btn.prop('disabled', false);
                }
            });
        });

        // Toggle Wishlist
        $(document).on('click', '.v-wishlist-btn', function(e) {
            e.preventDefault();
            const btn = $(this);
            const card = btn.closest('.v-card');
            const indicators = card.find('.v-status-indicators');
            const productId = btn.data('id');
            const btnIcon = btn.find('i');
            const originalIconClass = btnIcon.attr('class');

            // Loading state
            btn.prop('disabled', true);
            btnIcon.removeClass().addClass('fa-solid fa-spinner fa-spin');

            $.ajax({
                url: "{{ route('frontend.wishlist.toggle') }}",
                type: "POST",
                data: {
                    product_id: productId,
                    _token: csrfToken
                },
                success: function(response) {
                    const allWishBtns = $(`.v-wishlist-btn[data-id="${productId}"]`);
                    
                    if (response.action === 'added') {
                        allWishBtns.addClass('active');
                        allWishBtns.find('i').removeClass('fa-regular fa-heart fa-spinner fa-spin').addClass('fa-solid fa-heart');
                        
                        // Update indicators on all cards for this product
                        allWishBtns.each(function() {
                            const currentBtn = $(this);
                            const currentCard = currentBtn.closest('.v-card');
                            const currentIndicators = currentCard.find('.v-status-indicators');
                            if (currentIndicators.length && currentIndicators.find('.wish-dot').length === 0) {
                                currentIndicators.append('<span class="v-status-dot wish-dot" title="{{ trans_db('website.In Wishlist') }}"><i class="fa-solid fa-heart"></i></span>');
                            }
                        });
                    } else {
                        allWishBtns.removeClass('active');
                        allWishBtns.find('i').removeClass('fa-solid fa-heart fa-spinner fa-spin').addClass('fa-regular fa-heart');
                        
                        // Remove indicators on all cards for this product
                        allWishBtns.each(function() {
                            const currentBtn = $(this);
                            const currentCard = currentBtn.closest('.v-card');
                            currentCard.find('.wish-dot').remove();
                        });
                    }

                    // Update Wishlist Count
                    if(response.wishlist_count !== undefined) {
                        $('.wishlist-count').text(response.wishlist_count);
                    }
                    
                    // Handle row removal on wishlist page
                    const itemRow = $(`.item-row[data-id="${productId}"]`);
                    if (response.action === 'removed' && itemRow.length > 0) {
                        itemRow.fadeOut(300, function() { 
                            $(this).remove(); 
                            // Only reload if we were on the wishlist page and it's now empty
                            if ($('.item-row').length === 0 && (window.location.pathname.includes('/wishlist') || $('.wishlist-container').length > 0)) {
                                location.reload();
                            }
                        });
                    }

                    btn.prop('disabled', false);
                },
                error: function(xhr) {
                    console.error(xhr);
                    btn.prop('disabled', false);
                    btnIcon.removeClass().addClass(originalIconClass);
                    if(typeof swal !== 'undefined') {
                         swal("{{ trans_db('website.Error') }}", "{{ trans_db('website.Something went wrong, please try again') }}", "error");
                    }
                }
            });
        });

        // Remove from Cart Button (Trash Icon)
        $(document).on('click', '.remove-from-cart', function(e) {
            e.preventDefault();
            const btn = $(this);
            const productId = btn.data('id');
            const container = btn.closest('.v-card-actions'); // fallback

            $.ajax({
                url: "{{ route('frontend.cart.add') }}",
                type: "POST",
                data: {
                    product_id: productId,
                    quantity: -99999, // Ensure removal
                    _token: csrfToken
                },
                success: function(response) {
                    if(response.cart_count !== undefined) {
                        $('.cart-count').text(response.cart_count);
                    }
                    if(response.cart_total !== undefined) {
                        $('.subtotal-display, .total-display').text(response.cart_total);
                    }
                    // Remove row
                    $(`.item-row[data-id="${productId}"]`).fadeOut(300, function() { 
                        $(this).remove(); 
                        if ($('.item-row').length === 0) location.reload();
                    });
                }
            });
        });
    });
</script>

<script>
    // Mobile Menu Toggle Logic
    document.addEventListener('DOMContentLoaded', function() {
        const mobileToggle = document.getElementById('elegantMobileToggle');
        const mobileMenu = document.getElementById('elegantMobileMenu');
        const mobileOverlay = document.getElementById('elegantMobileOverlay');
        const mobileClose = document.getElementById('elegantMobileClose');

        function openMobileMenu() {
            mobileMenu.classList.add('active');
            mobileOverlay.classList.add('active');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        function closeMobileMenu() {
            mobileMenu.classList.remove('active');
            mobileOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        if (mobileToggle) {
            mobileToggle.addEventListener('click', openMobileMenu);
        }

        if (mobileClose) {
            mobileClose.addEventListener('click', closeMobileMenu);
        }

        if (mobileOverlay) {
            mobileOverlay.addEventListener('click', closeMobileMenu);
        }

        // Mobile Submenu Toggle
        const submenuToggles = document.querySelectorAll('.mobile-submenu-toggle');
        submenuToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                const parent = this.closest('.mobile-has-submenu');
                const submenu = parent.querySelector('.mobile-submenu');
                const arrow = this.querySelector('.arrow-icon');
                
                if (submenu.style.display === 'none') {
                    submenu.style.display = 'block';
                    arrow.style.transform = 'rotate(180deg)';
                } else {
                    submenu.style.display = 'none';
                    arrow.style.transform = 'rotate(0)';
                }
            });
        });

        // Mobile Inner Submenu Toggle
        const innerSubmenuToggles = document.querySelectorAll('.mobile-inner-toggle');
        innerSubmenuToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                const submenu = this.nextElementSibling;
                if (submenu && submenu.classList.contains('mobile-inner-submenu')) {
                    e.preventDefault();
                    e.stopPropagation();
                    const arrow = this.querySelector('i.fa-chevron-down');
                    
                    if (submenu.style.display === 'none') {
                        submenu.style.display = 'block';
                        if (arrow) arrow.style.transform = 'rotate(180deg)';
                    } else {
                        submenu.style.display = 'none';
                        if (arrow) arrow.style.transform = 'rotate(0)';
                    }
                }
            });
        });
    });
</script>

<script>
    // Product View Toggle Logic (Grid vs Horizontal)
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButtons = document.querySelectorAll('.btn-view-toggle');
        
        toggleButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const targetSelector = this.getAttribute('data-target');
                const viewType = this.getAttribute('data-view');
                const targetContainer = document.querySelector(targetSelector);
                
                if(targetContainer) {
                    // Toggle Class on Container
                    if(viewType === 'horizontal') {
                        targetContainer.classList.add('products-horizontal');
                    } else {
                        targetContainer.classList.remove('products-horizontal');
                    }
                    
                    // Update Active Button State
                    // Find sibling buttons in the same container
                    const siblings = this.parentElement.querySelectorAll('.btn-view-toggle');
                    siblings.forEach(sib => sib.classList.remove('active'));
                    this.classList.add('active');
                }
            });
        });
    });
</script>

<script>
    // Product Search Filter Logic
    document.addEventListener('DOMContentLoaded', function() {
        
        function setupProductSearch(inputId, containerSelector, noResultsId) {
            const input = document.getElementById(inputId);
            
            if (!input) return;

            input.addEventListener('keyup', function() {
                const filter = this.value.toLowerCase();
                const container = document.querySelector(containerSelector);
                const noResults = document.getElementById(noResultsId);
                
                if (!container) return;

                const cards = container.querySelectorAll('.v-card');
                let hasVisibleItems = false;

                cards.forEach(card => {
                    const titleElement = card.querySelector('.v-card-title');
                    const titleText = titleElement ? titleElement.textContent.toLowerCase() : '';
                    
                    if (titleText.includes(filter)) {
                        card.style.display = '';
                        hasVisibleItems = true;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if (noResults) {
                    noResults.style.display = hasVisibleItems ? 'none' : 'block';
                }
            });
        }

        // Setup for Best Sellers
        setupProductSearch('bestSellersSearch', '.best-seller-section .products-grid', 'best-sellers-no-results');

        // Setup for Latest Products
        setupProductSearch('latestProductsSearch', '.latest-products-section .products-grid', 'latest-products-no-results');
    });
</script>