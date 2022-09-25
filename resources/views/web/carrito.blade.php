@extends('web.plantilla')
@section('contenido')
@if (isset($carrito))
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
</section>
<section class="about_section text-white mt-5">
  <div class="container">
    <div class="row">
      <div class="form-group col-lg-12">
      
      <table id="grilla" class=" table text-white display">
          <thead>
            <tr>
              <th colspan="2" class="text-center">Producto</th>

              <th>Cantidad</th>
              <th>Precio</th>
              <th>Subtotal</th>
              <th>Impuestos</th>
              <th>Total</th>
              <th>Sucursal</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><img width='50' height='50'class="img-fluid img-thumbnail"src="{{$producto->imagen}}" alt="imagen producto"></td>
              <td>{{$producto->descripcion}}</td>
              <td>{{$cantidad}}</td>
              <td>{{$producto->precio}}</td>
              <td>{{$subtotal}}</td>
              <td>{{$impuestos}}</td>
              <td>{{$total}}</td>
              <td>
                    <select id="lstSucursal" name="lstSucursal" class="form-control">
                        <option selected disabled>Seleccionar</option>
                        @foreach ($aSucursales as $item)
                        <option value="{{ $item->idsucursal }}">{{ $item->nombre }}</option>
                        @endforeach
              
                    </select>
              </td>
            </tr>
          </tbody>
        </table>
        
      </div>
    </div>
  </div>
  <div class="row">
</section>
@else
<section class="about_section layout_padding">
  <div class="container  ">

    <div class="row">
      <div class="col-md-6 ">
        <div class="img-box">
          <img src="images/about-img.png" alt="">
        </div>
      </div>
      <div class="col-md-6">
        <div class="detail-box">
          <div class="heading_container mb-5">
            <h2>
              El carrito esta vacio!
            </h2>
          </div>
          Aún no has cargado tu carrito, por favor ingresa a Takeaway y elige lo que gustes del menú
</p> 
 <a href="/takeaway">Elegir productos</a>
          <!-- <a href="">
              Read More
            </a> -->
        </div>
      </div>
    </div>
  </div>
</section>
@endif
@endsection

  