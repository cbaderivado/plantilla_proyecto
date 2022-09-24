@extends('web.plantilla')
@section('contenido')
<?php 
$paginaPrevia=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
$paginaPrevia=$paginaPrevia=='http://127.0.0.1:8000/takeaway'?'/takeaway':'';
?>
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
            <input type="hidden"  id="paginaPrevia" name="paginaPrevia"value="{{$paginaPrevia}}" /></input>
            <div class="row">
              <div class="form-group col-lg-6">
                <label class="about_section">Correo: *</label>
                <input type="text" id="txtCorreo" name="txtCorreo" class="form-control" value="" required>

                <label class="about_section">Contraseña: *</label>
                <input type="password" id="txtPassword" name="txtPassword" class="form-control" value="" required>
              </div>
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
                <div>
                  <strong>{{$msg["MSG"]}}</strong>
                </div>
              </div>
            </div>

            @endif
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