    <footer id="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="social-links pull-right">
                        <a href="https://github.com/UpstatePHP" class="social-link github" title="Contribute on GitHub">
                            @include('partials.svgs.github')
                            <div class="hexagon"></div>
                        </a>
                        <a href="https://www.facebook.com/groups/upstatepug" class="social-link facebook" title="Join the group on Facebook">
                            @include('partials.svgs.facebook')
                            <div class="hexagon"></div>
                        </a>
                        <a href="https://twitter.com/UpstatePHP" class="social-link twitter" title="Follow us on Twitter">
                            @include('partials.svgs.twitter')
                            <div class="hexagon"></div>
                        </a>
                        <a href="https://www.youtube.com/channel/UCnibunYYwTP3ZEJEqd-H7ug" class="social-link youtube" title="Subscribe to our channel on YouTube">
                            @include('partials.svgs.youtube')
                            <div class="hexagon"></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    {{ Orchestra\Asset::container('before-footer')->scripts() }}
    <script>window.jQuery || document.write('<script src="/js/vendor/jquery.min.js"><\/script>')</script>
    {{ Orchestra\Asset::container('footer')->scripts() }}
</body>
</html>