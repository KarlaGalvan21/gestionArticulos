@extends('layouts.app')

@section('template_title')
    Products
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __('Productos de oficina') }}
                        </span>

                        <div class="float-right">
                            <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm float-right">
                                {{ __('Crear Nuevo') }}
                            </a>
                        </div>
                    </div>
                </div>

                @if ($message = Session::get('success'))
                    <div class="alert alert-success m-4">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                <div class="card-body bg-white">

                    <div class="mb-3">
                        <label for="searchInput" class="form-label">Buscar producto por nombre</label>
                        <input 
                            type="text" 
                            id="searchInput" 
                            class="form-control" 
                            placeholder="Escribe el nombre del producto..."
                        >
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="products-table">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>
                                    <th>Sku</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Stock</th>
                                    <th>Precio</th>
                                    <th>Activo</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $product->sku }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->description }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->active }}</td>
                                        <td>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                                <a class="btn btn-sm btn-primary" href="{{ route('products.show', $product->id) }}">Ver</a>
                                                <a class="btn btn-sm btn-success" href="{{ route('products.edit', $product->id) }}">Editar</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {!! $products->withQueryString()->links() !!}
        </div>
    </div>
</div>

{{-- Solo filtrará los visibles en la página para busquedas en toda la BD utilizar otro método --}}
<script>
document.getElementById('searchInput').addEventListener('keyup', function () {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#products-table tbody tr');

    rows.forEach(function(row) {
        let nameCell = row.getElementsByTagName('td')[2];
        let nameText = nameCell.textContent.toLowerCase();

        if (nameText.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
@endsection