<x-app-layout>
    {{-- Container Flex para o Header e o Conteúdo Principal --}}
    <div class="flex flex-col">

        {{-- Slot do Header --}}
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Área do Vendedor') }}
                </h2>

                <a href="{{ route('vendedor.ClientePaganteCreate') }}">
                    <x-primary-button>
                        Adicionar Cliente
                    </x-primary-button>
                </a>
            </div>
        </x-slot>

        {{-- Conteúdo Principal (Cards) --}}
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        {{-- Grid de Cards --}}
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @forelse ($clientesPagantes as $cliente)
                                <a href="#" class="group block p-6 rounded-lg border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:bg-gray-900 hover:shadow-xl hover:border-white dark:bg-gray-700 dark:border-gray-600 dark:hover:bg-gray-900">

                                    <h5 class="text-xl font-bold mb-2 text-gray-900 group-hover:text-white transition-colors duration-300 dark:text-white">
                                        {{ $cliente->nome ?? 'Nome do Cliente' }}
                                    </h5>

                                    <p class="text-gray-800 group-hover:text-gray-200 transition-colors duration-300 dark:text-gray-300 dark:group-hover:text-gray-200">
                                        {{-- Exemplo de como formatar o valor como moeda --}}
                                        R$ {{ number_format($cliente->valor_contrato ?? 0, 2, ',', '.') }}
                                    </p>

                                    <p class="mt-2 text-sm text-gray-600 group-hover:text-gray-300 transition-colors duration-300 dark:text-gray-400 dark:group-hover:text-gray-300">
                                        UC existente?:
                                        {{ $cliente->UC_existente ? 'Sim' : ($cliente->UC_existente === 0 ? 'Não' : 'Não informado') }}
                                    </p>
                                </a>
                            @empty
                                <div class="col-span-1 md:col-span-2 lg:col-span-3 p-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-center">
                                    <p class="text-gray-500 dark:text-gray-400">
                                        Nenhum cliente pagante encontrado no momento.
                                    </p>
                                </div>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>`