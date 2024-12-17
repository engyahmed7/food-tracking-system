@php
use App\Settings\HeaderSettings;

$headerSettings = app(HeaderSettings::class);
$headerItems = $headerSettings->header_items;
@endphp

<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="
                    {{ route('home') }}
                    " class="logo">Art<em>Xibition</em></a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        @foreach ($headerItems as $item)
                        <li><a href="{{ $item['url'] }}">{{ $item['label'] }}</a></li>
                        @endforeach
                    </ul>
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
</header>