<form class="row g-3" id="createForm" method="post" action="{{ route('admin.newsletter.update',['newsletter' => $item->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="col-md-12 required">
        <label for="subject" class="form-label">Subject</label>
        <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject">
        @error('subject')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="col-md-12 required">
        <label for="message" class="form-label">Message</label>
        <textarea class="form-control" id="message" name="message" rows="5" placeholder="Message"></textarea>
        @error('subject')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    
    <div class="col-md-12">
        <div class="d-md-flex d-grid align-items-center gap-3">
            <button type="submit" class="btn btn-primary px-4">Send</button>
        </div>
    </div>
</form>

<script src="{{ asset('admin/assets/plugins/validation/jquery.validate.min.js') }}"></script>
<script>
    $(function(){
        
        $('#createForm').validate({
            ignore: [],
            debug: false,
            rules: {
                subject: {
                    required: true,
                },
                message: {
                    required: true,
                }
            },
            messages: {
                subject: {
                    required: "This field is required",
                },
                message: {
                    required: "This field is required",
                }
            },
        });
    });