(function () {
  const toggle = document.getElementById("togglePassword");
  const pwd = document.getElementById("password");
  if (!toggle || !pwd) return;
  toggle.addEventListener("click", () => {
    const isHidden = pwd.type === "password";
    pwd.type = isHidden ? "text" : "password";
    toggle.setAttribute("aria-pressed", String(isHidden));
    toggle.setAttribute(
      "aria-label",
      isHidden ? "Ocultar contraseña" : "Mostrar contraseña"
    );
    const icon = toggle.querySelector("i");
    if (icon)
      icon.classList.toggle("bi-eye"), icon.classList.toggle("bi-eye-slash");
  });
})();
