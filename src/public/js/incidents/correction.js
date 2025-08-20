$(document).ready(function () {
  var regex = /^\(?-?\d+(\.\d+)?\s*,\s*-?\d+(\.\d+)?\)?$/;

  var editingProvinceId = $("#province").val();
  var editingMunicipalityId = $("#municipality").data('editing-municipality');
  var editingNeighborhoodId = $("#neighborhood").data('editing-neighborhood');

  if (editingProvinceId) {
    loadMunicipalities(editingProvinceId, editingMunicipalityId);
  }

  if (editingMunicipalityId && editingNeighborhoodId) {
    loadNeighborhoods(editingMunicipalityId, editingNeighborhoodId);
  }

  function loadMunicipalities(provinceId, selectedMunicipalityId = null) {
    $("#municipality, label[for='municipality']").prop("disabled", true);
    $("#neighborhood, label[for='neighborhood']").prop("disabled", true);
    $("#municipality").html('<option value=""></option>');
    $("#neighborhood").html('<option value=""></option>');

    if (!provinceId) return;

    $.getJSON("correction.php", { action: "GET", province_id: provinceId })
      .done(function (municipalities) {
        if (municipalities.length > 0) {
          var html = '<option value="">Seleccione</option>';
          $.each(municipalities, function (_, mun) {
            var selected = (selectedMunicipalityId && mun.id == selectedMunicipalityId) ? 'selected' : '';
            html += '<option value="' + mun.id + '" ' + selected + '>' + mun.municipality_name + '</option>';
          });
          $("#municipality").html(html);
          $("#municipality, label[for='municipality']").prop("disabled", false);

        } else {
          $("#municipality, label[for='municipality']").prop("disabled", true);
          $("#neighborhood, label[for='neighborhood']").prop("disabled", true);
        }
      })
      .fail(function () {
        $("#municipality, label[for='municipality']").prop("disabled", true);
        $("#neighborhood, label[for='neighborhood']").prop("disabled", true);
      });
  }

  function loadNeighborhoods(municipalityId, selectedNeighborhoodId = null) {
    $("#neighborhood, label[for='neighborhood']").prop("disabled", true);
    $("#neighborhood").html('<option value=""></option>');

    if (!municipalityId) return;

    $.getJSON("correction.php", {
      action: "GET",
      municipality_id: municipalityId,
    })
      .done(function (neighborhoods) {
        if (neighborhoods.length > 0) {
          var html = '<option value="">Seleccione</option>';
          $.each(neighborhoods, function (_, neigh) {
            var selected = (selectedNeighborhoodId && neigh.id == selectedNeighborhoodId) ? 'selected' : '';
            html += '<option value="' + neigh.id + '" ' + selected + '>' + neigh.neighborhood_name + '</option>';
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
  }

  $("#coordinates").on("input", function () {
    var value = $(this).val().trim();
    if (!regex.test(value)) {
      $(this).addClass("is-invalid");
    } else {
      $(this).removeClass("is-invalid");
    }
  });

  $("#correctionForm").on("submit", function (e) {
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
    loadMunicipalities(provinceId);
  });

  $("#municipality").change(function () {
    var municipalityId = $(this).val();
    $("#neighborhood, label[for='neighborhood']").prop("disabled", true);
    $("#neighborhood").html('<option value=""></option>');

    if (!municipalityId) return;
    loadNeighborhoods(municipalityId);
  });
});


