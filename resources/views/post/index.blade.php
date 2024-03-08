<x-app-layout>
  <div class="py-12">
    <div class="max-w-7xl mx-auto p-6 bg-white rounded-lg shadow-sm">
      @forelse ($posts as $post)
        <div class="mb-4">
          <a href="#">
            <h2 class="text-lg font-bold">{{ $post->title }}</h2>
          </a>
          <p>{!! $post->content !!}</p>
        </div>
      @empty
        <p>No posts</p>
      @endforelse
    </div>
  </div>
</x-app-layout>
