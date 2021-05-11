<div class="row ">
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">

            @php
                $pagenumber = $paginator->currentPage();
            @endphp

            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link" href={{ $paginator->previousPageUrl() }} tabindex="-1"
                        aria-disabled="true">Previous</a>
                </li>
                <li class="page-item active"><a class="page-link"
                        href={{ $paginator->url($pagenumber) }}>{{ $pagenumber }}</a></li>
                @php
                    $pagenumber++;
                @endphp

                @if ($paginator->hasMorePages())
                    <li class="page-item"><a class="page-link"
                            href={{ $paginator->url($pagenumber) }}>{{ $pagenumber }}</a></li>
                    @php
                        $pagenumber++;
                    @endphp
                    <li class="page-item"><a class="page-link"
                            href={{ $paginator->url($pagenumber) }}>{{ $pagenumber }}</a></li>
                    <li class="page-item">
                        <a class="page-link" href={{ $paginator->nextPageUrl() }}>Next</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <a class="page-link" href={{ $paginator->nextPageUrl() }}>Next</a>
                    </li>
                @endif


            @else
                <li class="page-item">
                    <a class="page-link" href={{ $paginator->previousPageUrl() }} tabindex="-1"
                        aria-disabled="true">Previous</a>
                </li>
                @php
                    $pagenumber--;
                @endphp
                <li class="page-item"><a class="page-link"
                        href={{ $paginator->url($pagenumber) }}>{{ $pagenumber }}</a></li>
                @php
                    $pagenumber++;
                @endphp
                <li class="page-item active"><a class="page-link"
                        href={{ $paginator->url($pagenumber) }}>{{ $pagenumber }}</a></li>
                @php
                    $pagenumber++;
                @endphp
                @if ($paginator->hasMorePages())
                    <li class="page-item"><a class="page-link"
                            href={{ $paginator->url($pagenumber) }}>{{ $pagenumber }}</a></li>
                    <li class="page-item">
                        <a class="page-link" href={{ $paginator->nextPageUrl() }}>Next</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <a class="page-link" href={{ $paginator->nextPageUrl() }}>Next</a>
                    </li>
                @endif
            @endif

            {{-- <li class="page-item active"><a class="page-link" href={{$paginator->url($pagenumber)}}>{{$pagenumber}}</a></li>
            @php
              $pagenumber++;
            @endphp
            <li class="page-item"><a class="page-link" href={{$paginator->url($pagenumber)}}>{{$pagenumber}}</a></li>
            @php
              $pagenumber++;
            @endphp
            <li class="page-item"><a class="page-link" href={{$paginator->url($pagenumber)}}>{{$pagenumber}}</a></li>
            @php
              $pagenumber--;
            @endphp --}}

        </ul>
    </nav>
</div>
