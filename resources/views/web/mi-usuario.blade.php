@extends('web.plantilla')

@section('contenido')
<section class="about_section">
  <div class="container">
    <div class="row">
      <div class="form-group col-lg-2">
        <label>Nombre:</label>
        <input disabled type="text" id="txtNombre" name="txtNombre" class="form-control" value="{{$cliente->nombre}}" required>
      </div>
      <div class="form-group col-lg-2">
        <label>Apellido:</label>
        <input disabled type="text" id="txtApellido" name="txtApellido" class="form-control" value="{{$cliente->apellido}}" required>
      </div>
      <div class="form-group col-lg-2">
        <label>Documento:</label>
        <input disabled type="text" id="txtDni" name="txtDni" class="form-control" value="{{$cliente->dni}}" required>
      </div>
      <div class="form-group col-lg-2">
        <label>Celular:</label>
        <input disabled type="text" id="txtCelular" name="txtCelular" class="form-control" value="{{$cliente->celular}}" required>
      </div>
      <div class="form-group col-lg-2">
        <label>Correo:</label>
        <input disabled type="text" id="txtCorreo" name="txtCorreo" class="form-control" value="{{$cliente->correo}}" required>
      </div>
      <div class="form-group col-lg-2">
        <div class="row">
          <a class="text-white btn btn-info pl-3 pr-3 mt-3 fs-6 " href="/actualizar-datos">Actualizar datos</a>
        </div>
        <div class="row">
          <a class="text-white btn btn-info pl-3 pr-3 mt-3  fs-6" href="/cambiar-contraseña">Cambiar contraseña</a>
        </div>
      </div>
  </div>
</section>
<section class="about_section text-white mt-5">
  <div class="container">
    <div class="row">
      <div class="form-group col-lg-12">
      @if(isset($aPedidos))  
      <table id="grilla" class=" table text-white display">
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
        @else
        <p class="text-white">Sin pedidos registrados</p>
        @endif  
      </div>
    </div>
  </div>
</section>

@endsection