@extends('layouts.app')

@section('title', 'Kelola Pengguna Platform')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <div class="flex items-center justify-between border-b border-zinc-200 pb-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-zinc-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-zinc-900">Admin Control</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <span class="text-zinc-900 font-semibold">Pengguna Platform</span>
            </div>
            <h1 class="font-display text-2xl sm:text-3xl font-extrabold text-zinc-900">
                Kelola Pengguna
            </h1>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-zinc-200/80 p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-zinc-100 text-zinc-400 uppercase tracking-wider font-semibold">
                        <th class="pb-3">User</th>
                        <th class="pb-3">Email</th>
                        <th class="pb-3">Peran / Role</th>
                        <th class="pb-3">Telepon</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @foreach($users as $user)
                        <tr class="hover:bg-zinc-50 transition">
                            <td class="py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $user->avatar ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=80&q=80' }}" 
                                         alt="{{ $user->name }}" class="w-8 h-8 rounded-full object-cover border border-zinc-100">
                                    <span class="font-bold text-zinc-900">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="py-4 text-zinc-600 font-mono">{{ $user->email }}</td>
                            <td class="py-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase
                                    {{ $user->isAdmin() ? 'bg-purple-100 text-purple-700' : ($user->isSeller() ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700') }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="py-4 text-zinc-600">{{ $user->phone ?? '-' }}</td>
                            <td class="py-4">
                                @if($user->status === 'active')
                                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-800 text-[10px] font-bold">
                                        Ditangguhkan (Suspended)
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 text-right">
                                @if($user->id !== Auth::id())
                                    <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-lg text-[11px] font-bold transition
                                            {{ $user->status === 'active' ? 'bg-rose-50 text-rose-600 hover:bg-rose-100' : 'bg-emerald-50 text-emerald-600 hover:bg-emerald-100' }}">
                                            {{ $user->status === 'active' ? 'Suspend Akun' : 'Aktifkan Akun' }}
                                        </button>
                                    </form>
                                @else
                                    <span class="text-[10px] text-zinc-400 italic">Akun Anda</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pt-4 border-t border-zinc-100">
            {{ $users->links() }}
        </div>
    </div>

</div>
@endsection
