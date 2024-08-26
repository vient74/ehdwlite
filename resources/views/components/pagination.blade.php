<!-- resources/views/components/pagination.blade.php -->
<div class="pagination">
    @if($paginator->previousPageUrl())
        @php
            $previousUrl = $paginator->previousPageUrl();
            // Pastikan URL sudah memiliki port 3000
            if (strpos($previousUrl, ':3000') === false) {
                $parsedUrl = parse_url($previousUrl);
                $previousUrl = "{$parsedUrl['scheme']}://{$parsedUrl['host']}:3000{$parsedUrl['path']}";

                if (isset($parsedUrl['query'])) {
                    $previousUrl .= "?{$parsedUrl['query']}";
                }
            }
        @endphp
        <a href="{{ $previousUrl }}" class="btn btn-primary">Previous</a>
    @endif

    @if($paginator->nextPageUrl())
        @php
            $nextUrl = $paginator->nextPageUrl();
            // Pastikan URL sudah memiliki port 3000
            if (strpos($nextUrl, ':3000') === false) {
                $parsedUrl = parse_url($nextUrl);
                $nextUrl = "{$parsedUrl['scheme']}://{$parsedUrl['host']}:3000{$parsedUrl['path']}";

                if (isset($parsedUrl['query'])) {
                    $nextUrl .= "?{$parsedUrl['query']}";
                }
            }
        @endphp
        <a href="{{ $nextUrl }}" class="btn btn-primary">Next</a>
    @endif
</div>
