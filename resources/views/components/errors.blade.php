<div class="row mb-2">
    @if ($errors->any())
    <!--@error('feedback')-->
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first() }}</strong>
        <!-- <strong>{{ $message }}</strong> -->
    </span>
    <!-- @enderror -->
    @endif
</div>
