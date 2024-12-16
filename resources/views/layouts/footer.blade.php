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
                        @foreach ($footerSettingsArray['open_hours'] as $openHour)
                        <li>{{ $openHour['value'] }}</li>
                        @endforeach
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
                                    @foreach($footerSettingsArray['menu'] as $menuItem)
                                    <li><a href="#">{{ $menuItem['value'] }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="social-links">
                                <ul>
                                    @foreach($footerSettingsArray['social_links'] as $socialLink)
                                    <li><a href="{{ $socialLink['value'] }}"><i class="fa fa-{{ $socialLink['key'] }}"></i></a></li>
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