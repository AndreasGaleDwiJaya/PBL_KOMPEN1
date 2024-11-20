<div class="modal-dialog" style="max-width: 500px;">
  <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title">Detail Level</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
          <!-- Detail Level -->
          @if($level)
              <div class="form-group">
                  <label for="level_id">ID Level</label>
                  <input type="text" id="level_id" class="form-control" value="{{ $level->level_id }}" readonly>
              </div>
              <div class="form-group">
                  <label for="level_kode">Kode Level</label>
                  <input type="text" id="level_kode" class="form-control" value="{{ $level->level_kode }}" readonly>
              </div>
              <div class="form-group">
                  <label for="level_nama">Nama Level</label>
                  <input type="text" id="level_nama" class="form-control" value="{{ $level->level_nama }}" readonly>
              </div>
          @else
              <div class="alert alert-danger">
                  <strong>Data tidak ditemukan!</strong>
              </div>
          @endif
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
  </div>
</div>


<script>
function modalAction(url) {
    console.log(url); // Debug URL
    $.ajax({
        url: url,
        type: 'GET',  // Pastikan menggunakan GET
        success: function(response) {
            $('#modal-body').html(response);
            $('#modal').modal('show');
        },
        error: function(xhr, status, error) {
            alert('Terjadi kesalahan: ' + xhr.status + ' ' + error);
        }
    });
}

</script>