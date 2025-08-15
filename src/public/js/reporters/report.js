$(document).ready(function () {
  var regex = /^\(?-?\d+(\.\d+)?\s*,\s*-?\d+(\.\d+)?\)?$/;

  $("#coordinates").on("input", function () {
    var value = $(this).val().trim();
    if (!regex.test(value)) {
      $(this).addClass("is-invalid");
    } else {
      $(this).removeClass("is-invalid");
    }
  });

  $("#incidenceForm").on("submit", function (e) {
    var value = $("#coordinates").val().trim();

    if (!regex.test(value)) {
      e.preventDefault();
      $("#coordinates").focus();
    }
  });

  // Oculta los selects y labels al inicio excepto provincia

  $("#province").change(function () {
    var provinceId = $(this).val();
    // deshabilita municipio y barrio siempre al cambiar provincia
    $("#municipality, label[for='municipality']").prop("disabled", true);
    $("#neighborhood, label[for='neighborhood']").prop("disabled", true);
    $("#municipality").html('<option value=""></option>');
    $("#neighborhood").html('<option value=""></option>');

    if (!provinceId) return;

    $.getJSON("report.php", { action: "GET", province_id: provinceId })
      .done(function (municipalities) {
        if (municipalities.length > 0) {
          var html = '<option value="">Seleccione</option>';
          $.each(municipalities, function (_, mun) {
            html +=
              '<option value="' +
              mun.id +
              '">' +
              mun.municipality_name +
              "</option>";
          });
          $("#municipality").html(html);
          $("#municipality, label[for='municipality']").prop("disabled", false);
        } else {
          // Si no hay municipios, oculta municipio y barrio
          $("#municipality, label[for='municipality']").prop("disabled", true);
          $("#neighborhood, label[for='neighborhood']").prop("disabled", true);
        }
      })
      .fail(function () {
        $("#municipality, label[for='municipality']").prop("disabled", true);
        $("#neighborhood, label[for='neighborhood']").prop("disabled", true);
      });
  });

  $("#municipality").change(function () {
    var municipalityId = $(this).val();
    $("#neighborhood, label[for='neighborhood']").prop("disabled", true);
    $("#neighborhood").html('<option value=""></option>');

    if (!municipalityId) return;

    $.getJSON("report.php", {
      action: "GET",
      municipality_id: municipalityId,
    })
      .done(function (neighborhoods) {
        if (neighborhoods.length > 0) {
          var html = '<option value="">Seleccione</option>';
          $.each(neighborhoods, function (_, neigh) {
            html +=
              '<option value="' +
              neigh.id +
              '">' +
              neigh.neighborhood_name +
              "</option>";
          });
          $("#neighborhood").html(html);
          $("#neighborhood, label[for='neighborhood']").prop("disabled", false);
        } else {
          $("#neighborhood, label[for='neighborhood']").prop("disabled", true);
          $("#neighborhood").html('<option value="">No hay Barrios</option>');
        }
      })
      .fail(function () {
        $("#neighborhood, label[for='neighborhood']").prop("disabled", true);
      });
  });
  
  const $container = $("#photoUrlsContainer");
  const $addBtn = $("#addPhotoBtn");

  // Agregar nuevo campo para la imagen
  $addBtn.on("click", function () {
    const $newField = $(`
            <div class="input-group mb-2">
                <span class="input-group-text"><i class="bi bi-image"></i></span>
                <input name="photo_url[]" type="url" class="form-control" placeholder="https://ejemplo.com/imagen.jpg">
                <button type="button" class="btn btn-danger remove-photo-btn">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `);
    $container.append($newField);
  });

  // Quitar un campo
  $container.on("click", ".remove-photo-btn", function () {
    if ($container.children().length > 1) {
      $(this).closest(".input-group").remove();
    }
  });
});
