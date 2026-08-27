<nav class="border-b border-border">
    <div class="max-w-5xl mx-auto h-16 px-4 flex items-center justify-between">
        <a href="/">
            <span class="font-bold text-xl">Idea</span>
        </a>

        <div class="flex items-center gap-5">
            @guest
                <a href="/login">Log In</a>
                <a href="/register" class="btn">Register</a>
            @endguest

            @auth
                <form action="/logout" method="POST">
                    @csrf
                    <button class="btn btn-ghost">Log Out</button>
                </form>
            @endauth
        </div>
    </div>
</nav>
