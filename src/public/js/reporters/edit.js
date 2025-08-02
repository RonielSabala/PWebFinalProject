$(document).ready(function () {
  $("#provincia").change(function () {
    var provinciaId = $(this).val();
    if (provinciaId != "") {
      $.get(
        "municipios.php",
        {
          provincia_id: provinciaId,
        },
        function (data) {
          $("#municipio").html(data);
        }
      );
    } else {
      $("#municipio").html(
        '<option value="">Seleccione una provincia</option>'
      );
    }
  });

  $("#municipio").change(function () {
    var id = $(this).val();
    if (id != "") {
      $.get(
        "barrios.php",
        {
          municipio_id: id,
        },
        function (data) {
          $("#barrio").html(data);
        }
      );
    } else {
      $("#barrio").html('<option value="">Seleccione un municipio</option>');
    }
  });
});
