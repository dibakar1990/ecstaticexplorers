@if ($message = Session::get('success'))

<script>

    Lobibox.notify('success', {
        pauseDelayOnHover: true,
        size: 'mini',
        rounded: true,
        sound: false,
        icon: 'bx bx-check-circle',
        delayIndicator: false,
        continueDelayOnInactiveTab: false,
        position: 'top right',
        msg: '{{$message}}.'
    });
</script>
@endif

@if ($message = Session::get('error'))
<script>
    Lobibox.notify('error', {
		pauseDelayOnHover: true,
		size: 'mini',
        sound: false,
		rounded: true,
		delayIndicator: false,
		icon: 'bx bx-x-circle',
		continueDelayOnInactiveTab: false,
		position: 'top right',
		msg: '{{$message}}.'
	});
</script>
@endif

@if ($message = Session::get('warning'))
<script>
    Lobibox.notify('warning', {
		pauseDelayOnHover: true,
		size: 'mini',
        sound: false,
		rounded: true,
		delayIndicator: false,
		icon: 'bx bx-error',
		continueDelayOnInactiveTab: false,
		position: 'top right',
		msg: '{{$message}}.'
	});
</script>
@endif