<x-layout title="Log In">
    <x-forms.form title="Log in" description="Glad to have you back.">
        <form action="/login" method="POST" class="space-y-4">
            @csrf

            <x-forms.field label="Email" name="email" type="email" />
            <x-forms.field label="Password" name="password" type="password" />

            <button type="submit" class="btn m-2 h-10 w-full" data-test="login-button">Log In</button>
        </form>
    </x-forms.form>
</x-layout>
