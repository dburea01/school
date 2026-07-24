@extends('layout')

@section('title', 'The Author')

@section('content')

<div class="row">
    <h1 class="text-center">The Author</h1>
</div>
<div class="row mt-3">
    <div class="col-md-4 offset-md-2">
        <div style="width:200px" class="mx-auto">
            <img src="img/photo_auteur_small.png" alt="" width="140" height="145">
        </div>
    </div>
    <div class="col-md-4">
        <strong>Identity: </strong>Dominique BUREAU (Dom)<br>
        <strong>Status: </strong>Married, 2 grown-up children<br>
        <strong>CV: </strong>Not looking for anything at all !<br>
        <strong>Motto: </strong>Make every day count <em>(Jack Dawson)</em><br>
        <strong>Passion: </strong>Web development (oh, if only it had been invented earlier...)
    </div>

</div>

<h2 class="text-center mt-5">For Techno Fans</h2>

<div class="row">
    <div class="col-md-8 offset-md-2">

        <p>For techno fans, the site <strong>{{ config('app.name') }}</strong> was developed in <a
                href="https://en.wikipedia.org/wiki/PHP" target="_blank" class="link-dark">PHP</a>.
            With the amazing framework <a href="http://laravel.com" target="_blank">Laravel</a>.</p>

        <p>I'm not an artist in the rendering of my pages but I try to make the user experience pleasant
            using <a href="https://getbootstrap.com/" target="_blank">Bootstrap</a>.
            And of course, I don’t forget smartphone users, those little devices where people with big fingers are not helped!</p>

        <p>Concerned about the planet's future, I try to make the site as <em>green</em> as possible. Thus all
            pages of the site are W3C valid (<a href="https://www.loginradius.com/blog/engineering/w3c-validation"
                target="_blank">Why is this important ?</a>).
            And all pages have a "Lighthouse" score close to 100% (<a
                href="https://www.nixondigital.io/insights/understanding-lighthouse-scores-why-they-matter-for-your-websites-success-and-how-to-improve-them/"
                target="_blank">Why is this important ?</a>).</p>

        <p>The solution is hosted on <a href="https://cloud.laravel.com/" target="_blank">cloud laravel</a>.</p>

        <p>Despite all my efforts, if you encounter problems (even bugs...), or if you have functional or technical
            suggestions about <strong>{{ config('app.name') }}</strong>, you can <a
                href="/contact-the-author">contact me</a>. Small messages of encouragement are
            also welcome.</p>



    </div>
</div>

<h2 class="text-center mt-5">History</h2>

<div class="row">
    <div class="col-md-6 offset-md-3">

        <table class="table">
            <tr>
                <td>February 26</td>
                <td>Idea is born</td>
            </tr>
            <tr>
                <td>February 26 > July 26</td>
                <td>Development</td>
            </tr>
            <tr>
                <td>August 26</td>
                <td>V0 (beta) in production</td>
            </tr>
        </table>
    </div>
</div>
@endsection