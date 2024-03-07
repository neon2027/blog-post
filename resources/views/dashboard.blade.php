<x-app-layout>
  {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <form class="p-6 text-gray-900" action="{{ route('blogs.store') }}" method="post">
          @csrf
          <div class="flex">
            <input type="text" name="content" id="content"
              class="w-full rounded-full py-1 transition-all duration-300 ease-in-out focus:pl-4"
              placeholder="What's on your mind?">
            <button
              class="ml-4 rounded-full bg-blue-500 px-4 py-2 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">Post</button>
          </div>
          @error('content')
            <div class="ml-4 mt-2 text-sm text-red-500">
              {{ $message }}
            </div>
          @enderror
        </form>
      </div>

      <div class="mt-6 space-y-4">
        @forelse ($blogs as $index => $blog)
          <div class="overflow-hidden bg-white shadow-sm hover:shadow-lg sm:rounded-lg">
            <div class="p-6">
              <div class="flex w-full items-center">
                <div class="flex-shrink-0">
                  <img class="h-10 w-10 rounded-full"
                    src="https://ui-avatars.com/api/?name={{ $blog->user->name }}&color=7F9CF5&background=EBF4FF"
                    alt="">
                </div>
                <div class="ml-4 flex w-full justify-between">
                  <div>
                    <div class="text-sm font-medium text-gray-900">
                      {{ $blog->user->name }}
                    </div>
                    <div class="text-sm text-gray-500">
                      {{ $blog->created_at->diffForHumans() }}
                    </div>
                  </div>
                  @if ($blog->user_id === auth()->id())
                    <div>
                      <button class="text-sm text-red-500"
                        onclick="event.preventDefault(); this.nextElementSibling.submit();">Delete</button>
                      <form action="{{ route('blogs.destroy', $blog->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                      </form>
                    </div>
                  @endif
                </div>

              </div>
              <div class="mt-4">
                <p class="text-lg">
                  {{ $blog->content }}
                </p>
              </div>

              <div class="mt-4 text-xs text-gray-500">
                @foreach ($blog->likes()->limit(3)->get() as $like)
                  @if ($like->user_id === auth()->id())
                    You
                  @else
                    {{ Str::substr($like->user->name, 0, strpos($like->user->name, ' ') ?: strlen($like->user->name)) }}
                  @endif

                  @if (!$loop->last)
                    ,
                  @endif
                @endforeach

                @if ($blog->likes->count() > 3)
                  and {{ $blog->likes->count() - 3 }} others
                @endif

                @if ($blog->likes->count() > 0)
                  liked this
                @else
                  Be the first to like this
                @endif
              </div>

            </div>
            <div class="flex">
              <button
                class="w-full border-t border-gray-200 py-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2">
                {{ $blog->comments->count() }}
                Comment</button>

              <button
                class="w-full border-t border-gray-200 py-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2"
                onclick="event.preventDefault(); this.nextElementSibling.submit();">
                {{ $blog->likes->count() }}
                @if ($blog->likes->contains('user_id', auth()->id()))
                  Unlike
                @else
                  Like
                @endif
              </button>
              <form action="{{ route('blogs.like', $blog->id) }}" method="post">
                @csrf
              </form>

            </div>
          </div>
        @empty <div class="p-6 text-gray-900">
            No blogs found
          </div>
        @endforelse
      </div>
    </div>
  </div>

</x-app-layout>
