@extends('web.plantilla')
<?php $sucu = 0; ?>

@section('contenido')
<!-- slider section -->
<section class="slider_section ">
  <div id="customCarousel1" class="carousel slide" data-ride="carousel">

    <div class="carousel-inner">
      @foreach ($aSucursales as $item)
      @if ($sucu==0)
      <div class="carousel-item active">
        <?php $sucu = 1; ?>
      @else
      <div class="carousel-item">
      @endif
          <div class="container ">
            <div class="row">
              <div class="col-md-7 col-lg-6 ">
                <div class="detail-box">
                  <h1>
                    Sucursal {{$item->nombre}}
                  </h1>
                  <p>
                    <a target="_blank" href="{{$item->linkmapa}}">Direccion: {{$item->direccion}}</a>
                  </p>
                  <p>
                    Pedir ahora al {{$item->telefono}}
                  </p>
                  <div class="btn-box">
                    <a href="/carrito" class="btn1">
                      Pedir ahora
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div>
      @endforeach
      </div>
      <div class="container">
        <ol class="carousel-indicators">
          <li data-target="#customCarousel1" data-slide-to="0" class="active"></li>
          <li data-target="#customCarousel1" data-slide-to="1"></li>
          <li data-target="#customCarousel1" data-slide-to="2"></li>
        </ol>
      </div>
      <a class="carousel-control-prev" href="#customCarousel1" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#customCarousel1" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
    

  </div>
</section>
<!-- end slider section -->
</div>
@endsection