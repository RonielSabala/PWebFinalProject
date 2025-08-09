(function () {
  const userSelect = document.getElementById("user_id");
  const roleSelect = document.getElementById("role_id");

  const previewAvatar = document.getElementById("previewAvatar");
  const previewName = document.getElementById("previewName");
  const previewEmail = document.getElementById("previewEmail");
  const previewRoleBadge = document.getElementById("previewRoleBadge");
  const previewId = document.getElementById("previewId");
  const previewRolesText = document.getElementById("previewRolesText");

  function initials(name) {
    if (!name) return "U";
    const parts = name.trim().split(/\s+/);
    return (
      (parts[0][0] || "").toUpperCase() +
      (parts[1] ? parts[1][0].toUpperCase() : "")
    );
  }

  function updatePreview() {
    const opt = userSelect.selectedOptions[0];
    const id = opt.value;
    const text = opt.textContent.trim();
    const email = opt.dataset.email || "—";
    const roles = opt.dataset.roles || "—";

    // Text from option is "username — email", split
    const username = text.split("—")[0] ? text.split("—")[0].trim() : text;

    previewAvatar.textContent = initials(username);
    previewName.textContent = username;
    previewEmail.textContent = email;
    previewId.textContent = id;
    previewRolesText.textContent = roles;

    // Role badge shows roleSelect value text
    const selectedRoleText = roleSelect.selectedOptions[0]?.textContent || "—";
    previewRoleBadge.textContent = selectedRoleText;
    // change badge color a bit by mapping some names — simple heuristic
    const nameLower = selectedRoleText.toLowerCase();
    previewRoleBadge.className = "badge badge-role";
    if (nameLower.includes("admin"))
      previewRoleBadge.classList.add("bg-danger", "text-white");
    else if (nameLower.includes("manager") || nameLower.includes("gestor"))
      previewRoleBadge.classList.add("bg-warning", "text-dark");
    else previewRoleBadge.classList.add("bg-success", "text-white");
  }

  userSelect.addEventListener("change", updatePreview);
  roleSelect.addEventListener("change", updatePreview);

  // Inicializar preview al cargar
  document.addEventListener("DOMContentLoaded", updatePreview);
})();
