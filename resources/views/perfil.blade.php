<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="../resources/css/estilo.css">

    <title>SeFerTour</title>
</head>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="{{ url('../resources/js/perfilEditar.js') }}"></script>


<body>
  <header>
    <nav class="navbar navbar-expand-sm navbar-dark static-top">
        <div class="container-fluid">
            <img src="{{url ('imagenes/logoanimado_blanco.gif') }}" alt="logo" width="25%">
            <button class="navbar-toggler text-black" type="button" data-toggle="collapse" data-target="#opciones">
              <img class="img-fluid "src="{{ url('imagenes/menu.png') }}" alt="menu" width="30">
            </button>
          <div class="collapse navbar-collapse " id="opciones">
            <ul class="navbar-nav ml-auto d-flex float-right text-right">
              <li class="nav-item active">
                <a class="nav-link text-white" href="{{ url('/') }}" id="link"><strong>{{ trans('texto.inicio') }}</strong></a>
              </li>
              <li class="nav-item text-white">
                <a class="nav-link text-white" href="{{ url('/tours') }}" id="link"><strong>{{ trans('texto.visit_guiadas') }}</strong></a>
              </li>

              <li><a class="m-3" href="{{ url('lang', ['es']) }}"><img class="img-fluid mt-3 border border-dark" src="{{url ('imagenes/espania.png')}}" alt="españa" width="25px" height="25px"></a></li>
              <li><a href="{{ url('lang', ['en']) }}"><img class="img-fluid mt-3 border border-dark mr-2" src="{{url ('imagenes/ingles.png')}}" alt="unitedKingdom" width="25px" height="25px"></a></li>

              <li class="nav-item dropdown d-flex flex-row-reverse">
                @if(Auth::user())
                  <a class="nav-link text-white" data-toggle="dropdown" href="{{ url('/') }}" role="button" >
                    @if( Auth::user()->foto )
                      <img src="{{ url('../storage/app/' . Auth::user()->foto) }}" alt="logo" width="25px" height="25px" class="rounded-circle">
                    @else
                      <img src="{{url('imagenes/perfil.png')}}" alt="logo" width="25px" class="rounded-circle">
                    @endif
                  </a>
                @else
                  <a class="nav-link text-white" data-toggle="dropdown" href="{{ url('/') }}" role="button" >
                    <img src="{{url('imagenes/perfil.png')}}" alt="logo" width="25px" class="rounded-circle">
                  </a>
                @endif
                <div class="dropdown-menu dropdown-menu-right">

                  @if(Auth::user())
                    <a class="dropdown-item" href="{{ url('perfil') }}">

                      <b>{{ Auth::user()->usuario }}</b>

                    </a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                      {{ trans('texto.salir') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                  @else
                    <a class="dropdown-item" href="{{ url('login') }}">{{ trans('texto.inicio_sesion') }}</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ url('register') }}">{{ trans('texto.registrar') }}</a>
                  @endif
                </div>
              </li>
            </ul>
          </div>
        </div>
    </nav>
  </header>

  @if ($errors->any())
    <div class="errors">
        <p><strong>Por favor corrige los siguientes errores<strong></p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="py-3">
      @if(Auth::user()->foto)
        <center>
          <img src="../storage/app/{{ Auth::user()->foto }}" alt="perfil" width="150" height="150" class="rounded-circle">
          <div class="col-12 my-2">
            <div class="row justify-content-center">

            <label class="mr-2">

            <a href="{{ url('/eliminarFoto') }}">
              @method('PUT')
               <img src="{{ url('imagenes/eliminar.png') }}" alt="eliminar" width="20" height="20">
            </a>
            </label>

            <form method="POST" action="{{ url('/nuevaFoto') }}" accept-charset="UTF-8" enctype="multipart/form-data" id="nuevaFotoUpload">
              @csrf
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <label>
                <input type="file" style="display: none;" name="foto" class="form-control @error('foto') is-invalid @enderror">
                <img src="{{ url('imagenes/cambio.png') }}" alt="añadir" width="20" height="20">
                  @error('foto')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </label>
            </form>
            </div>
            <script>
              document.getElementById("nuevaFotoUpload").onchange = function() {
                  document.getElementById("nuevaFotoUpload").submit();
              };
            </script>
          </div>
        </center>
      @else
        <center>
          <img src="{{ url('imagenes/perfil.png') }}" alt="perfil" width="150" height="150" class="rounded-circle">
          <div class="col-12 my-2">

            <form method="POST" action="{{ url('/nuevaFoto') }}" accept-charset="UTF-8" enctype="multipart/form-data" id="nuevaFotoUpload">
              @csrf
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <label>
                <input type="file" style="display: none;" name="foto" accept="image/*">
                <img src="{{ url('imagenes/añadir.png') }}" alt="eliminar" width="20" height="20">
             </label>
            </form>

            <script>
              document.getElementById("nuevaFotoUpload").onchange = function() {
                  document.getElementById("nuevaFotoUpload").submit();
              };
            </script>

          </div>
        </center>
      @endif
    </div>
    <div class="card container mt-3 mb-5" id="infoperfil">
        <div class="card-body">

            <h5 class="card-title text-center">{{ Auth::user()->usuario }}</h5>
            <p class="text-muted text-small mb-2">Nombre</p>
            <p class="mb-3">{{ Auth::user()->name }}</p>
            <p class="text-muted text-small mb-2">Apellido</p>
            <p class="mb-3">{{ Auth::user()->apellido }}</p>
            <p class="text-muted text-small mb-2">DNI</p>
            <p class="mb-3">{{ Auth::user()->dni }}</p>
            <p class="text-muted text-small mb-2">Email</p>
            <p class="mb-3">{{ Auth::user()->email }}</p>
            <p class="text-muted text-small mb-2">Tipo</p>
            <p class="mb-3">{{ Auth::user()->tipo }}</p>

            <form class="mb-3">
                <button type="button" onclick="muestraContenido()" class="btn mt-4" id="botonFormulario">Editar</button>
            </form>
        </div>
    </div>

    <div class="card container my-5" id="editPerfil">
      <div class="card-body">

          <form action="{{ route('editarPerfil') }}" method="POST" class="mb-3 mr-3">
            @method('PUT')
            @csrf
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{ Auth::user()->id }}">
            <p class="text-muted text-small mb-2">Nombre</p>
            <input type="text" required maxlength="25" class="mb-3" name="nombre" value="{{ Auth::user()->name }}">
            <p class="text-muted text-small mb-2">Apellido</p>
            <input type="text" class="mb-3" required maxlength="25" name="apellido" value="{{ Auth::user()->apellido }}">
            <p class="text-muted text-small mb-2">Usuario</p>
            <input type="text" class="mb-3" required maxlength="25" name="usuario" value="{{ Auth::user()->usuario }}">
            <p class="text-muted text-small mb-2">DNI</p>
            <input type="text" class="mb-3" required name="dni" value="{{ Auth::user()->dni }}">
            <p class="text-muted text-small mb-2">Email</p>
            <input type="email" class="mb-3" required maxlength="100" name="email" value="{{ Auth::user()->email }}">
            <p class="text-muted text-small mb-2">Tipo</p>
            <input type="text" disabled class="mb-3" name="tipo" value="{{ Auth::user()->tipo }}">
            
            <button type="button" class="btn mt-4 d-flex" id="botonFormulario" data-toggle="modal" data-target="#modal">Guardar</button>
            <button type="button" onclick="muestraEdit()" class="btn mt-4" id="botonCancelar">Cancelar</button>
            
            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Guardar cambios</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    ¿Estas seguro de que quieres guardar los cambios?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="botonFormulario">Guardar</button>
                  </div>
                </div>
              </div>
            </div>

          </form>
      </div>
  </div>



  <footer class="page-footer font-small bg-dark text-light">

    <div class="container text-center text-md-left d-flex">

      <div class="row mt-5">

        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">

          <h6 class="text-uppercase font-weight-bold">SeFerTour</h6>
          <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p>{{ trans('texto.descripcion') }}</p>

        </div>

        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">


          <h6 class="text-uppercase font-weight-bold">{{ trans('texto.redes') }}</h6>
          <hr class="accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p>
            <a href="#"><img src="{{url ('imagenes/insta.png')}}" alt="insta" width="20%"></a> Instagram
          </p>
          <p>
            <a href="#"><img src="{{url ('imagenes/facebook.png')}}" alt="facebook" width="20%"></a> Facebook
          </p>
          <p>
            <a href="#"><img src="{{url ('imagenes/twitter.png')}}" alt="twitter" width="20%"></a> Twitter
          </p>

        </div>

        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">

          <h6 class="text-uppercase font-weight-bold">{{ trans('texto.enlaces') }}</h6>
          <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p>
            <a href="#!">{{ trans('texto.cuenta') }}</a>
          </p>
          <p>
            <a href="#!">{{ trans('texto.registrar') }}</a>
          </p>

        </div>

        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">


          <h6 class="text-uppercase font-weight-bold">{{ trans('texto.contacto') }}</h6>
          <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p>Donostia, Gipuzkoa</p>
          <p>info@sefertour.com</p>
          <p>+ 34 234 567 88</p>
          <p>+ 34 234 567 89</p>

        </div>

      </div>
    </div>

    <div class="text-center py-3">© 2020 Copyright:
      <a href="#"> SeFerTour</a>
    </div>

  </footer>

</body>
</html>
