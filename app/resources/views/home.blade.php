@extends('layouts.app')
@section('title', 'Accueil | Iran News')
@section('content')
    <h1>Actualités</h1>
    @forelse($articles as $article)
        <article>
            <h2>
                <a href="{{ route('article.show', [$article->category, $article]) }}">{{ $article->title }}</a>
            </h2>
            <p>{{ $article->excerpt }}</p>
        </article>
    @empty
        <p>Aucun article publié pour le moment.</p>
    @endforelse
    {{ $articles->links() }}
    <aside>
        <h2>Catégories</h2>
        <ul>
            @foreach($categories as $cat)
                <li><a href="{{ route('category.show', $cat) }}">{{ $cat->name }} ({{ $cat->articles_count }})</a></li>
            @endforeach
        </ul>
    </aside>
@endsection
