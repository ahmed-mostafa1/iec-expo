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
      --primary-color: #057a02;
      --secondary-color: #00ff44;
      --accent-color: #00ff88;
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
      --primary: 51 153 88;
      --primary-foreground: 251 251 248;
      --secondary: 226 233 226;
      --secondary-foreground: 69 84 69;
      --muted: 20 20 20;
      --muted-foreground: 248 248 248;
      --accent: 28 28 28;
      --accent-foreground: 248 248 248;
      --border: 68 68 68;
      --ring: 51 153 88;
      --radius: 0.75rem;
      --chart-1: 57 172 99;
      --chart-2: 70 185 147;
      --chart-3: 69 161 161;
      --button-bg: #9873AC;
      --button-hover-bg: #b5ffb5;
      --button-text: #ffffff;
      --hover-accent: #000000;
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
      gap: 2rem;
      justify-self: center;
    }

    @media (min-width: 768px) {
      .nav {
        display: flex;
      }
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
      color: #9873AC;
    }

    .nav-link::before {
      content: "";
      position: absolute;
      width: 0;
      height: 4px;
      bottom: 0;
      left: 50%;
      background-color: #9873AC;
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

    @media (prefers-reduced-motion: reduce) {
      .nav-link {
        animation: none;
        opacity: 1;
        transform: none;
      }
    }



    .nav-logo {
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
      display: block;
      padding: 0.5rem;
      background: none;
      border: none;
      cursor: pointer;
    }

    @media (min-width: 768px) {
      .mobile-menu-btn {
        display: none;
      }
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
      min-height: 100vh;
      display: flex;
      align-items: center;
      padding: 6rem 0 4rem;
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
      min-height: calc(100vh - 8rem);
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

    @media (min-width: 640px) {
      .hero-video-frame {
        aspect-ratio: 16 / 8.5;
      }
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

    @media (min-width: 1024px) {
      .highlights-grid {
        grid-template-columns: repeat(4, 1fr);
      }
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
      padding: 5rem 0;
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

    @media (min-width: 768px) {
      .section-title {
        font-size: 2.25rem;
      }
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

    @media (min-width: 768px) {
      .role-cards {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    .role-cards.has-selection {
      grid-template-columns: 1fr 1.5fr;
    }

    @media (max-width: 767px) {
      .role-cards.has-selection {
        grid-template-columns: 1fr;
      }
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

    .form-card {
      display: none;
      background: rgb(var(--card));
      border: 1px solid rgb(var(--border));
      border-radius: 1rem;
      padding: 1.5rem;
      animation: fadeSlideIn 0.5s ease-out;
    }

    @media (min-width: 768px) {
      .form-card {
        padding: 2rem;
      }
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

    @media (min-width: 768px) {
      .form-grid-2 {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
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

    @media (prefers-reduced-motion: reduce) {
      .about-video-container {
        transform: scaleX(1);
        transition: none;
      }
    }

    .about-grid {
      display: grid;
      gap: 3rem;
      align-items: start;
    }

    @media (min-width: 1024px) {
      .about-grid {
        grid-template-columns: 1fr 1fr;
      }
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
      color: #057a02;
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

    .organizer-grid {
      display: grid;
      gap: 1.5rem;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      max-width: 1000px;
      margin: 0 auto;
    }

    @media (max-width: 640px) {
      .organizer-grid {
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
    }

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
      box-shadow: #00ff4433 0px 0px 10px, #00ff44cc 0px 0px 20px, #00ff44aa 0px 0px 30px, #00ff4477 0px 0px 40px, #00ff4444 0px 0px 50px;
    }

    .sponsor-card .sponsor-logo {
      width: 100%;
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

    @media (min-width: 640px) {
      .participants-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (min-width: 1024px) {
      .participants-grid {
        grid-template-columns: repeat(3, 1fr);
      }
    }

    @media (min-width: 1280px) {
      .participants-grid {
        grid-template-columns: repeat(4, 1fr);
      }
    }

    .participant-card {
      background: rgb(var(--card));
      border: 1px solid rgb(var(--border));
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

    @media (min-width: 1024px) {
      .contact-grid {
        grid-template-columns: 1fr 1fr;
      }
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
      stroke: currentColor;
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
    @media (max-width: 600px) {
      .contact-info-card .contact-info-links.two-columns {
        grid-template-columns: 1fr;
      }
    }

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
          <a href="#register" class="btn-primary nav-link" data-en="Register" data-ar="سجل الآن">Register</a>
          <a href="#sponsors" class="nav-link" data-en="Sponsors" data-ar="الرعاة">Sponsors</a>
          <a href="#participants" class="nav-link" data-en="Exhibitors" data-ar="المشاركون">Exhibitors</a>
          <a href="#organizers" class="nav-link" data-en="Organizers" data-ar="المنظمون">Organizers</a>
          <a href="#about" class="nav-link" data-en="About" data-ar="عن المعرض">About</a>
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
          <img class="nav-logo" src="{{ asset('./img/bu_logo.png') }}" alt="IEC Logo" />

        </div>
      </div>

      <nav class="mobile-nav" id="mobile-nav">
        <a href="#" class="mobile-nav-link" data-en="Home" data-ar="الرئيسية">Home</a>
        <a href="#register" class="mobile-nav-link" data-en="Register" data-ar="سجل الآن">Register</a>
        <a href="#sponsors" class="mobile-nav-link" data-en="Sponsors" data-ar="الرعاة">Sponsors</a>
        <a href="#participants" class="mobile-nav-link" data-en="Exhibitors" data-ar="المشاركون">Exhibitors</a>
        <a href="#organizers" class="mobile-nav-link" data-en="Organizers" data-ar="المنظمون">Organizers</a>
        <a href="#about" class="mobile-nav-link" data-en="About" data-ar="عن المعرض">About</a>
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
      $visitorCardTitle = $translate(data_get($visitorCard, 'title'), '');
      $visitorCardDescription = $translate(data_get($visitorCard, 'description'), '');
      $visitorCta = $translate(data_get($visitorCard, 'cta_label'), __('Select'));
      $visitorForm = data_get($registrationSection, 'visitor_form', []);
      $visitorFormTitle = $translate(data_get($visitorForm, 'title'), '');
      $visitorSubmit = $translate(data_get($visitorForm, 'cta_submit'), __('Submit Registration'));
      $visitorContact = $translate(data_get($visitorForm, 'cta_contact'), __('Contact Us'));
      $visitorFields = data_get($visitorForm, 'fields', []);
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
    @endphp

    @php
      $visitorFormActive = old('form_identifier') === 'visitor';
      $sponsorFormActive = old('form_identifier') === 'sponsor';
      $visitorShouldOpen = $visitorFormActive || session()->has('visitor_success');
      $sponsorShouldOpen = $sponsorFormActive || session()->has('sponsor_success');
    @endphp

    <section class="registration" id="register">
      <div class="container">
        <div class="section-header" data-animate>
          <h2 class="section-title" data-en="{{ e($registrationTitle['en']) }}" data-ar="{{ e($registrationTitle['ar']) }}">{{ $registrationTitle['text'] }}</h2>
          <p class="section-desc" data-en="{{ e($registrationDescription['en']) }}" data-ar="{{ e($registrationDescription['ar']) }}">{{ $registrationDescription['text'] }}</p>
        </div>

        <div class="registration-content">
          <div class="role-cards" id="role-cards">
            <div class="role-card" id="visitor-card" onclick="selectRole('visitor')">
              <div class="role-icon">
                <svg class="icon icon-lg" viewBox="0 0 24 24">
                  <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                  <circle cx="12" cy="7" r="4" />
                </svg>
              </div>
              <h3 class="role-title" data-en="{{ e($visitorCardTitle['en']) }}" data-ar="{{ e($visitorCardTitle['ar']) }}">{{ $visitorCardTitle['text'] }}</h3>
              <p class="role-desc" data-en="{{ e($visitorCardDescription['en']) }}" data-ar="{{ e($visitorCardDescription['ar']) }}">{{ $visitorCardDescription['text'] }}</p>
              <div class="role-cta" id="visitor-cta">
                <span data-en="{{ e($visitorCta['en']) }}" data-ar="{{ e($visitorCta['ar']) }}">{{ $visitorCta['text'] }}</span>
                <svg class="icon icon-sm" viewBox="0 0 24 24">
                  <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
              </div>
            </div>
            <div class="form-card" id="visitor-form">
              @if(session('visitor_success'))
                <div class="mb-4 rounded-lg border border-emerald-100 bg-emerald-50 px-3 py-2 text-sm text-emerald-900">
                  {{ session('visitor_success') }}
                </div>
              @endif
              <h3 class="form-title" data-en="{{ e($visitorFormTitle['en']) }}" data-ar="{{ e($visitorFormTitle['ar']) }}">{{ $visitorFormTitle['text'] }}</h3>
              <form id="visitor-registration-form"
                method="POST"
                action="{{ route('public.register.visitor', ['locale' => $locale]) }}"
                novalidate
                data-success-title="{{ e(__('registration.visitor.toast_title')) }}"
                data-success-message="{{ e(__('registration.visitor.success')) }}">
                @csrf
                <input type="hidden" name="form_identifier" value="visitor">
                <div class="form-grid form-grid-2">
                  <div class="form-group">
                    <label class="form-label" data-en="Full Name *" data-ar="الاسم الكامل *">Full Name *</label>
                    <input type="text" name="full_name" class="form-input" required placeholder="John Doe"
                      value="{{ $visitorFormActive ? old('full_name') : '' }}">
                    @if($visitorFormActive && $errors->has('full_name'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('full_name') }}</p>
                    @endif
                  </div>
                  <div class="form-group">
                    <label class="form-label" data-en="Email *" data-ar="البريد الإلكتروني *">Email *</label>
                    <input type="email" name="email" class="form-input" required placeholder="john@example.com"
                      value="{{ $visitorFormActive ? old('email') : '' }}">
                    @if($visitorFormActive && $errors->has('email'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('email') }}</p>
                    @endif
                  </div>
                </div>

                <div class="form-grid form-grid-2" style="margin-top:1rem;">
                  <div class="form-group">
                    <label class="form-label" data-en="Phone" data-ar="الهاتف">Phone</label>
                    <input type="tel" name="phone" class="form-input" placeholder="+966 50 000 0000"
                      value="{{ $visitorFormActive ? old('phone') : '' }}">
                    @if($visitorFormActive && $errors->has('phone'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('phone') }}</p>
                    @endif
                  </div>
                  <div class="form-group">
                    <label class="form-label" data-en="Job Title" data-ar="المسمى الوظيفي">Job Title</label>
                    <input type="text" name="job_title" class="form-input" placeholder="Marketing Manager"
                      value="{{ $visitorFormActive ? old('job_title') : '' }}">
                    @if($visitorFormActive && $errors->has('job_title'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('job_title') }}</p>
                    @endif
                  </div>
                </div>

                <div class="form-grid form-grid-2" style="margin-top:1rem;">
                  <div class="form-group">
                    <label class="form-label" data-en="Company / Organization" data-ar="الشركة / الجهة">Company / Organization</label>
                    <input type="text" name="company_name" class="form-input" placeholder="Umbrella Inc."
                      value="{{ $visitorFormActive ? old('company_name') : '' }}">
                    @if($visitorFormActive && $errors->has('company_name'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('company_name') }}</p>
                    @endif
                  </div>
                  <div class="form-group">
                    <label class="form-label" data-en="How did you hear about us?" data-ar="كيف سمعت عنا؟">How did you hear about us?</label>
                    <select class="form-select" name="heard_about" data-heard-select data-other-target="#visitor-heard-other">
                      <option value="">{{ __('Select option') }}</option>
                      <option value="social_media" @selected($visitorFormActive && old('heard_about') === 'social_media')>Social Media</option>
                      <option value="ads" @selected($visitorFormActive && old('heard_about') === 'ads')>Advertising</option>
                      <option value="friends" @selected($visitorFormActive && old('heard_about') === 'friends')>Friends / Colleagues</option>
                      <option value="other" @selected($visitorFormActive && old('heard_about') === 'other')>Other</option>
                    </select>
                    @if($visitorFormActive && $errors->has('heard_about'))
                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('heard_about') }}</p>
                    @endif
                  </div>
                </div>

                <div class="form-group" id="visitor-heard-other" style="{{ $visitorFormActive && old('heard_about') === 'other' ? '' : 'display:none;' }}; margin-top:1rem;">
                  <label class="form-label" data-en="Please specify" data-ar="يرجى التحديد">Please specify</label>
                  <input type="text" name="heard_about_other_text" class="form-input" placeholder="Conference website"
                    value="{{ $visitorFormActive ? old('heard_about_other_text') : '' }}">
                  @if($visitorFormActive && $errors->has('heard_about_other_text'))
                    <p class="mt-1 text-xs text-red-600">{{ $errors->first('heard_about_other_text') }}</p>
                  @endif
                </div>

                <div class="form-buttons">
                  <button type="button" class="btn btn-outline" onclick="clearRole()">
                    <svg class="icon icon-sm" style="margin-right: 0.5rem;" viewBox="0 0 24 24">
                      <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                    <span data-en="Back" data-ar="رجوع">{{ __('Back') }}</span>
                  </button>
                  <button type="submit" class="btn btn-primary" data-en="{{ e($visitorSubmit['en']) }}" data-ar="{{ e($visitorSubmit['ar']) }}">{{ $visitorSubmit['text'] }}</button>
                  <button type="button" class="btn btn-outline" onclick="scrollToContact()" data-en="{{ e($visitorContact['en']) }}" data-ar="{{ e($visitorContact['ar']) }}">{{ $visitorContact['text'] }}</button>
                </div>
              </form>
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
                      <label class="form-label" data-en="Full Name *" data-ar="الاسم الكامل *">Full Name *</label>
                      <input type="text" name="full_name" class="form-input" required placeholder="John Doe"
                        value="{{ $sponsorFormActive ? old('full_name') : '' }}">
                      @if($sponsorFormActive && $errors->has('full_name'))
                        <p class="mt-1 text-xs text-red-600">{{ $errors->first('full_name') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label class="form-label" data-en="Email *" data-ar="البريد الإلكتروني *">Email *</label>
                      <input type="email" name="email" class="form-input" required placeholder="john@company.com"
                        value="{{ $sponsorFormActive ? old('email') : '' }}">
                      @if($sponsorFormActive && $errors->has('email'))
                        <p class="mt-1 text-xs text-red-600">{{ $errors->first('email') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-grid form-grid-2" style="margin-top: 1rem;">
                    <div class="form-group">
                      <label class="form-label" data-en="Phone *" data-ar="الهاتف *">Phone *</label>
                      <input type="tel" name="phone" class="form-input" required placeholder="+966 50 000 0000"
                        value="{{ $sponsorFormActive ? old('phone') : '' }}">
                      @if($sponsorFormActive && $errors->has('phone'))
                        <p class="mt-1 text-xs text-red-600">{{ $errors->first('phone') }}</p>
                      @endif
                    </div>
                    <div class="form-group">
                      <label class="form-label" data-en="Job Title *" data-ar="المسمى الوظيفي *">Job Title *</label>
                      <input type="text" name="job_title" class="form-input" required placeholder="Marketing Manager"
                        value="{{ $sponsorFormActive ? old('job_title') : '' }}">
                      @if($sponsorFormActive && $errors->has('job_title'))
                        <p class="mt-1 text-xs text-red-600">{{ $errors->first('job_title') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-grid form-grid-2" style="margin-top:1rem;">
                    <div class="form-group" style="grid-column: span 2;">
                      <label class="form-label" data-en="Company / Organization *" data-ar="الشركة / الجهة *">Company / Organization *</label>
                      <input type="text" name="organization" class="form-input" required placeholder="Umbrella Inc."
                        value="{{ $sponsorFormActive ? old('organization') : '' }}">
                      @if($sponsorFormActive && $errors->has('organization'))
                        <p class="mt-1 text-xs text-red-600">{{ $errors->first('organization') }}</p>
                      @endif
                    </div>
                  </div>
                  <div class="form-grid" style="margin-top: 1rem;">
                    <div class="form-group">
                      <label class="form-label" data-en="Corporate Profile" data-ar="الملف التعريفي للشركة">Corporate Profile</label>
                      <input type="file" name="corporate_profile" class="form-input" accept="application/pdf,image/png,image/jpeg">
                      <span class="form-hint" data-en="PDF, PNG, JPG files only accepted" data-ar="يمكن إرفاق ملفات PDF أو JPG أو PNG">PDF, PNG, JPG files only accepted</span>
                      @if($sponsorFormActive && $errors->has('corporate_profile'))
                        <p class="mt-1 text-xs text-red-600">{{ $errors->first('corporate_profile') }}</p>
                      @endif
                    </div>
                  </div>
                </div>

	                <div id="exhibitor-step2" style="display: none;">
	                  <div class="form-grid form-grid-2">
	                    <div class="form-group">
	                      <label class="form-label" data-en="VAT (Value Added Tax)" data-ar="ضريبة القيمة المضافة">VAT (Value Added Tax)</label>
	                      <input type="text" name="vat_number" class="form-input" placeholder="300000000000003"
	                        value="{{ $sponsorFormActive ? old('vat_number') : '' }}">
	                      @if($sponsorFormActive && $errors->has('vat_number'))
	                        <p class="mt-1 text-xs text-red-600">{{ $errors->first('vat_number') }}</p>
	                      @endif
	                    </div>
	                    <div class="form-group">
	                      <label class="form-label" data-en="CR Number" data-ar="رقم السجل التجاري">CR Number</label>
	                      <input type="text" name="cr_number" class="form-input" placeholder="1010101010"
	                        value="{{ $sponsorFormActive ? old('cr_number') : '' }}">
	                      @if($sponsorFormActive && $errors->has('cr_number'))
	                        <p class="mt-1 text-xs text-red-600">{{ $errors->first('cr_number') }}</p>
	                      @endif
	                    </div>
	                  </div>
	                  <div class="form-grid form-grid-2" style="margin-top: 1rem;">
	                    <div class="form-group">
	                      <label class="form-label" data-en="CR Copy (Commercial Registration)" data-ar="نسخة السجل التجاري">CR Copy (Commercial Registration)</label>
	                      <input type="file" name="cr_copy" class="form-input" accept="application/pdf,image/png,image/jpeg">
	                      @if($sponsorFormActive && $errors->has('cr_copy'))
	                        <p class="mt-1 text-xs text-red-600">{{ $errors->first('cr_copy') }}</p>
	                      @endif
	                    </div>
	                    <div class="form-group">
	                      <label class="form-label" data-en="Company Logo" data-ar="شعار الشركة">Company Logo</label>
	                      <input type="file" name="company_logo" class="form-input" accept="image/png,image/jpeg,image/webp">
	                      <span class="form-hint" data-en="PNG, JPG, WEBP files only accepted" data-ar="يمكن إرفاق ملفات PNG أو JPG أو WEBP">PNG, JPG, WEBP files only accepted</span>
	                      @if($sponsorFormActive && $errors->has('company_logo'))
	                        <p class="mt-1 text-xs text-red-600">{{ $errors->first('company_logo') }}</p>
	                      @endif
	                    </div>
	                  </div>
	                  <div class="form-group" style="margin-top: 1rem;">
	                    <label class="form-label" data-en="National Address" data-ar="العنوان الوطني">National Address</label>
	                    <textarea name="national_address" class="form-textarea" rows="3" placeholder="Complete company address">{{ $sponsorFormActive ? old('national_address') : '' }}</textarea>
	                    @if($sponsorFormActive && $errors->has('national_address'))
	                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('national_address') }}</p>
	                    @endif
	                  </div>
	                  <div class="form-group" style="margin-top: 1rem;">
	                    <label class="form-label" data-en="National Address Document" data-ar="مستند العنوان الوطني">National Address Document</label>
	                    <input type="file" name="national_address_document" class="form-input" accept="application/pdf,image/png,image/jpeg">
	                    @if($sponsorFormActive && $errors->has('national_address_document'))
	                      <p class="mt-1 text-xs text-red-600">{{ $errors->first('national_address_document') }}</p>
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
                  <button type="button" class="btn btn-outline" onclick="scrollToContact()" data-en="{{ e($visitorContact['en']) }}" data-ar="{{ e($visitorContact['ar']) }}">{{ $visitorContact['text'] }}</button>
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
                  <a href="" class="sponsor-card-link">
                    <div class="sponsor-logo">
                      <img src="{{ $logoPath }}" alt="">
                    </div>
                   
                  </a>
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
                <a href=""
                  class="sponsor-card-link">
                  <div class="sponsor-logo">
                    <img src="{{ $logoPath }}" alt="">
                  </div>
                 
                </a>
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
          <h2 class="section-title" data-en="Exhibitors" data-ar="المشاركون">Exhibitors</h2>
          <p class="section-desc" data-en="Meet the industry leaders who will be showcasing at the event." data-ar="تعرّف على قادة الصناعة الذين سيشاركون في الحدث.">Meet the industry leaders who will be showcasing at the event.</p>
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
          <a href="{{ $participantHref }}"
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
            <div class="participant-name" data-en="{{ e($englishName) }}" data-ar="{{ e($arabicName) }}">
              {{ $participantName }}
              @if($participant->url)
              <svg class="icon icon-sm external-icon" viewBox="0 0 24 24">
                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14 21 3" />
              </svg>
              @endif
            </div>
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
          <h2 class="section-title" data-en="Organizers" data-ar="المنظمون">Organizers</h2>
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
          <div class="organizer-grid">
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
              <article class="sponsor-card organizer-card" data-animate>
                <div class="sponsor-logo organizer-logo">
                  <img src="{{ $logoPath }}" alt="{{ $displayName }}">
                </div>
                <div class="sponsor-card-footer organizer-footer">
                  <span class="organizer-name" data-en="{{ e($englishName) }}" data-ar="{{ e($arabicName) }}">{{ $displayName }}</span>
                  <p class="organizer-desc" data-en="{{ e($descriptionEn) }}" data-ar="{{ e($descriptionAr) }}">{{ $description }}</p>
                  @if($organizer->url)
                    <a href="{{ $organizer->url }}" class="organizer-link" target="_blank" rel="noopener">
                      {{ $organizerVisitCopy[$currentLocale] }}
                    </a>
                  @endif
                </div>
              </article>
            @endforeach
          </div>
        @else
          <p class="text-center text-gray-500 text-sm">{{ __('Organizers will be announced soon.') }}</p>
        @endif
      </div>
    </section>

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
      $mapEmbedUrl = data_get($contactSection, 'map_embed', 'https://www.google.com/maps?q=Riyadh+International+Convention+%26+Exhibition+Center&output=embed');
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
                    <label class="form-label" data-en="Phone (Optional)" data-ar="الهاتف (اختياري)">{{ __('Phone (Optional)') }}</label>
                    <input type="tel" class="form-input" placeholder="+966 50 000 0000">
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

    function applyRoleOrder(role) {
      const visitorCard = document.getElementById('visitor-card');
      const visitorForm = document.getElementById('visitor-form');
      const exhibitorCard = document.getElementById('exhibitor-card');
      const exhibitorForm = document.getElementById('exhibitor-form');

      const resetOrder = () => {
        [visitorCard, visitorForm, exhibitorCard, exhibitorForm].forEach(el => {
          el.style.order = '';
        });
      };

      if (!role) {
        resetOrder();
        return;
      }

      if (role === 'visitor') {
        visitorCard.style.order = '1';
        visitorForm.style.order = '2';
        exhibitorCard.style.order = '3';
        exhibitorForm.style.order = '4';
      } else {
        exhibitorCard.style.order = '1';
        exhibitorForm.style.order = '2';
        visitorCard.style.order = '3';
        visitorForm.style.order = '4';
      }
    }

    function toggleRoleVisibility(role) {
      const visitorElements = [document.getElementById('visitor-card'), document.getElementById('visitor-form')];
      const exhibitorElements = [document.getElementById('exhibitor-card'), document.getElementById('exhibitor-form')];

      if (role === 'visitor') {
        visitorElements.forEach(el => el.style.display = '');
        exhibitorElements.forEach(el => el.style.display = 'none');
      } else if (role === 'exhibitor') {
        exhibitorElements.forEach(el => el.style.display = '');
        visitorElements.forEach(el => el.style.display = 'none');
      } else {
        [...visitorElements, ...exhibitorElements].forEach(el => el.style.display = '');
      }
    }

    toggleRoleVisibility(null);

    function selectRole(role) {
      if (selectedRole === role) return;

      selectedRole = role;
      applyRoleOrder(role);
      toggleRoleVisibility(role);
      const roleCards = document.getElementById('role-cards');
      roleCards.classList.add('has-selection');

      if (role === 'visitor') {
        document.getElementById('visitor-card').classList.add('selected');
        document.getElementById('visitor-card').classList.remove('dimmed');
        document.getElementById('visitor-cta').style.display = 'none';
        document.getElementById('visitor-form').classList.add('active');

        document.getElementById('exhibitor-card').classList.add('dimmed');
        document.getElementById('exhibitor-card').classList.remove('selected');
        document.getElementById('exhibitor-form').classList.remove('active');
      } else {
        document.getElementById('exhibitor-card').classList.add('selected');
        document.getElementById('exhibitor-card').classList.remove('dimmed');
        document.getElementById('exhibitor-cta').style.display = 'none';
        document.getElementById('exhibitor-form').classList.add('active');

        document.getElementById('visitor-card').classList.add('dimmed');
        document.getElementById('visitor-card').classList.remove('selected');
        document.getElementById('visitor-form').classList.remove('active');
      }
    }

    function clearRole() {
      selectedRole = null;
      exhibitorStep = 1;

      const roleCards = document.getElementById('role-cards');
      roleCards.classList.remove('has-selection');

      document.getElementById('visitor-card').classList.remove('selected', 'dimmed');
      document.getElementById('visitor-cta').style.display = 'flex';
      document.getElementById('visitor-form').classList.remove('active');

      document.getElementById('exhibitor-card').classList.remove('selected', 'dimmed');
      document.getElementById('exhibitor-cta').style.display = 'flex';
      document.getElementById('exhibitor-form').classList.remove('active');
      const stepInput = document.getElementById('exhibitor_step_input');
      if (stepInput) {
        stepInput.value = '1';
      }
      toggleRoleVisibility(null);
      applyRoleOrder(null);
      updateExhibitorStep();
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

    function setExhibitorStep(step) {
      exhibitorStep = step;
      const stepInput = document.getElementById('exhibitor_step_input');
      if (stepInput) {
        stepInput.value = String(step);
      }
      updateExhibitorStep();
    }

    function updateExhibitorStep() {
      document.getElementById('exhibitor-step1').style.display = exhibitorStep === 1 ? 'block' : 'none';
      document.getElementById('exhibitor-step2').style.display = exhibitorStep === 2 ? 'block' : 'none';
      document.getElementById('exhibitor-next-btn').style.display = exhibitorStep === 1 ? 'inline-flex' : 'none';
      document.getElementById('exhibitor-submit-btn').style.display = exhibitorStep === 2 ? 'inline-flex' : 'none';

      document.getElementById('step1-indicator').classList.toggle('active', exhibitorStep >= 1);
      document.getElementById('step2-indicator').classList.toggle('active', exhibitorStep >= 2);
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
    }

    function bindAjaxRegistrationForm(form, { onSuccess } = {}) {
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
      field.addEventListener(eventType, () => clearFieldError(field), { once: true });
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

    const initialForm = @json($visitorShouldOpen ? 'visitor' : ($sponsorShouldOpen ? 'sponsor' : ''));
    const initialExhibitorStep = Number(@json($sponsorFormActive ? old('exhibitor_step', 1) : 1));

    document.addEventListener('DOMContentLoaded', () => {
      initHeardAboutSelects();
      initAjaxRegistrationForms();

      if (initialForm === 'visitor') {
        selectRole('visitor');
      } else if (initialForm === 'sponsor') {
        selectRole('exhibitor');
        setExhibitorStep(initialExhibitorStep);
      }
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
