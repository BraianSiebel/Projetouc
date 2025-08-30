<x-app-layout>
    {{-- Container Flex para o Header e o Conteúdo Principal --}}
    <div class="flex flex-col">

        {{-- Slot do Header --}}
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Área do Administrador') }}
                </h2>

                {{-- ÁREA DOS BOTÕES ATUALIZADA --}}
                <div class="flex items-center space-x-2">
                    <a href="{{ route('register') }}">
                        <x-secondary-button>
                            Registrar Novo Usuário
                        </x-secondary-button>
                    </a>

                    <a href="{{ route('vendedor.ClientePaganteCreate') }}">
                        <x-primary-button>
                            Adicionar Cliente
                        </x-primary-button>
                    </a>

                    {{-- BOTÃO DA LIXEIRA ADICIONADO AQUI --}}
                    <a href="{{ route('admin.cliente.lixeira') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{-- Ícone de Lixeira SVG --}}
                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.134-2.033-2.134H8.033C6.91 2.75 6 3.664 6 4.834v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                        Lixeira
                    </a>
                </div>
            </div>
        </x-slot>


        {{-- Conteúdo Principal --}}
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                {{-- Bloco para exibir mensagens de sucesso (Ex: após excluir um cliente) --}}
                @if (session('success'))
                    <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                        role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        {{-- Grid de Cards --}}
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @forelse ($clientesPagantes as $cliente)
                                {{-- Card como DIV para conter o formulário --}}
                                <div
                                    class="block p-6 rounded-lg border border-gray-200 bg-white shadow-sm dark:bg-gray-700 dark:border-gray-600">

                                    {{-- Conteúdo original do card --}}
                                    <h5 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">
                                        {{ $cliente->nome ?? 'Nome do Cliente' }}
                                    </h5>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                        Vendedor: {{ $cliente->user?->name ?? 'Vendedor não encontrado' }}
                                    </p>
                                    <p class="text-gray-800 dark:text-gray-200">
                                        R$ {{ number_format($cliente->valor_contrato ?? 0, 2, ',', '.') }}
                                    </p>
                                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                        UC existente?:
                                        {{ $cliente->UC_existente ? 'Sim' : ($cliente->UC_existente === 0 ? 'Não' : 'Não informado') }}
                                    </p>

                                    {{-- Botão de Exclusão (agora sempre visível) --}}
                                    <div class="mt-4 flex justify-end">
                                        <form method="POST" action="{{ route('admin.cliente.destroy', $cliente) }}"
                                            onsubmit="return confirm('Tem certeza que deseja excluir este cliente?');">
                                            @csrf
                                            @method('DELETE')
                                            {{-- Botão sem as classes de opacidade --}}
                                            <button type="submit"
                                                class="px-3 py-1 text-xs font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                Excluir
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div
                                    class="col-span-1 md:col-span-2 lg:col-span-3 p-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-center">
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
</x-app-layout>