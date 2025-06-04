<section class="bg-white  p-4 sm:p-6 lg:p-8 max-w-full">
    <header class="mb-4 sm:mb-6">
        <h2 class="text-lg sm:text-xl lg:text-2xl font-semibold text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-2 text-sm sm:text-base text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-4 sm:space-y-6">
        @csrf
        @method('patch')

        <!-- Name Field -->
        <div class="w-full">
            <label for="name" class="block text-sm sm:text-base font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">
                {{ __('Name') }}
            </label>
            <input 
                id="name" 
                name="name" 
                type="text" 
                class="w-full px-3 py-2 sm:px-4 sm:py-3 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-md sm:rounded-lg shadow-sm focus:ring-1 sm:focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 dark:focus:ring-indigo-400 transition duration-200" 
                value="{{ old('name', $user->name) }}" 
                required 
                autofocus 
                autocomplete="name" 
            />
            @error('name')
                <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Field -->
        <div class="w-full">
            <label for="email" class="block text-sm sm:text-base font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">
                {{ __('Email') }}
            </label>
            <input 
                id="email" 
                name="email" 
                type="email" 
                class="w-full px-3 py-2 sm:px-4 sm:py-3 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-md sm:rounded-lg shadow-sm focus:ring-1 sm:focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 dark:focus:ring-indigo-400 transition duration-200" 
                value="{{ old('email', $user->email) }}" 
                required 
                autocomplete="username" 
            />
            @error('email')
                <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 sm:mt-3 p-3 sm:p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-md sm:rounded-lg">
                    <p class="text-xs sm:text-sm text-yellow-800 dark:text-yellow-200">
                        {{ __('Your email address is unverified.') }}

                        <button 
                            form="send-verification" 
                            class="ml-1 underline text-xs sm:text-sm text-yellow-700 dark:text-yellow-300 hover:text-yellow-900 dark:hover:text-yellow-100 rounded-md focus:outline-none focus:ring-1 sm:focus:ring-2 focus:ring-yellow-500 focus:ring-offset-1 sm:focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-200"
                        >
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-xs sm:text-sm font-medium text-green-700 dark:text-green-300">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4 pt-3 sm:pt-4">
            <button 
                type="submit"
                class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 sm:px-6 sm:py-3 text-sm sm:text-base bg-indigo-600 hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-1 sm:focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 sm:focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 text-white font-semibold rounded-md sm:rounded-lg shadow-sm"
            >
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-y-1"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 transform translate-y-0"
                    x-transition:leave-end="opacity-0 transform translate-y-1"
                    x-init="setTimeout(() => show = false, 3000)"
                    class="w-full sm:w-auto text-xs sm:text-sm font-medium text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 px-3 py-2 rounded-md border border-green-200 dark:border-green-800 text-center sm:text-left"
                >
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>