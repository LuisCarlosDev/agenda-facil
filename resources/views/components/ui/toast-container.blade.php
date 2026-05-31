@if(session('toast'))
    <x-ui.toast
        :type="session('toast.type')"
        :message="session('toast.message')"
        :redirect="session('toast.redirect')"
    />
@endif

@if($errors->any())
    <x-ui.toast
        type="error"
        :message="$errors->first()"
    />
@endif
