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
    <link href="{{ asset('frontend/assets/css/dark-theme.css') }}" rel="stylesheet" id="dark-theme-css">


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

        /* Dark/Light Theme Toggle Button */
        .theme-toggle-container {
            margin-left: 15px;
            margin-right: 10px;
        }

        .theme-toggle-btn {
            background: none;
            border: 2px solid {{ $settings['site_color'] ?? '#007bff' }};
            border-radius: 50%;
            width: 40px;
            height: 40px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            color: {{ $settings['site_color'] ?? '#007bff' }};
            font-size: 16px;
        }

        .theme-toggle-btn:hover {
            background: {{ $settings['site_color'] ?? '#007bff' }};
            color: white;
            transform: scale(1.1);
        }

        .theme-toggle-btn:active {
            transform: scale(0.95);
        }

        /* Theme Icon Animation */
        #theme-icon, #mobile-theme-icon {
            transition: transform 0.3s ease;
        }

        .theme-toggle-btn:hover #theme-icon,
        .mobile-theme-toggle-btn:hover #mobile-theme-icon {
            transform: rotate(15deg);
        }

        /* Mobile Theme Toggle Button */
        .mobile-theme-toggle-container {
            margin-left: 15px;
            display: flex;
            align-items: center;
        }

        .mobile-theme-toggle-btn {
            background: none;
            border: 2px solid {{ $settings['site_color'] ?? '#007bff' }};
            border-radius: 50%;
            width: 36px;
            height: 36px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            color: {{ $settings['site_color'] ?? '#007bff' }};
            font-size: 14px;
        }

        .mobile-theme-toggle-btn:hover {
            background: {{ $settings['site_color'] ?? '#007bff' }};
            color: white;
            transform: scale(1.1);
        }

        .mobile-theme-toggle-btn:active {
            transform: scale(0.95);
        }

        /* Hide mobile theme toggle on desktop */
        @media (min-width: 576px) {
            .mobile-theme-toggle-container {
                display: none;
            }
        }

        /* Hide desktop theme toggle on mobile */
        @media (max-width: 575px) {
            .theme-toggle-container {
                display: none !important;
            }
        }

        /* Adjust offcanvas header layout for mobile */
        .offcanvas-header {
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        /* Hide hamburger menu on desktop screens */
        @media (min-width: 992px) {
            .offcanvas-header {
                display: none !important;
            }
        }

        /* Show hamburger menu only on mobile and tablet */
        @media (max-width: 991px) {
            .offcanvas-header {
                display: flex !important;
            }
        }

        /* Light Theme Variables and Overrides */
        :root {
            --light-bg: #ffffff;
            --light-card: #f8f9fa;
            --light-text: #333333;
            --light-text-muted: #666666;
            --light-border: #e9ecef;
            --accent-color: {{ $settings['site_color'] ?? '#007bff' }};
        }

        /* Light Theme Styles - Higher specificity to override dark theme */
        body.light-theme {
            background-color: var(--light-bg) !important;
            color: var(--light-text) !important;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Force light theme overrides with maximum specificity */
        body.light-theme * {
            color: var(--light-text) !important;
        }

        body.light-theme .card,
        body.light-theme .bg-white,
        body.light-theme .card__post,
        body.light-theme .card__post__body,
        body.light-theme .article__entry,
        body.light-theme .wrapper__list__article {
            background-color: var(--light-card) !important;
            color: var(--light-text) !important;
            border-color: var(--light-border) !important;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        body.light-theme h1, body.light-theme h2, body.light-theme h3,
        body.light-theme h4, body.light-theme h5, body.light-theme h6,
        body.light-theme p, body.light-theme span, body.light-theme div,
        body.light-theme a, body.light-theme li {
            color: var(--light-text) !important;
            transition: color 0.3s ease;
        }

        body.light-theme a:hover {
            color: var(--accent-color) !important;
        }

        body.light-theme .navbar, body.light-theme .topbar, body.light-theme header,
        body.light-theme .navigation-wrap {
            background-color: var(--light-bg) !important;
            border-color: var(--light-border) !important;
            transition: background-color 0.3s ease;
        }

        body.light-theme .navbar-nav .nav-link {
            color: var(--light-text) !important;
            transition: color 0.3s ease;
        }

        body.light-theme .form-control, body.light-theme .form-select,
        body.light-theme input, body.light-theme textarea {
            background-color: var(--light-card) !important;
            border-color: var(--light-border) !important;
            color: var(--light-text) !important;
            transition: all 0.3s ease;
        }

        /* Footer - Use backend color variable with theme-appropriate text */
        footer, .footer, .wrapper__footer, .bg__footer-dark, .wrapper__footer-bottom {
            background-color: {{ $settings['site_color'] ?? '#007bff' }} !important;
        }

        /* Preserve site color in light mode for footer */
        body.light-theme footer,
        body.light-theme .footer,
        body.light-theme .wrapper__footer,
        body.light-theme .bg__footer-dark,
        body.light-theme .wrapper__footer-bottom {
            background-color: {{ $settings['site_color'] ?? '#007bff' }} !important;
        }

        /* LIGHT THEME - Target specific footer classes from HTML structure */

        /* Main footer wrapper */
        body.light-theme .wrapper__footer,
        body.light-theme .wrapper__footer-bottom {
            color: #333333 !important;
        }

        /* Widget footer containers */
        body.light-theme .widget__footer,
        body.light-theme .widget__footer * {
            color: #333333 !important;
        }

        /* Footer titles (h4.footer-title) */
        body.light-theme .footer-title,
        body.light-theme .footer-title * {
            color: #333333 !important;
        }

        /* Dropdown footer sections */
        body.light-theme .dropdown-footer,
        body.light-theme .dropdown-footer * {
            color: #333333 !important;
        }

        /* Footer paragraphs and text */
        body.light-theme .wrapper__footer p,
        body.light-theme .wrapper__footer-bottom p,
        body.light-theme .widget__footer p {
            color: #333333 !important;
        }

        /* Footer links in lists */
        body.light-theme .option-content li a,
        body.light-theme .list-unstyled li a {
            color: #333333 !important;
            text-decoration: none !important;
        }

        body.light-theme .option-content li a:hover,
        body.light-theme .list-unstyled li a:hover {
            color: #000000 !important;
            text-decoration: underline !important;
        }

        /* Social media section */
        body.light-theme .social__media,
        body.light-theme .social__media * {
            color: #333333 !important;
        }

        /* Copyright text specifically */
        body.light-theme .text-white,
        body.light-theme .bg__footer-bottom-section p {
            color: #333333 !important;
        }

        /* Border sections */
        body.light-theme .border-top-1,
        body.light-theme .bg__footer-bottom-section {
            color: #333333 !important;
        }

        /* Social buttons - keep their styling but ensure text is visible */
        body.light-theme .btn-social {
            background-color: rgba(0,0,0,0.1) !important;
            border: 1px solid rgba(0,0,0,0.2) !important;
        }

        body.light-theme .btn-social i {
            color: #333333 !important;
        }
        body.light-theme .footer .social-media a {
            display: inline-block !important;
            width: 40px !important;
            height: 40px !important;
            line-height: 40px !important;
            text-align: center !important;

            color: #333333 !important;
            border-radius: 50% !important;
            transition: all 0.3s ease !important;
        }

        body.light-theme footer .social-links a:hover,
        body.light-theme .footer .social-links a:hover,
        body.light-theme footer .social-media a:hover,
        body.light-theme .footer .social-media a:hover {

            color: #000000 !important;
            transform: translateY(-2px) !important;
        }

        /* Light Theme Footer copyright and bottom text */
        body.light-theme footer .copyright,
        body.light-theme .footer .copyright,
        body.light-theme footer .footer-bottom,
        body.light-theme .footer .footer-bottom {
            color: #333333 !important;
            text-align: center !important;
            padding: 20px 0 !important;
            border-top: 1px solid rgba(51, 51, 51, 0.1) !important;
            margin-top: 30px !important;
        }

        /* Light Theme Footer form elements */
        body.light-theme footer input,
        body.light-theme .footer input,
        body.light-theme footer textarea,
        body.light-theme .footer textarea,
        body.light-theme footer select,
        body.light-theme .footer select {

            border: 1px solid rgba(51, 51, 51, 0.2) !important;
            color: #333333 !important;
            padding: 10px !important;
            border-radius: 4px !important;
        }

        body.light-theme footer input::placeholder,
        body.light-theme .footer input::placeholder,
        body.light-theme footer textarea::placeholder,
        body.light-theme .footer textarea::placeholder {
            color: rgba(51, 51, 51, 0.7) !important;
        }

        body.light-theme footer input:focus,
        body.light-theme .footer input:focus,
        body.light-theme footer textarea:focus,
        body.light-theme .footer textarea:focus,
        body.light-theme footer select:focus,
        body.light-theme .footer select:focus {
            outline: none !important;
            border-color: rgba(51, 51, 51, 0.5) !important;
            background-color: rgba(51, 51, 51, 0.15) !important;
        }

        /* Light Theme Footer buttons */
        body.light-theme footer .btn,
        body.light-theme .footer .btn {

            border: 1px solid rgba(51, 51, 51, 0.2) !important;
            color: #333333 !important;
            padding: 10px 20px !important;
            border-radius: 4px !important;
            transition: all 0.3s ease !important;
        }

        body.light-theme footer .btn:hover,
        body.light-theme .footer .btn:hover {

            border-color: rgba(51, 51, 51, 0.3) !important;
            color: #000000 !important;
        }

        /* Light Theme Footer - ensure all widgets are properly styled */
        body.light-theme .widget__footer,
        body.light-theme .widget__footer *,
        body.light-theme .footer-title,
        body.light-theme .footer-title * {
            color: #333333 !important;
        }

        /* Light Theme Footer dropdown and special elements */
        body.light-theme .dropdown-footer,
        body.light-theme .dropdown-footer *,
        body.light-theme footer .dropdown-menu,
        body.light-theme footer .dropdown-item {
            color: #333333 !important;
            background-color: transparent !important;
        }

        /* CONTAINER BACKGROUND FIXES - Prevent visual collapse */

        /* Ensure footer maintains proper contrast regardless of theme */
        footer, .wrapper__footer, .bg__footer-dark {
            position: relative !important;
            z-index: 1 !important;
        }

        /* Light theme - ensure footer containers don't become invisible */
        body.light-theme .wrapper__footer,
        body.light-theme .wrapper__footer-bottom,
        body.light-theme .bg__footer-dark {
            background-color: {{ $settings['site_color'] ?? '#007bff' }} !important;
            min-height: auto !important;
            padding: 40px 0 20px !important;
        }

        body.light-theme .wrapper__footer-bottom {
            padding: 20px 0 !important;
        }

        /* Ensure widget containers are visible in light theme */
        body.light-theme .widget__footer {
            background-color: transparent !important;
            border: none !important;
            box-shadow: none !important;
            opacity: 1 !important;
            visibility: visible !important;
        }

        /* Fix for image logo visibility */
        body.light-theme .image-logo,
        body.light-theme .logo-footer {
            opacity: 1 !important;
            visibility: visible !important;
            display: block !important;
        }

        /* Ensure proper spacing and visibility for all footer elements */
        body.light-theme .border-top-1,
        body.light-theme .bg__footer-bottom-section {
            border-top: 1px solid rgba(51, 51, 51, 0.2) !important;
            padding: 20px 0 !important;
            margin-top: 20px !important;
        }

        /* Dark Theme Footer - maintain white text (unchanged from dark-theme.css behavior) */
        body:not(.light-theme) footer,
        body:not(.light-theme) footer *,
        body:not(.light-theme) .wrapper__footer,
        body:not(.light-theme) .wrapper__footer *,
        body:not(.light-theme) .widget__footer,
        body:not(.light-theme) .widget__footer *,
        body:not(.light-theme) .footer-title,
        body:not(.light-theme) .footer-title * {
            color: #ffffff !important;
        }

        /* FOOTER LAYOUT PRESERVATION - Prevent collapse during theme switching */
        footer, .wrapper__footer, .wrapper__footer-bottom,
        .widget__footer, .dropdown-footer {
            min-height: auto !important;
            display: block !important;
            visibility: visible !important;
            position: relative !important;
            overflow: visible !important;
        }

        /* Ensure footer columns maintain structure */
        .wrapper__footer .col-md-4,
        .wrapper__footer .col-md-3,
        .wrapper__footer .col-md-2 {
            display: block !important;
            position: relative !important;
            min-height: 1px !important;
            padding: 15px !important;
        }

        /* Footer widget structure preservation */
        .widget__footer {
            margin-bottom: 30px !important;
            display: block !important;
        }

        .widget__footer .dropdown-footer {
            display: block !important;
            margin-bottom: 15px !important;
        }

        .widget__footer .footer-title {
            display: block !important;
            margin-bottom: 15px !important;
            font-size: 18px !important;
            font-weight: bold !important;
        }

        /* Footer lists structure */
        .widget__footer .list-unstyled {
            display: block !important;
            margin: 0 !important;
            padding: 0 !important;
            list-style: none !important;
        }

        .widget__footer .list-unstyled li {
            display: block !important;
            margin-bottom: 8px !important;
            padding: 0 !important;
        }

        /* Social media section structure */
        .social__media {
            display: block !important;
            margin-top: 20px !important;
        }

        .social__media .list-inline {
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 10px !important;
            margin: 0 !important;
            padding: 0 !important;
            list-style: none !important;
        }

        .social__media .list-inline-item {
            display: inline-block !important;
            margin: 0 !important;
        }

        /* FIX IS-HIDDEN CLASS BEHAVIOR - Consistent across themes */
        .wrapper__footer .widget__footer .is-hidden {
            display: block !important;
        }

        /* On mobile screens, hide dropdown content but keep structure */
        @media screen and (min-width: 320px) and (max-width: 575px) {
            .wrapper__footer .widget__footer .is-hidden {
                display: none !important;
            }

            /* Ensure footer still maintains minimum height on mobile */
            .wrapper__footer .widget__footer {
                min-height: 50px !important;
            }
        }

        /* Footer dropdown toggle styling - consistent behavior */
        .dropdown-footer .footer-title {
            cursor: pointer !important;
            position: relative !important;
            display: block !important;
        }

        .dropdown-footer .fa-angle-down {
            transition: transform 0.3s ease !important;
            float: right !important;
            margin-top: 2px !important;
        }

        /* SMOOTH TRANSITIONS - Prevent jarring layout shifts */
        footer, .wrapper__footer, .wrapper__footer-bottom,
        .widget__footer, .dropdown-footer, .footer-title,
        .list-unstyled, .social__media {
            transition: all 0.3s ease !important;
        }

        /* Smooth color transitions for text elements */
        footer *, .wrapper__footer *, .widget__footer *,
        .footer-title, .footer-title *,
        .dropdown-footer, .dropdown-footer *,
        .list-unstyled li a {
            transition: color 0.3s ease, background-color 0.3s ease !important;
        }

        /* Additional Light Theme Overrides for Better Compatibility */
        body.light-theme .container,
        body.light-theme .row,
        body.light-theme .col,
        body.light-theme .col-md-8,
        body.light-theme .col-md-4,
        body.light-theme .sidebar,
        body.light-theme aside,
        body.light-theme .widget,
        body.light-theme .popular__section-news,
        body.light-theme .wrapp__list__article-responsive {
            background-color: transparent !important;
            color: var(--light-text) !important;
        }

        /* Light theme - specific news components */
        body.light-theme .card__post__title,
        body.light-theme .card__post__title h1,
        body.light-theme .card__post__title h2,
        body.light-theme .card__post__title h3,
        body.light-theme .card__post__title h4,
        body.light-theme .card__post__title h5,
        body.light-theme .card__post__title h6,
        body.light-theme .card__post__title a {
            color: var(--light-text) !important;
        }

        /* Light theme - author and meta information */
        body.light-theme .card__post__author-info,
        body.light-theme .card__post__author-info *,
        body.light-theme .article__content ul,
        body.light-theme .article__content ul li,
        body.light-theme .article__content .list-inline,
        body.light-theme .article__content .list-inline li {
            color: var(--light-text-muted) !important;
        }

        /* Light theme - ensure all text elements are visible */
        body.light-theme .text-dark,
        body.light-theme .text-black,
        body.light-theme .text-body,
        body.light-theme .text-secondary,
        body.light-theme .text-muted {
            color: var(--light-text) !important;
        }

        /* Light theme - navigation and menu items */
        body.light-theme .navbar-brand,
        body.light-theme .nav-item,
        body.light-theme .nav-link,
        body.light-theme .dropdown-menu,
        body.light-theme .dropdown-item {
            background-color: var(--light-bg) !important;
            color: var(--light-text) !important;
        }

        body.light-theme .dropdown-item:hover {
            background-color: var(--light-card) !important;
            color: var(--accent-color) !important;
        }

        /* Light theme - social media and links */
        body.light-theme .topbar-sosmed a,
        body.light-theme .topbar-sosmed a i,
        body.light-theme .social-links a,
        body.light-theme .social-links a i,
        body.light-theme .topbar-text {
            color: var(--light-text) !important;
        }

        /* Light theme - list numbers and badges */
        body.light-theme .list-number,
        body.light-theme .list-number span,
        body.light-theme .wrapper__list-number .list-number,
        body.light-theme .wrapper__list-number .list-number span {
            background-color: var(--accent-color) !important;
            color: #ffffff !important;
        }

        /* FIX FOR UNDERLYING LAYER - Remove background from parent containers */
        .wrapper__list-number,
        .card__post__list,
        .wrapper__list-number .card__post__list,
        .popular__section-news .card__post__list,
        .wrapper__list__article .card__post__list {
            background-color: transparent !important;
            background: none !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
        }

        /* Ensure list number containers have proper styling */
        .list-number,
        .list-number span,
        .wrapper__list-number .list-number,
        .wrapper__list-number .list-number span {
            background-color: var(--accent-color) !important;
            color: #ffffff !important;
            border-radius: 50% !important;
            width: 40px !important;
            height: 40px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-weight: bold !important;
            font-size: 14px !important;
            margin-right: 15px !important;
            flex-shrink: 0 !important;
            border: none !important;
            box-shadow: none !important;
            position: relative !important;
            z-index: 2 !important;
        }

        /* Light theme specific - remove any card backgrounds around numbers */
        body.light-theme .wrapper__list-number,
        body.light-theme .card__post__list,
        body.light-theme .wrapper__list-number .card__post__list,
        body.light-theme .popular__section-news .card__post__list,
        body.light-theme .wrapper__list__article .card__post__list {
            background-color: transparent !important;
            background: none !important;
        }

        /* Dark theme specific - remove any card backgrounds around numbers */
        body:not(.light-theme) .wrapper__list-number,
        body:not(.light-theme) .card__post__list,
        body:not(.light-theme) .wrapper__list-number .card__post__list,
        body:not(.light-theme) .popular__section-news .card__post__list,
        body:not(.light-theme) .wrapper__list__article .card__post__list {
            background-color: transparent !important;
            background: none !important;
        }

        /* DARK THEME FIX - Override dark-theme.css card__post__list styling */
        body:not(.light-theme) .wrapper__list-number .card__post__list,
        body:not(.light-theme) .popular__section-news .card__post__list {
            background-color: transparent !important;
            background: none !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin-bottom: 0 !important;
            border-radius: 0 !important;
        }

        /* Ensure dark theme list numbers stay properly styled */
        body:not(.light-theme) .list-number,
        body:not(.light-theme) .list-number span,
        body:not(.light-theme) .wrapper__list-number .list-number,
        body:not(.light-theme) .wrapper__list-number .list-number span {
            background-color: {{ $settings['site_color'] ?? '#007bff' }} !important;
            color: #ffffff !important;
            border-radius: 50% !important;
            width: 40px !important;
            height: 40px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-weight: bold !important;
            position: relative !important;
            z-index: 10 !important;
        }

        /* Light theme - category badges */
        body.light-theme .card__post__category,
        body.light-theme .badge,
        body.light-theme .category-badge {
            background-color: var(--accent-color) !important;
            color: #ffffff !important;
        }

        /* Light theme - category badge hover effects */
        body.light-theme .card__post__category:hover,
        body.light-theme .badge:hover,
        body.light-theme .category-badge:hover {
            background-color: var(--accent-color) !important;
            color: #000000 !important;
            transition: color 0.3s ease !important;
        }

        /* Light theme - pagination */
        body.light-theme .pagination .page-link,
        body.light-theme .pagination a {
            background-color: var(--light-card) !important;
            color: var(--light-text) !important;
            border-color: var(--light-border) !important;
        }

        body.light-theme .pagination .page-link:hover,
        body.light-theme .pagination a:hover {
            background-color: var(--accent-color) !important;
            color: #ffffff !important;
        }

        /* Light theme - forms and inputs */
        body.light-theme .form-control:focus,
        body.light-theme .form-select:focus,
        body.light-theme input:focus,
        body.light-theme textarea:focus {
            border-color: var(--accent-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
        }



        /* Ensure dark theme CSS only applies when NOT in light theme */
        body:not(.light-theme) {
            background-color: #1a1a1a !important;
            color: #ffffff !important;
        }

        /* Comprehensive light theme overrides with maximum specificity */
        body.light-theme {
            background-color: var(--light-bg) !important;
            color: var(--light-text) !important;
        }

        body.light-theme * {
            color: var(--light-text) !important;
        }

        /* Override all dark theme styles for light mode */
        body.light-theme .card,
        body.light-theme .bg-white,
        body.light-theme .card__post,
        body.light-theme .card__post__body,
        body.light-theme .article__entry,
        body.light-theme .wrapper__list__article,
        body.light-theme .container,
        body.light-theme .container-fluid,
        body.light-theme .row,
        body.light-theme .col,
        body.light-theme .col-md-8,
        body.light-theme .col-md-4,
        body.light-theme .sidebar,
        body.light-theme aside,
        body.light-theme .widget,
        body.light-theme .popular__section-news,
        body.light-theme .wrapp__list__article-responsive {
            background-color: var(--light-bg) !important;
            color: var(--light-text) !important;
            border-color: var(--light-border) !important;
        }

        /* But preserve specific colored elements */
        body.light-theme .btn-primary,
        body.light-theme .bg-primary,
        body.light-theme .text-primary,
        body.light-theme .badge-primary,
        body.light-theme .alert-primary {
            color: #ffffff !important;
        }

        /* Preserve accent colors */
        body.light-theme .btn[style*="background"],
        body.light-theme .badge[style*="background"],
        body.light-theme .card__post__category {
            color: #ffffff !important;
        }

        /* Dark theme - category badges with site color background */
        body:not(.light-theme) .card__post__category,
        body:not(.light-theme) .badge,
        body:not(.light-theme) .category-badge {
            background-color: var(--accent-color) !important;
            color: #ffffff !important;
        }

        /* Dark theme - category badge hover effects */
        body:not(.light-theme) .card__post__category:hover,
        body:not(.light-theme) .badge:hover,
        body:not(.light-theme) .category-badge:hover {
            background-color: var(--accent-color) !important;
            color: #000000 !important;
            transition: color 0.3s ease !important;
        }

        /* Universal category styling - ensures proper colors for all category elements */
        .card__post__category,
        .category-label,
        .post-category,
        .badge.category,
        .category,
        a.category,
        [class*="category"][style*="background-color"] {
            background-color: var(--accent-color) !important;
            color: #ffffff !important;
            padding: 4px 8px !important;
            border-radius: 4px !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            text-decoration: none !important;
            display: inline-block !important;
            transition: all 0.3s ease !important;
        }

        /* Universal category hover effects */
        .card__post__category:hover,
        .category-label:hover,
        .post-category:hover,
        .badge.category:hover,
        .category:hover,
        a.category:hover,
        [class*="category"][style*="background-color"]:hover {
            background-color: var(--accent-color) !important;
            color: #000000 !important;
            text-decoration: none !important;
            transform: translateY(-1px) !important;
        }

        /* SPECIFIC OVERRIDES FOR BROAD SELECTORS - Higher specificity to override wildcards */

        /* Light theme - category elements override broad wildcard selector */
        body.light-theme .category,
        body.light-theme a.category,
        body.light-theme .card__post__category,
        body.light-theme .category-badge,
        body.light-theme .category-label {
            background-color: var(--accent-color) !important;
            color: #ffffff !important;
            text-decoration: none !important;
        }

        body.light-theme .category:hover,
        body.light-theme a.category:hover,
        body.light-theme .card__post__category:hover,
        body.light-theme .category-badge:hover,
        body.light-theme .category-label:hover {
            background-color: var(--accent-color) !important;
            color: #000000 !important;
            text-decoration: none !important;
        }

        /* Dark theme - category elements override broad wildcard selector */
        body:not(.light-theme) .category,
        body:not(.light-theme) a.category,
        body:not(.light-theme) .card__post__category,
        body:not(.light-theme) .category-badge,
        body:not(.light-theme) .category-label {
            background-color: var(--accent-color) !important;
            color: #ffffff !important;
            text-decoration: none !important;
        }

        body:not(.light-theme) .category:hover,
        body:not(.light-theme) a.category:hover,
        body:not(.light-theme) .card__post__category:hover,
        body:not(.light-theme) .category-badge:hover,
        body:not(.light-theme) .category-label:hover {
            background-color: var(--accent-color) !important;
            color: #000000 !important;
            text-decoration: none !important;
        }

        /* Dark theme icon color in toggle button */
        body:not(.light-theme) .theme-toggle-btn {
            color: #ffffff;
            border-color: {{ $settings['site_color'] ?? '#007bff' }};
        }

        body:not(.light-theme) .theme-toggle-btn:hover {
            background: {{ $settings['site_color'] ?? '#007bff' }};
            color: white;
        }

        /* Light theme icon color in toggle button */
        body.light-theme .theme-toggle-btn {
            color: {{ $settings['site_color'] ?? '#007bff' }};
            border-color: {{ $settings['site_color'] ?? '#007bff' }};
        }

        /* Mobile theme toggle - Dark theme styles */
        body:not(.light-theme) .mobile-theme-toggle-btn {
            color: #ffffff;
            border-color: {{ $settings['site_color'] ?? '#007bff' }};
        }

        body:not(.light-theme) .mobile-theme-toggle-btn:hover {
            background: {{ $settings['site_color'] ?? '#007bff' }};
            color: white;
        }

        /* Mobile theme toggle - Light theme styles */
        body.light-theme .mobile-theme-toggle-btn {
            color: {{ $settings['site_color'] ?? '#007bff' }};
            border-color: {{ $settings['site_color'] ?? '#007bff' }};
        }

        body.light-theme .mobile-theme-toggle-btn:hover {
            background: {{ $settings['site_color'] ?? '#007bff' }};
            color: white;
        }

        /* Force light backgrounds for major containers */
        body.light-theme .container,
        body.light-theme .container-fluid,
        body.light-theme .row,
        body.light-theme .col,
        body.light-theme main,
        body.light-theme section,
        body.light-theme article {
            background-color: var(--light-bg) !important;
        }

        /* Override dark theme body styles completely */
        body.light-theme {
            background-color: var(--light-bg) !important;
            color: var(--light-text) !important;
        }

        /* Override all dark theme card and content styles */
        body.light-theme .card,
        body.light-theme .bg-white,
        body.light-theme .card__post,
        body.light-theme .card__post__body,
        body.light-theme .article__entry,
        body.light-theme .wrapper__list__article {
            background-color: var(--light-card) !important;
            color: var(--light-text) !important;
            border-color: var(--light-border) !important;
        }

        /* Override dark theme text styles */
        body.light-theme h1, body.light-theme h2, body.light-theme h3,
        body.light-theme h4, body.light-theme h5, body.light-theme h6,
        body.light-theme p, body.light-theme span, body.light-theme div,
        body.light-theme a, body.light-theme li {
            color: var(--light-text) !important;
        }

        /* Override dark theme navigation */
        body.light-theme .navbar, body.light-theme .topbar, body.light-theme header,
        body.light-theme .navigation-wrap {
            background-color: var(--light-bg) !important;
            border-color: var(--light-border) !important;
        }

        body.light-theme .navbar-nav .nav-link {
            color: var(--light-text) !important;
        }

        /* Override dark theme forms */
        body.light-theme .form-control, body.light-theme .form-select,
        body.light-theme input, body.light-theme textarea {
            background-color: var(--light-card) !important;
            border-color: var(--light-border) !important;
            color: var(--light-text) !important;
        }

        /* Remove only white backgrounds in light mode, preserve site color */
        body.light-theme .bg-white,
        body.light-theme .bg-light,
        body.light-theme [class*="bg-white"],
        body.light-theme [style*="background-color: white"],
        body.light-theme [style*="background-color: #fff"],
        body.light-theme [style*="background-color: #ffffff"],
        body.light-theme [style*="background-color: #f8f9fa"] {
            background-color: transparent !important;
        }

        /* Override any remaining white backgrounds - but be more specific */
        body.light-theme .container,
        body.light-theme .container-fluid,
        body.light-theme .row,
        body.light-theme .col,
        body.light-theme .col-md-8,
        body.light-theme .col-md-4,
        body.light-theme .col-md-6,
        body.light-theme .col-md-3,
        body.light-theme .col-md-2,
        body.light-theme .col-md-12,
        body.light-theme main,
        body.light-theme section,
        body.light-theme article,
        body.light-theme div:not(.card):not(.card__post):not(.card__post__body):not(.article__entry):not(.wrapper__list__article):not(.navbar):not(.topbar):not(header):not(.navigation-wrap):not(.sidebar):not(aside):not(.widget):not(.popular__section-news):not(.wrapp__list__article-responsive) {
            background-color: transparent !important;
        }

        /* But preserve specific colored backgrounds */
        body.light-theme .btn-primary,
        body.light-theme .bg-primary,
        body.light-theme .badge,
        body.light-theme .alert-primary,
        body.light-theme .card,
        body.light-theme .card__post,
        body.light-theme .card__post__body,
        body.light-theme .article__entry,
        body.light-theme .wrapper__list__article,
        body.light-theme .navbar,
        body.light-theme .topbar,
        body.light-theme header,
        body.light-theme .navigation-wrap,
        body.light-theme .sidebar,
        body.light-theme aside,
        body.light-theme .widget,
        body.light-theme .popular__section-news,
        body.light-theme .wrapp__list__article-responsive {
            background-color: var(--light-bg) !important;
        }

        body.light-theme .card,
        body.light-theme .card__post,
        body.light-theme .card__post__body,
        body.light-theme .article__entry,
        body.light-theme .wrapper__list__article {
            background-color: var(--light-card) !important;
        }

        /* Specific light theme text overrides - targeting main content areas only */
        body.light-theme .container h1,
        body.light-theme .container h2,
        body.light-theme .container h3,
        body.light-theme .container h4,
        body.light-theme .container h5,
        body.light-theme .container h6,
        body.light-theme .container p,
        body.light-theme .container span,
        body.light-theme .container div,
        body.light-theme .container li,
        body.light-theme .topbar,
        body.light-theme .topbar *,
        body.light-theme .navbar,
        body.light-theme .navbar *,
        body.light-theme .card,
        body.light-theme .card *,
        body.light-theme .sidebar,
        body.light-theme .sidebar *,
        body.light-theme .article,
        body.light-theme .article *,
        body.light-theme main,
        body.light-theme main * {
            color: var(--light-text) !important;
        }

        /* Keep colored elements colored */
        body.light-theme .btn-primary,
        body.light-theme .btn-primary *,
        body.light-theme .bg-primary,
        body.light-theme .bg-primary *,
        body.light-theme .badge,
        body.light-theme .badge *,
        body.light-theme .alert-primary,
        body.light-theme .alert-primary * {
            color: #ffffff !important;
        }

        /* Exception: Links should be accent colored */
        body.light-theme a {
            color: var(--accent-color) !important;
        }

        body.light-theme a:hover {
            color: var(--light-text) !important;
            text-decoration: underline;
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

        /* Remove only white backgrounds, preserve site color */
        body.light-theme .bg-white,
        body.light-theme .bg-light,
        body.light-theme [class*="bg-white"],
        body.light-theme [style*="background-color: white"],
        body.light-theme [style*="background-color: #fff"],
        body.light-theme [style*="background-color: #ffffff"],
        body.light-theme [style*="background-color: #f8f9fa"],
        body.light-theme [style*="background-color: #ffffff"] {
            background-color: transparent !important;
        }

        /* Preserve site color backgrounds */
        body.light-theme .bg__footer-dark,
        body.light-theme .wrapper__footer,
        body.light-theme .wrapper__footer-bottom,
        body.light-theme footer,
        body.light-theme .footer {
            background-color: {{ $settings['site_color'] ?? '#007bff' }} !important;
        }

        /* Keep site color for buttons and accent elements */
        body.light-theme .btn-primary,
        body.light-theme .bg-primary,
        body.light-theme .badge,
        body.light-theme .alert-primary,
        body.light-theme .card__post__category,
        body.light-theme .list-number,
        body.light-theme .btn-social {
            background-color: {{ $settings['site_color'] ?? '#007bff' }} !important;
        }

        /* Light theme content areas */
        body.light-theme .card,
        body.light-theme .card__post,
        body.light-theme .card__post__body,
        body.light-theme .article__entry,
        body.light-theme .wrapper__list__article,
        body.light-theme .navbar,
        body.light-theme .topbar,
        body.light-theme header,
        body.light-theme .navigation-wrap,
        body.light-theme .sidebar,
        body.light-theme aside,
        body.light-theme .widget,
        body.light-theme .popular__section-news,
        body.light-theme .wrapp__list__article-responsive {
            background-color: var(--light-card) !important;
        }

        /* Main containers with light background */
        body.light-theme .container,
        body.light-theme .container-fluid,
        body.light-theme .row,
        body.light-theme .col,
        body.light-theme .col-md-8,
        body.light-theme .col-md-4,
        body.light-theme .col-md-6,
        body.light-theme .col-md-3,
        body.light-theme .col-md-2,
        body.light-theme .col-md-12,
        body.light-theme main,
        body.light-theme section,
        body.light-theme article {
            background-color: var(--light-bg) !important;
        }

        /* Newsletter Popup Styling for Light Mode */
        body.light-theme .newsletter-popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
            z-index: 99999;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        body.light-theme .newsletter-popup-overlay.active {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        /* Prevent body scroll when popup is active in light mode */
        body.light-theme .newsletter-popup-overlay.active ~ * {
            pointer-events: none;
        }

        body.light-theme .newsletter-popup-overlay.active {
            pointer-events: auto;
        }

        body.light-theme .newsletter-popup-container {
            background: #ffffff;
            border-radius: 16px;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            transform: translateY(30px) scale(0.9);
            transition: all 0.3s ease;
        }

        body.light-theme .newsletter-popup-overlay.active .newsletter-popup-container {
            transform: translateY(0) scale(1);
        }

        body.light-theme .newsletter-popup-close {
            position: absolute;
            top: 15px;
            right: 15px;
            background: transparent;
            border: none;
            color: var(--light-text-muted);
            font-size: 20px;
            cursor: pointer;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            z-index: 10001;
        }

        body.light-theme .newsletter-popup-close:hover {
            background: rgba(0, 0, 0, 0.1);
            color: var(--light-text);
        }

        body.light-theme .newsletter-popup-content {
            padding: 40px 30px 30px;
            text-align: center;
        }

        body.light-theme .newsletter-popup-header {
            margin-bottom: 30px;
        }

        body.light-theme .newsletter-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-color), #00d4ff);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 30px;
            color: white;
            box-shadow: 0 10px 30px rgba(0, 123, 255, 0.3);
        }

        body.light-theme .newsletter-popup-header h3 {
            color: var(--light-text);
            margin-bottom: 10px;
            font-size: 24px;
            font-weight: 700;
        }

        body.light-theme .newsletter-popup-header p {
            color: var(--light-text-muted);
            margin-bottom: 0;
            font-size: 16px;
            line-height: 1.5;
        }

        body.light-theme .newsletter-input-group {
            display: flex;
            gap: 0;
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        body.light-theme .newsletter-input-group input {
            flex: 1;
            padding: 15px 20px;
            border: none;
            background: var(--light-bg);
            color: var(--light-text);
            font-size: 16px;
            outline: none;
        }

        body.light-theme .newsletter-input-group input::placeholder {
            color: var(--light-text-muted);
        }

        body.light-theme .newsletter-submit-btn {
            background: var(--accent-color);
            color: white;
            border: none;
            padding: 15px 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 120px;
        }

        body.light-theme .newsletter-submit-btn:hover {
            background: var(--accent-color);
            filter: brightness(1.1);
        }

        body.light-theme .newsletter-submit-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        body.light-theme .newsletter-benefits {
            display: flex;
            flex-direction: column;
            gap: 8px;
            text-align: left;
            margin-bottom: 25px;
        }

        body.light-theme .newsletter-benefits small {
            color: var(--light-text-muted);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        body.light-theme .newsletter-benefits small i {
            color: #28a745;
            font-size: 12px;
        }

        body.light-theme .newsletter-popup-footer {
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }

        body.light-theme .newsletter-later-btn,
        body.light-theme .newsletter-never-btn {
            background: transparent;
            border: 1px solid var(--light-border);
            color: var(--light-text-muted);
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
            flex: 1;
        }

        body.light-theme .newsletter-later-btn:hover {
            background: var(--light-bg);
            color: var(--light-text);
        }

        body.light-theme .newsletter-never-btn:hover {
            background: rgba(220, 53, 69, 0.1);
            border-color: #dc3545;
            color: #dc3545;
        }










        /* ======================================================================
           FINAL DARK THEME OVERRIDE - MAXIMUM SPECIFICITY TO BEAT dark-theme.css
           ====================================================================== */

        /* Override dark-theme.css card__post__list with maximum specificity */
        body:not(.light-theme) .popular__section-news .wrapper__list-number .card__post__list,
        body:not(.light-theme) .wrapper__list__article .wrapper__list-number .card__post__list,
        body:not(.light-theme) aside .wrapper__list-number .card__post__list,
        body:not(.light-theme) .card__post__list.card__post__list,
        .card__post__list.card__post__list {
            background-color: transparent !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
            margin-bottom: 0 !important;
            border-radius: 0 !important;
        }

        /* Force transparent background with even higher specificity */
        body .popular__section-news .wrapper__list-number .card__post__list,
        body .wrapper__list-article .wrapper__list-number .card__post__list,
        body aside .wrapper__list-number .card__post__list {
            background-color: transparent !important;
            background: none !important;
            border: 0 !important;
            box-shadow: 0 0 0 transparent !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* Nuclear option - target all card__post__list inside popular posts */
        .popular__section-news .card__post__list,
        .wrapper__list-number .card__post__list,
        aside .wrapper__list-number .card__post__list {
            background-color: transparent !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* =================================================================
           MOBILE RESPONSIVENESS & NAVIGATION ENHANCEMENTS
           ================================================================= */

        /* MOBILE OFFCANVAS SIDEBAR - COMPREHENSIVE FIX */

        /* Light Theme Mobile Sidebar - Force White Background */
        .mobile-offcanvas,
        #modal_aside_right .modal-dialog-aside,
        #modal_aside_right .modal-content,
        .modal.fixed-right .modal-dialog-aside .modal-content {
            background-color: #ffffff !important;
            background: #ffffff !important;
            color: #000000 !important;
            border-right: 1px solid #dee2e6 !important;
        }

        /* Light Theme - All Text Elements in Mobile Sidebar */
        .mobile-offcanvas *,
        .mobile-offcanvas .navbar-nav,
        .mobile-offcanvas .navbar-nav .nav-item,
        .mobile-offcanvas .navbar-nav .nav-link,
        .mobile-offcanvas h1, .mobile-offcanvas h2, .mobile-offcanvas h3,
        .mobile-offcanvas h4, .mobile-offcanvas h5, .mobile-offcanvas h6,
        .mobile-offcanvas p, .mobile-offcanvas span, .mobile-offcanvas div,
        .mobile-offcanvas a, .mobile-offcanvas li,
        #modal_aside_right .modal-content *,
        #modal_aside_right .modal-content .list-group .list-group-item {
            color: #000000 !important;
            background: transparent !important;
        }

        /* Dark Theme Mobile Sidebar */
        body:not(.light-theme) .mobile-offcanvas,
        body:not(.light-theme) #modal_aside_right .modal-dialog-aside,
        body:not(.light-theme) #modal_aside_right .modal-content,
        body:not(.light-theme) .modal.fixed-right .modal-dialog-aside .modal-content {
            background-color: var(--dark-card) !important;
            background: var(--dark-card) !important;
            color: var(--dark-text) !important;
            border-right: 1px solid var(--dark-border) !important;
        }

        /* Dark Theme - All Text Elements in Mobile Sidebar */
        body:not(.light-theme) .mobile-offcanvas *,
        body:not(.light-theme) .mobile-offcanvas .navbar-nav,
        body:not(.light-theme) .mobile-offcanvas .navbar-nav .nav-item,
        body:not(.light-theme) .mobile-offcanvas .navbar-nav .nav-link,
        body:not(.light-theme) .mobile-offcanvas h1, body:not(.light-theme) .mobile-offcanvas h2,
        body:not(.light-theme) .mobile-offcanvas h3, body:not(.light-theme) .mobile-offcanvas h4,
        body:not(.light-theme) .mobile-offcanvas h5, body:not(.light-theme) .mobile-offcanvas h6,
        body:not(.light-theme) .mobile-offcanvas p, body:not(.light-theme) .mobile-offcanvas span,
        body:not(.light-theme) .mobile-offcanvas div, body:not(.light-theme) .mobile-offcanvas a,
        body:not(.light-theme) .mobile-offcanvas li,
        body:not(.light-theme) #modal_aside_right .modal-content *,
        body:not(.light-theme) #modal_aside_right .modal-content .list-group .list-group-item {
            color: var(--dark-text) !important;
            background: transparent !important;
        }

        /* Mobile Offcanvas Header - Light Theme */
        .offcanvas-header,
        #modal_aside_right .modal-header {
            background-color: #ffffff !important;
            background: #ffffff !important;
            color: #000000 !important;
            border-bottom: 1px solid #dee2e6 !important;
            padding: 15px 20px !important;
        }

        /* Mobile Offcanvas Header - Dark Theme */
        body:not(.light-theme) .offcanvas-header,
        body:not(.light-theme) #modal_aside_right .modal-header {
            background-color: var(--dark-card) !important;
            background: var(--dark-card) !important;
            color: var(--dark-text) !important;
            border-bottom: 1px solid var(--dark-border) !important;
        }

        /* MOBILE SIDEBAR HEADER FIX - TARGET ACTUAL ELEMENTS */
        #modal_aside_right .modal-header {
            position: relative !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            padding: 15px 20px !important;
            min-height: 60px !important;
            width: 100% !important;
        }

        /* Search Bar in Header */
        #modal_aside_right .modal-header .widget__form-search-bar {
            flex: 1 !important;
            margin-right: 15px !important;
        }

        /* Close Button - FIXED WITH PROPER BACKGROUND */
        #modal_aside_right .modal-header .close {
            position: relative !important;
            color: #000000 !important;
            background-color: #f8f9fa !important; /* Light gray background */
            background: #f8f9fa !important;
            border: 1px solid #dee2e6 !important; /* Subtle border */
            border-radius: 6px !important;
            font-size: 24px !important;
            font-weight: bold !important;
            padding: 0 !important;
            cursor: pointer !important;
            width: 40px !important;
            height: 40px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            z-index: 10 !important;
            flex-shrink: 0 !important;
            margin-left: auto !important;
            transition: all 0.2s ease !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1) !important;
        }

        /* Close Button - Dark Theme */
        body:not(.light-theme) #modal_aside_right .modal-header .close {
            color: var(--dark-text) !important;
            background-color: #495057 !important;
            background: #495057 !important;
            border: 1px solid var(--dark-border) !important;
            box-shadow: 0 1px 3px rgba(255,255,255,0.1) !important;
        }

        /* Close Button Hover Effects */
        #modal_aside_right .modal-header .close:hover {
            background-color: #e9ecef !important;
            background: #e9ecef !important;
            border-color: #adb5bd !important;
            transform: scale(1.05) !important;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15) !important;
            opacity: 1 !important;
        }

        body:not(.light-theme) #modal_aside_right .modal-header .close:hover {
            background-color: #6c757d !important;
            background: #6c757d !important;
            border-color: #adb5bd !important;
            box-shadow: 0 2px 6px rgba(255,255,255,0.15) !important;
        }

        /* Close Button Active/Press State */
        #modal_aside_right .modal-header .close:active {
            transform: scale(0.95) !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2) !important;
        }

        body:not(.light-theme) #modal_aside_right .modal-header .close:active {
            box-shadow: 0 1px 3px rgba(255,255,255,0.2) !important;
        }

        /* Close Button X Symbol */
        #modal_aside_right .modal-header .close span {
            font-size: 28px !important;
            line-height: 1 !important;
        }

        /* MOBILE NAVIGATION LINKS - COMPREHENSIVE FIX */

        /* Navigation Container - Light Theme */
        .mobile-offcanvas .navbar-nav,
        #modal_aside_right .modal-content .modal-body,
        #modal_aside_right .modal-content .list-group {
            flex-direction: column !important;
            width: 100% !important;
            padding: 0 !important;
            background-color: #ffffff !important;
            background: #ffffff !important;
        }

        /* Navigation Container - Dark Theme */
        body:not(.light-theme) .mobile-offcanvas .navbar-nav,
        body:not(.light-theme) #modal_aside_right .modal-content .modal-body,
        body:not(.light-theme) #modal_aside_right .modal-content .list-group {
            background-color: var(--dark-card) !important;
            background: var(--dark-card) !important;
        }

        /* Navigation Items - Light Theme */
        .mobile-offcanvas .navbar-nav .nav-item,
        #modal_aside_right .modal-content .list-group .list-group-item {
            width: 100% !important;
            margin: 0 !important;
            border-bottom: 1px solid #f1f1f1 !important;
            background-color: #ffffff !important;
            background: #ffffff !important;
        }

        /* Navigation Items - Dark Theme */
        body:not(.light-theme) .mobile-offcanvas .navbar-nav .nav-item,
        body:not(.light-theme) #modal_aside_right .modal-content .list-group .list-group-item {
            border-bottom: 1px solid var(--dark-border) !important;
            background-color: var(--dark-card) !important;
            background: var(--dark-card) !important;
        }

        /* Navigation Links - Light Theme */
        .mobile-offcanvas .navbar-nav .nav-link,
        #modal_aside_right .modal-content .list-group .list-group-item {
            color: #000000 !important;
            padding: 15px 20px !important;
            font-weight: 500 !important;
            display: block !important;
            width: 100% !important;
            border: none !important;
            text-decoration: none !important;
            transition: all 0.3s ease !important;
            background-color: #ffffff !important;
            background: #ffffff !important;
        }

        /* Navigation Links - Dark Theme */
        body:not(.light-theme) .mobile-offcanvas .navbar-nav .nav-link,
        body:not(.light-theme) #modal_aside_right .modal-content .list-group .list-group-item {
            color: var(--dark-text) !important;
            background-color: var(--dark-card) !important;
            background: var(--dark-card) !important;
        }

        /* Navigation Links Hover - Light Theme */
        .mobile-offcanvas .navbar-nav .nav-link:hover,
        #modal_aside_right .modal-content .list-group .list-group-item:hover {
            background-color: #f8f9fa !important;
            background: #f8f9fa !important;
            color: var(--accent-color) !important;
            padding-left: 30px !important;
        }

        /* Navigation Links Hover - Dark Theme */
        body:not(.light-theme) .mobile-offcanvas .navbar-nav .nav-link:hover,
        body:not(.light-theme) #modal_aside_right .modal-content .list-group .list-group-item:hover {
            background-color: var(--dark-bg) !important;
            background: var(--dark-bg) !important;
            color: var(--accent-color) !important;
        }

        /* MOBILE DROPDOWN STYLING - TARGET ACTUAL MODAL STRUCTURE */

        /* Dropdown Container in Modal - Must push content below */
        #modal_aside_right .modal-body .nav-item.dropdown,
        #modal_aside_right .modal-body .nav-item {
            position: relative !important;
            width: 100% !important;
        }

        /* Dropdown Menu in Modal - PUSH DOWN INSTEAD OF OVERLAP */
        #modal_aside_right .modal-body .dropdown-menu,
        #modal_aside_right .modal-body .dropdown-menu-left {
            position: static !important; /* Static to push content down */
            display: none !important;
            float: none !important;
            width: 100% !important;
            margin: 0 !important;
            background-color: #f1f1f1 !important;
            background: #f1f1f1 !important;
            border: none !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            padding: 0 !important;
            transform: none !important;
            left: auto !important;
            right: auto !important;
            top: auto !important;
            max-height: 0 !important;
            overflow: hidden !important;
            transition: max-height 0.3s ease, padding 0.3s ease !important;
        }

        /* Dropdown Menu - Dark Theme */
        body:not(.light-theme) #modal_aside_right .modal-body .dropdown-menu,
        body:not(.light-theme) #modal_aside_right .modal-body .dropdown-menu-left {
            background-color: #3a3a3a !important;
            background: #3a3a3a !important;
        }

        /* Show Dropdown - SMOOTH PUSH DOWN ANIMATION */
        #modal_aside_right .modal-body .dropdown-menu.show,
        #modal_aside_right .modal-body .dropdown-menu-left.show,
        #modal_aside_right .modal-body .nav-item.show .dropdown-menu,
        #modal_aside_right .modal-body .nav-item.show .dropdown-menu-left {
            display: block !important;
            max-height: 300px !important; /* Allow content to expand */
            overflow: visible !important;
            padding: 5px 0 !important;
        }

        /* Dropdown Toggle Link Styling */
        #modal_aside_right .modal-body .dropdown-toggle {
            position: relative !important;
            width: 100% !important;
            text-align: left !important;
            border: none !important;
            background: transparent !important;
        }

        /* Dropdown Toggle Arrow */
        #modal_aside_right .modal-body .dropdown-toggle::after {
            position: absolute !important;
            right: 20px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            transition: transform 0.3s ease !important;
        }

        /* Rotate Arrow When Open */
        #modal_aside_right .modal-body .nav-item.show .dropdown-toggle::after {
            transform: translateY(-50%) rotate(180deg) !important;
        }        /* Dropdown Items - Light Theme */
        .mobile-offcanvas .dropdown-item {
            color: #495057 !important;
            padding: 12px 40px !important;
            background: #f8f9fa !important;
            background-color: #f8f9fa !important;
            border: none !important;
            font-size: 14px !important;
            transition: all 0.3s ease !important;
        }

        /* Dropdown Items - Dark Theme */
        body:not(.light-theme) .mobile-offcanvas .dropdown-item {
            color: var(--dark-text-muted) !important;
            background: var(--dark-bg) !important;
            background-color: var(--dark-bg) !important;
        }

        /* Dropdown Items Hover - Light Theme */
        .mobile-offcanvas .dropdown-item:hover {
            background-color: #e9ecef !important;
            background: #e9ecef !important;
            color: var(--accent-color) !important;
            padding-left: 50px !important;
        }

        /* Dropdown Items Hover - Dark Theme */
        body:not(.light-theme) .mobile-offcanvas .dropdown-item:hover {
            background-color: var(--dark-card) !important;
            background: var(--dark-card) !important;
            color: var(--accent-color) !important;
        }

        /* MOBILE DROPDOWN PARENT LINK STYLING */
        .mobile-offcanvas .dropdown-toggle {
            position: relative !important;
            width: 100% !important;
            text-align: left !important;
            border: none !important;
            background: transparent !important;
            padding: 15px 20px !important;
        }

        /* Dropdown Parent Link - Light Theme */
        .mobile-offcanvas .nav-item.dropdown > .nav-link,
        .mobile-offcanvas .nav-item.dropdown > .dropdown-toggle {
            color: #000000 !important;
            background-color: #ffffff !important;
            background: #ffffff !important;
        }

        /* Dropdown Parent Link - Dark Theme */
        body:not(.light-theme) .mobile-offcanvas .nav-item.dropdown > .nav-link,
        body:not(.light-theme) .mobile-offcanvas .nav-item.dropdown > .dropdown-toggle {
            color: var(--dark-text) !important;
            background-color: var(--dark-card) !important;
            background: var(--dark-card) !important;
        }

        /* Dropdown Parent Link Hover - Light Theme */
        .mobile-offcanvas .nav-item.dropdown > .nav-link:hover,
        .mobile-offcanvas .nav-item.dropdown > .dropdown-toggle:hover {
            background-color: #f8f9fa !important;
            background: #f8f9fa !important;
            color: var(--accent-color) !important;
        }

        /* Dropdown Parent Link Hover - Dark Theme */
        body:not(.light-theme) .mobile-offcanvas .nav-item.dropdown > .nav-link:hover,
        body:not(.light-theme) .mobile-offcanvas .nav-item.dropdown > .dropdown-toggle:hover {
            background-color: var(--dark-bg) !important;
            background: var(--dark-bg) !important;
            color: var(--accent-color) !important;
        }

        /* SMOOTH CONTENT REFLOW */
        #modal_aside_right .modal-body .navbar-nav,
        #modal_aside_right .modal-body .list-group {
            overflow: visible !important;
        }

        #modal_aside_right .modal-body .nav-item {
            overflow: visible !important;
        }

        /* MOBILE DROPDOWN JAVASCRIPT ENHANCEMENT */
        /* This will be handled by JavaScript for proper dropdown behavior */

        /* ADDITIONAL OVERRIDES FOR STUBBORN ELEMENTS */

        /* Force all mobile sidebar text to be correct color */
        .modal.fixed-right .modal-dialog-aside .modal-content,
        .modal.fixed-right .modal-dialog-aside .modal-content *,
        .modal.fixed-right .modal-dialog-aside .modal-body *,
        .modal-aside .modal-content,
        .modal-aside .modal-content * {
            color: #000000 !important;
            background-color: #ffffff !important;
        }

        /* Dark theme overrides for modal */
        body:not(.light-theme) .modal.fixed-right .modal-dialog-aside .modal-content,
        body:not(.light-theme) .modal.fixed-right .modal-dialog-aside .modal-content *,
        body:not(.light-theme) .modal.fixed-right .modal-dialog-aside .modal-body *,
        body:not(.light-theme) .modal-aside .modal-content,
        body:not(.light-theme) .modal-aside .modal-content * {
            color: var(--dark-text) !important;
            background-color: var(--dark-card) !important;
        }

        /* Hamburger Menu Button Styling */
        .navbar-toggler {
            border: 1px solid rgba(0,0,0,0.1) !important;
            border-radius: 4px !important;
            padding: 6px 10px !important;
            background: transparent !important;
            transition: all 0.3s ease !important;
        }

        body:not(.light-theme) .navbar-toggler {
            border-color: var(--dark-border) !important;
        }

        .navbar-toggler:hover,
        .navbar-toggler:focus {
            background-color: rgba(0,0,0,0.05) !important;
            border-color: var(--accent-color) !important;
            outline: none !important;
            box-shadow: 0 0 5px rgba(0,0,0,0.1) !important;
        }

        body:not(.light-theme) .navbar-toggler:hover,
        body:not(.light-theme) .navbar-toggler:focus {
            background-color: var(--dark-card) !important;
            border-color: var(--accent-color) !important;
            box-shadow: 0 0 5px rgba(255,255,255,0.1) !important;
        }

        /* Hamburger Icon Lines */
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(0, 0, 0, 0.8)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: center !important;
            background-size: 100% 100% !important;
            width: 24px !important;
            height: 24px !important;
        }

        body:not(.light-theme) .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.9)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
        }

        /* Screen Overlay for Mobile Menu */
        .screen-overlay {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 0% !important;
            height: 100% !important;
            background-color: rgba(0, 0, 0, 0.5) !important;
            z-index: 1150 !important;
            opacity: 0 !important;
            visibility: hidden !important;
            transition: all 0.3s ease !important;
        }

        .screen-overlay.show {
            width: 100% !important;
            opacity: 1 !important;
            visibility: visible !important;
        }

        /* Mobile Search Styling */
        .top-search {
            background-color: #ffffff !important;
            color: #212529 !important;
            border-bottom: 1px solid #dee2e6 !important;
        }

        body:not(.light-theme) .top-search {
            background-color: var(--dark-card) !important;
            color: var(--dark-text) !important;
            border-bottom: 1px solid var(--dark-border) !important;
        }

        .top-search .form-control {
            background-color: #ffffff !important;
            color: #212529 !important;
            border: 1px solid #dee2e6 !important;
        }

        body:not(.light-theme) .top-search .form-control {
            background-color: var(--dark-bg) !important;
            color: var(--dark-text) !important;
            border: 1px solid var(--dark-border) !important;
        }

        /* Topbar Mobile Responsive */
        @media screen and (min-width: 320px) and (max-width: 575px) {
            .topbar .topbar-left .topbar-text {
                padding: 8px 0 !important;
                text-align: center !important;
                font-size: 13px !important;
            }

            .topbar .topbar-right {
                text-align: center !important;
                padding: 5px 0 !important;
            }

            .topbar .topbar-right .topbar-link {
                padding: 5px 0 !important;
            }

            .topbar .topbar-right .topbar-link li {
                padding: 0 8px !important;
                font-size: 12px !important;
            }

            .topbar .topbar-right .topbar-sosmed {
                display: none !important;
            }

            /* Reposition theme toggle on very small screens */
            .theme-toggle-container {
                position: fixed !important;
                bottom: 80px !important;
                right: 20px !important;
                top: auto !important;
                z-index: 1000 !important;
            }

            .theme-toggle-btn {
                width: 45px !important;
                height: 45px !important;
                font-size: 18px !important;
            }
        }

        /* Tablet Responsive */
        @media screen and (min-width: 576px) and (max-width: 768px) {
            .topbar .topbar-left {
                text-align: center !important;
            }

            .topbar .topbar-right {
                text-align: center !important;
                margin: 5px 0 !important;
            }

            .topbar .topbar-right .topbar-sosmed {
                display: none !important;
            }

            .topbar_language {
                margin-right: 10px !important;
            }

            .topbar_language select {
                padding: 5px 13px !important;
                margin-right: 10px !important;
            }
        }

        /* Navigation Bar Mobile Adjustments */
        @media screen and (max-width: 991px) {
            .navbar {
                padding: 8px 15px !important;
            }

            .navbar-brand img {
                max-height: 40px !important;
            }

            .navbar-nav {
                margin-top: 10px !important;
            }

            /* Ensure mobile offcanvas is properly styled */
            .mobile-offcanvas {
                width: 85% !important;
                max-width: 320px !important;
            }

            /* Hide desktop navigation */
            .navbar-collapse:not(.mobile-offcanvas) {
                display: none !important;
            }
        }

        /* Large Mobile Landscape */
        @media screen and (min-width: 576px) and (max-width: 991px) {
            .mobile-offcanvas {
                width: 70% !important;
                max-width: 300px !important;
            }
        }

        /* Content Spacing Mobile Adjustments */
        @media screen and (min-width: 320px) and (max-width: 575px) {
            .pb-80 {
                padding-bottom: 40px !important;
            }

            .pb-60 {
                padding-bottom: 30px !important;
            }

            section {
                padding: 20px 0 !important;
            }

            .container {
                padding-left: 15px !important;
                padding-right: 15px !important;
            }

            /* Popular posts mobile styling */
            .popular__section-news .card__post__list {
                padding: 10px !important;
                margin-bottom: 10px !important;
            }

            .wrapper__list-number .list-number {
                width: 35px !important;
                height: 35px !important;
                font-size: 14px !important;
                line-height: 35px !important;
            }

            /* Category badges mobile */
            .card__post__category {
                font-size: 12px !important;
                padding: 4px 8px !important;
            }

            /* Mobile typography adjustments */
            h1 { font-size: 24px !important; }
            h2 { font-size: 20px !important; }
            h3 { font-size: 18px !important; }
            h4 { font-size: 16px !important; }
            h5 { font-size: 14px !important; }
            h6 { font-size: 13px !important; }

            p {
                font-size: 14px !important;
                line-height: 1.5 !important;
            }
        }

        /* Enhanced Mobile Menu Animation */
        @media all and (max-width: 991px) {
            .mobile-offcanvas {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
                box-shadow: 2px 0 10px rgba(0,0,0,0.1) !important;
            }

            body:not(.light-theme) .mobile-offcanvas {
                box-shadow: 2px 0 10px rgba(255,255,255,0.05) !important;
            }

            .mobile-offcanvas.show {
                box-shadow: 2px 0 20px rgba(0,0,0,0.2) !important;
            }

            body:not(.light-theme) .mobile-offcanvas.show {
                box-shadow: 2px 0 20px rgba(255,255,255,0.1) !important;
            }

            /* Mobile menu items staggered animation */
            #modal_aside_right .modal-body .navbar-nav .nav-item {
                opacity: 0.8 !important;
                transform: translateX(-20px) !important;
                transition: all 0.3s ease !important;
            }

            #modal_aside_right.show .modal-body .navbar-nav .nav-item {
                opacity: 1 !important;
                transform: translateX(0) !important;
            }

            #modal_aside_right.show .modal-body .navbar-nav .nav-item:nth-child(1) { transition-delay: 0.1s !important; }
            #modal_aside_right.show .modal-body .navbar-nav .nav-item:nth-child(2) { transition-delay: 0.15s !important; }
            #modal_aside_right.show .modal-body .navbar-nav .nav-item:nth-child(3) { transition-delay: 0.2s !important; }
            #modal_aside_right.show .modal-body .navbar-nav .nav-item:nth-child(4) { transition-delay: 0.25s !important; }
            #modal_aside_right.show .modal-body .navbar-nav .nav-item:nth-child(5) { transition-delay: 0.3s !important; }
        }

        /* Mobile Forms and Inputs */
        @media screen and (max-width: 768px) {
            .form-control,
            .form-select,
            input,
            textarea {
                font-size: 16px !important; /* Prevents zoom on iOS */
                padding: 12px 15px !important;
            }

            .btn {
                padding: 12px 20px !important;
                font-size: 14px !important;
            }

            /* Mobile newsletter popup adjustments */
            .newsletter-popup-container {
                width: 95% !important;
                margin: 20px !important;
                border-radius: 12px !important;
            }

            .newsletter-popup-content {
                padding: 25px 20px 20px !important;
            }

            .newsletter-icon {
                width: 60px !important;
                height: 60px !important;
                font-size: 24px !important;
            }

            .newsletter-popup-header h3 {
                font-size: 20px !important;
            }

            .newsletter-input-group {
                flex-direction: column !important;
                gap: 10px !important;
            }

            .newsletter-input-group input,
            .newsletter-submit-btn {
                border-radius: 6px !important;
            }
        }

        /* Accessibility Improvements */
        @media (prefers-reduced-motion: reduce) {
            .mobile-offcanvas,
            .screen-overlay,
            .navbar-toggler,
            .mobile-offcanvas .navbar-nav .nav-item {
                transition: none !important;
            }
        }

        /* High Contrast Mode Support */
        @media (prefers-contrast: high) {
            .navbar-toggler {
                border-width: 2px !important;
            }

            .mobile-offcanvas .navbar-nav .nav-item {
                border-bottom-width: 2px !important;
            }

            .navbar-toggler-icon {
                filter: contrast(2) !important;
            }
        }

        /* Print Styles */
        @media print {
            .mobile-offcanvas,
            .navbar-toggler,
            .theme-toggle-container,
            .screen-overlay,
            .back-to-top-btn,
            .newsletter-popup-overlay {
                display: none !important;
            }
        }

        /* ===== MOBILE FOOTER STYLES FROM STYLES.CSS ===== */

        /* Base footer wrapper styles */
        .wrapper__footer {
            padding: 60px 0;
            position: relative;
        }

        @media screen and (min-width: 320px) and (max-width: 575px) {
            .wrapper__footer {
                padding: 40px 0;
            }
        }

        .wrapper__footer .widget__footer {
            display: block;
        }

        .wrapper__footer .widget__footer .dropdown-footer {
            display: block;
            cursor: pointer;
        }

        .wrapper__footer .widget__footer .footer-title {
            font-size: 18px;
            text-transform: capitalize;
            margin-bottom: 15px;
            font-family: "Poppins", sans-serif;
        }

        @media screen and (min-width: 320px) and (max-width: 575px) {
            .wrapper__footer .widget__footer .footer-title {
                font-size: 16px;
            }
        }

        .wrapper__footer .widget__footer span {
            float: right;
        }

        .wrapper__footer .widget__footer p {
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 0;
        }

        @media screen and (min-width: 320px) and (max-width: 575px) {
            .wrapper__footer .widget__footer p {
                margin-bottom: 30px;
            }
        }

        .wrapper__footer .widget__footer .blog-tags ul li a {
            border: 1px solid #848f9a;
            color: #848f9a;
        }

        .wrapper__footer .widget__footer .blog-tags ul li a:hover {
            border: 1px solid {{ $settings['site_color'] ?? '#007bff' }};
            background-color: transparent;
        }

        .wrapper__footer .widget__footer .link__category {
            position: relative;
            padding: 15px 0;
        }

        .wrapper__footer .widget__footer .link__category ul {
            -webkit-columns: 3;
            -moz-columns: 3;
            columns: 3;
            -webkit-column-gap: 20px;
            -moz-column-gap: 20px;
            column-gap: 20px;
            margin-bottom: 0;
        }

        @media screen and (min-width: 576px) and (max-width: 768px) {
            .wrapper__footer .widget__footer .link__category ul {
                -webkit-columns: 2;
                -moz-columns: 2;
                columns: 2;
                -webkit-column-gap: 30px;
                -moz-column-gap: 30px;
                column-gap: 30px;
            }
        }

        .wrapper__footer .widget__footer .link__category ul li {
            margin: 0;
            padding: 0;
            line-height: normal;
            -webkit-column-break-inside: avoid;
            -moz-column-break-inside: avoid;
            break-inside: avoid;
            display: block;
        }

        .wrapper__footer .widget__footer .link__category ul li a {
            text-transform: capitalize;
            font-weight: 700;
            font-size: 14px;
            font-family: "Montserrat", sans-serif;
        }

        .wrapper__footer .widget__footer .link__category ul li a:hover {
            color: black !important;
        }

        .wrapper__footer .widget__footer .is-hidden {
            display: block;
        }

        @media screen and (min-width: 320px) and (max-width: 575px) {
            .wrapper__footer .widget__footer .is-hidden {
                display: none;
            }
        }

        .wrapper__footer .dropdown-footer span:before {
            content: " ";
        }

        @media screen and (min-width: 320px) and (max-width: 575px) {
            .wrapper__footer .dropdown-footer span:before {
                content: "\f055 ";
            }

            .wrapper__footer .dropdown-footer.is-active span:before {
                content: "\f056   ";
            }
        }

        .wrapper__footer .list-unstyled a {
            font-family: "Montserrat", sans-serif;
            text-transform: capitalize;
            font-size: 14px;
            line-height: 35px;
            font-weight: 400;
        }

        .wrapper__footer figure.image-logo {
            width: 175px;
        }

        .wrapper__footer figure.image-logo img {
            position: relative;
            width: 100%;
            max-width: 100%;
            height: auto;
            -o-object-fit: cover;
            object-fit: cover;
        }

        @media screen and (min-width: 320px) and (max-width: 575px) {
            .wrapper__footer .social__media {
                text-align: left;
            }
        }

        .wrapper__footer .social__media .list-inline {
            margin-bottom: 0;
            display: flex;
            flex-wrap: wrap;
        }

        .wrapper__footer .social__media .list-inline li {
            width: auto !important;
        }

        @media screen and (min-width: 320px) and (max-width: 575px) {
            .wrapper__footer .social__media .list-inline {
                margin-bottom: 15px;
            }
        }

        .wrapper__footer .social__media .list-inline span {
            font-family: "Montserrat", sans-serif;
            text-transform: capitalize;
            font-size: 11px;
            font-weight: 700;
            margin-right: 10px;
        }

        @media screen and (min-width: 320px) and (max-width: 575px) {
            .wrapper__footer .social__media .list-inline span {
                display: block;
                margin-bottom: 10px;
            }
        }

        .wrapper__footer .social__media .list-inline .list-inline-item .btn-social.whatsapp {
            background-color: #25d366;
        }

        .wrapper__footer .social__media .list-inline .list-inline-item .btn-social.telegram {
            background-color: #179cde;
        }

        .bg__footer-bottom {
            padding: 15px 0;
        }

        .bg__footer-bottom span {
            font-size: 12px;
            font-weight: 600;
            font-family: "Montserrat", sans-serif;
        }

        @media screen and (min-width: 320px) and (max-width: 575px) {
            .bg__footer-bottom span {
                text-align: center;
                display: block;
            }
        }

        .bg__footer-bottom span a {
            text-transform: uppercase;
        }

        .bg__footer-bottom .list-inline {
            margin-bottom: 0;
            text-align: right;
        }

        @media screen and (min-width: 320px) and (max-width: 575px) {
            .bg__footer-bottom .list-inline {
                text-align: center;
                margin-bottom: 5px;
            }
        }

        .bg__footer-bottom .list-inline .list-inline-item a {
            font-family: "Montserrat", sans-serif;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }

        /* ===== THEME-SPECIFIC FOOTER TEXT COLORS ===== */

        /* Light theme footer text (black text) */
        body:not(.dark-theme) .wrapper__footer .widget__footer .footer-title,
        body:not(.dark-theme) .wrapper__footer .widget__footer p,
        body:not(.dark-theme) .wrapper__footer .widget__footer .link__category ul li a,
        body:not(.dark-theme) .wrapper__footer .list-unstyled a,
        body:not(.dark-theme) .wrapper__footer .option-content a,
        body:not(.dark-theme) .wrapper__footer .option-content li,
        body:not(.dark-theme) .wrapper__footer .option-content li a,
        body:not(.dark-theme) .wrapper__footer .social__media .list-inline span,
        body:not(.dark-theme) .bg__footer-bottom span,
        body:not(.dark-theme) .bg__footer-bottom span a,
        body:not(.dark-theme) .bg__footer-bottom .list-inline .list-inline-item a {
            color: #000000 !important;
        }

        /* Dark theme footer text (white text) */
        body.dark-theme .wrapper__footer .widget__footer .footer-title,
        body.dark-theme .wrapper__footer .widget__footer p,
        body.dark-theme .wrapper__footer .widget__footer .link__category ul li a,
        body.dark-theme .wrapper__footer .list-unstyled a,
        body.dark-theme .wrapper__footer .option-content a,
        body.dark-theme .wrapper__footer .option-content li,
        body.dark-theme .wrapper__footer .option-content li a,
        body.dark-theme .wrapper__footer .social__media .list-inline span,
        body.dark-theme .bg__footer-bottom span,
        body.dark-theme .bg__footer-bottom span a,
        body.dark-theme .bg__footer-bottom .list-inline .list-inline-item a {
            color: #ffffff !important;
        }

        /* Hover states for footer links with theme support */
        body:not(.dark-theme) .wrapper__footer .widget__footer .blog-tags ul li a:hover {
            color: #ffffff !important;
        }

        body.dark-theme .wrapper__footer .widget__footer .blog-tags ul li a:hover {
            color: #ffffff !important;
        }

        /* Additional footer dropdown content styling */
        .wrapper__footer .option-content {
            background: transparent !important;
            border: none !important;
            padding: 0 !important;
            margin-top: 10px !important;
        }

        .wrapper__footer .option-content li {
            margin-bottom: 8px !important;
            padding: 0 !important;
            list-style: none !important;
            background: transparent !important;
        }

        .wrapper__footer .option-content li a {
            display: block !important;
            padding: 5px 0 !important;
            text-decoration: none !important;
            transition: all 0.3s ease !important;
            background: transparent !important;
        }

        /* Light theme dropdown content hover */
        body:not(.dark-theme) .wrapper__footer .option-content li a:hover {
            color: black !important;
            padding-left: 10px !important;
        }

        /* Dark theme dropdown content hover */
        body.dark-theme .wrapper__footer .option-content li a:hover {
            color: white !important;
            padding-left: 10px !important;
        }

        /* Ensure dropdown content is visible when toggled */
        .wrapper__footer .option-content.is-visible,
        .wrapper__footer .option-content:not(.is-hidden) {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        /* Footer background adjustments */
        .bg__footer {
            background-color: #1b1c26;
        }

        .bg__footer-dark {
            background-color: var(--colorPrimary);
        }

        .border-top-5 {
            border-top: 5px solid var(--colorPrimary);
        }

        .border-top-1 {
            border-top: 1px solid #eeeeee57;
        }

        .border-line {
            height: 1px;
            margin: 15px 0;
            background-color: #2e2f3c;
        }

        /* Responsive footer border adjustments */
        body:not(.dark-theme) .border-line {
            background-color: #e0e0e0;
        }

        body.dark-theme .border-line {
            background-color: #2e2f3c;
        }

        body:not(.dark-theme) .border-top-1 {
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        body.dark-theme .border-top-1 {
            border-top: 1px solid #eeeeee57;
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

            // Dark/Light Theme Toggle Functionality
            const themeToggle = document.getElementById('theme-toggle');
            const mobileThemeToggle = document.getElementById('mobile-theme-toggle');
            const themeIcon = document.getElementById('theme-icon');
            const mobileThemeIcon = document.getElementById('mobile-theme-icon');
            const body = document.body;

            // Get saved theme or default to dark
            const savedTheme = localStorage.getItem('theme') || 'dark';

            // Apply initial theme
            function applyTheme(theme) {
                const darkThemeLink = document.getElementById('dark-theme-css');

                // Add transition for smooth switching
                body.style.transition = 'all 0.3s ease';

                if (theme === 'light') {
                    // Remove dark theme class first
                    body.classList.remove('dark-theme');

                    // Add light theme class
                    body.classList.add('light-theme');

                    // Disable dark theme CSS completely
                    if (darkThemeLink) {
                        darkThemeLink.disabled = true;
                        darkThemeLink.media = 'none';
                    }

                    // Update both desktop and mobile icons
                    if (themeIcon) themeIcon.className = 'fas fa-sun';
                    if (mobileThemeIcon) mobileThemeIcon.className = 'fas fa-sun';
                    console.log('🌞 Light theme activated - Dark CSS disabled');
                } else {
                    // Enable dark theme CSS first
                    if (darkThemeLink) {
                        darkThemeLink.disabled = false;
                        darkThemeLink.media = 'all';
                    }

                    // Remove light theme class
                    body.classList.remove('light-theme');

                    // Add dark theme class for additional specificity
                    body.classList.add('dark-theme');

                    // Update both desktop and mobile icons
                    if (themeIcon) themeIcon.className = 'fas fa-moon';
                    if (mobileThemeIcon) mobileThemeIcon.className = 'fas fa-moon';
                    console.log('🌙 Dark theme activated - Dark CSS enabled');
                }

                // Force a reflow to ensure styles are applied
                body.offsetHeight;

                // Remove transition after theme switch is complete
                setTimeout(() => {
                    body.style.transition = '';
                }, 400);
            }

            // Initialize theme on page load
            applyTheme(savedTheme);

            // Theme toggle function (shared by both buttons)
            function toggleTheme(button) {
                const currentTheme = body.classList.contains('light-theme') ? 'light' : 'dark';
                const newTheme = currentTheme === 'light' ? 'dark' : 'light';

                // Add click animation
                button.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    button.style.transform = '';
                }, 150);

                // Apply new theme
                applyTheme(newTheme);

                // Save preference
                localStorage.setItem('theme', newTheme);

                // Show notification
                if (typeof Toast !== 'undefined') {
                    Toast.fire({
                        icon: 'success',
                        title: `${newTheme === 'light' ? 'Light' : 'Dark'} theme activated!`,
                        timer: 1500
                    });
                }

                console.log(`🎨 Theme switched to: ${newTheme} (via ${button.id})`);
            }

            // Desktop theme toggle click handler
            if (themeToggle) {
                themeToggle.addEventListener('click', function() {
                    toggleTheme(this);
                });
            }

            // Mobile theme toggle click handler
            if (mobileThemeToggle) {
                mobileThemeToggle.addEventListener('click', function() {
                    toggleTheme(this);
                });
            }

            // Keyboard shortcut for theme toggle (Ctrl+Shift+T)
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey && e.shiftKey && e.key === 'T') {
                    e.preventDefault();
                    // Use whichever button is available (desktop or mobile)
                    const activeToggle = themeToggle || mobileThemeToggle;
                    if (activeToggle) {
                        toggleTheme(activeToggle);
                    }
                }
            });

            // Console info for theme toggle
            console.log(`
🎨 THEME TOGGLE FEATURE ACTIVE
==============================
• Current theme: ${savedTheme}
• Toggle button: Top-right of header
• Keyboard shortcut: Ctrl+Shift+T
• Smooth transitions between themes
• Remembers user preference
• Icons: 🌙 (dark) / ☀️ (light)
            `);

            // MOBILE DROPDOWN BEHAVIOR FIX
            // Handle mobile sidebar dropdown behavior to push content down
            $(document).ready(function() {
                // Handle mobile dropdown toggle
                $('#modal_aside_right .dropdown-toggle').on('click', function(e) {
                    e.preventDefault();

                    const $dropdownItem = $(this).closest('.nav-item');
                    const $dropdownMenu = $dropdownItem.find('.dropdown-menu, .dropdown-menu-left');

                    // Close other dropdowns
                    $('#modal_aside_right .nav-item').not($dropdownItem).removeClass('show');
                    $('#modal_aside_right .dropdown-menu, #modal_aside_right .dropdown-menu-left').not($dropdownMenu).removeClass('show');

                    // Toggle current dropdown
                    $dropdownItem.toggleClass('show');
                    $dropdownMenu.toggleClass('show');

                    console.log('📱 Mobile dropdown toggled');
                });

                // Close dropdowns when clicking outside
                $('#modal_aside_right').on('click', function(e) {
                    if (!$(e.target).closest('.dropdown-toggle').length) {
                        $('#modal_aside_right .nav-item').removeClass('show');
                        $('#modal_aside_right .dropdown-menu, #modal_aside_right .dropdown-menu-left').removeClass('show');
                    }
                });

                console.log('📱 Mobile dropdown behavior initialized');
            });

            // MOBILE FOOTER DROPDOWN FUNCTIONALITY
            // Handle mobile footer dropdown toggles (show/hide content on small screens)
            $(document).ready(function() {
                // Initialize footer dropdowns for mobile
                function initMobileFooterDropdowns() {
                    console.log('🦶 Initializing mobile footer dropdowns...');

                    // Find all footer dropdown elements
                    $('.wrapper__footer .dropdown-footer').each(function() {
                        const $dropdownContainer = $(this);
                        const $dropdownHeader = $dropdownContainer.find('.footer-title');
                        const $widget = $dropdownContainer.closest('.widget__footer');
                        const $hiddenContent = $widget.find('.option-content.is-hidden, .is-hidden');
                        const $icon = $dropdownHeader.find('span');

                        console.log('🔍 Found dropdown:', {
                            container: $dropdownContainer.length,
                            header: $dropdownHeader.length,
                            content: $hiddenContent.length,
                            icon: $icon.length,
                            screenWidth: window.innerWidth
                        });

                        // Only activate on mobile screens
                        if (window.innerWidth <= 575) {
                            // Add click handler to the header title
                            $dropdownHeader.off('click.footerDropdown').on('click.footerDropdown', function(e) {
                                e.preventDefault();
                                e.stopPropagation();

                                const $this = $(this);
                                const $currentWidget = $this.closest('.widget__footer');
                                const $currentHiddenContent = $currentWidget.find('.option-content.is-hidden, .option-content');
                                const $currentIcon = $this.find('span');

                                console.log('📱 Footer dropdown clicked:', {
                                    title: $this.text().trim(),
                                    contentFound: $currentHiddenContent.length,
                                    isVisible: $currentHiddenContent.is(':visible'),
                                    contentHTML: $currentHiddenContent.html(),
                                    contentText: $currentHiddenContent.text()
                                });

                                // Toggle active class on dropdown container
                                $dropdownContainer.toggleClass('is-active');

                                // Toggle visibility of hidden content
                                if ($dropdownContainer.hasClass('is-active')) {
                                    $currentHiddenContent.slideDown(400).addClass('is-visible').removeClass('is-hidden');
                                    $currentIcon.removeClass('fa-angle-down').addClass('fa-angle-up');
                                    console.log('📱 Footer dropdown opened - Content should be visible now');
                                } else {
                                    $currentHiddenContent.slideUp(400, function() {
                                        $(this).removeClass('is-visible').addClass('is-hidden');
                                    });
                                    $currentIcon.removeClass('fa-angle-up').addClass('fa-angle-down');
                                    console.log('📱 Footer dropdown closed');
                                }
                            });

                            // Also add click handler to the dropdown container itself as backup
                            $dropdownContainer.off('click.footerDropdownContainer').on('click.footerDropdownContainer', function(e) {
                                if (e.target === this || $(e.target).is('span')) {
                                    $dropdownHeader.trigger('click');
                                }
                            });

                            // Ensure content starts hidden on mobile
                            $hiddenContent.hide();
                            $icon.removeClass('fa-angle-up').addClass('fa-angle-down');

                            // Add cursor pointer style
                            $dropdownHeader.css('cursor', 'pointer');
                            $dropdownContainer.css('cursor', 'pointer');

                        } else {
                            // On desktop, show all content and remove click handlers
                            $dropdownHeader.off('click.footerDropdown');
                            $dropdownContainer.off('click.footerDropdownContainer');
                            $dropdownContainer.removeClass('is-active');
                            $hiddenContent.show();
                            $icon.removeClass('fa-angle-up').addClass('fa-angle-down');

                            // Remove cursor pointer
                            $dropdownHeader.css('cursor', '');
                            $dropdownContainer.css('cursor', '');
                        }
                    });
                }

                // Initialize on page load
                setTimeout(initMobileFooterDropdowns, 100);

                // Reinitialize on window resize
                $(window).on('resize', function() {
                    clearTimeout(window.footerDropdownResize);
                    window.footerDropdownResize = setTimeout(function() {
                        initMobileFooterDropdowns();
                    }, 250);
                });

                console.log('🦶 Mobile footer dropdown functionality initialized');
            });

        });

    </script>

    @stack('content')

</body>

</html>
