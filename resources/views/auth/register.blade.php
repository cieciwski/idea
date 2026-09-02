<x-layout title="Register">
    <x-forms.form title="Register an account" description="Start tracking your ideas today.">
        <form action="/register" method="POST" class="space-y-4">
            @csrf

            <x-forms.field label="Name" name="name" />
            <x-forms.field label="Email" name="email" type="email" />
            <x-forms.field label="Password" name="password" type="password" />

            <button type="submit" class="btn m-2 h-10 w-full" data-test="register-button">Create Account</button>
        </form>
    </x-forms.form>
</x-layout>
