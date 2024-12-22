@php

use App\Settings\FooterSettings;
use App\Models\Category;

$footerSettings = app(FooterSettings::class);
$footerSettingsArray = $footerSettings->toArray();

$categoryNames = [];
if (isset($footerSettingsArray['categories'])) {
$categoryNames = Category::whereIn('id', $footerSettingsArray['categories'])->pluck('name', 'id');
}

@endphp

<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="address">
                    <h4>Food Tracking Project Address</h4>
                    <span>{{ $footerSettingsArray['address']}}</span>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="links">
                    <h4>Category</h4>
                    <ul>
                        @foreach ($categoryNames as $categoryId => $categoryName)
                        <li>
                            <a href="">{{ $categoryName }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="hours">
                    <h4>Open Hours</h4>
                    <ul>
                        @if(isset($footerSettingsArray['open_hours']))
                        @if(is_string($footerSettingsArray['open_hours']))
                        @foreach (explode("\n", $footerSettingsArray['open_hours']) as $openHour)
                        <li>{{ trim($openHour) }}</li>
                        @endforeach
                        @elseif(is_array($footerSettingsArray['open_hours']))
                        @foreach ($footerSettingsArray['open_hours'] as $openHour)
                        <li>{{ $openHour }}</li>
                        @endforeach
                        @endif
                        @else
                        <li>Opening hours will be updated soon</li>
                        @endif
                    </ul>
                </div>

            </div>

            <div class="col-lg-12">
                <div class="under-footer">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6">
                            {{ $footerSettingsArray['location']}}
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <p class="copyright">
                                {{ $footerSettingsArray['copyright']}}

                                <br>Design: <a rel="nofollow" href="https://www.tooplate.com" target="_parent">Tooplate</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="sub-footer">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="logo"><span>Art<em>Xibition</em></span></div>
                        </div>
                        <div class="col-lg-6">
                            <div class="menu">
                                <ul>
                                    @foreach($footerSettingsArray['menu'] as $label => $url)
                                    <li><a href="{{ $url }}">{{ $label }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="social-links">
                                <ul>
                                    @foreach($footerSettingsArray['social_links'] as $platform => $url)
                                    <li><a href="{{ $url }}"><i class="fa fa-{{ $platform }}"></i></a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</footer>