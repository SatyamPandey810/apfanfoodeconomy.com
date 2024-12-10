<form method="POST" action="{{ route('admin.registers') }}">
    @csrf
    <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required>
    <input type="text" name="username" placeholder="username" value="{{ old('username') }}" required>
    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
    <button type="submit">Register</button>
</form>
