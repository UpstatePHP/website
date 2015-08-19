@extends('layouts.main')

@section('body')
<div class="container">
    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-content hero">
                    <div class="page-header">
                        <h1>Sponsors</h1>
                    </div>
                    @foreach ($sponsors as $sponsor)
                        <div class="col-lg-4 sponsor">
                            <div class="thumbnail">
                                @if ($sponsor->type === 'supporter')
                                <div class="supporter-ribbon">Supporter</div>
                                @endif
                                <a href="{!! $sponsor->url !!}" target="_blank">
                                    <img src="/uploads/{!! $sponsor->logo !!}" title="{!! $sponsor->name !!}">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <aside id="sidebar" class="col-lg-3">
            <section class="sidebar-widget">
                <h2>Support Our Sponsors</h2>
                <div class="sidebar-item-body">
                    <p>
                        UpstatePHP would not be what it is without everyone who has supported us along the way,
                        and we want to in turn support them. Click on a logo to visit a sponsors website.
                    </p>
                </div>
            </section>
            <section class="sidebar-widget">
                <h2>Become a Sponsor</h2>
                <div class="sidebar-item-body">
                    <p>
                        If you'd like to become a sponsor or supporter of UpstatePHP, please <a href="#contact-modal" data-toggle="modal">contact us</a>.
                    </p>
                </div>
            </section>
        </aside>
    </div>
</div>

@include('partials.contact-modal', ['contactSubject' => 'sponsorship'])

@stop
