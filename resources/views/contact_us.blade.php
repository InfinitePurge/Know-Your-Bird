<script>
    document.getElementById('contact-form').addEventListener('submit', function(e) {
        const name = document.getElementById('name');
        const email = document.getElementById('email');
        const message = document.getElementById('message');
        const subject = document.getElementById('subject');
        const errorElement = document.getElementById('error');

        // Frontend validation
        if (name.value.length < 3 || !emailIsValid(email.value) || subject.value.length < 3 || message.value
            .length < 15) {
            e.preventDefault(); // Prevent form submission if validation fails
            errorElement.innerHTML = 'Please fill out the form correctly.';
        } else {
            errorElement.innerHTML = ''; // Clear any previous error messages
        }
    });

    // Validate email function
    function emailIsValid(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
</script>


<link href="{{ asset('manocss/contactus.css') }}" rel="stylesheet">

<div class="contact-container">
    <div class="left-col">
    </div>
    <div class="right-col">
        <div class="theme-switch-wrapper">
            <a href="/" class="logo">Home</a>
        </div>

        <h1>Contact us</h1>
        <p>Got a question or feedback? We're all ears. Drop us a line using the form below, and we'll get back to you
            ASAP.</p>

        <form id="contact-form" method="post">
            @csrf
            @if (auth()->check())
                <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                <input type="hidden" name="email" value="{{ Auth::user()->email }}">
            @else
                <label for="name">Name</label>
                <input type="text" name="name" placeholder="Your Name" value="{{ old('name') }}" required>
                <label for="email">Email Address</label>
                <input type="email" name="email" placeholder="Your Email Address" value="{{ old('email') }}"
                    required>
            @endif
            <label for="subject">Subject</label>
            <input type="text" name="subject" placeholder="Subject" value="{{ old('subject') }}" required>
            <label for="message">Message</label>
            <textarea rows="6" placeholder="Your Message" name="message" required>{{ old('message') }}</textarea>
            <button type="submit" name="submit">Send</button>
        </form>

        @if ($errors->any())
            <div id="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div id="success-msg">
            @if (session('success'))
                {{ session('success') }}
            @endif
        </div>
    </div>
</div>
