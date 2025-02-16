@props(['class' => ''])
<div class="flex flex-col">
  <div class="{{ $class }} -my-2 overflow-x-auto smx:-mx-6 lgx:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            {{ $slot }}
          </div>
        </div>
    </div>
</div>
