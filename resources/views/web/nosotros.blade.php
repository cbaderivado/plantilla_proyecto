@extends('web.plantilla')
<?php
?>
@section('contenido')
<!-- about section -->

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
          <div class="heading_container">
            <h2>
              Somos Burguer SRL
            </h2>
          </div>
          <p>
            Ignoro quiénes son, pero sé que uno de ellos profetizó, en la hora de su muerte, que alguna vez llegaría mi redentor. Desde entonces no me duele la soledad, porque sé que vive mi redentor y al fin se levantará sobre el polvo.
          </p>
          <!-- <a href="">
              Read More
            </a> -->
        </div>
      </div>
    </div>
  </div>
</section>

<!-- end about section -->


<!-- client section -->

<section class="client_section layout_padding-bottom">
  <div class="container">
    <div class="heading_container heading_center pseudo_white_primary mb_45">
      <h2 class="about_section">
        Se dice de mí....
      </h2>
    </div>
    <div class="carousel-wrap row ">
      <div class="owl-carousel client_owl-carousel">
        <div class="item">
          <div class="box">
            <div class="detail-box">
              <p>
                Todavía no me recupero de la indigestión con la carne de gusano. Si van mejor lleven hepatalgina forte
              </p>
              <h6>
                Moana Michell
              </h6>
              <p>
                Sucursal Caballito
              </p>
            </div>
            <div class="img-box">
              <img src="web/images/client1.jpg" alt="" class="box-img">
            </div>
          </div>
        </div>
        <div class="item">
          <div class="box">
            <div class="detail-box">
              <p>
                Hubiera sido mejor que usarán aceite de motor y no el aceite quemado del mes pasado, todavía no me saco el sabor de las papas de la boca.
              </p>
              <h6>
                Mike Hamell
              </h6>
              <p>
                Sucursal Floresta
              </p>
            </div>
            <div class="img-box">
              <img src="web/images/client2.jpg" alt="" class="box-img">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- end client section -->


<section class="book_section layout_padding">
  <div class="container">
    <div class="heading_container">
      <h2 class="about_section">
        Trabajá con nosotros
      </h2>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form_container">
          <form id="form1" action="{{route('nosotros.guardarPostulacion')}}" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
            <div class="row">
              <div class="form-group col-lg-6">
                <label class="about_section">Nombre: *</label>
                <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="" required>
              </div>
              <div class="form-group col-lg-6">
                <label class="about_section">Apellido: *</label>
                <input type="text" id="txtApellido" name="txtApellido" class="form-control" value="" required>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-lg-6">
                <label class="about_section">Documento: *</label>
                <input type="text" id="txtDocumento" name="txtDocumento" class="form-control" value="" required>
              </div>
              <div class="form-group col-lg-6">
                <label class="about_section">Localidad: *</label>
                <input type="text" id="txtLocalidad" name="txtLocalidad" class="form-control" value="" required>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-lg-6">
                <label class="about_section">Telefono: *</label>
                <input type="text" id="txtTelefono" name="txtTelefono" class="form-control" value="" required>
              </div>
              <div class="form-group col-lg-6">
                <label class="about_section">Correo: *</label>
                <input type="text" id="txtCorreo" name="txtCorreo" class="form-control" value="" required>
              </div>

            </div>
            <div class="row">
              <div class="form-group col-lg-6">
                <label class="about_section">Adjuntar Curriculum: *</label>
                <input type="file" id="txtArchivoCv" name="txtArchivoCv" class="form-control-file about_section" value="" required>
              </div>
            </div>
            <button id="btnEnviar" name="btnEnviar" type="summit">
              Enviar CV
            </button>
        </div>
        </form>
      </div>
    </div>

  </div>
  </div>
</section>

@endsection