@extends('web.plantilla')

@section('contenido')
<!-- book section -->
<section class="about_section layout_padding">
  <div class="container">
    <div class="heading_container mb-5">
      <h2>
        Ingrese sus datos:
      </h2>
    </div>
    <div class="row mt-5">
      <div class="col-md-6">
        <div class="form_container">
          <form id="form1" action="{{route('registracion.guardarCliente')}}" method="POST">
            <div class="row">
              <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>

              <div class="form-group col-lg-6">
                <label>Nombre: *</label>
                <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="" required>
              </div>
              <div class="form-group col-lg-6">
                <label>Apellido: *</label>
                <input type="text" id="txtApellido" name="txtApellido" class="form-control" value="" required>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-lg-6">
                <label>Documento: *</label>
                <input type="text" id="txtDni" name="txtDni" class="form-control" value="" required>
              </div>
              <div class="form-group col-lg-6">
                <label>Celular: *</label>
                <input type="text" id="txtCelular" name="txtCelular" class="form-control" value="" required>
              </div>
            </div>
            <div class="row">

              <div class="form-group col-lg-6">
                <label>Correo: *</label>
                <input type="text" id="txtCorreo" name="txtCorreo" class="form-control" value="" required>
              </div>
              <div class="form-group col-lg-6">
                <label>Clave: *</label>
                <input type="text" id="txtClave" name="txtClave" class="form-control" value="" required>
              </div>
            </div>
            <div class="form-group col-lg-4">
              <button>
                Registrarse
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