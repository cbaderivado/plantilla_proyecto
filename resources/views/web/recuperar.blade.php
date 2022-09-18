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
        <div class="form_container">
          <form id="form1" action="{{route('recuperar.recuperar')}}" method="POST">
            <div class="row">
              <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
              <div class="row">
                <div class="form-group col-lg-12">
                  <label>Correo: *</label>
                  <input type="text" id="txtCorreo" name="txtNombre" class="form-control" value="" required>
                </div>
              </div>
              <div class="row col-lg-12">
                  <button class="btn btn-info">
                    Recuperar clave
                  </button>
                
              </div>
          </form>
        </div>
      
    
  </div>
  </div>
</section>
<!-- end book section -->
@endsection