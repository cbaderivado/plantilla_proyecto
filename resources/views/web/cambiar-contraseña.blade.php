@extends('web.plantilla')

@section('contenido')
<!-- book section -->
<section class="about_section layout_padding">
  <div class="container">
    <div class="heading_container mb-5">
      <h2>
        Escriba su contraseña actual y la nueva:
      </h2>
    </div>
    @if(isset($msg))
    <div class="col-4">
      <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
          <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
      </svg>
      <div class="alert alert-danger d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
          <use xlink:href="#exclamation-triangle-fill" />
        </svg>
        <div class="ml-2">
          <strong> {{$msg["MSG"]}}</strong>
        </div>
      </div>
    </div>

    @endif

    <div class="row mt-5">
      <div class="col-md-6">
        <div class="form_container">
          <form id="form1" action="{{route('miCuenta.actualizarClave')}}" method="POST">
            <div class="row">
              <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
              <div class="form-group col-lg-6">
                <label>Contraseña actual: *</label>
                <input type="password" id="txtClaveActual" name="txtClaveActual" class="form-control" value="" required>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-lg-6">
                <label>Clave: *</label>
                <input type="password" id="txtClaveNueva" name="txtClaveNueva" class="form-control" value="" required>
              </div>
            </div>

            <div class="form-group col-lg-4">
              <button class="text-white btn btn-info" type="summit">
                Actualizar
              </button>

            </div>

          </form>
        </div>


      </div>
    </div>
  </div>
  </div>
</section>
<!-- end book section -->
@endsection