document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById("icon_url");
  const preview = document.querySelector('img[alt="etiqueta"]');

  // placeholder SVG (no requests externos)
  const placeholder =
    "data:image/svg+xml;charset=UTF-8," +
    encodeURIComponent(
      `<svg xmlns="http://www.w3.org/2000/svg" width="150" height="150">
      <rect width="100%" height="100%" fill="#f8f9fa"/>
      <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#6c757d" font-size="14">Sin imagen</text>
    </svg>`
    );

  if (!input || !preview) return;

  function normalizeUrl(url) {
    if (!url) return "";
    url = url.trim();
    if (url.startsWith("//")) return "https:" + url;
    if (/^(data:|blob:|https?:\/\/)/i.test(url)) return url;
    if (url.startsWith("www.")) return "https://" + url;
    // si parece una url con punto, añadir https por defecto
    if (/\S+\.\S+/.test(url) && !/\s/.test(url)) return "https://" + url;
    return url; // devolver tal cual si no encaja en ninguna heurística
  }

  let dt;
  function scheduleUpdate() {
    clearTimeout(dt);
    dt = setTimeout(updatePreview, 250);
  }

  function updatePreview() {
    const raw = input.value || "";
    const url = normalizeUrl(raw);
    if (!url) {
      preview.src = placeholder;
      return;
    }
    preview.src = url;
    preview.dataset.tryUrl = url;
    preview.classList.add("loading");
  }

  input.addEventListener("input", scheduleUpdate);
  input.addEventListener("change", updatePreview);
  input.addEventListener("paste", () => setTimeout(scheduleUpdate, 50));

  preview.addEventListener("load", () => {
    preview.classList.remove("loading");
  });
  preview.addEventListener("error", () => {
    preview.classList.remove("loading");
    preview.src = placeholder;
  });

  updatePreview();
});
