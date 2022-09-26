@extends('web.plantilla')
@section('contenido')
<?php
$paginaPrevia = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
if ($paginaPrevia == 'http://127.0.0.1:8000/takeaway') {
  $paginaPrevia = '/takeaway';
}

?>


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
@if(isset($msg))

<div class="offset-2 col-6">
  <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
      <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
    </symbol>
  </svg>
  <div class="alert alert-danger d-flex align-items-center" role="alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
      <use xlink:href="#exclamation-triangle-fill" />
    </svg>
    <div class="ml-5">
      <strong>{{$msg["MSG"]}}</strong>
    </div>
  </div>
</div>
@endif
<section class="about_section text-white mt-5">
  <div class="container">
    <div class="row">
      <div class="form-group col-lg-12">

        <table id="grilla" class=" table text-white display">
          <thead>
            <tr>
              <th colspan="2" class="text-center">Producto</th>

              <th class="text-center">Cantidad</th>
              <th class="text-center">Precio</th>
              <th class="text-center">Subtotal</th>
              <th class="text-center">Impuestos</th>
              <th class="text-center">Total</th>
              <th class="text-center">Sucursal de retiro</th>
              <th class="text-center">Medio de pago</th>
              <th colspan="2" class="text-center">Acciones</th>

            </tr>
          </thead>
          <tbody>
            <tr>
              <td><img width='50' height='50' class="img-fluid img-thumbnail" src="{{$producto->imagen}}" alt="imagen producto"></td>
              <td>{{$producto->nombre}}</td>
              <td class="text-right">{{$carrito->cantidad}}</td>
              <td class="text-right">${{number_format($producto->precio,2,",",".")}}</td>
              <td class="text-right">${{number_format($totales['subtotal'],2,",",".")}}</td>
              <td class="text-right">${{number_format($totales['impuestos'],2,",",".")}}</td>
              <td class="text-right">${{number_format($totales['total'],2,",",".")}}</td>
              <td>
                <form class="m-1" id="formGuardar" action="{{route('carrito.guardarPedido')}}" method="POST">

                  <select id="lstSucursal" name="lstSucursal" class="form-control" required>
                    <option selected disabled>Seleccionar</option>
                    @foreach ($aSucursales as $item)
                    <option value="{{ $item->idsucursal }}">{{ $item->nombre }}</option>
                    @endforeach

                  </select>
              </td>
              <td>
                <select id="lstMediosdePago" name="lstMedioDePago" class="form-control" required>
                  <option selected disabled>Seleccionar</option>
                  <option value="1">Mercado Pago</option>
                  <option value="2">Pago en sucursal</option>
                </select>
              </td>

              <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
              <input type="text" name="id" id="id" value="{{$carrito->idcarrito}}"></input>
              <td><button data-bs-toggle="tooltip" data-bs-placement="top" title="Pagar" class="text-white btn btn-info" type="summit"><svg width="20" height="20" style="fill:rgb(255,255,255)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                    <path d="M64 0C46.3 0 32 14.3 32 32V96c0 17.7 14.3 32 32 32h80v32H87c-31.6 0-58.5 23.1-63.3 54.4L1.1 364.1C.4 368.8 0 373.6 0 378.4V448c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V378.4c0-4.8-.4-9.6-1.1-14.4L488.2 214.4C483.5 183.1 456.6 160 425 160H208V128h80c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H64zM96 48H256c8.8 0 16 7.2 16 16s-7.2 16-16 16H96c-8.8 0-16-7.2-16-16s7.2-16 16-16zM64 432c0-8.8 7.2-16 16-16H432c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16zm48-216c13.3 0 24 10.7 24 24s-10.7 24-24 24s-24-10.7-24-24s10.7-24 24-24zm72 24c0-13.3 10.7-24 24-24s24 10.7 24 24s-10.7 24-24 24s-24-10.7-24-24zm-24 56c13.3 0 24 10.7 24 24s-10.7 24-24 24s-24-10.7-24-24s10.7-24 24-24zm120-56c0-13.3 10.7-24 24-24s24 10.7 24 24s-10.7 24-24 24s-24-10.7-24-24zm-24 56c13.3 0 24 10.7 24 24s-10.7 24-24 24s-24-10.7-24-24s10.7-24 24-24zm120-56c0-13.3 10.7-24 24-24s24 10.7 24 24s-10.7 24-24 24s-24-10.7-24-24zm-24 56c13.3 0 24 10.7 24 24s-10.7 24-24 24s-24-10.7-24-24s10.7-24 24-24z" />
                  </svg></button></td>
              </form>
              <form class="m-1" id="formEliminar" action="{{route('carrito.cancelarPedido')}}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                <input type="text" name="id" id="id" value="{{$carrito->idcarrito}}"></input>
                <td><button data-bs-toggle="tooltip" data-bs-placement="top" title="Cancelar" class="text-white btn btn-info" type="summit"><svg width="20" height="20" style="fill:rgb(255,255,255)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                      <!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                      <path d="M367.2 412.5L99.5 144.8C77.1 176.1 64 214.5 64 256c0 106 86 192 192 192c41.5 0 79.9-13.1 111.2-35.5zm45.3-45.3C434.9 335.9 448 297.5 448 256c0-106-86-192-192-192c-41.5 0-79.9 13.1-111.2 35.5L412.5 367.2zM512 256c0 141.4-114.6 256-256 256S0 397.4 0 256S114.6 0 256 0S512 114.6 512 256z" />
                    </svg></button></td>
              </form>
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
          Aún no has cargado tu carrito, por favor ingresa a Takeaway y elige lo que gustes del menú.
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