@include('modals.login')
@include('modals.register')
@includeWhen(auth()->check() && auth()->user()->email_verified_at!==null, 'modals.create-thread')
@includeWhen(auth()->check() && auth()->user()->email_verified_at!==null, 'modals.profile')

