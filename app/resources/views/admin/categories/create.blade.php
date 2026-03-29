@extends('layouts.admin')

@section('title', 'Créer une catégorie | Admin')

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Créer une catégorie</h1>
        <a href="{{ route('admin.categories.index') }}" class="text-sm text-slate-700 hover:underline">Retour</a>
    </div>

    <form class="mt-4 bg-white border border-slate-200 rounded p-4" method="POST" action="{{ route('admin.categories.store') }}">
        @csrf

        <div>
            <label class="block text-sm font-medium">Nom</label>
            <input name="name" value="{{ old('name') }}" class="mt-1 w-full rounded border-slate-300" required maxlength="80">
            @error('name')<div class="text-sm text-red-700 mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="mt-4 flex items-center gap-3">
            <button class="px-4 py-2 rounded bg-slate-900 text-white hover:bg-slate-800" type="submit">Créer</button>
            <a class="text-sm text-slate-700 hover:underline" href="{{ route('admin.categories.index') }}">Annuler</a>
        </div>
    </form>
@endsection
