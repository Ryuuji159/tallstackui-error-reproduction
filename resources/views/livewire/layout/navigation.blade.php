<?php

use Livewire\Volt\Component;

new class extends Component {
    public function logout(): void
    {
        auth()->guard('web')->logout();

        session()->invalidate();
        session()->regenerateToken();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-white">
    <!-- Primary Navigation Menu -->
    <div class="max-w-screen-2xl mx-auto px-4 lg:px-6 lg:px-8">
        <div class="flex justify-between h-24">
            <a href="#" wire:navigate>
                <x-application-logo class="block object-contain h-[90px]"/>
            </a>

            <div class="hidden space-x-6 lg:flex">
                    <x-nav-link href="{{route('dashboard')}}" wire:navigate>
                        {{ __('Dashboard') }}
                    </x-nav-link>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden lg:flex lg:items-end pb-4 lg:ml-6">
                <x-dropdown text="{{ auth()->user()->name }}" position="bottom-end">
                    <x-dropdown.items text="{{ __('Profile') }}" wire:navigate href="{{route('profile')}}"/>
                    <x-dropdown.items text="{{ __('Salir') }}" wire:click="logout"/>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center lg:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none"
                         viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                              class="inline-flex" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                              class="hidden" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @can('list-projects')
                <x-responsive-nav-link href="{{route('dashboard')}}" wire:navigate>
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endcan
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div
                    class="font-medium text-base text-gray-800 dark:text-gray-200"
                    x-data="{ name: '{{ auth()->user()->name }}' }"
                    x-text="name"
                    x-on:profile-updated.window="name = $event.detail.name"></div>
                <div
                    class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-left">
                    <x-responsive-nav-link>
                        {{ __('Salir') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
