@forelse ($channels as $channel)
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="level">
                <div class="flex">
                    <h4>
                        <a href="/threads/{{ $channel->slug }}">
                                {{ $channel->name }}
                        </a>
                    </h4>
                </div>
                <a href="/threads/{{ $channel->slug }}">
                   VIEW >
                </a>
            </div>
        </div>

        <!-- <div class="panel-body">
        </div>

        <div class="panel-footer">
        </div> -->
    </div>
@empty
    <p>There are no relevant results at this time.</p>
@endforelse
