<?php

namespace App\Http\Controllers;

use App\Models\clientesPagantes;
use Illuminate\Http\Request;

class ClientesPagantesController extends Controller
{
    
    public function dashboardVendedor()
    {
        $clientesPagantes = clientesPagantes::orderBy('created_at', 'DESC')->get();
        return view('vendedor.dashboard', [
            'clientesPagantes' => $clientesPagantes
        ]);
    }
 
    public function dashboardAdmin()
    {
        $todosOsClientes = clientesPagantes::orderBy('created_at', 'DESC')->get();
        return view('admin.dashboard', [
            'clientesPagantes' => $todosOsClientes
        ]);
    }


    public function create()
    {
        return view('vendedor.ClientePaganteCreate');
    }


    public function store(Request $request)
    {
        $request->merge([
            'valor_contrato' => str_replace(',', '.', str_replace('.', '', $request->input('valor_contrato')))
        ]);

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'valor_contrato' => ['required', 'numeric', 'max:999999999999999.9999'],
            'UC_existente' => 'required|boolean',
        ]);

        $data['user_id'] = auth()->id();

        clientesPagantes::create($data);

//redirect p pagina correta
if (auth()->user()->role === 'admin') {
    return redirect()->route('admin.dashboard')->with('success', 'Cliente adicionado com sucesso!');
} else {
    return redirect()->route('vendedor.dashboard')->with('success', 'Cliente adicionado com sucesso!');
}    }

    //funcao soft delete
    public function destroy(clientesPagantes $cliente)
    {
        $cliente->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Cliente movido para a lixeira!');
    }
//moste a pag da lixeira
    public function lixeira()
    {
        $clientesExcluidos = clientesPagantes::onlyTrashed()->orderBy('deleted_at', 'DESC')->get();
        return view('admin.clientes.lixeira', ['clientes' => $clientesExcluidos]);
    }

    ///restaura da liexira
    public function restore($id)
    {
        $cliente = clientesPagantes::withTrashed()->findOrFail($id);
        $cliente->restore();

        return redirect()->route('admin.cliente.lixeira')->with('success', 'Cliente restaurado com sucesso!');
    }

  //perma remove cliente
    public function forceDelete($id)
    {
        $cliente = clientesPagantes::withTrashed()->findOrFail($id);
        $cliente->forceDelete();

        return redirect()->route('admin.cliente.lixeira')->with('success', 'Cliente excluído permanentemente!');
    }
}