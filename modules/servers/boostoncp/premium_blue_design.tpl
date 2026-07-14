{$booston_premium_css}

<div class="booston-client-container">
    <!-- 1. EXTREME PREMIUM ACCESS HEADER -->
    <div class="booston-hero-box">
        <div class="booston-icon-aura">
            <i class="fas fa-rocket booston-pulse-icon"></i>
        </div>
        <h2 class="booston-main-title">BoostonCP Neural Core</h2>
        <p class="booston-sub-text">Your high-performance hosting environment is active and ready.</p>
        
        {if $api_error}
            <div class="alert alert-danger booston-error-alert">
                <i class="fas fa-exclamation-triangle"></i> {$api_error}
            </div>
        {else}
            <a href="{$login_url}" target="_blank" class="booston-glow-btn">
                <span class="btn-shine"></span>
                <i class="fas fa-sign-in-alt"></i> Login to Control Panel
            </a>
        {/if}
    </div>

    <!-- 2. MINI DASHBOARD -->
    <div class="booston-dashboard-grid">
        <!-- Files -->
        <div class="booston-section">
            <h5 class="booston-section-title">File & Resources</h5>
            <div class="booston-features">
                <a href="{$login_url}" target="_blank" class="booston-feature-card">
                    <div class="f-icon"><i class="fas fa-folder-open"></i></div>
                    <span>File Manager</span>
                </a>
                <a href="{$login_url}" target="_blank" class="booston-feature-card">
                    <div class="f-icon"><i class="fas fa-chart-pie"></i></div>
                    <span>Disk Usage</span>
                </a>
                <a href="{$login_url}" target="_blank" class="booston-feature-card">
                    <div class="f-icon"><i class="fas fa-save"></i></div>
                    <span>Backup Master</span>
                </a>
            </div>
        </div>

        <!-- Databases -->
        <div class="booston-section">
            <h5 class="booston-section-title">Database Systems</h5>
            <div class="booston-features">
                <a href="{$login_url}" target="_blank" class="booston-feature-card">
                    <div class="f-icon"><i class="fas fa-database"></i></div>
                    <span>MySQL DBs</span>
                </a>
                <a href="{$login_url}" target="_blank" class="booston-feature-card">
                    <div class="f-icon"><i class="fas fa-magic"></i></div>
                    <span>DB Wizard</span>
                </a>
                <a href="{$login_url}" target="_blank" class="booston-feature-card">
                    <div class="f-icon"><i class="fas fa-table"></i></div>
                    <span>phpMyAdmin</span>
                </a>
            </div>
        </div>

        <!-- Domains -->
        <div class="booston-section">
            <h5 class="booston-section-title">Domain Management</h5>
            <div class="booston-features">
                <a href="{$login_url}" target="_blank" class="booston-feature-card">
                    <div class="f-icon"><i class="fas fa-globe"></i></div>
                    <span>Domains</span>
                </a>
                <a href="{$login_url}" target="_blank" class="booston-feature-card">
                    <div class="f-icon"><i class="fas fa-list-ol"></i></div>
                    <span>DNS Editor</span>
                </a>
                <a href="{$login_url}" target="_blank" class="booston-feature-card">
                    <div class="f-icon"><i class="fas fa-lock"></i></div>
                    <span>SSL Status</span>
                </a>
            </div>
        </div>

        <!-- Mail -->
        <div class="booston-section">
            <h5 class="booston-section-title">Email Solutions</h5>
            <div class="booston-features">
                <a href="{$login_url}" target="_blank" class="booston-feature-card">
                    <div class="f-icon"><i class="fas fa-envelope"></i></div>
                    <span>Mailboxes</span>
                </a>
                <a href="{$login_url}" target="_blank" class="booston-feature-card">
                    <div class="f-icon"><i class="fas fa-robot"></i></div>
                    <span>Autoresponders</span>
                </a>
                <a href="{$login_url}" target="_blank" class="booston-feature-card">
                    <div class="f-icon"><i class="fas fa-mail-bulk"></i></div>
                    <span>Webmail</span>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Plus+Jakarta+Sans:wght@400;600;800&display=swap');

    .booston-client-container {
        font-family: 'Plus Jakarta Sans', sans-serif;
        padding: 10px;
    }

    .booston-hero-box {
        background: #0f172a;
        background-image: radial-gradient(circle at 50% -20%, #1e40af 0%, #0f172a 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        padding: 50px 30px;
        text-align: center;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
    }

    .booston-icon-aura {
        width: 90px;
        height: 90px;
        background: rgba(59, 130, 246, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        position: relative;
        box-shadow: 0 0 30px rgba(59, 130, 246, 0.2);
    }

    .booston-pulse-icon {
        font-size: 3rem;
        color: #60efff;
        filter: drop-shadow(0 0 10px #3b82f6);
        animation: booston-float 3s ease-in-out infinite;
    }

    @keyframes booston-float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .booston-main-title {
        font-family: 'Orbitron', sans-serif;
        font-weight: 900;
        font-size: 1.8rem;
        color: #ffffff !important;
        text-transform: uppercase;
        letter-spacing: 3px;
        margin-bottom: 12px;
        text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }

    .booston-sub-text {
        color: #cbd5e1 !important;
        font-size: 1rem;
        font-weight: 500;
        max-width: 500px;
        margin: 0 auto 35px;
        line-height: 1.6;
    }

    .booston-glow-btn {
        display: inline-flex;
        align-items: center;
        gap: 15px;
        padding: 18px 45px;
        background: #2563eb;
        background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
        color: #ffffff !important;
        text-decoration: none !important;
        border-radius: 50px;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 14px;
        letter-spacing: 1.5px;
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
    }

    .booston-glow-btn:hover {
        transform: scale(1.05) translateY(-3px);
        box-shadow: 0 20px 40px rgba(37, 99, 235, 0.6);
        filter: brightness(1.1);
    }

    .booston-section-title {
        color: #3b82f6;
        font-size: 0.8rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        justify-content: center !important;
        text-align: center !important;
        gap: 15px;
    }
    .booston-section-title::before { content: ""; flex: 1; height: 1px; background: rgba(59, 130, 246, 0.2); }
    .booston-section-title::after { content: ""; flex: 1; height: 1px; background: rgba(59, 130, 246, 0.2); }
    body.dark .booston-section-title::before,
    body.dark .booston-section-title::after { background: rgba(255, 255, 255, 0.1) !important; }

    .booston-features {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        margin-bottom: 40px;
    }

    .booston-feature-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 30px 15px;
        text-align: center !important;
        text-decoration: none !important;
        transition: all 0.3s ease;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 15px !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        flex: 1 1 180px;
        max-width: 220px;
    }

    .f-icon {
        width: 60px;
        height: 60px;
        background: #f1f5f9;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: #2563eb;
        transition: 0.3s;
    }

    .booston-feature-card span {
        font-size: 0.85rem;
        font-weight: 700;
        color: #1e293b;
        text-align: center !important;
        display: block !important;
        width: 100% !important;
    }

    .booston-feature-card:hover {
        transform: translateY(-8px);
        border-color: #2563eb;
        box-shadow: 0 20px 25px -5px rgba(37, 99, 235, 0.1);
    }

    .booston-feature-card:hover .f-icon {
        background: #2563eb;
        color: #ffffff;
        transform: rotate(5deg);
    }

    /* DARK THEME FIXES */
    body.dark .booston-feature-card,
    [data-theme="dark"] .booston-feature-card,
    .dark-mode .booston-feature-card {
        background: #1e293b !important;
        border-color: rgba(255,255,255,0.05) !important;
    }
    body.dark .f-icon,
    [data-theme="dark"] .f-icon,
    .dark-mode .f-icon { background: rgba(255,255,255,0.03) !important; color: #60efff !important; }
    body.dark .booston-feature-card span,
    [data-theme="dark"] .booston-feature-card span,
    .dark-mode .booston-feature-card span { color: #f1f5f9 !important; }
</style>
