<section id="contact" class="border-t border-line">
    <div class="mx-auto grid max-w-6xl gap-12 px-5 py-20 sm:px-8 md:grid-cols-5 md:py-28">
        <div class="md:col-span-2">
            <p class="eyebrow">Contact</p>
            <h2 class="mt-3 font-display text-4xl leading-tight sm:text-5xl">Let's build something <em class="text-accent">useful</em>.</h2>
            <p class="mt-5 text-soft">
                Open to internships, junior roles and freelance projects. Send a message here or email
                <a class="link-underline text-ink" href="mailto:{{ config('portfolio.email') }}">{{ config('portfolio.email') }}</a>.
            </p>
        </div>

        <div class="md:col-span-3">
            @if (session('contact_sent'))
                <div class="rounded-2xl border border-accent/40 bg-raised p-8" role="status">
                    <p class="font-display text-3xl">Thanks — message received.</p>
                    <p class="mt-2 text-soft">I'll get back to you soon.</p>
                </div>
            @else
                <form method="POST" action="{{ route('contact.store') }}" class="grid gap-4 sm:grid-cols-2">
                    @csrf

                    {{-- Honeypot: hidden from people, tempting for bots --}}
                    <div class="hidden" aria-hidden="true">
                        <label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                    </div>

                    {{-- aria-invalid + aria-describedby let screen readers announce each error with its field --}}
                    <div>
                        <label for="name" class="mb-1.5 block text-sm font-medium">Name</label>
                        <input id="name" name="name" value="{{ old('name') }}" required maxlength="100" class="field" autocomplete="name"
                               @error('name') aria-invalid="true" aria-describedby="name-error" @enderror>
                        @error('name') <p id="name-error" class="field-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-medium">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required maxlength="150" class="field" autocomplete="email"
                               @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
                        @error('email') <p id="email-error" class="field-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label for="subject" class="mb-1.5 block text-sm font-medium">Subject <span class="font-normal text-soft">(optional)</span></label>
                        <input id="subject" name="subject" value="{{ old('subject') }}" maxlength="150" class="field"
                               @error('subject') aria-invalid="true" aria-describedby="subject-error" @enderror>
                        @error('subject') <p id="subject-error" class="field-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label for="message" class="mb-1.5 block text-sm font-medium">Message</label>
                        <textarea id="message" name="message" rows="6" required minlength="10" maxlength="5000" class="field resize-y"
                                  @error('message') aria-invalid="true" aria-describedby="message-error" @enderror>{{ old('message') }}</textarea>
                        @error('message') <p id="message-error" class="field-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <button type="submit" class="btn-primary">Send message <span aria-hidden="true">&rarr;</span></button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</section>
