<script>
    const name = document.getElementById('name');
    const email = document.getElementById('email');
    const message = document.getElementById('message');
    const subject = document.getElementById('subject');
    const contactForm = document.getElementById('contact-form');
    const errorElement = document.getElementById('error');
    const successMsg = document.getElementById('success-msg');
    const submitBtn = document.getElementById('submit');

    const validate = (e) => {
        e.preventDefault();

        if (name.value.length < 3) {
            errorElement.innerHTML = 'Your name should be at least 3 characters long.';
            return false;
        }

        if (!(email.value.includes('.') && (email.value.includes('@')))) {
            errorElement.innerHTML = 'Please enter a valid email address.';
            return false;
        }

        if (!emailIsValid(email.value)) {
            errorElement.innerHTML = 'Please enter a valid email address.';
            return false;
        }

        if (subject.value.length < 3) {
            errorElement.innerHTML = 'Please write a longer subject message.';
            return false;
        }

        if (message.value.length < 15) {
            errorElement.innerHTML = 'Please write a longer message.';
            return false;
        }

        errorElement.innerHTML = '';
        successMsg.innerHTML = 'Thank you! I will get back to you as soon as possible.';

        e.preventDefault();
        setTimeout(function() {
            successMsg.innerHTML = '';
            document.getElementById('contact-form').reset();
        }, 6000);

        return true;

    }

    const emailIsValid = email => {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    if (validate) {
        // If validation passes, send the form data to the server using AJAX
        const formData = new FormData(contactForm);

        fetch('/contact_us', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Handle the response (e.g., display success message)
                successMsg.innerHTML = data.message;
                setTimeout(function() {
                    successMsg.innerHTML = '';
                    document.getElementById('contact-form').reset();
                }, 6000);
            })
            .catch(error => {
                // Handle the error (e.g., display error message)
                errorElement.innerHTML = 'An error occurred. Please try again.';
            });
    }

    submitBtn.addEventListener('click', validate);
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
                <input type="hidden" id="name" name="name" value="{{ Auth::user()->name }}">
                <input type="hidden" id="email" name="email" value="{{ Auth::user()->email }}">
            @else
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Your Name" required>
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Your Email Address" required>
            @endif
            <label for="email">Subject</label>
            <input type="subject" id="subject" name="subject" placeholder="Subject" required>
            <label for="message">Message</label>
            <textarea rows="6" placeholder="Your Message" id="message" name="message" required></textarea>
            <button type="submit" id="submit" name="submit">Send</button>
        </form>
        <div id="error"></div>
        <div id="success-msg"></div>
    </div>
</div>
