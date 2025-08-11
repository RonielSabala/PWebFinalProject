    <!-- Modal -->
    <div class="modal fade" id="incidenceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-fullscreen-md-down">
            <div class="modal-content border-0 shadow-lg">
                <!-- Header -->
                <div class="modal-header p-3 align-items-start bg-incident">
                    <div class="d-flex align-items-center gap-3 w-100">
                        <div class="modal-hero-avatar" aria-hidden="true">
                            <!-- icono opcional -->
                            <i class="bi bi-exclamation-circle-fill"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="modal-title mb-0" id="incidenceModalLabel">Detalles de incidencia</h5>
                        </div>

                        <!-- Close -->
                        <button type="button" class="btn-close ms-3" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                </div>

                <!-- Body -->
                <div class="modal-body p-0">
                    <div id="modalBody" class="p-4 modal-body-content">
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer d-flex align-items-center">
                    <a id="btnGoToIncidencePage" class="btn btn-primary me-auto" href="#" rel="noopener noreferrer">
                        Abrir en otra pestaña
                    </a>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const incidents = <?= json_encode($incidents) ?>;
</script>