<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'TikFetch') }} — Public Video Browser</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/tikfetch.css') }}" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark border-bottom border-secondary-subtle">
    <div class="container py-2">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}"><span class="brand-mark">▶</span> TikFetch</a>
        <span class="small text-secondary">Independent community tool</span>
    </div>
</nav>

<main class="container py-5">
    <section class="hero text-center mx-auto">
        <div class="eyebrow mb-3"><span class="pulse"></span> PUBLIC PROFILE VIDEO BROWSER</div>
        <h1 class="display-5 fw-bold mb-3">Find videos.<br><span class="gradient-text">Choose what you need.</span></h1>
        <p class="lead text-secondary mb-4">Browse available videos from a public TikTok profile and download supported videos individually.</p>

        <form action="{{ route('profile.lookup') }}" method="POST" class="lookup-form text-start">
            @csrf
            <label for="profile_url" class="form-label fw-semibold">TikTok profile URL</label>
            <div class="input-group input-group-lg">
                <input id="profile_url" name="profile_url" type="url" class="form-control"
                       placeholder="https://www.tiktok.com/@username"
                       value="{{ old('profile_url', $profileUrl ?? '') }}" required maxlength="500">
                <button class="btn btn-primary px-4" type="submit">Find videos <span aria-hidden="true">→</span></button>
            </div>
            @error('profile_url') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
            <div class="small text-secondary mt-2">Public profiles only. Availability depends on the configured data provider.</div>
        </form>
    </section>

    @if ($result)
        <section class="mt-5">
            <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-3">
                <div>
                    <div class="eyebrow">PROFILE RESULTS</div>
                    <h2 class="h3 mb-1">{{ '@' . $result['username'] }}</h2>
                    <p class="text-secondary mb-0">{{ count($result['videos']) }} video(s) returned by the provider</p>
                </div>
                <div class="badge text-bg-warning p-2">Demo provider — sample data</div>
            </div>

            <div class="d-flex align-items-center justify-content-between mb-3">
                <label class="form-check d-flex gap-2 align-items-center">
                    <input class="form-check-input" type="checkbox" id="selectAll">
                    <span>Select all loaded videos</span>
                </label>
                <span class="small text-secondary"><span id="selectedCount">0</span> selected</span>
            </div>

            <div class="row g-3">
                @foreach ($result['videos'] as $video)
                    <div class="col-6 col-md-4 col-xl-3">
                        <article class="video-card h-100">
                            <div class="thumbnail">
                                <span class="play-symbol">▶</span>
                                <span class="demo-chip">SAMPLE</span>
                            </div>
                            <div class="p-3">
                                <div class="form-check mb-2">
                                    <input class="form-check-input video-select" type="checkbox" value="{{ $video['id'] }}" id="v-{{ $video['id'] }}">
                                    <label class="form-check-label small" for="v-{{ $video['id'] }}">Select video</label>
                                </div>
                                <p class="video-caption mb-3">{{ $video['caption'] }}</p>
                                <a class="btn btn-outline-light btn-sm w-100" href="{{ route('video.download', ['videoId' => $video['id']]) }}">Download video</a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
            <p class="small text-secondary mt-3">Sample cards demonstrate the interface only. Real video retrieval and downloads are not configured.</p>
        </section>
    @endif

    <section class="row g-3 mt-5">
        <div class="col-md-4"><div class="feature-card h-100"><div class="feature-icon">01</div><h3 class="h5 mt-3">Paste a profile</h3><p class="text-secondary mb-0">Enter a public TikTok profile URL to begin.</p></div></div>
        <div class="col-md-4"><div class="feature-card h-100"><div class="feature-icon">02</div><h3 class="h5 mt-3">Browse and select</h3><p class="text-secondary mb-0">Review provider-supplied metadata and choose a video.</p></div></div>
        <div class="col-md-4"><div class="feature-card h-100"><div class="feature-icon">03</div><h3 class="h5 mt-3">Download individually</h3><p class="text-secondary mb-0">Download only when an authorized media source is available.</p></div></div>
    </section>
</main>

<footer class="container py-4 border-top border-secondary-subtle small text-secondary d-flex flex-wrap justify-content-between gap-2">
    <span>© {{ date('Y') }} TikFetch — Independent service, not affiliated with TikTok.</span>
    <span>Use only content you are authorized to download.</span>
</footer>

<script>
const selectAll = document.getElementById('selectAll');
const checks = () => Array.from(document.querySelectorAll('.video-select'));
const count = document.getElementById('selectedCount');
function updateSelection() {
    const all = checks();
    const selected = all.filter(el => el.checked).length;
    if (count) count.textContent = selected;
    if (selectAll) {
        selectAll.checked = all.length > 0 && selected === all.length;
        selectAll.indeterminate = selected > 0 && selected < all.length;
    }
}
if (selectAll) selectAll.addEventListener('change', () => {
    checks().forEach(el => el.checked = selectAll.checked);
    updateSelection();
});
checks().forEach(el => el.addEventListener('change', updateSelection));
</script>
</body>
</html>
