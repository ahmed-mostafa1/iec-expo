<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>المعرض الدولي للتجارة اﻹلكترونية</title>
  <meta name="description" content="Join industry leaders for the premier business conference. March 15-17, 2025 in Riyadh. Register now for networking, innovation, and growth." />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&family=Work+Sans:wght@400;500;600;700&family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <style>
    :root {
      --primary-color: rgba(96, 36, 193, 1);
      --secondary-color: #6024c1;
      --accent-color: #6024c1;
      --dark-color: #1a1a1a;
      --light-color: #f8f9fa;
      --text-color: #333;
      --text-light: #666;
      --border-radius: 12px;
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      --background: 0 0 0;
      --foreground: 248 248 248;
      /* --card: 251 251 248; */
      --card: 18 18 18;
      --card-foreground: 248 248 248;
      --primary: 152, 3, 189, 1;
      --primary-foreground: 251 251 248;
      --secondary: 226 233 226;
      --secondary-foreground: 69 84 69;
      --muted: 20 20 20;
      --muted-foreground: 248 248 248;
      --accent: 28 28 28;
      --accent-foreground: 248 248 248;
      --border:152, 3, 189, 1;
      --ring: 51 153 88;
      --radius: 0.75rem;
      --chart-1: #9803bd;
      --chart-2: 70 185 147;
      --chart-3: 69 161 161;
      --button-bg: #9803bd;
      --button-hover-bg: rgba(96, 36, 193, 1);
      --button-text: #ffffff;
      --hover-accent: #ffffff;
    }


    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    [data-animate] {
      opacity: 0;
      transform: translateY(20px) scale(0.98);
      transition: opacity 0.6s ease, transform 0.6s ease;
    }

    [data-animate].visible {
      opacity: 1;
      transform: translateY(0) scale(1);
    }

    @keyframes heroFloat {

      0%,
      100% {
        transform: translateY(0) scale(1);
      }

      50% {
        transform: translateY(-12px) scale(1.01);
      }
    }

    @keyframes softPulse {

      0%,
      100% {
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
      }

      50% {
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.12);
      }
    }

    body {
      font-family: 'Cairo', 'Work Sans', sans-serif;
      background-color: rgb(var(--background));
      color: rgb(var(--foreground));
      line-height: 1.6;
    }

    html {
      scroll-behavior: smooth;
    }

    .container {
      max-width: 1280px;
      margin: 0 auto;
      padding: 1rem;
    }

    .hero .container {
      width: 100%;
      max-width: none;
      padding: 0;
    }

    /* Header */
    .header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 50;
      background: #000;
      backdrop-filter: blur(12px);
    }

    .header-inner {
      display: grid;
      grid-template-columns: auto 1fr auto;
      align-items: center;
      height: 64px;
      gap: 1rem;
    }

    .logo {
      font-size: 1.25rem;
      font-weight: 700;
      color: rgb(var(--primary));
      text-decoration: none;
    }

    .nav {
      display: none;
      align-items: center;
      gap: 1rem;
      justify-self: center;
    }



    .nav-link {
      text-decoration: none;
      position: relative;
      transition: color 0.4s ease;
      color: #fff;
      font-weight: 600;
      text-transform: uppercase;
      display: inline-flex;
      align-items: center;
      opacity: 0;
      transform: translateY(-12px);
      animation: navLinkFade 0.6s ease forwards;
    }

    .nav-link:hover {
      color: #9803bde1;
    }

    .nav-link::before {
      content: "";
      position: absolute;
      width: 0;
      height: 4px;
      bottom: 0;
      left: 50%;
      background-color: #9803bde1;
      transition: all 0.4s;
    }

    .nav-link:hover::before {
      width: 100%;
      left: 0;
    }

    .nav .nav-link:nth-child(1) {
      animation-delay: 0.1s;
    }

    .nav .nav-link:nth-child(2) {
      animation-delay: 0.2s;
    }

    .nav .nav-link:nth-child(3) {
      animation-delay: 0.3s;
    }

    .nav .nav-link:nth-child(4) {
      animation-delay: 0.4s;
    }

    .nav .nav-link:nth-child(5) {
      animation-delay: 0.5s;
    }

    .nav .nav-link:nth-child(6) {
      animation-delay: 0.6s;
    }

    .nav .nav-link:nth-child(7) {
      animation-delay: 0.7s;
    }

    @keyframes navLinkFade {
      from {
        opacity: 0;
        transform: translateY(-12px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes shimmer111 {
      0% {
        background-position: 200% 0;
      }

      100% {
        background-position: -200% 0;
      }
    }





    .nav-logo {
      height: 60px;
    }
    .nav-logo-bu{
      height: 60px;
    }

    .header-right {
      display: flex;
      align-items: center;
      gap: 1rem;
      justify-content: flex-end;
    }

    .logo-secondary {
      font-size: 1rem;
      letter-spacing: 0.08em;
      text-transform: uppercase;
    }

    .header-actions {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .lang-switch {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.875rem;
      font-weight: 500;
      color: rgb(var(--foreground) / 0.8);
      background: none;
      border: none;
      cursor: pointer;
      transition: color 0.2s;
      color: #fff;
      font-family: 'Cairo', 'Work Sans', sans-serif;
    }

    .lang-switch:hover {
      color: #9873AC;
    }

    #lang-text {
      font-family: 'Cairo', 'Work Sans', sans-serif;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0.625rem 1.25rem;
      border-radius: var(--radius);
      font-weight: 500;
      font-size: 0.875rem;
      cursor: pointer;
      transition: all 0.2s;
      text-decoration: none;
      border: none;
      background-color: var(--button-bg);
      color: var(--button-text);
    }

    .btn:hover,
    .btn:focus-visible {
      background-color: var(--button-hover-bg);
      color: var(--hover-accent);
      text-shadow: 0 0 6px rgba(0, 0, 0, 0.45);
    }

    .btn-outline {
      background: var(--button-bg);
      color: var(--button-text);
      border: none;
    }

    .btn-outline:hover {
      background: var(--button-hover-bg);
      color: var(--hover-accent);
      text-shadow: 0 0 6px rgba(0, 0, 0, 0.45);
    }

    button:hover,
    button:focus-visible,
    a:hover,
    a:focus-visible {
      color: #9873AC;
    }

    .btn-lg {
      padding: 0.875rem 1.75rem;
      font-size: 1rem;
    }

    .mobile-menu-btn {
      display: none;
      padding: 0.5rem;
      background: none;
      border: none;
      cursor: pointer;
    }

    .mobile-nav {
      display: none;
      padding: 1rem 0;
      border-top: 1px solid rgb(var(--border));
    }

    .mobile-nav.active {
      display: block;
    }

    .mobile-nav-link {
      display: block;
      padding: 0.75rem 0;
      color: rgb(var(--foreground) / 0.8);
      text-decoration: none;
      font-weight: 500;
    }

    /* Hero Section */
    .hero {
      min-height: 40vh;
      display: flex;
      align-items: center;
      padding-bottom: 20px;
      position: relative;
      overflow: hidden;
    }

    .hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgb(var(--accent)), rgb(var(--background)), rgb(var(--background)));
    }

    .hero::after {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(ellipse at top right, rgb(var(--primary) / 0.1), transparent 50%);
    }

    .hero-grid {
      position: relative;
      z-index: 10;
      display: grid;
      place-items: center;
      gap: 2rem;
      min-height: calc(100vh - 20rem);
      width: 100vw;
    }

    .hero-media {
      width: 100vw;
      max-width: none;
    }

    .hero-video-frame {
      position: relative;
      /* border-radius: 1.5rem; */
      overflow: hidden;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
      aspect-ratio: 16 / 9;
      background: #000;
      animation: heroFloat 12s ease-in-out infinite;
    }

    .hero-video-frame::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.05));
      pointer-events: none;
    }

    .hero-video {
      width: 100vw;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    .hero-video-caption {
      position: absolute;
      bottom: 1.25rem;
      left: 1.25rem;
      right: 1.25rem;
      z-index: 2;
      color: #fff;
      display: flex;
      flex-direction: column;
      gap: 0.25rem;
      text-shadow: 0 4px 12px rgba(0, 0, 0, 0.45);
    }

    .hero-video-caption span {
      font-size: 0.9rem;
      text-transform: uppercase;
      letter-spacing: 0.2em;
    }

    .hero-video-caption strong {
      font-size: 1.5rem;
      font-weight: 700;
    }

    /* Scroll indicator */
    /* .scroll-indicator {
      position: absolute;
      bottom: 0.5rem;
      left: 50%;
      transform: translateX(-50%);
      animation: bounce 1s infinite;
      z-index: 30;
      text-decoration: none;
      color: rgb(var(--muted-foreground));
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 44px;
      height: 44px;
      border-radius: 999px;
      border: 1px solid rgb(var(--border));
      background: rgb(var(--card) / 0.6);
      backdrop-filter: blur(6px);
    }

    .scroll-indicator:hover {
      color: rgb(var(--primary));
      border-color: rgb(var(--primary) / 0.4);
    } */

    @keyframes bounce {

      0%,
      100% {
        transform: translateX(-50%) translateY(0);
      }

      50% {
        transform: translateX(-50%) translateY(-10px);
      }
    }

    /* Highlights Section */
    .highlights {
      padding: 4rem 0;
      background: rgb(var(--background));
    }

    .highlights-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1.5rem;
    }



    .highlight-card {
      background: rgb(var(--card));
      border: 1px solid rgb(var(--border));
      border-radius: var(--radius);
      padding: 1.5rem;
      text-align: center;
      transition: all 0.5s;
      opacity: 0;
      transform: translateY(2rem);
      will-change: transform;
    }

    .highlight-card.visible {
      opacity: 1;
      transform: translateY(0);
    }

    .highlight-card:hover {
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
      transform: translateY(0) scale(1.05);
      border-color: rgb(var(--primary) / 0.3);
    }

    .highlight-icon {
      width: 64px;
      height: 64px;
      margin: 0 auto 1rem;
      border-radius: 50%;
      background: rgb(var(--primary) / 0.1);
      color: rgb(var(--primary));
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s;
    }

    .highlight-card:hover .highlight-icon {
      background: rgb(var(--primary));
      color: rgb(var(--primary-foreground));
    }

    .highlight-number {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
    }

    .highlight-label {
      color: rgb(var(--muted-foreground));
      font-weight: 500;
    }

    /* Registration Section */
    .registration {
      padding: 1rem 0;
      background: rgb(var(--accent) / 0.2);
    }

    .registration {
      opacity: rgba(255, 255, 255, 0.6)
    }

    .section-header {
      text-align: center;
      margin-bottom: 3rem;
      opacity: 0;
      transform: translateY(2rem);
      transition: all 0.7s;
    }

    .section-header.visible {
      opacity: 1;
      transform: translateY(0);
    }

    .section-title {
      font-size: 1.875rem;
      font-weight: 700;
      margin-bottom: 1rem;
    }

    .section-desc {
      font-size: 1.125rem;
      color: rgb(var(--muted-foreground));
      max-width: 42rem;
      margin: 0 auto;
    }

    .registration-content {
      max-width: 64rem;
      margin: 0 auto;
    }

    .role-cards {
      display: grid;
      gap: 1.5rem;
      transition: all 0.5s;
    }

    .role-cards.has-selection {
      grid-template-columns: 1fr 1.5fr;
    }

    .role-card {
      position: relative;
      background-color: rgb(var(--card));
      border: 2px solid rgb(var(--border));
      border-radius: 1rem;
      padding: 2rem;
      text-align: center;
      cursor: pointer;
      transition: all 0.5s;
      overflow: hidden;
    }

    .role-card:hover {
      border-color: rgb(var(--primary));
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
      animation: softPulse 1.8s ease-in-out infinite;
    }

    .role-card.selected {
      border-color: rgb(var(--primary));
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .role-card.dimmed {
      opacity: 0.6;
    }

    .role-icon {
      width: 80px;
      height: 80px;
      margin: 0 auto 1.5rem;
      border-radius: 1rem;
      background: rgb(var(--primary) / 0.1);
      color: rgb(var(--primary));
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s;
    }

    .role-card:hover .role-icon {
      background: rgb(var(--primary));
      color: rgb(var(--primary-foreground));
    }

    .role-title {
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 0.75rem;
    }

    .role-desc {
      color: rgb(var(--muted-foreground));
    }

    .role-cta {
      margin-top: 1.5rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      color: rgb(var(--card-foreground));
      font-weight: 500;
    }

    .row-logo {
      grid-column: 1 / -1;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0 0 1rem;
    }

    .row-logo img {
      max-width: 200px;
      height: auto;
      display: block;
    }

    .form-card {
      display: none;
      background: rgb(var(--card));
      border: 1px solid rgb(var(--border));
      border-radius: 1rem;
      padding: 1.5rem;
      animation: fadeSlideIn 0.5s ease-out;
    }



    .form-card.active {
      display: block;
    }

    @keyframes fadeSlideIn {
      from {
        opacity: 0;
        transform: translateX(1rem);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .form-group.has-error .form-label {
      color: #b91c1c;
    }

    .form-error {
      color: #dc2626;
      font-size: 0.75rem;
      margin-top: 0.35rem;
    }

    .form-control-error {
      border-color: #f87171 !important;
      box-shadow: 0 0 0 1px rgba(248, 113, 113, 0.35);
    }

    .form-title {
      font-size: 1.25rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
    }

    .form-grid {
      display: grid;
      gap: 1rem;
    }



    .form-group {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .blue-url-style {
      color: #3b82f6;
      font-weight: 600;
      text-decoration: underline;
    }

    .blue-url-style:hover {
      color: #2563eb;
    }

    .form-label {
      font-size: 0.875rem;
      font-weight: 500;
    }

    .form-input,
    .form-select,
    .form-textarea {
      padding: 0.625rem 0.875rem;
      border: 1px solid rgb(var(--border));
      border-radius: var(--radius);
      font-size: 0.875rem;
      background: rgb(var(--background));
      color: rgb(var(--foreground));
      transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
      outline: none;
      border-color: rgb(var(--primary));
      box-shadow: 0 0 0 3px rgb(var(--primary) / 0.1);
    }

    .form-textarea {
      resize: vertical;
      min-height: 80px;
    }

    .form-hint {
      font-size: 0.75rem;
      color: rgb(var(--muted-foreground));
      line-height: 1.2;
    }

    .form-buttons {
      display: flex;
      gap: 1rem;
      margin-top: 1.5rem;
    }

    .form-buttons .btn {
      flex: 1;
    }

    .step-indicator {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 1rem;
      margin-bottom: 1.5rem;
    }

    .step {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.5rem 1rem;
      border-radius: 9999px;
      font-size: 0.875rem;
      font-weight: 500;
      background: rgb(var(--muted));
      color: rgb(var(--muted-foreground));
    }

    .step.active {
      background: rgb(var(--primary));
      color: rgb(var(--primary-foreground));
    }

    .step-divider {
      width: 2rem;
      height: 1px;
      background: rgb(var(--border));
    }

    .other-role {
      margin-top: 1.5rem;
    }

    /* About Section */
    .about {
      position: relative;
      padding: 5rem 0;
      background: rgb(var(--background));
      overflow: hidden;
      isolation: isolate;
    }

    .about::after {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(120deg, rgba(0, 0, 0, 0.55), rgba(5, 122, 2, 0.35));
      z-index: 1;
      pointer-events: none;
    }

    .about .container {
      position: relative;
      z-index: 2;
    }

    .about-video-container {
      position: absolute;
      inset: 0;
      z-index: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
      transform-origin: center;
      transform: scaleX(0);
      transition: transform 1.25s ease-in-out;
      background: #000;
    }

    .about-video-container video {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .about-video-active .about-video-container {
      transform: scaleX(1);
    }



    .about-grid {
      display: grid;
      gap: 3rem;
      align-items: start;
    }



    .about-col {
      opacity: 0;
      transition: all 0.7s;
    }

    .about-col.visible {
      opacity: 1;
    }

    .about-col:first-child {
      transform: translateX(-2rem);
    }

    .about-col:first-child.visible {
      transform: translateX(0);
    }

    .about-col:last-child {
      transform: translateX(2rem);
    }

    .about-col:last-child.visible {
      transform: translateX(0);
    }

    .about-header {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      margin-bottom: 1.5rem;
    }

    .about-icon {
      padding: 0.75rem;
      border-radius: var(--radius);
      background: rgb(var(--primary) / 0.1);
      color: rgb(var(--primary));
    }

    .about-title {
      font-size: 1.875rem;
      font-weight: 700;
      color: #fff
    }

    .about-card {
      background: rgb(var(--card));
      border: 1px solid rgb(var(--border));
      border-radius: 1rem;
      padding: 2rem;
    }

    .about-text {
      font-size: 1.125rem;
      color: rgb(var(--muted-foreground));
      line-height: 1.7;
    }

    .about-text+.about-text {
      margin-top: 1rem;
    }

    .goals-list {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .goal-card {
      background: rgb(var(--card));
      border: 1px solid rgb(var(--border));
      border-radius: var(--radius);
      padding: 1.5rem;
      display: flex;
      gap: 1rem;
      transition: all 0.5s;
      opacity: 0;
      transform: translateY(1rem);
      /* text-align: center; */
    }

    .goal-card.visible {
      opacity: 1;
      transform: translateY(0);
    }

    .goal-card:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      border-color: rgb(var(--primary) / 0.3);
    }

    .goal-icon {
      flex-shrink: 0;
      padding: 0.75rem;
      border-radius: 0.5rem;
      background: rgb(var(--primary) / 0.1);
      color: rgb(var(--primary));
      transition: all 0.3s;
    }

    .goal-card:hover .goal-icon {
      background: rgb(var(--primary));
      color: rgb(var(--primary-foreground));
    }

    .goal-title {
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 0.25rem;
      color: rgb(var(--card-foreground));
    }

    .goal-desc {
      color: rgb(var(--muted-foreground));
    }

    /* Sponsors Section */
    .sponsors {
      padding: 5rem 0;
      background: rgb(var(--accent) / 0.2);
    }

    .sponsor-tiers {
      display: flex;
      flex-direction: column;
      gap: 2.5rem;
    }

    .sponsor-tier-title {
      text-align: center;
      font-size: 2rem !important;
      font-weight: 600;
      margin-bottom: 1rem;
      color: var(--accent-color);
    }

    .sponsor-tier-grid {
      display: grid;
      gap: 1.5rem;
      justify-content: center;
      justify-items: center;
      max-width: 1000px;
      margin: 0 auto;
    }

    .sponsor-tier-grid.tier-main,
    .sponsor-tier-grid.tier-strategic {
      grid-template-columns: repeat(auto-fit, minmax(300px, 250px));
    }

    .sponsor-tier-grid.tier-gold,
    .sponsor-tier-grid.tier-business {
      grid-template-columns: repeat(auto-fit, minmax(300px, 250px));
    }

    .sponsor-tier-grid.tier-silver,
    .sponsor-tier-grid.tier-marketing {
      grid-template-columns: repeat(auto-fit, minmax(300px, 250px));
    }

    /* .organizer-grid {
      display: grid;
      gap: 1.5rem;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      max-width: 1000px;
      margin: 0 auto;
    }

    /* @media (max-width: 640px) { */
    /* .organizer-grid {
        grid-template-columns: 1fr;
      }
    } 

    .organizer-details {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      gap: 0.75rem;
      text-align: center;
    }

    .organizer-name {
      font-size: 1.25rem;
      font-weight: 700;
      margin: 0;
      color: rgb(var(--foreground));
    }

    .organizer-desc {
      font-size: 0.95rem;
      color: rgb(var(--muted-foreground));
      line-height: 1.5;
    }

    .organizer-link {
      color: var(--hover-accent);
      text-decoration: none;
      font-weight: 600;
      align-self: center;
    }

    .organizer-link:hover {
      text-decoration: underline;
    } */

    .sponsor-featured-list {
      display: flex;
      flex-direction: column;
      gap: 2rem;
      max-width: 70%;
      margin: 0 auto;
    }

    .sponsor-featured-card {
      width: 100%;
      position: relative;
      border-radius: 1.5rem;
      padding: 2px;
      --sponsor-gradient: linear-gradient(120deg, #2dd4bf, #0f9f6e, #2dd4bf);
      background: var(--sponsor-gradient);
      background-size: 250% 250%;
      animation: sponsorBorderFlow 8s linear infinite;
      overflow: hidden;
    }


    .sponsor-featured-card.sponsor-strategic {
      --sponsor-gradient: linear-gradient(120deg, #9803bd, #9803bd, #9803bd);
    }

    .sponsor-featured-card.sponsor-business {
      --sponsor-gradient: linear-gradient(120deg, #a5b4fc, #6366f1, #a5b4fc);
    }

    .sponsor-featured-card.sponsor-marketing {
      --sponsor-gradient: linear-gradient(120deg, #f9a8d4, #db2777, #f472b6);
    }

    @keyframes sponsorBorderFlow {
      0% {
        background-position: 0% 50%;
      }

      100% {
        background-position: 200% 50%;
      }
    }

    .sponsor-featured-content {
      position: relative;
      z-index: 1;
      display: flex;
      gap: 2rem;
      align-items: stretch;
      padding: 2rem;
      border-radius: calc(1.5rem - 2px);
      background: #000000;
      box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.6);
    }

    .sponsor-featured-media {
      flex: 0 0 25%;
      max-width: 25%;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 1rem;
    }

    .sponsor-featured-logo {
      width: 100%;
      aspect-ratio: 1 / 1;
      border-radius: 1rem;
      /* background: #ffffff; */
      display: flex;
      align-items: center;
      justify-content: center;
      /* padding: 1rem; */
      /* border: solid 1px rgb(var(--border)); */
    }

    .sponsor-featured-logo img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }

    .sponsor-visit-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.4rem;
      padding: 0.65rem 0.5rem;
      border-radius: 9999px;
      background: rgb(var(--primary));
      color: rgb(var(--primary-foreground));
      font-weight: 600;
      text-decoration: none;
      transition: background 0.3s ease, transform 0.3s ease;
      width: 100%;
    }

    .sponsor-visit-btn:hover {
      background: var(--accent-color);
      color:#fff;
      transform: translateY(-1px);
    }

    .sponsor-featured-body {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      gap: 0.75rem;
    }

    .sponsor-featured-label {
      font-size: 0.85rem;
      letter-spacing: 0.2em;
      font-weight: 600;
      text-transform: uppercase;
      color: rgb(var(--primary));
    }

    .sponsor-featured-name-link {
      text-decoration: none;
    }

    .sponsor-featured-name {
      font-size: clamp(1.5rem, 2.2vw, 2.25rem);
      font-weight: 700;
      text-align: center;
      margin: 0;
      color: rgb(var(--foreground));
    }

    .sponsor-featured-desc {
      font-size: 1.15rem;
      text-align: center;
      color: rgb(var(--muted-foreground));
      line-height: 1.7;
    }











    /*  */

    .sponsor-card {
      background: transparent;
      border: 1px solid rgb(var(--border) / 0.6);
      border-radius: var(--radius);
      padding: 0.5rem;
      transition: all 0.5s;
      opacity: 0;
      transform: translateY(2rem);
      display: flex;
      flex-direction: column;
      gap: 1rem;
      text-decoration: none;
      min-height: 260px;
      will-change: transform;
    }

    .sponsor-card.visible {
      opacity: 1;
      transform: translateY(0);
    }

    .sponsor-card:hover {
      box-shadow: 0 15px 35px -10px rgba(0, 0, 0, 0.25);
      transform: translateY(0) scale(1.02);
      background: rgb(var(--card) / 0.4);
      box-shadow: #9803bde1 0px 0px 10px, #9803bde1 0px 0px 20px, #9803bde1 0px 0px 30px, #9803bde1 0px 0px 40px, #9803bde1 0px 0px 50px;
    }

    .sponsor-card .sponsor-logo {
      width: 100%;
      height: 100%;
      aspect-ratio: 1 / 1;
      border-radius: 1rem;
      overflow: hidden;
      background: rgb(var(--muted));
      box-shadow: inset 0 0 0 1px rgb(var(--border) / 1);
    }

    .sponsor-card .sponsor-logo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    .sponsor-card-footer {
      text-align: center;
      font-weight: 600;
      font-size: 1.05rem;
    }

    .sponsor-card.main:hover {
      border-color: rgb(242 147 13 / 0.6);
    }

    .sponsor-card.gold:hover {
      border-color: rgb(249 188 6 / 0.6);
    }

    .sponsor-card.silver:hover {
      border-color: rgb(143 150 163 / 0.6);
    }

    .sponsor-card.sponsor-strategic {
      border-color: rgba(253, 230, 138, 0.6);
    }

    .sponsor-card.sponsor-business {
      border-color: rgba(165, 180, 252, 0.6);
    }

    .sponsor-card.sponsor-marketing {
      border-color: rgba(249, 168, 212, 0.6);
    }

    .organizer-card {
      background: rgb(var(--card));
      border: 1px solid rgb(var(--border));
      padding: 1.25rem;
      min-height: 320px;
      justify-content: flex-start;
      align-items: center;
      text-align: center;
      gap: 1.25rem;
      box-shadow: 0 20px 35px -20px rgba(0, 0, 0, 0.5);
    }

    .organizer-logo {
      background: #000;
      border-radius: 1rem;
      padding: 1.25rem;
      width: 100%;
      height: 180px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .organizer-logo img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }

    .organizer-footer {
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
    }

    .sponsor-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      padding: 0.4rem 1rem;
      border-radius: 9999px;
      font-size: 0.8rem;
      font-weight: 500;
      color: rgb(45 134 77);
      text-decoration: none;
      border: 1px solid rgb(var(--border) / 0.6);
      box-shadow: inset 0 0 0 1px rgb(255 255 255 / 0.15);
      position: relative;
      overflow: hidden;
    }

    .sponsor-badge::after {
      content: '';
      position: absolute;
      inset: 0;
      border-radius: inherit;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
      z-index: -1;
    }

    .sponsor-badge.main {
      background: linear-gradient(120deg, rgba(255, 186, 90, 0.35), rgba(255, 153, 0, 0.2));
      color: rgb(170 103 9);
    }

    .sponsor-badge.gold {
      background: linear-gradient(120deg, rgba(252, 211, 77, 0.35), rgba(234, 179, 8, 0.2));
      color: rgb(151 116 12);
    }

    .sponsor-badge.silver {
      background: linear-gradient(120deg, rgba(226, 232, 240, 0.4), rgba(148, 163, 184, 0.25));
      color: rgb(92 99 112);
    }

    .sponsor-badge span {
      font-size: 1rem;
      font-weight: 900;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      text-decoration: none;
    }

    .organizers {
      padding: 5rem 0;
      background: rgb(var(--background));
    }

    /* Participants Section */
    .participants {
      padding: 5rem 0;
      background: rgb(var(--background));
    }

    .participants-grid {
      display: grid;
      gap: 1.5rem;
      grid-template-columns: 1fr;
    }







    .participant-card {
      /* background: rgb(var(--card));
      border: 1px solid rgb(var(--border)); */
      border-radius: var(--radius);
      padding: 0.5rem;
      transition: all 0.45s cubic-bezier(0.4, 0, 0.2, 1);
      opacity: 0;
      transform: translateY(2rem);
      text-decoration: none;
      color: inherit;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      /* min-height: 200px; */
      will-change: transform;
      position: relative;
      overflow: hidden;
    }

    .participant-card.visible {
      opacity: 1;
      transform: translateY(0);
    }

    .participant-card:hover {
      box-shadow: 0 20px 35px -15px rgba(0, 0, 0, 0.25);
      border-color: rgb(var(--primary) / 0.4);
      transform: translateY(-6px);
    }

    .participant-logo {
      background: rgb(var(--primary) / 0.1);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      margin-bottom: 1rem;
      transition: background 0.3s;
    }

    .participant-logo img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      border-radius: 10px;

    }

    .participant-card:hover .participant-logo {
      background: rgb(var(--primary) / 0.2);
    }

    .participant-name {
      font-weight: 600;
      margin-bottom: 0.5rem;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    .external-icon {
      opacity: 0;
      transition: opacity 0.3s;
    }

    .participant-card:hover .external-icon {
      opacity: 1;
    }

    /* Contact Section */
    .contact {
      padding: 5rem 0;
      background: rgb(var(--accent) / 0.2);
    }

    .contact-grid {
      display: grid;
      gap: 3rem;
      max-width: 72rem;
      margin: 0 auto;
    }



    .contact-col {
      opacity: 0;
      transition: all 0.7s;
    }

    .contact-col.visible {
      opacity: 1;
    }

    .contact-col:first-child {
      transform: translateX(-2rem);
    }

    .contact-col:first-child.visible {
      transform: translateX(0);
    }

    .contact-col:last-child {
      transform: translateX(2rem);
    }

    .contact-col:last-child.visible {
      transform: translateX(0);
    }

    .contact-form-card {
      background: rgb(var(--card));
      border: 1px solid rgb(var(--border));
      border-radius: 1rem;
      padding: 2rem;
    }

    .contact-info-title {
      font-size: 1.25rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
    }

    .contact-info-list {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .contact-info-card {
      background: rgb(var(--card));
      border: 1px solid rgb(var(--border));
      border-radius: var(--radius);
      padding: 1.5rem;
      transition: box-shadow 0.3s;
    }

    .contact-info-card:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .contact-info-card.primary {
      border-color: rgb(var(--primary) / 0.3);
      background: rgb(var(--card));
    }

    .contact-info-header {
      display: flex;
      align-items: start;
      gap: 1rem;
    }

    .contact-info-icon {
      padding: 0.5rem;
      border-radius: 0.5rem;
      background: rgb(var(--primary) / 0.1);
      color: rgb(var(--primary));
    }

    .contact-info-name {
      font-weight: 600;
      margin-bottom: 0.75rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .primary-badge {
      font-size: 0.75rem;
      background: rgb(var(--primary));
      color: rgb(var(--primary-foreground));
      padding: 0.125rem 0.5rem;
      border-radius: 9999px;
    }

    .contact-info-links {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .contact-info-link {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.875rem;
      color: rgb(var(--muted-foreground));
      text-decoration: none;
      transition: color 0.2s;
    }

    .contact-info-link:hover {
      color: var(--hover-accent);
    }

    .location-card {
      margin: auto;
      margin-top: 2rem;
      background: rgb(var(--card));
      border: 1px solid rgb(var(--border));
      border-radius: var(--radius);
      padding: 1.5rem;
      width: 100%;
      max-width: 72rem;
    }

    .location-header {
      display: flex;
      align-items: start;
      gap: 1rem;
    }

    .location-title {
      font-weight: 600;
      margin-bottom: 0.5rem;
    }

    .location-address {
      font-size: 0.875rem;
      color: rgb(var(--muted-foreground));
    }

    .map-embed {
      margin-top: 1rem;
      border-radius: var(--radius);
      overflow: hidden;
      border: 1px solid rgb(var(--border));
    }

    .map-embed iframe {
      width: 100%;
      height: 320px;
      border: 0;
    }

    .to-top-button {
      position: fixed;
      right: 1.25rem;
      bottom: 1.25rem;
      width: 44px;
      height: 44px;
      border-radius: 999px;
      background: rgb(var(--primary));
      color: rgb(var(--primary-foreground));
      border: none;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 15px 35px rgba(16, 185, 129, 0.3);
      opacity: 0;
      pointer-events: none;
      transform: translateY(20px);
      transition: opacity 0.3s ease, transform 0.3s ease;
      z-index: 60;
    }

    .to-top-button svg {
      animation: float-up 1.5s ease-in-out infinite;
    }

    .to-top-button.show {
      opacity: 1;
      pointer-events: auto;
      transform: translateY(0);
    }

    @keyframes float-up {

      0%,
      100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-3px);
      }
    }

    /* Footer */
    .footer {
      padding: 2rem 0;
      border-top: 1px solid rgb(var(--border));
      background: rgb(var(--card));
    }

    .footer-inner {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      text-align: center;
    }

    .footer-text {
      font-size: 0.875rem;
      color: rgb(var(--muted-foreground));
    }

    /* RTL Support */
    [dir="rtl"] {
      font-family: 'Cairo', sans-serif;
    }

    /* Icons (using SVG) */
    .icon {
      width: 24px;
      height: 24px;
      stroke: #ffffff;
      stroke-width: 2;
      fill: none;
      stroke-linecap: round;
      stroke-linejoin: round;
    }

    .icon-sm {
      width: 16px;
      height: 16px;
    }

    .icon-lg {
      width: 40px;
      height: 40px;
    }

    /* Toast */
    .toast-container {
      position: fixed;
      bottom: 1rem;
      right: 1rem;
      z-index: 100;
    }

    .toast {
      background: rgb(var(--card));
      border: 1px solid rgb(var(--border));
      border-radius: var(--radius);
      padding: 1rem 1.5rem;
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15);
      animation: slideIn 0.3s ease-out;
      min-width: 280px;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(1rem);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .toast-title {
      font-weight: 600;
      margin-bottom: 0.25rem;
    }

    .toast-desc {
      font-size: 0.875rem;
      color: rgb(var(--muted-foreground));
    }

    /* Statistics Section */
    .stats-section {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 30px;
      padding: 20px;
      margin-bottom: 5px;
    }

    .stat-item {
      background: #88808048;
      padding: 40px 30px;
      border-radius: 20px;
      text-align: center;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
      transition: var(--transition);
      position: relative;
      overflow: hidden;
    }

    .stat-item::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background: linear-gradient(90deg, var(--secondary-color), var(--accent-color));
      transform: scaleX(0);
      transition: transform 0.3s ease;
    }

    .stat-item:hover {
      transform: translateY(-10px);
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .stat-item:hover::before {
      transform: scaleX(1);
    }

    .stat-icon-wrapper {
      width: 70px;
      height: 70px;
      background: linear-gradient(135deg, rgba(0, 255, 68, 0.1), rgba(0, 255, 136, 0.05));
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
      font-size: 1.8rem;
      color: var(--secondary-color);
      transition: var(--transition);
    }

    .stat-item:hover .stat-icon-wrapper {
      background: linear-gradient(135deg, var(--secondary-color), var(--accent-color));
      color: white;
      transform: rotateY(180deg);
    }

    .stat-number {
      font-size: 2.8rem;
      font-weight: 800;
      color: #9873AC;
      margin-bottom: 10px;
    }

    .stat-label {
      font-size: 1rem;
      color: #9873AC;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 20px;
      font-weight: 600;
    }

    .stat-progress {
      width: 100%;
      height: 6px;
      background: #f0f0f0;
      border-radius: 3px;
      overflow: hidden;
    }

    .progress-fill {
      width: 0;
      height: 100%;
      background: linear-gradient(90deg, var(--secondary-color), var(--accent-color));
      border-radius: 3px;
      transition: width 2s ease;
    }

    /* Force the links block into 2 columns */
    .contact-info-card .contact-info-links.two-columns {
      display: grid !important;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      column-gap: 1.5rem;
    }

    /* Stack on mobile if you want */


    .contact-info-column {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .contact-info-column-header {
      font-weight: 600;
      font-size: 0.9rem;
      margin-bottom: 0.25rem;
      opacity: 0.8;
    }


    /* Refactored Media Queries */

    /* Min Width Queries (Mobile First) */
    @media (min-width: 640px) {
      .hero-video-frame {
        aspect-ratio: 16 / 8.5;
      }

      .participants-grid {
        grid-template-columns: repeat(2, 1fr);
      }

      .nav-logo,
      .nav-logo-bu {
        height: 40px;
      }
    }

    @media (min-width: 768px) {
      .nav {
        display: flex;
      }

      .section-title {
        font-size: 2.25rem;
      }

      .role-cards {
        grid-template-columns: repeat(2, 1fr);
      }

      .role-card.guest-card {
        grid-column: 1 / -1;
        justify-self: center;
        max-width: calc((100% - 1.5rem) / 2);
        width: 100%;
      }

      .form-card.guest-form {
        grid-column: 1 / -1;
      }

      .role-cards.guest-selected .guest-card,
      .role-cards.guest-selected .guest-form {
        grid-column: auto;
        justify-self: stretch;
        max-width: none;
      }

      .form-card {
        padding: 2rem;
      }

      .form-grid-2 {
        grid-template-columns: repeat(2, 1fr);
      }
      
      .nav-logo,
      .nav-logo-bu {
        height: 40px;
      }
    }

    @media (min-width: 1024px) {
      .highlights-grid {
        grid-template-columns: repeat(4, 1fr);
      }

      .about-grid {
        grid-template-columns: 1fr 1fr;
      }

      .participants-grid {
        grid-template-columns: repeat(3, 1fr);
      }

      .contact-grid {
        grid-template-columns: 1fr 1fr;
      }
    }

    @media (min-width: 1280px) {
      .participants-grid {
        grid-template-columns: repeat(4, 1fr);
      }
    }

    /* Max Width Queries */
    @media (max-width: 900px) {
      .sponsor-featured-media {
        flex-basis: 30%;
        max-width: 30%;
      }
    }

    @media (max-width: 768px) {
      .mobile-menu-btn {
        display: block;
      }

      .sponsor-featured-content {
        flex-direction: column;
        padding: 1.5rem;
      }

      .sponsor-featured-media {
        flex-basis: auto;
        max-width: none;
        width: 100%;
      }

      .sponsor-featured-logo {
        width: 100%;
        /* margin: 0 auto; */
      }

      .sponsor-featured-desc {
        display: none;
      }
      
      .nav-logo,
      .nav-logo-bu {
        height: 40px;
      }
    }

    @media (max-width: 767px) {
      .role-cards.has-selection {
        grid-template-columns: 1fr;
      }
      
      .nav-logo,
      .nav-logo-bu {
        height: 40px;
      }
    }

    @media (max-width: 600px) {
      .contact-info-card .contact-info-links.two-columns {
        grid-template-columns: 1fr;
      }
    }

    /* Preference Queries */
    @media (prefers-reduced-motion: reduce) {
      .nav-link {
        animation: none;
        opacity: 1;
        transform: none;
      }

      .about-video-container {
        transform: scaleX(1);
        transition: none;
      }

      .sponsor-featured-card {
        animation: none;
      }
    }
  </style>
</head>

<body>
  @php
  $publicSponsors = \App\Models\PublicSponsor::query()
  ->where('is_active', true)
  ->orderBy('tier')
  ->orderBy('display_order')
  ->get();

  if ($publicSponsors->isEmpty()) {
  $publicSponsors = collect(config('demo.sponsors'))
  ->map(function ($data, $id) {
  $model = new \App\Models\PublicSponsor($data);
  $model->id = $id;
  $model->exists = false;

  return $model;
  });
  }

  $sponsorTierLabels = [
  'strategic' => [
  'en' => 'Strategic Sponsors',
  'ar' => 'الراعي اﻹستراتيجي',
  ],
  'business' => [
  'en' => 'Business Sponsors',
  'ar' => 'راعي الأعمال',
  ],
  'marketing' => [
  'en' => 'Marketing Sponsors',
  'ar' => 'الراعي التسويقي',
  ],
  ];

  $tierAliases = [
  'main' => 'strategic',
  'gold' => 'business',
  'silver' => 'marketing',
  'strategic' => 'strategic',
  'business' => 'business',
  'marketing' => 'marketing',
  ];

  $groupedSponsors = $publicSponsors->groupBy(function ($sponsor) use ($tierAliases) {
  $tier = strtolower($sponsor->tier ?? 'other');

  return $tierAliases[$tier] ?? $tier;
  });

  $participants = \App\Models\Participant::query()
  ->where('is_active', true)
  ->orderBy('display_order')
  ->get();

  if ($participants->isEmpty()) {
  $participants = collect(config('demo.participants'))
  ->map(function ($data, $id) {
  $model = new \App\Models\Participant($data);
  $model->id = $id;
  $model->exists = false;

  return $model;
  });
  }

  $organizers = \App\Models\Organizer::query()
  ->where('is_active', true)
  ->orderBy('display_order')
  ->get();

  if ($organizers->isEmpty()) {
  $organizers = collect(config('demo.organizers'))
  ->map(function ($data, $id) {
  $model = new \App\Models\Organizer($data);
  $model->id = $id;
  $model->exists = false;

  return $model;
  });
  }
  @endphp
  <!-- Header -->
  <header class="header">
    <div class="container">
      <div class="header-inner">
        <img src="{{ asset('./img/IEC-logo.png') }}" alt="IEC Logo" class="nav-logo" />
        <nav class="nav">
          <a href="#" class="btn-primary nav-link" data-en="Home" data-ar="الرئيسية">Home</a>
          <a href="#" class="nav-link" data-en="Previous Editions of IEC" data-ar="نسخ المعرض السابقة">Previous Editions of IEC</a>
          <a href="#register" class="btn-primary nav-link" data-en="Register" data-ar="سجل الآن">Register</a>
          <a href="#about" class="nav-link" data-en="About" data-ar="عن المعرض">About</a>
          <a href="#sponsors" class="nav-link" data-en="Sponsors" data-ar="الرعاة">Sponsors</a>
          <a href="#participants" class="nav-link" data-en="Icons" data-ar="الأيقونات">Icons</a>
          <a href="#organizers" class="nav-link" data-en="Owned by" data-ar="الشركة المالكة">Owned by</a>
          <a href="#contact" class="nav-link" data-en="Contact" data-ar="تواصل معنا">Contact</a>
        </nav>

        <div class="header-right">
          <div class="header-actions">
            <button class="lang-switch" onclick="toggleLocale()">
              <svg class="icon icon-sm" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" />
                <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
              </svg>
              <span id="lang-text">العربية</span>
            </button>
            <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
              <svg class="icon" viewBox="0 0 24 24" id="menu-icon">
                <path d="M3 12h18M3 6h18M3 18h18" />
              </svg>
            </button>
          </div>
          <a href="https://umbrella.sa" />
            <img class="nav-logo-bu" src="{{ asset('./img/bu_logo.png') }}" alt="BU Logo"/>
          </a>
        </div>
      </div>

      <nav class="mobile-nav" id="mobile-nav">
        <a href="#" class="mobile-nav-link" data-en="Home" data-ar="الرئيسية">Home</a>
        <a href="#" class="mobile-nav-link" data-en="Previous Editions of IEC" data-ar="نسخ المعرض السابقة">Previous Editions of IEC</a>
        <a href="#register" class="mobile-nav-link" data-en="Register" data-ar="سجل الآن">Register</a>
        <a href="#about" class="mobile-nav-link" data-en="About" data-ar="عن المعرض">About</a>
        <a href="#sponsors" class="mobile-nav-link" data-en="Sponsors" data-ar="الرعاة">Sponsors</a>
        <a href="#participants" class="mobile-nav-link" data-en="Icons" data-ar="الأيقونات">Icons</a>
        <a href="#organizers" class="mobile-nav-link" data-en="Owned by" data-ar="الشركة المالكة">Owned by</a>
        <a href="#contact" class="mobile-nav-link" data-en="Contact" data-ar="تواصل معنا">Contact</a>
        
      </nav>
    </div>
  </header>

  <main>
    <!-- Hero Section -->
    @php
    $heroVideoUrl = \App\Models\LandingSection::mediaUrl($heroSection['video_path'] ?? null) ?? asset('video/hero.mp4');
    $heroPoster = \App\Models\LandingSection::mediaUrl($heroSection['poster_image_path'] ?? null);
    $heroStats = $heroSection['stats'] ?? [];
    $activeLocale = app()->getLocale();
    @endphp

    <section class="hero" id="hero">
      <div class="container">
        <div class="hero-grid">
          <div class="hero-media">
            <div class="hero-video-frame">
              <video class="hero-video" autoplay muted loop playsinline @if($heroPoster) poster="{{ $heroPoster }}" @endif>
                <source src="{{ $heroVideoUrl }}" type="video/mp4">
                Your browser does not support the video tag.
              </video>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- Registration Section -->
    @php
    $registrationLocale = app()->getLocale();
    $translate = function ($node, $fallback = '') use ($registrationLocale) {
    $en = data_get($node, 'en', $fallback);
    $ar = data_get($node, 'ar', $en);
    return [
    'en' => $en,
    'ar' => $ar,
    'text' => $registrationLocale === 'ar' ? $ar : $en,
    ];
    };
    $registrationTitle = $translate(data_get($registrationSection, 'title'), __('Registration'));
    $registrationDescription = $translate(data_get($registrationSection, 'description'), '');

    $visitorCard = data_get($registrationSection, 'visitor_card', []);
    $visitorForm = data_get($registrationSection, 'visitor_form', []);
    $visitorFields = data_get($visitorForm, 'fields', []);
    $visitorFieldsByName = collect($visitorFields)->keyBy('name');

    $guestCardTitle = $translate(data_get($visitorCard, 'title') ?? [
    'en' => trans('registration.guest.title', [], 'en'),
    'ar' => trans('registration.guest.title', [], 'ar'),
    ]);
    $guestCardDescription = $translate(data_get($visitorCard, 'description') ?? [
    'en' => trans('registration.guest.description', [], 'en'),
    'ar' => trans('registration.guest.description', [], 'ar'),
    ]);
    $guestCta = $translate(data_get($visitorCard, 'cta_label') ?? [
    'en' => trans('registration.guest.cta_label', [], 'en'),
    'ar' => trans('registration.guest.cta_label', [], 'ar'),
    ]);
    $guestFormTitle = $translate(data_get($visitorForm, 'title') ?? [
    'en' => trans('registration.guest.form_title', [], 'en'),
    'ar' => trans('registration.guest.form_title', [], 'ar'),
    ]);
    $guestSubmit = $translate(data_get($visitorForm, 'cta_submit') ?? [
    'en' => trans('registration.guest.cta_submit', [], 'en'),
    'ar' => trans('registration.guest.cta_submit', [], 'ar'),
    ]);
    $guestContact = $translate(data_get($visitorForm, 'cta_contact') ?? [
    'en' => trans('registration.guest.cta_contact', [], 'en'),
    'ar' => trans('registration.guest.cta_contact', [], 'ar'),
    ]);

    $exhibitorCard = data_get($registrationSection, 'exhibitor_card', []);
    $exhibitorCardTitle = $translate(data_get($exhibitorCard, 'title'), '');
    $exhibitorCardDescription = $translate(data_get($exhibitorCard, 'description'), '');
    $exhibitorCta = $translate(data_get($exhibitorCard, 'cta_label'), __('Select'));
    $exhibitorForm = data_get($registrationSection, 'exhibitor_form', []);
    $exhibitorFormTitle = $translate(data_get($exhibitorForm, 'title'), '');
    $exhibitorStepOne = $translate(data_get($exhibitorForm, 'step_one'), '');
    $exhibitorStepTwo = $translate(data_get($exhibitorForm, 'step_two'), '');
    $exhibitorNext = $translate(data_get($exhibitorForm, 'cta_next'), __('Next Step'));
    $exhibitorSubmit = $translate(data_get($exhibitorForm, 'cta_submit'), __('Submit Application'));
    $exhibitorFieldsStepOne = data_get($exhibitorForm, 'fields_step_one', []);
    $exhibitorFieldsStepTwo = data_get($exhibitorForm, 'fields_step_two', []);
    $exhibitorFieldsStepOneByName = collect($exhibitorFieldsStepOne)->keyBy('name');
    $exhibitorFieldsStepTwoByName = collect($exhibitorFieldsStepTwo)->keyBy('name');

    $iconCard = data_get($registrationSection, 'icon_card', []);
    $iconForm = data_get($registrationSection, 'icon_form', []);
    $iconFieldsStepOne = data_get($iconForm, 'fields_step_one', []);
    $iconFieldsStepTwo = data_get($iconForm, 'fields_step_two', []);
    $iconFieldsStepOneByName = collect($iconFieldsStepOne)->keyBy('name');
    $iconFieldsStepTwoByName = collect($iconFieldsStepTwo)->keyBy('name');

    $iconCardTitle = $translate(data_get($iconCard, 'title') ?? [
    'en' => trans('registration.icon.title', [], 'en'),
    'ar' => trans('registration.icon.title', [], 'ar'),
    ]);
    $iconCardDescription = $translate(data_get($iconCard, 'description') ?? [
    'en' => trans('registration.icon.description', [], 'en'),
    'ar' => trans('registration.icon.description', [], 'ar'),
    ]);
    $iconCta = $translate(data_get($iconCard, 'cta_label') ?? [
    'en' => trans('registration.icon.cta_label', [], 'en'),
    'ar' => trans('registration.icon.cta_label', [], 'ar'),
    ]);
    $iconFormTitle = $translate(data_get($iconForm, 'title') ?? [
    'en' => trans('registration.icon.form_title', [], 'en'),
    'ar' => trans('registration.icon.form_title', [], 'ar'),
    ]);
    $iconStepOne = $translate(data_get($iconForm, 'step_one') ?? [
    'en' => trans('registration.icon.step_one', [], 'en'),
    'ar' => trans('registration.icon.step_one', [], 'ar'),
    ]);
    $iconStepTwo = $translate(data_get($iconForm, 'step_two') ?? [
    'en' => trans('registration.icon.step_two', [], 'en'),
    'ar' => trans('registration.icon.step_two', [], 'ar'),
    ]);
    $iconNext = $translate(data_get($iconForm, 'cta_next') ?? [
    'en' => trans('registration.icon.cta_next', [], 'en'),
    'ar' => trans('registration.icon.cta_next', [], 'ar'),
    ]);
    $iconBack = $translate(data_get($iconForm, 'cta_back') ?? [
    'en' => trans('registration.icon.cta_back', [], 'en'),
    'ar' => trans('registration.icon.cta_back', [], 'ar'),
    ]);
    $iconSubmit = $translate(data_get($iconForm, 'cta_submit') ?? [
    'en' => trans('registration.icon.cta_submit', [], 'en'),
    'ar' => trans('registration.icon.cta_submit', [], 'ar'),
    ]);

    $fieldCopy = function ($fieldsByName, string $name, string $key, array $fallback) use ($translate) {
    $field = $fieldsByName->get($name);
    $value = $field ? data_get($field, $key) : null;
    return $translate($value ?? $fallback);
    };

    $fieldOptions = function ($fieldsByName, string $name, array $fallback) {
    $field = $fieldsByName->get($name);
    $options = data_get($field, 'options');
    return (is_array($options) && count($options)) ? $options : $fallback;
    };
    @endphp

    @php
    $visitorFormActive = old('form_identifier') === 'visitor';
    $sponsorFormActive = old('form_identifier') === 'sponsor';
    $iconFormActive = old('form_identifier') === 'icon';
    $visitorShouldOpen = $visitorFormActive || session()->has('visitor_success');
    $sponsorShouldOpen = $sponsorFormActive || session()->has('sponsor_success');
    $iconShouldOpen = $iconFormActive || session()->has('icon_success');
    @endphp

    <section class="registration" id="register">
      <div class="container">
        <div class="section-header" data-animate>
          <h2 class="section-title" data-en="{{ e($registrationTitle['en']) }}" data-ar="{{ e($registrationTitle['ar']) }}">{{ $registrationTitle['text'] }}</h2>
          <p class="section-desc" data-en="{{ e($registrationDescription['en']) }}" data-ar="{{ e($registrationDescription['ar']) }}">{{ $registrationDescription['text'] }}</p>
        </div>

        <div class="registration-content">
          <div class="role-cards" id="role-cards">
            <div class="row-logo" id="sponsor-row-logo">
              <img src="{{ asset('img/IEC-logo.png') }}" alt="IEC Logo">
            </div>

            <div class="role-card" id="exhibitor-card" onclick="selectRole('exhibitor')">
              <div class="role-icon">
                <svg class="icon icon-lg" viewBox="0 0 24 24">
                  <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z" />
                  <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2" />
                  <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2" />
                </svg>
              </div>
              <h3 class="role-title" data-en="{{ e($exhibitorCardTitle['en']) }}" data-ar="{{ e($exhibitorCardTitle['ar']) }}">{{ $exhibitorCardTitle['text'] }}</h3>
              <p class="role-desc" data-en="{{ e($exhibitorCardDescription['en']) }}" data-ar="{{ e($exhibitorCardDescription['ar']) }}">{{ $exhibitorCardDescription['text'] }}</p>
              <div class="role-cta" id="exhibitor-cta">
                <span data-en="{{ e($exhibitorCta['en']) }}" data-ar="{{ e($exhibitorCta['ar']) }}">{{ $exhibitorCta['text'] }}</span>
                <svg class="icon icon-sm" viewBox="0 0 24 24">
                  <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
              </div>
            </div>

            <div class="form-card" id="exhibitor-form">
              @if(session('sponsor_success'))
              <div class="mb-4 rounded-lg border border-emerald-100 bg-emerald-50 px-3 py-2 text-sm text-emerald-900">
                {{ session('sponsor_success') }}
              </div>
              @endif
              @php
              $exFullNameLabel = $fieldCopy($exhibitorFieldsStepOneByName, 'full_name', 'label', ['en' => 'Full Name *', 'ar' => 'الاسم الكامل *']);
              $exFullNamePlaceholder = $fieldCopy($exhibitorFieldsStepOneByName, 'full_name', 'placeholder', ['en' => 'John Doe', 'ar' => 'جون دو']);
              $exEmailLabel = $fieldCopy($exhibitorFieldsStepOneByName, 'email', 'label', ['en' => 'Email *', 'ar' => 'البريد الإلكتروني *']);
              $exEmailPlaceholder = $fieldCopy($exhibitorFieldsStepOneByName, 'email', 'placeholder', ['en' => 'john@company.com', 'ar' => 'john@company.com']);
              $exPhoneLabel = $fieldCopy($exhibitorFieldsStepOneByName, 'phone', 'label', ['en' => 'Phone *', 'ar' => 'الهاتف *']);
              $exPhonePlaceholder = $fieldCopy($exhibitorFieldsStepOneByName, 'phone', 'placeholder', ['en' => '+966 50 000 0000', 'ar' => '+966 50 000 0000']);
              $exJobLabel = $fieldCopy($exhibitorFieldsStepOneByName, 'job_title', 'label', ['en' => 'Job Title *', 'ar' => 'المسمى الوظيفي *']);
              $exJobPlaceholder = $fieldCopy($exhibitorFieldsStepOneByName, 'job_title', 'placeholder', ['en' => 'Marketing Manager', 'ar' => 'مدير التسويق']);
              $exOrgLabel = $fieldCopy($exhibitorFieldsStepOneByName, 'organization', 'label', ['en' => 'Company / Organization', 'ar' => 'الشركة / الجهة']);
              $exOrgPlaceholder = $fieldCopy($exhibitorFieldsStepOneByName, 'organization', 'placeholder', ['en' => 'Umbrella Inc.', 'ar' => 'شركة أمبريلا']);

              $exVatLabel = $fieldCopy($exhibitorFieldsStepTwoByName, 'vat_number', 'label', ['en' => 'VAT (Value Added Tax)', 'ar' => 'ضريبة القيمة المضافة']);
              $exVatPlaceholder = $fieldCopy($exhibitorFieldsStepTwoByName, 'vat_number', 'placeholder', ['en' => '300000000000003', 'ar' => '300000000000003']);
              $exCrNumberLabel = $fieldCopy($exhibitorFieldsStepTwoByName, 'cr_number', 'label', ['en' => 'CR Number', 'ar' => 'رقم السجل التجاري']);
              $exCrNumberPlaceholder = $fieldCopy($exhibitorFieldsStepTwoByName, 'cr_number', 'placeholder', ['en' => '1010101010', 'ar' => '1010101010']);

              $pdfHint = ['en' => 'PDF files only (max 8MB)', 'ar' => 'ملفات PDF فقط (بحد أقصى 8 ميغابايت)'];
              $exCrCopyLabel = $fieldCopy($exhibitorFieldsStepTwoByName, 'cr_copy', 'label', ['en' => 'CR Copy (Commercial Registration)', 'ar' => 'نسخة السجل التجاري']);
              $exCrCopyHint = $fieldCopy($exhibitorFieldsStepTwoByName, 'cr_copy', 'hint', $pdfHint);
              $exLogoLabel = $fieldCopy($exhibitorFieldsStepTwoByName, 'company_logo', 'label', ['en' => 'Company Logo', 'ar' => 'شعار الشركة']);
              $exLogoHint = $fieldCopy($exhibitorFieldsStepTwoByName, 'company_logo', 'hint', $pdfHint);
              $exAddressLabel = $fieldCopy($exhibitorFieldsStepTwoByName, 'national_address_document', 'label', ['en' => 'National Address Document', 'ar' => 'مستند العنوان الوطني']);
              $exAddressHint = $fieldCopy($exhibitorFieldsStepTwoByName, 'national_address_document', 'hint', $pdfHint);
              @endphp
              <h3 class="form-title" data-en="{{ e($exhibitorFormTitle['en']) }}" data-ar="{{ e($exhibitorFormTitle['ar']) }}">{{ $exhibitorFormTitle['text'] }}</h3>
              <div class="step-indicator">
                <div class="step active" id="step1-indicator">
                  <span>1</span>
                  <span data-en="{{ e($exhibitorStepOne['en']) }}" data-ar="{{ e($exhibitorStepOne['ar']) }}">{{ $exhibitorStepOne['text'] }}</span>
                </div>
                <div class="step-divider"></div>
                <div class="step" id="step2-indicator">
                  <span>2</span>
                  <span data-en="{{ e($exhibitorStepTwo['en']) }}" data-ar="{{ e($exhibitorStepTwo['ar']) }}">{{ $exhibitorStepTwo['text'] }}</span>
                </div>
              </div>

              <form id="sponsor-registration-form"
                method="POST"
                action="{{ route('public.register.sponsor', ['locale' => $locale]) }}"
                enctype="multipart/form-data"
                novalidate
                data-success-title="{{ e(__('registration.sponsor.toast_title')) }}"
                data-success-message="{{ e(__('registration.sponsor.success')) }}">
                @csrf
                <input type="hidden" name="form_identifier" value="sponsor">
                <input type="hidden" name="exhibitor_step" id="exhibitor_step_input" value="{{ $sponsorFormActive ? old('exhibitor_step', 1) : 1 }}">
                <div id="exhibitor-step1">
                  <div class="form-grid form-grid-2">
                    <div class="form-group">
                      <label class="form-label" data-en="{{ e($exFullNameLabel['en']) }}" data-ar="{{ e($exFullNameLabel['ar']) }}">{{ $exFullNameLabel['text'] }}</label>
                      <input type="text" name="full_name" class="form-input" required placeholder="{{ $exFullNamePlaceholder['text'] }}"
                        value="{{ $sponsorFormActive ? old('full_name') : '' }}">
                      @if($sponsorFormActive && $errors->has('full_name'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('full_name') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label class="form-label" data-en="{{ e($exEmailLabel['en']) }}" data-ar="{{ e($exEmailLabel['ar']) }}">{{ $exEmailLabel['text'] }}</label>
                      <input type="email" name="email" class="form-input" required placeholder="{{ $exEmailPlaceholder['text'] }}"
                        value="{{ $sponsorFormActive ? old('email') : '' }}">
                      @if($sponsorFormActive && $errors->has('email'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('email') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-grid form-grid-2" style="margin-top: 1rem;">
                    <div class="form-group">
                      <label class="form-label" data-en="{{ e($exPhoneLabel['en']) }}" data-ar="{{ e($exPhoneLabel['ar']) }}">{{ $exPhoneLabel['text'] }}</label>
                      <input type="tel" name="phone" class="form-input" required placeholder="{{ $exPhonePlaceholder['text'] }}"
                        value="{{ $sponsorFormActive ? old('phone') : '' }}">
                      @if($sponsorFormActive && $errors->has('phone'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('phone') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label class="form-label" data-en="{{ e($exJobLabel['en']) }}" data-ar="{{ e($exJobLabel['ar']) }}">{{ $exJobLabel['text'] }}</label>
                      <input type="text" name="job_title" class="form-input" required placeholder="{{ $exJobPlaceholder['text'] }}"
                        value="{{ $sponsorFormActive ? old('job_title') : '' }}">
                      @if($sponsorFormActive && $errors->has('job_title'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('job_title') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-grid" style="margin-top:1rem;">
                    <div class="form-group">
                      <label class="form-label" data-en="{{ e($exOrgLabel['en']) }}" data-ar="{{ e($exOrgLabel['ar']) }}">{{ $exOrgLabel['text'] }}</label>
                      <input type="text" name="organization" class="form-input" placeholder="{{ $exOrgPlaceholder['text'] }}"
                        value="{{ $sponsorFormActive ? old('organization') : '' }}">
                      @if($sponsorFormActive && $errors->has('organization'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('organization') }}</p>
                      @endif
                    </div>
                  </div>
                </div>

                <div id="exhibitor-step2" style="display: none;">
                  <div class="form-grid form-grid-2">
                    <div class="form-group">
                      <label class="form-label" data-en="{{ e($exVatLabel['en']) }}" data-ar="{{ e($exVatLabel['ar']) }}">{{ $exVatLabel['text'] }}</label>
                      <input type="text" name="vat_number" class="form-input" placeholder="{{ $exVatPlaceholder['text'] }}"
                        value="{{ $sponsorFormActive ? old('vat_number') : '' }}">
                      @if($sponsorFormActive && $errors->has('vat_number'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('vat_number') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label class="form-label" data-en="{{ e($exCrNumberLabel['en']) }}" data-ar="{{ e($exCrNumberLabel['ar']) }}">{{ $exCrNumberLabel['text'] }}</label>
                      <input type="text" name="cr_number" class="form-input" placeholder="{{ $exCrNumberPlaceholder['text'] }}"
                        value="{{ $sponsorFormActive ? old('cr_number') : '' }}">
                      @if($sponsorFormActive && $errors->has('cr_number'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('cr_number') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-grid form-grid-2" style="margin-top: 1rem;">
                    <div class="form-group">
                      <label class="form-label" data-en="{{ e($exCrCopyLabel['en']) }}" data-ar="{{ e($exCrCopyLabel['ar']) }}">{{ $exCrCopyLabel['text'] }}</label>
                      <input type="file" name="cr_copy" class="form-input" accept="application/pdf,image/png,image/jpeg">
                      <span class="form-hint" data-en="{{ e($exCrCopyHint['en']) }}" data-ar="{{ e($exCrCopyHint['ar']) }}">{{ $exCrCopyHint['text'] }}</span>
                      @if($sponsorFormActive && $errors->has('cr_copy'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('cr_copy') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label class="form-label" data-en="{{ e($exLogoLabel['en']) }}" data-ar="{{ e($exLogoLabel['ar']) }}">{{ $exLogoLabel['text'] }}</label>
                      <input type="file" name="company_logo" class="form-input" accept="application/pdf">
                      <span class="form-hint" data-en="{{ e($exLogoHint['en']) }}" data-ar="{{ e($exLogoHint['ar']) }}">{{ $exLogoHint['text'] }}</span>
                      @if($sponsorFormActive && $errors->has('company_logo'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('company_logo') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-grid form-grid-2" style="margin-top: 1rem;">
                    <div class="form-group">
                      <label class="form-label" data-en="{{ e($exAddressLabel['en']) }}" data-ar="{{ e($exAddressLabel['ar']) }}">{{ $exAddressLabel['text'] }}</label>
                      <input type="file" name="national_address_document" class="form-input" accept="application/pdf,image/png,image/jpeg">
                      <span class="form-hint" data-en="{{ e($exAddressHint['en']) }}" data-ar="{{ e($exAddressHint['ar']) }}">{{ $exAddressHint['text'] }}</span>
                      @if($sponsorFormActive && $errors->has('national_address_document'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('national_address_document') }}</p>
                      @endif
                    </div>
                  </div>

                  <div class="form-group" style="margin-top: 1rem;">
                    <label class="form-label" style="flex-direction: row; align-items: center; gap: 0.5rem;">
                      <input type="checkbox" name="privacy_policy" value="1" required @checked($sponsorFormActive && old('privacy_policy'))>
                      <span data-en="I accept the privacy policy" data-ar="أوافق على سياسة الخصوصية">I accept the privacy policy</span>
                      <a class="blue-url-style" href="{{ asset('pdf/privacy-policy.pdf') }}" target="_blank" rel="noopener" download data-en="Download from here" data-ar="يمكنك تحميل الملف منها">Download from here</a>
                    </label>
                    @if($sponsorFormActive && $errors->has('privacy_policy'))
                    <p class="mt-1 text-xs text-red-600">{{ $errors->first('privacy_policy') }}</p>
                    @endif
                  </div>
                </div>

                <div class="form-buttons">
                  <button type="button" class="btn btn-outline" onclick="exhibitorBack()">
                    <svg class="icon icon-sm" style="margin-right: 0.5rem;" viewBox="0 0 24 24">
                      <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                    <span data-en="Back" data-ar="رجوع">{{ __('Back') }}</span>
                  </button>
                  <button type="button" class="btn btn-primary" id="exhibitor-next-btn" onclick="exhibitorNext()">
                    <span data-en="{{ e($exhibitorNext['en']) }}" data-ar="{{ e($exhibitorNext['ar']) }}">{{ $exhibitorNext['text'] }}</span>
                    <svg class="icon icon-sm" style="margin-left: 0.5rem;" viewBox="0 0 24 24">
                      <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                  </button>
                  <button type="submit" class="btn btn-primary" id="exhibitor-submit-btn" style="display: none;" data-en="{{ e($exhibitorSubmit['en']) }}" data-ar="{{ e($exhibitorSubmit['ar']) }}">{{ $exhibitorSubmit['text'] }}</button>
                  <button type="button" class="btn btn-outline" onclick="scrollToContact()" data-en="{{ e($guestContact['en']) }}" data-ar="{{ e($guestContact['ar']) }}">{{ $guestContact['text'] }}</button>
                </div>
              </form>
            </div>

            <div class="role-card" id="icon-card" onclick="selectRole('icon')">
              <div class="role-icon">
                <svg class="icon icon-lg" viewBox="0 0 24 24">
                  <path d="M12 2l2.4 4.9 5.4.8-3.9 3.8.9 5.4L12 14.9 7.3 16.9l.9-5.4L4.3 7.7l5.4-.8L12 2Z" />
                </svg>
              </div>
              <h3 class="role-title" data-en="{{ e($iconCardTitle['en']) }}" data-ar="{{ e($iconCardTitle['ar']) }}">{{ $iconCardTitle['text'] }}</h3>
              <p class="role-desc" data-en="{{ e($iconCardDescription['en']) }}" data-ar="{{ e($iconCardDescription['ar']) }}">{{ $iconCardDescription['text'] }}</p>
              <div class="role-cta" id="icon-cta">
                <span data-en="{{ e($iconCta['en']) }}" data-ar="{{ e($iconCta['ar']) }}">{{ $iconCta['text'] }}</span>
                <svg class="icon icon-sm" viewBox="0 0 24 24">
                  <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
              </div>
            </div>

            <div class="form-card" id="icon-form">
              @if(session('icon_success'))
              <div class="mb-4 rounded-lg border border-emerald-100 bg-emerald-50 px-3 py-2 text-sm text-emerald-900">
                {{ session('icon_success') }}
              </div>
              @endif
              @php
              $iconFullNameLabel = $fieldCopy($iconFieldsStepOneByName, 'full_name', 'label', ['en' => 'Full Name *', 'ar' => 'الاسم الكامل *']);
              $iconFullNamePlaceholder = $fieldCopy($iconFieldsStepOneByName, 'full_name', 'placeholder', ['en' => 'John Doe', 'ar' => 'جون دو']);
              $iconEmailLabel = $fieldCopy($iconFieldsStepOneByName, 'email', 'label', ['en' => 'Email *', 'ar' => 'البريد الإلكتروني *']);
              $iconEmailPlaceholder = $fieldCopy($iconFieldsStepOneByName, 'email', 'placeholder', ['en' => 'john@company.com', 'ar' => 'john@company.com']);
              $iconPhoneLabel = $fieldCopy($iconFieldsStepOneByName, 'phone', 'label', ['en' => 'Phone *', 'ar' => 'الهاتف *']);
              $iconPhonePlaceholder = $fieldCopy($iconFieldsStepOneByName, 'phone', 'placeholder', ['en' => '+966 50 000 0000', 'ar' => '+966 50 000 0000']);
              $iconJobLabel = $fieldCopy($iconFieldsStepOneByName, 'job_title', 'label', ['en' => 'Job Title *', 'ar' => 'المسمى الوظيفي *']);
              $iconJobPlaceholder = $fieldCopy($iconFieldsStepOneByName, 'job_title', 'placeholder', ['en' => 'Marketing Manager', 'ar' => 'مدير التسويق']);
              $iconOrgLabel = $fieldCopy($iconFieldsStepOneByName, 'organization', 'label', ['en' => 'Company / Organization', 'ar' => 'الشركة / الجهة']);
              $iconOrgPlaceholder = $fieldCopy($iconFieldsStepOneByName, 'organization', 'placeholder', ['en' => 'Umbrella Inc.', 'ar' => 'شركة أمبريلا']);
              $iconLocationLabel = $fieldCopy($iconFieldsStepOneByName, 'location_selection', 'label', ['en' => trans('registration.icon.book_location', [], 'en'), 'ar' => trans('registration.icon.book_location', [], 'ar')]);
              $iconLocationPlaceholder = $fieldCopy($iconFieldsStepOneByName, 'location_selection', 'placeholder', ['en' => 'Select on the hall map', 'ar' => 'اختر من خريطة القاعة']);

              $iconVatLabel = $fieldCopy($iconFieldsStepTwoByName, 'vat_number', 'label', ['en' => trans('registration.icon.vat_number', [], 'en'), 'ar' => trans('registration.icon.vat_number', [], 'ar')]);
              $iconVatPlaceholder = $fieldCopy($iconFieldsStepTwoByName, 'vat_number', 'placeholder', ['en' => '300000000000003', 'ar' => '300000000000003']);
              $iconCrLabel = $fieldCopy($iconFieldsStepTwoByName, 'cr_number', 'label', ['en' => trans('registration.icon.cr_number', [], 'en'), 'ar' => trans('registration.icon.cr_number', [], 'ar')]);
              $iconCrPlaceholder = $fieldCopy($iconFieldsStepTwoByName, 'cr_number', 'placeholder', ['en' => '1010101010', 'ar' => '1010101010']);

              $iconCrCopyLabel = $fieldCopy($iconFieldsStepTwoByName, 'cr_copy', 'label', ['en' => trans('registration.icon.cr_copy', [], 'en'), 'ar' => trans('registration.icon.cr_copy', [], 'ar')]);
              $iconCrCopyHint = $fieldCopy($iconFieldsStepTwoByName, 'cr_copy', 'hint', $pdfHint);
              $iconLogoLabel = $fieldCopy($iconFieldsStepTwoByName, 'company_logo', 'label', ['en' => trans('registration.icon.company_logo', [], 'en'), 'ar' => trans('registration.icon.company_logo', [], 'ar')]);
              $iconLogoHint = $fieldCopy($iconFieldsStepTwoByName, 'company_logo', 'hint', $pdfHint);
              $iconAddressLabel = $fieldCopy($iconFieldsStepTwoByName, 'national_address_document', 'label', ['en' => trans('registration.icon.national_address_document', [], 'en'), 'ar' => trans('registration.icon.national_address_document', [], 'ar')]);
              $iconAddressHint = $fieldCopy($iconFieldsStepTwoByName, 'national_address_document', 'hint', $pdfHint);
              @endphp
              <h3 class="form-title" data-en="{{ e($iconFormTitle['en']) }}" data-ar="{{ e($iconFormTitle['ar']) }}">{{ $iconFormTitle['text'] }}</h3>
              <div class="step-indicator">
                <div class="step active" id="icon-step1-indicator">
                  <span>1</span>
                  <span data-en="{{ e($iconStepOne['en']) }}" data-ar="{{ e($iconStepOne['ar']) }}">{{ $iconStepOne['text'] }}</span>
                </div>
                <div class="step-divider"></div>
                <div class="step" id="icon-step2-indicator">
                  <span>2</span>
                  <span data-en="{{ e($iconStepTwo['en']) }}" data-ar="{{ e($iconStepTwo['ar']) }}">{{ $iconStepTwo['text'] }}</span>
                </div>
              </div>

              <form id="icon-registration-form"
                method="POST"
                action="{{ \Illuminate\Support\Facades\Route::has('public.register.icon') ? route('public.register.icon', ['locale' => $locale]) : '#' }}"
                enctype="multipart/form-data"
                novalidate
                data-success-title="{{ e(__('registration.icon.toast_title')) }}"
                data-success-message="{{ e(__('registration.icon.success')) }}">
                @csrf
                <input type="hidden" name="form_identifier" value="icon">
                <input type="hidden" name="icon_step" id="icon_step_input" value="{{ $iconFormActive ? old('icon_step', 1) : 1 }}">
                <div id="icon-step1">
                  <div class="form-grid form-grid-2">
                    <div class="form-group">
                      <label class="form-label" data-en="{{ e($iconFullNameLabel['en']) }}" data-ar="{{ e($iconFullNameLabel['ar']) }}">{{ $iconFullNameLabel['text'] }}</label>
                      <input type="text" name="full_name" class="form-input" required placeholder="{{ $iconFullNamePlaceholder['text'] }}"
                        value="{{ $iconFormActive ? old('full_name') : '' }}">
                      @if($iconFormActive && $errors->has('full_name'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('full_name') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label class="form-label" data-en="{{ e($iconEmailLabel['en']) }}" data-ar="{{ e($iconEmailLabel['ar']) }}">{{ $iconEmailLabel['text'] }}</label>
                      <input type="email" name="email" class="form-input" required placeholder="{{ $iconEmailPlaceholder['text'] }}"
                        value="{{ $iconFormActive ? old('email') : '' }}">
                      @if($iconFormActive && $errors->has('email'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('email') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-grid form-grid-2" style="margin-top: 1rem;">
                    <div class="form-group">
                      <label class="form-label" data-en="{{ e($iconPhoneLabel['en']) }}" data-ar="{{ e($iconPhoneLabel['ar']) }}">{{ $iconPhoneLabel['text'] }}</label>
                      <input type="tel" name="phone" class="form-input" required placeholder="{{ $iconPhonePlaceholder['text'] }}"
                        value="{{ $iconFormActive ? old('phone') : '' }}">
                      @if($iconFormActive && $errors->has('phone'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('phone') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label class="form-label" data-en="{{ e($iconJobLabel['en']) }}" data-ar="{{ e($iconJobLabel['ar']) }}">{{ $iconJobLabel['text'] }}</label>
                      <input type="text" name="job_title" class="form-input" required placeholder="{{ $iconJobPlaceholder['text'] }}"
                        value="{{ $iconFormActive ? old('job_title') : '' }}">
                      @if($iconFormActive && $errors->has('job_title'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('job_title') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-grid" style="margin-top:1rem;">
                    <div class="form-group">
                      <label class="form-label" data-en="{{ e($iconOrgLabel['en']) }}" data-ar="{{ e($iconOrgLabel['ar']) }}">{{ $iconOrgLabel['text'] }}</label>
                      <input type="text" name="organization" class="form-input" placeholder="{{ $iconOrgPlaceholder['text'] }}"
                        value="{{ $iconFormActive ? old('organization') : '' }}">
                      @if($iconFormActive && $errors->has('organization'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('organization') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-grid" style="margin-top:1rem;">
                    <div class="form-group">
                      <label class="form-label"
                        data-en="{{ e($iconLocationLabel['en']) }}"
                        data-ar="{{ e($iconLocationLabel['ar']) }}">
                        {{ $iconLocationLabel['text'] }}
                      </label>
                      <div class="flex gap-3 flex-col sm:flex-row">
                        <input type="text"
                          id="icon-location-selection"
                          name="location_selection"
                          class="form-input flex-1"
                          required
                          readonly
                          placeholder="{{ $iconLocationPlaceholder['text'] }}"
                          value="{{ $iconFormActive ? old('location_selection') : '' }}">
                        <button type="button" class="btn btn-outline flex-none" onclick="openHallDesign('icon-location-selection')">
                          <span data-en="Open hall map" data-ar="افتح خريطة القاعة">Open hall map</span>
                        </button>
                      </div>
                      @if($iconFormActive && $errors->has('location_selection'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('location_selection') }}</p>
                      @endif
                    </div>
                  </div>
                </div>

                <div id="icon-step2" style="display: none;">
                  <div class="form-grid form-grid-2">
                    <div class="form-group">
                      <label class="form-label" data-en="{{ e($iconVatLabel['en']) }}" data-ar="{{ e($iconVatLabel['ar']) }}">{{ $iconVatLabel['text'] }}</label>
                      <input type="text" name="vat_number" class="form-input" placeholder="{{ $iconVatPlaceholder['text'] }}"
                        value="{{ $iconFormActive ? old('vat_number') : '' }}">
                      @if($iconFormActive && $errors->has('vat_number'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('vat_number') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label class="form-label" data-en="{{ e($iconCrLabel['en']) }}" data-ar="{{ e($iconCrLabel['ar']) }}">{{ $iconCrLabel['text'] }}</label>
                      <input type="text" name="cr_number" class="form-input" placeholder="{{ $iconCrPlaceholder['text'] }}"
                        value="{{ $iconFormActive ? old('cr_number') : '' }}">
                      @if($iconFormActive && $errors->has('cr_number'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('cr_number') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-grid form-grid-2" style="margin-top: 1rem;">
                    <div class="form-group">
                      <label class="form-label" data-en="{{ e($iconCrCopyLabel['en']) }}" data-ar="{{ e($iconCrCopyLabel['ar']) }}">{{ $iconCrCopyLabel['text'] }}</label>
                      <input type="file" name="cr_copy" class="form-input" accept="application/pdf,image/png,image/jpeg">
                      <span class="form-hint" data-en="{{ e($iconCrCopyHint['en']) }}" data-ar="{{ e($iconCrCopyHint['ar']) }}">{{ $iconCrCopyHint['text'] }}</span>
                      @if($iconFormActive && $errors->has('cr_copy'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('cr_copy') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label class="form-label" data-en="{{ e($iconLogoLabel['en']) }}" data-ar="{{ e($iconLogoLabel['ar']) }}">{{ $iconLogoLabel['text'] }}</label>
                      <input type="file" name="company_logo" class="form-input" accept="application/pdf">
                      <span class="form-hint" data-en="{{ e($iconLogoHint['en']) }}" data-ar="{{ e($iconLogoHint['ar']) }}">{{ $iconLogoHint['text'] }}</span>
                      @if($iconFormActive && $errors->has('company_logo'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('company_logo') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-grid form-grid-2" style="margin-top: 1rem;">
                    <div class="form-group">
                      <label class="form-label" data-en="{{ e($iconAddressLabel['en']) }}" data-ar="{{ e($iconAddressLabel['ar']) }}">{{ $iconAddressLabel['text'] }}</label>
                      <input type="file" name="national_address_document" class="form-input" accept="application/pdf,image/png,image/jpeg">
                      <span class="form-hint" data-en="{{ e($iconAddressHint['en']) }}" data-ar="{{ e($iconAddressHint['ar']) }}">{{ $iconAddressHint['text'] }}</span>
                      @if($iconFormActive && $errors->has('national_address_document'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('national_address_document') }}</p>
                      @endif
                    </div>
                  </div>

                  <div class="form-group" style="margin-top: 1rem;">
                    <label class="form-label" style="flex-direction: row; align-items: center; gap: 0.5rem;">
                      <input type="checkbox" name="privacy_policy" value="1" required @checked($iconFormActive && old('privacy_policy'))>
                      <span data-en="I accept the privacy policy" data-ar="أوافق على سياسة الخصوصية">I accept the privacy policy</span>
                      <a class="blue-url-style" href="{{ asset('pdf/privacy-policy.pdf') }}" target="_blank" rel="noopener" download data-en="Download from here" data-ar="يمكنك تحميل الملف منها">Download from here</a>
                    @if($iconFormActive && $errors->has('privacy_policy'))
                    <p class="mt-1 text-xs text-red-600">{{ $errors->first('privacy_policy') }}</p>
                    @endif
                  </div>
                </div>

                <div class="form-buttons">
                  <button type="button" class="btn btn-outline" onclick="iconBack()">
                    <svg class="icon icon-sm" style="margin-right: 0.5rem;" viewBox="0 0 24 24">
                      <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                    <span data-en="{{ e($iconBack['en']) }}" data-ar="{{ e($iconBack['ar']) }}">{{ $iconBack['text'] }}</span>
                  </button>
                  <button type="button" class="btn btn-primary" id="icon-next-btn" onclick="iconNext()">
                    <span data-en="{{ e($iconNext['en']) }}" data-ar="{{ e($iconNext['ar']) }}">{{ $iconNext['text'] }}</span>
                    <svg class="icon icon-sm" style="margin-left: 0.5rem;" viewBox="0 0 24 24">
                      <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                  </button>
                  <button type="submit" class="btn btn-primary" id="icon-submit-btn" style="display: none;" data-en="{{ e($iconSubmit['en']) }}" data-ar="{{ e($iconSubmit['ar']) }}">{{ $iconSubmit['text'] }}</button>
                  <button type="button" class="btn btn-outline" onclick="scrollToContact()" data-en="{{ e($guestContact['en']) }}" data-ar="{{ e($guestContact['ar']) }}">{{ $guestContact['text'] }}</button>
                </div>
              </form>
            </div>

            <div class="row-logo" id="guest-row-logo">
              <img src="{{ asset('img/IEC-logo.png') }}" alt="IEC Logo">
            </div>

            <div class="role-card guest-card" id="visitor-card" onclick="selectRole('visitor')">
              <div class="role-icon">
                <svg class="icon icon-lg" viewBox="0 0 24 24">
                  <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                  <circle cx="12" cy="7" r="4" />
                </svg>
              </div>
              <h3 class="role-title" data-en="{{ e($guestCardTitle['en']) }}" data-ar="{{ e($guestCardTitle['ar']) }}">{{ $guestCardTitle['text'] }}</h3>
              <p class="role-desc" data-en="{{ e($guestCardDescription['en']) }}" data-ar="{{ e($guestCardDescription['ar']) }}">{{ $guestCardDescription['text'] }}</p>
              <div class="role-cta" id="visitor-cta">
                <span data-en="{{ e($guestCta['en']) }}" data-ar="{{ e($guestCta['ar']) }}">{{ $guestCta['text'] }}</span>
                <svg class="icon icon-sm" viewBox="0 0 24 24">
                  <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
              </div>
            </div>
            <div class="form-card guest-form" id="visitor-form">
              @if(session('visitor_success'))
              <div class="mb-4 rounded-lg border border-emerald-100 bg-emerald-50 px-3 py-2 text-sm text-emerald-900">
                {{ session('visitor_success') }}
              </div>
              @endif
              @php
              $guestFullNameLabel = $fieldCopy($visitorFieldsByName, 'full_name', 'label', ['en' => 'Full Name *', 'ar' => 'الاسم الكامل *']);
              $guestFullNamePlaceholder = $fieldCopy($visitorFieldsByName, 'full_name', 'placeholder', ['en' => 'John Doe', 'ar' => 'جون دو']);
              $guestEmailLabel = $fieldCopy($visitorFieldsByName, 'email', 'label', ['en' => 'Email *', 'ar' => 'البريد الإلكتروني *']);
              $guestEmailPlaceholder = $fieldCopy($visitorFieldsByName, 'email', 'placeholder', ['en' => 'john@example.com', 'ar' => 'john@example.com']);
              $guestPhoneLabel = $fieldCopy($visitorFieldsByName, 'phone', 'label', ['en' => 'Phone', 'ar' => 'الهاتف']);
              $guestPhonePlaceholder = $fieldCopy($visitorFieldsByName, 'phone', 'placeholder', ['en' => '+966 50 000 0000', 'ar' => '+966 50 000 0000']);
              $guestJobLabel = $fieldCopy($visitorFieldsByName, 'job_title', 'label', ['en' => 'Job Title', 'ar' => 'المسمى الوظيفي']);
              $guestJobPlaceholder = $fieldCopy($visitorFieldsByName, 'job_title', 'placeholder', ['en' => 'Marketing Manager', 'ar' => 'مدير التسويق']);
              $guestCompanyLabel = $fieldCopy($visitorFieldsByName, 'company_name', 'label', ['en' => 'Company / Organization', 'ar' => 'الشركة / الجهة']);
              $guestCompanyPlaceholder = $fieldCopy($visitorFieldsByName, 'company_name', 'placeholder', ['en' => 'Umbrella Inc.', 'ar' => 'شركة أمبريلا']);
              $guestHeardLabel = $fieldCopy($visitorFieldsByName, 'heard_about', 'label', ['en' => 'How did you hear about us?', 'ar' => 'كيف سمعت عنا؟']);
              $guestHeardOptions = $fieldOptions($visitorFieldsByName, 'heard_about', [
              ['value' => 'social_media', 'en' => 'Social Media', 'ar' => 'وسائل التواصل الاجتماعي'],
              ['value' => 'ads', 'en' => 'Advertising', 'ar' => 'الإعلانات'],
              ['value' => 'friends', 'en' => 'Friends / Colleagues', 'ar' => 'الأصدقاء / الزملاء'],
              ['value' => 'other', 'en' => 'Other', 'ar' => 'أخرى'],
              ]);
              $guestHeardOtherLabel = $fieldCopy($visitorFieldsByName, 'heard_about_other_text', 'label', ['en' => 'Please specify', 'ar' => 'يرجى التحديد']);
              $guestHeardOtherPlaceholder = $fieldCopy($visitorFieldsByName, 'heard_about_other_text', 'placeholder', ['en' => 'Conference website', 'ar' => 'موقع المؤتمر']);
              @endphp
              <h3 class="form-title" data-en="{{ e($guestFormTitle['en']) }}" data-ar="{{ e($guestFormTitle['ar']) }}">{{ $guestFormTitle['text'] }}</h3>
              <form id="visitor-registration-form"
                method="POST"
                action="{{ route('public.register.visitor', ['locale' => $locale]) }}"
                novalidate
                data-success-title="{{ e(__('registration.guest.toast_title')) }}"
                data-success-message="{{ e(__('registration.guest.success')) }}">
                @csrf
                <input type="hidden" name="form_identifier" value="visitor">
                <div class="form-grid form-grid-2">
                  <div class="form-group">
                    <label class="form-label" data-en="{{ e($guestFullNameLabel['en']) }}" data-ar="{{ e($guestFullNameLabel['ar']) }}">{{ $guestFullNameLabel['text'] }}</label>
                    <input type="text" name="full_name" class="form-input" required placeholder="{{ $guestFullNamePlaceholder['text'] }}"
                      value="{{ $visitorFormActive ? old('full_name') : '' }}">
                    @if($visitorFormActive && $errors->has('full_name'))
                    <p class="mt-1 text-xs text-red-600">{{ $errors->first('full_name') }}</p>
                    @endif
                  </div>
                  <div class="form-group">
                    <label class="form-label" data-en="{{ e($guestEmailLabel['en']) }}" data-ar="{{ e($guestEmailLabel['ar']) }}">{{ $guestEmailLabel['text'] }}</label>
                    <input type="email" name="email" class="form-input" required placeholder="{{ $guestEmailPlaceholder['text'] }}"
                      value="{{ $visitorFormActive ? old('email') : '' }}">
                    @if($visitorFormActive && $errors->has('email'))
                    <p class="mt-1 text-xs text-red-600">{{ $errors->first('email') }}</p>
                    @endif
                  </div>
                </div>

                <div class="form-grid form-grid-2" style="margin-top:1rem;">
                  <div class="form-group">
                    <label class="form-label" data-en="{{ e($guestPhoneLabel['en']) }}" data-ar="{{ e($guestPhoneLabel['ar']) }}">{{ $guestPhoneLabel['text'] }}</label>
                    <input type="tel" name="phone" class="form-input" placeholder="{{ $guestPhonePlaceholder['text'] }}"
                      value="{{ $visitorFormActive ? old('phone') : '' }}">
                    @if($visitorFormActive && $errors->has('phone'))
                    <p class="mt-1 text-xs text-red-600">{{ $errors->first('phone') }}</p>
                    @endif
                  </div>
                  <div class="form-group">
                    <label class="form-label" data-en="{{ e($guestJobLabel['en']) }}" data-ar="{{ e($guestJobLabel['ar']) }}">{{ $guestJobLabel['text'] }}</label>
                    <input type="text" name="job_title" class="form-input" placeholder="{{ $guestJobPlaceholder['text'] }}"
                      value="{{ $visitorFormActive ? old('job_title') : '' }}">
                    @if($visitorFormActive && $errors->has('job_title'))
                    <p class="mt-1 text-xs text-red-600">{{ $errors->first('job_title') }}</p>
                    @endif
                  </div>
                </div>

                <div class="form-grid form-grid-2" style="margin-top:1rem;">
                  <div class="form-group">
                    <label class="form-label" data-en="{{ e($guestCompanyLabel['en']) }}" data-ar="{{ e($guestCompanyLabel['ar']) }}">{{ $guestCompanyLabel['text'] }}</label>
                    <input type="text" name="company_name" class="form-input" placeholder="{{ $guestCompanyPlaceholder['text'] }}"
                      value="{{ $visitorFormActive ? old('company_name') : '' }}">
                    @if($visitorFormActive && $errors->has('company_name'))
                    <p class="mt-1 text-xs text-red-600">{{ $errors->first('company_name') }}</p>
                    @endif
                  </div>
                  <div class="form-group">
                    <label class="form-label" data-en="{{ e($guestHeardLabel['en']) }}" data-ar="{{ e($guestHeardLabel['ar']) }}">{{ $guestHeardLabel['text'] }}</label>
                    <select class="form-select" name="heard_about" data-heard-select data-other-target="#visitor-heard-other">
                      <option value="">{{ __('Select option') }}</option>
                      @foreach($guestHeardOptions as $option)
                      @php
                      $optionLabelEn = data_get($option, 'en', '');
                      $optionLabelAr = data_get($option, 'ar', $optionLabelEn);
                      $optionValue = data_get($option, 'value', $optionLabelEn);
                      $optionLabel = $registrationLocale === 'ar' ? $optionLabelAr : $optionLabelEn;
                      @endphp
                      <option value="{{ $optionValue }}" @selected($visitorFormActive && old('heard_about')===$optionValue ) data-en="{{ e($optionLabelEn) }}" data-ar="{{ e($optionLabelAr) }}">{{ $optionLabel }}</option>
                      @endforeach
                    </select>
                    @if($visitorFormActive && $errors->has('heard_about'))
                    <p class="mt-1 text-xs text-red-600">{{ $errors->first('heard_about') }}</p>
                    @endif
                  </div>
                </div>

                <div class="form-group" id="visitor-heard-other" style="{{ $visitorFormActive && old('heard_about') === 'other' ? '' : 'display:none;' }}; margin-top:1rem;">
                  <label class="form-label" data-en="{{ e($guestHeardOtherLabel['en']) }}" data-ar="{{ e($guestHeardOtherLabel['ar']) }}">{{ $guestHeardOtherLabel['text'] }}</label>
                  <input type="text" name="heard_about_other_text" class="form-input" placeholder="{{ $guestHeardOtherPlaceholder['text'] }}"
                    value="{{ $visitorFormActive ? old('heard_about_other_text') : '' }}">
                  @if($visitorFormActive && $errors->has('heard_about_other_text'))
                  <p class="mt-1 text-xs text-red-600">{{ $errors->first('heard_about_other_text') }}</p>
                  @endif
                </div>

                <div class="form-group" style="margin-top: 1rem;">
                  <label class="form-label" style="flex-direction: row; align-items: center; gap: 0.5rem;">
                    <input type="checkbox" name="privacy_policy" value="1" required @checked($visitorFormActive && old('privacy_policy'))>
                    <span data-en="I accept the privacy policy" data-ar="أوافق على سياسة الخصوصية">I accept the privacy policy</span>
                    <a class="blue-url-style" href="{{ asset('pdf/privacy-policy.pdf') }}" target="_blank" rel="noopener" download data-en="Download from here" data-ar="يمكنك تحميل الملف منها">Download from here</a>
                  </label>
                  @if($visitorFormActive && $errors->has('privacy_policy'))
                  <p class="mt-1 text-xs text-red-600">{{ $errors->first('privacy_policy') }}</p>
                  @endif
                </div>

                <div class="form-buttons">
                  <button type="button" class="btn btn-outline" onclick="clearRole()">
                    <svg class="icon icon-sm" style="margin-right: 0.5rem;" viewBox="0 0 24 24">
                      <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                    <span data-en="Back" data-ar="رجوع">{{ __('Back') }}</span>
                  </button>
                  <button type="submit" class="btn btn-primary" data-en="{{ e($guestSubmit['en']) }}" data-ar="{{ e($guestSubmit['ar']) }}">{{ $guestSubmit['text'] }}</button>
                  <button type="button" class="btn btn-outline" onclick="scrollToContact()" data-en="{{ e($guestContact['en']) }}" data-ar="{{ e($guestContact['ar']) }}">{{ $guestContact['text'] }}</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- About Section -->
    @php
    $aboutLocale = app()->getLocale();
    $aboutTranslate = function ($node, $fallback = '') use ($aboutLocale) {
    $en = data_get($node, 'en', $fallback);
    $ar = data_get($node, 'ar', $en);
    return [
    'en' => $en,
    'ar' => $ar,
    'text' => $aboutLocale === 'ar' ? $ar : $en,
    ];
    };
    $aboutTitle = $aboutTranslate(data_get($aboutSection, 'title'), __('About us'));
    $missionBlock = data_get($aboutSection, 'mission', []);
    $missionTitle = $aboutTranslate(data_get($missionBlock, 'title'), __('Our Mission'));
    $missionParagraphs = data_get($missionBlock, 'paragraphs', []);
    $goals = data_get($aboutSection, 'goals', []);
    $aboutVideo = \App\Models\LandingSection::mediaUrl($aboutSection['background_video'] ?? null) ?? asset('video/video.mp4');
    @endphp

    <section class="about" id="about">
      <div class="about-video-container" aria-hidden="true">
        <video class="about-video" autoplay muted loop playsinline preload="auto">
          <source src="{{ $aboutVideo }}" type="video/mp4">
        </video>
      </div>
      <div class="container">
        <h2 class="section-title" data-en="{{ e($aboutTitle['en']) }}" data-ar="{{ e($aboutTitle['ar']) }}" style="margin-bottom:20px; color:#fff; text-align: center;">{{ $aboutTitle['text'] }}</h2>
        <div class="about-grid">
          <div class="about-col" data-animate>
            <div class="about-header">
              <div class="about-icon">
                <svg class="icon" viewBox="0 0 24 24">
                  <circle cx="12" cy="12" r="10" />
                  <path d="M12 8v4l3 3" />
                </svg>
              </div>
              <h2 class="about-title" data-en="{{ e($missionTitle['en']) }}" data-ar="{{ e($missionTitle['ar']) }}">{{ $missionTitle['text'] }}</h2>
            </div>
            <div class="about-card">
              @forelse($missionParagraphs as $paragraph)
              @php $paragraphCopy = $aboutTranslate($paragraph); @endphp
              <p class="about-text" data-en="{{ e($paragraphCopy['en']) }}" data-ar="{{ e($paragraphCopy['ar']) }}">{{ $paragraphCopy['text'] }}</p>
              @empty
              <p class="about-text">{{ __('Mission details will be shared soon.') }}</p>
              @endforelse
            </div>
          </div>

          <div class="about-col" data-animate>
            @php $goalsTitle = $aboutTranslate(['en' => __('Our Goals'), 'ar' => __('أهدافنا')], __('Our Goals')); @endphp
            <h2 class="about-title" data-en="{{ e($goalsTitle['en']) }}" data-ar="{{ e($goalsTitle['ar']) }}" style="margin-bottom: 1.5rem;">{{ $goalsTitle['text'] }}</h2>
            <div class="goals-list">
              @forelse($goals as $goal)
              @php
              $goalTitle = $aboutTranslate(data_get($goal, 'title'), '');
              $goalDesc = $aboutTranslate(data_get($goal, 'description'), '');
              @endphp
              <div class="goal-card" data-animate>
                <div class="goal-icon">
                  <svg class="icon" viewBox="0 0 24 24">
                    <path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 1 1 7.072 0l-.548.547A3.374 3.374 0 0 0 14 18.469V19a2 2 0 1 1-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547Z" />
                  </svg>
                </div>
                <div>
                  <h3 class="goal-title" data-en="{{ e($goalTitle['en']) }}" data-ar="{{ e($goalTitle['ar']) }}">{{ $goalTitle['text'] }}</h3>
                  <p class="goal-desc" data-en="{{ e($goalDesc['en']) }}" data-ar="{{ e($goalDesc['ar']) }}">{{ $goalDesc['text'] }}</p>
                </div>
              </div>
              @empty
              <p class="text-sm text-gray-200">{{ __('Goals will be announced soon.') }}</p>
              @endforelse
            </div>
          </div>
        </div>
      </div>
    </section>



    <!-- Sponsors Section -->
    <section class="sponsors" id="sponsors">
      <div class="container">
        <div class="section-header" data-animate>
          <h2 class="section-title" data-en="Our Sponsors" data-ar="رعاتنا">Our Sponsors</h2>
          <p class="section-desc" data-en="We are grateful to our sponsors who make this event possible." data-ar="نحن ممتنون لرعاتنا الذين يجعلون هذا الحدث ممكناً.">We are grateful to our sponsors who make this event possible.</p>
        </div>

        @php
        $currentLocale = app()->getLocale();
        @endphp
        <div class="sponsor-tiers">
          @php $renderedSponsors = false; @endphp
          @foreach($sponsorTierLabels as $tierKey => $labelSet)
          @php
          $tierSponsors = $groupedSponsors->get($tierKey);
          $labelEn = $labelSet['en'] ?? '';
          $labelAr = $labelSet['ar'] ?? $labelEn;
          $label = $currentLocale === 'ar' ? $labelAr : $labelEn;
          @endphp
          @if($tierSponsors && $tierSponsors->count())
          @php $renderedSponsors = true; @endphp
          <div class="sponsor-tier">
            <h2 class="sponsor-tier-title" data-en="{{ e($labelEn) }}" data-ar="{{ e($labelAr) }}">{{ $label }}</h2>
            <div class="sponsor-tier-grid tier-{{ $tierKey }}">
              @foreach($tierSponsors as $sponsor)
              @php
              $logoPath = $sponsor->logo_path ? asset('storage/'.$sponsor->logo_path) : asset('img/IEC-logo.png');

              @endphp
              <article class="sponsor-card sponsor-{{ $tierKey }}" data-animate>
                  <div class="sponsor-logo">
                    <img src="{{ $logoPath }}" alt="">
                  </div>
              </article>
              @endforeach
            </div>
          </div>
          @endif
          @endforeach

          @php
          $otherSponsors = $groupedSponsors->filter(function ($_, $key) use ($sponsorTierLabels) {
          return ! array_key_exists($key, $sponsorTierLabels);
          })->flatten();
          @endphp

          @if($otherSponsors->count())
          @php $renderedSponsors = true; @endphp
          <div class="sponsor-tier">
            <h2 class="sponsor-tier-title" data-en="Sponsors" data-ar="الرعاة">Sponsors</h2>
            <div class="sponsor-tier-grid tier-main other-sponsors-grid">
              @foreach($otherSponsors as $sponsor)
              @php
              $logoPath = $sponsor->logo_path ? asset('storage/'.$sponsor->logo_path) : asset('img/IEC-logo.png');

              @endphp
              <article class="sponsor-card" data-animate>
                <!-- <a href=""
                  class="sponsor-card-link"> -->
                  <div class="sponsor-logo">
                    <img src="{{ $logoPath }}" alt="">
                  </div>
                <!-- </a> -->
              </article>
              @endforeach
            </div>
          </div>
          @endif

          @unless($renderedSponsors)
          <p class="text-center text-gray-500 text-sm">{{ __('Sponsors will be announced soon.') }}</p>
          @endunless
        </div>
      </div>
    </section>

    <!-- Participants Section -->
    <section class="participants" id="participants">
      <div class="container">
        <div class="section-header" data-animate>
          <h2 class="section-title" data-en="Icons" data-ar="الأيقونات">Icons</h2>
          <p class="section-desc" data-en="Meet the icons of IEC 360&deg;" data-ar="تعرّف على الـ Icons  المشاركين في IEC 360&deg;">Meet the icons of IEC 360&deg;</p>
        </div>

        <div class="participants-grid">
          @forelse($participants as $participant)
          @php
          $englishName = $participant->name ?? '';
          $arabicName = $participant->name_ar ?? $englishName;
          $participantName = app()->getLocale() === 'ar' ? $arabicName : $englishName;
          $participantHref = $participant->url
          ? $participant->url
          : route('public.participants.show', ['locale' => app()->getLocale(), 'participant' => $participant]);
          $isExternalParticipant = (bool) $participant->url;
          @endphp
          <a href=""
            class="participant-card"
            data-animate
            @if($isExternalParticipant) target="_blank" rel="noopener" @endif>
            <div class="participant-logo">
              @if($participant->logo_path)
              <img src="{{ asset('storage/'.$participant->logo_path) }}" alt="{{ $participantName }}">
              @else
              <span>{{ mb_strtoupper(mb_substr($participantName, 0, 1)) }}</span>
              @endif
            </div>
            <!-- <div class="participant-name" data-en="{{ e($englishName) }}" data-ar="{{ e($arabicName) }}">
              {{ $participantName }}
              @if($participant->url)
              <svg class="icon icon-sm external-icon" viewBox="0 0 24 24">
                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14 21 3" />
              </svg>
              @endif
            </div> -->
          </a>
          @empty
          <div class="participant-card" data-animate>
            <div class="participant-logo">ℹ️</div>
            <div class="participant-name">{{ __('Coming soon') }}</div>
            <p class="participant-desc">{{ __('Participants will be announced soon.') }}</p>
          </div>
          @endforelse
        </div>
      </div>
    </section>

    <!-- Organizers Section -->
    <section class="organizers" id="organizers">
      <div class="container">
        <div class="section-header" data-animate>
          <h2 class="section-title" data-en="Owned by" data-ar="الشركة المالكة">Owned by</h2>
          <p class="section-desc" data-en="Meet the teams orchestrating the IEC Expo experience." data-ar="تعرّف على الفرق التي تنظم تجربة المعرض الدولي للتجارة اﻹلكترونية.">
            Meet the teams orchestrating the IEC Expo experience.
          </p>
        </div>

        @php
        $organizerFallbackDesc = [
        'en' => __('Driving the strategic vision for IEC Expo.'),
        'ar' => __('يقودون الرؤية الاستراتيجية لمعرض IEC.'),
        ];
        $organizerVisitCopy = [
        'en' => __('Visit Website'),
        'ar' => __('زيارة الموقع'),
        ];
        $currentLocale = app()->getLocale();
        @endphp

        @if($organizers->count())
        <div class="sponsor-featured-list">
          @foreach($organizers as $organizer)
          @php
          $logoPath = $organizer->logo_path ? asset('storage/'.$organizer->logo_path) : asset('img/IEC-logo.png');
          $englishName = $organizer->name ?? '';
          $arabicName = $organizer->name_ar ?? $englishName;
          $displayName = $currentLocale === 'ar' ? $arabicName : $englishName;
          $descriptionEn = $organizer->description_en ?? $organizerFallbackDesc['en'];
          $descriptionAr = $organizer->description_ar ?? $organizerFallbackDesc['ar'];
          $description = $currentLocale === 'ar' ? $descriptionAr : $descriptionEn;
          @endphp
          <article class="sponsor-featured-card sponsor-strategic" data-animate>
            <div class="sponsor-featured-content">
              <div class="sponsor-featured-media">
                <div class="sponsor-featured-logo">
                  <img src="{{ $logoPath }}" alt="{{ $displayName }}">
                </div>
                @if($organizer->url)
                <a href="{{ $organizer->url }}" class="sponsor-visit-btn" target="_blank" rel="noopener">
                  <span data-en="{{ e($organizerVisitCopy['en']) }}" data-ar="{{ e($organizerVisitCopy['ar']) }}">{{ $organizerVisitCopy[$currentLocale] }}</span>
                  <svg class="icon icon-sm" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                  </svg>
                </a>
                @endif
              </div>
              <div class="sponsor-featured-body">
                <h3 class="sponsor-featured-name" data-en="{{ e($englishName) }}" data-ar="{{ e($arabicName) }}">{{ $displayName }}</h3>
                <p class="sponsor-featured-desc" data-en="{{ e($descriptionEn) }}" data-ar="{{ e($descriptionAr) }}">{{ $description }}</p>
              </div>
            </div>
          </article>
          @endforeach
        </div>
        @else
        <p class="text-center text-gray-500 text-sm">{{ __('Organizers will be announced soon.') }}</p>
        @endif
      </div>
    </section>

        <!-- Statistics Section -->
    <div class="stats-section">
      @forelse($heroStats as $index => $stat)
      @php
      $labelEn = data_get($stat, 'label.en', '');
      $labelAr = data_get($stat, 'label.ar', $labelEn);
      $label = $activeLocale === 'ar' ? $labelAr : $labelEn;
      $value = $stat['value'] ?? 0;
      $suffix = $stat['suffix'] ?? '';
      $iconClass = $stat['icon'] ?? 'fas fa-circle';
      @endphp
      <div class="stat-item" data-aos="zoom-in" data-aos-delay="{{ 100 * ($index + 1) }}">
        <div class="stat-icon-wrapper">
          <i class="{{ $iconClass }}"></i>
        </div>
        <div class="stat-number" data-count="{{ $value }}" data-suffix="{{ $suffix }}">{{ $value }}</div>
        <div class="stat-label" data-en="{{ e($labelEn) }}" data-ar="{{ e($labelAr) }}">{{ $label }}</div>
        <div class="stat-progress">
          <div class="progress-fill"></div>
        </div>
      </div>
      @empty
      <p class="text-center text-sm text-gray-500">{{ __('Stats will be announced soon.') }}</p>
      @endforelse
    </div>


    <!-- Contact Section -->
    @php
    $contactLocale = app()->getLocale();
    $contactTranslate = function ($node, $fallback = '') use ($contactLocale) {
    $en = data_get($node, 'en', $fallback);
    $ar = data_get($node, 'ar', $en);
    return [
    'en' => $en,
    'ar' => $ar,
    'text' => $contactLocale === 'ar' ? $ar : $en,
    ];
    };
    $contactTitleBlock = $contactTranslate(data_get($contactSection, 'title'), __('Contact Us'));
    $contactDescriptionBlock = $contactTranslate(data_get($contactSection, 'description'), '');
    $contactFormTitle = $contactTranslate(data_get($contactSection, 'form_title'), __('Send us a message'));
    $contactFormButton = $contactTranslate(data_get($contactSection, 'form_button'), __('Send Message'));
    $supportCards = data_get($contactSection, 'support_cards', []);
    $locationTitleBlock = $contactTranslate(data_get($contactSection, 'location_title'), __('Event Location'));
    $locationAddressBlock = $contactTranslate(data_get($contactSection, 'location_address'), '');
    $mapEmbedUrl = data_get($contactSection, 'map_embed', 'https://www.google.com/maps/place/The+Arena+Riyadh+Venue+for+Exhibitions+%7C+%D9%85%D8%B1%D9%83%D8%B2+%D8%B0%D9%8A+%D8%A3%D8%B1%D9%8A%D9%86%D8%A7+%D8%A7%D9%84%D8%B1%D9%8A%D8%A7%D8%B6+%D9%84%D9%84%D9%85%D8%B9%D8%A7%D8%B1%D8%B6+%D9%88%D8%A7%D9%84%D9%81%D8%B9%D8%A7%D9%84%D9%8A%D8%A7%D8%AA%E2%80%AD/@24.7779833,46.7296192,17z/data=!4m14!1m7!3m6!1s0x3e2efde8f1cd0b5d:0x4992b4380d1f29e5!2zVGhlIEFyZW5hIFJpeWFkaCBWZW51ZSBmb3IgRXhoaWJpdGlvbnMgfCDZhdix2YPYsiDYsNmKINij2LHZitmG2Kcg2KfZhNix2YrYp9i2INmE2YTZhdi52KfYsdi2INmI2KfZhNmB2LnYp9mE2YrYp9iq!8m2!3d24.7779833!4d46.7321941!16s%2Fg%2F11rwj51wpq!3m5!1s0x3e2efde8f1cd0b5d:0x4992b4380d1f29e5!8m2!3d24.7779833!4d46.7321941!16s%2Fg%2F11rwj51wpq?entry=ttu&g_ep=EgoyMDI1MTIwOS4wIKXMDSoASAFQAw%3D%3D');
    $locationImageUrl = \App\Models\LandingSection::mediaUrl(data_get($contactSection, 'location_image'));
    @endphp

    <section class="contact" id="contact">
      <div class="container">
        <div class="section-header" data-animate>
          <h2 class="section-title" data-en="{{ e($contactTitleBlock['en']) }}" data-ar="{{ e($contactTitleBlock['ar']) }}">{{ $contactTitleBlock['text'] }}</h2>
          <p class="section-desc" data-en="{{ e($contactDescriptionBlock['en']) }}" data-ar="{{ e($contactDescriptionBlock['ar']) }}">{{ $contactDescriptionBlock['text'] }}</p>
        </div>

        <div class="contact-grid">
          <div class="contact-col" data-animate>
            <div class="contact-form-card">
              <h3 class="form-title" data-en="{{ e($contactFormTitle['en']) }}" data-ar="{{ e($contactFormTitle['ar']) }}">{{ $contactFormTitle['text'] }}</h3>
              <form onsubmit="handleContactSubmit(event)">
                <div class="form-grid">
                  <div class="form-group">
                    <label class="form-label" data-en="Name *" data-ar="الاسم *">{{ __('Name *') }}</label>
                    <input type="text" class="form-input" required placeholder="{{ __('Your name') }}">
                  </div>
                  <div class="form-group">
                    <label class="form-label" data-en="Email *" data-ar="البريد الإلكتروني *">{{ __('Email *') }}</label>
                    <input type="email" class="form-input" required placeholder="you@example.com">
                  </div>
                  <div class="form-group">
                    <label class="form-label" data-en="Phone *" data-ar="الهاتف *">{{ __('Phone *') }}</label>
                    <input type="tel" class="form-input" required placeholder="+966 50 000 0000">
                  </div>
                  <div class="form-group">
                    <label class="form-label" data-en="Message *" data-ar="الرسالة *">{{ __('Message *') }}</label>
                    <textarea class="form-textarea" required rows="4" placeholder="{{ __('How can we help you?') }}"></textarea>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                  <svg class="icon icon-sm" style="margin-right: 0.5rem;" viewBox="0 0 24 24">
                    <path d="m22 2-7 20-4-9-9-4Z" />
                    <path d="M22 2 11 13" />
                  </svg>
                  <span data-en="{{ e($contactFormButton['en']) }}" data-ar="{{ e($contactFormButton['ar']) }}">{{ $contactFormButton['text'] }}</span>
                </button>
              </form>
            </div>
          </div>

          <div class="contact-col" data-animate>
            <div class="contact-info-list">
              @forelse($supportCards as $card)
              @php $cardTitle = $contactTranslate(data_get($card, 'title'), ''); @endphp
              <div class="contact-info-card">
                <div class="contact-info-header">
                  <div style="flex: 1;">
                    <div class="contact-info-name" data-en="{{ e($cardTitle['en']) }}" data-ar="{{ e($cardTitle['ar']) }}">
                      {{ $cardTitle['text'] }}
                    </div>
                    <div class="contact-info-links two-columns">
                      @foreach (data_get($card, 'columns', []) as $column)
                      @php $columnHeading = $contactTranslate(data_get($column, 'heading'), ''); @endphp
                      <div class="contact-info-column">
                        <div class="contact-info-column-header" data-en="{{ e($columnHeading['en']) }}" data-ar="{{ e($columnHeading['ar']) }}">
                          {{ $columnHeading['text'] }}
                        </div>
                        @foreach (data_get($column, 'contacts', []) as $contact)
                        @php
                        $contactType = $contact['type'] ?? 'phone';
                        $contactValue = $contact['value'] ?? '';
                        $contactHref = $contactType === 'email' ? 'mailto:' . $contactValue : 'tel:' . $contactValue;
                        @endphp
                        <a href="{{ $contactHref }}" class="contact-info-link">
                          @if ($contactType === 'email')
                          <svg class="icon icon-sm" viewBox="0 0 24 24">
                            <rect width="20" height="16" x="2" y="4" rx="2" />
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                          </svg>
                          @else
                          <svg class="icon icon-sm" viewBox="0 0 24 24">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                          </svg>
                          @endif
                          {{ $contactValue }}
                        </a>
                        @endforeach
                      </div>
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
              @empty
              <p class="text-sm text-gray-500">{{ __('Support contacts will be shared soon.') }}</p>
              @endforelse
            </div>
          </div>
        </div> 
                 <!-- map -->
        <div class="location-card">
          <div class="location-header">
            <div class="contact-info-icon">
              <svg class="icon icon-sm" viewBox="0 0 24 24">
                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z" />
                <circle cx="12" cy="10" r="3" />
              </svg>
            </div>
            <div>
              <div class="location-title" data-en="{{ e($locationTitleBlock['en']) }}" data-ar="{{ e($locationTitleBlock['ar']) }}">{{ $locationTitleBlock['text'] }}</div>
              <p class="location-address" data-en="{{ e($locationAddressBlock['en']) }}" data-ar="{{ e($locationAddressBlock['ar']) }}">{{ $locationAddressBlock['text'] }}</p>
            </div>
          </div>
          @if ($locationImageUrl)
          <div class="location-image" style="margin-top:1rem;">
            <img src="{{ $locationImageUrl }}" alt="{{ $locationTitleBlock['text'] }}" style="width:100%; border-radius:1rem;">
          </div>
          @endif
          <div class="map-embed">
            <iframe
              src="{{ $mapEmbedUrl }}"
              allowfullscreen
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div> 
                  <!-- map was here -->
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="footer-inner">
        <div class="footer-text"> <span data-en="INTERNATIONAL E-COMMERCE EXPO | Terms & Conditions" data-ar="المعرض الدولي للتجارة اﻹلكترونية"> INTERNATIONAL E-COMMERCE EXPO | Terms & Conditions</span></div>
        <div class="footer-text" data-en="All rights reserved." data-ar="جميع الحقوق محفوظة© 2025.">2025© All rights reserved.</div>
      </div>
    </div>
  </footer>

  <!-- Toast Container -->
  <div class="toast-container" id="toast-container"></div>
  <button id="to-top-btn" class="to-top-button" type="button" aria-label="{{ __('Back to top') }}" onclick="scrollToTop()">
    <svg class="icon icon-sm" viewBox="0 0 24 24">
      <path d="M12 19V5M5 12l7-7 7 7" />
    </svg>
  </button>

  <script>
    // Locale Management
    let currentLocale = @json($locale);

    function toggleLocale() {
      currentLocale = currentLocale === 'en' ? 'ar' : 'en';
      document.documentElement.lang = currentLocale;
      document.documentElement.dir = currentLocale === 'ar' ? 'rtl' : 'ltr';
      document.getElementById('lang-text').textContent = currentLocale === 'en' ? 'العربية' : 'English';

      // Update all translatable elements
      document.querySelectorAll('[data-en][data-ar]').forEach(el => {
        el.textContent = el.getAttribute(`data-${currentLocale}`);
      });
    }

    // Mobile Menu
    function toggleMobileMenu() {
      const nav = document.getElementById('mobile-nav');
      nav.classList.toggle('active');
    }

    // Close mobile menu on link click
    document.querySelectorAll('.mobile-nav-link').forEach(link => {
      link.addEventListener('click', () => {
        document.getElementById('mobile-nav').classList.remove('active');
      });
    });

    function scrollToContact() {
      const contactSection = document.getElementById('contact');
      if (contactSection) {
        contactSection.scrollIntoView({
          behavior: 'smooth'
        });
      }
    }


    // Count Up Animation
    function animateCountUp(element, target, suffix) {
      const duration = 2000;
      const startTime = Date.now();

      function update() {
        const elapsed = Date.now() - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const easeOut = 1 - Math.pow(1 - progress, 4);
        const current = Math.floor(easeOut * target);

        element.textContent = current.toLocaleString() + suffix;

        if (progress < 1) {
          requestAnimationFrame(update);
        } else {
          element.textContent = target.toLocaleString() + suffix;
        }
      }

      requestAnimationFrame(update);
    }

    // Intersection Observer for Animations
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px 15% 0px'
    };

    const animationObserver = new IntersectionObserver((entries) => {
      entries.forEach((entry, index) => {
        if (entry.isIntersecting) {
          const delay = entry.target.dataset.delay || 0;
          setTimeout(() => {
            entry.target.classList.add('visible');

            // Handle count-up for highlight numbers
            const numberEl = entry.target.querySelector('.highlight-number');
            if (numberEl && !numberEl.dataset.animated) {
              const target = parseInt(numberEl.dataset.target);
              const suffix = numberEl.dataset.suffix || '';
              animateCountUp(numberEl, target, suffix);
              numberEl.dataset.animated = 'true';
            }
          }, delay);
          animationObserver.unobserve(entry.target);
        }
      });
    }, observerOptions);

    // Observe all animated elements
    document.querySelectorAll('[data-animate]').forEach((el, index) => {
      const stagger = (index % 4) * 80;
      el.dataset.delay = stagger;
      animationObserver.observe(el);
    });

    // About Section Video Reveal
    (function() {
      const aboutSection = document.querySelector('.about');
      if (!aboutSection) return;

      const videoContainer = aboutSection.querySelector('.about-video-container');
      if (!videoContainer) return;

      const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
      const activateVideo = () => aboutSection.classList.add('about-video-active');

      if (prefersReducedMotion.matches) {
        activateVideo();
        return;
      }

      const aboutVideoObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            activateVideo();
            aboutVideoObserver.unobserve(entry.target);
          }
        });
      }, {
        threshold: 0.35
      });

      aboutVideoObserver.observe(aboutSection);
    })();

    // Registration Role Selection
    let selectedRole = null;
    let exhibitorStep = 1;
    let iconStep = 1;

    function applyRoleOrder(role) {
      const visitorCard = document.getElementById('visitor-card');
      const visitorForm = document.getElementById('visitor-form');
      const exhibitorCard = document.getElementById('exhibitor-card');
      const exhibitorForm = document.getElementById('exhibitor-form');
      const iconCard = document.getElementById('icon-card');
      const iconForm = document.getElementById('icon-form');
      const guestLogo = document.getElementById('guest-row-logo');
      const sponsorLogo = document.getElementById('sponsor-row-logo');

      const setBaseOrder = () => {
        if (sponsorLogo) sponsorLogo.style.order = '0';
        exhibitorCard.style.order = '1';
        exhibitorForm.style.order = '2';
        iconCard.style.order = '3';
        iconForm.style.order = '4';
        if (guestLogo) guestLogo.style.order = '5';
        visitorCard.style.order = '6';
        visitorForm.style.order = '7';
      };

      setBaseOrder();
    }

    function toggleRoleVisibility(role) {
      const visitorElements = [document.getElementById('visitor-card'), document.getElementById('visitor-form')];
      const exhibitorElements = [document.getElementById('exhibitor-card'), document.getElementById('exhibitor-form')];
      const iconElements = [document.getElementById('icon-card'), document.getElementById('icon-form')];

      if (role === 'visitor') {
        visitorElements.forEach(el => el.style.display = '');
        exhibitorElements.forEach(el => el.style.display = 'none');
        iconElements.forEach(el => el.style.display = 'none');
      } else if (role === 'exhibitor') {
        exhibitorElements.forEach(el => el.style.display = '');
        visitorElements.forEach(el => el.style.display = 'none');
        iconElements.forEach(el => el.style.display = 'none');
      } else if (role === 'icon') {
        iconElements.forEach(el => el.style.display = '');
        visitorElements.forEach(el => el.style.display = 'none');
        exhibitorElements.forEach(el => el.style.display = 'none');
      } else {
        [...visitorElements, ...exhibitorElements, ...iconElements].forEach(el => el.style.display = '');
      }
    }

    toggleRoleVisibility(null);
    applyRoleOrder(null);

    function selectRole(role) {
      if (selectedRole === role) return;

      selectedRole = role;
      applyRoleOrder(role);
      toggleRoleVisibility(role);
      const roleCards = document.getElementById('role-cards');
      roleCards.classList.add('has-selection');
      roleCards.classList.toggle('guest-selected', role === 'visitor');

      const guestLogo = document.getElementById('guest-row-logo');
      if (guestLogo && role) {
        guestLogo.style.display = 'none';
      }

      const roles = [{
          key: 'visitor',
          card: 'visitor-card',
          form: 'visitor-form',
          cta: 'visitor-cta'
        },
        {
          key: 'exhibitor',
          card: 'exhibitor-card',
          form: 'exhibitor-form',
          cta: 'exhibitor-cta'
        },
        {
          key: 'icon',
          card: 'icon-card',
          form: 'icon-form',
          cta: 'icon-cta'
        },
      ];

      roles.forEach(({
        key,
        card,
        form,
        cta
      }) => {
        const isActive = role === key;
        document.getElementById(card).classList.toggle('selected', isActive);
        document.getElementById(card).classList.toggle('dimmed', !isActive);
        document.getElementById(cta).style.display = isActive ? 'none' : 'flex';
        document.getElementById(form).classList.toggle('active', isActive);
      });
    }

    function clearRole() {
      selectedRole = null;
      exhibitorStep = 1;
      iconStep = 1;

      const guestLogo = document.getElementById('guest-row-logo');
      if (guestLogo) {
        guestLogo.style.display = '';
      }

      const roleCards = document.getElementById('role-cards');
      roleCards.classList.remove('has-selection');
      roleCards.classList.remove('guest-selected');

      document.getElementById('visitor-card').classList.remove('selected', 'dimmed');
      document.getElementById('visitor-cta').style.display = 'flex';
      document.getElementById('visitor-form').classList.remove('active');

      document.getElementById('exhibitor-card').classList.remove('selected', 'dimmed');
      document.getElementById('exhibitor-cta').style.display = 'flex';
      document.getElementById('exhibitor-form').classList.remove('active');

      document.getElementById('icon-card').classList.remove('selected', 'dimmed');
      document.getElementById('icon-cta').style.display = 'flex';
      document.getElementById('icon-form').classList.remove('active');
      const stepInput = document.getElementById('exhibitor_step_input');
      if (stepInput) {
        stepInput.value = '1';
      }
      const iconStepInput = document.getElementById('icon_step_input');
      if (iconStepInput) {
        iconStepInput.value = '1';
      }
      toggleRoleVisibility(null);
      applyRoleOrder(null);
      updateExhibitorStep();
      updateIconStep();
    }

    function exhibitorNext() {
      setExhibitorStep(2);
    }

    function exhibitorBack() {
      if (exhibitorStep === 1) {
        clearRole();
      } else {
        setExhibitorStep(1);
      }
    }

    function iconNext() {
      setIconStep(2);
    }

    function iconBack() {
      if (iconStep === 1) {
        clearRole();
      } else {
        setIconStep(1);
      }
    }

    function setExhibitorStep(step) {
      exhibitorStep = step;
      const stepInput = document.getElementById('exhibitor_step_input');
      if (stepInput) {
        stepInput.value = String(step);
      }
      updateExhibitorStep();
    }

    function setIconStep(step) {
      iconStep = step;
      const stepInput = document.getElementById('icon_step_input');
      if (stepInput) {
        stepInput.value = String(step);
      }
      updateIconStep();
    }

    function updateExhibitorStep() {
      document.getElementById('exhibitor-step1').style.display = exhibitorStep === 1 ? 'block' : 'none';
      document.getElementById('exhibitor-step2').style.display = exhibitorStep === 2 ? 'block' : 'none';
      document.getElementById('exhibitor-next-btn').style.display = exhibitorStep === 1 ? 'inline-flex' : 'none';
      document.getElementById('exhibitor-submit-btn').style.display = exhibitorStep === 2 ? 'inline-flex' : 'none';

      document.getElementById('step1-indicator').classList.toggle('active', exhibitorStep >= 1);
      document.getElementById('step2-indicator').classList.toggle('active', exhibitorStep >= 2);
    }

    function updateIconStep() {
      document.getElementById('icon-step1').style.display = iconStep === 1 ? 'block' : 'none';
      document.getElementById('icon-step2').style.display = iconStep === 2 ? 'block' : 'none';
      document.getElementById('icon-next-btn').style.display = iconStep === 1 ? 'inline-flex' : 'none';
      document.getElementById('icon-submit-btn').style.display = iconStep === 2 ? 'inline-flex' : 'none';

      document.getElementById('icon-step1-indicator').classList.toggle('active', iconStep >= 1);
      document.getElementById('icon-step2-indicator').classList.toggle('active', iconStep >= 2);
    }

    function initHeardAboutSelects() {
      document.querySelectorAll('[data-heard-select]').forEach(select => {
        const handler = () => syncHeardSelect(select);
        select.addEventListener('change', handler);
        syncHeardSelect(select);
      });
    }

    function syncHeardSelect(select) {
      const targetSelector = select.getAttribute('data-other-target');
      if (!targetSelector) {
        return;
      }
      const scope = select.form || document;
      const target = scope.querySelector(targetSelector);
      if (!target) {
        return;
      }
      if (select.value === 'other') {
        target.style.display = '';
      } else {
        target.style.display = 'none';
        const input = target.querySelector('input, textarea');
        if (input && input.value) {
          input.value = '';
        }
      }
    }

    function resetHeardAboutSelectsWithin(form) {
      form.querySelectorAll('[data-heard-select]').forEach(select => syncHeardSelect(select));
    }

    let hallSelectionTargetId = null;
    
    // TODO: remove this after uploading
    function openHallDesign(targetInputId) {
      hallSelectionTargetId = targetInputId;
      const localeSuffix = currentLocale ? `?locale=${encodeURIComponent(currentLocale)}` : '';
      window.open((window.APP_BASE_PATH || '') + '/hall-design' + localeSuffix, '_blank');
    }
    // TODO: uncomment this after uploading
    // function openHallDesign(targetInputId) {
    //   hallSelectionTargetId = targetInputId;
    //   const localeSuffix = currentLocale ? `?locale=${encodeURIComponent(currentLocale)}` : '';
    //   window.open('/iec360/hall-design' + localeSuffix, '_blank');
    // }



    window.addEventListener('message', (event) => {
      if (event.origin !== window.location.origin) {
        return;
      }
      const data = event.data || {};
      if (data.type !== 'hall-selection' || !data.space) {
        return;
      }
      const targetId = hallSelectionTargetId || '';
      let input = targetId ? document.getElementById(targetId) : null;
      if (!input) {
        input = document.getElementById('icon-location-selection') ||
          document.querySelector('#icon-form input[name="location_selection"]') ||
          document.querySelector('input[name="location_selection"]');
      }
      if (input) {
        input.value = data.space;
        input.dispatchEvent(new Event('input', { bubbles: true }));
        const form = input.closest('form');
        if (form && form.id === 'sponsor-registration-form') {
          setExhibitorStep(1);
        }
        if (form && form.id === 'icon-registration-form') {
          selectRole('icon');
          setIconStep(1);
        }
        try {
          input.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } catch (e) {}
      }
      hallSelectionTargetId = null;
      try { window.focus(); } catch (e) {}
    });

    function applyHallSelectionFromQuery() {
      const params = new URLSearchParams(window.location.search || '');
      const space = params.get('hall_space');
      if (!space) {
        return;
      }

      const target = params.get('hall_target') || 'icon';
      let input = document.getElementById(target);
      if (!input && target === 'icon') {
        input = document.getElementById('icon-location-selection') ||
          document.querySelector('#icon-form input[name="location_selection"]');
      }

      if (input) {
        selectRole('icon');
        setIconStep(1);
        input.value = space;
        input.dispatchEvent(new Event('input', { bubbles: true }));
        try {
          input.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } catch (e) {}
      }

      params.delete('hall_space');
      params.delete('hall_target');
      const nextQuery = params.toString();
      const nextUrl = window.location.pathname + (nextQuery ? `?${nextQuery}` : '') + window.location.hash;
      try {
        window.history.replaceState({}, '', nextUrl);
      } catch (e) {}
    }

    function initAjaxRegistrationForms() {
      const visitorForm = document.getElementById('visitor-registration-form');
      if (visitorForm) {
        bindAjaxRegistrationForm(visitorForm, {
          onSuccess: (payload) => {
            visitorForm.reset();
            resetHeardAboutSelectsWithin(visitorForm);
            clearRole();
            const title = (payload && payload.toast_title) || visitorForm.dataset.successTitle;
            const message = (payload && payload.message) || visitorForm.dataset.successMessage;
            showToast(title, message);
          },
        });
      }

      const sponsorForm = document.getElementById('sponsor-registration-form');
      if (sponsorForm) {
        bindAjaxRegistrationForm(sponsorForm, {
          onSuccess: (payload) => {
            sponsorForm.reset();
            setExhibitorStep(1);
            clearRole();
            const title = (payload && payload.toast_title) || sponsorForm.dataset.successTitle;
            const message = (payload && payload.message) || sponsorForm.dataset.successMessage;
            showToast(title, message);
          },
        });
      }

      const iconForm = document.getElementById('icon-registration-form');
      if (iconForm) {
        if (iconForm.getAttribute('action') === '#') {
          iconForm.addEventListener('submit', (event) => event.preventDefault());
        } else {
          bindAjaxRegistrationForm(iconForm, {
            onSuccess: (payload) => {
              iconForm.reset();
              setIconStep(1);
              clearRole();
              const title = (payload && payload.toast_title) || iconForm.dataset.successTitle;
              const message = (payload && payload.message) || iconForm.dataset.successMessage;
              showToast(title, message);
            },
          });
        }
      }
    }

    function bindAjaxRegistrationForm(form, {
      onSuccess
    } = {}) {
      form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const submitter = event.submitter || form.querySelector('button[type="submit"]');
        toggleSubmitting(submitter, true);
        clearFormErrors(form);

        try {
          const response = await fetch(form.action, {
            method: 'POST',
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
              'Accept': 'application/json',
            },
            body: new FormData(form),
          });

          if (response.ok) {
            const data = await response.json().catch(() => ({}));
            if (typeof onSuccess === 'function') {
              onSuccess(data);
            }
            return;
          }

          if (response.status === 422) {
            const data = await response.json().catch(() => ({}));
            showFormErrors(form, data.errors || {});
            return;
          }

          const fallback = getRegistrationErrorMessages();
          showToast(fallback.errorTitle, fallback.errorMessage);
        } catch (error) {
          const fallback = getRegistrationErrorMessages();
          showToast(fallback.errorTitle, fallback.errorMessage);
        } finally {
          toggleSubmitting(submitter, false);
        }
      });
    }

    function toggleSubmitting(button, isSubmitting) {
      if (!button) {
        return;
      }
      if (isSubmitting) {
        button.disabled = true;
        button.setAttribute('aria-busy', 'true');
      } else {
        button.disabled = false;
        button.removeAttribute('aria-busy');
      }
    }

    function clearFormErrors(form) {
      form.querySelectorAll('.form-error-inline').forEach(error => error.remove());
      form.querySelectorAll('.form-control-error').forEach(field => field.classList.remove('form-control-error'));
      form.querySelectorAll('.form-group.has-error').forEach(group => group.classList.remove('has-error'));
    }

    function markFieldError(field, message) {
      if (!field) {
        return;
      }
      const group = field.closest('.form-group');
      field.classList.add('form-control-error');
      if (group) {
        group.classList.add('has-error');
      }
      const errorEl = document.createElement('p');
      errorEl.className = 'form-error form-error-inline';
      errorEl.textContent = message;
      if (group) {
        group.appendChild(errorEl);
      } else {
        field.insertAdjacentElement('afterend', errorEl);
      }
      const eventType = field.matches('select, textarea, input[type="file"]') ? 'change' : 'input';
      field.addEventListener(eventType, () => clearFieldError(field), {
        once: true
      });
    }

    function clearFieldError(field) {
      field.classList.remove('form-control-error');
      const group = field.closest('.form-group');
      if (group) {
        group.classList.remove('has-error');
        group.querySelectorAll('.form-error-inline').forEach(error => error.remove());
      }
    }

    function showFormErrors(form, errors) {
      const entries = Object.entries(errors || {});
      if (!entries.length) {
        const fallback = getRegistrationErrorMessages();
        showToast(fallback.errorTitle, fallback.errorMessage);
        return;
      }

      let hasFieldErrors = false;
      const generalMessages = [];

      entries.forEach(([fieldName, messages]) => {
        const message = Array.isArray(messages) ? messages[0] : messages;
        const selector = `[name="${escapeSelector(fieldName)}"]`;
        let field = form.querySelector(selector);

        if (!field) {
          // Try to match array-like inputs e.g., field[0]
          const normalized = fieldName.replace(/\./g, '\\.');
          field = form.querySelector(`[name="${escapeSelector(normalized)}"]`);
        }

        if (!field) {
          generalMessages.push(message);
          return;
        }

        hasFieldErrors = true;
        markFieldError(field, message);

        if (form.id === 'sponsor-registration-form') {
          ensureSponsorFieldVisible(field);
        }
        if (form.id === 'icon-registration-form') {
          ensureIconFieldVisible(field);
        }
      });

      if (generalMessages.length && !hasFieldErrors) {
        const fallback = getRegistrationErrorMessages();
        showToast(fallback.errorTitle, generalMessages[0]);
      }

    }

    function ensureSponsorFieldVisible(field) {
      const step1 = document.getElementById('exhibitor-step1');
      const step2 = document.getElementById('exhibitor-step2');
      if (step1 && step1.contains(field)) {
        setExhibitorStep(1);
      } else if (step2 && step2.contains(field)) {
        setExhibitorStep(2);
      }
    }

    function ensureIconFieldVisible(field) {
      const step1 = document.getElementById('icon-step1');
      const step2 = document.getElementById('icon-step2');
      if (step1 && step1.contains(field)) {
        setIconStep(1);
      } else if (step2 && step2.contains(field)) {
        setIconStep(2);
      }
    }

    function escapeSelector(value) {
      if (window.CSS && typeof window.CSS.escape === 'function') {
        return window.CSS.escape(value);
      }
      return String(value).replace(/([ #.;?+*~':"!^$[\]()=>|/@])/g, '\\$1');
    }

    function getRegistrationErrorMessages() {
      if (currentLocale === 'ar') {
        return {
          errorTitle: 'حدث خطأ',
          errorMessage: 'تعذر إرسال النموذج. حاول مرة أخرى.',
        };
      }

      return {
        errorTitle: 'Something went wrong',
        errorMessage: 'We could not submit the form. Please try again.',
      };
    }

    // Form Submissions
    function handleContactSubmit(event) {
      event.preventDefault();
      showToast(
        currentLocale === 'ar' ? 'تم إرسال الرسالة!' : 'Message Sent!',
        currentLocale === 'ar' ? 'سنتواصل معك قريباً.' : 'We will get back to you soon.'
      );
      event.target.reset();
    }

    const initialForm = @json($visitorShouldOpen ? 'visitor' : ($sponsorShouldOpen ? 'sponsor' : ($iconShouldOpen ? 'icon' : '')));
    const initialExhibitorStep = Number(@json($sponsorFormActive ? old('exhibitor_step', 1) : 1));
    const initialIconStep = Number(@json($iconFormActive ? old('icon_step', 1) : 1));

    document.addEventListener('DOMContentLoaded', () => {
      initHeardAboutSelects();
      initAjaxRegistrationForms();
      document.querySelectorAll('.sponsor-card-link, .participant-card').forEach(el => {
        el.addEventListener('click', (event) => {
          event.preventDefault();
          event.stopPropagation();
        });
      });

      if (initialForm === 'visitor') {
        selectRole('visitor');
      } else if (initialForm === 'sponsor') {
        selectRole('exhibitor');
        setExhibitorStep(initialExhibitorStep);
      } else if (initialForm === 'icon') {
        selectRole('icon');
        setIconStep(initialIconStep);
      }

      applyHallSelectionFromQuery();
    });

    // Toast Notification
    function showToast(title, description) {
      const container = document.getElementById('toast-container');
      const toast = document.createElement('div');
      toast.className = 'toast';
      toast.innerHTML = `
        <div class="toast-title">${title}</div>
        <div class="toast-desc">${description}</div>
      `;
      container.appendChild(toast);

      setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(1rem)';
        setTimeout(() => toast.remove(), 300);
      }, 3000);
    }

    const toTopBtn = document.getElementById('to-top-btn');
    if (toTopBtn) {
      window.addEventListener('scroll', () => {
        if (window.scrollY > 200) {
          toTopBtn.classList.add('show');
        } else {
          toTopBtn.classList.remove('show');
        }
      });
    }

    function scrollToTop() {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    }

    // Initialize AOS
    if (typeof AOS !== 'undefined') {
      AOS.init({
        duration: 1000,
        once: true,
        offset: 100
      });
    }

    // Animated Counter
    function animateCounters() {
      const counters = document.querySelectorAll('.stat-number');
      const speed = 800;

      counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-count') || '0', 10);
        const suffix = counter.getAttribute('data-suffix') || '';
        let current = 0;
        const increment = Math.max(Math.ceil(target / speed), 1);

        const animate = () => {
          current += increment;
          if (current >= target) {
            current = target;
            counter.innerText = `${current}${suffix}`;
            return;
          }
          counter.innerText = `${current}${suffix}`;
          requestAnimationFrame(animate);
        };

        animate();
      });
    }

    // Intersection Observer for animations
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          animateCounters();
          // Animate progress bars
          document.querySelectorAll('.progress-fill').forEach(bar => {
            bar.style.width = bar.getAttribute('data-width') || '85%';
          });
          observer.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.5
    });

    const statsSection = document.querySelector('.stats-section');
    if (statsSection) {
      observer.observe(statsSection);
    }
  </script>
</body>

</html>
