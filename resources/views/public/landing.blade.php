
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Conference 2025 | Premier Business Event</title>
  <meta name="description" content="Join industry leaders for the premier business conference. March 15-17, 2025 in Riyadh. Register now for networking, innovation, and growth." />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --background: 60 30% 96%;
      --foreground: 120 10% 20%;
      /* --card: 60 30% 98%; */
      --card: transparent;
      --card-foreground: 120 10% 20%;
      --primary: 142 50% 40%;
      --primary-foreground: 60 30% 98%;
      --secondary: 120 15% 90%;
      --secondary-foreground: 120 10% 30%;
      --muted: 60 15% 90%;
      --muted-foreground: 120 10% 45%;
      --accent: 142 30% 92%;
      --accent-foreground: 142 50% 30%;
      --border: 120 15% 85%;
      --ring: 142 50% 40%;
      --radius: 0.75rem;
      --chart-1: 142 50% 45%;
      --chart-2: 160 45% 50%;
      --chart-3: 180 40% 45%;
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
      0%, 100% { transform: translateY(0) scale(1); }
      50% { transform: translateY(-12px) scale(1.01); }
    }

    @keyframes softPulse {
      0%, 100% { box-shadow: 0 20px 40px rgba(0,0,0,0.08); }
      50% { box-shadow: 0 30px 60px rgba(0,0,0,0.12); }
    }

    body {
      font-family: 'Work Sans', sans-serif;
      background-color: hsl(var(--background));
      color: hsl(var(--foreground));
      line-height: 1.6;
    }

    html {
      scroll-behavior: smooth;
    }

    .container {
      max-width: 1280px;
      margin: 0 auto;
      padding: 0 1rem;
    }

    /* Header */
    .header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 50;
      background: hsla(var(--card) / 0.8);
      backdrop-filter: blur(12px);
      border-bottom: 1px solid hsl(var(--border));
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
      color: hsl(var(--primary));
      text-decoration: none;
    }

    .nav {
      display: none;
      align-items: center;
      gap: 2rem;
      justify-self: center;
    }

    @media (min-width: 768px) {
      .nav { display: flex; }
    }

    .nav-link {
      color: hsl(var(--foreground) / 0.8);
      text-decoration: none;
      font-weight: 500;
      transition: color 0.2s;
    }

    .nav-link:hover {
      color: hsl(var(--primary));
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
      color: hsl(var(--foreground) / 0.8);
      background: none;
      border: none;
      cursor: pointer;
      transition: color 0.2s;
    }

    .lang-switch:hover {
      color: hsl(var(--primary));
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
    }

    .btn-primary {
      background: hsl(var(--primary));
      color: hsl(var(--primary-foreground));
    }

    .btn-primary:hover {
      background: hsl(142 50% 35%);
    }

    .btn-outline {
      background: transparent;
      color: hsl(var(--foreground));
      border: 1px solid hsl(var(--border));
    }

    .btn-outline:hover {
      background: hsl(var(--accent));
      border-color: hsl(var(--primary) / 0.3);
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
      .mobile-menu-btn { display: none; }
    }

    .mobile-nav {
      display: none;
      padding: 1rem 0;
      border-top: 1px solid hsl(var(--border));
    }

    .mobile-nav.active {
      display: block;
    }

    .mobile-nav-link {
      display: block;
      padding: 0.75rem 0;
      color: hsl(var(--foreground) / 0.8);
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
      background: linear-gradient(135deg, hsl(var(--accent)), hsl(var(--background)), hsl(var(--background)));
    }

    .hero::after {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(ellipse at top right, hsl(var(--primary) / 0.1), transparent 50%);
    }

    .hero-grid {
      position: relative;
      z-index: 10;
      display: grid;
      place-items: center;
      gap: 2rem;
      min-height: calc(100vh - 8rem);
    }

    .hero-media {
      width: 100%;
      max-width: 960px;
    }

    .hero-video-frame {
      position: relative;
      border-radius: 1.5rem;
      overflow: hidden;
      box-shadow: 0 25px 50px -12px rgba(0,0,0,0.35);
      aspect-ratio: 16 / 9;
      background: #000;
      animation: heroFloat 12s ease-in-out infinite;
    }

    @media (min-width: 640px) {
      .hero-video-frame { aspect-ratio: 16 / 8.5; }
    }

    .hero-video-frame::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(0,0,0,0.4), rgba(0,0,0,0.05));
      pointer-events: none;
    }

    .hero-video {
      width: 100%;
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
      text-shadow: 0 4px 12px rgba(0,0,0,0.45);
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
    .scroll-indicator {
      position: absolute;
      bottom: 2rem;
      left: 50%;
      transform: translateX(-50%);
      animation: bounce 1s infinite;
      z-index: 30;
      text-decoration: none;
      color: hsl(var(--muted-foreground));
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 44px;
      height: 44px;
      border-radius: 999px;
      border: 1px solid hsl(var(--border));
      background: hsla(var(--card) / 0.6);
      backdrop-filter: blur(6px);
    }

    .scroll-indicator:hover {
      color: hsl(var(--primary));
      border-color: hsl(var(--primary) / 0.4);
    }

    @keyframes bounce {
      0%, 100% { transform: translateX(-50%) translateY(0); }
      50% { transform: translateX(-50%) translateY(-10px); }
    }

    /* Highlights Section */
    .highlights {
      padding: 4rem 0;
      background: hsl(var(--background));
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
      background: hsl(var(--card));
      border: 1px solid hsl(var(--border));
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
      box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
      transform: translateY(0) scale(1.05);
      border-color: hsl(var(--primary) / 0.3);
    }

    .highlight-icon {
      width: 64px;
      height: 64px;
      margin: 0 auto 1rem;
      border-radius: 50%;
      background: hsl(var(--primary) / 0.1);
      color: hsl(var(--primary));
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s;
    }

    .highlight-card:hover .highlight-icon {
      background: hsl(var(--primary));
      color: hsl(var(--primary-foreground));
    }

    .highlight-number {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
    }

    .highlight-label {
      color: hsl(var(--muted-foreground));
      font-weight: 500;
    }

    /* Registration Section */
    .registration {
      padding: 5rem 0;
      background: hsl(var(--accent) / 0.3);
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
      .section-title { font-size: 2.25rem; }
    }

    .section-desc {
      font-size: 1.125rem;
      color: hsl(var(--muted-foreground));
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
      background: hsl(var(--card));
      border: 2px solid hsl(var(--border));
      border-radius: 1rem;
      padding: 2rem;
      text-align: center;
      cursor: pointer;
      transition: all 0.5s;
      overflow: hidden;
    }

    .role-card:hover {
      border-color: hsl(var(--primary));
      box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
      animation: softPulse 1.8s ease-in-out infinite;
    }

    .role-card.selected {
      border-color: hsl(var(--primary));
      box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
    }

    .role-card.dimmed {
      opacity: 0.6;
    }

    .role-icon {
      width: 80px;
      height: 80px;
      margin: 0 auto 1.5rem;
      border-radius: 1rem;
      background: hsl(var(--primary) / 0.1);
      color: hsl(var(--primary));
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s;
    }

    .role-card:hover .role-icon {
      background: hsl(var(--primary));
      color: hsl(var(--primary-foreground));
    }

    .role-title {
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 0.75rem;
    }

    .role-desc {
      color: hsl(var(--muted-foreground));
    }

    .role-cta {
      margin-top: 1.5rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      color: hsl(var(--primary));
      font-weight: 500;
    }

    .form-card {
      display: none;
      background: hsl(var(--card));
      border: 1px solid hsl(var(--border));
      border-radius: 1rem;
      padding: 1.5rem;
      animation: fadeSlideIn 0.5s ease-out;
    }

    @media (min-width: 768px) {
      .form-card { padding: 2rem; }
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
      border: 1px solid hsl(var(--border));
      border-radius: var(--radius);
      font-size: 0.875rem;
      background: hsl(var(--background));
      color: hsl(var(--foreground));
      transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
      outline: none;
      border-color: hsl(var(--primary));
      box-shadow: 0 0 0 3px hsl(var(--primary) / 0.1);
    }

    .form-textarea {
      resize: vertical;
      min-height: 80px;
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
      background: hsl(var(--muted));
      color: hsl(var(--muted-foreground));
    }

    .step.active {
      background: hsl(var(--primary));
      color: hsl(var(--primary-foreground));
    }

    .step-divider {
      width: 2rem;
      height: 1px;
      background: hsl(var(--border));
    }

    .other-role {
      margin-top: 1.5rem;
    }

    /* About Section */
    .about {
      padding: 5rem 0;
      background: hsl(var(--background));
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
      background: hsl(var(--primary) / 0.1);
      color: hsl(var(--primary));
    }

    .about-title {
      font-size: 1.875rem;
      font-weight: 700;
    }

    .about-card {
      background: hsl(var(--card));
      border: 1px solid hsl(var(--border));
      border-radius: 1rem;
      padding: 2rem;
    }

    .about-text {
      font-size: 1.125rem;
      color: hsl(var(--muted-foreground));
      line-height: 1.7;
    }

    .about-text + .about-text {
      margin-top: 1rem;
    }

    .goals-list {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .goal-card {
      background: hsl(var(--card));
      border: 1px solid hsl(var(--border));
      border-radius: var(--radius);
      padding: 1.5rem;
      display: flex;
      gap: 1rem;
      transition: all 0.5s;
      opacity: 0;
      transform: translateY(1rem);
    }

    .goal-card.visible {
      opacity: 1;
      transform: translateY(0);
    }

    .goal-card:hover {
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      border-color: hsl(var(--primary) / 0.3);
    }

    .goal-icon {
      flex-shrink: 0;
      padding: 0.75rem;
      border-radius: 0.5rem;
      background: hsl(var(--primary) / 0.1);
      color: hsl(var(--primary));
      transition: all 0.3s;
    }

    .goal-card:hover .goal-icon {
      background: hsl(var(--primary));
      color: hsl(var(--primary-foreground));
    }

    .goal-title {
      font-size: 1.125rem;
      font-weight: 600;
      margin-bottom: 0.25rem;
    }

    .goal-desc {
      color: hsl(var(--muted-foreground));
    }

    /* Sponsors Section */
    .sponsors {
      padding: 5rem 0;
      background: hsl(var(--accent) / 0.2);
    }

    .sponsor-tiers {
      display: flex;
      flex-direction: column;
      gap: 2.5rem;
    }

    .sponsor-tier-title {
      text-align: center;
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 1rem;
    }

    .sponsor-tier-grid {
      display: grid;
      gap: 1.5rem;
      justify-content: center;
      justify-items: center;
      max-width: 1000px;
      margin: 0 auto;
    }

    .sponsor-tier-grid.tier-main {
      grid-template-columns: repeat(auto-fit, minmax(220px, 260px));
    }

    .sponsor-tier-grid.tier-gold {
      grid-template-columns: repeat(auto-fit, minmax(200px, 220px));
    }

    .sponsor-tier-grid.tier-silver {
      grid-template-columns: repeat(auto-fit, minmax(180px, 200px));
    }

    .sponsor-card {
      background: transparent;
      border: 1px solid hsla(var(--border) / 0.6);
      border-radius: var(--radius);
      padding: 1.25rem;
      transition: all 0.5s;
      opacity: 0;
      transform: translateY(2rem);
      display: flex;
      flex-direction: column;
      gap: 1rem;
      min-height: 260px;
      will-change: transform;
    }

    .sponsor-card.visible {
      opacity: 1;
      transform: translateY(0);
    }

    .sponsor-card:hover {
      box-shadow: 0 15px 35px -10px rgba(0,0,0,0.25);
      transform: translateY(0) scale(1.02);
      animation: softPulse 2.2s ease-in-out infinite;
      background: hsla(var(--card) / 0.4);
    }

    .sponsor-card .sponsor-logo {
      width: 100%;
      aspect-ratio: 1 / 1;
      border-radius: 1rem;
      overflow: hidden;
      background: hsl(var(--muted));
      box-shadow: inset 0 0 0 1px hsla(var(--border) / 1);
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

    .sponsor-card.main:hover { border-color: hsl(35 90% 50% / 0.6); }
    .sponsor-card.gold:hover { border-color: hsl(45 95% 50% / 0.6); }
    .sponsor-card.silver:hover { border-color: hsl(220 10% 60% / 0.6); }

    .sponsor-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      padding: 0.4rem 1rem;
      border-radius: 9999px;
      font-size: 0.8rem;
      font-weight: 500;
      color:hsl(142 50% 35%);
      text-decoration: none;
      border: 1px solid hsla(var(--border) / 0.6);
      box-shadow: inset 0 0 0 1px hsla(0,0%,100%,0.15);
      position: relative;
      overflow: hidden;
    }

    .sponsor-badge::after {
      content: '';
      position: absolute;
      inset: 0;
      border-radius: inherit;
      box-shadow: 0 6px 12px rgba(0,0,0,0.08);
      z-index: -1;
    }

    .sponsor-badge.main {
      background: linear-gradient(120deg, rgba(255, 186, 90, 0.35), rgba(255, 153, 0, 0.2));
      color: hsl(35 90% 35%);
    }

    .sponsor-badge.gold {
      background: linear-gradient(120deg, rgba(252, 211, 77, 0.35), rgba(234, 179, 8, 0.2));
      color: hsl(45 85% 32%);
    }

    .sponsor-badge.silver {
      background: linear-gradient(120deg, rgba(226, 232, 240, 0.4), rgba(148, 163, 184, 0.25));
      color: hsl(220 10% 40%);
    }
    .sponsor-badge span{
      font-size: 0.75rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      text-decoration: none;
    }

    /* Participants Section */
    .participants {
      padding: 5rem 0;
      background: hsl(var(--background));
    }

    .participants-grid {
      display: grid;
      gap: 1.5rem;
      grid-template-columns: 1fr;
    }

    @media (min-width: 640px) {
      .participants-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (min-width: 1024px) {
      .participants-grid { grid-template-columns: repeat(3, 1fr); }
    }

    .participant-card {
      background: hsl(var(--card));
      border: 1px solid hsl(var(--border));
      border-radius: var(--radius);
      padding: 0.5rem;
      transition: all 0.5s;
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
    }

    .participant-card.visible {
      opacity: 1;
      transform: translateY(0);
    }

    .participant-card:hover {
      box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
      border-color: hsl(var(--primary) / 0.3);
    }

    .participant-logo {
      width: 64px;
      height: 64px;
      border-radius: var(--radius);
      background: hsl(var(--primary) / 0.1);
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
    }

    .participant-card:hover .participant-logo {
      background: hsl(var(--primary) / 0.2);
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

    .participant-desc {
      font-size: 0.875rem;
      color: hsl(var(--muted-foreground));
    }

    /* Contact Section */
    .contact {
      padding: 5rem 0;
      background: hsl(var(--accent) / 0.2);
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
      background: hsl(var(--card));
      border: 1px solid hsl(var(--border));
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
      background: hsl(var(--card));
      border: 1px solid hsl(var(--border));
      border-radius: var(--radius);
      padding: 1.5rem;
      transition: box-shadow 0.3s;
    }

    .contact-info-card:hover {
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .contact-info-card.primary {
      border-color: hsl(var(--primary) / 0.3);
      background: hsl(var(--primary) / 0.05);
    }

    .contact-info-header {
      display: flex;
      align-items: start;
      gap: 1rem;
    }

    .contact-info-icon {
      padding: 0.5rem;
      border-radius: 0.5rem;
      background: hsl(var(--primary) / 0.1);
      color: hsl(var(--primary));
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
      background: hsl(var(--primary));
      color: hsl(var(--primary-foreground));
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
      color: hsl(var(--muted-foreground));
      text-decoration: none;
      transition: color 0.2s;
    }

    .contact-info-link:hover {
      color: hsl(var(--primary));
    }

    .location-card {
      margin-top: 2rem;
      background: hsl(var(--card));
      border: 1px solid hsl(var(--border));
      border-radius: var(--radius);
      padding: 1.5rem;
      width: 100%;
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
      color: hsl(var(--muted-foreground));
    }

    .map-embed {
      margin-top: 1rem;
      border-radius: var(--radius);
      overflow: hidden;
      border: 1px solid hsl(var(--border));
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
      background: hsl(var(--primary));
      color: hsl(var(--primary-foreground));
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
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-3px); }
    }

    /* Footer */
    .footer {
      padding: 2rem 0;
      border-top: 1px solid hsl(var(--border));
      background: hsl(var(--card));
    }

    .footer-inner {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 1rem;
    }

    @media (min-width: 768px) {
      .footer-inner {
        flex-direction: row;
        justify-content: space-between;
      }
    }

    .footer-text {
      font-size: 0.875rem;
      color: hsl(var(--muted-foreground));
    }

    /* RTL Support */
    [dir="rtl"] {
      font-family: 'Noto Sans Arabic', 'Work Sans', sans-serif;
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
      background: hsl(var(--card));
      border: 1px solid hsl(var(--border));
      border-radius: var(--radius);
      padding: 1rem 1.5rem;
      box-shadow: 0 10px 25px -5px rgba(0,0,0,0.15);
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
      color: hsl(var(--muted-foreground));
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

    $sponsorTiers = [
        'main'   => __('Main Sponsors'),
        'gold'   => __('Gold Sponsors'),
        'silver' => __('Silver Sponsors'),
    ];

    $groupedSponsors = $publicSponsors->groupBy(function ($sponsor) {
        return strtolower($sponsor->tier ?? 'other');
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
@endphp
  <!-- Header -->
  <header class="header">
    <div class="container">
      <div class="header-inner">
        <a href="#hero" class="logo" data-en="Conference 2025" data-ar="مؤتمر 2025">Conference 2025</a>
        
        <nav class="nav">
          <a href="#about" class="nav-link" data-en="About" data-ar="عن المعرض">About</a>
          <a href="#sponsors" class="nav-link" data-en="Sponsors" data-ar="الرعاة">Sponsors</a>
          <a href="#participants" class="nav-link" data-en="Participants" data-ar="المشاركون">Participants</a>
          <a href="#contact" class="nav-link" data-en="Contact" data-ar="تواصل معنا">Contact</a>
        </nav>

        <div class="header-right">
          <a href="#hero" class="logo logo-secondary" data-en="IEC Expo" data-ar="معرض IEC">IEC Expo</a>
          <div class="header-actions">
            <button class="lang-switch" onclick="toggleLocale()">
              <svg class="icon icon-sm" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
              <span id="lang-text">العربية</span>
            </button>
            <a href="#register" class="btn btn-primary" style="display: none;" data-en="Register" data-ar="سجل الآن">Register</a>
            <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
              <svg class="icon" viewBox="0 0 24 24" id="menu-icon"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
            </button>
          </div>
        </div>
      </div>
      
      <nav class="mobile-nav" id="mobile-nav">
        <a href="#about" class="mobile-nav-link" data-en="About" data-ar="عن المعرض">About</a>
        <a href="#sponsors" class="mobile-nav-link" data-en="Sponsors" data-ar="الرعاة">Sponsors</a>
        <a href="#participants" class="mobile-nav-link" data-en="Participants" data-ar="المشاركون">Participants</a>
        <a href="#contact" class="mobile-nav-link" data-en="Contact" data-ar="تواصل معنا">Contact</a>
        <a href="#register" class="btn btn-primary" style="width: 100%; margin-top: 1rem;" data-en="Register" data-ar="سجل الآن">Register</a>
      </nav>
    </div>
  </header>

  <main>
    <!-- Hero Section -->
    <section class="hero" id="hero">
      <div class="container">
        <div class="hero-grid">
          <div class="hero-media">
            <div class="hero-video-frame">
              <video class="hero-video" autoplay muted loop playsinline poster="https://images.pexels.com/photos/1181406/pexels-photo-1181406.jpeg?auto=compress&cs=tinysrgb&w=1600">
                <source src="https://cdn.coverr.co/videos/coverr-business-people-shaking-hands-8725/1080p.mp4" type="video/mp4">
                Your browser does not support the video tag.
              </video>
              <div class="hero-video-caption">
                <span data-en="Experience" data-ar="تجربة غامرة">Experience</span>
                <strong data-en="Innovation In Motion" data-ar="الابتكار في حركة">Innovation In Motion</strong>
              </div>
            </div>
          </div>
        </div>
      </div>
      <a href="#highlights" class="scroll-indicator" aria-label="{{ __('Scroll to highlights') }}">
        <svg class="icon" viewBox="0 0 24 24"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
      </a>
    </section>

    <!-- Highlights Section -->
    <section class="highlights" id="highlights">
      <div class="container">
        <div class="highlights-grid">
          <div class="highlight-card" data-animate>
            <div class="highlight-icon">
              <svg class="icon icon-lg" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div class="highlight-number" data-target="5000" data-suffix="+">0</div>
            <div class="highlight-label" data-en="Expected Visitors" data-ar="زائر متوقع">Expected Visitors</div>
          </div>
          <div class="highlight-card" data-animate>
            <div class="highlight-icon">
              <svg class="icon icon-lg" viewBox="0 0 24 24"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg>
            </div>
            <div class="highlight-number" data-target="150" data-suffix="+">0</div>
            <div class="highlight-label" data-en="Exhibitors" data-ar="عارض">Exhibitors</div>
          </div>
          <div class="highlight-card" data-animate>
            <div class="highlight-icon">
              <svg class="icon icon-lg" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
            </div>
            <div class="highlight-number" data-target="30" data-suffix="">0</div>
            <div class="highlight-label" data-en="Countries" data-ar="دولة">Countries</div>
          </div>
          <div class="highlight-card" data-animate>
            <div class="highlight-icon">
              <svg class="icon icon-lg" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div class="highlight-number" data-target="3" data-suffix="">0</div>
            <div class="highlight-label" data-en="Days of Innovation" data-ar="أيام من الابتكار">Days of Innovation</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Registration Section -->
    <section class="registration" id="register">
      <div class="container">
        <div class="section-header" data-animate>
          <h2 class="section-title" data-en="Registration" data-ar="التسجيل">Registration</h2>
          <p class="section-desc" data-en="Choose your role to begin the registration process. Visitors and exhibitors have different registration flows." data-ar="اختر دورك لبدء عملية التسجيل. الزوار والعارضون لديهم مسارات تسجيل مختلفة.">Choose your role to begin the registration process. Visitors and exhibitors have different registration flows.</p>
        </div>

        <div class="registration-content">
          <div class="role-cards" id="role-cards">
            <div class="role-card" id="visitor-card" onclick="selectRole('visitor')">
              <div class="role-icon">
                <svg class="icon icon-lg" viewBox="0 0 24 24"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
              </div>
              <h3 class="role-title" data-en="Visitor / Client" data-ar="زائر / عميل">Visitor / Client</h3>
              <p class="role-desc" data-en="Attend the conference and explore opportunities" data-ar="احضر المؤتمر واستكشف الفرص">Attend the conference and explore opportunities</p>
              <div class="role-cta" id="visitor-cta">
                <span data-en="Select" data-ar="اختر">Select</span>
                <svg class="icon icon-sm" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
              </div>
            </div>

            <div class="form-card" id="visitor-form">
              <h3 class="form-title" data-en="Visitor Registration" data-ar="تسجيل الزائر">Visitor Registration</h3>
              <form onsubmit="handleSubmit(event, 'visitor')">
                <div class="form-grid form-grid-2">
                  <div class="form-group">
                    <label class="form-label" data-en="Full Name *" data-ar="الاسم الكامل *">Full Name *</label>
                    <input type="text" class="form-input" required placeholder="John Doe">
                  </div>
                  <div class="form-group">
                    <label class="form-label" data-en="Email *" data-ar="البريد الإلكتروني *">Email *</label>
                    <input type="email" class="form-input" required placeholder="john@example.com">
                  </div>
                </div>
                <div class="form-grid form-grid-2" style="margin-top: 1rem;">
                  <div class="form-group">
                    <label class="form-label" data-en="Phone *" data-ar="الهاتف *">Phone *</label>
                    <input type="tel" class="form-input" required placeholder="+966 50 000 0000">
                  </div>
                  <div class="form-group">
                    <label class="form-label" data-en="Company" data-ar="الشركة">Company</label>
                    <select class="form-select">
                      <option value="">Select company</option>
                      <option value="company1">Company A</option>
                      <option value="company2">Company B</option>
                      <option value="other">Other</option>
                    </select>
                  </div>
                </div>
                <div class="form-grid" style="margin-top: 1rem;">
                  <div class="form-group">
                    <label class="form-label" data-en="How did you hear about us?" data-ar="كيف سمعت عنا؟">How did you hear about us?</label>
                    <select class="form-select">
                      <option value="">Select option</option>
                      <option value="social">Social Media</option>
                      <option value="ads">Advertising</option>
                      <option value="friends">Friends/Colleagues</option>
                      <option value="other">Other</option>
                    </select>
                  </div>
                </div>
                <div class="form-grid" style="margin-top: 1rem;">
                  <div class="form-group">
                    <label class="form-label" data-en="Areas of Interest" data-ar="مجالات الاهتمام">Areas of Interest</label>
                    <textarea class="form-textarea" placeholder="Tell us what interests you..."></textarea>
                  </div>
                </div>
                <div class="form-buttons">
                  <button type="button" class="btn btn-outline" onclick="clearRole()">
                    <svg class="icon icon-sm" style="margin-right: 0.5rem;" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                    <span data-en="Back" data-ar="رجوع">Back</span>
                  </button>
                  <button type="submit" class="btn btn-primary" data-en="Submit Registration" data-ar="إرسال التسجيل">Submit Registration</button>
                </div>
              </form>
            </div>

            <div class="role-card" id="exhibitor-card" onclick="selectRole('exhibitor')">
              <div class="role-icon">
                <svg class="icon icon-lg" viewBox="0 0 24 24"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/></svg>
              </div>
              <h3 class="role-title" data-en="Exhibitor / Sponsor" data-ar="عارض / راعي">Exhibitor / Sponsor</h3>
              <p class="role-desc" data-en="Showcase your products and connect with attendees" data-ar="اعرض منتجاتك وتواصل مع الحضور">Showcase your products and connect with attendees</p>
              <div class="role-cta" id="exhibitor-cta">
                <span data-en="Select" data-ar="اختر">Select</span>
                <svg class="icon icon-sm" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
              </div>
            </div>

            <div class="form-card" id="exhibitor-form">
              <h3 class="form-title" data-en="Exhibitor Application" data-ar="طلب العرض">Exhibitor Application</h3>
              <div class="step-indicator">
                <div class="step active" id="step1-indicator">
                  <span>1</span>
                  <span data-en="Contact" data-ar="التواصل">Contact</span>
                </div>
                <div class="step-divider"></div>
                <div class="step" id="step2-indicator">
                  <span>2</span>
                  <span data-en="Company" data-ar="الشركة">Company</span>
                </div>
              </div>

              <form onsubmit="handleSubmit(event, 'exhibitor')">
                <div id="exhibitor-step1">
                  <div class="form-grid form-grid-2">
                    <div class="form-group">
                      <label class="form-label" data-en="Full Name *" data-ar="الاسم الكامل *">Full Name *</label>
                      <input type="text" class="form-input" required placeholder="John Doe">
                    </div>
                    <div class="form-group">
                      <label class="form-label" data-en="Email *" data-ar="البريد الإلكتروني *">Email *</label>
                      <input type="email" class="form-input" required placeholder="john@company.com">
                    </div>
                  </div>
                  <div class="form-grid form-grid-2" style="margin-top: 1rem;">
                    <div class="form-group">
                      <label class="form-label" data-en="Phone *" data-ar="الهاتف *">Phone *</label>
                      <input type="tel" class="form-input" required placeholder="+966 50 000 0000">
                    </div>
                    <div class="form-group">
                      <label class="form-label" data-en="Job Title *" data-ar="المسمى الوظيفي *">Job Title *</label>
                      <input type="text" class="form-input" required placeholder="Marketing Manager">
                    </div>
                  </div>
                  <div class="form-grid" style="margin-top: 1rem;">
                    <div class="form-group">
                      <label class="form-label" data-en="Organization *" data-ar="المؤسسة *">Organization *</label>
                      <input type="text" class="form-input" required placeholder="Company Name">
                    </div>
                  </div>
                </div>

                <div id="exhibitor-step2" style="display: none;">
                  <div class="form-grid form-grid-2">
                    <div class="form-group">
                      <label class="form-label" data-en="VAT Number *" data-ar="الرقم الضريبي *">VAT Number *</label>
                      <input type="text" class="form-input" placeholder="300000000000003">
                    </div>
                    <div class="form-group">
                      <label class="form-label" data-en="CR Number *" data-ar="السجل التجاري *">CR Number *</label>
                      <input type="text" class="form-input" placeholder="1010000000">
                    </div>
                  </div>
                  <div class="form-grid" style="margin-top: 1rem;">
                    <div class="form-group">
                      <label class="form-label" data-en="National Address *" data-ar="العنوان الوطني *">National Address *</label>
                      <input type="text" class="form-input" placeholder="Building, Street, City">
                    </div>
                  </div>
                  <div class="form-grid" style="margin-top: 1rem;">
                    <div class="form-group">
                      <label class="form-label" data-en="Supporting Documents (Optional)" data-ar="المستندات الداعمة (اختياري)">Supporting Documents (Optional)</label>
                      <input type="file" class="form-input">
                    </div>
                  </div>
                </div>

                <div class="form-buttons">
                  <button type="button" class="btn btn-outline" onclick="exhibitorBack()">
                    <svg class="icon icon-sm" style="margin-right: 0.5rem;" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                    <span data-en="Back" data-ar="رجوع">Back</span>
                  </button>
                  <button type="button" class="btn btn-primary" id="exhibitor-next-btn" onclick="exhibitorNext()">
                    <span data-en="Next Step" data-ar="الخطوة التالية">Next Step</span>
                    <svg class="icon icon-sm" style="margin-left: 0.5rem;" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                  </button>
                  <button type="submit" class="btn btn-primary" id="exhibitor-submit-btn" style="display: none;" data-en="Submit Application" data-ar="إرسال الطلب">Submit Application</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Sponsors Section -->
    <section class="sponsors" id="sponsors">
      <div class="container">
        <div class="section-header" data-animate>
          <h2 class="section-title">{{ __('Our Sponsors') }}</h2>
          <p class="section-desc">{{ __('We are grateful to our sponsors who make this event possible.') }}</p>
        </div>

        <div class="sponsor-tiers">
          @php $renderedSponsors = false; @endphp
          @foreach($sponsorTiers as $tierKey => $label)
            @php $tierSponsors = $groupedSponsors->get($tierKey); @endphp
            @if($tierSponsors && $tierSponsors->count())
              @php $renderedSponsors = true; @endphp
              <div class="sponsor-tier">
                <h3 class="sponsor-tier-title">{{ $label }}</h3>
                <div class="sponsor-tier-grid tier-{{ $tierKey }}">
                  @foreach($tierSponsors as $sponsor)
                    <a href="{{ route('public.sponsors.show', ['locale' => app()->getLocale(), 'sponsor' => $sponsor]) }}"
                       class="sponsor-card {{ $tierKey }}"
                       data-animate>
                      <div class="sponsor-badge {{ $tierKey }}">
                        <svg class="icon icon-sm" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        <span>{{ $label }}</span>
                      </div>
                      <div class="sponsor-logo">
                        <img src="{{ asset('storage/'.$sponsor->logo_path) }}" alt="{{ $sponsor->name }}">
                      </div>
                     
                    </a>
                  @endforeach
                </div>
              </div>
            @endif
          @endforeach

          @php
            $otherSponsors = $groupedSponsors->filter(function ($_, $key) use ($sponsorTiers) {
              return ! array_key_exists($key, $sponsorTiers);
            })->flatten();
          @endphp

          @if($otherSponsors->count())
            @php $renderedSponsors = true; @endphp
            <div class="sponsor-tier">
              <h3 class="sponsor-tier-title">{{ __('Sponsors') }}</h3>
              <div class="sponsor-tier-grid tier-main">
                @foreach($otherSponsors as $sponsor)
                  <a href="{{ route('public.sponsors.show', ['locale' => app()->getLocale(), 'sponsor' => $sponsor]) }}"
                     class="sponsor-card"
                     data-animate>
                    <div class="sponsor-badge">
                      <svg class="icon icon-sm" viewBox="0 0 24 24"><path d="M12 5v14"/></svg>
                      <span>{{ $sponsor->tier }}</span>
                    </div>
                    <div class="sponsor-logo">
                      <img src="{{ asset('storage/'.$sponsor->logo_path) }}" alt="{{ $sponsor->name }}">
                    </div>
                    
                  </a>
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
          <h2 class="section-title">{{ __('Participating Companies') }}</h2>
          <p class="section-desc">{{ __('Meet the industry leaders who will be showcasing at the event.') }}</p>
        </div>

        <div class="participants-grid">
          @forelse($participants as $participant)
            <a href="{{ route('public.participants.show', ['locale' => app()->getLocale(), 'participant' => $participant]) }}"
               class="participant-card"
               data-animate>
              <div class="participant-logo">
                @if($participant->logo_path)
                  <img src="{{ asset('storage/'.$participant->logo_path) }}" alt="{{ $participant->name }}">
                @else
                  <span>{{ mb_strtoupper(mb_substr($participant->name, 0, 1)) }}</span>
                @endif
              </div>
              <div class="participant-name">
                {{ $participant->name }}
                @if($participant->url)
                  <svg class="icon icon-sm external-icon" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14 21 3"/></svg>
                @endif
              </div>
              <p class="participant-desc">{{ $participant->description_en ?: __('Details coming soon.') }}</p>
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

    <!-- About Section -->
    <section class="about" id="about">
      <div class="container">
        <div class="about-grid">
          <div class="about-col" data-animate>
            <div class="about-header">
              <div class="about-icon">
                <svg class="icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
              </div>
              <h2 class="about-title" data-en="Our Mission" data-ar="مهمتنا">Our Mission</h2>
            </div>
            <div class="about-card">
              <p class="about-text" data-en="Our mission is to create a world-class platform that brings together visionaries, innovators, and industry leaders from across the globe. We aim to foster collaboration, inspire innovation, and drive meaningful connections that shape the future of business." data-ar="مهمتنا هي إنشاء منصة عالمية المستوى تجمع أصحاب الرؤى والمبتكرين وقادة الصناعة من جميع أنحاء العالم. نهدف إلى تعزيز التعاون وإلهام الابتكار وإنشاء علاقات هادفة تشكل مستقبل الأعمال.">Our mission is to create a world-class platform that brings together visionaries, innovators, and industry leaders from across the globe. We aim to foster collaboration, inspire innovation, and drive meaningful connections that shape the future of business.</p>
              <p class="about-text" data-en="Through carefully curated sessions, exhibitions, and networking opportunities, we provide an unparalleled experience for all attendees." data-ar="من خلال الجلسات والمعارض وفرص التواصل المنتقاة بعناية، نقدم تجربة لا مثيل لها لجميع الحضور.">Through carefully curated sessions, exhibitions, and networking opportunities, we provide an unparalleled experience for all attendees.</p>
            </div>
          </div>

          <div class="about-col" data-animate>
            <h2 class="about-title" data-en="Our Goals" data-ar="أهدافنا" style="margin-bottom: 1.5rem;">Our Goals</h2>
            <div class="goals-list">
              <div class="goal-card" data-animate>
                <div class="goal-icon">
                  <svg class="icon" viewBox="0 0 24 24"><path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 1 1 7.072 0l-.548.547A3.374 3.374 0 0 0 14 18.469V19a2 2 0 1 1-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547Z"/></svg>
                </div>
                <div>
                  <h3 class="goal-title" data-en="Innovation" data-ar="الابتكار">Innovation</h3>
                  <p class="goal-desc" data-en="Showcase cutting-edge technologies and solutions" data-ar="عرض أحدث التقنيات والحلول">Showcase cutting-edge technologies and solutions</p>
                </div>
              </div>
              <div class="goal-card" data-animate>
                <div class="goal-icon">
                  <svg class="icon" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div>
                  <h3 class="goal-title" data-en="Networking" data-ar="التواصل">Networking</h3>
                  <p class="goal-desc" data-en="Connect industry leaders and professionals" data-ar="ربط قادة الصناعة والمهنيين">Connect industry leaders and professionals</p>
                </div>
              </div>
              <div class="goal-card" data-animate>
                <div class="goal-icon">
                  <svg class="icon" viewBox="0 0 24 24"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09zM12 15l-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/></svg>
                </div>
                <div>
                  <h3 class="goal-title" data-en="Growth" data-ar="النمو">Growth</h3>
                  <p class="goal-desc" data-en="Drive business opportunities and partnerships" data-ar="تعزيز فرص الأعمال والشراكات">Drive business opportunities and partnerships</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
      <div class="container">
        <div class="section-header" data-animate>
          <h2 class="section-title" data-en="Contact Us" data-ar="تواصل معنا">Contact Us</h2>
          <p class="section-desc" data-en="Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible." data-ar="لديك أسئلة؟ نود أن نسمع منك. أرسل لنا رسالة وسنرد في أقرب وقت ممكن.">Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
        </div>

        <div class="contact-grid">
          <div class="contact-col" data-animate>
            <div class="contact-form-card">
              <h3 class="form-title" data-en="Send us a message" data-ar="أرسل لنا رسالة">Send us a message</h3>
              <form onsubmit="handleContactSubmit(event)">
                <div class="form-grid">
                  <div class="form-group">
                    <label class="form-label" data-en="Name *" data-ar="الاسم *">Name *</label>
                    <input type="text" class="form-input" required placeholder="Your name">
                  </div>
                  <div class="form-group">
                    <label class="form-label" data-en="Email *" data-ar="البريد الإلكتروني *">Email *</label>
                    <input type="email" class="form-input" required placeholder="you@example.com">
                  </div>
                  <div class="form-group">
                    <label class="form-label" data-en="Phone (Optional)" data-ar="الهاتف (اختياري)">Phone (Optional)</label>
                    <input type="tel" class="form-input" placeholder="+966 50 000 0000">
                  </div>
                  <div class="form-group">
                    <label class="form-label" data-en="Message *" data-ar="الرسالة *">Message *</label>
                    <textarea class="form-textarea" required rows="4" placeholder="How can we help you?"></textarea>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                  <svg class="icon icon-sm" style="margin-right: 0.5rem;" viewBox="0 0 24 24"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                  <span data-en="Send Message" data-ar="إرسال الرسالة">Send Message</span>
                </button>
              </form>
            </div>
          </div>

          <div class="contact-col" data-animate>
            <h3 class="contact-info-title" data-en="Contact Information" data-ar="معلومات التواصل">Contact Information</h3>
            <div class="contact-info-list">
              <div class="contact-info-card primary">
                <div class="contact-info-header">
                  <div class="contact-info-icon">
                    <svg class="icon icon-sm" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                  </div>
                  <div style="flex: 1;">
                    <div class="contact-info-name">
                      <span data-en="General Inquiries" data-ar="الاستفسارات العامة">General Inquiries</span>
                      <span class="primary-badge" data-en="Primary" data-ar="الرئيسي">Primary</span>
                    </div>
                    <div class="contact-info-links">
                      <a href="mailto:info@conference2025.com" class="contact-info-link">
                        <svg class="icon icon-sm" viewBox="0 0 24 24"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        info@conference2025.com
                      </a>
                      <a href="tel:+966110000000" class="contact-info-link">
                        <svg class="icon icon-sm" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        +966 11 000 0000
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="contact-info-card">
                <div class="contact-info-header">
                  <div style="flex: 1;">
                    <div class="contact-info-name" data-en="Exhibitor Support" data-ar="دعم العارضين">Exhibitor Support</div>
                    <div class="contact-info-links">
                      <a href="mailto:exhibitors@conference2025.com" class="contact-info-link">
                        <svg class="icon icon-sm" viewBox="0 0 24 24"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        exhibitors@conference2025.com
                      </a>
                      <a href="tel:+966110000001" class="contact-info-link">
                        <svg class="icon icon-sm" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        +966 11 000 0001
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="contact-info-card">
                <div class="contact-info-header">
                  <div style="flex: 1;">
                    <div class="contact-info-name" data-en="Sponsorship" data-ar="الرعاية">Sponsorship</div>
                    <div class="contact-info-links">
                      <a href="mailto:sponsors@conference2025.com" class="contact-info-link">
                        <svg class="icon icon-sm" viewBox="0 0 24 24"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        sponsors@conference2025.com
                      </a>
                      <a href="tel:+966110000002" class="contact-info-link">
                        <svg class="icon icon-sm" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        +966 11 000 0002
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="location-card">
          <div class="location-header">
            <div class="contact-info-icon">
              <svg class="icon icon-sm" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
            </div>
            <div>
              <div class="location-title">{{ __('Event Location') }}</div>
              <p class="location-address">{{ __('Riyadh International Convention & Exhibition Center, King Abdullah Road, Riyadh, Saudi Arabia') }}</p>
            </div>
          </div>
          <div class="map-embed">
            <iframe
              src="https://www.google.com/maps?q=Riyadh+International+Convention+%26+Exhibition+Center&output=embed"
              allowfullscreen
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="footer-inner">
        <div class="footer-text">© 2025 <span data-en="INTERNATIONAL E-COMMERCE EXPO | Terms & Conditions" data-ar="المؤتمر الدولي للتجارة اﻹلكترونية"> INTERNATIONAL E-COMMERCE EXPO | Terms & Conditions</span></div>
        <div class="footer-text" data-en="All rights reserved." data-ar="جميع الحقوق محفوظة.">2025© All rights reserved.</div>
      </div>
    </div>
  </footer>

  <!-- Toast Container -->
  <div class="toast-container" id="toast-container"></div>
  <button id="to-top-btn" class="to-top-button" type="button" aria-label="{{ __('Back to top') }}" onclick="scrollToTop()">
    <svg class="icon icon-sm" viewBox="0 0 24 24"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
  </button>

  <script>
    // Locale Management
    let currentLocale = 'en';

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
      toggleRoleVisibility(null);
      applyRoleOrder(null);
      updateExhibitorStep();
    }

    function exhibitorNext() {
      exhibitorStep = 2;
      updateExhibitorStep();
    }

    function exhibitorBack() {
      if (exhibitorStep === 1) {
        clearRole();
      } else {
        exhibitorStep = 1;
        updateExhibitorStep();
      }
    }

    function updateExhibitorStep() {
      document.getElementById('exhibitor-step1').style.display = exhibitorStep === 1 ? 'block' : 'none';
      document.getElementById('exhibitor-step2').style.display = exhibitorStep === 2 ? 'block' : 'none';
      document.getElementById('exhibitor-next-btn').style.display = exhibitorStep === 1 ? 'inline-flex' : 'none';
      document.getElementById('exhibitor-submit-btn').style.display = exhibitorStep === 2 ? 'inline-flex' : 'none';
      
      document.getElementById('step1-indicator').classList.toggle('active', exhibitorStep >= 1);
      document.getElementById('step2-indicator').classList.toggle('active', exhibitorStep >= 2);
    }

    // Form Submissions
    function handleSubmit(event, type) {
      event.preventDefault();
      showToast(
        currentLocale === 'ar' ? 'تم إرسال التسجيل!' : 'Registration Submitted!',
        currentLocale === 'ar' ? 'سنتواصل معك قريباً.' : 'We will contact you soon.'
      );
      clearRole();
      event.target.reset();
    }

    function handleContactSubmit(event) {
      event.preventDefault();
      showToast(
        currentLocale === 'ar' ? 'تم إرسال الرسالة!' : 'Message Sent!',
        currentLocale === 'ar' ? 'سنتواصل معك قريباً.' : 'We will get back to you soon.'
      );
      event.target.reset();
    }

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
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Show register button on desktop
    if (window.innerWidth >= 640) {
      document.querySelector('.header-actions .btn-primary').style.display = 'inline-flex';
    }
    window.addEventListener('resize', () => {
      document.querySelector('.header-actions .btn-primary').style.display = 
        window.innerWidth >= 640 ? 'inline-flex' : 'none';
    });
  </script>
</body>
</html>
