<?php

/*
|--------------------------------------------------------------------------
| Portfolio settings
|--------------------------------------------------------------------------
| Your personal details shown across the public site. Set them in .env so
| nothing personal is hard-coded in the repo.
*/

return [
    'name' => env('PORTFOLIO_NAME', 'Your Name'),
    'role' => env('PORTFOLIO_ROLE', 'Software Developer'),
    'tagline' => env('PORTFOLIO_TAGLINE', 'I build business systems end to end — from APIs and databases to the apps people use every day.'),
    'location' => env('PORTFOLIO_LOCATION', 'Philippines'),
    'about' => env('PORTFOLIO_ABOUT', 'I enjoy turning messy, real-world processes into software that is simple to use. Most of my work is in C# / ASP.NET Core and PHP / Laravel, with a soft spot for clean database design.'),

    'email' => env('PORTFOLIO_EMAIL', 'you@example.com'),
    'github' => env('PORTFOLIO_GITHUB', 'https://github.com/your-username'),
    'linkedin' => env('PORTFOLIO_LINKEDIN'),
    'resume_url' => env('PORTFOLIO_RESUME_URL'),

    // Only this account can sign in to /admin in production.
    'admin_email' => env('ADMIN_EMAIL', 'admin@example.com'),
    'admin_password' => env('ADMIN_PASSWORD', 'password'),

    // Where contact-form notifications are sent (uses your MAIL_* settings).
    'notify_email' => env('PORTFOLIO_NOTIFY_EMAIL', env('PORTFOLIO_EMAIL')),
];
