<section class="bg-white  p-4 sm:p-6 lg:p-8  max-w-full">
    <header class="mb-4 sm:mb-6">
        <h2 class="text-lg sm:text-xl lg:text-2xl font-semibold text-gray-900 dark:text-gray-100">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-2 text-sm sm:text-base text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-4 sm:space-y-6">
        @csrf
        @method('put')

        <!-- Current Password Field -->
        <div class="w-full">
            <label for="update_password_current_password" class="block text-sm sm:text-base font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">
                {{ __('Current Password') }}
            </label>
            <input 
                id="update_password_current_password" 
                name="current_password" 
                type="password" 
                class="w-full px-3 py-2 sm:px-4 sm:py-3 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-md sm:rounded-lg shadow-sm focus:ring-1 sm:focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 dark:focus:ring-indigo-400 transition duration-200" 
                autocomplete="current-password" 
            />
            @error('current_password')
                <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
            @if ($errors->updatePassword->has('current_password'))
                @foreach ($errors->updatePassword->get('current_password') as $error)
                    <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
                @endforeach
            @endif
        </div>

        <!-- New Password Field -->
        <div class="w-full">
            <label for="update_password_password" class="block text-sm sm:text-base font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">
                {{ __('New Password') }}
            </label>
            <input 
                id="update_password_password" 
                name="password" 
                type="password" 
                class="w-full px-3 py-2 sm:px-4 sm:py-3 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-md sm:rounded-lg shadow-sm focus:ring-1 sm:focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 dark:focus:ring-indigo-400 transition duration-200" 
                autocomplete="new-password" 
            />
            @error('password')
                <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
            @if ($errors->updatePassword->has('password'))
                @foreach ($errors->updatePassword->get('password') as $error)
                    <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
                @endforeach
            @endif
        </div>

        <!-- Confirm Password Field -->
        <div class="w-full">
            <label for="update_password_password_confirmation" class="block text-sm sm:text-base font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">
                {{ __('Confirm Password') }}
            </label>
            <input 
                id="update_password_password_confirmation" 
                name="password_confirmation" 
                type="password" 
                class="w-full px-3 py-2 sm:px-4 sm:py-3 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-md sm:rounded-lg shadow-sm focus:ring-1 sm:focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 dark:focus:ring-indigo-400 transition duration-200" 
                autocomplete="new-password" 
            />
            @error('password_confirmation')
                <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
            @if ($errors->updatePassword->has('password_confirmation'))
                @foreach ($errors->updatePassword->get('password_confirmation') as $error)
                    <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
                @endforeach
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

            @if (session('status') === 'password-updated')
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