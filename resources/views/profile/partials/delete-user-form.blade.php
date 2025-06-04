<section class="bg-white  p-4 sm:p-6 lg:p-8  max-w-full space-y-4 sm:space-y-6">
    <header class="mb-4 sm:mb-6">
        <h2 class="text-lg sm:text-xl lg:text-2xl font-semibold text-gray-900 dark:text-gray-100">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-2 text-sm sm:text-base text-gray-600 dark:text-gray-400 leading-relaxed">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <!-- Delete Account Button -->
    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center justify-center px-4 py-2 sm:px-6 sm:py-3 text-sm sm:text-base bg-red-600 hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-1 sm:focus:ring-2 focus:ring-red-500 focus:ring-offset-1 sm:focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 text-white font-semibold rounded-md sm:rounded-lg shadow-sm border border-transparent"
    >
        {{ __('Delete Account') }}
    </button>

    <!-- Modal -->
    <div
        x-data="{ show: false }"
        x-on:open-modal.window="$event.detail == 'confirm-user-deletion' ? show = true : null"
        x-on:close.stop="show = false"
        x-on:keydown.escape.window="show = false"
        x-show="show"
        x-init="@if($errors->userDeletion->isNotEmpty()) show = true @endif"
        class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
        style="display: none;"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <!-- Modal Backdrop -->
        <div 
            x-show="show" 
            class="fixed inset-0 transform transition-all"
            x-on:click="show = false"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
        </div>

        <!-- Modal Content -->
        <div 
            x-show="show" 
            class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-md sm:mx-auto"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
            <form method="post" action="{{ route('profile.destroy') }}" class="p-4 sm:p-6">
                @csrf
                @method('delete')

                <h2 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-gray-100 mb-3 sm:mb-4">
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>

                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 leading-relaxed mb-4 sm:mb-6">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>

                <!-- Password Field -->
                <div class="mb-4 sm:mb-6">
                    <label for="password" class="sr-only">{{ __('Password') }}</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="w-full px-3 py-2 sm:px-4 sm:py-3 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-md sm:rounded-lg shadow-sm focus:ring-1 sm:focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-gray-100 dark:focus:ring-red-400 transition duration-200"
                        placeholder="{{ __('Password') }}"
                        x-ref="password"
                    />
                    @if ($errors->userDeletion->has('password'))
                        @foreach ($errors->userDeletion->get('password') as $error)
                            <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>

                <!-- Modal Actions -->
                <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 sm:gap-4">
                    <button 
                        type="button"
                        x-on:click="show = false"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 sm:px-6 sm:py-3 text-sm sm:text-base bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 focus:bg-gray-50 dark:focus:bg-gray-600 active:bg-gray-100 dark:active:bg-gray-500 focus:outline-none focus:ring-1 sm:focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 sm:focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 text-gray-700 dark:text-gray-300 font-medium rounded-md sm:rounded-lg shadow-sm"
                    >
                        {{ __('Cancel') }}
                    </button>

                    <button 
                        type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 sm:px-6 sm:py-3 text-sm sm:text-base bg-red-600 hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-1 sm:focus:ring-2 focus:ring-red-500 focus:ring-offset-1 sm:focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 text-white font-semibold rounded-md sm:rounded-lg shadow-sm border border-transparent"
                        x-on:click="$refs.password.focus()"
                    >
                        {{ __('Delete Account') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>