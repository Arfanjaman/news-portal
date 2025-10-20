<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">

    <meta name="csrf-token" content="{{ csrf_token() }}" />
     <title>@hasSection('title') @yield('title') @else {{ $settings['site_seo_title'] }} @endif </title>
    <meta name="description" content="@hasSection('meta_description') @yield('meta_description') @else {{ $settings['site_seo_description'] }} @endif " />
    <meta name="keywords" content="{{ $settings['site_seo_keywords'] }}" />
     <meta name="og:image" content="@hasSection('meta_og_image') @yield('meta_og_image') @else {{ asset($settings['site_logo']) }} @endif" />
    <meta name="og:title" content="@yield('meta_og_title')" />
    <meta name="og:description" content="@yield('meta_og_description')" />

    <meta name="twitter:title" content="@yield('meta_tw_title')" />
    <meta name="twitter:description" content="@yield('meta_tw_description')" />
    <meta name="twitter:image" content="@yield('meta_tw_image')" />

    <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="icon" href="{{ asset($settings['site_favicon']) }}" type="image/png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link href="{{ asset('frontend/assets/css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/dark-theme.css') }}" rel="stylesheet">


<style>
        /* Reading Progress Bar - Fixed CSS */
        .reading-progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 4px;
            background: linear-gradient(90deg, {{ $settings['site_color'] ?? '#007bff' }}, #00d4ff);
            z-index: 9999;
            transition: width 0.1s ease-out;
            box-shadow: 0 2px 10px rgba(0, 123, 255, 0.3);
        }

        /* ---------- Strong override for pagination (place at very end of CSS) ---------- */
        nav .pagination,
        div .pagination,
        ul.pagination,
        .pagination {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            justify-content: center !important;
            align-items: center !important;
            gap: 8px !important;
            /* spacing between items */
            padding-left: 0 !important;
            margin: 30px 0 !important;
            list-style: none !important;
        }

        /* make sure list items are inline and don't stack */
        ul.pagination>li,
        .pagination>li,
        .pagination .page-item {
            display: inline-flex !important;
            align-items: center !important;
            margin: 0 !important;
        }

        /* page link / span as perfect circles - Dark theme version */
        .pagination .page-link,
        .pagination a,
        .pagination span {
            display: inline-flex !important;
            justify-content: center !important;
            align-items: center !important;
            width: 35px !important;
            height: 35px !important;
            padding: 0 !important;
            border-radius: 50% !important;
            text-decoration: none !important;
            line-height: 1 !important;
            border: 1px solid var(--dark-border) !important;
            color: var(--dark-text) !important;
            background: var(--dark-card) !important;
            box-shadow: none !important;
        }

        /* active / selected state - Dark theme version */
        .pagination .active .page-link,
        .pagination .page-item.active>a,
        .pagination .page-item.active>span {
            background-color: var(--accent-color) !important;
            color: #fff !important;
            border-color: var(--accent-color) !important;
        }

        /* Hover state for pagination */
        .pagination .page-link:hover,
        .pagination a:hover,
        .pagination span:hover {
            background-color: var(--accent-color) !important;
            color: #fff !important;
            border-color: var(--accent-color) !important;
        }

        /* remove browser focus/outline/blue ring on click */
        .pagination .page-link:focus,
        .pagination .page-link:active,
        .pagination a:focus,
        .pagination a:active,
        .pagination span:focus,
        .pagination span:active {
            outline: none !important;
            box-shadow: none !important;
            background: transparent !important;
        }

        /* mobile highlight */
        .pagination {
            -webkit-tap-highlight-color: transparent !important;
        }
        /* social link */
         .btn-social {
    background-color: #fff !important;
  }

  .btn-social > i{
    color: var(--colorPrimary) !important;
  }



        :root {
            --colorPrimary: {{ $settings['site_color'] }};
        }
        .bg__footer-dark {

          background-color: var(--colorPrimary);
          }



    .img-fluid.rounded-circle {
    width: 100px !important;
    height: 100px !important;
    object-fit: cover !important;
    }

    .wrap__profile-author {
    width: 50% !important;
    }

    .wrap__profile-author-detail {
    position: relative;
    }

    .author-wrapper {
    position: absolute;
    top: 20%;
    }

    .social__media__widget-icon {
    margin-top: 10px;
    margin-left: 10px;
    }

    .list-inline-item-contact a {
    background-color: var(--colorPrimary) !important;
    }
    .list-inline-item-contact a i {
    color: #fff !important;
    }












</style>
</head>

<body>
    <!--Global Variables-->
    @php
        $socialLinks = \App\Models\SocialLink::where('status', 1)->get();
        $footerInfo = \App\Models\FooterInfo::where('language', getLangauge())->first();

        $footerGridOne = \App\Models\FooterGridOne::where(['status' => 1, 'language' => getLangauge()])->get();
        $footerGridTwo = \App\Models\FooterGridTwo::where(['status' => 1, 'language' => getLangauge()])->get();
        $footerGridThree = \App\Models\FooterGridThree::where(['status' => 1, 'language' => getLangauge()])->get();
        $footerGridOneTitle = \App\Models\FooterTitle::where(['key' => 'grid_one_title', 'language' => getLangauge()])->first();
        $footerGridTwoTitle = \App\Models\FooterTitle::where(['key' => 'grid_two_title', 'language' => getLangauge()])->first();
        $footerGridThreeTitle = \App\Models\FooterTitle::where(['key' => 'grid_three_title', 'language' => getLangauge()])->first();

    @endphp

    <!-- Header news -->
    @include('frontend.layouts.header')
    <!-- End Header news -->

    @yield('content')

    <!-- Footer Section -->
    @include('frontend.layouts.footer')
    <!-- End Footer Section -->


    <!-- Reading Progress Bar -->
    <div id="reading-progress" class="reading-progress-bar"></div>

    <!-- Smart Newsletter Popup -->
    <div id="newsletter-popup" class="newsletter-popup-overlay">
        <div class="newsletter-popup-container">
            <button class="newsletter-popup-close" id="newsletter-close" aria-label="Close newsletter popup">
                <i class="fa fa-times"></i>
            </button>

            <div class="newsletter-popup-content">
                <div class="newsletter-popup-header">
                    <div class="newsletter-icon">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <h3>{{ __('frontend.Stay Updated!') }}</h3>
                    <p>{{ __('frontend.Get the latest news and updates delivered straight to your inbox') }}</p>
                </div>

                <form class="newsletter-popup-form" id="newsletter-popup-form">
                    @csrf
                    <div class="newsletter-input-group">
                        <input type="email" name="email" placeholder="{{ __('frontend.Enter your email address') }}" required>
                        <button type="submit" class="newsletter-submit-btn">
                            <span class="submit-text">{{ __('frontend.Subscribe') }}</span>
                            <span class="submit-loading" style="display: none;">
                                <i class="fa fa-spinner fa-spin"></i>
                            </span>
                        </button>
                    </div>

                    <div class="newsletter-benefits">
                        <small>
                            <i class="fa fa-check"></i> {{ __('frontend.Breaking news alerts') }}
                        </small>
                        <small>
                            <i class="fa fa-check"></i> {{ __('frontend.Weekly newsletter') }}
                        </small>
                        <small>
                            <i class="fa fa-check"></i> {{ __('frontend.No spam, unsubscribe anytime') }}
                        </small>
                    </div>
                </form>

                <div class="newsletter-popup-footer">
                    <button class="newsletter-later-btn" id="newsletter-later">{{ __('frontend.Maybe Later') }}</button>
                    <button class="newsletter-never-btn" id="newsletter-never">{{ __('frontend.Don\'t show again') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Back to Top Button -->
    <button id="return-to-top" class="back-to-top-btn" aria-label="Back to top">
        <i class="fa fa-chevron-up"></i>
    </button>

    <script type="text/javascript" src="{{ asset('frontend/assets/js/index.bundle.js') }}"></script>
    @include('sweetalert::alert')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
         const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })


        // Add csrf token in ajax request
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            /** change language **/
            $('#site-language').on('change', function() {
                let languageCode = $(this).val();
                $.ajax({
                    method: 'GET',
                    url: "{{ route('language') }}",
                    data: {
                        language_code: languageCode
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                             window.location.href = "{{ url('/') }}";
                        }
                    },
                    error: function(data) {
                        console.error(data);
                    }
                })
            })
             /** Subscribe Newsletter**/
            $('.newsletter-form').on('submit', function(e){
                e.preventDefault(); //preventing reload
                $.ajax({
                    method: 'POST',
                    url: "{{ route('subscribe-newsletter') }}",
                    data: $(this).serialize(),
                    beforeSend: function(){ //loading state to prevent multiple submission
                        $('.newsletter-button').text('loading...');
                        $('.newsletter-button').attr('disabled', true);
                    },
                    success: function(data){
                       Toast.fire({
                                icon: 'success',
                                title: data.message
                            })
                         $('.newsletter-form')[0].reset();
                         $('.newsletter-button').text('sign up');

                        $('.newsletter-button').attr('disabled', false);
                    },
                    error: function(data){  //ajax er error catch korar jnno
                        $('.newsletter-button').text('sign up');
                        $('.newsletter-button').attr('disabled', false);

                        if(data.status === 422){
                            let errors = data.responseJSON.errors;
                            $.each(errors, function(index, value){
                                Toast.fire({
                                    icon: 'error',
                                    title: value[0]
                                })
                            })
                        }
                    }
                })
            })

            // Enhanced Back to Top Button & Reading Progress Functionality
            const backToTopBtn = document.getElementById('return-to-top');
            const progressBar = document.getElementById('reading-progress');

            // Debug: Check if elements exist
            console.log('Back to top button found:', !!backToTopBtn);
            console.log('Progress bar found:', !!progressBar);
            if (progressBar) {
                console.log('Progress bar initial style:', progressBar.style.cssText);
                console.log('Progress bar computed style:', window.getComputedStyle(progressBar));
            }

            // Show/Hide button and update progress on scroll
            function updateBackToTop() {
                const scrolled = window.pageYOffset;
                const maxHeight = document.documentElement.scrollHeight - window.innerHeight;
                const scrollPercent = Math.min((scrolled / maxHeight) * 100, 100);

                // Show/hide button
                if (scrolled > 300) {
                    backToTopBtn.classList.add('visible');
                } else {
                    backToTopBtn.classList.remove('visible');
                }

                // Update progress bar
                if (progressBar && maxHeight > 0) {
                    progressBar.style.width = scrollPercent + '%';
                    // Debug: Uncomment next line to see progress in console
                    console.log('Progress:', scrollPercent.toFixed(1) + '%', 'Bar width:', progressBar.style.width);
                }
            }            // Smooth scroll to top function
            function smoothScrollToTop() {
                const startPosition = window.pageYOffset;
                const startTime = performance.now();
                const duration = 1600; // 1600ms duration

                function animation(currentTime) {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);

                    // Easing function (ease-out-cubic)
                    const ease = 1 - Math.pow(1 - progress, 3);

                    window.scrollTo(0, startPosition * (1 - ease));

                    if (progress < 1) {
                        requestAnimationFrame(animation);
                    }
                }

                requestAnimationFrame(animation);
            }

            // Event listeners
            window.addEventListener('scroll', updateBackToTop);
            backToTopBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // Add click animation
                this.style.transform = 'translateY(-1px) scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);

                smoothScrollToTop();
            });

            // Initial call
            updateBackToTop();

            // Session-Based Newsletter Popup Functionality
            const newsletterPopup = document.getElementById('newsletter-popup');
            const newsletterForm = document.getElementById('newsletter-popup-form');
            const closeBtn = document.getElementById('newsletter-close');
            const laterBtn = document.getElementById('newsletter-later');
            const neverBtn = document.getElementById('newsletter-never');

            let popupTriggered = false;
            let userInteracted = false;
            let scrollThreshold = false;
            let timeThreshold = false;

            // Check if popup should be shown based on session storage
            function shouldShowPopup() {
                // Check for demo mode
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.get('demo') === 'true') {
                    console.log('🎓 DEMO MODE - Newsletter popup will show');
                    return true;
                }

                // Check session-based storage
                const subscribed = sessionStorage.getItem('newsletter_subscribed');
                const neverShow = sessionStorage.getItem('newsletter_never_show');

                // Don't show if subscribed or never show in this session
                if (subscribed === 'true' || neverShow === 'true') {
                    console.log('Newsletter blocked for this session:', { subscribed, neverShow });
                    return false;
                }

                return true;
            }

            // Show popup with animation
            function showPopup() {
                if (popupTriggered || !shouldShowPopup()) return;

                popupTriggered = true;
                newsletterPopup.classList.add('active');
                document.body.style.overflow = 'hidden';

                console.log('📧 Newsletter popup shown');
            }

            // Hide popup with animation
            function hidePopup() {
                newsletterPopup.classList.remove('active');
                document.body.style.overflow = '';
            }

            // Smart trigger conditions
            function checkPopupTriggers() {
                if (popupTriggered || !shouldShowPopup()) return;

                const scrollPercent = (window.pageYOffset / (document.documentElement.scrollHeight - window.innerHeight)) * 100;

                // Trigger after 30 seconds OR 50% scroll OR user interaction
                if (timeThreshold && (scrollThreshold || scrollPercent > 50 || userInteracted)) {
                    showPopup();
                }
            }

            // Set time threshold after 30 seconds
            setTimeout(() => {
                timeThreshold = true;
                checkPopupTriggers();
            }, 30000);

            // Check scroll threshold
            function handleScroll() {
                if (!scrollThreshold) {
                    const scrollPercent = (window.pageYOffset / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
                    if (scrollPercent > 25) {
                        scrollThreshold = true;
                        checkPopupTriggers();
                    }
                }
            }

            // User interaction tracking
            function trackUserInteraction() {
                if (!userInteracted) {
                    userInteracted = true;
                    // User is engaged, reduce trigger time to 15 seconds
                    setTimeout(() => {
                        timeThreshold = true;
                        checkPopupTriggers();
                    }, 15000);
                }
            }

            // Event listeners for user interaction and scroll
            document.addEventListener('mousemove', trackUserInteraction, { once: true });
            document.addEventListener('keydown', trackUserInteraction, { once: true });
            document.addEventListener('click', trackUserInteraction, { once: true });
            document.addEventListener('scroll', handleScroll);

            // Button Event Handlers
            if (closeBtn) {
                closeBtn.addEventListener('click', () => {
                    hidePopup();
                    console.log('❌ Newsletter popup closed - can show again in this session');
                });
            }

            // Maybe Later button - allows multiple shows in same session
            if (laterBtn) {
                laterBtn.addEventListener('click', () => {
                    hidePopup();
                    popupTriggered = false; // Reset so it can show again
                    console.log('⏸️ Newsletter "Maybe Later" - can show again in this session');
                });
            }

            // Never Show button - blocks for this session only
            if (neverBtn) {
                neverBtn.addEventListener('click', () => {
                    hidePopup();
                    sessionStorage.setItem('newsletter_never_show', 'true');
                    console.log('🚫 Newsletter "Don\'t show again" - blocked for this session');
                });
            }

            // Close on overlay click - can show again
            if (newsletterPopup) {
                newsletterPopup.addEventListener('click', (e) => {
                    if (e.target === newsletterPopup) {
                        hidePopup();
                        console.log('❌ Newsletter closed via overlay - can show again');
                    }
                });

                // Close on Escape key - can show again
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && newsletterPopup.classList.contains('active')) {
                        hidePopup();
                        console.log('❌ Newsletter closed via ESC key - can show again');
                    }
                });
            }

            // Handle form submission using existing route
            if (newsletterForm) {
                newsletterForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const submitBtn = this.querySelector('.newsletter-submit-btn');
                    const submitText = submitBtn.querySelector('.submit-text');
                    const submitLoading = submitBtn.querySelector('.submit-loading');
                    const emailInput = this.querySelector('input[name="email"]');

                    // Show loading state
                    submitBtn.disabled = true;
                    submitText.style.display = 'none';
                    submitLoading.style.display = 'inline-block';

                    // Use existing newsletter subscription route
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('subscribe-newsletter') }}",
                        data: $(this).serialize(),
                        success: function(data) {
                            Toast.fire({
                                icon: 'success',
                                title: data.message || 'Successfully subscribed!'
                            });

                            // Hide popup and mark as subscribed for this session
                            hidePopup();
                            sessionStorage.setItem('newsletter_subscribed', 'true');
                            console.log('✅ Newsletter subscription successful - blocked for this session');
                        },
                        error: function(data) {
                            let errorMessage = 'Subscription failed. Please try again.';

                            if (data.status === 422 && data.responseJSON.errors) {
                                const errors = data.responseJSON.errors;
                                errorMessage = Object.values(errors)[0][0];
                            }

                            Toast.fire({
                                icon: 'error',
                                title: errorMessage
                            });
                        },
                        complete: function() {
                            // Reset button state
                            submitBtn.disabled = false;
                            submitText.style.display = 'inline-block';
                            submitLoading.style.display = 'none';
                        }
                    });
                });
            }

            // DEMO HELPER FUNCTIONS
            document.addEventListener('keydown', function(e) {
                // Press Ctrl+Shift+N to reset newsletter popup (for demo)
                if (e.ctrlKey && e.shiftKey && e.key === 'N') {
                    sessionStorage.removeItem('newsletter_subscribed');
                    sessionStorage.removeItem('newsletter_never_show');
                    popupTriggered = false;
                    console.log('🎓 DEMO: Newsletter popup reset for this session!');

                    if (typeof Toast !== 'undefined') {
                        Toast.fire({
                            icon: 'info',
                            title: 'Demo Mode: Newsletter popup reset for this session!'
                        });
                    }
                }

                // Press Ctrl+Shift+P to force show popup immediately (for demo)
                if (e.ctrlKey && e.shiftKey && e.key === 'P') {
                    popupTriggered = false;
                    showPopup();
                    console.log('🎓 DEMO: Newsletter popup forced to show!');
                }
            });

            // Console info for demo mode
            if (window.location.search.includes('demo=true')) {
                console.log(`
🎓 NEWSLETTER POPUP SESSION-BASED DEMO
======================================
• Session Logic: Only shows once per action per session
• Button Behaviors:
  - X Close: Can show again in same session
  - Maybe Later: Can show again in same session (multiple times)
  - Don't Show Again: Won't show again this session
  - Subscribe: Won't show again this session
• Demo Shortcuts:
  - Ctrl+Shift+N: Reset session preferences
  - Ctrl+Shift+P: Force show popup
• Add ?demo=true to URL for demo mode
• Triggers: 30s timer OR 25% scroll OR user interaction
                `);
            }

        });

    </script>

    @stack('content')

</body>

</html>
