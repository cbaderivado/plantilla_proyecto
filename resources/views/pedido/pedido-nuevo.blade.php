@extends('plantilla')
@section('titulo', "$titulo")
@section('scripts')
<script>
    globalId = '<?php echo isset($aPedidos->idpedido) && $aPedidos->idpedido > 0 ? $aPedidos->idpedido : 0; ?>';
    <?php $globalId = isset($aPedidos->idpedido) ? $aPedidos->idpedido : "0";
    ?>
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/pedidos">Pedidos</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/pedido/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    @if($globalId > 0)
    <li class="btn-item"><a title="Eliminar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
    @endif
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
    function fsalir() {
        location.href = "/admin/";
    }
</script>
@endsection
@section('contenido')
<?php


if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div class="panel-body">
    <div id="msg"></div>
    <?php
    if (isset($msg)) {
        echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
    }
    ?>

    <form id="form1" method="POST">
        <div class="row">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
            <input type="hidden" name="txtEstadoPago" value="3"></input>
            <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
            <div class="form-group col-lg-6">
                <label>Fecha: *</label>
                
                <input type="date" id="txtFecha" name="txtfecha" class="form-control" value="{{strtotime($aPedidos->fecha)}}" required>
                
            </div>

            <div class="form-group col-lg-6">
                <label>Descripcion: *</label>
                <input type="text" id="txtDescripcion" name="txtDescripcion" class="form-control" value="{{$aPedidos->descripcion}}" required>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-6">
                <label>Sucursal:</label>
                <select id="lstSucursal" name="lstSucursal" class="form-control">

                    @if($globalId>0)
                    <option selected value="{{ $aPedidos->fk_idsucursal }}">{{ $aPedidos->sucursal }}</option>
                    @else
                    <option selected disabled>Seleccionar</option>
                    @endif
                    @foreach ($aSucursales as $item)
                    <option value="{{ $item->idsucursal }}">{{ $item->nombre }}</option>
                    @endforeach

                </select>
            </div>
            <div class="form-group col-lg-6">
                <label>Cliente:</label>
                <select id="lstCliente" name="lstCliente" class="form-control">
                    @if ($globalId>0)
                    <option selected value="{{ $aPedidos->fk_idcliente }}">{{ $aPedidos->cliente }}</option>
                    @else
                    <option selected disabled>Seleccionar</option>

                    @endif
                    @foreach ($aClientes as $item)
                    <option value="{{ $item->idcliente }}">{{ $item->nombre }}</option>
                    @endforeach


                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-6">
                <label>Estado:</label>
                <select id="lstEstado" name="lstEstado" class="form-control">
                    @if ($globalId>0)
                    <option selectedvalue="{{ $aPedidos->fk_idestado }}">{{ $aPedidos->estado }}</option>
                    @else
                    <option selected disabled>Seleccionar</option>

                    @endif
                    @foreach ($aEstados as $item)
                    <option value="{{ $item->idestado }}">{{ $item->nombre }}</option>
                    @endforeach


                </select>
            </div>

            <div class="form-group col-lg-6">
                <label>Total: *</label>
                <input type="text" id="txtTotal" name="txtTotal" class="form-control" value="{{ $aPedidos->total }}" required>
            </div>
        </div>
        <div class="modal fade" id="mdlEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Eliminar registro?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">¿Deseas eliminar el registro actual?</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
                        <button type="button" class="btn btn-primary" onclick="eliminar();">Sí</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $("#form1").validate();

            function guardar() {
                if ($("#form1").valid()) {
                    modificado = false;
                    form1.submit();
                } else {
                    $("#modalGuardar").modal('toggle');
                    msgShow("Corrija los errores e intente nuevamente.", "danger");
                    return false;
                }
            }

            function eliminar() {
                $.ajax({
                    type: "GET",
                    url: "{{ asset('admin/pedido/eliminar') }}",
                    data: {
                        id: globalId
                    },
                    async: true,
                    dataType: "json",
                    success: function(data) {
                        mensaje = "";
                        tipo = "";

                        if (data.err == "0") {
                            mensaje = "Registro eliminado exitosamente.";
                            tipo = "success";
                            quitarcartel(mensaje, tipo);
                            location.href = '/admin/pedidos';
                        } else {
                            mensaje = data.err;
                            tipo = "danger";
                            quitarcartel(mensaje, tipo);
                        }
                    }
                });
            }

            function quitarcartel(mensaje, tipo) {
                msgShow(mensaje, tipo);
                $("#btnEnviar").hide();
                $("#btnEliminar").hide();
                $('#mdlEliminar').modal('toggle');
            }
        </script>

    </form>
</div>

@endsection