@extends('layouts.app')

@section('title', $category->name . ' | Iran News')

@section('content')
    <h1>{{ $category->name }}</h1>

    @forelse($articles as $article)
        <article>
            <h2>
                <a href="{{ route('article.show', [$category, $article]) }}">{{ $article->title }}</a>
            </h2>
            <p>{{ $article->excerpt }}</p>
        </article>
    @empty
        <p>Aucun article publié dans cette catégorie.</p>
    @endforelse

    {{ $articles->links() }}
@endsection
