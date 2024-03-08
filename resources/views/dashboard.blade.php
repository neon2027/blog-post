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
                class="w-full border-t border-gray-200 py-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2"
                onclick="event.preventDefault(); 
                window.location.href='{{ route('dashboard', ['blog' => $blog->id]) }}';">
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


    @if (request()->blog)
      <div
        class="absolute bg-white top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 max-w-4xl w-full h-[calc(100vh-100px)] rounded-lg shadow z-50 overflow-y-auto">
        <div class="relative h-full">
          <div class="flex justify-between items-center p-4 px-6 sticky top-0 bg-white border-b shadow-sm">
            <h1 class="text-2xl font-semibold text-gray-900">Comments</h1>
            <button class="text-gray-500"
              onclick="event.preventDefault(); window.location.href='{{ route('dashboard') }}';">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>
          <div class="p-6">
            <div class="flex w-full items-center">
              <div class="flex-shrink-0">
                <img class="h-10 w-10 rounded-full"
                  src="https://ui-avatars.com/api/?name=Exequiel Lustan&color=7F9CF5&background=EBF4FF" alt="">
              </div>
              <div class="ml-4 flex w-full justify-between">
                <div>
                  <div class="text-sm font-medium text-gray-900">
                    {{ $selectedBlog->user->name }}
                  </div>
                  <div class="text-sm text-gray-500">
                    {{ $selectedBlog->created_at->diffForHumans() }}
                  </div>
                </div>
                @if ($blog->user_id === auth()->id())
                  <div>
                    <button class="text-sm text-red-500"
                      onclick="event.preventDefault(); this.nextElementSibling.submit();">Delete</button>
                    <form action="{{ route('blogs.destroy', $selectedBlog->id) }}" method="post">
                      @csrf
                      @method('DELETE')
                    </form>
                  </div>
                @endif
              </div>
            </div>
            <div class="mt-4">
              <p class="text-lg">
                {{ $selectedBlog->content }}
              </p>
            </div>

            <div class="mt-4 text-xs text-gray-500">
              @foreach ($selectedBlog->likes()->limit(3)->get() as $like)
                @if ($like->user_id === auth()->id())
                  You
                @else
                  {{ Str::substr($like->user->name, 0, strpos($like->user->name, ' ') ?: strlen($like->user->name)) }}
                @endif

                @if (!$loop->last)
                  ,
                @endif
              @endforeach

              @if ($selectedBlog->likes->count() > 3)
                and {{ $selectedBlog->likes->count() - 3 }} others
              @endif

              @if ($selectedBlog->likes->count() > 0)
                liked this
              @else
                Be the first to like this
              @endif
            </div>
            <div class="flex mt-4">
              <button
                class="w-full border-t border-gray-200 py-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2"
                onclick="event.preventDefault(); 
                window.location.href='{{ route('dashboard', ['blog' => $selectedBlog->id]) }}';">
                {{ $selectedBlog->comments->count() }}
                Comment</button>

              <button
                class="w-full border-t border-gray-200 py-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2"
                onclick="event.preventDefault(); this.nextElementSibling.submit();">
                {{ $selectedBlog->likes->count() }}
                @if ($selectedBlog->likes->contains('user_id', auth()->id()))
                  Unlike
                @else
                  Like
                @endif
              </button>
              <form action="{{ route('blogs.like', $selectedBlog->id) }}" method="post">
                @csrf
              </form>

            </div>

            <div>
              <ul>
                @forelse ($selectedBlog->comments()->latest()->get() as $comment)
                  <li class="mt-4">
                    <div class="flex w-full items-center">
                      <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full"
                          src="https://ui-avatars.com/api/?name=Exequiel Lustan&color=7F9CF5&background=EBF4FF"
                          alt="">
                      </div>
                      <div class="ml-4 flex w-full justify-between">
                        <div>
                          <div class="text-sm font-medium text-gray-900">
                            {{ $comment->user->name }}
                          </div>
                          <div class="text-sm text-gray-500">
                            {{ $comment->created_at->diffForHumans() }}
                          </div>
                        </div>
                        @if ($comment->user_id === auth()->id())
                          <div>
                            <button class="text-sm text-red-500"
                              onclick="event.preventDefault(); this.nextElementSibling.submit();">Delete</button>
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="post">
                              @csrf
                              @method('DELETE')
                            </form>
                          </div>
                        @endif
                      </div>
                    </div>
                    <div class="mt-4">
                      <p class="text-lg">
                        {{ $comment->comment }}
                      </p>
                    </div>
                  </li>
                @empty
                  <div class="mt-4 text-gray-500 text-center">
                    No comments found
                  </div>
                @endforelse
              </ul>

            </div>

          </div>
          <div class="sticky bg-white  w-full bottom-0 p-6 shadow-sm border-t">
            <form class="flex gap-4" action="{{ route('comments.store', $selectedBlog->id) }}" method="post">
              @csrf
              <input type="text" name="comment" id="comment"
                class="w-full rounded-full py-1 transition-all duration-300 ease-in-out focus:pl-4 border-gray-500"
                placeholder="Write a comment...">
              <button
                class=" rounded-full bg-blue-500 px-4 py-2 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">Comment</button>
            </form>
          </div>
        </div>
      </div>
      <div class="fixed h-full w-full bg-black top-0 bg-opacity-50"></div>
    @endif
  </div>

</x-app-layout>
