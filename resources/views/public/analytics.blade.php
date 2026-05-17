@extends('layouts.public')

@section('content')
    @php
        $locale = app()->getLocale();
        $isRtl = $locale === 'ar';
        $dateRangeLabel = $dateFrom->toDateString().' - '.$dateTo->toDateString();
        $exportParams = [
            'locale' => $locale,
            'date_from' => $dateFrom->toDateString(),
            'date_to' => $dateTo->toDateString(),
        ];
        $reportOrder = ['acquisition', 'content', 'geography', 'technology', 'events'];
        $reportMetricKeys = [
            'acquisition' => 'sessions',
            'content' => 'screen_page_views',
            'geography' => 'active_users',
            'technology' => 'sessions',
            'events' => 'event_count',
        ];
        $reportMetricLabels = [
            'acquisition' => __('analytics.table.sessions'),
            'content' => __('analytics.table.views'),
            'geography' => __('analytics.table.users'),
            'technology' => __('analytics.table.sessions'),
            'events' => __('analytics.table.events'),
        ];

        $metricCards = [
            [
                'label' => __('analytics.metrics.active_users'),
                'value' => number_format($dashboard['totals']['active_users']),
                'summary' => __('analytics.metric_groups.audience'),
                'accent' => '#6d3bbd',
            ],
            [
                'label' => __('analytics.metrics.sessions'),
                'value' => number_format($dashboard['totals']['sessions']),
                'summary' => __('analytics.metric_groups.traffic'),
                'accent' => '#0891b2',
            ],
            [
                'label' => __('analytics.metrics.views'),
                'value' => number_format($dashboard['totals']['screen_page_views']),
                'summary' => __('analytics.metric_groups.content'),
                'accent' => '#b7791f',
            ],
            [
                'label' => __('analytics.metrics.registrations'),
                'value' => number_format($dashboard['totals']['registrations']),
                'summary' => __('analytics.metric_groups.conversions'),
                'accent' => '#7c3aed',
            ],
            [
                'label' => __('analytics.metrics.events'),
                'value' => number_format($dashboard['totals']['event_count']),
                'summary' => __('analytics.metric_groups.activity'),
                'accent' => '#be185d',
            ],
            [
                'label' => __('analytics.metrics.key_events'),
                'value' => number_format($dashboard['totals']['key_events'], 2),
                'summary' => __('analytics.metric_groups.quality'),
                'accent' => '#4f46e5',
            ],
            [
                'label' => __('analytics.metrics.engagement_rate'),
                'value' => number_format($dashboard['totals']['engagement_rate'], 2).'%',
                'summary' => __('analytics.metric_groups.engagement'),
                'accent' => '#0f766e',
            ],
            [
                'label' => __('analytics.metrics.avg_session'),
                'value' => number_format($dashboard['totals']['average_session_duration'], 1).__('analytics.units.seconds_short'),
                'summary' => __('analytics.metric_groups.duration'),
                'accent' => '#9333ea',
            ],
        ];
    @endphp

    <style>
        body {
            background: #f6f2fb !important;
        }

        body.analytics-theme-dark {
            background: #10091a !important;
        }

        .analytics-main {
            width: 100%;
            min-width: 0;
            max-width: 80rem !important;
        }

        .analytics-dashboard {
            --ink: #20142d;
            --muted: #6d6078;
            --soft: #f6f2fb;
            --panel: #ffffff;
            --line: #e6ddec;
            --purple: #4a2574;
            --purple-2: #6d3bbd;
            --teal: #0891b2;
            --gold: #b7791f;
            --hero-bg: linear-gradient(135deg, #ffffff 0%, #f3eaff 55%, #e9fbf7 100%);
            --shell-bg: radial-gradient(circle at 0 0, rgba(109, 59, 189, 0.12), transparent 28rem), linear-gradient(180deg, #faf7ff 0%, #f6f2fb 100%);
            --card-soft: #fbfaff;
            --card-hover: #f4edff;
            --table-alt: #fbfaff;
            --table-hover: #eefcff;
            --table-top: #f3edff;
            --shadow: rgba(42, 24, 61, 0.08);
            color: var(--ink);
            display: grid;
            gap: 1.25rem;
            width: 100%;
            max-width: 100%;
            margin: 0;
            padding: 1rem;
            overflow-x: clip;
            background: var(--shell-bg);
            border-radius: 1.25rem;
        }

        .analytics-dashboard[data-theme="dark"] {
            --ink: #f8f3ff;
            --muted: #b9a8c9;
            --soft: #10091a;
            --panel: #1a1026;
            --line: #352243;
            --purple: #b991ff;
            --purple-2: #c7a2ff;
            --teal: #36d6c1;
            --gold: #f1bd62;
            --hero-bg: linear-gradient(135deg, #251535 0%, #1a1026 58%, #102622 100%);
            --shell-bg: radial-gradient(circle at 0 0, rgba(185, 145, 255, 0.18), transparent 30rem), linear-gradient(180deg, #10091a 0%, #160d22 100%);
            --card-soft: #211431;
            --card-hover: #2a193d;
            --table-alt: #1f132e;
            --table-hover: #122c31;
            --table-top: #2c1b44;
            --shadow: rgba(0, 0, 0, 0.28);
        }

        .analytics-dashboard * {
            box-sizing: border-box;
        }

        @supports not (overflow: clip) {
            .analytics-dashboard {
                overflow-x: hidden;
            }
        }

        .analytics-dashboard,
        .analytics-panel,
        .analytics-hero-top,
        .analytics-status-grid,
        .analytics-actions,
        .analytics-filter,
        .analytics-toolbar-actions,
        .analytics-nav,
        .analytics-report-tabs,
        .analytics-metrics,
        .analytics-section-head,
        .analytics-report-head,
        .analytics-chart-wrap,
        .analytics-report-table-wrap {
            min-width: 0;
            max-width: 100%;
        }

        .analytics-panel {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 1rem;
            box-shadow: 0 18px 55px var(--shadow);
        }

        .analytics-status-card,
        .analytics-action,
        .analytics-metric,
        .analytics-link,
        .analytics-report-tab,
        .analytics-export-link,
        .analytics-button,
        .analytics-theme-toggle,
        .analytics-range-chip {
            min-width: 0;
        }

        .analytics-hero {
            overflow: hidden;
        }

        .analytics-hero-top {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(20rem, 27rem);
            gap: 1.5rem;
            align-items: end;
            padding: 1.5rem;
            background: var(--hero-bg);
        }

        .analytics-eyebrow,
        .analytics-label {
            margin: 0;
            color: var(--purple-2);
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .locale-ar .analytics-eyebrow,
        .locale-ar .analytics-label {
            letter-spacing: 0;
            text-transform: none;
        }

        .analytics-title {
            margin: 0.55rem 0 0;
            color: var(--ink);
            font-size: clamp(1.85rem, 4vw, 3rem);
            font-weight: 800;
            line-height: 1.08;
        }

        .analytics-copy {
            max-width: 45rem;
            margin: 0.85rem 0 0;
            color: var(--muted);
            font-size: 1rem;
            line-height: 1.75;
        }

        .analytics-status-grid {
            display: grid;
            gap: 0.75rem;
        }

        .analytics-status-card {
            min-height: 4.5rem;
            padding: 0.95rem 1rem;
            border: 1px solid var(--line);
            border-radius: 0.85rem;
            background: color-mix(in srgb, var(--panel) 82%, transparent);
        }

        .analytics-status-card strong {
            display: block;
            margin-top: 0.4rem;
            color: var(--ink);
            font-size: 0.95rem;
            line-height: 1.35;
        }

        .analytics-success {
            color: #0f766e;
        }

        .analytics-actions {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.75rem;
            padding: 1rem;
            border-top: 1px solid var(--line);
            background: var(--panel);
        }

        .analytics-action {
            display: flex;
            min-height: 4.75rem;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 0.9rem 1rem;
            color: var(--ink);
            text-decoration: none;
            border: 1px solid var(--line);
            border-radius: 0.85rem;
            background: var(--card-soft);
            transition: border-color 0.18s ease, box-shadow 0.18s ease, transform 0.18s ease;
        }

        .analytics-action:hover,
        .analytics-action:focus-visible {
            border-color: rgba(109, 59, 189, 0.35);
            box-shadow: 0 12px 28px var(--shadow);
            transform: translateY(-1px);
            outline: none;
        }

        .analytics-action span:first-child {
            display: block;
            color: var(--muted);
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.11em;
            text-transform: uppercase;
        }

        .locale-ar .analytics-action span:first-child {
            letter-spacing: 0;
            text-transform: none;
        }

        .analytics-action strong {
            display: block;
            margin-top: 0.3rem;
            color: var(--ink);
            font-size: 0.95rem;
        }

        .analytics-action-mark {
            display: inline-flex;
            width: 2rem;
            height: 2rem;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: color-mix(in srgb, var(--purple-2) 14%, var(--panel));
            color: var(--purple);
            font-weight: 900;
        }

        .analytics-toolbar {
            position: relative;
            z-index: 10;
            padding: 1rem;
            backdrop-filter: blur(16px);
            background: color-mix(in srgb, var(--panel) 94%, transparent);
        }

        .analytics-filter {
            display: grid;
            grid-template-columns: minmax(0, 12rem) minmax(0, 12rem) auto minmax(16rem, 1fr);
            gap: 0.75rem;
            align-items: end;
        }

        .analytics-field label {
            display: block;
            color: var(--muted);
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.11em;
            text-transform: uppercase;
        }

        .locale-ar .analytics-field label {
            letter-spacing: 0;
            text-transform: none;
        }

        .analytics-input {
            min-width: 0;
            width: 100%;
            margin-top: 0.35rem;
            padding: 0.62rem 0.75rem;
            color: var(--ink);
            font: inherit;
            font-size: 0.9rem;
            font-weight: 700;
            border: 1px solid var(--line);
            border-radius: 0.75rem;
            background: var(--panel);
        }

        .analytics-input:focus {
            border-color: var(--purple-2);
            outline: 2px solid rgba(109, 59, 189, 0.18);
            outline-offset: 1px;
        }

        .analytics-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 2.65rem;
            padding: 0.65rem 1rem;
            color: #ffffff;
            font: inherit;
            font-size: 0.9rem;
            font-weight: 800;
            border: 0;
            border-radius: 0.75rem;
            background: var(--purple);
            box-shadow: 0 14px 28px rgba(74, 37, 116, 0.2);
            cursor: pointer;
        }

        .analytics-button:hover,
        .analytics-button:focus-visible {
            background: #5a2f89;
            outline: none;
        }

        .analytics-toolbar-actions {
            justify-self: end;
            align-self: end;
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            justify-content: flex-end;
        }

        .analytics-range-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            min-height: 2.65rem;
            padding: 0.65rem 0.85rem;
            color: #0f766e;
            font-size: 0.78rem;
            font-weight: 800;
            border: 1px solid color-mix(in srgb, var(--teal) 32%, var(--line));
            border-radius: 0.75rem;
            background: color-mix(in srgb, var(--teal) 12%, var(--panel));
            overflow-wrap: anywhere;
            text-align: center;
        }

        .analytics-dashboard[data-theme="dark"] .analytics-range-chip {
            color: var(--teal);
        }

        .analytics-theme-toggle {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            min-height: 2.65rem;
            padding: 0.65rem 0.85rem;
            color: var(--purple);
            font: inherit;
            font-size: 0.78rem;
            font-weight: 900;
            border: 1px solid var(--line);
            border-radius: 0.75rem;
            background: color-mix(in srgb, var(--purple-2) 10%, var(--panel));
            cursor: pointer;
        }

        .analytics-theme-toggle:hover,
        .analytics-theme-toggle:focus-visible {
            background: var(--card-hover);
            outline: none;
        }

        .analytics-theme-toggle svg {
            width: 1rem;
            height: 1rem;
            flex: 0 0 auto;
        }

        .analytics-range-chip::before {
            content: "";
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 999px;
            background: #10b981;
        }

        .analytics-nav {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.9rem;
            padding-bottom: 0.1rem;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .analytics-nav::-webkit-scrollbar {
            display: none;
        }

        .analytics-link,
        .analytics-report-tab {
            flex: 0 0 auto;
            padding: 0.58rem 0.8rem;
            color: var(--ink);
            font: inherit;
            font-size: 0.86rem;
            font-weight: 800;
            text-decoration: none;
            border: 1px solid var(--line);
            border-radius: 999px;
            background: var(--panel);
            cursor: pointer;
            white-space: nowrap;
        }

        .analytics-link:hover,
        .analytics-link:focus-visible,
        .analytics-report-tab:hover,
        .analytics-report-tab:focus-visible {
            border-color: rgba(109, 59, 189, 0.38);
            background: var(--card-hover);
            outline: none;
        }

        .analytics-report-tabs {
            display: flex;
            flex: 0 0 auto;
            gap: 0.5rem;
        }

        .analytics-report-tab[aria-selected="true"] {
            color: #ffffff;
            border-color: var(--purple);
            background: var(--purple);
            box-shadow: 0 12px 24px rgba(74, 37, 116, 0.22);
        }

        .analytics-empty {
            display: flex;
            gap: 0.75rem;
            align-items: center;
            padding: 1rem;
            color: #8a5d0b;
            font-weight: 800;
            border: 1px solid #f1d28a;
            border-radius: 1rem;
            background: color-mix(in srgb, var(--gold) 15%, var(--panel));
        }

        .analytics-dashboard[data-theme="dark"] .analytics-empty {
            color: var(--gold);
            border-color: color-mix(in srgb, var(--gold) 35%, var(--line));
        }

        .analytics-metrics {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 0.9rem;
        }

        .analytics-metric {
            position: relative;
            min-height: 9rem;
            padding: 1rem;
            overflow: hidden;
        }

        .analytics-metric::before {
            content: "";
            position: absolute;
            inset-inline-start: 0;
            top: 0;
            width: 0.32rem;
            height: 100%;
            background: var(--metric-accent);
        }

        .analytics-metric-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
        }

        .analytics-metric-group {
            margin: 0;
            color: var(--muted);
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.11em;
            text-transform: uppercase;
        }

        .locale-ar .analytics-metric-group {
            letter-spacing: 0;
            text-transform: none;
        }

        .analytics-metric-label {
            margin: 0.45rem 0 0;
            color: var(--ink);
            font-size: 0.9rem;
            font-weight: 800;
        }

        .analytics-metric-value {
            margin: 1rem 0 0;
            color: var(--ink);
            font-size: 2rem;
            font-weight: 850;
            line-height: 1;
        }

        .analytics-metric-index {
            display: inline-flex;
            width: 2.15rem;
            height: 2.15rem;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            color: var(--metric-accent);
            font-size: 0.85rem;
            font-weight: 900;
            border-radius: 0.75rem;
            background: color-mix(in srgb, var(--metric-accent) 12%, var(--panel));
        }

        .analytics-section-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        .analytics-section-title {
            margin: 0.4rem 0 0;
            color: var(--ink);
            font-size: 1.55rem;
            font-weight: 850;
            line-height: 1.15;
        }

        .analytics-section-copy {
            margin: 0.35rem 0 0;
            color: var(--muted);
            font-size: 0.92rem;
            line-height: 1.6;
        }

        .analytics-export-link {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.62rem 0.8rem;
            color: var(--purple);
            font-weight: 800;
            text-decoration: none;
            border: 1px solid var(--line);
            border-radius: 0.75rem;
            background: color-mix(in srgb, var(--purple-2) 10%, var(--panel));
        }

        .analytics-export-link:hover,
        .analytics-export-link:focus-visible {
            border-color: rgba(109, 59, 189, 0.4);
            background: var(--card-hover);
            outline: none;
        }

        .analytics-chart-wrap {
            position: relative;
            height: 24rem;
            padding: 0.85rem;
            border: 1px solid var(--line);
            border-radius: 1rem;
            background: var(--card-soft);
        }

        .analytics-chart-wrap canvas {
            display: block;
            width: 100%;
            height: 100%;
        }

        .analytics-chart-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem;
            margin: 1rem 0 0.75rem;
        }

        .analytics-chart-legend-item {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.4rem 0.6rem;
            color: var(--ink);
            font-size: 0.78rem;
            font-weight: 850;
            border: 1px solid var(--line);
            border-radius: 999px;
            background: var(--card-soft);
        }

        .analytics-chart-legend-dot {
            width: 0.62rem;
            height: 0.62rem;
            flex: 0 0 auto;
            border-radius: 999px;
            background: var(--legend-color);
        }

        .analytics-chart-dates {
            display: flex;
            gap: 0.45rem;
            max-width: 100%;
            margin-top: 0.75rem;
            padding: 0.05rem 0.05rem 0.35rem;
            overflow-x: auto;
            scrollbar-width: thin;
            -webkit-overflow-scrolling: touch;
        }

        .analytics-chart-date {
            flex: 0 0 auto;
            padding: 0.34rem 0.55rem;
            color: var(--muted);
            font-size: 0.72rem;
            font-weight: 850;
            line-height: 1;
            border: 1px solid var(--line);
            border-radius: 999px;
            background: var(--panel);
            white-space: nowrap;
        }

        .analytics-chart-status {
            position: absolute;
            inset: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            color: var(--muted);
            font-weight: 800;
            text-align: center;
            border: 1px dashed color-mix(in srgb, var(--muted) 24%, transparent);
            border-radius: 0.8rem;
            background: color-mix(in srgb, var(--panel) 72%, transparent);
        }

        .analytics-chart-status[hidden] {
            display: none;
        }

        .analytics-chart-wrap.is-chart-empty canvas {
            opacity: 0.08;
        }

        .analytics-report-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1.25rem;
            border-bottom: 1px solid var(--line);
            background: var(--card-soft);
        }

        .analytics-report-table-wrap {
            overflow-x: auto;
        }

        .analytics-report-table {
            width: 100%;
            min-width: 58rem;
            border-collapse: collapse;
            color: var(--ink);
            font-size: 0.9rem;
        }

        .analytics-report-table thead {
            color: var(--muted);
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            background: var(--panel);
        }

        .locale-ar .analytics-report-table thead {
            letter-spacing: 0;
            text-transform: none;
        }

        .analytics-report-table th,
        .analytics-report-table td {
            padding: 0.95rem 1.25rem;
            border-bottom: 1px solid var(--line);
            text-align: start;
            vertical-align: middle;
        }

        .analytics-report-table th.analytics-number,
        .analytics-report-table td.analytics-number {
            text-align: end;
        }

        .analytics-report-table tbody tr:nth-child(even) {
            background: var(--table-alt);
        }

        .analytics-report-table tbody tr:hover {
            background: var(--table-hover);
        }

        .analytics-report-table tbody tr.analytics-top-row {
            background: var(--table-top);
        }

        .analytics-rank {
            display: inline-flex;
            min-width: 2.1rem;
            height: 2.1rem;
            align-items: center;
            justify-content: center;
            padding: 0 0.45rem;
            color: var(--ink);
            font-size: 0.78rem;
            font-weight: 900;
            border-radius: 999px;
            background: color-mix(in srgb, var(--muted) 16%, var(--panel));
        }

        .analytics-top-row .analytics-rank {
            color: #ffffff;
            background: var(--purple);
        }

        .analytics-dimension {
            min-width: 18rem;
            max-width: 30rem;
        }

        .analytics-dimension-line {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 0;
        }

        .analytics-dimension-label {
            min-width: 0;
            overflow: hidden;
            color: var(--ink);
            font-weight: 850;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .analytics-top-badge {
            flex: 0 0 auto;
            padding: 0.16rem 0.48rem;
            color: #8a5d0b;
            font-size: 0.66rem;
            font-weight: 900;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            border-radius: 999px;
            background: color-mix(in srgb, var(--gold) 22%, var(--panel));
        }

        .analytics-dashboard[data-theme="dark"] .analytics-top-badge {
            color: #f9d889;
        }

        .locale-ar .analytics-top-badge {
            letter-spacing: 0;
            text-transform: none;
        }

        .analytics-bar {
            height: 0.5rem;
            margin-top: 0.65rem;
            overflow: hidden;
            border-radius: 999px;
            background: color-mix(in srgb, var(--muted) 18%, var(--panel));
        }

        .analytics-bar-fill {
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, var(--purple-2), var(--teal));
        }

        .analytics-primary-value {
            display: inline-flex;
            min-width: 2.6rem;
            justify-content: center;
            padding: 0.32rem 0.48rem;
            color: var(--ink);
            font-size: 0.78rem;
            font-weight: 900;
            border-radius: 0.65rem;
            background: color-mix(in srgb, var(--muted) 14%, var(--panel));
        }

        @media (max-width: 1024px) {
            .analytics-hero-top,
            .analytics-filter,
            .analytics-actions,
            .analytics-metrics {
                grid-template-columns: 1fr 1fr;
            }

            .analytics-toolbar-actions {
                justify-self: start;
                justify-content: flex-start;
            }
        }

        @media (max-width: 700px) {
            .analytics-dashboard {
                border-radius: 0;
            }

            .analytics-hero-top,
            .analytics-actions,
            .analytics-filter,
            .analytics-metrics {
                grid-template-columns: 1fr;
            }

            .analytics-section-head,
            .analytics-report-head {
                flex-direction: column;
                align-items: stretch;
            }
        }

        /* Mobile-first final layout pass. Keep this after the legacy breakpoints. */
        .analytics-dashboard {
            gap: 0.85rem;
            margin: 0;
            padding: 0.75rem;
            border-radius: 0;
        }

        .analytics-panel {
            border-radius: 0.9rem;
        }

        .analytics-hero-top,
        .analytics-actions,
        .analytics-filter,
        .analytics-metrics {
            grid-template-columns: 1fr;
        }

        .analytics-hero-top {
            gap: 1rem;
            padding: 1rem;
        }

        .analytics-title {
            font-size: clamp(1.55rem, 7.4vw, 2.25rem);
        }

        .analytics-copy {
            font-size: 0.92rem;
            line-height: 1.65;
        }

        .analytics-status-card,
        .analytics-action,
        .analytics-metric {
            padding: 0.85rem;
        }

        .analytics-actions {
            gap: 0.6rem;
            padding: 0.75rem;
        }

        .analytics-action {
            min-height: 4rem;
        }

        .analytics-toolbar {
            padding: 0.75rem;
        }

        .analytics-button,
        .analytics-theme-toggle,
        .analytics-range-chip {
            width: 100%;
        }

        .analytics-toolbar-actions {
            justify-self: stretch;
            justify-content: stretch;
        }

        .analytics-toolbar-actions > * {
            flex: 1 1 100%;
            min-width: 0;
        }

        .analytics-nav {
            gap: 0.4rem;
            margin: 0.75rem 0 0;
            padding: 0 0 0.35rem;
        }

        .analytics-link,
        .analytics-report-tab {
            padding: 0.52rem 0.72rem;
            font-size: 0.8rem;
        }

        .analytics-metric {
            min-height: auto;
        }

        .analytics-metric-value {
            font-size: 1.75rem;
        }

        .analytics-section-head,
        .analytics-report-head {
            flex-direction: column;
            align-items: stretch;
        }

        .analytics-chart-wrap {
            height: 16.5rem;
            padding: 0.55rem;
        }

        .analytics-report-head {
            padding: 1rem;
        }

        .analytics-report-table {
            min-width: 43rem;
            font-size: 0.82rem;
        }

        .analytics-report-table th,
        .analytics-report-table td {
            padding: 0.75rem 0.85rem;
        }

        .analytics-dimension {
            min-width: 15rem;
            max-width: 20rem;
        }

        @media (min-width: 640px) {
            .analytics-dashboard {
                gap: 1rem;
                padding: 1rem;
                border-radius: 1.25rem;
            }

            .analytics-hero-top,
            .analytics-actions,
            .analytics-filter,
            .analytics-metrics {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (min-width: 1024px) {
            .analytics-dashboard {
                gap: 1.25rem;
            }

            .analytics-panel {
                border-radius: 1rem;
            }

            .analytics-hero-top {
                grid-template-columns: minmax(0, 1fr) minmax(20rem, 27rem);
                gap: 1.5rem;
                padding: 1.5rem;
            }

            .analytics-actions {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 0.75rem;
                padding: 1rem;
            }

            .analytics-filter {
                grid-template-columns: minmax(0, 12rem) minmax(0, 12rem) auto minmax(16rem, 1fr);
            }

            .analytics-toolbar {
                padding: 1rem;
            }

            .analytics-toolbar-actions {
                justify-self: end;
                justify-content: flex-end;
            }

            .analytics-button,
            .analytics-theme-toggle,
            .analytics-range-chip {
                width: auto;
            }

            .analytics-metrics {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }

            .analytics-metric {
                min-height: 9rem;
                padding: 1rem;
            }

            .analytics-chart-wrap {
                height: 24rem;
                padding: 0.85rem;
            }

            .analytics-chart-dates {
                flex-wrap: wrap;
                overflow-x: visible;
            }

            .analytics-report-head {
                flex-direction: row;
                align-items: center;
                padding: 1.25rem;
            }

            .analytics-section-head {
                flex-direction: row;
                align-items: flex-start;
            }

            .analytics-report-table {
                min-width: 58rem;
                font-size: 0.9rem;
            }

            .analytics-report-table th,
            .analytics-report-table td {
                padding: 0.95rem 1.25rem;
            }

            .analytics-dimension {
                min-width: 18rem;
                max-width: 30rem;
            }
        }
    </style>

    <section class="analytics-dashboard">
        <section id="overview" class="analytics-panel analytics-hero">
            <div class="analytics-hero-top">
                <div>
                    <p class="analytics-eyebrow">{{ __('analytics.sections.command_center') }}</p>
                    <h1 class="analytics-title">{{ __('analytics.title') }}</h1>
                    <p class="analytics-copy">{{ __('analytics.description') }}</p>
                </div>

                <div class="analytics-status-grid">
                    <div class="analytics-status-card">
                        <p class="analytics-label">{{ __('analytics.range') }}</p>
                        <strong>{{ $dateRangeLabel }}</strong>
                    </div>
                    <div class="analytics-status-card">
                        <p class="analytics-label">{{ __('analytics.last_sync') }}</p>
                        <strong>
                            @if ($dashboard['lastSync'])
                                {{ $dashboard['lastSync']->started_at->format('Y-m-d H:i') }}
                                <span class="analytics-success">({{ __("analytics.status.{$dashboard['lastSync']->status}") }})</span>
                            @else
                                {{ __('analytics.status.not_available') }}
                            @endif
                        </strong>
                    </div>
                </div>
            </div>

            <div class="analytics-actions">
                <a href="#traffic" class="analytics-action">
                    <span>
                        {{ __('analytics.sections.quick_action') }}
                        <strong>{{ __('analytics.sections.view_traffic') }}</strong>
                    </span>
                    <span class="analytics-action-mark">&rarr;</span>
                </a>
                <a href="#reports" class="analytics-action">
                    <span>
                        {{ __('analytics.sections.quick_action') }}
                        <strong>{{ __('analytics.sections.view_reports') }}</strong>
                    </span>
                    <span class="analytics-action-mark">&rarr;</span>
                </a>
                <a href="{{ route('public.analytics.export', $exportParams + ['report' => 'daily']) }}" class="analytics-action">
                    <span>
                        {{ __('analytics.export_csv') }}
                        <strong>{{ __('analytics.reports.daily') }}</strong>
                    </span>
                    <span class="analytics-action-mark">&darr;</span>
                </a>
            </div>
        </section>

        @if ($dashboard['series']['labels'] === [])
            <div class="analytics-empty">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                </svg>
                {{ __('analytics.empty_range') }}
            </div>
        @endif

        <section class="analytics-metrics" aria-label="{{ __('analytics.sections.overview') }}">
            @foreach ($metricCards as $card)
                <article class="analytics-panel analytics-metric" style="--metric-accent: {{ $card['accent'] }}">
                    <div class="analytics-metric-top">
                        <div>
                            <p class="analytics-metric-group">{{ $card['summary'] }}</p>
                            <h2 class="analytics-metric-label">{{ $card['label'] }}</h2>
                            <p class="analytics-metric-value">{{ $card['value'] }}</p>
                        </div>
                        <span class="analytics-metric-index">{{ $loop->iteration }}</span>
                    </div>
                </article>
            @endforeach
        </section>

        <section id="traffic" class="analytics-panel" style="padding: 1.25rem;">
            <div class="analytics-section-head">
                <div>
                    <p class="analytics-label">{{ __('analytics.sections.traffic') }}</p>
                    <h2 class="analytics-section-title">{{ __('analytics.charts.traffic') }}</h2>
                    <p class="analytics-section-copy">{{ __('analytics.charts.traffic_hint') }}</p>
                </div>
                <a href="{{ route('public.analytics.export', $exportParams + ['report' => 'daily']) }}" class="analytics-export-link">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 3v11m0 0 4-4m-4 4-4-4M5 19h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    {{ __('analytics.export') }}
                </a>
            </div>
            <div class="analytics-chart-legend" aria-label="{{ __('analytics.charts.legend') }}">
                <span class="analytics-chart-legend-item">
                    <span class="analytics-chart-legend-dot" style="--legend-color: #6d3bbd"></span>
                    {{ __('analytics.metrics.active_users') }}
                </span>
                <span class="analytics-chart-legend-item">
                    <span class="analytics-chart-legend-dot" style="--legend-color: #0891b2"></span>
                    {{ __('analytics.metrics.sessions') }}
                </span>
                <span class="analytics-chart-legend-item">
                    <span class="analytics-chart-legend-dot" style="--legend-color: #b7791f"></span>
                    {{ __('analytics.metrics.views') }}
                </span>
            </div>
            <div class="analytics-chart-wrap">
                <canvas id="trafficChart"></canvas>
                <div class="analytics-chart-status" data-chart-status aria-live="polite">
                    {{ __('analytics.charts.loading') }}
                </div>
            </div>
            @if ($dashboard['series']['labels'] !== [])
                <div class="analytics-chart-dates" aria-label="{{ __('analytics.charts.date_points') }}">
                    @foreach ($dashboard['series']['labels'] as $label)
                        <span class="analytics-chart-date">{{ $label }}</span>
                    @endforeach
                </div>
            @endif
        </section>

        <div class="analytics-panel analytics-toolbar">
            <form method="GET" action="{{ route('public.analytics', ['locale' => $locale]) }}" class="analytics-filter">
                <div class="analytics-field">
                    <label for="date_from">{{ __('analytics.filters.from') }}</label>
                    <input id="date_from" name="date_from" type="date" value="{{ $dateFrom->toDateString() }}" class="analytics-input">
                </div>
                <div class="analytics-field">
                    <label for="date_to">{{ __('analytics.filters.to') }}</label>
                    <input id="date_to" name="date_to" type="date" value="{{ $dateTo->toDateString() }}" class="analytics-input">
                </div>
                <button type="submit" class="analytics-button">{{ __('analytics.filters.apply') }}</button>
                <div class="analytics-toolbar-actions">
                    <div class="analytics-range-chip">{{ __('analytics.sections.active_range') }}: {{ $dateRangeLabel }}</div>
                    <button type="button" class="analytics-theme-toggle" data-analytics-theme-toggle aria-pressed="false">
                        <svg data-theme-icon-light viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 4V2m0 20v-2m8-8h2M2 12h2m14.95-6.95 1.41-1.41M3.64 20.36l1.41-1.41m0-13.9L3.64 3.64m16.72 16.72-1.41-1.41M12 17a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                        <svg data-theme-icon-dark viewBox="0 0 24 24" fill="none" aria-hidden="true" hidden>
                            <path d="M21 14.5A8.5 8.5 0 0 1 9.5 3 7 7 0 1 0 21 14.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span data-theme-label>{{ __('analytics.sections.dark_mode') }}</span>
                    </button>
                </div>
            </form>

            <nav class="analytics-nav" aria-label="{{ __('analytics.sections.navigation') }}">
                <a href="#overview" class="analytics-link">{{ __('analytics.sections.overview') }}</a>
                <a href="#traffic" class="analytics-link">{{ __('analytics.sections.traffic') }}</a>

                <div class="analytics-report-tabs" role="tablist" aria-label="{{ __('analytics.sections.report_tabs') }}">
                    @foreach ($reportOrder as $report)
                        @php
                            $isDefaultReport = $report === 'acquisition';
                        @endphp
                        <button type="button"
                            id="tab-{{ $report }}"
                            class="analytics-report-tab"
                            role="tab"
                            aria-selected="{{ $isDefaultReport ? 'true' : 'false' }}"
                            aria-controls="panel-{{ $report }}"
                            data-report-tab="{{ $report }}">
                            {{ $reports[$report] }}
                        </button>
                    @endforeach
                </div>
            </nav>
        </div>


        <section id="reports" class="analytics-panel" style="overflow: hidden;">
            @foreach ($reportOrder as $report)
                @php
                    $isDefaultReport = $report === 'acquisition';
                    $metricKey = $reportMetricKeys[$report];
                    $maxMetric = collect($dashboard['reports'][$report])->max($metricKey);
                    $maxMetric = $maxMetric > 0 ? $maxMetric : 1;
                @endphp
                <section id="report-{{ $report }}"
                    role="tabpanel"
                    tabindex="0"
                    aria-labelledby="tab-{{ $report }}"
                    data-report-panel="{{ $report }}"
                    @unless ($isDefaultReport) hidden @endunless>
                    <div class="analytics-report-head">
                        <div>
                            <p class="analytics-label">{{ __('analytics.sections.report_tabs') }}</p>
                            <h2 class="analytics-section-title">{{ $reports[$report] }}</h2>
                            <p class="analytics-section-copy">{{ __('analytics.sections.ranked_by') }} {{ $reportMetricLabels[$report] }}</p>
                        </div>
                        <a href="{{ route('public.analytics.export', $exportParams + ['report' => $report]) }}" class="analytics-export-link">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M12 4v10m0 0 3-3m-3 3-3-3M5 20h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            {{ __('analytics.export') }}
                        </a>
                    </div>

                    <div class="analytics-report-table-wrap">
                        <table class="analytics-report-table">
                            <thead>
                                <tr>
                                    <th>{{ __('analytics.table.rank') }}</th>
                                    <th>{{ __('analytics.table.dimension') }}</th>
                                    <th class="analytics-number">{{ __('analytics.table.users') }}</th>
                                    <th class="analytics-number">{{ __('analytics.table.sessions') }}</th>
                                    <th class="analytics-number">{{ $report === 'events' ? __('analytics.table.events') : __('analytics.table.views') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dashboard['reports'][$report] as $row)
                                    @php
                                        $primaryValue = (int) $row[$metricKey];
                                        $percentage = min(($primaryValue / $maxMetric) * 100, 100);
                                        $isTopRow = $loop->first;
                                    @endphp
                                    <tr @class(['analytics-top-row' => $isTopRow])>
                                        <td><span class="analytics-rank">#{{ $loop->iteration }}</span></td>
                                        <td class="analytics-dimension">
                                            <div class="analytics-dimension-line">
                                                <span class="analytics-dimension-label" title="{{ $row['label'] }}">{{ $row['label'] }}</span>
                                                @if ($isTopRow)
                                                    <span class="analytics-top-badge">{{ __('analytics.table.top_result') }}</span>
                                                @endif
                                            </div>
                                            <div class="analytics-bar">
                                                <div class="analytics-bar-fill" style="width: {{ $percentage }}%;"></div>
                                            </div>
                                        </td>
                                        <td class="analytics-number"><strong>{{ number_format($row['active_users']) }}</strong></td>
                                        <td class="analytics-number">{{ number_format($row['sessions']) }}</td>
                                        <td class="analytics-number">
                                            <span class="analytics-primary-value">{{ number_format($report === 'events' ? $row['event_count'] : $row['screen_page_views']) }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="padding: 3rem; text-align: center; color: var(--muted); font-weight: 800;">
                                            {{ __('analytics.no_rows') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            @endforeach
        </section>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dashboard = document.querySelector('.analytics-dashboard');
            const themeToggle = document.querySelector('[data-analytics-theme-toggle]');
            const themeLabel = document.querySelector('[data-theme-label]');
            const lightIcon = document.querySelector('[data-theme-icon-light]');
            const darkIcon = document.querySelector('[data-theme-icon-dark]');
            const chartStatus = document.querySelector('[data-chart-status]');
            const chartWrap = document.querySelector('.analytics-chart-wrap');
            const reportTabs = Array.from(document.querySelectorAll('[data-report-tab]'));
            const reportPanels = Array.from(document.querySelectorAll('[data-report-panel]'));
            const reportsSection = document.getElementById('reports');
            const themeText = {
                dark: @json(__('analytics.sections.dark_mode')),
                light: @json(__('analytics.sections.light_mode')),
            };
            const chartMessages = {
                loading: @json(__('analytics.charts.loading')),
                noData: @json(__('analytics.charts.no_data')),
                error: @json(__('analytics.charts.error')),
            };
            let trafficChart = null;
            let chartLoadAttempts = 0;
            let fallbackChartRendered = false;
            let fallbackChartSeries = null;

            const preferredTheme = () => {
                let storedTheme = null;

                try {
                    storedTheme = window.localStorage.getItem('analytics-theme');
                } catch (error) {
                    storedTheme = null;
                }

                if (storedTheme === 'dark' || storedTheme === 'light') {
                    return storedTheme;
                }

                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            };

            const chartPalette = () => {
                const isDark = dashboard?.dataset.theme === 'dark';

                return {
                    text: isDark ? '#f8f3ff' : '#20142d',
                    muted: isDark ? '#b9a8c9' : '#6d6078',
                    grid: isDark ? 'rgba(199, 162, 255, 0.14)' : 'rgba(109, 59, 189, 0.10)',
                    tooltip: isDark ? 'rgba(13, 8, 20, 0.96)' : 'rgba(32, 20, 45, 0.94)',
                    pointBorder: isDark ? '#1a1026' : '#ffffff',
                };
            };

            const syncChartTheme = () => {
                if (!trafficChart) {
                    if (fallbackChartRendered && fallbackChartSeries) {
                        const chartElement = document.getElementById('trafficChart');
                        renderCanvasFallback(chartElement, fallbackChartSeries);
                    }

                    return;
                }

                const palette = chartPalette();
                trafficChart.options.plugins.tooltip.backgroundColor = palette.tooltip;
                trafficChart.options.scales.x.ticks.color = palette.muted;
                trafficChart.options.scales.x.grid.color = palette.grid;
                trafficChart.options.scales.y.ticks.color = palette.muted;
                trafficChart.options.scales.y.grid.color = palette.grid;
                trafficChart.data.datasets.forEach((dataset) => {
                    dataset.pointBorderColor = palette.pointBorder;
                });
                trafficChart.update();
            };

            const applyTheme = (theme, persist = false) => {
                if (!dashboard) {
                    return;
                }

                dashboard.dataset.theme = theme;
                document.body.classList.toggle('analytics-theme-dark', theme === 'dark');

                if (themeToggle) {
                    themeToggle.setAttribute('aria-pressed', theme === 'dark' ? 'true' : 'false');
                }

                if (themeLabel) {
                    themeLabel.textContent = theme === 'dark' ? themeText.light : themeText.dark;
                }

                if (lightIcon && darkIcon) {
                    lightIcon.hidden = theme === 'dark';
                    darkIcon.hidden = theme !== 'dark';
                }

                if (persist) {
                    try {
                        window.localStorage.setItem('analytics-theme', theme);
                    } catch (error) {
                        // Ignore storage failures; the current page still updates.
                    }
                }

                syncChartTheme();
            };

            applyTheme(preferredTheme());

            themeToggle?.addEventListener('click', () => {
                applyTheme(dashboard?.dataset.theme === 'dark' ? 'light' : 'dark', true);
            });

            const setChartStatus = (message = '', visible = false) => {
                if (!chartStatus || !chartWrap) {
                    return;
                }

                chartStatus.textContent = message;
                chartStatus.hidden = !visible;
                chartWrap.classList.toggle('is-chart-empty', visible);
            };

            const hasUsableTrafficData = (series) => {
                return Array.isArray(series.labels) &&
                    series.labels.length > 0 &&
                    [series.active_users, series.sessions, series.screen_page_views].some((dataset) => {
                        return Array.isArray(dataset) && dataset.some((value) => Number(value) > 0);
                    });
            };

            const renderCanvasFallback = (canvas, series) => {
                if (!canvas || !hasUsableTrafficData(series)) {
                    return false;
                }

                const context = canvas.getContext('2d');

                if (!context) {
                    return false;
                }

                const palette = chartPalette();
                const parent = canvas.parentElement;
                const pixelRatio = window.devicePixelRatio || 1;
                const width = Math.max(canvas.clientWidth || parent?.clientWidth || 640, 320);
                const height = Math.max(canvas.clientHeight || parent?.clientHeight || 288, 220);
                const padding = {
                    top: 28,
                    right: 18,
                    bottom: 18,
                    left: 46,
                };
                const labels = series.labels;
                const datasets = [
                    {
                        label: @json(__('analytics.metrics.active_users')),
                        values: series.active_users || [],
                        color: '#6d3bbd',
                    },
                    {
                        label: @json(__('analytics.metrics.sessions')),
                        values: series.sessions || [],
                        color: '#0891b2',
                    },
                    {
                        label: @json(__('analytics.metrics.views')),
                        values: series.screen_page_views || [],
                        color: '#b7791f',
                    },
                ];
                const maxValue = Math.max(
                    1,
                    ...datasets.flatMap((dataset) => dataset.values.map((value) => Number(value) || 0))
                );
                const plotWidth = width - padding.left - padding.right;
                const plotHeight = height - padding.top - padding.bottom;
                const xForIndex = (index) => {
                    if (labels.length <= 1) {
                        return padding.left + plotWidth / 2;
                    }

                    return padding.left + (index / (labels.length - 1)) * plotWidth;
                };
                const yForValue = (value) => padding.top + plotHeight - ((Number(value) || 0) / maxValue) * plotHeight;

                canvas.width = Math.floor(width * pixelRatio);
                canvas.height = Math.floor(height * pixelRatio);
                context.setTransform(pixelRatio, 0, 0, pixelRatio, 0, 0);
                context.clearRect(0, 0, width, height);
                context.font = '12px Arial, sans-serif';
                context.lineCap = 'round';
                context.lineJoin = 'round';

                for (let tick = 0; tick <= 4; tick++) {
                    const y = padding.top + (plotHeight / 4) * tick;
                    const value = Math.round(maxValue - (maxValue / 4) * tick);
                    context.strokeStyle = palette.grid;
                    context.lineWidth = 1;
                    context.beginPath();
                    context.moveTo(padding.left, y);
                    context.lineTo(width - padding.right, y);
                    context.stroke();
                    context.fillStyle = palette.muted;
                    context.textAlign = 'right';
                    context.fillText(String(value), padding.left - 8, y + 4);
                }

                datasets.forEach((dataset) => {
                    context.strokeStyle = dataset.color;
                    context.lineWidth = 2.5;
                    context.beginPath();

                    dataset.values.forEach((value, index) => {
                        const x = xForIndex(index);
                        const y = yForValue(value);

                        if (index === 0) {
                            context.moveTo(x, y);
                        } else {
                            context.lineTo(x, y);
                        }
                    });

                    context.stroke();

                    dataset.values.forEach((value, index) => {
                        const x = xForIndex(index);
                        const y = yForValue(value);
                        context.fillStyle = dataset.color;
                        context.beginPath();
                        context.arc(x, y, 3.5, 0, Math.PI * 2);
                        context.fill();
                    });
                });

                fallbackChartRendered = true;
                fallbackChartSeries = series;
                setChartStatus('', false);

                return true;
            };

            window.addEventListener('resize', () => {
                if (fallbackChartRendered && fallbackChartSeries && !trafficChart) {
                    const chartElement = document.getElementById('trafficChart');
                    renderCanvasFallback(chartElement, fallbackChartSeries);
                }
            });

            const reportFromHash = () => {
                const hash = window.location.hash || '';

                if (!hash.startsWith('#report-')) {
                    return null;
                }

                return hash.replace('#report-', '');
            };

            const activateReport = (report, scrollToReports = false, updateHash = false) => {
                const selectedTab = reportTabs.find((tab) => tab.dataset.reportTab === report);

                if (!selectedTab) {
                    return false;
                }

                reportTabs.forEach((tab) => {
                    tab.setAttribute('aria-selected', tab.dataset.reportTab === report ? 'true' : 'false');
                });

                reportPanels.forEach((panel) => {
                    panel.hidden = panel.dataset.reportPanel !== report;
                });

                if (updateHash) {
                    window.history.replaceState(null, '', `#report-${report}`);
                }

                if (scrollToReports && reportsSection) {
                    reportsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }

                return true;
            };

            reportTabs.forEach((tab) => {
                tab.addEventListener('click', () => {
                    activateReport(tab.dataset.reportTab, true, true);
                });
            });

            activateReport(reportFromHash() || 'acquisition');

            window.addEventListener('hashchange', () => {
                const report = reportFromHash();

                if (report) {
                    activateReport(report, true);
                }
            });

            const renderCharts = () => {
                if (!window.Chart) {
                    chartLoadAttempts++;

                    if (chartLoadAttempts > 8) {
                        const chartElement = document.getElementById('trafficChart');
                        const series = @json($dashboard['series']);

                        if (!hasUsableTrafficData(series)) {
                            setChartStatus(chartMessages.noData, true);
                            return;
                        }

                        if (!renderCanvasFallback(chartElement, series)) {
                            setChartStatus(chartMessages.error, true);
                        }

                        return;
                    }

                    window.setTimeout(renderCharts, 100);
                    return;
                }

                const chartElement = document.getElementById('trafficChart');

                if (!chartElement) {
                    return;
                }

                const series = @json($dashboard['series']);
                const isRtl = @json($isRtl);
                const palette = chartPalette();

                if (!hasUsableTrafficData(series)) {
                    setChartStatus(chartMessages.noData, true);
                    return;
                }

                try {
                    trafficChart = new window.Chart(chartElement, {
                        type: 'line',
                        data: {
                            labels: series.labels,
                            datasets: [{
                                    label: @json(__('analytics.metrics.active_users')),
                                    data: series.active_users,
                                    borderColor: '#6d3bbd',
                                    backgroundColor: 'rgba(109, 59, 189, 0.12)',
                                    pointBackgroundColor: '#6d3bbd',
                                    pointBorderColor: palette.pointBorder,
                                    pointRadius: 4,
                                    pointHoverRadius: 6,
                                    fill: true,
                                    tension: 0.4,
                                },
                                {
                                    label: @json(__('analytics.metrics.sessions')),
                                    data: series.sessions,
                                    borderColor: '#0891b2',
                                    backgroundColor: 'rgba(8, 145, 178, 0.08)',
                                    pointBackgroundColor: '#0891b2',
                                    pointBorderColor: palette.pointBorder,
                                    pointRadius: 4,
                                    pointHoverRadius: 6,
                                    tension: 0.4,
                                },
                                {
                                    label: @json(__('analytics.metrics.views')),
                                    data: series.screen_page_views,
                                    borderColor: '#b7791f',
                                    backgroundColor: 'rgba(183, 121, 31, 0.08)',
                                    pointBackgroundColor: '#b7791f',
                                    pointBorderColor: palette.pointBorder,
                                    pointRadius: 4,
                                    pointHoverRadius: 6,
                                    tension: 0.4,
                                },
                            ],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: {
                                mode: 'index',
                                intersect: false
                            },
                            plugins: {
                                legend: {
                                    display: false,
                                },
                                tooltip: {
                                    rtl: isRtl,
                                    textDirection: isRtl ? 'rtl' : 'ltr',
                                    backgroundColor: palette.tooltip,
                                    titleColor: '#ffffff',
                                    bodyColor: '#ffffff',
                                    borderColor: 'rgba(109, 59, 189, 0.22)',
                                    borderWidth: 1,
                                    padding: 12,
                                    boxPadding: 6,
                                    usePointStyle: true,
                                    cornerRadius: 10,
                                },
                            },
                            scales: {
                                x: {
                                    ticks: {
                                        display: false,
                                        color: palette.muted,
                                        maxRotation: 0,
                                        autoSkip: true,
                                        font: { family: 'inherit' }
                                    },
                                    grid: {
                                        color: palette.grid,
                                        drawBorder: false,
                                    },
                                },
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        color: palette.muted,
                                        precision: 0,
                                        font: { family: 'inherit' }
                                    },
                                    border: {
                                        dash: [4, 4],
                                        display: false
                                    },
                                    grid: {
                                        color: palette.grid,
                                    },
                                },
                            },
                        },
                    });
                    setChartStatus('', false);
                } catch (error) {
                    console.error(error);
                    setChartStatus(chartMessages.error, true);
                }
            };

            renderCharts();
        });
    </script>
@endsection
