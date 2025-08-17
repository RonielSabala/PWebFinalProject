document.addEventListener("click", function (e) {
  if (e.target.closest("#toggleFirst")) {
    const btn = e.target.closest(".togglePassword");
    const input = document.getElementById("password");
    const icon = btn.querySelector("i");
    input.type = input.type === "password" ? "text" : "password";
    icon.classList.toggle("bi-eye");
    icon.classList.toggle("bi-eye-slash");
  }
  if (e.target.closest("#toggleConfirm")) {
    const btn = e.target.closest(".togglePassword");
    const input = document.getElementById("confirm_password");
    const icon = btn.querySelector("i");
    input.type = input.type === "password" ? "text" : "password";
    icon.classList.toggle("bi-eye");
    icon.classList.toggle("bi-eye-slash");
  }
});

(function () {
  const codeInput = document.getElementById("code");
  if (codeInput) {
    codeInput.addEventListener("input", function () {
      this.value = this.value.replace(/\D/g, "").slice(0, 6);
    });
  }
})();
