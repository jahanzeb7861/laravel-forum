@forelse ($threads as $thread)
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="level">
                <div class="flex">
                    <h4>
                        <a href="{{ $thread->path() }}" target="_blank">
                            @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                <strong>
                                    {{ $thread->title }}
                                </strong>
                            @else
                                {{ $thread->title }}
                            @endif
                        </a>
                    </h4>

                    <h5>
                        Posted By: <a href="/profiles/{{ $thread->creator->name }}">{{ $thread->creator->name }}</a>
                    </h5>
                </div>
                <a href="{{ $thread->path() }}">
                    {{ $thread->replies_count }} {{ Illuminate\Support\Str::plural('reply', $thread->replies_count) }}
                </a>
            </div>
        </div>
        <div class="panel-footer">
            {{ $thread->visits }} Visits
        </div>
    </div>
@empty
    <p>There are no relevant results at this time.</p>
@endforelse

{{ $threads->links() }}

@if ($threads->lastPage() > 1)
    <ul class="pagination">
        <li class="{{ ($threads->currentPage() == 1) ? ' disabled' : '' }}">
            <a href="{{ $threads->url(1) }}" aria-label="First">
                <span aria-hidden="true" style="color:black !important">&laquo;&laquo;</span>
            </a>
        </li>
        <li class="{{ ($threads->currentPage() == 1) ? ' disabled' : '' }}">
            <a href="{{ $threads->previousPageUrl() }}" aria-label="Previous">
                <span aria-hidden="true" style="color:black !important">&laquo;</span>
            </a>
        </li>
        @for ($i = 1; $i <= $threads->lastPage(); $i++)
            <li class="{{ ($threads->currentPage() == $i) ? ' active' : '' }}">
                <a href="{{ $threads->url($i) }}">{{ $i }}</a>
            </li>
        @endfor
        <li class="{{ ($threads->currentPage() == $threads->lastPage()) ? ' disabled' : '' }}">
            <a href="{{ $threads->nextPageUrl() }}" aria-label="Next">
                <span aria-hidden="true" style="color:black !important">&raquo;</span>
            </a>
        </li>
        <li class="{{ ($threads->currentPage() == $threads->lastPage()) ? ' disabled' : '' }}">
            <a href="{{ $threads->url($threads->lastPage()) }}" aria-label="Last">
                <span aria-hidden="true" style="color:black !important">&raquo;&raquo;</span>
            </a>
        </li>
    </ul>
@endif


@section('scripts')


<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        // Select the div element to hide
        var divToHide = document.querySelector('.flex.justify-between.flex-1.sm\\:hidden');

        // Check if the div element is found
        if (divToHide) {
            // Hide the div element by setting its display property to 'none'
            divToHide.style.display = 'none';
        }


        // class="flex justify-between flex-1 sm:hidden"
        var divToHide2 = document.querySelector('.nav.flex.items-center.justify-between');

        // Check if the div element is found
        if (divToHide2) {
            // Hide the div element by setting its display property to 'none'
            divToHide2.style.display = 'none';
        }

        // Select the nav element with role="navigation" to hide
        var navToHide = document.querySelector('nav[role="navigation"]');

        // Check if the nav element is found
        if (navToHide) {
            // Hide the nav element by setting its display property to 'none'
            navToHide.style.display = 'none';
        }
    });
</script>

@endsection
