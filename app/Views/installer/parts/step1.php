<div class="d-flex flex-column justify-content-center align-items-center box-content">
    <div id="spinner" class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
    <p id="spinnerMessage">Checking Requirements...</p>
    <i id="finalIcon" class="bi bi-check-circle" style="font-size: 3rem; color: green; display: none"></i>
    <i id="errorIcon" class="bi bi-x-circle" style="font-size: 3rem; color: red; display: none"></i>
    <p id="finalMessage"></p>
    <a href="javascript:void(0)" id="showError" data-bs-toggle="modal" data-bs-target="#errorModal" style="display: none" class="btn btn-danger">Show Error</a>
</div>

<!-- Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="errorModalLabel">Error Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="errorDetails"></div>
      </div>
    </div>
  </div>
</div>