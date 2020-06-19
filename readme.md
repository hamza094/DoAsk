# DoAsk [![Build Status](https://travis-ci.org/hamza094/DoAsk.svg?branch=master)](https://travis-ci.org/hamza094/DoAsk)
This is an open-source forum that is built in Laravel and Vue.js designed with Sass similar to quora and stack overflow.

# Features
- Top trending answered and unanswered threads
- User activity feed and profile reputation
- AWS image upload
- Dynamic thread page
- Reply to spam detection
- Lock pined and subscribe thread
- Mail confirmation

# Installation

- You need Redis as your cache driver you need to install the Redis Server. You can either use homebrew on a Mac or compile from source (https://redis.io/topics/quickstart).

- reCAPTCHA is a Google tool to help prevent forum spam. You'll need to create a free account (don't worry, it's quick).
https://www.google.com/recaptcha/intro/
Choose reCAPTCHA V2, and specify your local (and eventually production) domain name.
Once submitted, you'll see two important keys that should be referenced in your .env file.
RECAPTCHA_KEY=PASTE_KEY_HERE
RECAPTCHA_SECRET=PASTE_SECRET_HERE

- Edit config/forum.php, and add any email address that should be marked as an administrator.
For live view visit site https://doask.herokuapp.com/threads
