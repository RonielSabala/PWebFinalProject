$(document).ready(function () {
  // Oculta los selects y labels al inicio excepto provincia
  $("#municipality, label[for='municipality']").hide();
  $("#neighborhood, label[for='neighborhood']").hide();

  $("#province").change(function () {
    var provinceId = $(this).val();
    // Oculta municipio y barrio siempre al cambiar provincia
    $("#municipality, label[for='municipality']").hide();
    $("#neighborhood, label[for='neighborhood']").hide();
    $("#municipality").html('<option value="">Seleccione</option>');
    $("#neighborhood").html('<option value="">Seleccione</option>');

    if (!provinceId) return;

    $.getJSON("edit_incidence.php", { action: "GET", province_id: provinceId })
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
          $("#municipality, label[for='municipality']").show();
        } else {
          // Si no hay municipios, oculta municipio y barrio
          $("#municipality, label[for='municipality']").hide();
          $("#neighborhood, label[for='neighborhood']").hide();
        }
      })
      .fail(function () {
        $("#municipality, label[for='municipality']").hide();
        $("#neighborhood, label[for='neighborhood']").hide();
      });
  });

  $("#municipality").change(function () {
    var municipalityId = $(this).val();
    $("#neighborhood, label[for='neighborhood']").hide();
    $("#neighborhood").html('<option value="">Seleccione</option>');

    if (!municipalityId) return;

    $.getJSON("edit_incidence.php", {
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
          $("#neighborhood, label[for='neighborhood']").show();
        } else {
          $("#neighborhood, label[for='neighborhood']").hide();
        }
      })
      .fail(function () {
        $("#neighborhood, label[for='neighborhood']").hide();
      });
  });
});
