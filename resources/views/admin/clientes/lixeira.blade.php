<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lixeira de Clientes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            &larr; Voltar para o Dashboard
                        </a>
                    </div>
                    
                    @forelse ($clientes as $cliente)
                        <div class="flex justify-between items-center p-4 border-b">
                            <div>
                                <p class="font-bold">{{ $cliente->nome }}</p>
                                <p class="text-sm text-gray-600">
                                    Excluído em: {{ $cliente->deleted_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            <div class="flex space-x-2">
                                <form action="{{ route('admin.cliente.restore', $cliente->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Restaurar
                                    </button>
                                </form>

                                <form action="{{ route('admin.cliente.forceDelete', $cliente->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Tem certeza que deseja excluir este cliente para sempre? Esta ação não pode ser desfeita.')">
                                        Excluir Permanentemente
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="p-4">A lixeira está vazia.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>