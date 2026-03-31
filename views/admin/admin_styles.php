<!-- Admin Base Styles — inclus dans chaque page admin -->
<style>
    :root {
        --adm-bg:        #f0f2f7;
        --adm-surface:   #ffffff;
        --adm-border:    #dde3ee;
        --adm-border-2:  #c8d0e0;
        --adm-blue:      #003f8a;
        --adm-blue-hover:#00265c;
        --adm-blue-lt:   #e8f1fb;
        --adm-gold:      #c8a04a;
        --adm-red:       #c0392b;
        --adm-red-lt:    #fdf0ef;
        --adm-red-border:#f5c6c2;
        --adm-green:     #1a7a4a;
        --adm-green-lt:  #edfaf3;
        --adm-green-border:#b2e0ca;
        --adm-amber:     #b45309;
        --adm-amber-lt:  #fef9ee;
        --adm-amber-border:#fde68a;
        --adm-text:      #1a1d2e;
        --adm-text-mid:  #4a5068;
        --adm-text-muted:#7a839a;
        --adm-shadow-sm: 0 1px 3px rgba(0,38,92,.07);
        --adm-shadow-md: 0 4px 16px rgba(0,38,92,.1);
        --adm-radius:    8px;
        --font-ui:       'Source Sans 3', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family: var(--font-ui);
        background: var(--adm-bg);
        color: var(--adm-text);
        font-size: 15px;
        line-height: 1.55;
        -webkit-font-smoothing: antialiased;
    }

    /* ─── TOPNAV ─── */
    .adm-topnav {
        background: var(--adm-blue);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 28px;
        height: 56px;
        box-shadow: 0 2px 8px rgba(0,0,0,.2);
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .adm-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }

    .adm-logo-icon {
        width: 30px; height: 30px;
        background: var(--adm-gold);
        border-radius: 4px;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 13px;
        color: var(--adm-blue-hover);
    }

    .adm-logo-text {
        color: #fff;
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: -.01em;
    }

    .adm-logo-badge {
        background: rgba(255,255,255,.15);
        color: rgba(255,255,255,.8);
        font-size: 0.65rem;
        font-weight: 600;
        letter-spacing: .08em;
        text-transform: uppercase;
        padding: 2px 8px;
        border-radius: 20px;
        margin-left: 4px;
    }

    .adm-topnav-right {
        display: flex;
        align-items: center;
        gap: 18px;
        font-size: 0.85rem;
    }

    .adm-user {
        color: rgba(255,255,255,.75);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .adm-user-avatar {
        width: 28px; height: 28px;
        background: var(--adm-gold);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.7rem; font-weight: 700;
        color: var(--adm-blue-hover);
        flex-shrink: 0;
    }

    .adm-logout {
        color: rgba(255,255,255,.65);
        text-decoration: none;
        font-size: 0.8rem;
        padding: 4px 10px;
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 4px;
        transition: background .2s, color .2s;
    }
    .adm-logout:hover { background: rgba(255,255,255,.12); color: #fff; }

    /* ─── LAYOUT ─── */
    .adm-wrap { max-width: 1180px; margin: 0 auto; padding: 28px 24px 64px; }

    /* ─── PAGE HEADER ─── */
    .adm-page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .adm-page-title { font-size: 1.4rem; font-weight: 700; color: var(--adm-text); }
    .adm-breadcrumb {
        font-size: 0.8rem; color: var(--adm-text-muted); margin-top: 4px;
        display: flex; align-items: center; gap: 6px;
    }
    .adm-breadcrumb a { color: var(--adm-blue); text-decoration: none; }
    .adm-breadcrumb a:hover { text-decoration: underline; }

    /* ─── CARD ─── */
    .adm-card {
        background: var(--adm-surface);
        border: 1px solid var(--adm-border);
        border-radius: var(--adm-radius);
        box-shadow: var(--adm-shadow-sm);
        overflow: hidden;
    }

    .adm-card-header {
        padding: 16px 20px;
        border-bottom: 1px solid var(--adm-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        background: #fafbfd;
    }

    .adm-card-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--adm-text-mid);
        letter-spacing: .03em;
        text-transform: uppercase;
    }

    .adm-card-body { padding: 24px; }

    /* ─── FORM ELEMENTS ─── */
    .adm-label {
        display: block;
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--adm-text-mid);
        letter-spacing: .03em;
        text-transform: uppercase;
        margin-bottom: 6px;
    }

    .adm-input,
    .adm-select,
    .adm-textarea {
        width: 100%;
        padding: 9px 12px;
        border: 1px solid var(--adm-border-2);
        border-radius: 6px;
        font-size: 0.95rem;
        font-family: var(--font-ui);
        color: var(--adm-text);
        background: #fff;
        transition: border-color .2s, box-shadow .2s;
        outline: none;
    }

    .adm-input:focus,
    .adm-select:focus,
    .adm-textarea:focus {
        border-color: var(--adm-blue);
        box-shadow: 0 0 0 3px rgba(0,63,138,.1);
    }

    .adm-textarea { resize: vertical; line-height: 1.6; }

    .adm-field { margin-bottom: 20px; }

    .adm-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .adm-help {
        font-size: 0.8rem;
        color: var(--adm-text-muted);
        margin-top: 5px;
    }

    .adm-error {
        font-size: 0.82rem;
        color: var(--adm-red);
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .adm-error::before { content: '⚠'; font-size: 0.9rem; }

    /* ─── NOTICE ─── */
    .adm-notice {
        background: var(--adm-blue-lt);
        border: 1px solid #b8d4f5;
        border-left: 4px solid var(--adm-blue);
        border-radius: 6px;
        padding: 12px 16px;
        font-size: 0.88rem;
        color: var(--adm-text-mid);
        margin-bottom: 24px;
        line-height: 1.6;
    }

    /* ─── BUTTONS ─── */
    .adm-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 18px;
        border-radius: 6px;
        font-size: 0.88rem;
        font-weight: 700;
        font-family: var(--font-ui);
        cursor: pointer;
        border: none;
        text-decoration: none;
        transition: background .2s, transform .15s;
        white-space: nowrap;
    }

    .adm-btn:hover { transform: translateY(-1px); }

    .adm-btn-primary { background: var(--adm-blue); color: #fff; }
    .adm-btn-primary:hover { background: var(--adm-blue-hover); }

    .adm-btn-ghost {
        background: transparent;
        color: var(--adm-text-mid);
        border: 1px solid var(--adm-border-2);
    }
    .adm-btn-ghost:hover { background: var(--adm-bg); }

    .adm-btn-danger { background: var(--adm-red-lt); color: var(--adm-red); border: 1px solid var(--adm-red-border); }
    .adm-btn-danger:hover { background: #fce0dd; }

    .adm-btn-success { background: var(--adm-green-lt); color: var(--adm-green); border: 1px solid var(--adm-green-border); }

    .adm-form-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-top: 20px;
        border-top: 1px solid var(--adm-border);
        margin-top: 8px;
        flex-wrap: wrap;
    }

    /* ─── TABLE ─── */
    .adm-table-wrap { overflow-x: auto; }

    .adm-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    .adm-table thead th {
        background: #fafbfd;
        padding: 11px 16px;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
        color: var(--adm-text-muted);
        border-bottom: 1px solid var(--adm-border);
        white-space: nowrap;
    }

    .adm-table tbody td {
        padding: 13px 16px;
        border-bottom: 1px solid var(--adm-border);
        vertical-align: middle;
    }

    .adm-table tbody tr:last-child td { border-bottom: none; }

    .adm-table tbody tr:hover td { background: #fafbfd; }

    .adm-pill {
        display: inline-flex;
        align-items: center;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: .04em;
    }

    .adm-pill-blue { background: var(--adm-blue-lt); color: var(--adm-blue); }
    .adm-pill-green { background: var(--adm-green-lt); color: var(--adm-green); }
    .adm-pill-amber { background: var(--adm-amber-lt); color: var(--adm-amber); }

    .adm-link { color: var(--adm-blue); text-decoration: none; font-weight: 600; }
    .adm-link:hover { text-decoration: underline; }

    .adm-muted { color: var(--adm-text-muted); font-size: 0.85rem; }

    .adm-table-actions { display: flex; gap: 8px; align-items: center; }

    /* ─── STATS ROW ─── */
    .adm-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
        margin-bottom: 28px;
    }

    .adm-stat-card {
        background: var(--adm-surface);
        border: 1px solid var(--adm-border);
        border-radius: var(--adm-radius);
        padding: 18px 20px;
        box-shadow: var(--adm-shadow-sm);
    }

    .adm-stat-label {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: .07em;
        text-transform: uppercase;
        color: var(--adm-text-muted);
        margin-bottom: 6px;
    }

    .adm-stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--adm-blue);
        line-height: 1;
    }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 700px) {
        .adm-row { grid-template-columns: 1fr; }
        .adm-wrap { padding: 16px 14px 48px; }
        .adm-topnav { padding: 0 16px; }
        .adm-page-header { flex-direction: column; }
    }
</style>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">