@extends('layouts.app')
@section('title', 'Pelanggan')

@section('content')
<section class="space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900">Daftar Pelanggan</h1>
    </div>

    @if($customers->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
            <p class="text-gray-600">Belum ada data pelanggan.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($customers as $customer)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex flex-col gap-3">
                    <div class="flex items-start justify-between gap-2">
                        <a href="{{ route('customers.show', $customer) }}" class="group">
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-700 transition">
                                {{ $customer->name }}
                            </h3>
                        </a>
                        <span class="text-xs text-gray-500">ID #{{ $customer->id }}</span>
                    </div>

                    <div class="mt-2 flex items-center gap-2">
                        <a href="{{ route('customers.show', $customer) }}"
                           class="inline-flex items-center px-3 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50">
                            Detail
                        </a>

                        <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="ml-auto"
                              onsubmit="return confirm('Hapus pelanggan ini? Data terkait mungkin ikut terhapus.')">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>Hapus</x-danger-button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        @if(method_exists($customers, 'links'))
            <div class="pt-6">
                {{ $customers->links() }}
            </div>
        @endif
    @endif
</section>
@endsection
