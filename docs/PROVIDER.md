# Provider integration contract

The included `DemoVideoProvider` is the only implemented adapter. It provides explicitly labeled fictional records and no media.

TikTok's account-authorized APIs must not be treated as general arbitrary-profile scraping or unrestricted media-download APIs. **No official TikTok endpoint is claimed or implemented here.** Before adding a production adapter, verify current documentation, licensing, scopes, allowed use, quotas, pricing, data retention, and whether actual downloadable media is provided.

Implement `TikTokVideoProviderInterface` with `profile`, `videos` (cursor pagination), `downloadUrl`, and `health`. Normalize only actually returned fields. Register the adapter in `TikFetchServiceProvider`, and set `TIKTOK_PROVIDER` to its identifier. Credentials belong in server environment or a secret manager, never app settings or JavaScript. Set exact HTTPS provider and media hostname allowlists. Prevent redirect escape, DNS rebinding, private IP connections, unbounded downloads, and oversized media. An allowlist + DNS precheck alone is insufficient: pin the validated connection destination and revalidate every redirect. Until a bounded streaming/authorized transfer is implemented and tested, the download controller deliberately refuses to claim success.
