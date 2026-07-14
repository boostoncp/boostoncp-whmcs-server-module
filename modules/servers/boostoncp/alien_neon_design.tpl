{$booston_premium_css}

<div class="booston-alien-wrap">
    <!-- Alien Orbs for Depth -->
    <div class="alien-orb orb-1"></div>
    <div class="alien-orb orb-2"></div>
    <div class="alien-orb orb-3"></div>
    
    <div class="booston-client-container">
        <!-- 1. NEURAL HERO CORE -->
        <div class="booston-hero-box">
            <div class="booston-scanner"></div>
            <div class="booston-icon-aura">
                <i class="fas fa-microchip booston-pulse-icon"></i>
            </div>
            <h2 class="booston-main-title">BoostonCP <span class="neural-text">Neural Core</span></h2>
            <p class="booston-sub-text">Interstellar hosting environment active. Systems operating at light speed with quantum redundancy.</p>
            
            {if $api_error}
                <div class="alert alert-danger booston-error-alert">
                    <i class="fas fa-radiation-alt"></i> {$api_error}
                </div>
            {else}
                <div class="btn-wrap-alien">
                    <a href="{$login_url}" target="_blank" class="booston-alien-btn">
                        <i class="fas fa-sign-in-alt"></i> INITIALIZE PANEL ACCESS
                    </a>
                </div>
            {/if}
        </div>

        <!-- 2. QUANTUM DASHBOARD GRID -->
        <div class="booston-dashboard-grid">
            
            <!-- Group: Files -->
            <div class="booston-section">
                <h5 class="booston-section-title"><i class="fas fa-atom"></i> Quantum Storage</h5>
                <div class="booston-features-stack">
                    <a href="{$login_url}" target="_blank" class="booston-alien-card">
                        <div class="f-icon"><i class="fas fa-folder-tree"></i></div>
                        <div class="f-info">
                            <span class="f-label">File Manager</span>
                            <small class="f-desc">Direct filesystem access</small>
                        </div>
                    </a>
                    <a href="{$login_url}" target="_blank" class="booston-alien-card">
                        <div class="f-icon"><i class="fas fa-tachometer-alt-fastest"></i></div>
                        <div class="f-info">
                            <span class="f-label">Resource Hub</span>
                            <small class="f-desc">Real-time node metrics</small>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Group: DB -->
            <div class="booston-section">
                <h5 class="booston-section-title"><i class="fas fa-dna"></i> Data Structures</h5>
                <div class="booston-features-stack">
                    <a href="{$login_url}" target="_blank" class="booston-alien-card">
                        <div class="f-icon"><i class="fas fa-database"></i></div>
                        <div class="f-info">
                            <span class="f-label">Neural DBs</span>
                            <small class="f-desc">High-speed SQL clusters</small>
                        </div>
                    </a>
                    <a href="{$login_url}" target="_blank" class="booston-alien-card">
                        <div class="f-icon"><i class="fas fa-table"></i></div>
                        <div class="f-info">
                            <span class="f-label">phpMyAdmin</span>
                            <small class="f-desc">Visual data architect</small>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Group: Network -->
            <div class="booston-section">
                <h5 class="booston-section-title"><i class="fas fa-satellite-dish"></i> Galactic Network</h5>
                <div class="booston-features-stack">
                    <a href="{$login_url}" target="_blank" class="booston-alien-card">
                        <div class="f-icon"><i class="fas fa-globe-americas"></i></div>
                        <div class="f-info">
                            <span class="f-label">Domains</span>
                            <small class="f-desc">Zone & Record management</small>
                        </div>
                    </a>
                    <a href="{$login_url}" target="_blank" class="booston-alien-card">
                        <div class="f-icon"><i class="fas fa-shield-virus"></i></div>
                        <div class="f-info">
                            <span class="f-label">SSL Shield</span>
                            <small class="f-desc">Certificate deployment</small>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Group: Mail -->
            <div class="booston-section">
                <h5 class="booston-section-title"><i class="fas fa-envelope-open-text"></i> Signal Comms</h5>
                <div class="booston-features-stack">
                    <a href="{$login_url}" target="_blank" class="booston-alien-card">
                        <div class="f-icon"><i class="fas fa-envelope"></i></div>
                        <div class="f-info">
                            <span class="f-label">Email Accounts</span>
                            <small class="f-desc">Secure mailbox creation</small>
                        </div>
                    </a>
                    <a href="{$login_url}" target="_blank" class="booston-alien-card">
                        <div class="f-icon"><i class="fas fa-paper-plane"></i></div>
                        <div class="f-info">
                            <span class="f-label">Webmail</span>
                            <small class="f-desc">Neural interface access</small>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Syncopate:wght@400;700&family=Space+Grotesk:wght@300;500;700&display=swap');

    :root {
        --alien-neon: #00f2ff;
        --alien-purple: #7000ff;
        --alien-bg: #050505;
        --alien-border: rgba(0, 242, 255, 0.15);
    }

    .booston-alien-wrap {
        background: var(--alien-bg);
        border-radius: 30px;
        position: relative;
        overflow: hidden;
        padding: 40px 30px;
        color: #fff;
        margin-top: 20px;
        box-shadow: 0 30px 60px rgba(0,0,0,0.8);
    }

    /* Floating Orbs */
    .alien-orb {
        position: absolute;
        width: 400px;
        height: 400px;
        border-radius: 50%;
        filter: blur(100px);
        z-index: 0;
        opacity: 0.25;
        animation: orb-float 15s infinite alternate;
    }
    .orb-1 { background: var(--alien-neon); top: -150px; right: -100px; }
    .orb-2 { background: var(--alien-purple); bottom: -150px; left: -100px; animation-delay: -7s; }
    .orb-3 { background: #3b82f6; top: 40%; left: 30%; width: 200px; height: 200px; }

    @keyframes orb-float {
        0% { transform: translate(0, 0) scale(1); }
        100% { transform: translate(100px, 50px) scale(1.2); }
    }

    .booston-client-container {
        position: relative;
        z-index: 1;
        font-family: 'Space Grotesk', sans-serif;
    }

    /* Hero Box */
    .booston-hero-box {
        background: rgba(255, 255, 255, 0.02);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 35px;
        padding: 70px 40px;
        text-align: center;
        margin-bottom: 50px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 0 40px rgba(0, 0, 0, 0.5);
    }

    .booston-scanner {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 3px;
        background: linear-gradient(90deg, transparent, var(--alien-neon), transparent);
        box-shadow: 0 0 15px var(--alien-neon);
        animation: scan-loop 4s linear infinite;
        opacity: 0.4;
    }
    @keyframes scan-loop { 0% { top: -5%; } 100% { top: 105%; } }

    .booston-icon-aura {
        width: 100px; height: 100px;
        background: rgba(0, 242, 255, 0.05);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 30px;
        border: 1px solid var(--alien-border);
        box-shadow: 0 0 30px rgba(0, 242, 255, 0.1);
    }

    .booston-pulse-icon {
        font-size: 3.5rem;
        color: var(--alien-neon);
        filter: drop-shadow(0 0 10px var(--alien-neon));
        animation: neon-pulse 2s ease-in-out infinite;
    }
    @keyframes neon-pulse { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.7; transform: scale(0.95); } }

    .booston-main-title {
        font-family: 'Syncopate', sans-serif;
        font-weight: 700;
        font-size: 2.4rem;
        letter-spacing: 6px;
        text-transform: uppercase;
        margin-bottom: 15px;
        color: #fff;
    }
    .neural-text { color: var(--alien-neon); text-shadow: 0 0 20px var(--alien-neon); }

    .booston-sub-text {
        color: #8c91a0;
        max-width: 600px;
        margin: 0 auto 40px;
        font-size: 1.1rem;
        font-weight: 300;
    }

    /* Industrial Alien Button */
    .booston-alien-btn {
        display: inline-flex;
        align-items: center;
        gap: 15px;
        padding: 22px 60px;
        background: transparent;
        border: 2px solid var(--alien-neon);
        color: var(--alien-neon) !important;
        text-decoration: none !important;
        font-weight: 800;
        letter-spacing: 3px;
        font-size: 14px;
        transition: 0.4s all cubic-bezier(0.175, 0.885, 0.32, 1.275);
        clip-path: polygon(10% 0, 100% 0, 90% 100%, 0 100%);
        box-shadow: 0 0 20px rgba(0, 242, 255, 0.1);
    }
    .booston-alien-btn:hover {
        background: var(--alien-neon);
        color: #000 !important;
        box-shadow: 0 0 50px var(--alien-neon);
        transform: scale(1.05);
    }

    /* Dashboard Grid */
    .booston-dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 30px;
    }

    .booston-section-title {
        color: var(--alien-purple);
        font-family: 'Syncopate', sans-serif;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 2px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        opacity: 0.8;
    }

    .booston-features-stack {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .booston-alien-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 18px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 20px;
        text-decoration: none !important;
        transition: 0.3s all ease;
    }

    .f-icon {
        font-size: 1.8rem;
        color: var(--alien-neon);
        width: 50px; height: 50px;
        display: flex; align-items: center; justify-content: center;
        background: rgba(0, 242, 255, 0.05);
        border-radius: 12px;
        transition: 0.3s;
    }

    .f-label { color: #fff; font-weight: 700; font-size: 0.95rem; display: block; margin-bottom: 2px; }
    .f-desc { color: #64748b; font-size: 0.75rem; font-weight: 500; }

    .booston-alien-card:hover {
        background: rgba(0, 242, 255, 0.08);
        border-color: var(--alien-neon);
        transform: translateX(10px) scale(1.02);
        box-shadow: 0 10px 25px rgba(0, 242, 255, 0.1);
    }
    .booston-alien-card:hover .f-icon {
        background: var(--alien-neon);
        color: #000;
        transform: rotate(-5deg);
    }

    /* Light Theme Integration (Dark-ish mode forced inside the wrap) */
    [data-theme="light"] .booston-alien-wrap {
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }
</style>