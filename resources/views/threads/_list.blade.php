@forelse ($threads as $thread)
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="level">
                <div class="flex">
                    <h4>
                        <a href="{{ $thread->path() }}">
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
