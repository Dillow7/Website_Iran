@extends('layouts.admin')

@section('title', 'Articles | Admin')

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Articles</h1>
        <a href="{{ route('admin.articles.create') }}" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-500">
            Nouvel article
        </a>
    </div>

    <div class="mt-4 bg-white border border-slate-200 rounded overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="text-left font-medium p-3">Titre</th>
                    <th class="text-left font-medium p-3">Catégorie</th>
                    <th class="text-left font-medium p-3">Publié</th>
                    <th class="text-right font-medium p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($articles as $article)
                <tr class="border-t border-slate-100">
                    <td class="p-3">
                        <div class="font-medium">{{ $article->title }}</div>
                        <div class="text-slate-500">/{{ $article->slug }}</div>
                    </td>
                    <td class="p-3">{{ $article->category?->name }}</td>
                    <td class="p-3">
                        @if($article->published_at)
                            <span class="inline-flex items-center rounded px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200">Oui</span>
                        @else
                            <span class="inline-flex items-center rounded px-2 py-0.5 bg-slate-50 text-slate-600 border border-slate-200">Brouillon</span>
                        @endif
                    </td>
                    <td class="p-3 text-right">
                        <a class="text-blue-700 hover:underline" href="{{ route('admin.articles.edit', $article) }}">Modifier</a>
                        <form class="inline" method="POST" action="{{ route('admin.articles.destroy', $article) }}" onsubmit="return confirm('Supprimer cet article ?');">
                            @csrf
                            @method('DELETE')
                            <button class="ml-3 text-red-700 hover:underline" type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="p-3" colspan="4">Aucun article.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $articles->links() }}
    </div>
@endsection
