@extends('web.plantilla')

@section('contenido')
<section class="about_section">
  <div class="container">
    <div class="row">
      <div class="form-group col-lg-2 mr-3">
        <label>Nombre:</label>
        <input disabled type="text" id="txtNombre" name="txtNombre" class="form-control" value="{{$cliente->nombre}}" required>
      </div>
      <div class="form-group col-lg-2 mr-3">
        <label>Apellido:</label>
        <input disabled type="text" id="txtApellido" name="txtApellido" class="form-control" value="{{$cliente->apellido}}" required>
      </div>
      <div class="form-group col-lg-2 mr-3">
        <label>Documento:</label>
        <input disabled type="text" id="txtDni" name="txtDni" class="form-control" value="{{$cliente->dni}}" required>
      </div>
      <div class="form-group col-lg-2 mr-3">
        <label>Celular:</label>
        <input disabled type="text" id="txtCelular" name="txtCelular" class="form-control" value="{{$cliente->celular}}" required>
      </div>
      <div class="form-group col-lg-2 mr-3">
        <label>Correo:</label>
        <input disabled type="text" id="txtCorreo" name="txtCorreo" class="form-control" value="{{$cliente->correo}}" required>
      </div>
    </div>
  </div>
</section>
<section class="about_section text-white">
  <div class="container">
    <div class="row">
      <div class="form-group col-lg-12">
        <table id="grilla" class="display">
          <thead>
            <tr>
              <th>Fecha</th>
              <th>Descripcion</th>
              <th>Sucursal</th>
              <th>Estado</th>
              <th>Estado pago</th>
              <th>Total</th>

            </tr>
          </thead>
          <tbody>
            @foreach ($aPedidos as $item)
            <tr>
              <td>{{$item->fecha}}</td>
              <td>{{$item->descripcion}}</td>
              <td>{{$item->sucursal}}</td>
              <td>{{$item->estado}}</td>
              <td>{{$item->estadoPago}}</td>
              <td>{{$item->total}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

@endsection