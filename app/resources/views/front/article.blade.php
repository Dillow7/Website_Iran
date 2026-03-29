@extends('layouts.app')

@section('title', $article->title . ' | Iran News')

@section('content')
    <nav aria-label="Fil d'Ariane">
        <ol>
            <li><a href="{{ route('home') }}">Accueil</a></li>
            <li><a href="{{ route('category.show', $category) }}">{{ $category->name }}</a></li>
            <li aria-current="page">{{ $article->title }}</li>
        </ol>
    </nav>

    <article>
        <h1>{{ $article->title }}</h1>

        <p>
            Publié le {{ optional($article->published_at)->format('d/m/Y') }}
            par {{ $article->user?->name }}
        </p>

        @if($article->image)
            <figure>
                <img
                    src="{{ asset('storage/' . $article->image) }}"
                    alt="{{ $article->alt_image ?? $article->title }}"
                    width="800"
                    height="450"
                    loading="lazy"
                >
            </figure>
        @endif

        <div class="article-content">
            {!! $article->content !!}
        </div>
    </article>

    @if($related->count())
        <section>
            <h2>Articles liés</h2>
            @foreach($related as $item)
                <article>
                    <h3>
                        <a href="{{ route('article.show', [$item->category, $item]) }}">{{ $item->title }}</a>
                    </h3>
                    <p>{{ $item->excerpt }}</p>
                </article>
            @endforeach
        </section>
    @endif
@endsection
