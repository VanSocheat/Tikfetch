# Provider integration checklist

Before enabling a real provider:

1. Confirm its written documentation supports public-profile discovery for your intended use.
2. Confirm whether it returns video metadata, a playable embed, or a downloadable media URL. These are different capabilities.
3. Review provider terms, TikTok terms applicable to your service, copyright obligations, and privacy requirements.
4. Add an adapter implementing `TikTokVideoProviderInterface`.
5. Validate every media URL against an explicit hostname allowlist; do not follow redirects to arbitrary hosts.
6. Use short timeouts and bounded retries.
7. Do not log API keys, signed media URLs, or access tokens.
8. Add automated tests with mocked responses.
9. Add a user quota and a provider-wide rate limit.
10. Only mark a download successful after the media response is actually delivered successfully.

The bundled demo provider intentionally does not return downloadable URLs.
