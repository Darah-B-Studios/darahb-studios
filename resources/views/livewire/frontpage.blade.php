<div x-data="{showNavigation: false}">
    <nav class="flex justify-between text-gray-200 py-2 text-sm px-3 bg-gray-900">
        <div class="flex items-center space-x-4">
            {{-- burger --}}
            <span class="sm:hidden p-1 hover:bg-gray-800 hover:cursor-pointer hover:rounded"
                @click="showNavigation = !showNavigation">🍔
                Menu</span>
            {{-- logo --}}
            <a href="#" id="logo" class="inline-flex items-center space-x-2 hover:opacity-95">
                <img src="//logo.clearbit.com/embarktrucks.com" alt="logo" class="h-8 rounded-full">
                <span class="uppercase font-semibold">Company logo</span>
            </a>
            {{-- left navigation bar --}}
            <ul class="hidden sm:flex space-x-3 items-center">
                @foreach ($menus as $menu)
                    <li class="px-3 hover:bg-gray-800 hover:rounded py-2">
                        <a href="{{ url($menu->slug) }}">{{ $menu->label }}</a>
                    </li>
                @endforeach

                {{-- <li class="px-3 hover:bg-gray-800 hover:rounded py-2">
                    <a href="#">service</a>
                </li>
                <li class="px-3 hover:bg-gray-800 hover:rounded py-2">
                    <a href="#">about us</a>
                </li>
                <li class="px-3 hover:bg-gray-800 hover:rounded py-2">
                    <a href="#">contact</a>
                </li> --}}
            </ul>
        </div>


        {{-- right navigation links --}}
        <ul>
            <li
                class="px-3 hover:opacity-95 bg-gradient-to-br from-red-800 to-red-700 rounded-lg lg:px-6 cursor-pointer py-2">
                <a href="#">login</a>
            </li>
        </ul>
    </nav>
    {{-- mobile navigation bar --}}
    <ul class="bg-gray-900 text-gray-300 items-center divide-y divide-gray-700" x-show="showNavigation">
        <li class="px-3 hover:bg-gray-800 hover:rounded py-2" @click="showNavigation = false;">
            <a href="#">home</a>
        </li>
        <li class="px-3 hover:bg-gray-800 hover:rounded py-2" @click="showNavigation = false;">
            <a href="#">service</a>
        </li>
        <li class="px-3 hover:bg-gray-800 hover:rounded py-2" @click="showNavigation = false;">
            <a href="#">about us</a>
        </li>
        <li class="px-3 hover:bg-gray-800 hover:rounded py-2" @click="showNavigation = false;">
            <a href="#">contact</a>
        </li>
    </ul>
    <div>
        <aside>

        </aside>
    </div>
    <main class="mx-auto px-6 sm:px-10 lg:w-10/12 lg:px-0 min-h-screen py-4 sm:py-8 w-full">
        <div
            class="h-40 rounded-lg shadow-xl bg-gradient-to-br from-indigo-700 to-blue-800 text-gray-200 flex flex-col items-center justify-center text-center">
            <h1 class="text-2xl uppercase leading-3">{{ $title }}</h1>
            <p class="text-gray-300 mt-2 text-sm">We're ready at all times to be at your service</p>
        </div>
        <article>
            {!! $content !!}
        </article>

        <div class="mt-8">
            <div class="sm:flex justify-between mb-8">
                <div class="mb-4 sm:mb-0">
                    <h3 class="text-2xl font-bold">Features of our website</h3>
                    <p class="text-gray-500">Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus ut
                        deserunt id, aliquid
                        itaque cum.</p>
                </div>
                <div>
                    <button class="rounded-lg bg-blue-600 text-blue-100 text-center px-6 py-2">left</button>
                </div>
            </div>
            <div class="columns-1 md:columns-2 lg:columns-4 gap-8">
                @for ($count = 0; $count < 4; $count++)
                    <div class="bg-blue-100 rounded-lg hover:shadow-lg p-4 mb-4 sm:mb-0">
                        <h3 class="text-gray-800 font-semibold mb-1 text-lg">Feature title goes here</h3>
                        <p class="text-sm text-gray-500">Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                            Quaerat et, itaque id mollitia ipsa accusantium veniam optio repellat ea alias.</p>

                        {{-- author --}}
                        <div class="mt-2 flex items-center space-x-2 bg-gray-100 rounded-lg p-2">
                            <div class="h-8 w-8 rounded-full bg-gray-400"></div>
                            <div>
                                <h3 class="text-gray-700">Bless Darah</h3>
                                <p class="text-xs text-gray-500">UI/UX Designer | Fullstack Developer</p>
                            </div>
                        </div>
                        <button
                            class="hidden rounded bg-gradient-to-br from-gray-400 to-gray-300 py-1 px-3 mt-4 text-sm">learn
                            more</button>
                    </div>
                @endfor

            </div>
        </div>
    </main>
</div>
