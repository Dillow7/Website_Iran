@extends('layouts.admin')

@section('title', 'Créer un article | Admin')

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Créer un article</h1>
        <a href="{{ route('admin.articles.index') }}" class="text-sm text-slate-700 hover:underline">Retour</a>
    </div>

    <form class="mt-4 bg-white border border-slate-200 rounded p-4" method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium">Titre (max 60)</label>
                <input name="title" value="{{ old('title') }}" class="mt-1 w-full rounded border-slate-300" required maxlength="60">
                @error('title')<div class="text-sm text-red-700 mt-1">{{ $message }}</div>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Catégorie</label>
                <select name="category_id" class="mt-1 w-full rounded border-slate-300" required>
                    <option value="">-- Choisir --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<div class="text-sm text-red-700 mt-1">{{ $message }}</div>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Date de publication</label>
                <input type="datetime-local" name="published_at" value="{{ old('published_at') }}" class="mt-1 w-full rounded border-slate-300">
                @error('published_at')<div class="text-sm text-red-700 mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium">Extrait (max 200)</label>
                <textarea name="excerpt" class="mt-1 w-full rounded border-slate-300" rows="2" maxlength="200">{{ old('excerpt') }}</textarea>
                @error('excerpt')<div class="text-sm text-red-700 mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium">Contenu (HTML autorisé)</label>
                <textarea name="content" class="mt-1 w-full rounded border-slate-300 font-mono" rows="10" required>{{ old('content') }}</textarea>
                @error('content')<div class="text-sm text-red-700 mt-1">{{ $message }}</div>@enderror
                <p class="text-xs text-slate-500 mt-1">Conseil SEO : évite les &lt;h1&gt; dans le contenu, commence plutôt à &lt;h2&gt;.</p>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium">Meta description (max 160)</label>
                <input name="meta_description" value="{{ old('meta_description') }}" class="mt-1 w-full rounded border-slate-300" maxlength="160">
                @error('meta_description')<div class="text-sm text-red-700 mt-1">{{ $message }}</div>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Image</label>
                <input type="file" name="image" class="mt-1 w-full">
                @error('image')<div class="text-sm text-red-700 mt-1">{{ $message }}</div>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Alt image (SEO)</label>
                <input name="alt_image" value="{{ old('alt_image') }}" class="mt-1 w-full rounded border-slate-300" maxlength="125">
                @error('alt_image')<div class="text-sm text-red-700 mt-1">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mt-4 flex items-center gap-3">
            <button class="px-4 py-2 rounded bg-slate-900 text-white hover:bg-slate-800" type="submit">Créer</button>
            <a class="text-sm text-slate-700 hover:underline" href="{{ route('admin.articles.index') }}">Annuler</a>
        </div>
    </form>
@endsection
