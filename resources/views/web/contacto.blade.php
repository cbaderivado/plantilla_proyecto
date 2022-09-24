@extends('web.plantilla')

@section('contenido')
<!-- book section -->
<section class="book_section layout_padding">
  <div class="container">
    <div class="heading_container">
      <h2>
        Book A Table
      </h2>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form_container">
          <form action="{{route('contacto.enviar')}}" method="POST">
            <div>
              <input type="text" id="txtNombre" name="txtNombre"class="form-control" placeholder="Nombre" />
            </div>
            <div>
              <input type="text" id="txtTelefono" name="txtTelefono"class="form-control" placeholder="Teléfono" />
            </div>
            <div>
              <input type="email" id="txtCorreo" name="txtCorreo" class="form-control" placeholder="Correo electronico" />
            </div>
            <div>
              <textarea type="text" id="txtMensaje" name="txtMensaje"class="form-control" placeholder="Mensaje"> </textarea>
            </div>
            <div class="btn_box">
              <button type="summit">
                Enviar
              </button>
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-6">
        <div class="map_container ">
          <div id="googleMap"></div>
        </div>
      </div>
      </form>
    </div>
  </div>
  </div>
  </div>
</section>
<!-- end book section -->
@endsection