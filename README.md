# BoostonCP WHMCS Provisioning Module

[![Version](https://img.shields.io/badge/version-1.6.5-blue.svg)](https://github.com/BoostonCP/whmcs-module/releases)
[![WHMCS Compatibility](https://img.shields.io/badge/whmcs-v8.x%20--%20v9.x-green.svg)](https://whmcs.com)
[![License](https://img.shields.io/badge/license-GPL--3.0-orange.svg)](LICENSE)

An official provisioning module for **BoostonCP** that automates hosting account creation, resource management, suspension/unsuspension, termination, and Single Sign-On (SSO) directly within the WHMCS billing panel.

---

### 🌐 Official Resources & Channels

| 🌐 Brand Resources | 👥 Community & Socials |
| :--- | :--- |
| 🔗 **[Official Website](https://boostoncp.com)** | 📢 **[Facebook Page](https://www.facebook.com/boostoncp)** |
| 📚 **[Documentation](https://boostoncp.com/docs)** | 👥 **[Community Group](https://www.facebook.com/groups/boostoncp.community)** |
| 🎓 **[Video Tutorials](https://boostoncp.com/tutorials)** | 💬 **[Discussion Portal](https://boostoncp.com/community)** |
| ✍️ **[Official Blog](https://boostoncp.com/blog)** | 📞 **[Contact Support](https://boostoncp.com/contact)** |

---

## Key Features

- **Automated Provisioning:** Instant account setup upon payment clearance.
- **Account Automation:** Auto-suspend on overdue invoices, auto-unsuspend on payment, and instant account termination.
- **Single Sign-On (SSO):** One-click secure login buttons for both admins and clients directly into the BoostonCP dashboard.
- **Multiple Client Area Themes:** Customize the WHMCS client portal with stunning dashboard layouts (Premium Blue, Interstellar Alien Neon, and Original).
- **Resource Synchronization:** Sync and update disk, CPU, RAM, and bandwidth limits in real-time.
- **Usage Statistics:** Auto-update account active/suspended metrics and server utilization stats in WHMCS.

---

## Directory Structure

To maintain the standard WHMCS ecosystem design, upload the files according to the following structure:

```text
whmcs_root/
└── modules/
    └── servers/
        └── boostoncp/
            ├── boostoncp.php             # Main provisioning hooks & API connector
            ├── hooks.php                  # Automation event handlers
            ├── boostoncp_hooks.php        # Core resource sync hooks
            ├── redirect.php               # Client SSO portal redirect handler
            ├── premium_blue_design.tpl    # Premium Blue client area layout
            ├── alien_neon_design.tpl      # Interstellar Neon client area layout
            └── original_design.tpl        # Classic BoostonCP client area layout
```

---

## Installation Guide

### 1. Upload Module Files
1. Download the latest release `.zip` archive from the releases page.
2. Extract the archive and copy the `modules/` folder into your WHMCS root directory (e.g. `/public_html/billing/`).

### 2. Configure the Server in WHMCS
1. Log in to your WHMCS Admin Area.
2. Navigate to **System Settings > Servers** (or **Setup > Products/Services > Servers**).
3. Click **Add New Server** and enter your BoostonCP server details:
   - **Name:** Your server name.
   - **Hostname:** Your server's hostname (e.g., `server.yourdomain.com`).
   - **IP Address:** Your server's public IP address.
   - **Type:** Select `BoostonCP` from the dropdown list.
   - **Access Hash / API Key:** Paste your BoostonCP Admin API key.
   - **Secure:** Check the box to enable secure HTTPS communication (recommended).
4. Click **Test Connection** to verify settings.

### 3. Create hosting Packages
1. Go to **System Settings > Products/Services**.
2. Click **Create a New Product** and configure the basic pricing/billing details.
3. Under the **Module Settings** tab:
   - **Module Name:** Select `BoostonCP`.
   - **BoostonCP Package:** Choose your desired package from the dropdown list (dynamically fetched from your server).
   - **Client Area Design:** Select your preferred dashboard layout for the client area.
4. Select the automation trigger setting (e.g., *Automatically setup the product as soon as the first payment is received*) and save.

---

## API & Firewall Configuration

To ensure secure communication, verify the following configuration on your BoostonCP server:

1. **API Port:** The module communicates via port `2087` (default). Ensure port `2087` is open for outbound traffic on the WHMCS host and inbound traffic on the BoostonCP server.
2. **IP Whitelisting:** If using IP restrictions on your API keys, ensure that the public outbound IPv4/IPv6 address of your WHMCS server is whitelisted.

---

## License

This project is licensed under the GPL-3.0 License. See the [LICENSE](LICENSE) file for details.
