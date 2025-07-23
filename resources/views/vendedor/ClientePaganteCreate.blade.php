<x-app-layout>
    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">

                <form action="{{ route('vendedor.store') }}" enctype="multipart/form-data" method="post">
                    @csrf

                    <div>
                        <x-input-label for="nome" :value="__('Nome')" />
                        <x-text-input id="nome" class="block mt-1 w-full" type="text" name="nome" :value="old('nome')" />
                        <x-input-error :messages="$errors->get('nome')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="valor_contrato" :value="__('Valor do Contrato')" />
                        <x-text-input id="valor_contrato" class="block mt-1 w-full" type="text" inputmode="decimal" name="valor_contrato" :value="old('valor_contrato')" />
                        <x-input-error :messages="$errors->get('valor_contrato')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="UC_existente" :value="__('UC Existente?')" />
                        <select name="UC_existente" id="UC_existente" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="1" @selected(old('UC_existente', '1') == '1')>Sim</option>
                            <option value="0" @selected(old('UC_existente') == '0')>Não</option>
                        </select>
                        <x-input-error :messages="$errors->get('UC_existente')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        {{-- ALTERAÇÃO: O botão HTML foi substituído pelo seu componente Blade. --}}
                        <x-primary-button>
                            {{ __('Salvar') }}
                        </x-primary-button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- Script para validar o campo de valor (permite números e uma vírgula) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputValor = document.getElementById('valor_contrato');
            if (inputValor) {
                inputValor.addEventListener('input', function(e) {
                    let value = e.target.value;
                    value = value.replace(/[^0-9,]/g, '');
                    const parts = value.split(',');
                    if (parts.length > 2) {
                        value = parts[0] + ',' + parts.slice(1).join('');
                    }
                    e.target.value = value;
                });
            }
        });
    </script>
</x-app-layout>