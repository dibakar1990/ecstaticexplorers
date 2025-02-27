<footer class="page-footer">
    <p class="mb-0">Copyright © {{ date('Y') }}. All right reserved.</p>
</footer>

<div class="modal fade" id="deleteConfirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmLabel">Static backdrop</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="deleteModalBody">
                
            </div>
            <div class="modal-footer">
                <form id="deleteForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">{{ __('Delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ajaxModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="ajaxModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajaxModalLabel">Modal Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="dynamicAjaxModalBody">
                
            </div>
        </div>
    </div>
</div>