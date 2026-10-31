# Security and compliance

This is a development scaffold, not a production security certification. Demo results are fictional. No private-profile access, CAPTCHA bypass, proxy evasion, or arbitrary URL fetch is implemented. Never fetch a user-supplied media URL. Use HTTPS, APP_DEBUG=false, secure session cookies, least-privilege DB credentials, managed secrets, rate limiting, and monitored queue workers.

Before production: implement real email verification and reset flows, audit logs, account deletion and retention, copyright notice/takedown forms and handling, privacy/terms/AUP pages, hardened download streaming with DNS pinning, redirect restrictions, bandwidth and size caps, concurrency limits, and dependency audit. Obtain legal review of provider terms and copyright permissions. Do not claim successful downloads until the stream completes; interrupted streams require separate delivery status semantics.
