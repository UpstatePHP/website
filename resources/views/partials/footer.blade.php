<footer id="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="social-links pull-right">
                    <a href="https://github.com/UpstatePHP" class="social-link github" target="_blank" title="Contribute on GitHub">
                        @include('partials.svgs.github')
                        <div class="hexagon"></div>
                    </a>
                    <a href="https://www.facebook.com/groups/upstatepug" class="social-link facebook" target="_blank" title="Join the group on Facebook">
                        @include('partials.svgs.facebook')
                        <div class="hexagon"></div>
                    </a>
                    <a href="https://twitter.com/UpstatePHP" class="social-link twitter" target="_blank" title="Follow us on Twitter">
                        @include('partials.svgs.twitter')
                        <div class="hexagon"></div>
                    </a>
                    <a href="https://www.youtube.com/channel/UCnibunYYwTP3ZEJEqd-H7ug" class="social-link youtube" target="_blank" title="Subscribe to our channel on YouTube">
                        @include('partials.svgs.youtube')
                        <div class="hexagon"></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

{!! Asset::container('before-footer')->scripts() !!}

<script>window.jQuery || document.write('<script src="/js/gmaps/jquery.min.js"><\/script>')</script>

{!! Asset::container('footer')->scripts() !!}
