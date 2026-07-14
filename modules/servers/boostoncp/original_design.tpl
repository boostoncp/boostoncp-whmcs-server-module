{$booston_premium_css}

<div class="booston-client-container">
    <!-- EXTREME PREMIUM EXPLOSIVE HEADER -->
    <div class="booston-hero-box-explosive">
        <div class="booston-icon-aura-explosive">
            <i class="fas fa-rocket booston-pulse-icon"></i>
        </div>
        <h2 class="booston-main-title">BoostonCP Neural Core</h2>
        <p class="booston-sub-text">Your high-performance hosting environment is active and ready.</p>
        
        {if $api_error}
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i> {$api_error}
            </div>
        {else}
            <a href="{$login_url}" target="_blank" class="booston-glow-btn">
                <i class="fas fa-sign-in-alt"></i> Login to Control Panel
            </a>
        {/if}
    </div>

    <!-- MINI DASHBOARD -->
    <div class="booston-dashboard-grid">
        <div class="booston-section">
            <h5 class="booston-section-title">Files & Resources</h5>
            <div class="booston-features">
                <a href="{$login_url}" target="_blank" class="booston-feature-card">
                    <div class="f-icon"><i class="fas fa-folder-open"></i></div>
                    <span>File Manager</span>
                </a>
                <a href="{$login_url}" target="_blank" class="booston-feature-card">
                    <div class="f-icon"><i class="fas fa-chart-pie"></i></div>
                    <span>Disk Usage</span>
                </a>
            </div>
        </div>

        <div class="booston-section">
            <h5 class="booston-section-title">Database Systems</h5>
            <div class="booston-features">
                <a href="{$login_url}" target="_blank" class="booston-feature-card">
                    <div class="f-icon"><i class="fas fa-database"></i></div>
                    <span>MySQL DBs</span>
                </a>
                <a href="{$login_url}" target="_blank" class="booston-feature-card">
                    <div class="f-icon"><i class="fas fa-table"></i></div>
                    <span>phpMyAdmin</span>
                </a>
            </div>
        </div>

        <div class="booston-section">
            <h5 class="booston-section-title">Domain Management</h5>
            <div class="booston-features">
                <a href="{$login_url}" target="_blank" class="booston-feature-card">
                    <div class="f-icon"><i class="fas fa-globe"></i></div>
                    <span>Domains</span>
                </a>
                <a href="{$login_url}" target="_blank" class="booston-feature-card">
                    <div class="f-icon"><i class="fas fa-lock"></i></div>
                    <span>SSL Status</span>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .booston-hero-box-explosive {
        background: #0f172a;
        background-image: radial-gradient(circle at 50% -20%, #1e40af 0%, #0f172a 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        padding: 50px 30px;
        text-align: center;
        margin-bottom: 40px;
    }
    .booston-icon-aura-explosive {
        width: 80px; height: 80px; background: rgba(59, 130, 246, 0.1);
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        margin: 0 auto 25px; box-shadow: 0 0 30px rgba(59, 130, 246, 0.2);
    }
    .booston-main-title { font-family: 'Orbitron', sans-serif; color: #ffffff !important; text-transform: uppercase; letter-spacing: 2px; }
    .booston-sub-text { color: #cbd5e1 !important; font-size: 1rem; }
    .booston-glow-btn {
        display: inline-flex; align-items: center; gap: 12px; padding: 15px 40px;
        background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
        color: #fff !important; text-decoration: none !important; border-radius: 50px;
        font-weight: 800; text-transform: uppercase; box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4);
    }
    .booston-feature-card {
        background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 15px; padding: 20px;
        text-align: center !important; text-decoration: none !important; transition: 0.3s;
        display: flex !important; flex-direction: column !important; align-items: center !important;
        justify-content: center !important; gap: 10px !important;
        flex: 1 1 180px; max-width: 220px;
    }
    .booston-feature-card span {
        text-align: center !important;
        display: block !important;
        width: 100% !important;
    }
    .f-icon { font-size: 1.5rem; color: #2563eb; }
    .booston-features {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        margin-top: 15px;
    }
    body.dark .booston-feature-card,
    [data-theme="dark"] .booston-feature-card { 
        background: #1e293b !important; 
        border-color: rgba(255,255,255,0.05) !important; 
    }
    body.dark .booston-feature-card span,
    [data-theme="dark"] .booston-feature-card span {
        color: #f1f5f9 !important;
    }
    .booston-dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }
</style>
