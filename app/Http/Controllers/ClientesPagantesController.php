<?php

namespace App\Http\Controllers;

use App\Models\clientesPagantes;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\PostCondition;

class ClientesPagantesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
       public function dashboardVendedor()
    {
        $clientesPagantes = clientesPagantes::orderBy('created_at', 'DESC')->get();

        // ✅ Retorna a view do VENDEDOR
        return view('vendedor.dashboard', [
            'clientesPagantes' => $clientesPagantes
        ]);
    }

    /**
     * Mostra o painel do ADMIN.
     */
    public function dashboardAdmin()
    {
        // Você pode ter uma lógica diferente para o admin se precisar
        $todosOsClientes = clientesPagantes::orderBy('created_at', 'DESC')->get();

        // ✅ Retorna a view do ADMIN
        return view('admin.dashboard', [
            // A variável na view do admin também se chamará 'clientesPagantes'
            // para que o @forelse funcione sem alterações.
            'clientesPagantes' => $todosOsClientes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendedor.ClientePaganteCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Formata o input ANTES de passar para a validação.
        // Isso transforma "1.500,75" em "1500.75"
        $request->merge([
            'valor_contrato' => str_replace(',', '.', str_replace('.', '', $request->input('valor_contrato')))
        ]);

        // 2. Agora valide os dados já formatados.
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            // REGRAS DE VALIDAÇÃO PARA O NÚMERO:
            'valor_contrato' => [
                'required',
                'numeric', // Garante que é um número válido
                'max:999999999999999.9999' // 15 dígitos antes do ponto, 4 depois
            ],
            'UC_existente' => 'required|boolean',
        ]);

        $data['user_id'] = auth()->id();

        // 3. Se a validação passar, o código continua e cria o registro.
        clientesPagantes::create($data);

        return redirect()->back()->with('success', 'Cliente salvo!');
    }

    /**
     * Display the specified resource.
     */
    public function show(clientesPagantes $clientesPagantes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(clientesPagantes $clientesPagantes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, clientesPagantes $clientesPagantes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(clientesPagantes  $cliente)
    {
        $cliente->delete();

        // Redireciona de volta para o dashboard com uma mensagem de sucesso.
        return redirect()->route('admin.dashboard')
                         ->with('success', 'Cliente excluído com sucesso!');
    }
}
