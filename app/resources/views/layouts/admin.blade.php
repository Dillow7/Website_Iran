<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin | Iran News')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="min-h-screen flex">
        <aside class="w-64 bg-white border-r border-slate-200 hidden md:block">
            <div class="px-4 py-4 border-b border-slate-200">
                <a href="{{ route('admin.home') }}" class="font-semibold">Iran News — Admin</a>
            </div>

            <nav class="p-3">
                <a href="{{ route('admin.articles.index') }}" class="block px-3 py-2 rounded hover:bg-slate-100 {{ request()->routeIs('admin.articles.*') ? 'bg-slate-100 font-medium' : '' }}">
                    Articles
                </a>
                <a href="{{ route('admin.categories.index') }}" class="block mt-1 px-3 py-2 rounded hover:bg-slate-100 {{ request()->routeIs('admin.categories.*') ? 'bg-slate-100 font-medium' : '' }}">
                    Catégories
                </a>
            </nav>
        </aside>

        <div class="flex-1">
            <header class="bg-white border-b border-slate-200">
                <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
                    <div class="md:hidden">
                        <span class="font-semibold">Admin</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-slate-600">{{ auth()->user()?->email }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm px-3 py-1.5 rounded bg-slate-900 text-white hover:bg-slate-800">
                                Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="max-w-6xl mx-auto p-4">
                @if(session('success'))
                    <div class="mb-4 rounded border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-900">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
