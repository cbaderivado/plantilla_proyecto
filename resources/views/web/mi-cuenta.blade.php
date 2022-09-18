@extends('web.plantilla')
@section('contenido')
@if(isset($msg))
<div class="alert alert-danger d-flex align-items-center" role="alert">
  <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:">
    <use xlink:href="#exclamation-triangle-fill" />
  </svg>
  <div>
    {{$msg["MSG"]}}
  </div>
</div>
@endif
<section class="book_section layout_padding">
  <div class="container">
    <div class="heading_container">
      <h2 class="about_section">
        Iniciar sesión
      </h2>
    </div>
    <div class="row">

      <div class="col-md-12">
        <div class="form_container">
          <form id="form1" action="{{route('miCuenta.ingresar')}}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
            <div class="row">
              <div class="form-group col-lg-6">
                <label class="about_section">Correo: *</label>
                <input type="text" id="txtCorreo" name="txtCorreo" class="form-control" value="" required>

                <label class="about_section">Contraseña: *</label>
                <input type="password" id="txtPassword" name="txtPassword" class="form-control" value="" required>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-lg-2">
                <button type="summit">
                  Ingresar
                </button>
              </div>

            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-lg-4">
        <a class="text-white btn btn-info" href="/registracion">Registrarse</a>
      </div>
      <div class="col-lg-4">
        <a class="text-white  btn btn-info" href="/recuperar">Olvide la Contraseña</a>
      </div>
    </div>
  </div>
  </div>


</section>

@endsection