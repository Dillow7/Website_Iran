@extends('layouts.admin')

@section('title', 'Catégories | Admin')

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Catégories</h1>
        <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-500">
            Nouvelle catégorie
        </a>
    </div>

    <div class="mt-4 bg-white border border-slate-200 rounded overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="text-left font-medium p-3">Nom</th>
                    <th class="text-left font-medium p-3">Slug</th>
                    <th class="text-right font-medium p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($categories as $category)
                <tr class="border-t border-slate-100">
                    <td class="p-3 font-medium">{{ $category->name }}</td>
                    <td class="p-3 text-slate-600">{{ $category->slug }}</td>
                    <td class="p-3 text-right">
                        <a class="text-blue-700 hover:underline" href="{{ route('admin.categories.edit', $category) }}">Modifier</a>
                        <form class="inline" method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Supprimer cette catégorie ?');">
                            @csrf
                            @method('DELETE')
                            <button class="ml-3 text-red-700 hover:underline" type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="p-3" colspan="3">Aucune catégorie.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>
@endsection
