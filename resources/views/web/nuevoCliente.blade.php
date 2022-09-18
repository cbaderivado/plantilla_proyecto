@extends('web.plantilla')
@section('contenido')
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
              Somos Burguer SRL
            </h2>
          </div>
          <p>
            Se ha dado de alta el nuevo usuario con exito! En unos instantes recibirá un correo para activar su cuenta. Si no lo recibe en los próximos minutos, revise su carpeta de spam.
          </p>
          <a href="/">Regresar a la web</a>
          <!-- <a href="">
              Read More
            </a> -->
        </div>
      </div>
    </div>
  </div>
</section>
<p clas="about_section">
@endsection