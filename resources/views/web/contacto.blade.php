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
        <div class="col-md-12">
          <div class="form_container">
            <form action="">
              <div>
                <input type="text" class="form-control" placeholder="Nombre" />
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Teléfono" />
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Correo electronico" />
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Mensaje" />
              </div>
              <div class="btn_box">
                <button >
                  Enviar
                </button>
              </div>
            </form>
          </div>
        </div>
        
      </div>
    </div>
  </section>
  <!-- end book section -->
@endsection
  