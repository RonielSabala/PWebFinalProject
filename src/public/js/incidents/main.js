function initFilters() {
  // Búsqueda al cambiar cualquiera de los inputs
  $("#provinceFilter, #fromFilter, #toFilter, #labelFilter").on("change", renderIncidents);

  // Buscar al escribir titulo y presionar Enter
  $("#titleFilter").on("keydown", (e) => {
    if (e.key === "Enter") renderIncidents();
  });

  // Si el campo queda vacío, buscar
  $("#titleFilter").on("input", function () {
    if (this.value.trim() === "") {
      renderIncidents();
    }
  });

  // Botón de lupa
  $("#searchButton").on("click", renderIncidents);

  // Botón de las ultimas 24 horas
  init_toggle_button();
}

function init_toggle_button() {
  const toggle = document.getElementById("beautifulToggle");
  const label = document.getElementById("toggleLabel");
  const stateBadge = document.getElementById("beautifulToggleState");

  if (!toggle) return;

  function setFromToYesterday() {
    const now = new Date();
    now.setDate(now.getDate() - 1);
    const yyyy = now.getFullYear();
    const mm = String(now.getMonth() + 1).padStart(2, "0");
    const dd = String(now.getDate()).padStart(2, "0");
    const iso = `${yyyy}-${mm}-${dd}`;
    $("#fromFilter").val(iso);
  }

  function clearFrom() {
    $("#fromFilter").val("");
  }

  function updateToggleUI(checked) {
    if (checked) {
      label.classList.remove("off");
      stateBadge.textContent = "ON";
      setFromToYesterday();
    } else {
      label.classList.add("off");
      stateBadge.textContent = "OFF";
      clearFrom();
    }

    window.dispatchEvent(
      new CustomEvent("incidents:toggle", {
        detail: {
          visible: !!checked,
        },
      })
    );

    try {
      renderIncidents();
    } catch (err) {}
  }

  updateToggleUI(toggle.checked);
  toggle.addEventListener("change", (e) => updateToggleUI(e.target.checked));
}

function setDefaultDate() {
  const now = new Date();
  const yesterday = new Date(now.getTime() - 24 * 60 * 60 * 1000);
  $("#fromFilter").val(yesterday.toISOString().substring(0, 10));
}

function showModal(currentRoute, id) {
  // Obtener datos de la incidencia
  $.getJSON(currentRoute, {
    action: "GET",
    incidence_id: id,
  })
    .done(function (modalHtml) {
      $("#modalBody").html(modalHtml);
      $("#btnGoToIncidencePage").attr("href", `incidence.php?id=${id}`);
      $("#incidenceModal").modal("show");
      initCarousel($("#incidenceModal"));
    })
    .fail(function () {
      $("#modalBody").html("<p>Error al cargar incidencia.</p>");
      $("#incidenceModal").modal("show");
    });
}

function initCarousel($document) {
  $document.find(".container-carousel").each(function () {
    let $container = $(this);
    let $slides = $container.find(".slide");
    let $dots = $container.find(".dot");
    let $btnLeft = $container.find(".arrow-left");
    let $btnRight = $container.find(".arrow-right");
    let currentIndex = 0;

    function goToSlide(index) {
      if (index < 0) index = 0;
      if (index >= $slides.length) index = $slides.length - 1;
      currentIndex = index;

      let offset =
        $slides.eq(index).position().left +
        $container.find(".slider").scrollLeft();
      $container.find(".slider").animate({ scrollLeft: offset }, 300);

      $dots.removeClass("active").eq(index).addClass("active");
    }

    $dots.on("click", function () {
      goToSlide($(this).data("index"));
    });

    $btnLeft.on("click", function () {
      goToSlide(currentIndex - 1);
    });

    $btnRight.on("click", function () {
      goToSlide(currentIndex + 1);
    });

    goToSlide(0);
  });
}

// Iniciar carruseles fuera del modal
$(function () {
  initCarousel($(document));
});
